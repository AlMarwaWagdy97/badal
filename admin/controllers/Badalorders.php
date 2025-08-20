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

class Badalorders extends ControllerAdmin
{

    private $badalorderModel;

    public function __construct()
    {
        $this->badalorderModel = $this->model('Badalorder');
    }

    /**
     * loading index view with latest badalorders
     */
    public function index($current = '', $perpage = 50)
    {
        // get badalorders
        $cond = ' WHERE ds.status <> 2 AND projects.project_id = ds.project_id AND ds.order_id = orders.order_id ';
        $bind = [];
        //check user action if the form has submitted
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // sanitize POST array
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            // date search
            if (!empty($_POST['search']['date_from'])) {
                $cond .= ' AND ds.create_date >= ' . strtotime($_POST['search']['date_from']) . ' ';
            }
            if (!empty($_POST['search']['date_to'])) {
                $cond .= ' AND ds.create_date <= ' . strtotime($_POST['search']['date_to']) . ' ';
            }
            // amount search
            if (!empty($_POST['search']['amount_from'])) {
                $cond .= ' AND ds.amount >= ' . $_POST['search']['amount_from'] . ' ';
            }
            if (!empty($_POST['search']['amount_to'])) {
                $cond .= ' AND ds.amount <= ' . $_POST['search']['amount_to'] . ' ';
            }
            if (!empty($_POST['search']['order'])) {
                $cond .= ' AND orders.order_identifier LIKE "%' . $_POST['search']['order'] . '%" ';
            }
            // projects search
            if (!empty($_POST['search']['projects'])) {
                $cond .= ' AND ds.project_id in (' . implode(',', $_POST['search']['projects']) . ') ';
            }
            if (!empty($_POST['search']['status'])) {
                $_POST['search']['status'] =  $_POST['search']['status'] == "pendding" ? 0 : $_POST['search']['status'];
                $cond .= ' AND ds.status =  ' . $_POST['search']['status'] . ' ';
            }
            if (!empty($_POST['search']['subsitute'])) {
                $cond .= ' AND ds.substitute_id =  ' . $_POST['search']['subsitute'] . ' ';
            }
            //handling Delete
            if (isset($_POST['delete'])) {
                if (isset($_POST['record'])) {
                    if ($row_num = $this->badalorderModel->deleteById($_POST['record'], 'badal_id')) {
                        flash('badalorder_msg', 'تم حذف ' . $row_num . ' بنجاح');
                    } else {
                        flash('badalorder_msg', 'لم يتم الحذف', 'alert alert-danger');
                    }
                }
                redirect('badalorders');
            }
        }
        //handling search
        $searches = $this->badalorderModel->searchHandling(['total'], $current);
        $cond .= $searches['cond'];
        $bind = $searches['bind'];
        // get all records count after search and filtration
        $recordsCount = $this->badalorderModel->allBadalordersCount(", projects, orders " . $cond, $bind);
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
        //get all records for current badalorder
        $badalorders = $this->badalorderModel->getBadalorders($cond, $bind, $limit, $bindLimit);

