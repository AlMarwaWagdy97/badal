<?php

/*
 * Copyright (C) 2024 Easy CMS 
 */

class QueueTable extends ModelAdmin
{
    public function __construct()
    {
        parent::__construct('queue_table');
    }

    public function addqueue($data){
        $this->db->query('INSERT INTO queue_table( order_id, substitute_id, is_send, status, modified_date, create_date)'
        . ' VALUES (:order_id, :substitute_id, :is_send, :status, :modified_date, :create_date)');
        // binding values
        $this->db->bind(':order_id', $data['order_id']);
        $this->db->bind(':substitute_id', $data['substitute_id']);
        $this->db->bind(':is_send', 0);
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
     * update status by order ID 
     * @param Array $order id 
     * @param Array $status 
     */
    public function updateStatus($order, $status = 0){
        $query = 'UPDATE `queue_table` SET   `status` = :status, `modified_date` = :modified_date WHERE `order_id`= :order_id';
        $this->db->query($query);
        $this->db->bind(':order_id', $order);
        $this->db->bind(':status', $status);
        $this->db->bind(':modified_date', time());
        if ($this->db->excute()) {
            return true;
        } else {
            return false;
        }
    }

     /**
     * update Send by  ID 
     * @param Array $order id 
     * @param Array $status 
     */
    public function updateSend($queue_table_id, $is_send = 1){
        $query = 'UPDATE `queue_table` SET `is_send` = :is_send, `modified_date` = :modified_date WHERE `queue_table_id`= :queue_table_id';
        $this->db->query($query);
        $this->db->bind(':queue_table_id', $queue_table_id);
        $this->db->bind(':is_send', $is_send);
        $this->db->bind(':modified_date', time());
        if ($this->db->excute()) {
            return true;
        } else {
            return false;
        }
    }

    // get all the subsitude that donot exist in queue and didnit reach to the limit orders to notify them
    public function getAvailableSubsitudes(){
        $query = "SELECT 
                    st.full_name, 
                    st.substitute_id
                FROM 
                    substitutes st
                LEFT JOIN (
                    SELECT 
                        substitute_id, 
                        COUNT(*) AS trx
                    FROM 
                        badal_orders bo
                    WHERE DATE(FROM_UNIXTIME(bo.start_at)) BETWEEN DATE_FORMAT(CURDATE(), '%Y-%m-01') AND LAST_DAY(CURDATE())
                    GROUP BY 
                        substitute_id
                ) bo_counts ON st.substitute_id = bo_counts.substitute_id
                WHERE 
                    COALESCE(bo_counts.trx, 0) < st.limitation
                and st.status = 1
                and st.substitute_id NOT IN ( SELECT substitute_id FROM queue_table WHERE is_send = 0 AND `status` = 1 );";


        $this->db->query($query);
        $this->db->excute();
        return $this->db->resultSet();
    }

    // get the 10 top from the queue table
    public function getTopTenQueue() {
        $query = "SELECT * 
                    FROM queue_table qt
                    LEFT JOIN substitutes st ON qt.substitute_id =  st.substitute_id
                    WHERE qt.is_send = 0 AND qt.`status` = 1
                    LIMIT 1";
        $this->db->query($query);
        $this->db->excute();
        return $this->db->resultSet();
    }


    // Notfication message
    public function notifyMessage(){
        return "يوجد طلبات جديدة
        في حال رغبتكم في تنفيذ الطلب يرجى دخول التطبيق ";
    }


    // notify the subsitudes send (SMS , E-mail & Whatsapp)
    public function notify($info){
        $message = $this->notifyMessage();
        // send SMS
        $sms = $this->SMS($info->phone, $message);
        // send email
        $email = $this->Email($info->email, "طلب جديد", nl2br($message));
        // send whatsapp
        $whatsapp = $this->sendWhatsApp($info->phone, "badal_notify");     

        return true;
    }
    
}