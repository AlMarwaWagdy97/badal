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

class Badalrituals extends ControllerAdmin
{

    private $model;

    public function __construct()
    {
        $this->model = $this->model('Badalritual');
    }


    /**
     * show record by order_id
     * @param integer $order_id
     */
    public function show($order_id)
    {
        if (!$Badalrituals = $this->model->getBadalRituals($order_id)) {
            flash('badalorder_msg', ' لا يوجد مناسك لهذا الطلب', 'alert alert-danger');
            redirect('badalorders');
        }
        $data = [
            'page_title' => ' مناسك الطلب',
            'Badalrituals' => $Badalrituals,
        ];
        $this->view('badalrituals/show', $data);
    }



}
