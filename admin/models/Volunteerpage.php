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

class Volunteerpage extends ModelAdmin
{

    public function __construct()
    {
        parent::__construct('volunteerpages');
    }

    /**
     * get all volunteerpages from datatbase
     *
     * @param  string $cond
     * @param  array $bind
     * @param  string $limit
     * @param  mixed $bindLimit
     *
     * @return object volunteerpages data
     */
    public function getPages($cond = '', $bind = '', $limit = '', $bindLimit = 50)
    {
        $query = 'SELECT volunteerpage_id, title, image, meta_keywords, meta_description, hits, status, create_date, modified_date '
            . 'FROM volunteerpages ' . $cond . ' ORDER BY volunteerpages.create_date DESC ';

        return $this->getAll($query, $bind, $limit, $bindLimit);
    }

    /**
     * get count of all records
     * @param type $cond
     * @return type
     */
    public function allPagesCount($cond = '', $bind = '')
    {
        return $this->countAll( $cond, $bind);        
    }

    /**
     * insert new volunteerpage
     * @param array $data
     * @return boolean
     */
    public function addPage($data)
    {
        $this->db->query('INSERT INTO volunteerpages( title, alias, content, image, meta_keywords, meta_description, status, modified_date, create_date)'
            . ' VALUES (:title, :alias, :content, :image, :meta_keywords, :meta_description, :status, :modified_date, :create_date)');
        // binding values
        $this->db->bind(':title', $data['title']);
        $this->db->bind(':alias', $data['alias']);
        $this->db->bind(':content', $data['content']);
        $this->db->bind(':image', $data['image']);
        $this->db->bind(':meta_keywords', $data['meta_keywords']);
        $this->db->bind(':meta_description', $data['meta_description']);
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

    public function updatePage($data)
    {
        $query = 'UPDATE volunteerpages SET title = :title, content = :content, meta_keywords = :meta_keywords,'
            . ' meta_description = :meta_description, status = :status, modified_date = :modified_date';
        (empty($data['image'])) ? null : $query .= ', image = :image';
        $query .= ' WHERE volunteerpage_id = :volunteerpage_id';
        $this->db->query($query);
        // binding values
        $this->db->bind(':volunteerpage_id', $data['volunteerpage_id']);
        $this->db->bind(':title', $data['title']);
        $this->db->bind(':content', $data['content']);
        $this->db->bind(':meta_keywords', $data['meta_keywords']);
        $this->db->bind(':meta_description', $data['meta_description']);
        $this->db->bind(':status', $data['status']);
        $this->db->bind(':modified_date', time());
        empty($data['image']) ? null : $this->db->bind(':image', $data['image']);
        // excute
        if ($this->db->excute()) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * get volunteerpage by id
     * @param integer $id
     * @return object volunteerpage data
     */
    public function getPageById($id)
    {
        return $this->getById($id, 'volunteerpage_id');
    }

}
