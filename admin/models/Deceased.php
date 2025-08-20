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

class Deceased extends ModelAdmin
{

    /**
     * setting table name
     */
    public function __construct()
    {
        parent::__construct('deceaseds');
    }

    /**
     * get all deceased from datatbase
     *
     * @param  string $cond
     * @param  array $bind
     * @param  string $limit
     * @param  mixed $bindLimit
     *
     * @return object Deceased data
     */
    public function getDeceased($cond = '', $bind = '', $limit = '', $bindLimit = '')
    {
        $query = 'SELECT deceaseds.*, projects.name as project, projects.project_id  FROM deceaseds, projects ' . $cond . ' ORDER BY deceaseds.create_date DESC ';
        return $this->getAll($query, $bind, $limit, $bindLimit);
    }

    /**
     * get count of all records
     * @param type $cond
     * @return type
     */
    public function allDeceasedCount($cond = '', $bind = '')
    {
        return $this->countAll($cond, $bind);
    }

    public function getProjectsSettingIds($cond = '', $bind = '', $limit = '', $bindLimit = ''){
        $query = 'SELECT `value` FROM `settings` WHERE `alias` = "deceased" LIMIT 1;';
        $row = $this->getAll($query, $bind, $limit, $bindLimit);
        return json_decode($row[0]->value);
        // 
    }
    /**
     * get all projects from datatbase with status
     *
     * @return object projects data
     */
    public function getProjectsWithIds($values)
    {     
        $values = str_replace("[", "(", $values);
        $values = str_replace("]", ")", $values);
        $query  = "SELECT `project_id`, `name` FROM `projects` WHERE projects.status = 1 AND `project_id` IN ". $values;
        return $this->getAll($query);
    }


    /**
     * get project Category from projects 
     *
     * @return object projects data
     */
    public function getProjectCategoryById($id)
    {     
        $query = 'SELECT `name` FROM `project_categories` WHERE `category_id` = ' . $id;
        return $this->getAll($query)[0]->name;

    }
    /**
     * get project from Deceased 
     *
     * @return object projects data
     */
    public function getProjectById($id)
    {     
        $deceased = $this->getById($id, 'deceased_id');
        $query = 'SELECT projects.* , project_categories.name as category FROM `projects`, project_categories WHERE   project_categories.category_id = projects.category_id  AND `project_id` = ' . $deceased->project_id;
        return $this->getAll($query)[0];
    }

    /**
     * get Deceased by id
     * @param integer $id
     * @return object Deceased data
     */
    public function getDeceasedById($id)
    {
        return $this->getById($id, 'deceased_id');
    }
    
    /**
     * update Deceased  id in project  
     *
     * @return object projects data
     */
    public function updateProjectDeceaseds($deceased_id, $project_id)
    {     
        $query = 'UPDATE `projects` SET `deceased_id`= :deceased_id  WHERE `project_id` = :project_id';
        $this->db->query($query);
        $this->db->bind(':deceased_id', $deceased_id);
        $this->db->bind(':project_id', $project_id);
          // excute
        if ($this->db->excute()) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * get project by decesed id  
     *
     * @return object projects data
     */
    public function getProjectByDeceasedId($deceased_id)
    {     
        $query = 'SELECT *  FROM `projects` WHERE   `deceased_id` = ' . $deceased_id;
        return $this->getAll($query)[0];
    }

    /**
     * update project  id in Deceased  
     *
     * @return object projects data
     */
    public function updateDeceasedsProject($deceased_id, $project_id)
    {     
        $query = 'UPDATE `deceaseds` SET `project_id` = :project_id WHERE   `deceased_id`= :deceased_id';
        $this->db->query($query);
        $this->db->bind(':deceased_id', $deceased_id);
        $this->db->bind(':project_id', $project_id);
          // excute
        if ($this->db->excute()) {
            return true;
        } else {
            return false;
        }
    }
    
    /**
     * update Confirm  in Deceased  
     *
     */
    public function updateDeceasedsConfirmed($deceased_id) {     
        $query = 'UPDATE `deceaseds` SET `confirmed`= 1  WHERE `deceased_id` = :deceased_id';
        $this->db->query($query);
        $this->db->bind(':deceased_id', $deceased_id);
          // excute
          if ($this->db->excute()) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * get orders  
     *
     */
    public function getOrdersByDeseasedID($deceased_id, $cond = '',  $bind = '', $limit = ''){
        $query = 'SELECT ord.*, p.title AS payment_method, d.full_name AS donor, d.mobile, d.email
        FROM orders ord,  payment_methods p , donors d 
        WHERE ord.payment_method_id = p.payment_id
        AND ord.donor_id = d.donor_id
        AND ord.status <> 2 
        AND ord.deceased_id = ' . $deceased_id  . ' ' . $cond . '';
        return $this->getAll($query, $bind);
    }

    /**
     * get Total  
     *
     */
    public function getOrderTotalById($deceased_id, $cond = '',  $bind = '', $limit = ''){
        $query = 'SELECT SUM(total) as total , COUNT(*) as count FROM orders ord WHERE   ord.status <> 2 '. $cond.' AND ord.deceased_id = ' . $deceased_id;
        return $this->getAll($query, $bind, $limit)[0];
    }

    /**
     * get Deseased from Project Id  
     *
     */
    public function getDeceasedByProjectId($project_id) {     
        $query = 'SELECT `deceased_id` FROM `projects` WHERE `project_id` = ' . $project_id;
        return $this->getAll($query)[0];
    }

    /**
     * get Deseased from Project Id  
     *
     */
    public function sendConfirmation($mobile, $project_id) {   
        $message = ' لقد تم تأكيد طلبكم بنجاح .. رابط الطلب ' . URLROOT . '/projects/show/' . $project_id ;
        $this->SMS($mobile, $message);
    }

}


