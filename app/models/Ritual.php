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

class Ritual extends Model
{
    public function __construct()
    {
        parent::__construct('rituals');
    }

    /**
     * getRitualById
     *
     * @param  mixed $id
     *
     * @return object ritual
     */
    public function getRitualById($id)
    {
        return $this->getBy(['ritual_id' => $id, 'status' => 1]);
    }

    /**
     * categoriesCount
     *
     * @return void
     */
    public function ritualsCount()
    {
        return $this->countAll(['status' => 1]);
    }

    /**
     * get all getRituals
     *
     * @param  mixed $cond
     * @param  mixed $start
     * @param  mixed $perpage
     * @return object
     */
    public function getRituals($start, $perpage)
    {
        return $this->get('*', ['status' => 1], $start, $perpage);
    }

    /**
     * get all Rites By ProjectId 
     *
     * @param  mixed $projectId
     * @return object
     */
    public function getRitesByProjectId($projectId)
    {
        $query = 'SELECT rite_id AS id, title, proof, CONCAT( "' . URLROOT .'/media/files/rites/" , image) AS image FROM `rites`  WHERE rites.status <> 2 AND rites.project_id =  ' . $projectId . ' ORDER BY arrangement';
        $this->db->query($query);
        return ($this->db->resultSet());
    }

    /**
     * get project by id   
     *
     * @param  mixed $projectId
     * @return object
     */
    public function getProject($projectId){
        $query = 'SELECT * FROM `projects`  WHERE `status` <> 2 AND `project_id` =  ' . $projectId;
        $this->db->query($query);
        return $this->db->single();

    }

   /**
     * get Rituals by order_id   
     *
     * @param  mixed $order_id
     * @return object
     */
    public function getRitualsByOrder($order_id) {
        $query = 'SELECT `ritual_id`, `title`, `proof`, `start`, `complete`, 
        (SELECT name FROM `projects` WHERE `rituals`.project_id = `projects`.project_id ) As project_name,
        (SELECT CONCAT("' . URLROOT . '/media/files/rites/", `image`)   FROM `rites` WHERE `rites`.rite_id = `rituals`.rite_id ) As image
         FROM `rituals`  WHERE `status` <> 2 AND `order_id` =  ' . $order_id . '  ORDER BY create_date';
        $this->db->query($query);
        return $this->db->resultSet();
    }
    
    
    /**
     * start new Rituals  (save rites ) 
     *
     * @param  mixed $projectId
     * @param  mixed $substituteId
     * @return object
     */
    public function storeRituals($rite, $data){
        $query = 'INSERT INTO rituals ( title, project_id, order_id, rite_id, substitute_id, proof, start, status, complete, modified_date, create_date)'
                . ' VALUES (:title, :project_id, :order_id, :rite_id, :substitute_id, :proof, :start, :status, :complete, :modified_date, :create_date)';
        $this->db->query($query);
        // binding values
        $this->db->bind(':title', $rite->title);
        // $this->db->bind(':type',  $data['project']->name);
        $this->db->bind(':project_id',   $data['project']->project_id);
        $this->db->bind(':order_id',   $data['order_id']);
        $this->db->bind(':substitute_id',  $data['substitute_id']);
        $this->db->bind(':rite_id', $rite->id);
        $this->db->bind(':proof', $rite->proof);
        $this->db->bind(':start', 0);
        $this->db->bind(':complete', 0);
        $this->db->bind(':status', 1);
        $this->db->bind(':modified_date', time());
        $this->db->bind(':create_date', time());
        // excute
        if ($this->db->excute()) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * check require proof from Rites 
     *
     * @param  mixed $order_id
     * @return object
     */
    public function getProofRites($order_id){
        $query = 'SELECT `proof FROM `rites`  WHERE `status` <> 2 AND `order_id` =  ' . $order_id;
        $this->db->query($query);
        return $this->db->single();
    }

    /**
     * check require proof from Rites 
     *
     * @param  mixed $order_id
     * @return object
     */
    public function getuncompleterdRitual($order_id){
        $query = 'SELECT `ritual_id` FROM `rituals`  WHERE `status` <> 2 AND `order_id` = :order_id AND `start` = 1 AND `complete` = 0 ';
        $this->db->query($query);
        $this->db->bind(':order_id', $order_id);
        return $this->db->resultSet();
    }

    /**
     * update Rites (proof - complete )
     *
     * @param  mixed $ritual_id 
     * @param  mixed $proof 
     * @return object
     */
    public function updateProofRituals($ritual_id, $proof){
        $query = 'UPDATE `rituals` SET `proof` = :proof, `complete` = 1 WHERE   `ritual_id`= :ritual_id';
        $this->db->query($query);
        $this->db->bind(':proof', $proof);
        $this->db->bind(':ritual_id', $ritual_id);
          // excute
        if ($this->db->excute()) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * update Rites (complete )
     *
     * @param  mixed $ritual_id 
     * @param  mixed $proof 
     * @return object
     */
    public function updateCompleteRituals($ritual_id){
        $query = 'UPDATE `rituals` SET  `complete` = 1 WHERE   `ritual_id`= :ritual_id';
        $this->db->query($query);
        $this->db->bind(':ritual_id', $ritual_id);
          // excute
        if ($this->db->excute()) {
            return true;
        } else {
            return false;
        }
    }


    /**
     * get Rites befor one rites
     *
     * @param  mixed $order_id 
     * @param  mixed $ritual_id 
     * @return object
     */
    public function getOrderRites($order_id, $ritual_id ){
        $query = 'SELECT * FROM `rituals` WHERE `order_id` = :order_id  AND `ritual_id` < ' . $ritual_id . 
        ' AND (`start` = 0 OR  `complete` = 0 )';
        $this->db->query($query);
        $this->db->bind(':order_id', $order_id);
        return $this->db->resultSet();
    }
    
    /**
     * update Rites (complete )
     *
     * @param  mixed $ritual_id 
     * @param  mixed $proof 
     * @return object
     */
    public function updateStartRituals($ritual_id){
        $query = 'UPDATE `rituals` SET  `start` = 1, `start_time` = :start_time  WHERE   `ritual_id`= :ritual_id';
        $this->db->query($query);
        $this->db->bind(':ritual_id', $ritual_id);
        $this->db->bind(':start_time', time());
          // excute
          if ($this->db->excute()) {
              return true;
        } else {
            return false;
        }
    }

    /**
     * get Time taken 
     *
     * @param  mixed $id 
     * @return object
     */
    public function getTimeTaken($rite_id ){
        $query = 'SELECT time_taken FROM `rites` WHERE `rite_id` = :rite_id ' ;
        $this->db->query($query);
        $this->db->bind(':rite_id', $rite_id);
        return $this->db->single();
    }

    /**
     * update video 
     *
     * @param  mixed $ritual_id 
     * @param  mixed $proof 
     * @return object
     */
    public function uploadVideo($ritual_id, $proof){
        $query = 'UPDATE `rituals` SET `proof` = :proof WHERE   `ritual_id`= :ritual_id';
        $this->db->query($query);
        $this->db->bind(':proof', $proof);
        $this->db->bind(':ritual_id', $ritual_id);
          // excute
        if ($this->db->excute()) {
            return true;
        } else {
            return false;
        }
    }
}
