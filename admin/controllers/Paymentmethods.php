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

class PaymentMethods extends ControllerAdmin
{

    private $paymentModel;

    public function __construct()
    {
        $this->paymentModel = $this->model('PaymentMethod');
    }

    /**
     * loading index view with latest paymentmethods
     */
    public function index($current = '', $perpage = 50)
    {
        // get paymentmethods
        $cond = 'WHERE status <> 2 ';
        $bind = [];

        //check user action if the form has submitted
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // sanitize POST array
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

            //handling Delete
            if (isset($_POST['delete'])) {
                if (isset($_POST['record'])) {
                    if (in_array('1', $_POST['record']) || in_array('2', $_POST['record']) || in_array('3', $_POST['record']) || in_array('4', $_POST['record'])) {
                        flash('paymentmethod_msg', 'لا يمكن حذف وسيلة الدفع هذه', 'alert alert-danger');
                    } else {
                        if ($row_num = $this->paymentModel->deleteById($_POST['record'], 'payment_id')) {
                            flash('paymentmethod_msg', 'تم حذف ' . $row_num . ' بنجاح');
                        } else {
                            flash('paymentmethod_msg', 'لم يتم الحذف', 'alert alert-danger');
                        }
                    }
                }

                redirect('paymentmethods');
            }

            //handling Publish
            if (isset($_POST['publish'])) {
                if (isset($_POST['record'])) {
                    if ($row_num = $this->paymentModel->publishById($_POST['record'], 'payment_id')) {
                        flash('paymentmethod_msg', 'تم نشر ' . $row_num . ' بنجاح');
                    } else {
                        flash('paymentmethod_msg', 'هناك خطأ ما يرجي المحاولة لاحقا', 'alert alert-danger');
                    }
                }
                redirect('paymentmethods');
            }

            //handling Unpublish
            if (isset($_POST['unpublish'])) {

                if (isset($_POST['record'])) {
                    if ($row_num = $this->paymentModel->unpublishById($_POST['record'], 'payment_id')) {
                        flash('paymentmethod_msg', 'تم ايقاف نشر ' . $row_num . ' بنجاح');
                    } else {
                        flash('paymentmethod_msg', 'هناك خطأ ما يرجي المحاولة لاحقا', 'alert alert-danger');
                    }
                }
                redirect('paymentmethods');
            }
        }

        //handling search
        $searches = $this->paymentModel->searchHandling(['title', 'status'], $current);
        $cond .= $searches['cond'];
        $bind = $searches['bind'];

        // get all records count after search and filtration
        $recordsCount = $this->paymentModel->allPaymentMethodsCount($cond, $bind);
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
        //get all records for current page
        $paymentmethods = $this->paymentModel->getPaymentMethods($cond, $bind, $limit, $bindLimit);

