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

class Store extends ModelAdmin
{

    public function __construct()
    {
        parent::__construct('stores');
    }

    /**
     * get all stores from datatbase
     *
     * @param  string $cond
     * @param  array $bind
     * @param  string $limit
     * @param  mixed $bindLimit
     *
     * @return object stores data
     */
    public function getStores($cond = '', $bind = '', $limit = '', $bindLimit = '')
    {
        $query = 'SELECT * FROM stores ' . $cond . ' ORDER BY stores.create_date DESC ';
        return $this->getAll($query, $bind, $limit, $bindLimit);
    }

    /**
     * get count of all records
     * @param type $cond
     * @return type
     */
    public function allStoresCount($cond = '', $bind = '')
    {
        return $this->countAll($cond, $bind);
    }

    /**
     * insert new stores
     * @param array $data
     * @return boolean
     */
    public function addStore($data)
    {
        $this->db->query('INSERT INTO stores( alias, name, user, password, email, employee_name, employee_image, employee_number, job, department, location, mobile, whatsapp,
                ax_store_number, details, background_color, background_image, meta_keywords, meta_description, status, modified_date, create_date)'
            . ' VALUES (:alias, :name, :user, :password, :email, :employee_name, :employee_image, :employee_number, :job, :department, :location, :mobile, :whatsapp,
             :ax_store_number, :details, :background_color, :background_image, :meta_keywords, :meta_description, :status, :modified_date, :create_date)');
        // binding values
        $this->db->bind(':alias', $data['alias']);
        $this->db->bind(':name', $data['name']);
        $this->db->bind(':user', $data['user']);
        $this->db->bind(':password', password_hash($data['password'], PASSWORD_DEFAULT));
        $this->db->bind(':email', $data['email']);
        $this->db->bind(':employee_name', $data['employee_name']);
        $this->db->bind(':employee_image', $data['employee_image']);
        $this->db->bind(':employee_number', $data['employee_number']);
        $this->db->bind(':job', $data['job']);
        $this->db->bind(':ax_store_number', $data['ax_store_number']);
        $this->db->bind(':department', $data['department']);
        $this->db->bind(':location', $data['location']);
        $this->db->bind(':mobile', $data['mobile']);
        $this->db->bind(':whatsapp', $data['whatsapp']);
        $this->db->bind(':details', $data['details']);
        $this->db->bind(':background_image', $data['background_image']);
        $this->db->bind(':background_color', $data['background_color']);
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

