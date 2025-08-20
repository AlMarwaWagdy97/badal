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

class Badalorder extends ModelAdmin
{

    public function __construct()
    {
        parent::__construct('badal_orders');
    }

    /**
     * get all badalorders from datatbase
     *
     * @param  string $cond
     * @param  array $bind
     * @param  string $limit
     * @param  mixed $bindLimit
     *
     * @return object badalorders data
     */
    public function getBadalorders($cond = '', $bind = '', $limit = '', $bindLimit = 50)
    {
        $query = 'SELECT  ds.*, 
                    orders.order_identifier as `order`,
                    projects.name as project,
                    badal_review.rate,
                    badal_review.description,
                    badal_review.review_id
                    FROM badal_orders ds 
                    JOIN projects ON projects.project_id = ds.project_id 
                    JOIN orders ON ds.order_id = orders.order_id 
                    -- LEFT JOIN substitutes ON ds.substitute_id =  substitutes.substitute_id
                    LEFT JOIN badal_review ON ds.badal_id = badal_review.badal_id 
                    ' . $cond . ' AND ds.status <> 2  ORDER BY ds.create_date DESC;';
        // $query = 'SELECT ds.*,orders.order_identifier as `order`, projects.name as project  FROM badal_orders ds ,projects, orders   ' . $cond . ' ORDER BY ds.create_date DESC ';
        return $this->getAll($query, $bind, $limit, $bindLimit);
    }

    /**
     * get count of all records
     * @param type $cond
     * @return type
     */
    public function allBadalordersCount($cond = '', $bind = '')
    {
        // dd($cond);
        $this->db->query('SELECT count(*) as count FROM ' . $this->table . ' ds ' . $cond);
        if (!empty($bind)) {
            foreach ($bind as $key => $value) {
                $this->db->bind($key, '%' . $value . '%');
            }
        }
        $this->db->excute();
        return $this->db->single();
    }

