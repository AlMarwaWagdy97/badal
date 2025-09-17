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

class Order extends ModelAdmin
{

    public function __construct()
    {
        parent::__construct('orders');
    }

    /**
     * get all orders from datatbase 
     *
     * @param  string $cond
     * @param  array $bind
     * @param  string $limit
     * @param  mixed $bindLimit
     *
     * @return object orders data
     */
    public function getOrders($cond = '', $bind = '', $limit = '', $bindLimit = 50)
    {
        $query = 'SELECT ord.*, payment_methods.title AS payment_method, donors.full_name AS donor, donors.mobile, donors.email,
        (SELECT name FROM statuses WHERE ord.status_id = statuses.status_id) AS status_name,
        (SELECT name FROM stores WHERE ord.store_id = stores.store_id) AS store
        FROM orders ord use INDEX (create_date) , donors, payment_methods ' . $cond . ' ORDER BY ord.create_date DESC ';
         

         
        return $this->getAll($query, $bind, $limit, $bindLimit);
    }

    /**
     * getAll data from database
     *
     * @param  string $cond
     * @param  array $bind
     * @param  string $limit
     * @param  array $bindLimit
     *
     * @return Object
     */
    public function getAll($query, $bind = '', $limit = '', $bindLimit = '')
    {
        $this->db->query($query . $limit);
        if (!empty($bind)) {
            foreach ($bind as $key => $value) {
                $this->db->bind($key, $value);
            }
        }
        if (!empty($bindLimit)) {
            foreach ($bindLimit as $key => $value) {
                $this->db->bind($key, $value);
            }
        }
        return $this->db->resultSet();
    }
    /**
     * get count of all records
     * @param type $cond
     * @return type
     */
    public function allOrdersCount($cond = '', $bind = [])
    {
        $query = 'SELECT count(*) as count FROM ' . $this->table . ' ord ' . $cond;
        $this->db->query($query);
        if (!empty($bind)) {
            foreach ($bind as $key => $value) {
                $this->db->bind($key, $value);
            }
        }
        $this->db->excute();
        return $this->db->single();
    }


