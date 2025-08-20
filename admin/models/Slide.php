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

class Slide extends ModelAdmin
{

    public function __construct()
    {
        parent::__construct('slides');
    }

    /**
     * get all slides from datatbase
     *
     * @param  string $cond
     * @param  array $bind
     * @param  string $limit
     * @param  mixed $bindLimit
     *
     * @return object slides data
     */
    public function getSlides($cond = '', $bind = '', $limit = '', $bindLimit = 50)
    {
        $query = 'SELECT * FROM slides ' . $cond . ' ORDER BY slides.create_date DESC ';

        return $this->getAll($query, $bind, $limit, $bindLimit);
    }

    /**
     * get count of all records
     * @param type $cond
     * @return type
     */
    public function allSlidesCount($cond = '', $bind = '')
    {
        return $this->countAll($cond, $bind);
    }

    /**
     * insert new slides
     * @param array $data
     * @return boolean
     */
    public function addSlide($data)
    {
        $this->db->query('INSERT INTO slides( name, alias, description, image, arrangement, url, status, modified_date, create_date)'
            . ' VALUES (:name, :alias, :description, :image, :arrangement, :url, :status, :modified_date, :create_date)');
        // binding values
        $this->db->bind(':name', $data['name']);
        $this->db->bind(':alias', $data['alias']);
        $this->db->bind(':description', $data['description']);
        $this->db->bind(':image', $data['image']);
        $this->db->bind(':arrangement', $data['arrangement']);
        $this->db->bind(':url', $data['url']);
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

    public function updateSlide($data)
    {
        $query = 'UPDATE slides SET name = :name, description = :description, arrangement = :arrangement, url = :url, status = :status, modified_date = :modified_date';

        (empty($data['image'])) ? null : $query .= ', image = :image';

        $query .= ' WHERE slide_id = :slide_id';
        $this->db->query($query);
        // binding values
        $this->db->bind(':slide_id', $data['slide_id']);
        $this->db->bind(':name', $data['name']);
        $this->db->bind(':description', $data['description']);
        $this->db->bind(':arrangement', $data['arrangement']);
        $this->db->bind(':url', $data['url']);
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
     * get slide by id
     * @param integer $id
     * @return object slide data
     */
    public function getSlideById($id)
    {
        return $this->getById($id, 'slide_id');
    }

}
