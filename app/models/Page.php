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

class Page extends Model
{
    public function __construct()
    {
        parent::__construct('pages');
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
     * add Contacts
     *
     * @param  mixed $data
     * @return void
     */
    public function addContacts($data)
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
        $this->db->bind(':status', 0);
        $this->db->bind(':create_date', time());
        $this->db->bind(':modified_date', time());

        // excute
        if ($this->db->excute()) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * store In-kinde 
     *
     * @param array $data
     * @return boolean
     */
    public function addInkinde($data)
    {
        $this->db->query('INSERT INTO inkindes(email, message, full_name, district, phone, street, status, modified_date, create_date)'
            . ' VALUES ( :email, :message, :full_name, :district, :phone, :street, :status, :modified_date, :create_date)');
        // binding values
        $this->db->bind(':email', $data['email']);
        $this->db->bind(':message', $data['message']);
        $this->db->bind(':full_name', $data['full_name']);
        $this->db->bind(':district', $data['district']);
        $this->db->bind(':phone', $data['phone']);
        $this->db->bind(':street', $data['street']);
        $this->db->bind(':status', 0);
        $this->db->bind(':create_date', time());
        $this->db->bind(':modified_date', time());
        // excute
        if ($this->db->excute()) {
            return true;
        } else {
            return false;
        }
    }
    /**
     * store beneficiary 
     *
     * @param array $data
     * @return boolean
     */
    public function addBeneficiaries($data)
    {
        $this->db->query('INSERT INTO beneficiaries( identity, nationality, gender, family, income, message, full_name, district, phone, city, image, status, modified_date, create_date)'
            . ' VALUES (:identity, :nationality, :gender, :family, :income, :message, :full_name, :district, :phone, :city, :image, :status, :modified_date, :create_date)');
        // binding values
        $this->db->bind(':identity', $data['identity']);
        $this->db->bind(':nationality', $data['nationality']);
        $this->db->bind(':gender', $data['gender']);
        $this->db->bind(':family', $data['family']);
        $this->db->bind(':income', $data['income']);
        $this->db->bind(':message', $data['message']);
        $this->db->bind(':full_name', $data['full_name']);
        $this->db->bind(':district', $data['district']);
        $this->db->bind(':phone', $data['phone']);
        $this->db->bind(':city', $data['city']);
        $this->db->bind(':image', $data['image']);
        $this->db->bind(':status', 0);
        $this->db->bind(':create_date', time());
        $this->db->bind(':modified_date', time());
        // excute
        if ($this->db->excute()) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * store Volunteer
     *
     * @param array $data
     * @return boolean
     */
    public function addVolunteer($data)
    {
        $this->db->query('INSERT INTO volunteers( identity, nationality, gender, email, full_name, phone, image, status, modified_date, create_date)'
            . ' VALUES (:identity, :nationality, :gender, :email, :full_name, :phone, :image, :status, :modified_date, :create_date)');
        // binding values
        $this->db->bind(':identity', $data['identity']);
        $this->db->bind(':nationality', $data['nationality']);
        $this->db->bind(':gender', $data['gender']);
        $this->db->bind(':email', $data['email']);
        $this->db->bind(':full_name', $data['full_name']);
        $this->db->bind(':phone', $data['phone']);
        $this->db->bind(':image', $data['image']);
        $this->db->bind(':status', 0);
        $this->db->bind(':create_date', time());
        $this->db->bind(':modified_date', time());
        // excute
        if ($this->db->excute()) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * load news tickers
     *
     * @return object articles
     */
    public function getNewsTicker()
    {
        $results = $this->getFromTable('articles', 'article_id, description', ['news_ticker' => 1, 'status' => 1], '', '');
        return $results;
    }
    public function getArticles()
    {
        $results = $this->getFromTable('articles', '*', ['featured' => 1, 'status' => 1], 1, 4);
        return $results;
    }
}