    /**
     * updateBadalorder
     * @param  array $data
     * @return void
     */
    public function updateBadalorder($data)
    {
        $query = 'UPDATE badal_orders SET amount = :amount, quantity =:quantity, total = :total, project_id =:project_id, modified_date = :modified_date';
        $query .= ' WHERE badal_id = :badal_id';
        $this->db->query($query);
        // binding values
        $this->db->bind(':badal_id', $data['badal_id']);
        $this->db->bind(':project_id', $data['project_id']);
        $this->db->bind(':amount', $data['amount']);
        $this->db->bind(':total', $data['total']);
        $this->db->bind(':quantity', $data['quantity']);
        $this->db->bind(':modified_date', time());
        // excute
        if ($this->db->excute()) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * updateBadalorder
     * @param  array $data
     * @return void
     */
    public function addBadalorder($data)
    {
        $query = 'INSERT INTO badal_orders ( amount, order_id, project_id, total, quantity, badalorder_type, status, modified_date, create_date)'
            . ' VALUES (:amount, :order_id, :project_id, :total, :quantity, :badalorder_type, :status, :modified_date, :create_date)';
        $this->db->query($query);
        // binding values
        $this->db->bind(':amount', $data['amount']);
        $this->db->bind(':order_id', $data['order_id']);
        $this->db->bind(':project_id', $data['project_id']);
        $this->db->bind(':total', $data['total']);
        $this->db->bind(':quantity', $data['quantity']);
        $this->db->bind(':badalorder_type', $data['badalorder_type']);
        $this->db->bind(':status', $data['status']);
        $this->db->bind(':modified_date', time());
        $this->db->bind(':create_date', time());
        // excute
        if ($this->db->excute()) {
            return true;
        } else {
            return false;
        }
    }
    /**
     * get badalorder by id
     * @param integer $id
     * @return object badalorder data
     */
    public function getBadalorderById($id)
    {
        return $this->getById($id, 'badal_id');
    }

    /**
     * get list of badalorders categories
     * @param string $cond
     * @return object categories list
     */
    public function projectsList($cond = '')
    {
        $query = 'SELECT project_id, name FROM projects  ' . $cond . ' AND badal = 1 ORDER BY create_date DESC ';
        $this->db->query($query);
        $results = $this->db->resultSet();
        return $results;
    }

    /**
     * get list of badalorders categories
     * @param string $cond
     * @return object categories list
     */
    public function statusesList($cond = '')
    {
        $query = 'SELECT status_id, name FROM statuses  ' . $cond . ' ORDER BY create_date DESC ';
        $this->db->query($query);
        $results = $this->db->resultSet();
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
     * set Badalorder Tages
     *
     * @param  mixed $badalorder_ids
     * @param  mixed $tag_id
     * @return void
     */
    public function setBadalorderStatuses($badalorder_ids, $status_id)
    {
        return $this->setWhereIn('status_id', $status_id, 'badal_id', $badalorder_ids);
    }

    public function clearAllStatusesByBadalordersId($badalorder_ids)
    {
        return $this->setWhereIn('status_id', null, 'badal_id', $badalorder_ids);
    }

    /**
     * handling Search Condition, creating bind array and handling search session
     *
     * @param  array $searches
     * @return array of condation and bind array
     */
    public function handlingSearchCondition($searches)
    {
        //reset search session
        unset($_SESSION['search']);
        $cond = '';
        $bind = [];
        if (!empty($searches)) {
            foreach ($searches as $keyword) {
                if ($keyword == 'donor') {
                    $cond .= ' AND donors.full_name LIKE :' . $keyword . ' ';
                } elseif ($keyword == 'payment_method') {
                    $cond .= ' AND payment_methods.title LIKE :' . $keyword . ' ';
                } elseif ($keyword == 'mobile') {
                    $cond .= ' AND donors.mobile LIKE :' . $keyword . ' ';
                } elseif ($keyword == 'project') {
                    $cond .= ' AND projects.name LIKE :' . $keyword . ' ';
                } else {
                    $cond .= ' AND ds.' . $keyword . ' LIKE :' . $keyword . ' ';
                }
                if ($keyword == 'date_from' || $keyword == 'date_to') {
                    $bind[':' . $keyword] = strtotime($_POST['search'][$keyword]);
                } else {
                    $bind[':' . $keyword] = $_POST['search'][$keyword];
                }

                $_SESSION['search'][$keyword] = $_POST['search'][$keyword];
            }
        }
        return  ['cond' => $cond, 'bind' => $bind];
    }

    /**
     * handling Search Condition on the stored session, creating bind array and handling search session
     *
     * @param  array $searches
     * @return array of condation and bind array
     */
    public function handlingSearchSessionCondition($searches)
    {
        $cond = '';
        $bind = [];
        foreach ($searches as $keyword) {
            if (isset($_SESSION['search'][$keyword])) {
                if ($keyword == 'donor') {
                    $cond .= ' AND donors.full_name LIKE :' . $keyword . ' ';
                } elseif ($keyword == 'project') {
                    $cond .= ' AND projects.name LIKE :' . $keyword . ' ';
                } elseif ($keyword == 'payment_method') {
                    $cond .= ' AND payment_methods.title LIKE :' . $keyword . ' ';
                } elseif ($keyword == 'mobile') {
                    $cond .= ' AND donors.mobile LIKE :' . $keyword . ' ';
                } else {
                    $cond .= ' AND ds.' . $keyword . ' LIKE :' . $keyword . ' ';
                }
                //handling
                if ($keyword == 'date_from' || $keyword == 'date_to') {
                    $bind[':' . $keyword] = strtotime($_SESSION['search'][$keyword]);
                } else {
                    $bind[':' . $keyword] = $_SESSION['search'][$keyword];
                }
            }
        }
        return ['cond' => $cond, 'bind' => $bind];
    }
    /**
     * get users informations to contact them
     *
     * @param [array] $badalorder_ids
     * @return object
     */
    public function getUsersData($in)
    {
        //get the id in PDO form @Example :id1,id2
        for ($index = 1; $index <= count($in); $index++) {
            $id_num[] = ":in" . $index;
        }
        //setting the query
        $this->db->query('SELECT DISTINCT projects.name as project, projects.sms_msg as msg, donors.donor_id, donors.full_name, donors.mobile, donors.email, bo.badal_id, bo.badalorder_identifier, bo.total
                    FROM donors, badal_orders as bo, projects WHERE bo.project_id = projects.project_id AND bo.donor_id = donors.donor_id AND bo.badal_id IN (' . implode(',', $id_num) . ')');
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
        $data = $this->getUsersData($in); // loading data required to send sms 
        $identifiers = [];      //saving the repeated identifiers (cart badalorders)
        $cartItems = [];        //temperary save identifer to escap repeated
        $sendData = [];         // non repeated data array
        $totals = [];           // total value for badalorders that was in cart
        $projects = [];         // compain projects
        foreach ($data as $value) { // loop to collect repeated identifiers and non repeated 
            if (in_array($value->badalorder_identifier, $identifiers)) {
                $cartItems[] = $value->badalorder_identifier;
                continue;
            }
            $identifiers[] = $value->badalorder_identifier;
            $sendData[] = $value;
        }
        foreach ($data as $total) { // loop to get sum of repeated badalorders 
            if (in_array($total->badalorder_identifier, $cartItems)) {
                $totals[$total->badalorder_identifier] += $total->total;
                $projects[$total->badalorder_identifier] .= " - " . $total->project;
                continue;
            }
        }
        foreach ($sendData as $send) {
            if (array_key_exists($send->badalorder_identifier, $totals)) { // setting the value for total badalorder
                $send->total = $totals[$send->badalorder_identifier];
                $send->project = $projects[$send->badalorder_identifier];
            }
            $message = str_replace('[[name]]', $send->full_name, $send->msg); // replace name string with user name
            $message = str_replace('[[identifier]]', $send->badalorder_identifier, $message); // replace name string with user name
            $message = str_replace('[[total]]', $send->total, $message); // replace name string with user name
            $message = str_replace('[[project]]', $send->project, $message); // replace name string with user name
            $this->SMS($send->mobile, $message);
            if (!empty($send->email)) {
                $this->Email($send->email, SITENAME . '  : تأكيد الطلب', $message);
            }
        }
    }


    public function getPendingOrders()
    {
        $query = 'SELECT COUNT(*) as count FROM `badal_orders` WHERE `status` = 0; ';
        $this->db->query($query);
        return$this->db->single();
    }

    public function getsubsitutes( $cond )
    {
        $query = 'SELECT * FROM `substitutes`  ' . $cond . ' ORDER BY create_date DESC ';
        $this->db->query($query);
        return $this->db->resultSet();
    }
}
