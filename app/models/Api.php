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



class Api extends Model

{

    public function __construct()

    {

        parent::__construct('donations');

    }



    /**

     * get all donations

     *

     * @param integer $start

     * @param integer $count

     * @return object

     */

    public function getDonations($start = 0, $count = 20, $status, $donation_id, $project_id, $order_id, $API_status)

    {

        return $this->queryResult(

            'SELECT donations.*,orders.order_identifier as `order`, projects.name as project,

             from_unixtime(donations.create_date) as create_date, from_unixtime(donations.modified_date) as modified_date 

             FROM donations  ,projects, orders, donors

             WHERE donations.status <> 2 ' . $status . ' ' . $donation_id . ' ' . $project_id . ' ' . $order_id . ' ' . $API_status . ' 

                AND projects.project_id = donations.project_id AND orders.donor_id = donors.donor_id AND orders.order_id = donations.order_id

             ORDER BY donations.create_date LIMIT ' . $start . ' , ' . $count

        );

    }



    /**

     * get all orders

     *

     * @param integer $start

     * @param integer $count

     * @return object

     */

 
     public function getOrders($start = 0, $count = 20, $status, $order_identifier, $order_id, $API_status, $API_odoo, $custom_status_id, $payment_method, $store_id, $start_date, $end_date)
     {

         return $this->queryResult(
            'SELECT ord.*, 
            CONCAT("' . MEDIAURL . '/../files/banktransfer/", `banktransferproof`) as banktransferproof,
            payment_methods.title AS payment_method,
            payment_methods.payment_key, 
            donors.full_name AS donor, 
            donors.mobile, 
            donors.identity,
            donors.email,
            FROM_UNIXTIME(ord.create_date) AS create_date, 
            FROM_UNIXTIME(ord.modified_date) AS modified_date,
            (SELECT statuses.name FROM statuses WHERE statuses.status_id = ord.status_id) AS custom_status,
            ord.status_id AS custom_status_id,
            substitutes.full_name AS substitute_name,
            substitutes.phone AS substitute_mobile,
            substitutes.email AS substitute_email
        
        FROM orders ord USE INDEX (create_date)
        
        INNER JOIN donors ON donors.donor_id = ord.donor_id 
        INNER JOIN payment_methods ON ord.payment_method_id = payment_methods.payment_id
        INNER JOIN badal_orders ON badal_orders.order_id = ord.order_id 
        LEFT JOIN substitutes  ON substitutes.substitute_id = badal_orders.substitute_id 
        
        WHERE ord.status <> 2  
        ' . $status . ' ' . $order_identifier . ' ' . $order_id . ' ' . $API_status . ' ' . $store_id . ' ' . $custom_status_id . ' ' . $payment_method 
        . ' ' . $start_date . ' ' . $end_date . ' ' . $API_odoo . ' AND
        donors.donor_id = ord.donor_id AND ord.payment_method_id = payment_methods.payment_id 

        ORDER BY ord.create_date LIMIT ' . $start . ' , ' . $count
 
        );
 
     }



    public function updatetOrders($filters, $set_status)

    {

        $cond = '';

        foreach ($filters as $key => $value) {

            $cond .= " AND $key = :$key";

        }

        $query = 'UPDATE orders SET API_status = :API_status WHERE orders.status <> 2 ' . $cond;


        $this->db->query($query);

        $this->db->bind(':API_status', $set_status);

        foreach ($filters as $key => $value) {

            $this->db->bind(":" . $key, $value);

        }

        $this->db->excute();

        return $this->db->rowCount();

    }



    public function updatetOrdersOdoo($filters, $odooStatus)

    {

        $cond = '';

        foreach ($filters as $key => $value) {

            $cond .= " AND $key = :$key";

        }

        $query = 'UPDATE orders SET API_odoo = :API_odoo2 WHERE orders.status <> 2 ' . $cond;

        $this->db->query($query);

        $this->db->bind(':API_odoo2', $odooStatus);

        foreach ($filters as $key => $value) {

            $this->db->bind(":" . $key, $value);

        }

        $this->db->excute();

        return $this->db->rowCount();

    }

    /**

     * check user API authintcation 

     *

     * @param [string] $user

     * @param [string] $key

     * @return array

     */

    public function auth($user, $key)

    {

        $api_settings = json_decode($this->getSettings('api')->value); // load API settings



        if ($api_settings->api_user == $user && $api_settings->api_key == $key) {

            return ['enable' => $api_settings->api_enable, 'authorized' => true];

        } else {

            return ['enable' => $api_settings->api_enable, 'authorized' => false];

        }

    }

    /**

     * get donations by order is

     *

     * @param int $order_id

     * @return object

     */

    public function getDonationByOrderId($order_id)

    {

        return $this->queryResult('SELECT donations.*, projects.beneficiary, projects.project_number AS AX_ID FROM donations, projects WHERE projects.project_id = donations.project_id AND  order_id = ' . $order_id);

    }



    /**

     * get Store by id 

     *

     * @param int $store_id

     * @return object

     */

    public function getStore($store_id)

    {

        if (!$store_id) {

            $store_id = 0;

        }

        $results = $this->queryResult('SELECT * FROM stores WHERE store_id = ' . $store_id);

        if (count($results) > 0) {

            return $results[0];

        }

    }

    /**

     * get list of stores

     *

     * @param string $cond

     * @return object

     */

    public function storesList($cond)

    {

        return $this->queryResult('SELECT * FROM stores ' . $cond);

    }
    
    
      /**
     * update odoo by order identifier or start date and end date
     *
     * @param string $cond
     * @return object
     */
    public function updatetOrdersOdooWithDate($filters, $odooStatus, $start_date = null, $end_date = null)
    {
        // create_date
        $cond = '';
        foreach ($filters as $key => $value) {
             $cond .= " AND $key = :$key";
        }

        $query = "UPDATE orders SET API_odoo = :API_odoo2 WHERE orders.status <> 2 " . $cond;

        if($start_date != null) {
            $query .= " AND from_unixtime( `create_date`, '%Y-%m-%d') >= '" . date('Y-m-d', strtotime($start_date)) ."'";
        }
        if($end_date != null) {
            $query .= " AND from_unixtime( `create_date`, '%Y-%m-%d') <= '" . date('Y-m-d', strtotime($end_date)) ."'";
        }
    
      
        $this->db->query($query);
        $this->db->bind(':API_odoo2', $odooStatus);
        foreach ($filters as $key => $value) {
            $this->db->bind(":" . $key, $value);

        }

        $this->db->excute();

        return $this->db->rowCount();

    }

}

