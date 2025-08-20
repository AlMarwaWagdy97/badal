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

class Volunteerpage extends Model
{
    public function __construct()
    {
        parent::__construct('volunteerpages');
    }

    /**
     * get all pages from datatbase
     * @return object page data
     */
    public function getPages($cols = '*', $bind = '', $start = '', $count = '')
    {
        $results = $this->get($cols, $bind, $start, $count);
        return $results;
    }

    /**
     * get all slides from datatbase
     * @return object slides data
     */
    public function getSlides($cols = '*', $bind = ['status' => 1])
    {
        $results = $this->getFromTable('slides', $cols, $bind, '', '', 'arrangement', 'ASC');
        return $results;
    }
    /**
     * get Projects Tags
     *
     * @param string $cols
     * @param array $bind
     * @return void
     */
    public function getProjectsTags($cols = '*', $bind = ['status' => 1])
    {
        $results = $this->getFromTable('project_tags', $cols, $bind, '', '', 'arrangement', 'ASC');
        return $results;
    }
    /**
     * get projects from datatbase
     * @return object projects data
     */
    public function getProjects()
    {
        $query = 'SELECT pj.*,(SELECT SUM(total) FROM donations WHERE pj.project_id =donations.project_id AND status = 1 LIMIT 1 ) as total 
        FROM `projects` pj WHERE pj.status = 1 AND pj.kafara <> "app" AND pj.start_date <= ' . time() . ' AND pj.end_date >= ' . time() . ' AND pj.hidden = 0 AND pj.featured = 1 ORDER BY arrangement ASC';
        $this->db->query($query);
        return $this->db->resultSet();
    }

    /**
     * get project_categories from datatbase
     * @return object project_categories data
     */
    public function getProjectCategories($cols = '*', $bind = ['status' => 1, 'parent_id' => 0], $orderBy = 'arrangement', $order = 'ASC')
    {
        $results = $this->getFromTable('project_categories', $cols, $bind, '', '', $orderBy, $order);
        return $results;
    }

    /**
     * get all pages from datatbase
     * @return object page data
     */
    public function getPagesTitle()
    {
        $results = $this->get('page_id, title, alias', ['status' => 1]);
        return $results;
    }

    public function getPageById($id)
    {
        return $this->getBy(['page_id' => $id, 'status' => 1]);
    }

    /**
     * store Volunteering
     *
     * @param array $data
     * @return boolean
     */
    public function addVolunteering($data)
    {
        $this->db->query('INSERT INTO volunteering(volunteerpage_id, identity, email, full_name, phone, otp, status, modified_date, create_date)'
            . ' VALUES (:volunteerpage_id, :identity, :email, :full_name, :phone, :otp, :status, :modified_date, :create_date)');
        // binding values
        $this->db->bind(':volunteerpage_id', $data['volunteerpage']->volunteerpage_id);
        $this->db->bind(':identity', $data['identity']);
        $this->db->bind(':email', $data['email']);
        $this->db->bind(':full_name', $data['full_name']);
        $this->db->bind(':phone', $data['phone']);
        $this->db->bind(':otp', $data['otp']);
        $this->db->bind(':status', 0);
        $this->db->bind(':create_date', time());
        $this->db->bind(':modified_date', time());
        // excute
        if ($this->db->excute()) {
            return  $this->db->lastId();
        } else {
            return false;
        }
    }

    public function updateVolunteering($id)
    {
        $this->db->query('UPDATE volunteering SET status = 1 WHERE volunteering_id = :id');
        $this->db->bind(':id', $id);
        $this->db->excute();
    }

    public function updateVolunteeringShare($id, $chanel)
    {
        if ($chanel == 'twitter' || $chanel == 'whatsapp' || $chanel == 'facebook' || $chanel == 'instagram') {
            $this->db->query('UPDATE volunteering SET ' . $chanel . ' = 1 WHERE volunteering_id = :id');
            $this->db->bind(':id', $id);
            $this->db->excute();
        }
    }
    public function updatecount($id)
    {
        $this->db->query('UPDATE volunteering SET shared_count = shared_count+1 WHERE volunteering_id = :id');
        $this->db->bind(':id', $id);
        $this->db->excute();
    }
}