        $data = [
            'current' => $current,
            'perpage' => $perpage,
            'header' => '',
            'title' => 'وسائل الدفع',
            'paymentmethods' => $paymentmethods,
            'recordsCount' => $recordsCount->count,
            'footer' => '',
        ];
        $this->view('paymentmethods/index', $data);
    }

    /**
     * adding new page
     */
    public function add()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            $content = $this->paymentModel->cleanHTML($_POST['content']);
            // sanitize POST array
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

            $data = [
                'page_title' => 'وسائل الدفع',
                'title' => trim($_POST['title']),
                'content' => $content,
                'image' => '',
                'payment_key' => '',
                'status' => '',
                'cart_show' => trim($_POST['cart_show']),
                'status_error' => '',
                'image_error' => '',
            ];

            // validate image
            if (!empty($_FILES['image'])) {
                $image = uploadImage('image', ADMINROOT . '/../media/images/', 5000000, true);
                if (empty($image['error'])) {
                    $data['image'] = $image['filename'];
                } else {
                    if (!isset($image['error']['nofile'])) {
                        $data['image_error'] = implode(',', $image['error']);
                    }
                }
            }
            // adding payment key
            if (isset($_POST['payment_key'])) {
                $data['payment_key'] = trim($_POST['payment_key']);
            }
            // validate status
            if (isset($_POST['status'])) {
                $data['status'] = trim($_POST['status']);
            }
            if ($data['status'] == '') {
                $data['status_error'] = 'من فضلك اختار حالة النشر';
            }
            // make sure there is no errors
            if (empty($data['status_error']) && empty($data['image_error'])) {
                //validated
                if ($this->paymentModel->addPaymentMethod($data)) {
                    flash('paymentmethod_msg', 'تم الحفظ بنجاح');
                    redirect('paymentmethods');
                } else {
                    flash('paymentmethod_msg', 'هناك خطأ ما حاول مرة اخري', 'alert alert-danger');
                }
            } else {
                //load the view with error
                $this->view('paymentmethods/add', $data);
            }
        } else {
            $data = [
                'page_title' => 'وسائل الدفع',
                'title' => '',
                'content' => '',
                'payment_key' => '',
                'image' => '',
                'cart_show' => 0,
                'status' => 0,
                'title_error' => '',
                'status_error' => '',
                'image_error' => '',
            ];
        }

        //loading the add page view
        $this->view('paymentmethods/add', $data);
    }

    /**
     * update page
     * @param integer $id
     */
    public function edit($id)
    {
        $id = (int) $id;
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            //cleare html content from malicious
            $content = $this->paymentModel->cleanHTML($_POST['content']);


            // sanitize POST array
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            // var_dump(json_decode(json_encode($_POST['meta']),true)); die();
            
            
            foreach($_POST['meta'] as $key => $file){
                if (!empty($_FILES[$key])) {
                    $image = uploadImage($key, ADMINROOT . '/../media/images/', 5000000, true);
                    if (empty($image['error'])) {
                        $_POST['meta'][$key]["image"] = $image['filename'];
                    } 
                }
            }
        
            $data = [
                'payment_id' => $id,
                'page_title' => 'وسائل الدفع',
                'meta' => json_encode($_POST['meta']),
                'title' => trim($_POST['title']),
                'content' => $content,
                'payment_key' => '',
                'image' => '',
                'cart_show' => trim($_POST['cart_show']),
                'status' => '',
                'status_error' => '',
                'image_error' => '',
            ];

            // adding payment key
            if (isset($_POST['payment_key'])) {
                $data['payment_key'] = trim($_POST['payment_key']);
            }
            // validate image
            if (!empty($_FILES['image'])) {
                $image = uploadImage('image', ADMINROOT . '/../media/images/', 5000000, true);
                if (empty($image['error'])) {
                    $data['image'] = $image['filename'];
                } else {
                    if (!isset($image['error']['nofile'])) {
                        $data['image_error'] = implode(',', $image['error']);
                    }
                }
            }
            // validate status
            if (isset($_POST['status'])) {
                $data['status'] = trim($_POST['status']);
            }
            if ($data['status'] == '') {
                $data['status_error'] = 'من فضلك اختار حالة النشر';
            }
            //             make sure there is no errors
            if (empty($data['status_error']) && empty($data['image_error'])) {
                //validated
                if ($this->paymentModel->updatePaymentMethod($data)) {
                    flash('paymentmethod_msg', 'تم التعديل بنجاح');
                    isset($_POST['save']) ? redirect('paymentmethods/edit/' . $id) : redirect('paymentmethods');
                } else {
                    flash('paymentmethod_msg', 'هناك خطأ ما حاول مرة اخري', 'alert alert-danger');
                }
            } else {
                //load the view with error
                $this->view('paymentmethods/edit', $data);
            }
        } else {
            // featch page
            if (!$paymentmethod = $this->paymentModel->getPaymentMethodById($id)) {
                flash('paymentmethod_msg', 'هناك خطأ ما هذه الصفحة غير موجوده او ربما اتبعت رابط خاطيء ', 'alert alert-danger');
                redirect('paymentmethods');
            }

            $data = [
                'page_title' => 'وسائل الدفع',
                'payment_id' => $id,
                'title' => $paymentmethod->title,
                'meta' => json_decode($paymentmethod->meta, true),
                'content' => $paymentmethod->content,
                'payment_key' => $paymentmethod->payment_key,
                'image' => $paymentmethod->image,
                'cart_show' => $paymentmethod->cart_show,
                'status' => $paymentmethod->status,
                'title_error' => '',
                'status_error' => '',
                'image_error' => '',
            ];
            $this->view('paymentmethods/edit', $data);
        }
    }

    /**
     * showing page details
     * @param integer $id
     */
    public function show($id)
    {
        if (!$paymentmethod = $this->paymentModel->getPaymentMethodById($id)) {
            flash('paymentmethod_msg', 'هناك خطأ ما هذه الصفحة غير موجوده او ربما اتبعت رابط خاطيء ', 'alert alert-danger');
            redirect('paymentmethods');
        }
        $data = [
            'page_title' => 'وسائل الدفع',
            'paymentmethod' => $paymentmethod,
        ];
        $this->view('paymentmethods/show', $data);
    }

    /**
     * delete record by id
     * @param integer $id
     */
    public function delete($id)
    {
        if ($id <= 5) {
            flash('paymentmethod_msg', 'لا يمكن حذف وسيلة الدفع هذه', 'alert alert-danger');
        } else {
            if ($row_num = $this->paymentModel->deleteById([$id], 'payment_id')) {
                flash('paymentmethod_msg', 'تم حذف ' . $row_num . ' بنجاح');
            } else {
                flash('paymentmethod_msg', 'لم يتم الحذف', 'alert alert-danger');
            }
        }

        redirect('paymentmethods');
    }

    /**
     * publish record by id
     * @param integer $id
     */
    public function publish($id)
    {
        if ($row_num = $this->paymentModel->publishById([$id], 'payment_id')) {
            flash('paymentmethod_msg', 'تم نشر ' . $row_num . ' بنجاح');
        } else {
            flash('paymentmethod_msg', 'هناك خطأ ما يرجي المحاولة لاحقا', 'alert alert-danger');
        }
        redirect('paymentmethods');
    }

    /**
     * publish record by id
     * @param integer $id
     */
    public function unpublish($id)
    {
        if ($row_num = $this->paymentModel->unpublishById([$id], 'payment_id')) {
            flash('paymentmethod_msg', 'تم ايقاف نشر ' . $row_num . ' بنجاح');
        } else {
            flash('paymentmethod_msg', 'هناك خطأ ما يرجي المحاولة لاحقا', 'alert alert-danger');
        }
        redirect('paymentmethods');
    }
}
