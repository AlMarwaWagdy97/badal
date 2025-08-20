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

class Menu extends ModelAdmin
{

    public function __construct()
    {
        parent::__construct('menus');
    }

    /**
     * get all menus from datatbase
     *
     * @param  string $cond
     * @param  array $bind
     * @param  string $limit
     * @param  mixed $bindLimit
     *
     * @return object menus data
     */
    public function getMenus($cond = '', $bind = '', $limit = '', $bindLimit, $cols = '*')
    {
        $list_ids = $this->arrang_records('WHERE status <> 2');
        // dd($cond. $bind. $limit. $bindLimit);
        !empty($list_ids) ?: $list_ids = [0];
        $query = 'SELECT ' . $cols . ' FROM menus ' . $cond . ' AND menu_id IN (' . implode(',', $list_ids) . ') ORDER BY FIND_IN_SET(menu_id,"' . implode(',', $list_ids) . '"), menus.create_date DESC ';
        return $this->getAll($query, $bind, $limit, $bindLimit);
    }

    /**
     * get multi level records
     * @param string $table database table
     * @param string  $condation 
     * @return array array of all records ips sorted from pparent to chiled
     */
    public function arrang_records($cond = '')
    {
        $list_ids = [];
        $query = 'SELECT menu_id, parent_id FROM menus ' . $cond . ' ORDER BY menus.create_date DESC ';
        $total = $this->getAll($query);

        foreach ($total as $parent) {
            if ($parent->parent_id == 0) {
                $list_ids[] = $parent->menu_id;
                $this->arrange_child($total, $parent->menu_id, $list_ids);
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
                $list_ids[] = $child->menu_id;
                $this->arrange_child($total, $child->menu_id, $list_ids);
            }
        }
    }

    /**
     * get count of all records
     * @param type $cond
     * @return type
     */
    public function allMenusCount($cond = '', $bind = '')
    {
        return $this->countAll($cond, $bind);
    }

    /**
     * insert new menus
     * @param array $data
     * @return boolean
     */
    public function addMenu($data)
    {
        $this->db->query('INSERT INTO menus( name, alias, parent_id, level, type, arrangement, url, status, modified_date, create_date)'
            . ' VALUES (:name, :alias, :parent_id, :level, :type, :arrangement, :url, :status, :modified_date, :create_date)');
        // binding values
        $this->db->bind(':name', $data['name']);
        $this->db->bind(':alias', $data['alias']);
        $this->db->bind(':parent_id', $data['parent_id']);
        $this->db->bind(':level', $data['level'] + 1);
        $this->db->bind(':type', $data['type']);
        $this->db->bind(':arrangement', $data['arrangement']);
        $this->db->bind(':url', $data['url']);
        $this->db->bind(':status', $data['status']);
        $this->db->bind(':modified_date', time());
        $this->db->bind(':create_date', time());

        // excute
        if ($this->db->excute()) {
            return true;
        } else {
            return false;
        }
    }

    public function updateMenu($data)
    {
        $query = 'UPDATE menus SET name = :name, parent_id = :parent_id, level = :level, type = :type, arrangement = :arrangement, url = :url, status = :status, modified_date = :modified_date';
        $query .= ' WHERE menu_id = :menu_id';
        $this->db->query($query);
        // binding values
        $this->db->bind(':menu_id', $data['menu_id']);
        $this->db->bind(':name', $data['name']);
        $this->db->bind(':parent_id', $data['parent_id']);
        $this->db->bind(':level', $data['level'] + 1);
        $this->db->bind(':type', $data['type']);
        $this->db->bind(':arrangement', $data['arrangement']);
        $this->db->bind(':url', $data['url']);
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
     * get menu by id
     * @param integer $id
     * @return object menu data
     */
    public function getMenuById($id)
    {
        return $this->getById($id, 'menu_id');
    }
}
