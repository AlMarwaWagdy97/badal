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

class ProjectCategory extends ModelAdmin
{

    public function __construct()
    {
        parent::__construct('project_categories');
    }

    /**
     * get all project_categories from datatbase
     *
     * @param  string $cond
     * @param  array $bind
     * @param  string $limit
     * @param  mixed $bindLimit
     *
     * @return object project_categories data
     */
    public function getProjectCategories($cond = '', $bind = '', $limit = '', $bindLimit = 50, $cols = '*')
    {
        $list_ids = $this->arrang_records($cond, $bind, $limit, $bindLimit);

        !empty($list_ids) ?: $list_ids = [0];
        $query = 'SELECT ' . $cols . ' FROM project_categories where category_id IN (' . implode(',', $list_ids) . ') ORDER BY FIND_IN_SET(category_id,"' . implode(',', $list_ids) . '"), project_categories.create_date DESC ';
        return $this->getAll($query);
    }

    /**
     * get multi level records
     * @param string $table database table
     * @param string  $condation 
     * @return array array of all records ips sorted from pparent to chiled
     */
    public function arrang_records($cond, $bind, $limit, $bindLimit)
    {
        $list_ids = [];
        $query = 'SELECT category_id, parent_id FROM project_categories ' . $cond . ' ORDER BY project_categories.create_date DESC ';
        $total = $this->getAll($query, $bind, $limit, $bindLimit);

        foreach ($total as $parent) {
            if ($parent->parent_id == 0) {
                $list_ids[] = $parent->category_id;
                $this->arrange_child($total, $parent->category_id, $list_ids);
            }
        }
        return $list_ids;
    }

    /**
     * @param array $total
     * @param int $paren_id
     * @param array $list_ids
     */
    function arrange_child($total, $paren_id, &$list_ids)
    {
        foreach ($total as $child) {
            if ($child->parent_id == $paren_id) {
                $list_ids[] = $child->category_id;
                $this->arrange_child($total, $child->category_id, $list_ids);
            }
        }
    }
    /**
     * get count of all records
     * @param type $cond
     * @return type
     */
    public function allProjectCategoriesCount($cond = '', $bind = '')
    {
        return $this->countAll($cond, $bind);
    }
    /**
     * get list of projects categories
     * @param string $cond
     * @return object categories list
     */
    public function categoriesList($cond = '')
    {
        $query = 'SELECT category_id, name, level, parent_id FROM project_categories  ' . $cond . ' ORDER BY create_date DESC ';
        $this->db->query($query);
        $results = $this->db->resultSet();
        return $results;
    }
    /**
     * insert new project_categories
     * @param array $data
     * @return boolean
     */
    public function addProjectCategory($data)
    {
        $this->db->query('INSERT INTO project_categories( name, alias, kafara, parent_id, level, description, image, arrangement, background_image, ads_banner, ads_url, ads2_banner, ads2_url, section_bg, background_color, featured, back_home, meta_keywords, meta_description, status, modified_date, create_date)'
            . ' VALUES (:name, :alias, :kafara, :parent_id, :level, :description, :image, :arrangement, :background_image, :ads_banner, :ads_url, :ads2_banner, :ads2_url, :section_bg, :background_color, :featured, :back_home, :meta_keywords, :meta_description, :status, :modified_date, :create_date)');
        // binding values
        $this->db->bind(':name', $data['name']);
        $this->db->bind(':alias', $data['alias']);
        $this->db->bind(':parent_id', $data['parent_id']);
        $this->db->bind(':level', $data['level'] + 1);
        $this->db->bind(':description', $data['description']);
        $this->db->bind(':image', $data['image']);
        $this->db->bind(':arrangement', $data['arrangement']);
        $this->db->bind(':kafara', $data['kafara']);
        $this->db->bind(':background_image', $data['background_image']);
        $this->db->bind(':ads_banner', $data['ads_banner']);
        $this->db->bind(':ads_url', $data['ads_url']);
        $this->db->bind(':ads2_banner', $data['ads2_banner']);
        $this->db->bind(':ads2_url', $data['ads2_url']);
        $this->db->bind(':section_bg', $data['section_bg']);
        $this->db->bind(':background_color', $data['background_color']);
        $this->db->bind(':featured', $data['featured']);
        $this->db->bind(':back_home', $data['back_home']);
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

    public function updateProjectCategory($data)
    {
        $query = 'UPDATE project_categories SET name = :name, parent_id = :parent_id, level = :level, description = :description, arrangement = :arrangement, kafara = :kafara, back_home = :back_home, meta_keywords = :meta_keywords,'
            . ' background_color =:background_color, ads_url=:ads_url, ads2_url=:ads2_url, section_bg=:section_bg, featured=:featured, meta_description = :meta_description, status = :status, modified_date = :modified_date';

        (empty($data['image'])) ? null : $query .= ', image = :image';
        (empty($data['background_image'])) ? null : $query .= ', background_image = :background_image';
        (empty($data['ads_banner'])) ? null : $query .= ', ads_banner = :ads_banner';
        (empty($data['ads2_banner'])) ? null : $query .= ', ads2_banner = :ads2_banner';

        $query .= ' WHERE category_id = :category_id';
        $this->db->query($query);
        // binding values
        $this->db->bind(':parent_id', $data['parent_id']);
        $this->db->bind(':level', $data['level'] + 1);
        $this->db->bind(':category_id', $data['category_id']);
        $this->db->bind(':name', $data['name']);
        $this->db->bind(':description', $data['description']);
        $this->db->bind(':arrangement', $data['arrangement']);
        $this->db->bind(':kafara', $data['kafara']);
        $this->db->bind(':back_home', $data['back_home']);
        $this->db->bind(':background_color', $data['background_color']);
        $this->db->bind(':ads_url', $data['ads_url']);
        $this->db->bind(':ads2_url', $data['ads2_url']);
        $this->db->bind(':section_bg', $data['section_bg']);
        $this->db->bind(':featured', $data['featured']);
        $this->db->bind(':meta_keywords', $data['meta_keywords']);
        $this->db->bind(':meta_description', $data['meta_description']);
        $this->db->bind(':status', $data['status']);
        $this->db->bind(':modified_date', time());
        empty($data['image']) ? null : $this->db->bind(':image', $data['image']);
        empty($data['background_image']) ? null : $this->db->bind(':background_image', $data['background_image']);
        empty($data['ads_banner']) ? null : $this->db->bind(':ads_banner', $data['ads_banner']);
        empty($data['ads2_banner']) ? null : $this->db->bind(':ads2_banner', $data['ads2_banner']);
        // excute
        if ($this->db->excute()) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * get project_category by id
     * @param integer $id
     * @return object project_category data
     */
    public function getProjectCategoryById($id)
    {
        return $this->getById($id, 'category_id');
    }


    public function removeAdsBanner($id, $field_name)
    {
        $query = 'UPDATE project_categories SET ' . $field_name . ' = NULL WHERE category_id = :category_id';
        $this->db->query($query);
        // binding values
        $this->db->bind(':category_id', $id);
        // excute
        if ($this->db->excute()) {
            return true;
        } else {
            return false;
        }
    }
}
