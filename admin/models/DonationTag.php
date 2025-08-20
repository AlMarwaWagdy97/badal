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

class DonationTag extends ModelAdmin
{

    public function __construct()
    {
        parent::__construct('donation_tags');
    }

    /**
     * get all donation_tags from datatbase
     *
     * @param  string $cond
     * @param  array $bind
     * @param  string $limit
     * @param  mixed $bindLimit
     *
     * @return object donation_tags data
     */
    public function getDonationTags($cond = '', $bind = '', $limit = '', $bindLimit = 50)
    {
        $query = 'SELECT * FROM donation_tags ' . $cond . ' ORDER BY donation_tags.create_date DESC ';

        return $this->getAll($query, $bind, $limit, $bindLimit);
    }

    /**
     * get count of all records
     * @param type $cond
     * @return type
     */
    public function allDonationTagsCount($cond = '', $bind = '')
    {
        return $this->countAll($cond, $bind);
    }

    /**
     * insert new donation_tags
     * @param array $data
     * @return boolean
     */
    public function addDonationTag($data)
    {
        $this->db->query('INSERT INTO donation_tags( name, alias, description, status, modified_date, create_date)'
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

    public function updateDonationTag($data)
    {
        $query = 'UPDATE donation_tags SET name = :name, description = :description, status = :status, modified_date = :modified_date';


        $query .= ' WHERE tag_id = :tag_id';
        $this->db->query($query);
        // binding values
        $this->db->bind(':tag_id', $data['tag_id']);
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
     * get donation_tag by id
     * @param integer $id
     * @return object donation_tag data
     */
    public function getDonationTagById($id)
    {
        return $this->getById($id, 'tag_id');
    }

}
