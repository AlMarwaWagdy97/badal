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

class Badalorder extends Model
{
    public function __construct()
    {
        parent::__construct('badal_orders');
    }


    /**
     * get badal_order by id
     * @param integer $id
     * @return object badal_order data
     */
    public function getBadalOrderById($id)
    {
        $this->db->query('SELECT * FROM `badal_orders` WHERE badal_id = ' . $id);
        $row = $this->db->single();
        return $row;
    }



    /**
     * get badal_order by order_id2
     * @param integer $id
     * @return object badal_order data
     */
    public function getBadalOrderByOrderID2($order_id)
    {
        $query = 'SELECT `projects`.name as project_name, `badal_orders`.*,  from_unixtime( `badal_orders`.create_date) AS time, orders.donor_id
            , from_unixtime( `badal_orders`.start_at) AS start_at
            , from_unixtime( `badal_orders`.complete_at) AS complete_at
            ,`requests`.request_id 
        FROM  `badal_orders`, `projects`, orders, `requests`
        WHERE badal_orders.order_id = :order_id 
        AND `requests`.badal_id = `badal_orders`.badal_id AND `requests`.status = 1 AND `requests`.is_selected = 1
        AND  `badal_orders`.project_id =  `projects`.project_id   
         AND orders.order_id =  `badal_orders`.order_id';

        $this->db->query($query);
        $this->db->bind(':order_id', $order_id);
        return $this->db->single();
    }

    /**
     * get badal_order by order_id
     * @param integer $id
     * @return object badal_order data
     */
    public function getBadalOrderByOrderID($order_id)
    {
        $this->db->query('SELECT * FROM `badal_orders` WHERE `order_id` = ' . $order_id);
        $row = $this->db->single();
        return $row;
    }

    /**
     * addBadalorder
     *
     * @param  array $data
     *
     * @return void
     */
    public function addBadalOrder($data)
    {
        $this->db->query('INSERT INTO badal_orders (amount, total, quantity, substitute_id, order_id, project_id, behafeof, relation, language, gender, is_offer, offer_id, start_at, status, modified_date, create_date)'
            . ' VALUES (:amount, :total, :quantity, :substitute_id, :order_id, :project_id, :behafeof, :relation, :language, :gender, :is_offer, :offer_id, :start_at, :status, :modified_date, :create_date)');
        // binding values
        $this->db->bind(':amount', $data['amount']);
        $this->db->bind(':total', $data['total']);
        $this->db->bind(':quantity', $data['quantity']);
        $this->db->bind(':substitute_id', $data['substitute_id']);
        $this->db->bind(':project_id', $data['project_id']);
        $this->db->bind(':order_id', $data['order_id']);
        $this->db->bind(':behafeof', $data['behafeof']);
        $this->db->bind(':relation', $data['relation']);
        $this->db->bind(':language', $data['language']);
        $this->db->bind(':gender', $data['gender']);
        $this->db->bind(':is_offer', $data['is_offer']);
        $this->db->bind(':offer_id', $data['offer_id']);
        $this->db->bind(':start_at', $data['start_at']);
        $this->db->bind(':status', $data['status']);
        $this->db->bind(':create_date', time());
        $this->db->bind(':modified_date', time());
        // excute
        if ($this->db->excute()) {
            return $this->db->lastId();
        } else {
            return false;
        }
    }

