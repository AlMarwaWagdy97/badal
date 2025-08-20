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

class Notifications extends ControllerAdmin
{

    private $notificationModel;

    public function __construct()
    {
        $this->notificationModel = $this->model('Notification');
    }

    /**
     * loading index view with latest notifications
     */
    public function index($current = '', $perpage = 50)
    {
        // get notifications
        $cond = 'WHERE status <> 2 ';
        $bind = [];

        //check user action if the form has submitted
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // sanitize POST array
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

            //handling Delete
            if (isset($_POST['delete'])) {
                if (isset($_POST['record'])) {
                    if ($row_num = $this->notificationModel->deleteById($_POST['record'], 'notification_id')) {
                        flash('notification_msg', 'تم حذف ' . $row_num . ' بنجاح');
                    } else {
                        flash('notification_msg', 'لم يتم الحذف', 'alert alert-danger');
                    }
                }

                redirect('notifications');
            }
        }

        //handling search
        $searches = $this->notificationModel->searchHandling(['subject', 'message', 'status'], $current);
        $cond .= $searches['cond'];
        $bind = $searches['bind'];

        // get all records count after search and filtration
        $recordsCount = $this->notificationModel->allNotificationsCount($cond, $bind);
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
        //get all records for current notification
        $notifications = $this->notificationModel->getNotifications($cond, $bind, $limit, $bindLimit);

