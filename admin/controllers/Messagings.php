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

class Messagings extends ControllerAdmin
{

    private $orderModel;
    // private $messagingModel;

    public function __construct()
    {
        $this->orderModel = $this->model('Order');
    }

    public function index()
    {
        redirect('dashboard');
    }
    /**
     * sendning message to member /members
     *
     * @return void
     */
    public function send()
    {
        if (!isset($_POST['members'])) {
            redirect('dashboard');
        }
        $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        // get members data
        $members = $this->orderModel->getUsersData($_POST['members']);
        if (isset($_POST['SMS'])) { // if message through sms            
            foreach ($members as $member) {
                $mobile = str_replace(' ', '', $member->mobile);
                $message = str_replace('[[name]]', $member->donor, $_POST['message']); // replace name string with user name
                $message = str_replace('[[identifier]]', $member->order_identifier, $message); // replace name string with user name
                $message = str_replace('[[total]]', $member->total, $message); // replace name string with user name
                $message = str_replace('[[project]]', $member->projects, $message); // replace name string with user name
                $this->orderModel->SMS($mobile, $message);
            }
            flash('order_msg', 'تم الارسال بنجاح ');
            redirect('orders');
        } elseif (isset($_POST['Email'])) { // if message through Email
            foreach ($members as $member) {
                $email = str_replace(' ', '', $member->email);
                $message = str_replace('[[name]]', $member->donor, $_POST['message']); // replace name string with user name
                $message = str_replace('[[identifier]]', $member->order_identifier, $message); // replace name string with user name
                $message = str_replace('[[total]]', $member->total, $message); // replace name string with user name
                $message = nl2br(str_replace('[[project]]', $member->projects, $message)); // replace name string with user name
                $result = $this->orderModel->Email($email, $_POST['subject'], $message); // sending Email
                if ($result) {
                    flash('order_msg', 'تم الارسال بنجاح   ');
                } else {
                    flash('order_msg', 'هناك خطأ ما يرجي المحاولة لاحقا', 'alert alert-danger');
                }
                redirect('orders');
            }
        }
    }
}
