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

class Badaloffers extends ModelAdmin
{

    public function __construct()
    {
        parent::__construct('badal_offers');
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
    public function getBadaloffers($cond = '', $bind = '', $limit = '', $bindLimit = 50)
    {
        $query = 'SELECT offers.*, projects.name as project, `substitutes`.full_name as substitute_name  FROM `badal_offers` offers, projects, substitutes ' . $cond . ' ORDER BY offers.create_date DESC ';
        // dd($query);
        return $this->getAll($query, $bind, $limit, $bindLimit);
    }

    /**
     * get count of all records
     * @param type $cond
     * @return type
     */
    public function allBadaloffersCount($cond = '', $bind = '')
    {
        $this->db->query('SELECT count(*) as count FROM `' . $this->table . '` offers ' . $cond);
        if (!empty($bind)) {
            foreach ($bind as $key => $value) {
                $this->db->bind($key, '%' . $value . '%');
            }
        }
        $this->db->excute();
        return $this->db->single();
    }

    /**
     * handling Search Condition, creating bind array and handling search session
     *
     * @param  array $searches
     * @return array of condation and bind array
     */
    public function handlingSearchCondition($searches)
    {
        //reset search session
        unset($_SESSION['search']);
        $cond = '';
        $bind = [];
        if (!empty($searches)) {
            foreach ($searches as $keyword) {
                $cond .= ' AND offers.' . $keyword . ' LIKE :' . $keyword . ' ';
                $bind[':' . $keyword] = $_POST['search'][$keyword];
                $_SESSION['search'][$keyword] = $_POST['search'][$keyword];
            }
        }
        return $data = ['cond' => $cond, 'bind' => $bind];
    }


    /**
     * get list of badalorders categories
     * @param string $cond
     * @return object categories list
     */
    public function projectsList($cond = '')
    {
        $query = 'SELECT project_id, name FROM projects  ' . $cond . ' AND badal = 1 ORDER BY create_date DESC ';
        $this->db->query($query);
        $results = $this->db->resultSet();
        return $results;
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
     * get offer by id
     * @param string $offer_id
     * @return object order 
     */
    public function getOfferByID($offer_id)
    {
        $query = 'SELECT `offers`.*, `projects`.name as project, `substitutes`.full_name as substitute_name, 
                        `substitutes`.email,  `substitutes`.phone, `substitutes`.nationality, `substitutes`.gender, `substitutes`.languages, `substitutes`.identity,
                        CONCAT("' . MEDIAURL .  '/../files/substitutes/", substitutes.image ) AS substitute_image
                    FROM `badal_offers` offers, `projects`, `substitutes` 
                    WHERE `offers`.offer_id = :offer_id  
                    AND `offers`.status <> 2 
                    AND `offers`.project_id = `projects`.project_id 
                    AND `offers`.substitute_id = `substitutes`.substitute_id 
                ORDER BY `offers`.create_date DESC ';
        $this->db->query($query);
        $this->db->bind(':offer_id', $offer_id);
        $this->db->excute();
        return $this->db->single();
    }

    /**
     * get last Id
     * @return integr
     */
    public function lastId()
    {
        return $this->db->lastId();
    }

    /**
     * get Offers By Subsitute Id
     * @return integr
     */
    public function geOffersBySubsitute($substitute_id)
    {
        $query = 'SELECT `badal_offers`.*, projects.name as project, `substitutes`.full_name as substitute_name
                  FROM `badal_offers`, `projects`, `substitutes`
                  WHERE `badal_offers`.`substitute_id` = :substitute_id 
                  AND `badal_offers`.`project_id` = `projects`.project_id 
                  AND `badal_offers`.`substitute_id` = `substitutes`.substitute_id 
                  AND `badal_offers`.`status` <> 2 
                  ORDER BY `badal_offers`.`create_date` DESC ';
        $this->db->query($query);
        $this->db->bind(':substitute_id', $substitute_id);
        $results = $this->db->resultSet();
        return $results;
    }


    /**
     * canceled one or more records by id
     * @param Array $ids
     * @param string colomn id
     * @return boolean or row count
     */
    public function canceledById($ids, $where)
    {
        //get the id in PDO form @Example :id1,id2
        for ($index = 1; $index <= count($ids); $index++) {
            $id_num[] = ":id" . $index;
        }
        //setting the query
        $this->db->query('UPDATE ' . $this->table . ' SET status = 4 WHERE ' . $where . ' IN (' . implode(',', $id_num) . ')');
        //loop through the bind function to bind all the IDs
        foreach ($ids as $key => $id) {
            $this->db->bind(':id' . ($key + 1), $id);
        }
        if ($this->db->excute()) {
            return $this->db->rowCount();
        } else {
            return false;
        }
    }

    /**
     * get Pending Offers
     * @return integr
     */
    public function getPendingOffers()
    {
        $query = 'SELECT COUNT(*) as count FROM `badal_offers` WHERE `status` = 0; ';
        $this->db->query($query);
        return$this->db->single();
    }


}
