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

class Dashboard extends ControllerAdmin
{

    public function __construct()
    {
        $this->orderModel = $this->model('Order');
    }

    /**
     * loading index view with latest groups
     */
    public function index()
    {
        $data = [
            'header' => '',
            'orderCount' => $this->orderModel->countAll('WHERE status = 0','')->count,
            'donorCount' => $this->orderModel->countAll('','','donors')->count,
            'contactsCount' => $this->orderModel->countAll('WHERE status = 1','','contacts')->count,
            'projectsCount' => $this->orderModel->countAll('','','projects')->count,
            'orders' => $this->orderModel->getAll('SELECT total, quantity, from_unixtime(create_date,"%Y-%m-%d") as create_date FROM orders WHERE status = 1 AND create_date <= ' . time() . ' AND create_date >= ' . (time() - 2592000) ." ORDER BY create_date DESC" ),
            'title' => 'لوحة التحكم',
            'footer' => ''
        ];
        $this->view('dashboard/index', $data);
    }
}
