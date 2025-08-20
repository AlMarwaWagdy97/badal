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

class Volunteerings extends ControllerAdmin
{
    private $volunteeringModel;
    public function __construct()
    {
        $this->volunteeringModel = $this->model('Volunteering');
    }
    /**
     * loading index view with latest volunteering
     */
    public function index($current = '', $perpage = 50)
    {
        // get volunteering
        $cond = ',volunteerpages WHERE volunteering.status <> 2 ';
        $bind = [];
        //check user action if the form has submitted
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // sanitize POST array
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            //handling Delete
            if (isset($_POST['delete'])) {
                if (isset($_POST['record'])) {
                    if ($row_num = $this->volunteeringModel->deleteById($_POST['record'], 'volunteering_id')) {
                        flash('volunteering_msg', 'تم حذف ' . $row_num . ' بنجاح');
                    } else {
                        flash('volunteering_msg', 'لم يتم الحذف', 'alert alert-danger');
                    }
                }
                redirect('volunteerings');
            }
        }
        //handling search
        $searches = $this->volunteeringModel->searchHandling(['full_name', 'identity', 'phone', 'email', 'status', 'volunteerpages.title'], $current);
        $cond .= str_replace('volunteering.volunteerpages.title', 'volunteerpages.title', $searches['cond']);
        $bind = $searches['bind'];
        
        // get all records count after search and filtration
        $recordsCount = $this->volunteeringModel->allVolunteeringsCount($cond, $bind);
        
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
        //get all records for current volunteering
        $volunteering = $this->volunteeringModel->getVolunteerings($cond, $bind, $limit, $bindLimit);
        $data = [
            'current' => $current,
            'perpage' => $perpage,
            'header' => '',
            'title' => 'ساعات التطوع',
            'volunteering' => $volunteering,
            'recordsCount' => $recordsCount->count,
            'footer' => '',
        ];
        $this->view('volunteering/index', $data);
    }

    /**
     * delete record by id
     * @param integer $id
     */
    public function delete($id)
    {
        if ($row_num = $this->volunteeringModel->deleteById([$id], 'volunteering_id')) {
            flash('volunteering_msg', 'تم حذف ' . $row_num . ' بنجاح');
        } else {
            flash('volunteering_msg', 'لم يتم الحذف', 'alert alert-danger');
        }
        redirect('volunteerings');
    }

    /**
     * publish record by id
     * @param integer $id
     */
    public function publish($id)
    {
        if ($row_num = $this->volunteeringModel->publishById([$id], 'volunteering_id')) {
            flash('volunteering_msg', 'تم تعليم كا مقروءة ' . $row_num . ' بنجاح');
        } else {
            flash('volunteering_msg', 'هناك خطأ ما يرجي المحاولة لاحقا', 'alert alert-danger');
        }
        redirect('volunteerings');
    }

    /**
     * publish record by id
     * @param integer $id
     */
    public function unpublish($id)
    {
        if ($row_num = $this->volunteeringModel->unpublishById([$id], 'volunteering_id')) {
            flash('volunteering_msg', 'تم تعليم كا غير مقروءة ' . $row_num . ' بنجاح');
        } else {
            flash('volunteering_msg', 'هناك خطأ ما يرجي المحاولة لاحقا', 'alert alert-danger');
        }
        redirect('volunteerings');
    }
}
