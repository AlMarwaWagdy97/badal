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

class Status extends ModelAdmin
{

    public function __construct()
    {
        parent::__construct('statuses');
    }

    /**
     * get all statuses from datatbase
     *
     * @param  string $cond
     * @param  array $bind
     * @param  string $limit
     * @param  mixed $bindLimit
     *
     * @return object statuses data
     */
    public function getStatuses($cond = '', $bind = '', $limit = '', $bindLimit = 50)
    {
        $query = 'SELECT * FROM statuses ' . $cond . ' ORDER BY statuses.create_date DESC ';

        return $this->getAll($query, $bind, $limit, $bindLimit);
    }

    /**
     * get count of all records
     * @param type $cond
     * @return type
     */
    public function allStatusesCount($cond = '', $bind = '')
    {
        return $this->countAll($cond, $bind);
    }

    /**
     * insert new statuses
     * @param array $data
     * @return boolean
     */
    public function addStatus($data)
    {
        $this->db->query('INSERT INTO statuses( name, alias, description, status, modified_date, create_date)'
            . ' VALUES (:name, :alias, :description, :status, :modified_date, :create_date)');
        // binding values
        $this->db->bind(':name', $data['name']);
        $this->db->bind(':alias', $data['alias']);
        $this->db->bind(':description', $data['description']);
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

    public function updateStatus($data)
    {
        $query = 'UPDATE statuses SET name = :name, description = :description, status = :status, modified_date = :modified_date';


        $query .= ' WHERE status_id = :status_id';
        $this->db->query($query);
        // binding values
        $this->db->bind(':status_id', $data['status_id']);
        $this->db->bind(':name', $data['name']);
        $this->db->bind(':description', $data['description']);
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
     * get Status by id
     * @param integer $id
     * @return object Status data
     */
    public function getStatusById($id)
    {
        return $this->getById($id, 'status_id');
    }

}
