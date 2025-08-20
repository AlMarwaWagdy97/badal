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

class Notification extends ModelAdmin
{

    public function __construct()
    {
        parent::__construct('notifications');
    }

    /**
     * get all notifications from datatbase
     *
     * @param  string $cond
     * @param  array $bind
     * @param  string $limit
     * @param  mixed $bindLimit
     *
     * @return object notifications data
     */
    public function getNotifications($cond = '', $bind = '', $limit = '', $bindLimit = 50)
    {
        $query = 'SELECT * FROM notifications ' . $cond . ' ORDER BY notifications.create_date DESC ';

        return $this->getAll($query, $bind, $limit, $bindLimit);
    }

    /**
     * get count of all records
     * @param type $cond
     * @return type
     */
    public function allNotificationsCount($cond = '', $bind = '')
    {
        return $this->countAll($cond, $bind);
    }

    /**
     * insert new notifications
     * @param array $data
     * @return boolean
     */
    public function addNotification($data)
    {
        $this->db->query('INSERT INTO notifications( subject, message, status, modified_date, create_date)'
            . ' VALUES (:subject, :message,  :status, :modified_date, :create_date)');
        // binding values
        $this->db->bind(':subject', $data['subject']);
        $this->db->bind(':message', $data['message']);
        $this->db->bind(':status', 1);
        $this->db->bind(':create_date', time());
        $this->db->bind(':modified_date', time());

        // excute
        if ($this->db->excute()) {
            return true;
        } else {
            return false;
        }
    }



    /**
     * get notification by id
     * @param integer $id
     * @return object notification data
     */
    public function getNotificationById($id)
    {
        return $this->getById($id, 'notification_id');
    }


    public function sendNotification($data)
    {
        $sent = sendPush($data['subject'], $data['message']);
        if (!$sent) {
            flash('notification_msg', 'هناك خطأ ما حاول مرة اخري' . $sent, 'alert alert-danger');
        } else {
            return true;
        }
    }
}
