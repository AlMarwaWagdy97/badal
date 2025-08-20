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

class SubstitutesOrders extends ControllerAdmin
{

    private $orderModel;

    public function __construct()
    {
        $this->orderModel = $this->model('Order');
    }

    /**
     * loading index view with latest orders
     */
    public function index($substitute_id , $current = '', $perpage = 50)
    {
        // get orders
        $cond = 'WHERE ord.status <> 2 AND donors.donor_id = ord.donor_id AND ord.payment_method_id = payment_methods.payment_id
                AND  ord.order_id = ds.order_id AND ds.substitute_id = ' . $substitute_id;
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
                redirect('SubstitutesOrders/index/' . $substitute_id);
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

                        redirect('SubstitutesOrders/index/' . $substitute_id);
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
                redirect('SubstitutesOrders/index/' . $substitute_id);
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
                redirect('SubstitutesOrders/index/' . $substitute_id);
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
                redirect('SubstitutesOrders/index/' . $substitute_id);
            }

          
            //handling export
            if (isset($_POST['export'])) {
                if (isset($_POST['record'])) {
                    return $this->orderModel->exportSubsitutesOrders($_POST['record'], $substitute_id);
                } else {
                    flash('order_msg', 'هناك خطأ ما يرجي المحاولة لاحقا', 'alert alert-danger');
                    redirect('SubstitutesOrders/index/' . $substitute_id);
                }
            }

            if (isset($_POST['exportAll']) && isset($_SESSION['search'])) {
                    $total =  $this->orderModel->allOrdersCount(", donors, payment_methods, badal_orders ds  " . $_SESSION['search']['cond'], $_SESSION['search']['bind']);
                if ($total->count > 20000) {
                    flash('order_msg', 'عدد النتائج اكبر من اللازم اقصي عدد يمكن استخراجه 20000', 'alert alert-danger');
                    redirect('SubstitutesOrders/index/' . $substitute_id);
                }
                return $this->orderModel->exportAllSubsitutesOrders($substitute_id);
            } elseif (isset($_POST['exportAll'])) {
                flash('order_msg', 'يجب ان تقوم بالبحث اولا لكي تتمكن من استخراج النتائج', 'alert alert-danger');
                redirect('SubstitutesOrders/index/' . $substitute_id);
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
                redirect('SubstitutesOrders/index/' . $substitute_id);
            }

        } else {
            $cond .= ' AND ord.store_id IS NULL ';

            if (isset($_SESSION['search']['bind'])) {
                $cond = $_SESSION['search']['cond'];
                $bind = $_SESSION['search']['bind'];
            }
        }
    
        $recordsCount = $this->orderModel->allOrdersCount(", donors, payment_methods, badal_orders ds " . $cond, $bind);
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
        $orders = $this->orderModel->getOrdersSubsitutes($cond, $bind, $limit, $bindLimit);
        $data = [
            'current' => $current,
            'perpage' => $perpage,
            'header' => '',
            'title' => 'الطلبات',
            'statuses' => $this->orderModel->statusesList(' WHERE status = 1'),
            'stores' => $this->orderModel->stores(),
            'paymentMethodsList' => $this->orderModel->paymentMethodsList(' WHERE status <> 2 '),
            'projects' => $this->orderModel->projectsList(' WHERE status <> 2 AND badal = 1 '),
            'orders' => $orders,
            'recordsCount' => $recordsCount->count,
            'footer' => '',
        ];
        $this->view('substitutes/orders', $data);
    }

    public function sendNotficationBadal($orders){
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
                        'donor'         => $subsitue->full_name,
                        'subject'       => 'تم تسجيل تبرع جديد ',
                        'msg'           => "تم تسجيل تبرع جديد بمشروع : {$order->projects} <br/> بقيمة : " . $order->total,
                        // 'notify_id'     => $substitute->subsitude_donor_id,
                        // 'notify'        => 'تم تسجيل تبرع جديد ',
                    ];

                    $messaging->sendNotfication($subsitueData, 'newOrder');
                }
            }
        }
    }
}
