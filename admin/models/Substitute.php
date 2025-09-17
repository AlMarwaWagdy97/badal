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

class Substitute extends ModelAdmin
{

    public function __construct()
    {
        parent::__construct('substitutes');
    }

    /**
     * get all Substitutes from datatbase
     *
     * @param  string $cond
     * @param  array $bind
     * @param  string $limit
     * @param  mixed $bindLimit
     *
     * @return object Substitutes data
     */
    public function getSubstitutes($cond = '', $bind = '', $limit = '', $bindLimit = 50)
    {
        
        // $query = 'SELECT *, 
        // (select  COUNT(*) 
        //     FROM `badal_offers` 
        //     WHERE `badal_offers`.substitute_id = `substitutes`.substitute_id ) AS offers ,
        //     (select  COUNT(*) 
        //     FROM `orders` , badal_orders
        //     WHERE `badal_orders`.substitute_id = `substitutes`.substitute_id
        //     AND  `badal_orders`.order_id = `orders`.order_id) AS orders ,
        // (SELECT  round(AVG(`badal_review`.rate) * 2 , 0) / 2
        //                 FROM `badal_review`, `badal_orders` 
        //                 WHERE `badal_orders`.`substitute_id` = `substitutes`.`substitute_id`
        //                 AND `badal_review`.`badal_id` = `badal_orders`.`badal_id`
        //             ) AS rate 
        // FROM substitutes ' . $cond . ' ORDER BY substitutes.create_date DESC ';

        $query = 'SELECT
            s.*,
            COUNT(DISTINCT ba.offer_id) AS offers, 
            COUNT(DISTINCT bo.order_id) AS orders,
            ROUND(AVG(br.rate) * 2, 0) / 2 AS rate
        FROM substitutes s
        LEFT JOIN badal_offers ba ON s.substitute_id = ba.substitute_id
        LEFT JOIN  badal_orders bo ON s.substitute_id = bo.substitute_id AND bo.status = 1
        LEFT JOIN orders o ON o.order_id = bo.order_id AND o.status = 1
        LEFT JOIN  badal_review br ON bo.badal_id = br.badal_id
        ' . $cond . ' 
        GROUP BY  s.substitute_id
        ORDER BY s.create_date DESC;';

        dd($query);

        return $this->getAll($query, $bind, $limit, $bindLimit);
    }


        

    /**
     * get count of all records
     * @param type $cond
     * @return type
     */
    public function allSubstitutesCount($cond = '', $bind = '')
    {
        return $this->countAll($cond, $bind);
    }

    /**
     * insert new Substitutes
     * @param array $data
     * @return boolean
     */
    public function addSubstitute($data)
    {
        $this->db->query('INSERT INTO substitutes( image, full_name, identity, phone, nationality, gender, email, languages, proportion, status, modified_date, create_date)'
            . ' VALUES ( :image, :full_name, :identity, :phone, :nationality, :gender, :email, :languages, :proportion, :status, :modified_date, :create_date)');
        // binding values
        $this->db->bind(':identity', $data['identity']);
        $this->db->bind(':image', $data['image']);
        $this->db->bind(':full_name', $data['full_name']);
        $this->db->bind(':phone', $data['phone']);
        $this->db->bind(':nationality', $data['nationality']);
        $this->db->bind(':gender', $data['gender']);
        $this->db->bind(':email', $data['email']);
        $this->db->bind(':proportion', $data['proportion']);
        $this->db->bind(':languages', implode(',', $data['languages']) );
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

    public function updateSubstitute($data)
    {
        $query = 'UPDATE substitutes SET full_name = :full_name, identity = :identity, languages = :languages, proportion = :proportion, status = :status, phone = :phone, nationality = :nationality';
        if (!empty($data['image'])) $query .= ', image = :image';
        $query .= ', gender = :gender, email = :email, modified_date = :modified_date WHERE substitute_id = :substitute_id';
        $this->db->query($query);
        // binding values
        $this->db->bind(':substitute_id', $data['substitute_id']);
        $this->db->bind(':identity', $data['identity']);
        if (!empty($data['image'])) $this->db->bind(':image', $data['image']);
        $this->db->bind(':full_name', $data['full_name']);
        $this->db->bind(':phone', $data['phone']);
        $this->db->bind(':nationality', $data['nationality']);
        $this->db->bind(':gender', $data['gender']);
        $this->db->bind(':email', $data['email']);
        $this->db->bind(':proportion', @$data['proportion']);
        $this->db->bind(':languages', implode(',', $data['languages']) );
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
     * get substitute by id
     * @param integer $id
     * @return object substitute data
     */
    public function getSubstituteById($id)
    {
        return $this->getById($id, 'substitute_id');
    }

   /**
     * get Offers By Subsitute Id
     * @return integr
     */
    public function getOffersBySubsitute($substitute_id)
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
}