    /**
     * updateOrder
     * @param  array $data
     * @return void
     */
    public function updateOrder($data)
    {
        $query = 'UPDATE orders SET API_status = "updated", quantity =:quantity, total = :total, payment_method_id = :payment_method_id, status_id = :status_id, status = :status, modified_date = :modified_date';
        (empty($data['banktransferproof'])) ? null : $query .= ', banktransferproof = :banktransferproof';
        $query .= ' WHERE order_id = :order_id';
        $this->db->query($query);
        // binding values
        $this->db->bind(':order_id', $data['order_id']);
        $this->db->bind(':total', $data['total']);
        $this->db->bind(':quantity', $data['quantity']);
        $this->db->bind(':payment_method_id', $data['payment_method_id']);
        $this->db->bind(':status_id', $data['status_id']);
        $this->db->bind(':status', $data['status']);
        $this->db->bind(':modified_date', time());
        empty($data['banktransferproof']) ? null : $this->db->bind(':banktransferproof', $data['banktransferproof']);

        // excute
        if ($this->db->excute()) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * get order by id
     * @param integer $id
     * @return object order data
     */
    public function getOrderById($id)
    {
        $query = 'SELECT orders.*, payment_methods.title FROM orders, payment_methods WHERE orders.payment_method_id = payment_methods.payment_id AND order_id = :order_id ORDER BY create_date DESC ';
        $this->db->query($query);
        $this->db->bind(':order_id', $id);
        $row = $this->db->single();
        return $row;
    }

    /**
     * get list of projects
     * @param string $cond
     * @return object projects list
     */
    public function projectsList($cond = '')
    {
        $query = 'SELECT project_id, name FROM projects  ' . $cond . ' ORDER BY create_date DESC ';
        $this->db->query($query);
        $results = $this->db->resultSet();
        return $results;
    }
    /**
     * get list of stores
     * @param string $cond
     * @return object stores list
     */
    public function stores($cond = '')
    {
        $query = 'SELECT store_id, name FROM stores  ' . $cond . ' ORDER BY create_date DESC ';
        $this->db->query($query);
        $results = $this->db->resultSet();
        return $results;
    }

    /**
     * get list of statuses List
     * @param string $cond
     * @return object statuses list
     */
    public function statusesList($cond = '')
    {
        $query = 'SELECT status_id, name FROM statuses  ' . $cond . ' ORDER BY create_date DESC ';
        $this->db->query($query);
        $results = $this->db->resultSet();
        return $results;
    }
    /**
     * get list of orders tags
     * @param string $cond
     * @return object tags list
     */
    public function statusesListByOrder($order_id)
    {
        $query = 'SELECT statuses.tag_id,  statuses.name FROM tags_orders ,statuses WHERE tags_orders.order_id = ' . $order_id . ' and statuses.tag_id = tags_orders.tag_id ';
        $this->db->query($query);
        $results = $this->db->resultSet(PDO::FETCH_COLUMN);
        return $results;
    }

    /**
     * get list of pamyment methods
     * @param string $cond
     * @return object categories list
     */
    public function paymentMethodsList($cond = '')
    {
        $query = 'SELECT payment_id, title FROM payment_methods  ' . $cond . ' ORDER BY create_date DESC ';
        $this->db->query($query);
        $results = $this->db->resultSet();
        return $results;
    }

    /**
     * get last Id
     * @return integr
     */
    public function lastId()
    {
        return $this->db->lastId();
    }

    /**
     * set Order Tages
     *
     * @param  mixed $order_ids
     * @param  mixed $tag_id
     * @return void
     */
    public function setOrderStatuses($order_ids, $status_id)
    {
        return $this->setWhereIn('status_id', $status_id, 'order_id', $order_ids);
    }

    public function clearAllStatusesByOrdersId($order_ids)
    {
        return $this->setWhereIn('status_id', null, 'order_id', $order_ids);
    }


    /**
     * get users informations to contact them
     *
     * @param [array] $order_ids
     * @return object
     */
    public function getUsersData($in)
    {
        //get the id in PDO form @Example :id1,id2
        for ($index = 1; $index <= count($in); $index++) {
            $id_num[] = ":in" . $index;
        }
        //setting the query
        $this->db->query('SELECT ord.order_id, ord.total, ord.app, ord.order_identifier, dnr.full_name as donor, dnr.mobile, dnr.email, dnr.donor_id,
        (select GROUP_CONCAT( DISTINCT projects.name SEPARATOR " , ") from projects, donations dn where ord.order_id = dn.order_id AND dn.project_id = projects.project_id) as projects,
        (select GROUP_CONCAT( DISTINCT projects.project_id SEPARATOR ",") from projects, donations dn where ord.order_id = dn.order_id AND dn.project_id = projects.project_id) as projectsIds
        FROM orders ord , donors dnr  WHERE dnr.donor_id = ord.donor_id AND ord.order_id IN (' . implode(',', $id_num) . ')');
        //loop through the bind function to bind all the IDs
        foreach ($in as $key => $value) {
            $this->db->bind(':in' . ($key + 1), $value);
        }
        if ($this->db->excute()) {
            return $this->db->resultSet();
        } else {
            return false;
        }
    }

    /**
     * canceled one or more records by id
     * @param Array $ids
     * @param string colomn id
     * @return boolean or row count
     */
    public function canceledById($ids, $where)
    {
        //get the id in PDO form @Example :id1,id2
        for ($index = 1; $index <= count($ids); $index++) {
            $id_num[] = ":id" . $index;
        }
        //setting the query
        $this->db->query('UPDATE ' . $this->table . ' SET status = 4 WHERE ' . $where . ' IN (' . implode(',', $id_num) . ')');
        //loop through the bind function to bind all the IDs
        foreach ($ids as $key => $id) {
            $this->db->bind(':id' . ($key + 1), $id);
        }
        if ($this->db->excute()) {
            return $this->db->rowCount();
        } else {
            return false;
        }
    }

    /**
     * waiting one or more records by id
     * @param Array $ids
     * @param string colomn id
     * @return boolean or row count
     */
    public function waitingById($ids, $where)
    {
        //get the id in PDO form @Example :id1,id2
        for ($index = 1; $index <= count($ids); $index++) {
            $id_num[] = ":id" . $index;
        }
        //setting the query
        $this->db->query('UPDATE ' . $this->table . ' SET status = 3 WHERE ' . $where . ' IN (' . implode(',', $id_num) . ')');
        //loop through the bind function to bind all the IDs
        foreach ($ids as $key => $id) {
            $this->db->bind(':id' . ($key + 1), $id);
        }
        if ($this->db->excute()) {
            return $this->db->rowCount();
        } else {
            return false;
        }
    }

    /**
     * send Confirmation email and sms to users
     *
     * @param [array] $in
     * @return void
     */
    public function sendConfirmation($in)
    {
        $userData = $this->getUsersData($in); // loading data required to send sms 
        $notificationsSetting = $this->getSettings('notifications'); // loading sending settings
        $options = json_decode($notificationsSetting->value);
        $notificationsBadal = $this->getSettings('badal_notifications'); // loading sending badal settings
        foreach ($userData as $send) {
            if($send->app == "badal"){
                $options = json_decode($notificationsBadal->value);
            }else{
                $options = json_decode($notificationsSetting->value);
            }
            if ($options->confirm_enabled) { // check if email confirmation is enabled
                $message = str_replace('[[name]]', $send->donor, $options->confirm_msg); // replace name string with user name
                $message = str_replace('[[identifier]]', $send->order_identifier, $message); // replace identifier string with order identifier
                $message = str_replace('[[total]]', $send->total, $message); // replace total string with order total
                $message = str_replace('[[project]]', $send->projects, $message); // replace name string with project
                $message = str_replace('[[link]]',URLROOT .'/invoices/show/' . orderIdentifier($send->order_id)??"", $message); // replace link string with order invoices 

                if (!empty($send->email)) {
                    $this->Email($send->email, $options->confirm_subject, nl2br($message));
                }
            }
            if ($options->confirm_sms) { // check if SMS confirmation is enabled
                $message = str_replace('[[name]]', $send->donor, $options->confirm_sms_msg); // replace name string with user name
                $message = str_replace('[[identifier]]', $send->order_identifier, $message); // replace identifier string with order identifier
                $message = str_replace('[[total]]', $send->total, $message); // replace total string with order total
                $message = str_replace('[[project]]', $send->projects, $message); // replace name string with project
                $message = str_replace('[[link]]',URLROOT .'/invoices/show/' . orderIdentifier($send->order_id)??"", $message); // replace link string with order invoices 

                if (!empty($send->mobile)) {
                    $this->SMS($send->mobile, $message);
                }
            }
            if ($send->app == 'kafara') { // check if SMS confirmation is enabled
                $message = str_replace('[[name]]', $send->donor, $options->confirm_sms_msg); // replace name string with user name
                $message = str_replace('[[identifier]]', $send->order_identifier, $message); // replace identifier string with order identifier
                $message = str_replace('[[total]]', $send->total, $message); // replace total string with order total
                $message = str_replace('[[project]]', $send->projects, $message); // replace name string with project
                sendPush('تأكيد الطلب ', $message, $send->donor_id);
            }

            //  check if special message -----------------------------------
            $specialsetting = json_decode($this->getSettings('specialMessages')->value); // loading sending settings
            if ($specialsetting->specialenabled == 1) {
                $intersectPeojects = array_intersect(explode(',', $send->projectsIds), json_decode($specialsetting->projects) ?? []);
                if (count($intersectPeojects)) {
                    $project_selected = $this->getProjectsByIds(implode(',', $intersectPeojects));
                    $specialData = [
                        'donor' => $send->donor,
                        'identifier' => $send->order_identifier,
                        'total' => $send->total,
                        'projects' => $project_selected->names,
                        'link' => URLROOT .'/invoices/show/' . orderIdentifier($send->order_id),
                    ];
                    $this->NotficationsWhatsApp($send->mobile, $specialData, 'special_confirm');
                }
            }
            // if (!(count(array_intersect(explode(',', $send->projectsIds), json_decode($specialsetting->projects) ?? [])) == count(@$_SESSION['cart']['items'] ?? []))) {

                // send whatsapp confirm order
                if (!empty($send->mobile)) {
                    $this->ConfirmedOrdersApp($send->mobile,  $send->donor,  $send); #$to, $name, $order, $amount, $projects
                }
            // }
        }
    }

    /**
     * get project by names
     *
     * @param [int] $id
     * @return object
     */
    public function getProjectsByIds($ids)
    {
        $ids = str_replace(',', '","', $ids);
        $query = 'SELECT GROUP_CONCAT( DISTINCT projects.name SEPARATOR " , ") AS names FROM `projects` WHERE  `project_id` IN ("' . $ids . '") AND status <> 2 ORDER BY create_date DESC ';
        $this->db->query($query);
        return $this->db->single();
    }

    /**
     * get donations by order id
     *
     * @param [int] $id
     * @return object
     */
    public function getDonationsByOrderId($id)
    {
        $query = 'SELECT donations.*, projects.name as project FROM donations, projects WHERE donations.project_id = projects.project_id AND order_id = :order_id AND donations.status <> 2 ORDER BY create_date DESC ';
        $this->db->query($query);
        $this->db->bind(':order_id', $id);
        $results = $this->db->resultSet();
        return $results;
    }

    /**
     * change donations status accourding to order
     *
     * @param [array] $ids
     * @param [string] $where
     * @return void
     */
    public function publishDonations($ids, $where)
    {
        //get the id in PDO form @Example :id1,id2
        for ($index = 1; $index <= count($ids); $index++) {
            $id_num[] = ":id" . $index;
        }
        //setting the query
        $this->db->query('UPDATE donations SET status = 1 WHERE ' . $where . ' IN (' . implode(',', $id_num) . ')');
        //loop through the bind function to bind all the IDs
        foreach ($ids as $key => $id) {
            $this->db->bind(':id' . ($key + 1), $id);
        }
        if ($this->db->excute()) {
            return $this->db->rowCount();
        } else {
            return false;
        }
    }
    /**
     * change donations status accourding to order
     * @param Array $ids
     * @param string colomn id
     * @return boolean or row count
     */
    public function unpublishDonations($ids, $where)
    {
        //get the id in PDO form @Example :id1,id2
        for ($index = 1; $index <= count($ids); $index++) {
            $id_num[] = ":id" . $index;
        }
        //setting the query
        $this->db->query('UPDATE donations SET status = 0 WHERE ' . $where . ' IN (' . implode(',', $id_num) . ')');
        //loop through the bind function to bind all the IDs
        foreach ($ids as $key => $id) {
            $this->db->bind(':id' . ($key + 1), $id);
        }
        if ($this->db->excute()) {
            return $this->db->rowCount();
        } else {
            return false;
        }
    }

    /**
     * export selected orders 
     *
     * @param array $records
     * @return export
     */
    public function exportOrders($records)
    {
        //get the id in PDO form @Example :id1,id2
        for ($index = 1; $index <= count($records); $index++) {
            $id_num[] = ":id" . $index;
        }
        $query = 'SELECT ord.*, payment_methods.title AS payment_method, donors.full_name AS donor, donors.mobile, donors.email,
        from_unixtime(ord.create_date) as create_date, from_unixtime(ord.modified_date) as modified_date ,
        CONCAT("' . URLROOT . '/media/files/banktransfer/", `banktransferproof`) as banktransferproof,
        (SELECT name FROM statuses WHERE ord.status_id = statuses.status_id) AS status_name,
        (SELECT name FROM stores WHERE ord.store_id = stores.store_id) AS store
        FROM orders ord , donors, payment_methods 
        WHERE ord.status <> 2 AND donors.donor_id = ord.donor_id AND ord.payment_method_id = payment_methods.payment_id 
        AND ord.order_id IN (' . implode(',', $id_num) .  ') ORDER BY ord.create_date DESC ';
        $this->db->query($query);
        foreach ($records as $key => $id) {
            $this->db->bind(':id' . ($key + 1), $id);
        }
        $results = $this->db->resultSet();
        $data[] = [
            "order_id" => "order_id",
            "order_identifier" => "الرقم التعريفي",
            "total" => "المجموع",
            "quantity" => "الكمية",
            "payment_method_id" => "payment_method_id",
            "payment_method_key" => "وسيلة الدفع",
            "hash" => "hash",
            "banktransferproof" => "تأكيد التحويل البنكي",
            "gift" => "الاهداء",
            "gift_data" => "بيانات الاهداء",
            "meta" => "رد payfort",
            "projects" => "المشروعات",
            "projects_id" => "projects_id",
            "donor_id" => "donor_id",
            "store_id" => "store_id",
            "API_status" => "APIحالة ال ",
            "status_id" => "وسم الحالة",
            "donor_name" => "اسم طالب الخدمة",
            "status" => "status",
            "modified_date" => "عدل في",
            "create_date" => "اضيف في",
            "payment_method" => "وسيلة الطلب",
            "donor" => "طلب بأسم",
            "mobile" => "الجوال",
            "email" => "البريد الالكتروني",
            "status_name" => "وسم الحالة ",
            "store" => "المتجر الفرعي",
        ];
        $results = array_merge($data, $results);
        $this->exportToExcel($results);
    }

    /**
     * export selected orders 
     *
     * @param array $records
     * @return export
     */
    public function exportAllOrders()
    {
        if ($_SESSION['search']) {
            $search = $_SESSION['search'];
            $total =  $this->allOrdersCount(", donors, payment_methods " . $_SESSION['search']['cond'], $_SESSION['search']['bind']);

            if ($total->count > 20000) {
                return false;
            }
            // $results = $this->getOrders($search['cond'], $search['bind'], '', '');
            $results = $this->getOrdersExport($search['cond'], $search['bind'], '', '');
      
            $data[] = [
                "order_id" => "order_id",
                "order_identifier" => "الرقم التعريفي",
                "quantity" => "الكمية",
                "total" => "المجموع",
                "payment_method_key" => "وسيلة الدفع",
                "projects" => "المشروعات",
                "donor_name" => "اسم طالب الخدمة",
                "mobile" => "الجوال",
                "email" => "البريد الالكتروني",
                "status" => "الحاله",
                "create_date" => "تاريخ الإنشاء",
                "status_name" => "وسم الحالة ",
                "store" => "المتجر الفرعي",

                // "payment_method_id" => "payment_method_id",
                // "hash" => "hash",
                // "banktransferproof" => "تأكيد التحويل البنكي",
                // "gift" => "الاهداء",
                // "gift_data" => "بيانات الاهداء",
                // "meta" => "رد payfort",
                // "projects_id" => "projects_id",
                // "donor_id" => "donor_id",
                // "store_id" => "store_id",
                // "API_status" => "APIحالة ال ",
                // "status_id" => "وسم الحالة",
                // "donor_name" => "اسم المطلب",
                // "modified_date" => "عدل في",
                // "create_date" => "اضيف في",
                // "payment_method" => "وسيلة الطلب",
                // "donor" => "طلب بأسم",
              
            ];
            $results = array_merge($data, $results);
            $this->exportToExcel($results);
        }
    }

    /**
     * get all orders from datatbase 
     *
     * @param  string $cond
     * @param  array $bind
     * @param  string $limit
     * @param  mixed $bindLimit
     *
     * @return object orders data
     */
    public function getOrdersExport($cond = '', $bind = '', $limit = '', $bindLimit = 50)
    {
        $query = 'SELECT ord.order_id ,ord.order_identifier ,ord.quantity ,ord.total , payment_methods.title AS payment_method
            ,payment_methods.title AS payment_method, ord.projects
            , donors.full_name AS donor, donors.mobile, donors.email,
            ord.status ,from_unixtime(ord.create_date) as create_date,
        
        (SELECT name FROM statuses WHERE ord.status_id = statuses.status_id) AS status_name,
        (SELECT name FROM stores WHERE ord.store_id = stores.store_id) AS store
        -- ,(select GROUP_CONCAT( DISTINCT projects.name SEPARATOR " , ") from projects, donations where ord.order_id = donations.order_id AND donations.project_id = projects.project_id) as projects
        FROM orders ord use INDEX (create_date) , donors, payment_methods ' . $cond . ' ORDER BY ord.create_date DESC ';
        return $this->getAll($query, $bind, $limit, $bindLimit);
    }


    /**
     * export selected orders 
     *
     * @param array $records
     * @return export
     */
    public function exportGifted($records)
    {
        //get the id in PDO form @Example :id1,id2
        for ($index = 1; $index <= count($records); $index++) {
            $id_num[] = ":id" . $index;
        }
        $query = 'SELECT gift_data, order_identifier, order_id, create_date FROM orders ord 
        WHERE  ord.order_id IN (' . implode(',', $id_num) .  ') ORDER BY ord.create_date DESC ';
        $this->db->query($query);
        foreach ($records as $key => $id) {
            $this->db->bind(':id' . ($key + 1), $id);
        }
        $results = $this->db->resultSet();
        foreach ($results as $order) {
            $order->gift_data = json_decode($order->gift_data);
            $orders[] = [
                "order_id" => $order->order_id,
                "order_identifier" => $order->order_identifier,
                "giver_name" => $order->gift_data->giver_name,
                "giver_number" => $order->gift_data->giver_number,
                "giver_email" => @$order->gift_data->giver_email,
                "giver_group" => $order->gift_data->giver_group,
                "card" => URLROOT . MEDIAFOLDER . @$order->gift_data->card,
                "create_date" => date('Y/ m/ d | H:i a', $order->create_date),
            ];
        }

        $data[] = [
            "order_id" => "order_id",
            "order_identifier" => "الرقم التعريفي",
            "giver_name" => "اسم المهدي اليه",
            "giver_number" => "رقم الجوال",
            "giver_email" => "البريد الالكتروني",
            "giver_group" => "الفئة",
            "card" => "كارت الاهداء",
            "create_date" => "تاريخ الاهداء",
        ];
        $results = array_merge($data, $orders);
        $this->exportToExcel($results);
    }
    /**
     * send gift card
     *
     * @param array $records
     * @return int|boolean
     */
    public function giftById($records)
    {
        //get the id in PDO form @Example :id1,id2
        for ($index = 1; $index <= count($records); $index++) {
            $id_num[] = ":id" . $index;
        }
        //setting the query
        $this->db->query('SELECT donors.mobile ,orders.* FROM orders, donors WHERE orders.donor_id = donors.donor_id AND gift = 1 AND  order_id IN (' . implode(',', $id_num) . ')');
        //loop through the bind function to bind all the IDs
        foreach ($records as $key => $id) {
            $this->db->bind(':id' . ($key + 1), $id);
        }
        $data = $this->db->resultSet();
        if (count($data) > 0) {
            //loading gift message from settings
            $count = 0;
            $gift = json_decode($this->getSettings('gift')->value); // loading sending settings
            foreach ($data as $order) {
                $gift_data = json_decode($order->gift_data);
                $card =  str_replace('.jpg', '', str_replace('/gifts/img_', URLROOT . '/gift/', $gift_data->card));
                $message = str_replace('[[giver_group]]', $gift_data->giver_group, $gift->msg); // replace name string with user name
                $message = str_replace('[[giver_name]]', $gift_data->giver_name, $message); // replace identifier string with order identifier
                $message = str_replace('[[card]]',  $card, $message); // replace total string with order total
                $message = str_replace('[[project]]', $order->projects, $message); // replace name string with project
                $message = str_replace('[[from_name]]', $order->donor_name, $message); // replace name string with project
                if (!empty($gift_data->giver_number)) {
                    $datawhats = [
                        'name'          => $gift_data->giver_name,
                        'donor_name'    => $order->donor_name,
                        'card'          => MEDIAURL . "/" . $gift_data->card,
                        'project'       => $order->projects,
                        'from_name'       => $order->donor_name,
                    ];
                    $this->NotficationsWhatsApp($gift_data->giver_number, $datawhats, 'gift_confirm');
                    $this->SMS($gift_data->giver_number, $message);
                    $count++;
                }
            }
            return $count;
        } else {
            return false;
        }
    }

    public function requestProof($records)
    {
        //get the id in PDO form @Example :id1,id2
        for ($index = 1; $index <= count($records); $index++) {
            $id_num[] = ":id" . $index;
        }
        //setting the query
        $this->db->query('SELECT donors.*, orders.hash, orders.order_identifier, orders.order_id FROM orders, donors 
                        WHERE orders.payment_method_id = 1 AND orders.hash IS NOT null 
                        AND orders.banktransferproof IS null AND orders.donor_id = donors.donor_id 
                        AND orders.order_id IN (' . implode(',', $id_num) . ') ');
        //loop through the bind function to bind all the IDs
        foreach ($records as $key => $id) {
            $this->db->bind(':id' . ($key + 1), $id);
        }
        $data = $this->db->resultSet();
        if (count($data) > 0) {
            //loading gift message from settings
            $count = 0;
            foreach ($data as $order) {
                $message = " $order->full_name   \n\tبرجاء تأكيد طلبكم رقم : $order->order_identifier \n\t من خلال رفع صورة تأكيد التحويل علي الرابط التالي \n\t "
                    . URLROOT . '/pages/bp/' . $order->order_id . "\n\t" . SITENAME;
                if (!empty($order->mobile)) $this->SMS($order->mobile, $message);
                $message =  "<p style='text-align:right;font-size:16px;line-height:34px;' >" . nl2br($message) . '<p>';
                if (!empty($order->email)) $this->Email($order->email, SITENAME .  ': طلب رفع اثبات التحويل البنكي ', $message);
                $count++;
            }
            return $count;
        } else {
            return false;
        }
    }


    /**
     * update badalorder status if order is badal  and 
     *
     * @param [array] $ids
     * @param [string] $where
     * @return void
     */
    public function updatebadal($ids, $status)
    {
        //get the id in PDO form @Example :id1,id2
        for ($index = 1; $index <= count($ids); $index++) {
            $id_num[] = ":id" . $index;
        }
        //setting the query
        $this->db->query("UPDATE badal_orders 
                            JOIN orders ON badal_orders.order_id = orders.order_id
                            SET badal_orders.status = :status
                            WHERE orders.order_id IN  (" . implode(',', $id_num) . ") 
                            AND orders.app = 'badal';");
        //loop through the bind function to bind all the IDs
        foreach ($ids as $key => $id) {
            $this->db->bind(':status', $status);
            $this->db->bind(':id' . ($key + 1), $id);
        }
        if ($this->db->excute()) {
            return $this->db->rowCount();
        } else {
            return false;
        }
    }


    /**
     * update offer status if order is badal  and 
     *
     * @param [array] $ids
     * @param [string] $where
     * @return void
     */
    public function updateOfferByBadal($ids, $status)
    {
        //get the id in PDO form @Example :id1,id2
        for ($index = 1; $index <= count($ids); $index++) {
            $id_num[] = ":id" . $index;
        }
        // dd($ids); //85684
        //setting the query
        $this->db->query("UPDATE `badal_offers` 
                            JOIN `badal_orders` ON `badal_offers`.offer_id = `badal_orders`.offer_id
                            SET `badal_offers`.status = :status
                            WHERE `badal_orders`.order_id IN ( SELECT `order_id` FROM `orders` WHERE  `order_id` IN  (" . implode(',', $id_num) .  " ) )");
        //loop through the bind function to bind all the IDs
        foreach ($ids as $key => $id) {
            $this->db->bind(':status', 1);
            $this->db->bind(':id' . ($key + 1), $id);
        }
        if ($this->db->excute()) {
            return $this->db->rowCount();
        } else {
            return false;
        }
    }


     /**
     * get substitutes
     *
     * @return object
     */
    public function getSubstitutes()
    {
        $query = 'SELECT `email`, `phone`, `full_name`,
         (SELECT `donors`.donor_id FROM `donors` WHERE `donors`.mobile = `substitutes`.phone AND `donors`.`status` = 1  LIMIT 1) AS subsitude_donor_id
        FROM `substitutes`  WHERE `status` = 1; ';
        
        $this->db->query($query);
        return $this->db->resultSet();
    }


    /**
     * get Badal order from selected
     *
     * @return object
     */
    public function getBadalOrders($records)
    {

        for ($index = 1; $index <= count($records); $index++) {
            $id_num[] = ":id" . $index;
        }
        $query = 'SELECT * FROM orders ord 
                    WHERE  ord.order_id IN (' . implode(',', $id_num) .  ') AND `app` = "badal" ORDER BY ord.create_date DESC ';
        $this->db->query($query);
        foreach ($records as $key => $id) {
            $this->db->bind(':id' . ($key + 1), $id);
        }
        return $this->db->resultSet();
    }



    /**
     * get all orders from datatbase with subsitutes
     *
     * @param  string $cond
     * @param  array $bind
     * @param  string $limit
     * @param  mixed $bindLimit
     *
     * @return object orders data
     */
    public function getOrdersSubsitutes($cond = '', $bind = '', $limit = '', $bindLimit = 50)
    {
        $query = 'SELECT ord.*, ds.* ,payment_methods.title AS payment_method, donors.full_name AS donor, donors.mobile, donors.email,
        (SELECT name FROM statuses WHERE ord.status_id = statuses.status_id) AS status_name,
        (SELECT name FROM stores WHERE ord.store_id = stores.store_id) AS store,
        (SELECT rate FROM badal_review WHERE ds.badal_id = badal_review.badal_id) AS rate
        FROM orders ord , donors, payment_methods, badal_orders ds ' . $cond . ' ORDER BY ord.create_date DESC ';
        return $this->getAll($query, $bind, $limit, $bindLimit);
    }


    /**
     * export selected orders 
     *
     * @param array $records
     * @return export
     */
    public function exportSubsitutesOrders($records, $substitute_id)
    {
        //get the id in PDO form @Example :id1,id2
        for ($index = 1; $index <= count($records); $index++) {
            $id_num[] = ":id" . $index;
        }

        $query = 'SELECT ord.order_identifier, ord.total, donors.full_name AS donor, donors.mobile, donors.email,
                ds.behafeof, ds.relation, ds.language, ds.gender,
                ord.projects,    payment_methods.title AS payment_method,
                CONCAT("' . URLROOT . '/media/files/banktransfer/", `banktransferproof`) as banktransferproof,
                ord.hash, from_unixtime(ord.create_date) as create_date, from_unixtime(ord.modified_date) as modified_date ,
                ord.status,
                (SELECT rate FROM badal_review WHERE ds.badal_id = badal_review.badal_id) AS rate, 
                (SELECT name FROM statuses WHERE ord.status_id = statuses.status_id) AS status_name,
                (SELECT name FROM stores WHERE ord.store_id = stores.store_id) AS store
            FROM orders ord , donors, payment_methods, badal_orders ds 
            WHERE ord.status <> 2  
                AND donors.donor_id = ord.donor_id 
                AND ord.payment_method_id = payment_methods.payment_id 
                AND ord.order_id = ds.order_id AND ds.substitute_id = ' . $substitute_id . ' 
                AND ord.order_id IN (' . implode(',', $id_num) .  ') 
                ORDER BY ord.create_date DESC ';


        $this->db->query($query);
        foreach ($records as $key => $id) {
            $this->db->bind(':id' . ($key + 1), $id);
        }
        $results = $this->db->resultSet();
        $data[] = [
            "order_identifier" => "الرقم التعريفي",
            "total" => "المجموع",
            "donor" => "طلب بأسم",
            "mobile" => "الجوال",
            "email" => "البريد الاكتيروني",
            "behafeof" => "نيابة عن",
            "relation" => "الصفه",
            "language" => "اللغة",
            "gender" => "النوع",
            "projects" => "المشروعات",
            "payment_method" => " وسيلة الدفع",
            "banktransferproof" => "تأكيد التحويل البنكي",
            "hash" => "hash",
            "create_date" => "اضيف في",
            "modified_date" => " عدل في",
            "status" => "الحاله",
            "rate" => "التقيم",
            "status_name" => "وسم الحالة ",
            "store" => "المتجر الفرعي",
        ];
        $results = array_merge($data, $results);
        $this->exportToExcel($results);
    }


    /**
     * export selected orders 
     *
     * @param array $records
     * @return export
     */
    public function exportAllSubsitutesOrders($substitute_id)
    {
        if ($_SESSION['search']) {
            $query = 'SELECT ord.order_identifier, ord.total, donors.full_name AS donor, donors.mobile, donors.email,
            ds.behafeof, ds.relation, ds.language, ds.gender,
            ord.projects,    payment_methods.title AS payment_method,
            CONCAT("' . URLROOT . '/media/files/banktransfer/", `banktransferproof`) as banktransferproof,
            ord.hash, from_unixtime(ord.create_date) as create_date, from_unixtime(ord.modified_date) as modified_date ,
            ord.status,
            (SELECT rate FROM badal_review WHERE ds.badal_id = badal_review.badal_id) AS rate, 
            (SELECT name FROM statuses WHERE ord.status_id = statuses.status_id) AS status_name,
            (SELECT name FROM stores WHERE ord.store_id = stores.store_id) AS store
            
            FROM orders ord , donors, payment_methods, badal_orders ds 
            ' . $_SESSION['search']['cond']. '
            ORDER BY ord.create_date DESC ';

            $this->db->query($query);   

            if (!empty( $_SESSION['search']['bind'])) {
                foreach ( $_SESSION['search']['bind'] as $key => $value) {
                    $this->db->bind($key, $value);
                }
            }
            $results = $this->db->resultSet();
            $data[] = [
                "order_identifier" => "الرقم التعريفي",
                "total" => "المجموع",
                "donor" => "طلب بأسم",
                "mobile" => "الجوال",
                "email" => "البريد الاكتيروني",
                "behafeof" => "نيابة عن",
                "relation" => "الصفه",
                "language" => "اللغة",
                "gender" => "النوع",
                "projects" => "المشروعات",
                "payment_method" => " وسيلة الدفع",
                "banktransferproof" => "تأكيد التحويل البنكي",
                "hash" => "hash",
                "create_date" => "اضيف في",
                "modified_date" => " عدل في",
                "status" => "الحاله",
                "rate" => "التقيم",
                "status_name" => "وسم الحالة ",
                "store" => "المتجر الفرعي",
            ];
            $results = array_merge($data, $results);
            $this->exportToExcel($results);
        }
    }


        /**
     * get count of all records
     * @param type $cond
     * @return type
     */
    public function allOrdersCountGift($cond = '', $bind = [])
    {
        $query = 'SELECT count(*) as count FROM ' . $this->table . ' ord ' . $cond;
        $this->db->query($query);
        if (!empty($bind)) {
            foreach ($bind as $key => $value) {
                $this->db->bind($key, $value);
            }
        }
        $this->db->excute();
        return $this->db->single();
    }

    /**
     * export selected orders 
     *
     * @param array $records
     * @return export
     */
    public function exportAllOrdersGift($cond = '', $bind = [])
    {
        $query = 'SELECT gift_data, order_identifier, order_id, create_date, `status` FROM orders ord ' . $cond .  $bind ;
        $this->db->query($query);
        $results = $this->db->resultSet();

        foreach ($results as $order) {
            $order->gift_data = json_decode($order->gift_data);
            $orders[] = [
                "order_id" => $order->order_id,
                "order_identifier" => $order->order_identifier,
                "giver_name" => $order->gift_data->giver_name,
                "giver_number" => $order->gift_data->giver_number,
                "giver_email" => @$order->gift_data->giver_email,
                "giver_group" => $order->gift_data->giver_group,
                "card" => URLROOT . MEDIAFOLDER . @$order->gift_data->card,
                "create_date" => date('Y/ m/ d | H:i a', $order->create_date),
                "status" => $order->status,
            ];
        }

        $data[] = [
            "order_id" => "order_id",
            "order_identifier" => "الرقم التعريفي",
            "giver_name" => "اسم المهدي اليه",
            "giver_number" => "رقم الجوال",
            "giver_email" => "البريد الالكتروني",
            "giver_group" => "الفئة",
            "card" => "كارت الاهداء",
            "create_date" => "تاريخ الاهداء",
            "status" => " حاله الطلب",
        ];
        $results = array_merge($data, $orders);
        $this->exportToExcel($results);
    }

}
