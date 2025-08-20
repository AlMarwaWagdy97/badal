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

class Store extends Model
{
    public function __construct()
    {
        parent::__construct('stores');
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
     * getStoreById
     *
     * @param  mixed $id
     *
     * @return object category
     */
    public function getStoreById($id)
    {
        return $this->getBy(['alias' => $id, 'status' => 1]);
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
     * get Products By Store
     *
     * @param  int  $id
     *
     * @return object
     */
    public function getProjectsByStore($id, $start, $perpage)
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
     * get all Stores
     *
     * @param  mixed $cond
     * @param  mixed $start
     * @param  mixed $perpage
     * @return object
     */
    public function getStores($start, $perpage)
    {
        return $this->get('*', ['status' => 1, 'parent_id' => 0], $start, $perpage);
    }

    /**
     * check if user exist
     *
     * @param [string] $username
     * @return void
     */
    public function findUser($username)
    {
        return $this->getBy(['user' => $username, 'status' => 1]);
    }
    /**
     * check login details
     *
     * @param [string] $user
     * @param [string] $password
     * @return void
     */
    public function login($user, $password)
    {
        return $this->getBy(['password' => $password]);
    }
    /**
     * get orders by store id
     *
     * @param int $id
     * @return object
     */
    public function getOrdersByStoreId($id)
    {
        return $this->getFromTable('orders', '*', ['store_id' => $id]);
    }

    public function updatePassword($store_id, $password)
    {
        $this->db->query('UPDATE stores SET password = :password WHERE store_id = :store_id');
        //loop through the bind function to bind all the IDs
        $this->db->bind(':store_id', $store_id);
        $this->db->bind(':password', password_hash($password, PASSWORD_DEFAULT));

        if ($this->db->excute()) {
            return $this->db->rowCount();
        } else {
            return false;
        }
    }


    public function updateStoreDonor($mobile, $store_id)
    {
        $this->db->query('UPDATE donors SET store_id = :store_id WHERE mobile = :mobile');
        //loop through the bind function to bind all the IDs
        $this->db->bind(':mobile', $mobile);
        $this->db->bind(':store_id', $store_id);

        if ($this->db->excute()) {
            return $this->db->rowCount();
        } else {
            return false;
        }
    }


    /**
     * projects Count
     *
     * @param  mixed $id
     * @return void
     */
    public function getProjectsHits($store_id)
    {
        $query = 'SELECT p.project_id, p.name, sp.hits
                    FROM stores_projects sp
                    INNER JOIN projects p ON sp.project_id = p.project_id
                    WHERE sp.store_id = :store_id;';

        $this->db->query($query);
        $this->db->bind(':store_id', $store_id);

        return ($this->db->resultSet());
    }
}
