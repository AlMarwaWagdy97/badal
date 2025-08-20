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

class Reports extends ControllerAdmin
{

    private $donationModel;
    private $orderModel;

    public function __construct()
    {
        $this->donationModel = $this->model('Donation');
        $this->orderModel = $this->model('Order');
    }

    /**
     * loading index view with latest orders
     */
    public function index()
    {
        $data = [
            'header' => '',
            'title' => ' التقارير',
            'statuses' => $this->donationModel->statusesList(),
            'projects' => $this->donationModel->projectsList(),
            'paymentMethods' => $this->donationModel->paymentMethodsList(),
            'footer' => '',
        ];
        $this->view('reports/index', $data);
    }



    /**
     * showing donation details
     * @param integer $id
     */
    public function show($id)
    {
        $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

        if (!in_array($id, ['orders', 'donors', 'contacts']) || !isset($_POST)) {
            flash('report_msg', 'هناك خطأ ما هذه الصفحة غير موجوده او ربما اتبعت رابط خاطيء ', 'alert alert-danger');
            redirect('reports');
        }
        if ($id == 'orders') {
            // build query
            // get orders
            $cond = 'WHERE ord.status <> 2 AND donors.donor_id = ord.donor_id AND ord.payment_method_id = payment_methods.payment_id';
            $bind = [];
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
                $cond .= ' AND ord.projects_id REGEXP '  . rtrim(strIncRepeat(':projects_id', count($projects), "|"), "|") . '';
                foreach ($projects as $key => $project) {
                    if (!empty($project)) {
                        $bind[':projects_id' . $key] = "($project)";
                    }
                }
            }
            // result count
            if (!empty($_POST['search']['limit'])) {
                $limit = ' LIMIT 0 , :perpage ';
                $bindLimit[':perpage'] = (int) $_POST['search']['limit'];;
            } else {
                $limit = '';
                $bindLimit = '';
            }

            $orders = $this->orderModel->getOrders($cond, $bind, $limit, $bindLimit);
            $data = [
                'page_title' => 'التقارير',
                'orders' => $orders,
            ];
            $this->view('reports/orders', $data);
        } elseif ($id == 'donors') {
            // build query
            $status_exp = '';
            $mobile_exp = '';
            $mobile_confirmed_exp = '';
            $donors_exp = '';
            $email_exp = '';
            $date_exp_from = '';
            $date_exp_to = '';
            if ($_POST['status'] !== '') {
                $status_exp = ' AND dr.status =' . $_POST['status'] . ' ';
            }
            if ($_POST['donor'] !== '') {
                $donors_exp = ' AND dr.full_name LIKE "%' . $_POST['donor'] . '%" ';
            }
            if ($_POST['email'] !== '') {
                $email_exp = ' AND dr.email LIKE "%' . $_POST['email'] . '%" ';
            }
            if ($_POST['mobile'] !== '') {
                $mobile_exp = ' AND dr.mobile LIKE "%' . $_POST['mobile'] . '%" ';
            }
            if ($_POST['mobile_confirmed'] !== '') {
                $mobile_confirmed_exp = ' AND dr.mobile_confirmed =' . $_POST['mobile_confirmed'] . ' ';
            }
            if ($_POST['date_from'] !== '') {
                $amount_exp_from = ' AND dr.create_date >= ' . strtotime($_POST['date_from']) . ' ';
            }
            if ($_POST['date_to'] !== '') {
                $amount_exp_to = ' AND dr.create_date <= ' . strtotime($_POST['date_to']) . ' ';
            }
            // excute
            $query = 'SELECT * FROM donors dr WHERE donor_id >0 '
                .  $status_exp . $mobile_exp . $mobile_confirmed_exp . $email_exp . $donors_exp . $date_exp_from . $date_exp_to;
            // dd($query);
            $donor = $this->donationModel->getAll($query);
            $data = [
                'page_title' => 'التقارير',
                'donor' => $donor,
            ];
            $this->view('reports/donors', $data);
        } elseif ($id == 'contacts') {
            // build query
            $status_exp = '';
            $phone_exp = '';
            $message_exp = '';
            $subject_exp = '';
            $full_name_exp = '';
            $email_exp = '';
            $type_exp = '';
            $date_exp_from = '';
            $date_exp_to = '';
            if ($_POST['status'] !== '') {
                $status_exp = ' AND status =' . $_POST['status'] . ' ';
            }
            if ($_POST['full_name'] !== '') {
                $full_name_exp = ' AND full_name LIKE "%' . $_POST['full_name'] . '%" ';
            }
            if ($_POST['email'] !== '') {
                $email_exp = ' AND email LIKE "%' . $_POST['email'] . '%" ';
            }
            if ($_POST['type'] !== '') {
                $type_exp = ' AND type LIKE "%' . $_POST['type'] . '%" ';
            }
            if ($_POST['subject'] !== '') {
                $subject_exp = ' AND subject LIKE "%' . $_POST['subject'] . '%" ';
            }
            if ($_POST['phone'] !== '') {
                $phone_exp = ' AND phone LIKE "%' . $_POST['phone'] . '%" ';
            }
            if ($_POST['message'] !== '') {
                $message_exp = ' AND message LIKE "%' . $_POST['message'] . '%" ';
            }
            if ($_POST['date_from'] !== '') {
                $amount_exp_from = ' AND create_date >= ' . strtotime($_POST['date_from']) . ' ';
            }
            if ($_POST['date_to'] !== '') {
                $amount_exp_to = ' AND create_date <= ' . strtotime($_POST['date_to']) . ' ';
            }
            // excute
            $query = 'SELECT * FROM contacts WHERE contact_id > 0 '
                .  $status_exp . $phone_exp . $message_exp . $subject_exp . $type_exp . $email_exp . $full_name_exp . $date_exp_from . $date_exp_to;
            // dd($query);
            $contact = $this->donationModel->getAll($query);
            $data = [
                'page_title' => 'التقارير',
                'contact' => $contact,
            ];
            $this->view('reports/contacts', $data);
        }
    }
}
