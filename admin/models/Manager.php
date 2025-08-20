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

class Manager extends ModelAdmin
{

    public function __construct()
    {
        parent::__construct('stores_managers');
    }

    /**
     * get all stores_managers from datatbase
     * @return object group data
     */
    public function getManagers($cond = '', $bind = '', $limit = '', $bindLimit = '')
    {
        $query = 'SELECT * FROM stores_managers ' . $cond . ' ORDER BY stores_managers.create_date DESC ';
        return $this->getAll($query, $bind, $limit, $bindLimit);
    }

    /**
     * get count of all records
     * @param type $cond
     * @return type
     */
    public function allManagersCount($cond = '', $bind = '')
    {
        $this->db->query('SELECT count(*) as count FROM stores_managers ' . $cond);
        if (!empty($bind)) {
            foreach ($bind as $key => $value) {
                $this->db->bind($key, '%' . $value . '%');
            }
        }
        $this->db->excute();
        return $this->db->single();
    }
    /**
     * insert new group
     * @param array $data
     * @return boolean
     */
    public function addManager($data)
    {
        $this->db->query('INSERT INTO stores_managers( name, email, password, stores, status, create_date, modified_date)'
            . ' VALUES (:name, :email, :password, :stores, :status, :create_date, :modified_date)');
        // binding values
        $this->db->bind(':name', $data['name']);
        $this->db->bind(':email', $data['email']);
        $this->db->bind(':password', password_hash($data['password'], PASSWORD_DEFAULT));
        $this->db->bind(':stores', json_encode($data['stores']));
        $this->db->bind(':status', $data['status']);
        $this->db->bind(':create_date', time());
        $this->db->bind(':modified_date', time());

        // excute
        if ($this->db->excute()) {
            return true;
        } else {
            return false;
        }
    }

    public function updateManager($data)
    {
        $query = 'UPDATE stores_managers SET name = :name, email = :email, stores = :stores, status = :status, modified_date = :modified_date';
        if (!empty($data['password']))  $query .= ", password = :password ";
        $query .= ' WHERE manager_id = :manager_id';
        // dd($data) ;
        $this->db->query($query);
        // binding values
        !empty($data['password']) ? $this->db->bind(':password', password_hash($data['password'], PASSWORD_DEFAULT)) : '';
        $this->db->bind(':manager_id', $data['manager_id']);
        $this->db->bind(':name', $data['name']);
        $this->db->bind(':email', $data['email']);
        $this->db->bind(':stores', json_encode($data['stores']));
        $this->db->bind(':status', $data['status']);
        $this->db->bind(':modified_date', time());
        // excute
        if ($this->db->excute()) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * get group by id
     * @param integer $id
     * @return object group data
     */
    public function getManagerById($id)
    {
        return $this->getById($id, 'manager_id');
    }
}
