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

class Inkind extends ModelAdmin
{

    public function __construct()
    {
        parent::__construct('inkindes');
    }

    /**
     * get all Inkindes from datatbase
     *
     * @param  string $cond
     * @param  array $bind
     * @param  string $limit
     * @param  mixed $bindLimit
     *
     * @return object Inkindes data
     */
    public function getInkindes($cond = '', $bind = '', $limit = '', $bindLimit = 50)
    {
        $query = 'SELECT * FROM inkindes ' . $cond . ' ORDER BY inkindes.create_date DESC ';

        return $this->getAll($query, $bind, $limit, $bindLimit);
    }

    /**
     * get count of all records
     * @param type $cond
     * @return type
     */
    public function allInkindesCount($cond = '', $bind = '')
    {
        return $this->countAll($cond, $bind);
    }

    /**
     * insert new Inkindes
     * @param array $data
     * @return boolean
     */
    public function addInkind($data)
    {
        $this->db->query('INSERT INTO inkindes( district, message, full_name, email, phone, street, status, modified_date, create_date)'
            . ' VALUES (:district, :message, :full_name, :email, :phone, :street, :status, :modified_date, :create_date)');
        // binding values
        $this->db->bind(':district', $data['district']);
        $this->db->bind(':message', $data['message']);
        $this->db->bind(':full_name', $data['full_name']);
        $this->db->bind(':email', $data['email']);
        $this->db->bind(':phone', $data['phone']);
        $this->db->bind(':street', $data['street']);
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

    public function updateInkind($data)
    {
        $query = 'UPDATE inkindes SET district = :district, message = :message, full_name = :full_name, email = :email, status = :status, 
         phone = :phone, street = :street, modified_date = :modified_date WHERE inkind_id = :inkind_id';

        $this->db->query($query);
        // binding values
        $this->db->bind(':inkind_id', $data['inkind_id']);
        $this->db->bind(':district', $data['district']);
        $this->db->bind(':message', $data['message']);
        $this->db->bind(':full_name', $data['full_name']);
        $this->db->bind(':email', $data['email']);
        $this->db->bind(':phone', $data['phone']);
        $this->db->bind(':street', $data['street']);
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
     * get inkind by id
     * @param integer $id
     * @return object inkind data
     */
    public function getInkindById($id)
    {
        return $this->getById($id, 'inkind_id');
    }

}
