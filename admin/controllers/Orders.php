<?php

/*
 * Copyright (C) 2018 Easy CMS Framework Ahmed Elmahdy
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License
 * @license    https://opensource.org/licenses/GPL-3.0
 *
 * @package    Easy CMS MVC framework
 * @author     Ahmed Elmahdy
 * @link       https://ahmedx.com
 *
 * For more information about the author , see <http://www.ahmedx.com/>.
 */

class Orders extends ControllerAdmin
{

    private $orderModel;

    public function __construct()
    {
        $this->orderModel = $this->model('Order');
    }

    /**
     * loading index view with latest orders
     */
    public function index($current = '', $perpage = 50)
    {
        // get orders
        $cond = 'WHERE ord.status <> 2 AND donors.donor_id = ord.donor_id AND ord.payment_method_id = payment_methods.payment_id ';
        $bind = [];
        //check user action if the form has submitted
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // sanitize POST array
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            //search handling
            if (isset($_POST['search']['submit'])) {
                unset($_SESSION['search']);
                // date search
                if (!empty($_POST['search']['date_from'])) {
                    $cond .= ' AND ord.create_date >= :date_from ';
                    $bind[':date_from'] = strtotime($_POST['search']['date_from']);
                }
                if (!empty($_POST['search']['date_to'])) {
                    $cond .= ' AND ord.create_date <= :date_to ';
                    $bind[':date_to'] = strtotime($_POST['search']['date_to']) + 86400;
                }
                // total search
                if (!empty($_POST['search']['total_from'])) {
                    $cond .= ' AND ord.total >= :total_from ';
                    $bind[':total_from'] = $_POST['search']['total_from'];
                }
                if (!empty($_POST['search']['total_to'])) {
                    $cond .= ' AND ord.total <= :total_to ';
                    $bind[':total_to'] = $_POST['search']['total_to'];
                }
                // order_identifier search
                if (!empty($_POST['search']['order_identifier'])) {
                    $cond .= ' AND ord.order_identifier LIKE  :order_identifier ';
                    $bind[':order_identifier'] = '%' . $_POST['search']['order_identifier'] . '%';
                }
                // mobile search
                if (!empty($_POST['search']['mobile'])) {
                    $cond .= ' AND donors.mobile LIKE  :mobile ';
                    $bind[':mobile'] = '%' . $_POST['search']['mobile'] . '%';
                }
                // donor_name search
                if (!empty($_POST['search']['donor_name'])) {
                    $cond .= ' AND ord.donor_name LIKE  :donor_name ';
                    $bind[':donor_name'] = '%' . $_POST['search']['donor_name'] . '%';
                }
                // full_name search
                if (!empty($_POST['search']['full_name'])) {
                    $cond .= ' AND donors.full_name LIKE  :full_name ';
                    $bind[':full_name'] = '%' . $_POST['search']['full_name'] . '%';
                }
                // status search
                if (!empty($_POST['search']['status'])) {
                    if ($_POST['search']['status'] == 5) $_POST['search']['status'] = 0;
                    $cond .= ' AND ord.status =  :status ';
                    $bind[':status'] =  $_POST['search']['status'];
                }
                // app search
                if (!empty($_POST['search']['app'])) {
                    $cond .= ' AND ord.app =  :app ';
                    $bind[':app'] =  $_POST['search']['app'];
                }
                // custom status search
                if (!empty($_POST['search']['status_id'])) {
                    $status_ids = array_filter($_POST['search']['status_id']);
                    $cond .= ' AND ord.status_id  in (' . strIncRepeat(':status_id', count($status_ids)) . ')';
                    foreach ($status_ids as $key => $status) {
                        if (!empty($status)) {
                            $bind[':status_id' . $key] = $status;
                        }
                    }
                }
                // Stores search
                if (!empty($_POST['search']['store_id'])) {
                    $stores = array_filter($_POST['search']['store_id']);
                    $cond .= ' AND ord.store_id  in (' . strIncRepeat(':store_id', count($stores)) . ')';
                    foreach ($stores as $key => $store) {
                        if (!empty($store)) {
                            $bind[':store_id' . $key] = $store;
                        }
                    }
                }
                // payment_method search
                if (!empty($_POST['search']['payment_method'])) {
                    $payment_methods = array_filter($_POST['search']['payment_method']);
                    $cond .= ' AND ord.payment_method_id  in ('  . strIncRepeat(':payment_method', count($payment_methods)) . ')';
                    foreach ($payment_methods as $key => $payment_method) {
                        if (!empty($payment_method)) {
                            $bind[':payment_method' . $key] = $payment_method;
                        }
                    }
                }
                // projects search 
                if (!empty($_POST['search']['projects'])) {
                    $projects = array_filter($_POST['search']['projects']);
                    $cond .= ' AND ord.projects_id REGEXP :pjs'; //search in multible values (like x or like y or etc)
                    $bind[':pjs'] = "(" . implode(")|(", $projects) . ")";
                    $_SESSION['search']['pjs'] = $projects; //store projects as array to save search data
                }
                // banktransferproof search 
                if (!empty($_POST['search']['banktransferproof'])) {
                    if ($_POST['search']['banktransferproof'] == 1) $cond .= ' AND ord.banktransferproof IS NOT NULL ';
                    if ($_POST['search']['banktransferproof'] == 2) $cond .= ' AND ord.banktransferproof IS NULL ';
                }
                // as gift search 
                if (!empty($_POST['search']['gift'])) {
                    if ($_POST['search']['gift'] == 1) $cond .= ' AND ord.gift =1 ';
                    if ($_POST['search']['gift'] == 2) $cond .= ' AND ord.gift =0 ';
                }
                // storing search data into session
                $_SESSION['search']['cond'] = $cond;
                $_SESSION['search']['bind'] = $bind;
                //store status and payment method for saving search attribute 
                if (isset($_POST['search']['payment_method'])) $_SESSION['search']['payment_method'] = $_POST['search']['payment_method'];
                if (isset($_POST['search']['status_id'])) $_SESSION['search']['status_id'] = $_POST['search']['status_id'];
                if (isset($_POST['search']['store_id'])) $_SESSION['search']['store_id'] = $_POST['search']['store_id'];
            } elseif (isset($_POST['search']['clearSearch'])) {
                unset($_SESSION['search']);
                $cond .= ' AND ord.store_id IS NULL ';
            }
            //handling Delete
            if (isset($_POST['delete'])) {
                if (isset($_POST['record'])) {
                    if ($row_num = $this->orderModel->deleteById($_POST['record'], 'order_id')) {
                        // update status if order is badal 
                        $this->orderModel->updateOfferByBadal($_POST['record'], 1);
                        flash('order_msg', 'تم حذف ' . $row_num . ' بنجاح');
                    } else {
                        flash('order_msg', 'لم يتم الحذف', 'alert alert-danger');
                    }
                }
                redirect('orders');
            }
            //handling Publish
            if (isset($_POST['publish'])) {
                if (isset($_POST['record'])) {
                    if ($row_num = $this->orderModel->publishById($_POST['record'], 'order_id')) {
                        //update donations publishing status after updating the order
                        $this->orderModel->publishDonations($_POST['record'], 'order_id');

                        // update status if order is badal 
                        $this->orderModel->updatebadal($_POST['record'], 1);
                        
                        // send sms with gift card
                        $this->orderModel->giftById($_POST['record'], 'order_id');
                        //send confirmation to user 
                        $this->orderModel->sendConfirmation($_POST['record']);
                       
                        // send message to badal 
                        $orders = $this->orderModel->getBadalOrders($_POST['record']); 
                        if($orders){
                            $this->sendNotficationBadal($orders);
                        }

                        redirect('orders');
                    }
                    flash('order_msg', 'تم تأكيد  ' . $row_num . ' بنجاح');
                } else {
                    flash('order_msg', 'هناك خطأ ما يرجي المحاولة لاحقا', 'alert alert-danger');
                }
            }
            //handling Unpublish
            if (isset($_POST['unpublish'])) {
                if (isset($_POST['record'])) {
                    if ($row_num = $this->orderModel->unpublishById($_POST['record'], 'order_id')) {
                        //update donations publishing status after updating the order
                        $this->orderModel->unpublishDonations($_POST['record'], 'order_id');

                        // update status if order is badal 
                        $this->orderModel->updatebadal($_POST['record'], 0);

                        flash('order_msg', 'تم الغاء تأكيد  ' . $row_num . ' بنجاح');
                    } else {
                        flash('order_msg', 'هناك خطأ ما يرجي المحاولة لاحقا', 'alert alert-danger');
                    }
                }
                redirect('orders');
            }
            //handling waiting
            if (isset($_POST['waiting'])) {
                if (isset($_POST['record'])) {
                    if ($row_num = $this->orderModel->waitingById($_POST['record'], 'order_id')) {
                         // update status if order is badal 
                         $this->orderModel->updatebadal($_POST['record'], 3);
                        flash('order_msg', 'تم وضع في الانتظار  ' . $row_num . ' بنجاح');
                    } else {
                        flash('order_msg', 'هناك خطأ ما يرجي المحاولة لاحقا', 'alert alert-danger');
                    }
                }
                redirect('orders');
            }
            //handling canceled
            if (isset($_POST['canceled'])) {

                if (isset($_POST['record'])) {
                     // update status if order is badal 
                     $this->orderModel->updatebadal($_POST['record'], 4);
                    //  if order count by offer, return offer again 
                    $this->orderModel->updateOfferByBadal($_POST['record'], 1);

                    if ($row_num = $this->orderModel->canceledById($_POST['record'], 'order_id')) {
                        flash('order_msg', 'تم الغاء   ' . $row_num . ' بنجاح');
                    } else {
                        flash('order_msg', 'هناك خطأ ما يرجي المحاولة لاحقا', 'alert alert-danger');
                    }
                }
                redirect('orders');
            }
            //handling sending gift card
            if (isset($_POST['gift'])) {

                if (isset($_POST['record'])) {
                    if ($row_num = $this->orderModel->giftById($_POST['record'])) {
                        flash('order_msg', 'تم ارسال كارت الاهداء الي    ' . $row_num . ' بنجاح');
                    } else {
                        flash('order_msg', 'هناك خطأ ما يرجي المحاولة لاحقا', 'alert alert-danger');
                    }
                }
                redirect('orders');
            }

            //handling sending request for bank transfear proof
            if (isset($_POST['proof'])) {

                if (isset($_POST['record'])) {
                    if ($row_num = $this->orderModel->requestProof($_POST['record'])) {
                        flash('order_msg', 'تم ارسال طلب رفع اثبات التحويل البنكي الي    ' . $row_num . ' بنجاح');
                    } else {
                        flash('order_msg', 'هناك خطأ ما يرجي المحاولة لاحقا', 'alert alert-danger');
                    }
                }
                redirect('orders');
            }
            //handling export
            if (isset($_POST['export'])) {
                if (isset($_POST['record'])) {
                    return $this->orderModel->exportOrders($_POST['record']);
                } else {
                    flash('order_msg', 'هناك خطأ ما يرجي المحاولة لاحقا', 'alert alert-danger');
                    redirect('orders');
                }
            }
            //handling export
            if (isset($_POST['exportAll']) && isset($_SESSION['search'])) {
                $total =  $this->orderModel->allOrdersCount(", donors, payment_methods " . $_SESSION['search']['cond'], $_SESSION['search']['bind']);
                if ($total->count > 20000) {
                    flash('order_msg', 'عدد النتائج اكبر من اللازم اقصي عدد يمكن استخراجه 20000', 'alert alert-danger');
                    redirect('orders');
                }
                return $this->orderModel->exportAllOrders();
            } elseif (isset($_POST['exportAll'])) {
                flash('order_msg', 'يجب ان تقوم بالبحث اولا لكي تتمكن من استخراج النتائج', 'alert alert-danger');
                redirect('orders');
            }

            //handling send
            if (isset($_POST['send'])) {
                if (isset($_POST['record'])) {
                    $data = [
                        'header' => '',
                        'title' => 'المراسلات',
                        'type' => $_POST['send'],
                        'members' => $this->orderModel->getUsersData($_POST['record']),
                        'footer' => '',
                    ];
                    return $this->view('messagings/index', $data);
                } else {
                    flash('order_msg', 'لم تقم بأختيار اي طلب', 'alert alert-danger');
                }
            }
            //handling status
            if (isset($_POST['status_id'])) {
                if (isset($_POST['record'])) {
                    if ($row_num = $this->orderModel->setOrderStatuses($_POST['record'], $_POST['status_id'])) {
                        flash('order_msg', 'تم اضافة ' . $row_num . ' بنجاح');
                    } else {
                        flash('order_msg', 'هناك خطأ ما يرجي المحاولة لاحقا', 'alert alert-danger');
                    }
                }
                redirect('orders');
            }
            //clear status
            if (isset($_POST['clear'])) {
                if (isset($_POST['record'])) {
                    if ($row_num = $this->orderModel->clearAllStatusesByOrdersId($_POST['record'])) {
                        flash('order_msg', 'تم الغاء   ' . $row_num . ' بنجاح');
                    } else {
                        flash('order_msg', 'هناك خطأ ما يرجي المحاولة لاحقا', 'alert alert-danger');
                    }
                }
                redirect('orders');
            }
        } else {
            $cond .= ' AND ord.store_id IS NULL ';

            if (isset($_SESSION['search']['bind'])) {
                $cond = $_SESSION['search']['cond'];
                $bind = $_SESSION['search']['bind'];
            }
        }
        // get all records count after search and filtration
        if (!empty($_POST['search']['deceased_id'])) {
            if($_POST['search']['deceased_id'] == 1){ $cond .= ' AND ord.deceased_id IS NOT NULL ';}
            if($_POST['search']['deceased_id'] == 2){ $cond .= ' AND ord.deceased_id IS NULL';}
            $_SESSION['search']['deceased_id'] = $_POST['search']['deceased_id'];
        }
        $recordsCount = $this->orderModel->allOrdersCount("use INDEX (create_date), donors, payment_methods " . $cond, $bind);
        // make sure its integer value and its usable
        $current = (int) $current;
        $perpage = (int) $perpage;

