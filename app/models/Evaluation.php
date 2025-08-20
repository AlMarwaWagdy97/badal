<?php

/*
 * Copyright (C) 2024 Easy CMS Framework Ahmed Elmahdy
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

class Evaluation extends Model
{

    /**
     * setting table name
     */
    public function __construct()
    {
        parent::__construct('evaluation_answers');
    }

    /**
     * insert new Substitute
     * @param array $data
     * @return boolean
     */
    public function addAnswer($data)
    {
        
        $this->db->query('INSERT INTO `evaluation_answers`( `type`, `name`, `mobile`, `email`, `answers`, `points`, `points_text`,  `status`, modified_date, create_date)'
            . ' VALUES ( :type, :name, :mobile, :email, :answers, :points, :points_text, :status, :modified_date, :create_date)');
        // binding values
        
        $this->db->bind(':type', $data['type']);
        $this->db->bind(':name', $data['name']);
        $this->db->bind(':mobile', $data['mobile']);
        $this->db->bind(':email', $data['email']);
        $this->db->bind(':answers', $data['client_answer']);
        $this->db->bind(':points', $data['points']);
        $this->db->bind(':points_text', $data['points_text']);
        $this->db->bind(':status', 0);
        $this->db->bind(':create_date', time());
        $this->db->bind(':modified_date', time());

        // excute
        if ($this->db->excute()) {
            return true;
        } else {
            return false;
        } 
    }
}
