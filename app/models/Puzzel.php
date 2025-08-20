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

class Puzzel extends Model
{
    public function __construct()
    {
        parent::__construct('puzzels');
    }
    /**
     * categoriesCount
     *
     * @return void
     */
    public function puzzelsCount()
    {
        return $this->countAll(['status' => 1]);
    }
    /**
     * get all puzzels from datatbase
     * @return object page data
     */
    public function getPuzzels($start, $perpage)
    {
        return $this->get('*', ['status' => 1], $start, $perpage);
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
     * get all puzzel from datatbase
     * @return object page data
     */

    public function getPuzzelById($id)
    {
        return $this->getBy(['puzzel_id' => $id, 'status' => 1]);
    }
    /**
     * save player data to db
     *
     * @param array $data
     * @return void
     */
    public function addplayer($data)
    {
        $this->db->query('INSERT INTO players(puzzel_id, full_name,  email, phone, status, modified_date, create_date)'
            . ' VALUES (:puzzel_id, :full_name, :email, :phone, :status, :modified_date, :create_date)');
        // binding values
        $this->db->bind(':puzzel_id', $data['puzzel_id']);
        $this->db->bind(':full_name', $data['full_name']);
        $this->db->bind(':email', $data['email']);
        $this->db->bind(':phone', $data['phone']);
        $this->db->bind(':status', 0);
        $this->db->bind(':create_date', time());
        $this->db->bind(':modified_date', time());

        // excute
        if ($this->db->excute()) {
            return $this->db->lastId();
        } else {
            return false;
        }
    }

    public function updatePlayer($id)
    {
        $this->db->query('UPDATE players SET share = 1 WHERE player_id = :player_id');
        //loop through the bind function to bind all the IDs
        $this->db->bind(':player_id', $id);

        if ($this->db->excute()) {
            return $this->db->rowCount();
        } else {
            return false;
        }
    }
}
