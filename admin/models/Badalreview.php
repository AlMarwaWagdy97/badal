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

class Badalreview extends ModelAdmin
{

    public function __construct()
    {
        parent::__construct('badal_review');
        error_reporting(E_ALL);
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
    public function getBadalReviews($cond = '', $bind = '', $limit = '', $bindLimit = 50)
    {
        $query = 'SELECT badal_review.* FROM `badal_review` ' . $cond . '  ORDER BY badal_review.create_date DESC ';
        // dd($query);
        return $this->getAll($query, $bind, $limit, $bindLimit);
    }

    /**
     * get count of all records
     * @param type $cond
     * @return type
     */
    public function allBadalReviewsCount($cond = '', $bind = '')
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
     * get Review By ID
     * @param integer $id
     * @return object review data
     */
    public function getReviewByID($id)
    {
        return $this->getById($id, 'review_id');

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
     * get Reviews
     */
    public function getReviews()
    {
        return [
            5 => "راضي تماما",
            4 => "راضي نوعا ما ",
            3 => "محايد",
            2 => "غير راضي نوعا ما",
            1 => "غير راضي",
        ];
    }


    
    /**
     * get reviews By Subsitute Id
     * @return integr
     */
    public function getReviewBySubstituteId($substitute_id)
    {
        $query = 'SELECT `badal_review`.* 
                    FROM `badal_review`, `badal_orders` 
                    WHERE `badal_orders`.substitute_id = :substitute_id
                    AND `badal_review`.badal_id = `badal_orders`.badal_id
                    AND `badal_review`.status <> 2 
                    ORDER BY `badal_review`.create_date DESC';
        $this->db->query($query);
        $this->db->bind(':substitute_id', $substitute_id);
        $results = $this->db->resultSet();
        return $results;
    }


    /**
     * get donor By Subsitute Id
     * @return data
     */
    public function getDonorByReview($data)
    {
        $query = 'SELECT `donors`.* 
                    FROM `badal_orders`, `orders`, `donors`
                    WHERE `badal_orders`.badal_id = :badal_id
                    AND `badal_orders`.order_id = `orders`.order_id 
                    AND `orders`.donor_id = `donors`.donor_id 
                    AND `donors`.status <> 2; ';
        $this->db->query($query);
        $this->db->bind(':badal_id', $data['badal_id']);
        $this->db->excute();
        return $this->db->single();
    }

    /**
     * update replay in subsitude
     * @return data
     */
    public function updateBadalReviewReplay($data)
    {
        $query = 'UPDATE `badal_review` SET email_reply = :email_reply, sms_reply = :sms_reply,  modified_date = :modified_date 
         WHERE review_id = :review_id';
        $this->db->query($query);
        $this->db->bind(':email_reply', @$data['email_msg']);
        $this->db->bind(':sms_reply', @$data['sms_msg']);
        $this->db->bind(':review_id', @$data['review_id']);
        $this->db->bind(':modified_date', time());
        // excute
        if ($this->db->excute()) {
            return true;
        } else {
            return false;
        }
    }

}
