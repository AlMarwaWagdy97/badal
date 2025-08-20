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

class Deceased extends Model
{

    /**
     * setting table name
     */
    public function __construct()
    {
        parent::__construct('deceaseds');
    }



    /**
     * insert new deceased
     * @param array $data
     * @return boolean
     */
    public function addDeceased($data)
    {
        $this->db->query('INSERT INTO deceaseds( name, mobile, email, image, target_price, description, project_id, deceased_name, relative_relation, deceased_image, status, confirmed, create_date, modified_date)'
            . ' VALUES (:name, :mobile,   :email, :image, :target_price, :description, :project_id, :deceased_name, :relative_relation, :deceased_image, :status, :confirmed, :create_date, :modified_date)');
        // binding values
        $this->db->bind(':name', $data['name']);
        $this->db->bind(':mobile', $data['mobile']);
        $this->db->bind(':email', $data['email']);
        $this->db->bind(':image', $data['image']);
        $this->db->bind(':target_price', $data['target_price']);
        $this->db->bind(':description', $data['description']);
        $this->db->bind(':project_id', $data['project_id']);
        $this->db->bind(':deceased_name', $data['deceased_name']);
        $this->db->bind(':relative_relation', $data['relative_relation']);
        $this->db->bind(':deceased_image', $data['deceased_image']);
        $this->db->bind(':status', $data['status']);
        $this->db->bind(':confirmed', 0);
        $this->db->bind(':create_date', time());
        $this->db->bind(':modified_date', time());

        // excute
        if ($this->db->excute()) {
            return $this->db->lastId();
        } else {
            return false;
        }
    }

    /**
     * update Deceased data
     *
     * @param  mixed $data
     *
     * @return void
     */
    public function updateDeceased($data)
    {
        $query = 'UPDATE deceaseds SET email = :email, deleted = 0  WHERE deceased_id = :deceased_id';

        $query = 'UPDATE deceaseds SET  name = :name,  mobile = :mobile,  mobile_confirmed = :mobile_confirmed, email = :email, deceased_name = :deceased_name, relative_relation = :relative_relation, deceased_image = :deceased_image,  image = :image,  target_price = :target_price,  description = :description, project_id = :project_id,  status = :status'  ;
        $query .= ', modified_date = :modified_date  WHERE deceased_id = :deceased_id';

        $this->db->query($query);
        // binding values
        $this->db->bind(':deceased_id', $data['deceased_id']);
        $this->db->bind(':name', $data['name']);
        $this->db->bind(':mobile', $data['mobile']);
        $this->db->bind(':mobile_confirmed', $data['mobile_confirmed']);
        $this->db->bind(':email', $data['email']);
        $this->db->bind(':image', $data['image']);
        $this->db->bind(':target_price', $data['target_price']);
        $this->db->bind(':description', $data['description']);
        $this->db->bind(':project_id', $data['project_id']);
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
     * update user Mobile Confirmation
     *
     * @param [array] $data
     * @return void
     */
    public function updateMobileConfirmation($data)
    {
        $query = 'UPDATE deceaseds SET mobile_confirmed = :mobile_confirmed WHERE deceased_id = :deceased_id';
        $this->db->query($query);
        $this->db->bind(':deceased_id', $data['deceased_id']);
        $this->db->bind(':mobile_confirmed', $data['mobile_confirmed']);
        // excute
        if ($this->db->excute()) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * update user Email Confirmation
     *
     * @param [array] $data
     * @return void
     */
    public function updateEmail($data)
    {
        $query = 'UPDATE deceaseds SET email = :email, deleted = 0  WHERE deceased_id = :deceased_id';
        $this->db->query($query);
        $this->db->bind(':deceased_id', $data['deceased_id']);
        $this->db->bind(':email', $data['email']);
        // excute
        if ($this->db->excute()) {
            return true;
        } else {
            return false;
        }
    }
    
    /**
     * Find deceased by email
     * @param string $email
     * @return boolean
     */
    public function getdeceasedByMobile($mobile)
    {
        return $this->getSingle('*', ['mobile' => $mobile]);
    }



    /**
     * Find deceased by email
     * @param string $email
     * @return boolean
     */
    public function getDeceasedId($deceased_id)
    {
        return $this->getSingle('*', ['deceased_id' => $deceased_id]);
    }
    



    /**
     * Delete deceased by given id
     *
     * @param int $id
     * @return boolean
     */
    public function DeleteDeceased($id)
    {
        $query = 'UPDATE deceaseds SET deleted = 1 WHERE deceased_id = :deceased_id';
        $this->db->query($query);
        $this->db->bind(':deceased_id', $id);
        // excute
        if ($this->db->excute()) {
            return true;
        } else {
            return false;
        }
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
     * getAll data from database
     *
     * @param  string $cond
     * @param  array $bind
     * @param  string $limit
     * @param  array $bindLimit
     *
     * @return Object
     */
    public function getAll($query, $bind = '', $limit = '', $bindLimit = '')
    {
        $this->db->query($query . $limit);
        if (!empty($bind)) {
            foreach ($bind as $key => $value) {
                if ($key == ':category_id' && !empty($value)) {
                    $this->db->bind($key, '' . $value . '');
                } else {
                    $this->db->bind($key, '%' . $value . '%');
                }
            }
        }
        if (!empty($bindLimit)) {
            foreach ($bindLimit as $key => $value) {
                $this->db->bind($key, $value);
            }
        }
        return $this->db->resultSet();
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

        /**
     * get all deceased from datatbase
     *
     * @param  string $cond
     * @param  array $bind
     * @param  string $limit
     * @param  mixed $bindLimit
     *
     * @return object donor data
     */
    // public function getDeceased($cond = '', $bind = '', $limit = '', $bindLimit = '')
    // {
    //     $query = 'SELECT * FROM deceaseds  ' . $cond . ' ORDER BY deceased.create_date DESC ';
    //     return $this->getAll($query, $bind, $limit, $bindLimit);
    // }


}
