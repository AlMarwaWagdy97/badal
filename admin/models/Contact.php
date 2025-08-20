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

class Contact extends ModelAdmin
{

    public function __construct()
    {
        parent::__construct('contacts');
    }

    /**
     * get all contacts from datatbase
     *
     * @param  string $cond
     * @param  array $bind
     * @param  string $limit
     * @param  mixed $bindLimit
     *
     * @return object contacts data
     */
    public function getContacts($cond = '', $bind = '', $limit = '', $bindLimit = 50)
    {
        $query = 'SELECT * FROM contacts ' . $cond . ' ORDER BY contacts.create_date DESC ';

        return $this->getAll($query, $bind, $limit, $bindLimit);
    }

    /**
     * get count of all records
     * @param type $cond
     * @return type
     */
    public function allContactsCount($cond = '', $bind = '')
    {
        return $this->countAll($cond, $bind);
    }

    /**
     * insert new contacts
     * @param array $data
     * @return boolean
     */
    public function addContact($data)
    {
        $this->db->query('INSERT INTO contacts( subject, message, full_name, city, email, phone, type, status, modified_date, create_date)'
            . ' VALUES (:subject, :message, :full_name, :city, :email, :phone, :type, :status, :modified_date, :create_date)');
        // binding values
        $this->db->bind(':subject', $data['subject']);
        $this->db->bind(':message', $data['message']);
        $this->db->bind(':full_name', $data['full_name']);
        $this->db->bind(':city', $data['city']);
        $this->db->bind(':email', $data['email']);
        $this->db->bind(':phone', $data['phone']);
        $this->db->bind(':type', $data['type']);
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

    public function updateContact($data)
    {
        $query = 'UPDATE contacts SET subject = :subject, message = :message, full_name = :full_name, city = :city, email = :email, status = :status, 
         phone = :phone, type = :type, modified_date = :modified_date WHERE contact_id = :contact_id';

        $this->db->query($query);
        // binding values
        $this->db->bind(':contact_id', $data['contact_id']);
        $this->db->bind(':subject', $data['subject']);
        $this->db->bind(':message', $data['message']);
        $this->db->bind(':city', $data['city']);
        $this->db->bind(':full_name', $data['full_name']);
        $this->db->bind(':email', $data['email']);
        $this->db->bind(':phone', $data['phone']);
        $this->db->bind(':type', $data['type']);
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
     * get contact by id
     * @param integer $id
     * @return object contact data
     */
    public function getContactById($id)
    {
        return $this->getById($id, 'contact_id');
    }

}