        $data = [
            'current' => $current,
            'perpage' => $perpage,
            'header' => '',
            'title' => 'رسائل التنبيهات',
            'notifications' => $notifications,
            'recordsCount' => $recordsCount->count,
            'footer' => '',
        ];
        $this->view('notifications/index', $data);
    }

    /**
     * adding new notification
     */
    public function add()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // sanitize POST array
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

            $data = [
                'page_title' => 'رسائل التنبيهات',
                'subject' => trim($_POST['subject']),
                'message' => trim($_POST['message']),
                'types' => ['شكوي', 'طلب', 'اقتراح', 'استفسار'],
                'subject_error' => '',
                'message_error' => '',
                'full_name_error' => '',
            ];
            // validate subject
            !(empty($data['subject'])) ?: $data['subject_error'] = 'هذا الحقل مطلوب';
            // validate message
            !(empty($data['message'])) ?: $data['message_error'] = 'هذا الحقل مطلوب';

            //make sure there is no errors
            if (empty($data['subject_error']) && empty($data['message_error'])) {
                //validated
                if ($this->notificationModel->addNotification($data)) {
                    // run API request for push notification
                    $this->notificationModel->sendNotification($data);
                    flash('notification_msg', 'تم الحفظ بنجاح');
                    redirect('notifications');
                } else {
                    flash('notification_msg', 'هناك خطأ ما حاول مرة اخري', 'alert alert-danger');
                }
            } else {
                //load the view with error
                $this->view('notifications/add', $data);
            }
        } else {
            $data = [
                'page_title' => 'رسائل التنبيهات',
                'subject' => '',
                'message' => '',
                'subject_error' => '',
                'message_error' => '',
                'full_name_error' => '',
            ];
        }

        //loading the add notification view
        $this->view('notifications/add', $data);
    }

    /**
     * update notification
     * @param integer $id
     */
    public function edit($id)
    {
        $id = (int) $id;
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // sanitize POST array
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

            $data = [
                'notification_id' => $id,
                'page_title' => 'رسائل التنبيهات',
                'subject' => trim($_POST['subject']),
                'message' => trim($_POST['message']),
                'full_name' => trim($_POST['full_name']),
                'city' => trim($_POST['city']),
                'email' => trim($_POST['email']),
                'phone' => trim($_POST['phone']),
                'type' => trim($_POST['type']),
                'types' => ['شكوي', 'طلب', 'اقتراح', 'استفسار'],
                'status' => '',
                'status_error' => '',
                'subject_error' => '',
                'message_error' => '',
                'full_name_error' => '',
            ];

            // validate subject
            !(empty($data['subject'])) ?: $data['subject_error'] = 'هذا الحقل مطلوب';
            // validate message
            !(empty($data['message'])) ?: $data['message_error'] = 'هذا الحقل مطلوب';
            // validate full_name
            !(empty($data['full_name'])) ?: $data['full_name_error'] = 'هذا الحقل مطلوب';

            // validate status
            if (isset($_POST['status'])) {
                $data['status'] = trim($_POST['status']);
            }
            if ($data['status'] == '') {
                $data['status_error'] = 'من فضلك اختار حالة النشر';
            }
            // make sure there is no errors
            if (empty($data['status_error']) && empty($data['subject_error']) && empty($data['message_error']) && empty($data['full_name_error'])) {
                //validated
                if ($this->notificationModel->updateNotification($data)) {
                    flash('notification_msg', 'تم التعديل بنجاح');
                    isset($_POST['save']) ? redirect('notifications/edit/' . $id) : redirect('notifications');
                } else {
                    flash('notification_msg', 'هناك خطأ ما حاول مرة اخري', 'alert alert-danger');
                }
            } else {
                //load the view with error
                $this->view('notifications/edit', $data);
            }
        } else {
            // featch notification
            if (!$notification = $this->notificationModel->getNotificationById($id)) {
                flash('notification_msg', 'هناك خطأ ما هذه الصفحة غير موجوده او ربما اتبعت رابط خاطيء ', 'alert alert-danger');
                redirect('notifications');
            }

            $data = [
                'page_title' => 'رسائل التنبيهات',
                'notification_id' => $id,
                'subject' => $notification->subject,
                'message' => $notification->message,
                'full_name' => $notification->full_name,
                'city' => $notification->city,
                'email' => $notification->email,
                'phone' => $notification->phone,
                'types' => ['شكوي', 'طلب', 'اقتراح', 'استفسار'],
                'type' => $notification->type,
                'status' => $notification->status,
                'status_error' => '',
                'subject_error' => '',
                'message_error' => '',
                'full_name_error' => '',
            ];
            $this->view('notifications/edit', $data);
        }
    }

    /**
     * showing notification details
     * @param integer $id
     */
    public function show($id)
    {
        if (!$notification = $this->notificationModel->getNotificationById($id)) {
            flash('notification_msg', 'هناك خطأ ما هذه الصفحة غير موجوده او ربما اتبعت رابط خاطيء ', 'alert alert-danger');
            redirect('notifications');
        }
        $this->notificationModel->publishById([$id], 'notification_id');
        $data = [
            'page_title' => 'رسائل التنبيهات',
            'notification' => $notification,
        ];
        $this->view('notifications/show', $data);
    }

    /**
     * delete record by id
     * @param integer $id
     */
    public function delete($id)
    {
        if ($row_num = $this->notificationModel->deleteById([$id], 'notification_id')) {
            flash('notification_msg', 'تم حذف ' . $row_num . ' بنجاح');
        } else {
            flash('notification_msg', 'لم يتم الحذف', 'alert alert-danger');
        }
        redirect('notifications');
    }

    /**
     * publish record by id
     * @param integer $id
     */
    public function publish($id)
    {
        $data =  $this->notificationModel->getNotificationById($id);

        if ($this->notificationModel->sendNotification(['subject' => $data->subject, 'message' => $data->message])) {
            flash('notification_msg', 'تم اعادة الارسال بنجاح');
        } else {
            flash('notification_msg', 'هناك خطأ ما يرجي المحاولة لاحقا', 'alert alert-danger');
        }
        redirect('notifications');
    }

    /**
     * publish record by id
     * @param integer $id
     */
    public function unpublish($id)
    {
        if ($row_num = $this->notificationModel->unpublishById([$id], 'notification_id')) {
            flash('notification_msg', 'تم تعليم كا غير مقروءة ' . $row_num . ' بنجاح');
        } else {
            flash('notification_msg', 'هناك خطأ ما يرجي المحاولة لاحقا', 'alert alert-danger');
        }
        redirect('notifications');
    }
}