        $data = [
            'current' => $current,
            'perpage' => $perpage,
            'header' => '',
            'title' => 'التبرعات',
            'statuses' => $this->badalorderModel->statusesList(' WHERE status = 1'),
            'paymentMethodsList' => $this->badalorderModel->paymentMethodsList(' WHERE status <> 2 '),
            'projects' => $this->badalorderModel->projectsList(' WHERE status = 1'),
            'subsitutes' => $this->badalorderModel->getsubsitutes(' WHERE status <> 2'),
            'badalorders' => $badalorders,
            'recordsCount' => $recordsCount->count,
            'footer' => '',
        ];
        $this->view('badalorders/index', $data);
    }

    /**
     * update badalorder
     * @param integer $id
     */
    public function edit($id)
    {
        $id = (int) $id;
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // sanitize POST array
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

            $data = [
                'badal_id' => $id,
                'page_title' => ' التبرعات',
                'amount' => $_POST['amount'],
                'total' => $_POST['total'],
                'quantity' => $_POST['quantity'],
                'banktransferproof' => '',
                'projectList' => $this->badalorderModel->projectsList('WHERE status = 1'),
                'project_id' => $_POST['project_id'],
                'statuses' => '',
                'status' => '',
                'payment_method_id_error' => '',
                'project_id_error' => '',
            ];
            isset($_POST['statuses']) ? $data['statuses'] = $_POST['statuses'] : '';
            // validate payment methods
            !(empty($data['payment_method_id'])) ?: $data['payment_method_id_error'] = 'هذا الحقل مطلوب';

            // validate payment methods
            !(empty($data['project_id'])) ? null : $data['project_id_error'] = 'هذا الحقل مطلوب';

            // dd($_FILES);
            // validate status
            if (isset($_POST['status'])) {
                $data['status'] = trim($_POST['status']);
            }
            if ($data['status'] == '') {
                $data['status_error'] = 'من فضلك اختار حالة النشر';
            }
            //make sure there is no errors
            if (empty($data['project_id_error'])) {
                //validated
                if ($this->badalorderModel->updateBadalorder($data)) {
                    flash('badalorder_msg', 'تم التعديل بنجاح');
                    isset($_POST['save']) ? redirect('badalorders/edit/' . $id) : redirect('badalorders');
                } else {
                    flash('badalorder_msg', 'هناك خطأ ما حاول مرة اخري', 'alert alert-danger');
                }
            } else {
                //load the view with error
                $this->view('badalorders/edit', $data);
            }
        } else {
            // featch badalorder
            if (!$badalorder = $this->badalorderModel->getBadalorderById($id)) {
                flash('badalorder_msg', 'هناك خطأ ما هذه الصفحة غير موجوده او ربما اتبعت رابط خاطيء ', 'alert alert-danger');
                redirect('badalorders');
            }
            $data = [
                'page_title' => 'التبرعات',
                'badal_id' => $id,
                'amount' => $badalorder->amount,
                'total' => $badalorder->total,
                'quantity' => $badalorder->quantity,
                'project_id' => $badalorder->project_id,
                'projectList' => $this->badalorderModel->projectsList('WHERE status = 1'),
                'payment_method_id_error' => '',
                'project_id_error' => '',
                'banktransferproof_error' => '',
                'status_error' => '',
            ];
            $this->view('badalorders/edit', $data);
        }
    }
    /**
     * update badalorder
     * @param integer $id
     */
    public function add($id)
    {
        $id = (int) $id;
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // sanitize POST array
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

            $data = [
                'order_id' => $id,
                'amount' => $_POST['amount'],
                'total' => $_POST['total'],
                'quantity' => $_POST['quantity'],
                'project_id' => $_POST['project_id'],
                'status' =>  $_POST['status'],
                'badalorder_type' => $_POST['badalorder_type'],
            ];


            //make sure there is no errors
            if (!empty($data['project_id']) && !empty($data['amount']) && !empty($data['total']) && !empty($data['quantity']) && !empty($data['status'])) {
                //validated
                // dd($data);
                if ($this->badalorderModel->addBadalorder($data)) {
                    flash('order_msg', 'تمت الاضافة بنجاح');
                    redirect('orders/edit/' . $id);
                } else {
                    flash('order_msg', 'هناك خطأ ما حاول مرة اخري', 'alert alert-danger');
                }
            } else {
                flash('order_msg', 'برجاء استكمال جميع الحقول ', 'alert alert-danger');
                redirect('orders/edit/' . $id);
            }
        } else {
            flash('order_msg', 'هناك خطأ ما هذه الصفحة غير موجوده او ربما اتبعت رابط خاطيء ', 'alert alert-danger');
            redirect('orders');
        }
    }
    /**
     * showing badalorder details
     * @param integer $id
     */
    public function show($id)
    {
        if (!$badalorder = $this->badalorderModel->getBadalorderById($id)) {
            flash('badalorder_msg', 'هناك خطأ ما هذه الصفحة غير موجوده او ربما اتبعت رابط خاطيء ', 'alert alert-danger');
            redirect('badalorders');
        }
        $data = [
            'page_title' => 'التبرعات',
            'badalorder_type_list' => ['share' => 'تبرع بالاسهم', 'fixed' => 'قيمة ثابته', 'open' => 'تبرع مفتوح', 'unit' => 'فئات'],
            'badalorder' => $badalorder,
        ];
        $this->view('badalorders/show', $data);
    }

    /**
     * delete record by id
     * @param integer $id
     */
    public function delete($id)
    {
        if ($row_num = $this->badalorderModel->deleteById([$id], 'badal_id')) {
            flash('badalorder_msg', 'تم حذف ' . $row_num . ' بنجاح');
        } else {
            flash('badalorder_msg', 'لم يتم الحذف', 'alert alert-danger');
        }
        redirect('badalorders');
    }

    /**
     * publish record by id
     * @param integer $id
     */
    public function publish($id)
    {
        if ($row_num = $this->badalorderModel->publishById([$id], 'badal_id')) {
            flash('badalorder_msg', 'تم نشر ' . $row_num . ' بنجاح');
        } else {
            flash('badalorder_msg', 'هناك خطأ ما يرجي المحاولة لاحقا', 'alert alert-danger');
        }
        redirect('badalorders');
    }

    /**
     * publish record by id
     * @param integer $id
     */
    public function unpublish($id)
    {
        if ($row_num = $this->badalorderModel->unpublishById([$id], 'badal_id')) {
            flash('badalorder_msg', 'تم ايقاف نشر ' . $row_num . ' بنجاح');
        } else {
            flash('badalorder_msg', 'هناك خطأ ما يرجي المحاولة لاحقا', 'alert alert-danger');
        }
        redirect('badalorders');
    }
    /**
     * canceled record by id
     * @param integer $id
     */
    public function canceled($id)
    {
        if ($row_num = $this->badalorderModel->canceledById([$id], 'badal_id')) {
            flash('badalorder_msg', 'تم الغاء ' . $row_num . ' بنجاح');
        } else {
            flash('badalorder_msg', 'هناك خطأ ما يرجي المحاولة لاحقا', 'alert alert-danger');
        }
        redirect('badalorders');
    }

    /**
     * publish record by id
     * @param integer $id
     */
    public function waiting($id)
    {
        if ($row_num = $this->badalorderModel->waitingById([$id], 'badal_id')) {
            flash('badalorder_msg', 'تم وضع في الانتظار ' . $row_num . ' بنجاح');
        } else {
            flash('badalorder_msg', 'هناك خطأ ما يرجي المحاولة لاحقا', 'alert alert-danger');
        }
        redirect('badalorders');
    }
}
