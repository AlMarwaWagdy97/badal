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

class Manager extends Model
{
    public function __construct()
    {
        parent::__construct('stores_managers');
    }

    /**
     * get all pages from datatbase
     * @return object page data
     */
    public function getPagesTitle()
    {
        $results = $this->getFromTable('pages', 'page_id, title, alias', ['status' => 1]);
        return $results;
    }

    /**
     * getManagerById
     *
     * @param  mixed $id
     *
     * @return object category
     */
    public function getManagerById($id)
    {
        return $this->getBy(['manager_id' => $id, 'status' => 1]);
    }

    /**
     * getProjectsById
     *
     * @param  mixed $id
     *
     * @return object project
     */
    public function getProjectById($id)
    {
        return $this->getSingle('*', ['project_id' => $id], 'projects');
    }
    /**
     * get Products By Manager
     *
     * @param  int  $id
     *
     * @return object
     */
    public function getProjectsByManager($id, $start, $perpage)
    {
        $query = 'SELECT pj.*,
        (SELECT SUM(donations.total) FROM donations, orders WHERE donations.order_id = orders.order_id AND orders.store_id = :store_id AND pj.project_id = donations.project_id AND donations.status = 1 LIMIT 1 ) as total 
         FROM `projects` pj 
        WHERE  pj.start_date <= ' . time() . ' AND pj.end_date >= ' . time() . ' AND pj.hidden = 0  LIMIT :start, :perpage';
        $this->db->query($query);
        $this->db->bind(':store_id', $id);
        $this->db->bind(':start', $start);
        $this->db->bind(':perpage', $perpage);
        return ($this->db->resultSet());
    }

    /**
     * projects Count
     *
     * @param  mixed $id
     * @return void
     */
    public function projectsCount($id)
    {
        $query = 'SELECT count(*) as count FROM `projects` pj ,stores_projects sps
        WHERE pj.project_id = sps.project_id AND sps.store_id =:store_id AND sps.status =1 AND pj.start_date <= ' . time() . ' AND pj.end_date >= ' . time() . ' AND pj.hidden = 0';
        $this->db->query($query);
        $this->db->bind(':store_id', $id);

        return ($this->db->single());
    }

    /**
     * storesCount
     *
     * @return void
     */
    public function storesCount()
    {
        return $this->countAll(['status' => 1]);
    }

    /**
     * get all Managers
     *
     * @param  mixed $cond
     * @param  mixed $start
     * @param  mixed $perpage
     * @return object
     */
    public function getManagers($start, $perpage)
    {
        return $this->get('*', ['status' => 1, 'parent_id' => 0], $start, $perpage);
    }

    /**
     * check if email exist
     *
     * @param [string] $emailname
     * @return void
     */
    public function findUser($emailname)
    {
        return $this->getBy(['email' => $emailname, 'status' => 1]);
    }
    /**
     * check login details
     *
     * @param [string] $email
     * @param [string] $password
     * @return void
     */
    public function login($email, $password)
    {
        return $this->getBy(['password' => $password]);
    }
    /**
     * get orders by store id
     *
     * @param int $id
     * @return object
     */
    public function getOrdersByManagerId($id)
    {
        return $this->getFromTable('orders', '*', ['stores.store_id' => $id]);
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
    public function getOrders($cond = '', $bind = '', $limit = '', $bindLimit = '')
    {
        $query = 'SELECT ord.*, payment_methods.title AS payment_method, donors.full_name AS donor, donors.mobile, stores.name as store,
        (SELECT name FROM statuses WHERE ord.status_id = statuses.status_id) AS status_name 
        FROM orders ord , donors, payment_methods, stores ' . $cond . ' ORDER BY ord.create_date DESC ';
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
        $query = 'SELECT count(*) as count FROM orders ord ' . $cond;
        $this->db->query($query);
        if (!empty($bind)) {
            foreach ($bind as $key => $value) {
                $this->db->bind($key, $value);
            }
        }
        $this->db->excute();
        return $this->db->single();
    }

    public function updatePassword($manager_id, $password)
    {
        $this->db->query('UPDATE stores_managers SET password = :password WHERE manager_id = :manager_id');
        //loop through the bind function to bind all the IDs
        $this->db->bind(':manager_id', $manager_id);
        $this->db->bind(':password', password_hash($password, PASSWORD_DEFAULT));

        if ($this->db->excute()) {
            return $this->db->rowCount();
        } else {
            return false;
        }
    }
    
    
    /**
     * get count of all records
     * @param type $cond
     * @return type
     */
    public function getStores()
    {
        $stores = implode(',', json_decode($_SESSION['managerlogin']->stores, true));

        $query = 'SELECT * FROM stores WHERE  status <> 2 AND store_id  in (' . $stores . ') ' ;
        $this->db->query($query);
        if (!empty($bind)) {
            foreach ($bind as $key => $value) {
                $this->db->bind($key, $value);
            }
        }
        return $this->db->resultSet();
    }
}
