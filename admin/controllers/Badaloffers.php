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

class Badaloffers extends ControllerAdmin
{

    private $model;

    public function __construct()
    {
        $this->model = $this->model('Badaloffer');
    }

    /**
     * loading index view with latest badalorders
     */
    public function index($current = '', $perpage = 50)
    {
        // get badalorders
        $cond = ' WHERE offers.status <> 2 AND offers.project_id = projects.project_id AND offers.substitute_id = substitutes.substitute_id ';
        $bind = [];
        //check user action if the form has submitted
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // sanitize POST array
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            // date search
            if (!empty($_POST['search']['date_from'])) {
                $cond .= ' AND offers.create_date >= ' . strtotime($_POST['search']['date_from']) . ' ';
            }
            if (!empty($_POST['search']['date_to'])) {
                $cond .= ' AND offers.create_date <= ' . (strtotime($_POST['search']['date_to'] ) + 86400) . ' ';
            }
            // amount search
            if (!empty($_POST['search']['amount_from'])) {
                $cond .= ' AND offers.amount >= ' . $_POST['search']['amount_from'] . ' ';
            }
            if (!empty($_POST['search']['amount_to'])) {
                $cond .= ' AND offers.amount <= ' . $_POST['search']['amount_to'] . ' ';
            }
            if (!empty($_POST['search']['status'])) {
                $_POST['search']['status'] =  $_POST['search']['status'] == "pendding" ? 0 : $_POST['search']['status'];
                $cond .= ' AND offers.status =  ' . $_POST['search']['status'] . ' ';
            }
            // projects search
            if (!empty($_POST['search']['projects'])) {
                $cond .= ' AND offers.project_id in (' . implode(',', $_POST['search']['projects']) . ') ';
            }
            //handling Delete
            if (isset($_POST['delete'])) {
                if (isset($_POST['record'])) {
                    if ($row_num = $this->model->deleteById($_POST['record'], 'offer_id')) {
                        flash('badaloffer_msg', 'تم حذف ' . $row_num . ' بنجاح');
                    } else {
                        flash('badaloffer_msg', 'لم يتم الحذف', 'alert alert-danger');
                    }
                }
                redirect('badaloffers');
            }
            if (isset($_POST['publish'])) {
                if (isset($_POST['record'])) {
                    if ($row_num = $this->model->publishById($_POST['record'], 'offer_id')) {
                        flash('badaloffer_msg', 'تم نشر ' . $row_num . ' بنجاح');
                    } else {
                        flash('badaloffer_msg', 'هناك خطأ ما يرجي المحاولة لاحقا', 'alert alert-danger');
                    }
                }
                redirect('badaloffers');
            }

            //handling Unpublish
            if (isset($_POST['unpublish'])) {

                if (isset($_POST['record'])) {
                    if ($row_num = $this->model->unpublishById($_POST['record'], 'offer_id')) {
                        flash('badaloffer_msg', 'تم ايقاف نشر ' . $row_num . ' بنجاح');
                    } else {
                        flash('badaloffer_msg', 'هناك خطأ ما يرجي المحاولة لاحقا', 'alert alert-danger');
                    }
                }
                redirect('badaloffers');
            }
            if (isset($_POST['canceled'])) {

                if (isset($_POST['record'])) {
                    if ($row_num = $this->model->canceledById($_POST['record'], 'offer_id')) {
                        flash('badaloffer_msg', 'تم الغاء   ' . $row_num . ' بنجاح');
                    } else {
                        flash('badaloffer_msg', 'هناك خطأ ما يرجي المحاولة لاحقا', 'alert alert-danger');
                    }
                }
                redirect('badaloffers');
            }
        }
        //handling search
        $searches = $this->model->searchHandling(['substitute_id'], $current);
        $cond .= $searches['cond'];
        $bind = $searches['bind'];
        // get all records count after search and filtration
        $recordsCount = $this->model->allBadaloffersCount(", projects, substitutes " . $cond, $bind);
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
        $badaloffers = $this->model->getBadaloffers($cond, $bind, $limit, $bindLimit);

        $data = [
            'current' => $current,
            'perpage' => $perpage,
            'header' => '',
            'title' => 'عروض الحج والعمره',
            'projects' => $this->model->projectsList(' WHERE status = 1'),
            'substitutes' => $this->model->substitutesList(''),
            'badaloffers' => $badaloffers,
            'recordsCount' => $recordsCount->count,
            'footer' => '',
        ];
        $this->view('badaloffers/index', $data);
    }

    /**
     * publish record by id
     * @param integer $id
     */
    public function publish($id)
    {
        if ($row_num = $this->model->publishById([$id], 'offer_id')) {
            flash('badaloffer_msg', 'تم نشر ' . $row_num . ' بنجاح');
        } else {
            flash('badaloffer_msg', 'هناك خطأ ما يرجي المحاولة لاحقا', 'alert alert-danger');
        }
        redirect('badaloffers');
    }

    /**
     * publish record by id
     * @param integer $id
     */
    public function unpublish($id)
    {
        if ($row_num = $this->model->unpublishById([$id], 'offer_id')) {
            flash('badaloffer_msg', 'تم ايقاف نشر ' . $row_num . ' بنجاح');
        } else {
            flash('badaloffer_msg', 'هناك خطأ ما يرجي المحاولة لاحقا', 'alert alert-danger');
        }
        redirect('badaloffers');
    }

    /**
     * canceled record by id
     * @param integer $id
     */
    public function canceled($id)
    {
        if ($row_num = $this->model->canceledById([$id], 'offer_id')) {
            flash('badaloffer_msg', 'تم الغاء ' . $row_num . ' بنجاح');
        } else {
            flash('badaloffer_msg', 'هناك خطأ ما يرجي المحاولة لاحقا', 'alert alert-danger');
        }
        redirect('badaloffers');
    }


    /**
     * delete record by id
     * @param integer $id
     */
    public function delete($id)
    {
        if ($row_num = $this->model->deleteById([$id], 'offer_id')) {
            flash('badaloffer_msg', 'تم حذف ' . $row_num . ' بنجاح');
        } else {
            flash('badaloffer_msg', 'لم يتم الحذف', 'alert alert-danger');
        }
        redirect('badaloffers');
    }


    
    /**
     * show record by id
     * @param integer $id
     */
    public function show($id)
    {
        if (!$BadalOffers = $this->model->getOfferByID($id)) {
            flash('badaloffer_msg', 'هناك خطأ ما هذه الصفحة غير موجوده او ربما اتبعت رابط خاطيء ', 'alert alert-danger');
            redirect('BadalOffers');
        }
        $data = [
            'page_title' => 'العرض',
            'BadalOffers' => $BadalOffers,
        ];
        $this->view('badaloffers/show', $data);
    }

 






}
