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

class Badalrequests extends ControllerAdmin
{

    private $model;

    public function __construct()
    {
        $this->model = $this->model('Badalrequest');
    }

    /**
     * loading index view with latest badalorders
     */
    public function index($current = '', $perpage = 50)
    {
        // get badalorders
        $cond = ' WHERE requests.status <> 2 AND  requests.substitute_id = substitutes.substitute_id ';
        $bind = [];
        //check user action if the form has submitted
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // sanitize POST array
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            // date search
            if (!empty($_POST['search']['date_from'])) {
                $cond .= ' AND requests.create_date >= ' . strtotime($_POST['search']['date_from']) . ' ';
            }
            if (!empty($_POST['search']['date_to'])) {
                $cond .= ' AND requests.create_date <= ' . strtotime($_POST['search']['date_to']) . ' ';
            }
            //handling Delete
            if (isset($_POST['delete'])) {
                if (isset($_POST['record'])) {
                    if ($row_num = $this->model->deleteById($_POST['record'], 'request_id')) {
                        flash('badalrequest_msg', 'تم حذف ' . $row_num . ' بنجاح');
                    } else {
                        flash('badalrequest_msg', 'لم يتم الحذف', 'alert alert-danger');
                    }
                }
                redirect('Badalrequests');
            }
        }
        //handling search
        $searches = $this->model->searchHandling(['substitute_id', 'badal_id', 'is_selected'], $current);
        $cond .= $searches['cond'];
        $bind = $searches['bind'];
        // get all records count after search and filtration
        $recordsCount = $this->model->allBadalRequestsCount(", substitutes " . $cond, $bind);
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
        $badalrequests = $this->model->getBadalRequests($cond, $bind, $limit, $bindLimit);

        $data = [
            'current' => $current,
            'perpage' => $perpage,
            'header' => '',
            'title' => 'الطلبات',
            'substitutes' => $this->model->substitutesList(''),
            'badalrequests' => $badalrequests,
            'recordsCount' => $recordsCount->count,
            'footer' => '',
        ];
        $this->view('badalrequest/index', $data);
    }

      /**
     * show record by badal_id
     * @param integer $badal_id
     */
    public function show($badal_id)
    {
        if (!$badalrequests = $this->model->getBadalRequestsByBadal($badal_id)) {
            flash('badalrequest_msg', ' لا يوجد متقدميين لهذا الطلب', 'alert alert-danger');
            redirect('Badalrequests');
        }
        $data = [
            'title' => 'طلبات المتقدمين',
            'badalrequests' => $badalrequests,
        ];
        $this->view('badalrequest/show', $data);
    }

    /**
     * delete record by id
     * @param integer $id
     */
    public function delete($id)
    {
        if ($row_num = $this->model->deleteById([$id], 'request_id')) {
            flash('badalrequest_msg', 'تم حذف ' . $row_num . ' بنجاح');
        } else {
            flash('badalrequest_msg', 'لم يتم الحذف', 'alert alert-danger');
        }
        redirect('Badalrequests');
    }






}