        ($perpage == 0) ? $perpage = 20 : null;
        if ($current <= 0 || $current > ceil($recordsCount->count / $perpage)) {
            $current = 1;
            $limit = 'LIMIT 0 , :perpage ';
            $bindLimit[':perpage'] = $perpage;
        } else {
            $limit = 'LIMIT  ' . (($current - 1) * $perpage) . ', :perpage';
            $bindLimit[':perpage'] = $perpage;
        }
        //get all records for current order
        $orders = $this->orderModel->getOrders($cond, $bind, $limit, $bindLimit);
        $data = [
            'current' => $current,
            'perpage' => $perpage,
            'header' => '',
            'title' => 'الطلبات',
            'statuses' => $this->orderModel->statusesList(' WHERE status = 1'),
            'stores' => $this->orderModel->stores(),
            'paymentMethodsList' => $this->orderModel->paymentMethodsList(' WHERE status <> 2 '),
            'projects' => $this->orderModel->projectsList(' WHERE status <> 2'),
            'orders' => $orders,
            'recordsCount' => $recordsCount->count,
            'footer' => '',
        ];
        $this->view('orders/index', $data);
    }

    /**
     * update order
     * @param integer $id
     */
    public function edit($id)
    {
        $id = (int) $id;
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // sanitize POST array
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            // featch order
            if (!$order = $this->orderModel->getOrderById($id)) {
                flash('order_msg', 'هناك خطأ ما هذه الصفحة غير موجوده او ربما اتبعت رابط خاطيء ', 'alert alert-danger');
                redirect('orders');
            }
            $data = [
                'order' => $order,
                'donations' => $this->orderModel->getDonationsByOrderId($id),
                'banktransferproof' => $order->banktransferproof,
                'order_id' => $id,
                'page_title' => ' الطلبات',
                'order_identifier' => trim($_POST['order_identifier']),
                'total' => $_POST['total'],
                'quantity' => $_POST['quantity'],
                'status_id' => $_POST['status_id'],
                'payment_method_id' => trim($_POST['payment_method_id']),
                'paymentMethodsList' => $this->orderModel->paymentMethodsList(' WHERE status <> 2 '),
                'statusesList' => $this->orderModel->statusesList(),
                'statuses' => '',
                'status' => '',
                'payment_method_id_error' => '',
                'projects_error' => '',
                'banktransferproof_error' => '',
                'status_error' => '',
            ];
            isset($_POST['statuses']) ? $data['statuses'] = $_POST['statuses'] : '';
            // validate payment methods
            !(empty($data['payment_method_id'])) ?: $data['payment_method_id_error'] = 'هذا الحقل مطلوب';

            // validate banktransferproof
            if ($_FILES['banktransferproof']['error'] != 4) { // no file has uploaded 
                $image = $this->orderModel->validateImage('banktransferproof', ADMINROOT . '/../media/files/banktransfer/');
                ($image[0]) ? $data['banktransferproof'] = $image[1] : $data['banktransferproof_error'] = $image[1];
            }
            // validate status
            if (isset($_POST['status'])) {
                $data['status'] = trim($_POST['status']);
            }
            if ($data['status'] == '') {
                $data['status_error'] = 'من فضلك اختار حالة النشر';
            }
            //make sure there is no errors
            if (empty($data['status_error']) && empty($data['payment_method_id_error']) && empty($data['banktransferproof_error'])) {
                //validated
                if ($this->orderModel->updateOrder($data)) {
                    //update donations publishing status after updating the order
                    if ($data['status'] == 1) {
                        $this->orderModel->publishDonations([$id], 'order_id');
                    } else {
                        $this->orderModel->unpublishDonations([$id], 'order_id');
                    }
                    flash('order_msg', 'تم التعديل بنجاح');
                    isset($_POST['save']) ? redirect('orders/edit/' . $id) : redirect('orders');
                } else {
                    flash('order_msg', 'هناك خطأ ما حاول مرة اخري', 'alert alert-danger');
                }
            } else {
                //load the view with error
                $this->view('orders/edit', $data);
            }
        } else {
            // featch order
            if (!$order = $this->orderModel->getOrderById($id)) {
                flash('order_msg', 'هناك خطأ ما هذه الصفحة غير موجوده او ربما اتبعت رابط خاطيء ', 'alert alert-danger');
                redirect('orders');
            }
            
            if ($order->payment_method_id != 1) {
                flash('order_msg', 'لا يمكن التعديل الا علي عمليات التحويل البنكي ', 'alert alert-danger');
                redirect('orders');
            }
            $data = [
                'page_title' => 'الطلبات',
                'order' => $order,
                'donations' => $this->orderModel->getDonationsByOrderId($id),
                'paymentMethodsList' => $this->orderModel->paymentMethodsList(' WHERE status <> 2 '),
                'banktransferproof' => $order->banktransferproof,
                'statusesList' => $this->orderModel->statusesList(),
                'payment_method_id_error' => '',
                'banktransferproof_error' => '',
                'status_error' => '',
                //donation data
                'amount' => '',
                'total' => '',
                'quantity' => '',
                'project_id' => '',
                'donation_type' => '',
                'projectList' => $this->orderModel->projectsList('WHERE status = 1'),
                'project_id_error' => '',
            ];
            $this->view('orders/edit', $data);
        }
    }

    /**
     * showing order details
     * @param integer $id
     */
    public function show($id)
    {
        if (!$order = $this->orderModel->getOrderById($id)) {
            flash('order_msg', 'هناك خطأ ما هذه الصفحة غير موجوده او ربما اتبعت رابط خاطيء ', 'alert alert-danger');
            redirect('orders');
        }
        $data = [
            'page_title' => 'الطلبات',
            'donation_type_list' => ['share' => 'طلب بالاسهم', 'fixed' => 'قيمة ثابته', 'open' => 'طلب مفتوح', 'unit' => 'فئات'],
            'donations' => $this->orderModel->getDonationsByOrderId($id),
            'order' => $order,
        ];
        $this->view('orders/show', $data);
    }

    /**
     * delete record by id
     * @param integer $id
     */
    public function delete($id)
    {
        if ($row_num = $this->orderModel->deleteById([$id], 'order_id')) {
            flash('order_msg', 'تم حذف ' . $row_num . ' بنجاح');
        } else {
            flash('order_msg', 'لم يتم الحذف', 'alert alert-danger');
        }
        redirect('orders');
    }

    /**
     * publish record by id
     * @param integer $id
     */
    public function publish($id)
    {
        if ($row_num = $this->orderModel->publishById([$id], 'order_id')) {
            flash('order_msg', 'تم نشر ' . $row_num . ' بنجاح');
        } else {
            flash('order_msg', 'هناك خطأ ما يرجي المحاولة لاحقا', 'alert alert-danger');
        }
        redirect('orders');
    }

    /**
     * publish record by id
     * @param integer $id
     */
    public function unpublish($id)
    {
        if ($row_num = $this->orderModel->unpublishById([$id], 'order_id')) {
            flash('order_msg', 'تم ايقاف نشر ' . $row_num . ' بنجاح');
        } else {
            flash('order_msg', 'هناك خطأ ما يرجي المحاولة لاحقا', 'alert alert-danger');
        }
        redirect('orders');
    }
    /**
     * canceled record by id
     * @param integer $id
     */
    public function canceled($id)
    {
        if ($row_num = $this->orderModel->canceledById([$id], 'order_id')) {
            flash('order_msg', 'تم الغاء ' . $row_num . ' بنجاح');
        } else {
            flash('order_msg', 'هناك خطأ ما يرجي المحاولة لاحقا', 'alert alert-danger');
        }
        redirect('orders');
    }

    /**
     * publish record by id
     * @param integer $id
     */
    public function waiting($id)
    {
        if ($row_num = $this->orderModel->waitingById([$id], 'order_id')) {
            flash('order_msg', 'تم وضع في الانتظار ' . $row_num . ' بنجاح');
        } else {
            flash('order_msg', 'هناك خطأ ما يرجي المحاولة لاحقا', 'alert alert-danger');
        }
        redirect('orders');
    }

    public function sendNotficationBadal($orders){
        require_once APPROOT . '/admin/models/QueueTable.php';
        $queueTable = new QueueTable();
        $subsitutes = $queueTable->getAvailableSubsitudes();
        if ($subsitutes) {
            foreach ($subsitutes as $subsitute) {
                $data['order_id'] = $orders[0]->order_id;
                $data['substitute_id'] = $subsitute->substitute_id;
                $queueTable->addqueue($data);
            }
        }
    }
    


    public function sendNotficationBadalOld($orders){
        $subsitutes = $this->orderModel->getSubstitutes();
        
        if ($subsitutes) {
            require_once APPROOT . '/app/models/Messaging.php';
            $messaging = new Messaging();
            foreach ($orders as $order) {
                foreach ($subsitutes as $subsitue) {
                   $subsitueData = [
                        'mailto'        => $subsitue->email,
                        'mobile'        => $subsitue->phone,
                        'identifier'    => $order->order_identifier,
                        'total'         => $order->total,
                        'project'       => $order->projects,
                        'donor'         => $order->donor_name,
                        'subject'       => 'تم تسجيل طلب جديد ',
                        'msg'           => "تم تسجيل طلب جديد بمشروع : {$order->projects}"  ,
                        'notify_id'     => $subsitue->subsitude_donor_id,
                        'notify'        => " يوجد طلب جديد",
                    ];

                    $messaging->sendNotfication($subsitueData, 'newOrder');
                }
            }
        }
    }
}
