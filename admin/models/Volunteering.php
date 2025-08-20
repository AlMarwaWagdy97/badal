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

class Volunteering extends ModelAdmin
{

    public function __construct()
    {
        parent::__construct('volunteering');
    }

    /**
     * get all Volunteerings from datatbase
     *
     * @param  string $cond
     * @param  array $bind
     * @param  string $limit
     * @param  mixed $bindLimit
     *
     * @return object Volunteerings data
     */
    public function getVolunteerings($cond = '', $bind = '', $limit = '', $bindLimit = 50)
    {
        if (isset($bind[':volunteerpages.title'])) {
            $cond = str_replace(':volunteerpages.title', ':title', $cond);
            $bind[':title'] = $bind[':volunteerpages.title'];
            unset($bind[':volunteerpages.title']);
        }
        $query = 'SELECT volunteering.*, volunteerpages.title, volunteerpages.volunteerpage_id FROM volunteering ' . $cond . ' ORDER BY volunteering.create_date DESC ';

        return $this->getAll($query, $bind, $limit, $bindLimit);
    }

    /**
     * get count of all records
     * @param type $cond
     * @return type
     */
    public function allVolunteeringsCount($cond = '', $bind = '')
    {
        if (isset($bind[':volunteerpages.title'])) {
            $cond = str_replace(':volunteerpages.title', ':title', $cond);
            $bind[':title'] = $bind[':volunteerpages.title'];
            unset($bind[':volunteerpages.title']);
        }
        return $this->countAll($cond, $bind);
    }

    /**
     * insert new Volunteerings
     * @param array $data
     * @return boolean
     */
    public function addVolunteering($data)
    {
        $this->db->query('INSERT INTO volunteering( image, full_name, identity, phone, nationality, gender, email, status, modified_date, create_date)'
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

    public function updateVolunteering($data)
    {
        $query = 'UPDATE volunteering SET full_name = :full_name, identity = :identity, status = :status, phone = :phone, nationality = :nationality';
        if (!empty($data['image'])) $query .= ', image = :image';
        $query .= ', gender = :gender, email = :email, modified_date = :modified_date WHERE volunteering_id = :volunteering_id';
        $this->db->query($query);
        // binding values
        $this->db->bind(':volunteering_id', $data['volunteering_id']);
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
     * get volunteering by id
     * @param integer $id
     * @return object volunteering data
     */
    public function getVolunteeringById($id)
    {
        return $this->getById($id, 'volunteering_id');
    }
}
