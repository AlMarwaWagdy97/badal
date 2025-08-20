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

class Badalrequest extends ModelAdmin
{

    public function __construct()
    {
        parent::__construct('requests');
    }

    /**
     * get all badalorders from datatbase
     *
     * @param  string $cond
     * @param  array $bind
     * @param  string $limit
     * @param  mixed $bindLimit
     *
     * @return object badalorders data
     */
    public function getBadalRequests($cond = '', $bind = '', $limit = '', $bindLimit = 50)
    {
        $query = 'SELECT requests.*, `substitutes`.full_name as substitute_name  FROM `requests`, `substitutes` ' . $cond . 'AND requests.type = "badal"  ORDER BY requests.create_date DESC ';
        // dd($query);
        return $this->getAll($query, $bind, $limit, $bindLimit);
    }

    /**
     * get count of all records
     * @param type $cond
     * @return type
     */
    public function allBadalRequestsCount($cond = '', $bind = '')
    {
        $this->db->query('SELECT count(*) as count FROM `' . $this->table . '` ' . $cond);
        if (!empty($bind)) {
            foreach ($bind as $key => $value) {
                $this->db->bind($key, '%' . $value . '%');
            }
        }
        $this->db->excute();
        return $this->db->single();
    }



    /**
     * get list of substitutes
     * @param string $cond
     * @return object substitutes list
     */
    public function substitutesList($cond = '')
    {
        $query = 'SELECT substitute_id, full_name FROM substitutes  ' . $cond . '  ORDER BY create_date DESC ';
        $this->db->query($query);
        $results = $this->db->resultSet();
        return $results;
    }


    /**
     * get requests by badal id
     * @param string $badal_id
     * @return object requests list
     */
    public function getBadalRequestsByBadal($badal_id)
    {
        $query = 'SELECT requests.*, `substitutes`.full_name as substitute_name  
                  FROM `requests`, `substitutes` 
                  WHERE `requests`.badal_id = :badal_id 
                  AND `requests`.type = "badal" 
                  AND `requests`.substitute_id = `substitutes`.substitute_id  
                  AND `requests`.status <> 2 
                  ORDER BY `requests`.create_date DESC ';
        $this->db->query($query);
        $this->db->bind(':badal_id', $badal_id);
        $results = $this->db->resultSet();
        return $results;
    }

    /**
     * get last Id
     * @return integr
     */
    public function lastId()
    {
        return $this->db->lastId();
    }


}