    /**
     * get badalOrders by status
     * @param int $donor_id
     * @param int $status
     */
    public function getBadalOrderDonor($donor_id, $status)
    {
        $query = 'SELECT `projects`.name, `badal_orders`.*,  orders.donor_id,
                    (SELECT from_unixtime( `requests`.start_at)  FROM `requests` WHERE `requests`.badal_id = `badal_orders`.badal_id AND `requests`.status = 1 AND `requests`.is_selected = 1 Limit 1) AS time
                    , from_unixtime( `badal_orders`.start_at) AS start_at
                    , from_unixtime( `badal_orders`.complete_at) AS complete_at
                    ,(SELECT rate FROM `badal_review` WHERE `badal_review`.badal_id = `badal_orders`.badal_id) AS review 
                FROM  `badal_orders`, `projects`  ,orders
                WHERE orders.donor_id = :donor_id 
                AND  `badal_orders`.project_id =  `projects`.project_id  
                AND `orders`.status <> 2  
                AND orders.order_id =  `badal_orders`.order_id';
        switch ($status) {
            case 1: // pinding
                $query .= ' AND  `badal_orders`.complete_at IS NULL AND `badal_orders`.start_at IS NULL ';
                break;
            case 2: // in proccess
                $query .= ' AND `badal_orders`.complete_at IS  NULL AND `badal_orders`.start_at IS NOT NULL AND `orders`.status = 1 ';
                break;
            case 3: // complete
                $query .= ' AND `badal_orders`.complete_at IS NOT NULL AND `orders`.status = 1 ';
                break;
            default:
                return false;
                break;
        }
        $this->db->query($query);
        $this->db->bind(':donor_id', $donor_id);

        return $this->db->resultSet();
    }

    /**
     * get badalOrders by substitute_id and status
     * @param Array $data [status,substitute_id]
     */
    public function getBadalOrderSubstitute($data)
    {
        $query = 'SELECT `projects`.name as project_name, `badal_orders`.*, orders.donor_id';

        switch ($data['status']) {
            case 3:
                $query .=   ', from_unixtime( `badal_orders`.complete_at) AS time';
                break;
            default:
                $query .=   ',from_unixtime( `requests`.start_at) AS time';
                break;
        }

        $query .= ', from_unixtime( `badal_orders`.start_at) AS start_at
            , from_unixtime( `badal_orders`.complete_at) AS complete_at
            ,(SELECT rate FROM `badal_review` WHERE `badal_review`.badal_id = `badal_orders`.badal_id) AS review 
            ,`requests`.request_id,
            CASE WHEN true THEN "0" ELSE orders.total END AS total,
            CASE WHEN true THEN "0" ELSE badal_orders.amount END AS amount
        FROM  `badal_orders`, `projects`, orders, `requests`
        WHERE badal_orders.substitute_id = :substitute_id 
        AND `requests`.badal_id = `badal_orders`.badal_id AND `requests`.status = 1 AND `requests`.is_selected = 1
        AND  `badal_orders`.project_id =  `projects`.project_id   
        AND `badal_orders`.status = 1 
         AND orders.order_id =  `badal_orders`.order_id';
        switch ($data['status']) {
            case 1: // pinding
                $query .= ' AND  `badal_orders`.complete_at IS NULL AND `badal_orders`.start_at IS NULL ';
                break;
            case 2: // in proccess
                $query .= ' AND `badal_orders`.complete_at IS  NULL AND `badal_orders`.start_at IS NOT NULL';
                break;
            case 3: // complete
                $query .= ' AND `badal_orders`.complete_at IS NOT NULL ';
                break;
            default:
                return false;
                break;
        }

        $this->db->query($query);
        $this->db->bind(':substitute_id', $data['substitute_id']);
        return $this->db->resultSet();
    }

    /**
     * get list of pending that has no substitute badalOrders 
     * @param Array $ids
     */
    public function getBadalOrderPending()
    {
        $query = 'SELECT
        projects.name as project_name,
        projects.project_id,
        CONCAT("' . MEDIAURL .  '/", projects.secondary_image ) AS secondary_image,
        orders.order_id,
        orders.donor_id,
        orders.order_identifier,  orders.donor_name, 
        badal_orders.*,
        orders.total AS total,
        badal_orders.amount AS amount,
        from_unixtime( badal_orders.create_date) AS time
        FROM  badal_orders, projects, orders 
        WHERE substitute_id IS NULL 
        AND badal_orders.project_id = projects.project_id 
        AND orders.order_id = badal_orders.order_id AND  
        badal_orders.status = 1';

        $this->db->query($query);
        return $this->db->resultSet();
    }

