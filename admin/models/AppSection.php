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

class AppSection extends ModelAdmin
{

    public function __construct()
    {
        parent::__construct('app_sections');
    }

    /**
     * get all app_sections from datatbase
     *
     * @param  string $cond
     * @param  array $bind
     * @param  string $limit
     * @param  mixed $bindLimit
     *
     * @return object app_sections data
     */
    public function getAppSections($cond = '', $bind = '', $limit = '', $bindLimit = 50, $cols = '*')
    {
        $query = 'SELECT * FROM app_sections ' . $cond . ' ORDER BY app_sections.create_date DESC ';

        return $this->getAll($query, $bind, $limit, $bindLimit);
    }



    /**
     * get count of all records
     * @param type $cond
     * @return type
     */
    public function allAppSectionsCount($cond = '', $bind = '')
    {
        return $this->countAll($cond, $bind);
    }

    /**
     * insert new app_sections
     * @param array $data
     * @return boolean
     */
    public function addAppSection($data)
    {
        $this->db->query('INSERT INTO app_sections( name, alias, description, image, arrangement, featured, status, modified_date, create_date)'
                            . ' VALUES (:name, :alias, :description, :image, :arrangement,:featured, :status, :modified_date, :create_date)');
        // binding values
        $this->db->bind(':name', $data['name']);
        $this->db->bind(':alias', $data['alias']);
        $this->db->bind(':description', $data['description']);
        $this->db->bind(':image', $data['image']);
        $this->db->bind(':arrangement', $data['arrangement']);
        $this->db->bind(':featured', $data['featured']);
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

    public function updateAppSection($data)
    {
        $query = 'UPDATE app_sections SET name = :name, description = :description, arrangement = :arrangement, featured=:featured, status = :status, modified_date = :modified_date';

        (empty($data['image'])) ? null : $query .= ', image = :image';

        $query .= ' WHERE section_id = :section_id';
        $this->db->query($query);
        // binding values
        $this->db->bind(':section_id', $data['section_id']);
        $this->db->bind(':name', $data['name']);
        $this->db->bind(':description', $data['description']);
        $this->db->bind(':arrangement', $data['arrangement']);
        $this->db->bind(':featured', $data['featured']);
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
     * get app_section by id
     * @param integer $id
     * @return object app_section data
     */
    public function getAppSectionById($id)
    {
        return $this->getById($id, 'section_id');
    }

}
