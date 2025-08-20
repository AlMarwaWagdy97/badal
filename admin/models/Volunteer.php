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

class Volunteer extends ModelAdmin
{

    public function __construct()
    {
        parent::__construct('volunteers');
    }

    /**
     * get all Volunteers from datatbase
     *
     * @param  string $cond
     * @param  array $bind
     * @param  string $limit
     * @param  mixed $bindLimit
     *
     * @return object Volunteers data
     */
    public function getVolunteers($cond = '', $bind = '', $limit = '', $bindLimit = 50)
    {
        $query = 'SELECT * FROM volunteers ' . $cond . ' ORDER BY volunteers.create_date DESC ';

        return $this->getAll($query, $bind, $limit, $bindLimit);
    }

    /**
     * get count of all records
     * @param type $cond
     * @return type
     */
    public function allVolunteersCount($cond = '', $bind = '')
    {
        return $this->countAll($cond, $bind);
    }

    /**
     * insert new Volunteers
     * @param array $data
     * @return boolean
     */
    public function addVolunteer($data)
    {
        $this->db->query('INSERT INTO volunteers( image, full_name, identity, phone, nationality, gender, email, status, modified_date, create_date)'
            . ' VALUES ( :image, :full_name, :identity, :phone, :nationality, :gender, :email, :status, :modified_date, :create_date)');
        // binding values
        $this->db->bind(':identity', $data['identity']);
        $this->db->bind(':image', $data['image']);
        $this->db->bind(':full_name', $data['full_name']);
        $this->db->bind(':phone', $data['phone']);
        $this->db->bind(':nationality', $data['nationality']);
        $this->db->bind(':gender', $data['gender']);
        $this->db->bind(':email', $data['email']);
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

    public function updateVolunteer($data)
    {
        $query = 'UPDATE volunteers SET full_name = :full_name, identity = :identity, status = :status, phone = :phone, nationality = :nationality';
        if (!empty($data['image'])) $query .= ', image = :image';
        $query .= ', gender = :gender, email = :email, modified_date = :modified_date WHERE volunteer_id = :volunteer_id';
        $this->db->query($query);
        // binding values
        $this->db->bind(':volunteer_id', $data['volunteer_id']);
        $this->db->bind(':identity', $data['identity']);
        if (!empty($data['image'])) $this->db->bind(':image', $data['image']);
        $this->db->bind(':full_name', $data['full_name']);
        $this->db->bind(':phone', $data['phone']);
        $this->db->bind(':nationality', $data['nationality']);
        $this->db->bind(':gender', $data['gender']);
        $this->db->bind(':email', $data['email']);
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
     * get volunteer by id
     * @param integer $id
     * @return object volunteer data
     */
    public function getVolunteerById($id)
    {
        return $this->getById($id, 'volunteer_id');
    }
}