    /**
     * update badalOrders by id 
     * @param Array $ids
     */
    public function updateBadalOrderStart($id)
    {
        $query = 'UPDATE `badal_orders` SET   `start_at` = :start_at, `modified_date` = :modified_date WHERE `badal_id`= :badal_id';
        $this->db->query($query);
        $this->db->bind(':badal_id', $id);
        $this->db->bind(':start_at', time());
        $this->db->bind(':modified_date', time());
        // excute
        if ($this->db->excute()) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * update badalOrders by id 
     * @param Array $ids
     */
    public function updateBadalOrderCompleted($id)
    {
        $query = 'UPDATE `badal_orders` SET   `complete_at` = :complete_at, `modified_date` = :modified_date WHERE `badal_id`= :badal_id';
        $this->db->query($query);
        $this->db->bind(':badal_id', $id);
        $this->db->bind(':complete_at', time());
        $this->db->bind(':modified_date', time());
        // excute
        if ($this->db->excute()) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * get Setting by id 
     * @param integer $id
     */
    public function getSettingById($id)
    {
        $query = 'SELECT `value` FROM  `settings`  WHERE alias = "badal"';
        $this->db->query($query);
        return $this->db->single();
    }

    /**
     * get Setting by id 
     * @param integer $id
     */
    public function getBadalOrders()
    {
        $query = 'SELECT * FROM  `badal_orders`  WHERE `substitute_id` IS NOT NULL  AND `complete_at`  IS NULL  AND `start_at`  IS NULL AND `status` = 1';
        $this->db->query($query);
        return $this->db->resultSet();
    }

    /**
     * get badal_order by order_id
     * @param integer $id
     * @return object badal_order data
     */
    public function getDonorByOrderID($order_id)
    {
        $this->db->query('SELECT
         `orders`.order_id,`orders`.order_identifier,`orders`.total,`orders`.projects,`orders`.donor_name,
         `badal_orders`.behafeof, `badal_orders`.behafeof, `substitutes`.full_name As substitute_name, `substitutes`.phone As substitute_phone, `donors`.* 
         FROM `orders`, `donors`, `badal_orders`, `substitutes`
         WHERE `orders`.order_id = ' . $order_id . '
         AND `orders`.donor_id = `donors`.donor_id 
         AND `orders`.order_id = `badal_orders`.order_id
         AND `badal_orders`.substitute_id = `substitutes`.substitute_id

        ');
       
        return $this->db->single();
    }

    /**
     * get all uncompleted rituals by order_id
     * @param integer $id
     * @return object badal_order data
     */
    public function getuncompleteRituals($order_id)
    {
        $this->db->query('SELECT `ritual_id` FROM `rituals` WHERE order_id = :order_id AND (start = 0  OR complete = 0)');
        $this->db->bind(':order_id', $order_id);
        return $this->db->single();
    }

    /**
     * get badal by id
     * @return object badal data
     */
    public function getBadalById($id)
    {
        return $this->getBy(['badal_id' => $id]);
    }

    /**
     * get subsitude by offer_id 
     * @param Array $ids
     */
    public function getSubsitudeOffer($offer_id)
    {
        $this->db->query('SELECT `substitute_id` FROM `badal_offers` WHERE offer_id = :offer_id AND status = 1');
        $this->db->bind(':offer_id', $offer_id);
        return $this->db->single();
    }

    /**
     * update status offer by 3 --> slected
     * @param Array $ids
     */
    public function updateStatusOffer($offer_id)
    {
        $query = 'UPDATE `badal_offers` SET   `status` = :status, `modified_date` = :modified_date WHERE `offer_id`= :offer_id';
        $this->db->query($query);
        $this->db->bind(':offer_id', $offer_id);
        $this->db->bind(':status', 3);
        $this->db->bind(':modified_date', time());
        // excute
        if ($this->db->excute()) {
            return true;
        } else {
            return false;
        }
    }

    /**
     *add request for badal 
     * @param int $id
     * @param Array $array
     */
    public function addRequestOffer($badalId, $data)
    {
        $this->db->query('INSERT INTO `requests` (badal_id, substitute_id, start_at, is_selected, `status`,  modified_date, create_date)'
            . ' VALUES ( :badal_id, :substitute_id, :start_at, :is_selected, :status, :modified_date, :create_date)');
        // binding values
        $this->db->bind(':badal_id', $badalId);
        $this->db->bind(':substitute_id', @$data['substitute_id']);
        $this->db->bind(':start_at', $data['offer_start_at']);
        $this->db->bind(':is_selected', 1);
        $this->db->bind(':status', 1);
        $this->db->bind(':create_date', time());
        $this->db->bind(':modified_date', time());
        // excute
        if ($this->db->excute()) {
            return $this->db->lastId();
        } else {
            return false;
        }
    }


    /**
     * get Ssubstitute From Order
     * @param Array $order_id
     */
    public function getSsubstituteFromOrder($order_id)
    {
        $query = 'SELECT `substitutes`.* 
                  FROM `substitutes`, `orders`, `badal_orders` 
                  WHERE `orders`.order_id = :order_id 
                  And `badal_orders`.order_id = `orders`.order_id
                  And  `substitutes`.substitute_id = `badal_orders`.substitute_id ';
        $this->db->query($query);
        $this->db->bind(':order_id', $order_id);
        return $this->db->single();
    }

    /**
     * get request from badal request
     * @param Array $badal_id
     */
    public function getRequestByBadalOrderID($badal_id)
    {
        $query = 'SELECT `requests`.* 
                  FROM `requests` 
                  WHERE `requests`.badal_id = :badal_id 
                  And `requests`.is_selected = 1
                  And `requests`.status = 1 ';

        $this->db->query($query);
        $this->db->bind(':badal_id', $badal_id);
        return $this->db->single();
    }


    /**
     * get badalOrders by status
     * @param int $donor_id
     * @param int $status
     */
    public function getBadalOrderDonorComplete($donor_id, $status)
    {
        $query = 'SELECT `projects`.name, `badal_orders`.*,  orders.donor_id
                    , from_unixtime( `badal_orders`.complete_at)  AS time
                    , from_unixtime( `badal_orders`.start_at) AS start_at
                    , from_unixtime( `badal_orders`.complete_at) AS complete_at
                    ,(SELECT rate FROM `badal_review` WHERE `badal_review`.badal_id = `badal_orders`.badal_id) AS review 
                FROM  `badal_orders`, `projects`  ,orders
                WHERE orders.donor_id = :donor_id 
                AND  `badal_orders`.project_id =  `projects`.project_id  
                AND `orders`.status <> 2  
                AND orders.order_id =  `badal_orders`.order_id';
        switch ($status) {
            case 1: // pinding
                $query .= ' AND  `badal_orders`.complete_at IS NULL AND `badal_orders`.start_at IS NULL ';
                break;
            case 2: // in proccess
                $query .= ' AND `badal_orders`.complete_at IS  NULL AND `badal_orders`.start_at IS NOT NULL AND `orders`.status = 1 ';
                break;
            case 3: // complete
                $query .= ' AND `badal_orders`.complete_at IS NOT NULL AND `orders`.status = 1 ';
                break;
            default:
                return false;
                break;
        }
        $this->db->query($query);
        $this->db->bind(':donor_id', $donor_id);

        return $this->db->resultSet();
    }



    /**
     * get proofed links from  from badal request
     * @param Array $badal_id
     */
    public function getProofedRituals($order_id)
    {
        $query = 'SELECT `rituals`.title, `rituals`.proof
        FROM `rituals`
        WHERE `rituals`.order_id = :order_id
          AND `rituals`.status = 1
          AND `rituals`.proof NOT IN ("1", "0")';

        $this->db->query($query);
        $this->db->bind(':order_id', $order_id);
        return $this->db->resultSet();
    }
}
