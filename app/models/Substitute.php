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

class Substitute extends Model
{

    /**
     * setting table name
     */
    public function __construct()
    {
        parent::__construct('substitutes');
    }



    /**
     * insert new Substitute
     * @param array $data
     * @return boolean
     */
    public function addSubstitute($data)
    {
        
        $this->db->query('INSERT INTO `substitutes`( image, full_name, identity, phone, nationality, gender, email, languages, status, modified_date, create_date)'
            . ' VALUES ( :image, :full_name, :identity, :phone, :nationality, :gender, :email, :languages, :status, :modified_date, :create_date)');
        // binding values
        $this->db->bind(':identity', $data['identity']);
        $this->db->bind(':image', $data['image']);
        $this->db->bind(':full_name', $data['full_name']);
        $this->db->bind(':phone', $data['phone']);
        $this->db->bind(':nationality', $data['nationality']);
        $this->db->bind(':gender', $data['gender']);
        $this->db->bind(':email', $data['email']);
        $this->db->bind(':languages', implode(',', $data['languages']) );
        $this->db->bind(':status', '0');
        $this->db->bind(':create_date', time());
        $this->db->bind(':modified_date', time());

        // excute
        if ($this->db->excute()) {
            return true;
        } else {
            return false;
        }  $this->db->query('INSERT INTO `substitutes`( image, full_name, identity, phone, nationality, gender, email, languages, status, modified_date, create_date)'
            . ' VALUES ( :image, :full_name, :identity, :phone, :nationality, :gender, :email, :languages, :status, :modified_date, :create_date)');
        // binding values
        $this->db->bind(':identity', $data['identity']);
        $this->db->bind(':image', $data['image']);
        $this->db->bind(':full_name', $data['full_name']);
        $this->db->bind(':phone', $data['phone']);
        $this->db->bind(':nationality', $data['nationality']);
        $this->db->bind(':gender', $data['gender']);
        $this->db->bind(':email', $data['email']);
        $this->db->bind(':languages', implode(',', $data['languages']) );
        $this->db->bind(':status', '0');
        $this->db->bind(':create_date', time());
        $this->db->bind(':modified_date', time());

        // excute
        if ($this->db->excute()) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * list all Substitute
     * @param array $data
     * @return boolean
     */
    public function getSubstitutes() {
        $query = 'SELECT `substitute_id`, `full_name`, `gender`, `create_date` FROM `substitutes`  WHERE `status` <> 2 ';
        $this->db->query($query);
        return ($this->db->resultSet());
    }

    /**
     * select all Substitute
     * @param array $data
     * @return boolean
     */
    public function selectSubstitutes($data) {
        $query = 'UPDATE `badal_orders` SET `substitute_id` = :substitute_id, `modified_date` = :modified_date  WHERE `badal_id`= :badal_id';
        $this->db->query($query);
        $this->db->bind(':substitute_id', $data['substitute_id']);
        $this->db->bind(':modified_date', time());
        $this->db->bind(':badal_id', $data['badal_id']);
          // excute
        if ($this->db->excute()) {
            return true;
        } else {
            return false;
        }
    }


    /**
     * select all Substitute has order totday
     * @param array $data
     * @return boolean
     */
    public function gettSubstitutesHasOrderToday() {
        $query = 'SELECT `requests`.*, `substitutes`.phone, `substitutes`.email, `substitutes`.full_name,
                         `orders`.total, `orders`.order_identifier, `projects`.`name` AS project_name
                  FROM `requests`, `substitutes`, `badal_orders`, `orders`, `projects`
                  WHERE `requests`.substitute_id  = `substitutes`.substitute_id  
                  AND `requests`.badal_id = `badal_orders`.badal_id
                  AND `badal_orders`.order_id = `orders`.order_id
                  AND `projects`.project_id = `badal_orders`.project_id
                  AND `requests`.is_selected = 1 
                  AND `requests`.`status` = 1
                  AND `badal_orders`.`status` = 1
                  AND `substitutes`.`status` = 1
                  AND DATE( FROM_UNIXTIME(`requests`.`start_at`)) = CURDATE(); ';
        $this->db->query($query);
        return ($this->db->resultSet());
    }


}
