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

class Gifted extends ControllerAdmin
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
        $cond = 'WHERE ord.status <> 2 AND ord.gift = 1 ';
        $bind = [];
        //check user action if the form has submitted
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // sanitize POST array
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

            if (!empty($_POST['search']['status'])) {
                if ($_POST['search']['status'] == 5) $_POST['search']['status'] = 0;
                $cond .= ' AND ord.status =  ' . $_POST['search']['status'];
            }
            
            
            $cond .= ' ORDER BY ord.create_date DESC   ';
            //handling export
            if (isset($_POST['export'])) {
                if (isset($_POST['record'])) {
                    return $this->orderModel->exportGifted($_POST['record']);
                } else {
                    flash('order_msg', 'هناك خطأ ما يرجي المحاولة لاحقا', 'alert alert-danger');
                    redirect('gifted');
                }
            }
            //handling export
            if (isset($_POST['exportGifted']) ) {
                $total =  $this->orderModel->allOrdersCountGift( $cond . @$_SESSION['search']['cond'], @$_SESSION['search']['bind']);
                if ($total->count > 40000) {
                    flash('order_msg', 'عدد النتائج اكبر من اللازم اقصي عدد يمكن استخراجه 20000', 'alert alert-danger');
                    redirect('gifted');
                }
                return $this->orderModel->exportAllOrdersGift( $cond . @$_SESSION['search']['cond'], @$_SESSION['search']['bind']);
            } elseif (isset($_POST['exportAll'])) {
                flash('order_msg', 'يجب ان تقوم بالبحث اولا لكي تتمكن من استخراج النتائج', 'alert alert-danger');
                redirect('gifted');
            }
        }
        // get all records count after search and filtration
        // $recordsCount = $this->orderModel->allOrdersCount($cond, $bind);
        // make sure its integer value and its usable
        $current = (int) $current;
        $perpage = (int) $perpage;
        $recordsCount = $this->orderModel->allOrdersCount($cond, $bind);
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
        $orders = $this->orderModel->getAll("SELECT gift_data, order_identifier, order_id, create_date FROM orders ord " . $cond, $bind, $limit, $bindLimit);
        $data = [
            'current' => $current,
            'perpage' => $perpage,
            'header' => '',
            'title' => 'بيانات الاهداء',
            'orders' => $orders,
            'recordsCount' => $recordsCount->count,
            'footer' => '',
        ];
        $this->view('gifted/index', $data);
    }
}