    public function updateStore($data)
    {
        $query = 'UPDATE stores SET alias =:alias, name = :name, email = :email, user = :user, employee_name = :employee_name, employee_number = :employee_number, job = :job, 
        department = :department, location = :location, mobile = :mobile, whatsapp = :whatsapp, details = :details, background_color =:background_color, 
        ax_store_number = :ax_store_number, meta_keywords = :meta_keywords, meta_description = :meta_description, status = :status, modified_date = :modified_date';
        (empty($data['employee_image'])) ? null : $query .= ', employee_image = :employee_image';
        (empty($data['password'])) ? null : $query .= ', password = :password';
        (empty($data['background_image'])) ? null : $query .= ', background_image = :background_image';
        $query .= ' WHERE store_id = :store_id';
        $this->db->query($query);
        // binding values
        $this->db->bind(':store_id', $data['store_id']);
        $this->db->bind(':alias', $data['alias']);
        $this->db->bind(':name', $data['name']);
        $this->db->bind(':email', $data['email']);
        $this->db->bind(':user', $data['user']);
        $this->db->bind(':employee_name', $data['employee_name']);
        $this->db->bind(':employee_number', $data['employee_number']);
        $this->db->bind(':department', $data['department']);
        $this->db->bind(':job', $data['job']);
        $this->db->bind(':ax_store_number', $data['ax_store_number']);
        $this->db->bind(':location', $data['location']);
        $this->db->bind(':mobile', $data['mobile']);
        $this->db->bind(':whatsapp', $data['whatsapp']);
        $this->db->bind(':details', $data['details']);
        $this->db->bind(':background_color', $data['background_color']);
        $this->db->bind(':meta_keywords', $data['meta_keywords']);
        $this->db->bind(':meta_description', $data['meta_description']);
        $this->db->bind(':status', $data['status']);
        $this->db->bind(':modified_date', time());
        empty($data['password']) ? null : $this->db->bind(':password', password_hash($data['password'], PASSWORD_DEFAULT));
        empty($data['employee_image']) ? null : $this->db->bind(':employee_image', $data['employee_image']);
        empty($data['background_image']) ? null : $this->db->bind(':background_image', $data['background_image']);
        // excute
        if ($this->db->excute()) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * get store by id
     * @param integer $id
     * @return object store data
     */
    public function getStoreById($id)
    {
        return $this->getById($id, 'store_id');
    }

    /**
     * check if alias exist 
     *
     * @param [string] $var
     * @return boolean
     */
    public function aliasExist($var)
    {
        $store = (array) $this->getById($var, 'alias');
        return count($store) < 2 ? $store : false;
    }

    /**
     * check if alias exist 
     *
     * @param [string] $var
     * @return boolean
     */
    public function aliasUpdate($alias, $store_id)
    {
        $query = 'SELECT * FROM stores WHERE alias =:alias AND store_id != :store_id';
        $this->db->query($query);
        $this->db->bind(':store_id', $store_id);
        $this->db->bind(':alias', $alias);
        $row = (array) $this->db->single();
        return count($row) < 2 ? $row : false;
    }

    /**
     * get all projects from datatbase
     *
     * @param  string $cond
     *
     * @return object projects data
     */
    public function getProjects($cond = '')
    {
        $query = 'SELECT * FROM projects ' . $cond . ' ORDER BY projects.create_date DESC ';
        return $this->getAll($query);
    }

    /**
     * add Project To Store
     *
     * @param [array] $projects
     * @param [int] $store_id
     * @return void
     */
    public function addProjectToStore($projects, $store_id)
    {
        $count = 0;
        foreach ($projects as $project_id) {
            $this->db->query('INSERT INTO stores_projects ( store_id, project_id, status, modified_date, create_date) VALUES (:store_id, :project_id, :status, :modified_date, :create_date)');
            // binding values
            $this->db->bind(':store_id', $store_id);
            $this->db->bind(':project_id', $project_id);
            $this->db->bind(':status', 0);
            $this->db->bind(':create_date', time());
            $this->db->bind(':modified_date', time());
            // excute
            if ($this->db->excute()) {
                $count++;
            }
        }
        return $count;
    }

    /**
     * publish Project To Store
     *
     * @param [array] $projects
     * @param [int] $store_id
     * @return int
     */
    public function publishProjectToStore($projects, $store_id)
    {
        //get the id in PDO form @Example :id1,id2
        for ($index = 1; $index <= count($projects); $index++) {
            $id_num[] = ":id" . $index;
        }
        //setting the query
        $this->db->query('UPDATE stores_projects SET status = 1 WHERE store_id = :store_id AND project_id IN (' . implode(',', $id_num) . ')');
        $this->db->bind(':store_id', $store_id);
        //loop through the bind function to bind all the IDs
        foreach ($projects as $key => $id) {
            $this->db->bind(':id' . ($key + 1), $id);
        }
        if ($this->db->excute()) {
            return $this->db->rowCount();
        } else {
            return false;
        }
    }

    /**
     * unpublish Project To Store
     *
     * @param [array] $projects
     * @param [int] $store_id
     * @return int
     */
    public function unpublishProjectToStore($projects, $store_id)
    {
        //get the id in PDO form @Example :id1,id2
        for ($index = 1; $index <= count($projects); $index++) {
            $id_num[] = ":id" . $index;
        }
        //setting the query
        $this->db->query('UPDATE stores_projects SET status = 0 WHERE store_id = :store_id AND project_id IN (' . implode(',', $id_num) . ')');
        $this->db->bind(':store_id', $store_id);
        //loop through the bind function to bind all the IDs
        foreach ($projects as $key => $id) {
            $this->db->bind(':id' . ($key + 1), $id);
        }
        if ($this->db->excute()) {
            return $this->db->rowCount();
        } else {
            return false;
        }
    }


    /**
     * delete Project From Store
     *
     * @param [array] $projects
     * @param [int] $store_id
     * @return int
     */
    public function deleteProjectFromStore($projects, $store_id)
    {
        //get the id in PDO form @Example :id1,id2
        for ($index = 1; $index <= count($projects); $index++) {
            $id_num[] = ":id" . $index;
        }
        //setting the query
        $this->db->query('DELETE FROM stores_projects WHERE store_id = :store_id AND project_id IN (' . implode(',', $id_num) . ')');
        $this->db->bind(':store_id', $store_id);
        //loop through the bind function to bind all the IDs
        foreach ($projects as $key => $id) {
            $this->db->bind(':id' . ($key + 1), $id);
        }
        if ($this->db->excute()) {
            return $this->db->rowCount();
        } else {
            return false;
        }
    }

    /**
     * get all projects from datatbase
     *
     * @param  string $cond
     *
     * @return object projects data
     */
    public function getStoreProjects($store_id = '')
    {
        $query = 'SELECT pj.name, pj.project_number, pj.description, sps.* FROM projects pj, stores_projects sps 
        WHERE pj.status <> 2 AND pj.project_id IN (SELECT project_id FROM stores_projects WHERE store_id = ' . $store_id . ')
         AND sps.project_id = pj.project_id AND sps.store_id = ' . $store_id . '  ORDER BY sps.create_date DESC ';
        return $this->getAll($query);
    }
}
