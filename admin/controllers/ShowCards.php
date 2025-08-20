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

class ShowCards extends ControllerAdmin
{

    private $orderModel;

    public function __construct()
    {
        $this->orderModel = $this->model('Order');
    }

    /**
     * showing order card
     * @param integer $id
     */
    public function show($id)
    {
        if (!$order = $this->orderModel->getOrderById($id)) {
            flash('order_msg', 'هناك خطأ ما هذه الصفحة غير موجوده او ربما اتبعت رابط خاطيء ', 'alert alert-danger');
            redirect('orders');
        }
        $data = [
            'page_title' => 'بيانات الإهداء ',
            'order' => $order,
        ];
        $this->view('orders/cards', $data);
    }

}
