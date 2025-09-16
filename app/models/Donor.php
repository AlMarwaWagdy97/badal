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

class Donor extends Model
{

    /**
     * setting table name
     */
    public function __construct()
    {
        parent::__construct('donors');
    }

    /**
     * get count of all records
     * @param type $cond
     * @return type
     */
    public function allDonorsCount($cond = '', $bind = '')
    {
        return $this->countAll(' INNER JOIN groups  ON donors.group_id = groups.group_id  ' . $cond, $bind);
    }

    /**
     * insert new donor
     * @param array $data
     * @return boolean
     */
    public function addDonor($data)
    {
        $this->db->query('INSERT INTO donors( full_name, mobile, `identity`,  mobile_confirmed, store_id, email, status, create_date, modified_date)'
            . ' VALUES (:full_name, :mobile, :identity, :mobile_confirmed,:store_id, :email, :status, :create_date, :modified_date)');

        $store_id = isset($_SESSION['store']->store_id) ? $_SESSION['store']->store_id : null;
        // binding values
        $this->db->bind(':full_name', $data['full_name']);
        $this->db->bind(':email', $data['email']);
        $this->db->bind(':store_id', $store_id);
        $this->db->bind(':mobile', $data['mobile']);
        $this->db->bind(':identity', @$data['identity']);
        $this->db->bind(':mobile_confirmed', $data['mobile_confirmed']);
        $this->db->bind(':status', $data['status']);
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
     * update Donor data
     *
     * @param  mixed $data
     *
     * @return void
     */
    public function updateDonor($data)
    {
        $query = 'UPDATE donors SET full_name = :full_name, email = :email, `identity` = :identity ';
        $query .= ', modified_date = :modified_date  WHERE donor_id = :donor_id';

        $this->db->query($query);
        // binding values
        $this->db->bind(':donor_id', $data['donor_id']);
        $this->db->bind(':full_name', $data['full_name']);
        $this->db->bind(':email', $data['email']);
        $this->db->bind(':identity', $data['identity']);
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
        $query = 'UPDATE donors SET mobile_confirmed = :mobile_confirmed WHERE donor_id = :donor_id';
        $this->db->query($query);
        $this->db->bind(':donor_id', $data['donor_id']);
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
        $query = 'UPDATE donors SET email = :email, deleted = 0  WHERE donor_id = :donor_id';
        $this->db->query($query);
        $this->db->bind(':donor_id', $data['donor_id']);
        $this->db->bind(':email', $data['email']);
        // excute
        if ($this->db->excute()) {
            return true;
        } else {
            return false;
        }
    }
    /**
     * Find donor by email
     * @param string $email
     * @return boolean
     */
    public function getdonorByMobile($mobile)
    {
        return $this->getSingle('*', ['mobile' => $mobile]);
    }

    /**
     * Find donor by email
     * @param string $email
     * @return boolean
     */
    public function getdonorByMobileCustom($mobile)
    {
        $query = 'SELECT * FROM `donors` WHERE mobile = :mobile AND `status` != 2 ';
        $this->db->query($query);
        $this->db->bind(':mobile', $mobile);
        return$this->db->getSingle();
    }


    /**
     * get Donations By Mobail
     *
     * @param [string] $mobile
     * @return object
     */
    public function getDonationsByMobail($mobile)
    {
        $query = 'SELECT orders.*, payment_methods.title as payment_method FROM  orders, donors, payment_methods 
                  WHERE orders.donor_id = donors.donor_id 
                  AND payment_methods.payment_id = orders.payment_method_id 
                  AND donors.mobile = :mobile 
                  AND orders.status <> 2 ORDER BY orders.create_date DESC';
        $this->db->query($query);
        // bind values
        $this->db->bind(':mobile', $mobile);
        return $this->db->resultSet();
    }


    /**
     * update otp code
     *
     * @param array $data[otp,donor_id,expiration]
     * @return boolean
     */
    public function updateOTP($data)
    {
        $query = 'UPDATE donors SET otp = :otp, token = :token, expiration = :expiration WHERE donor_id = :donor_id';
        $this->db->query($query);
        $this->db->bind(':donor_id', $data['donor_id']);
        $this->db->bind(':token', $data['token']);
        $this->db->bind(':otp', $data['otp']);
        $this->db->bind(':expiration', $data['expiration']);
        $this->db->bind(':identity', $data['identity']);
        // excute
        if ($this->db->excute()) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * get donor by id and token
     *
     * @param integer $donor_id
     * @param integer $otp
     * @param string $token
     * @return object
     */
    public function getDonorByOTP($donor_id, $otp, $token)
    {
        $query = 'SELECT * FROM  donors WHERE donor_id = :donor_id 
        AND otp = :otp AND token = :token AND expiration > ' . time();
        $this->db->query($query);
        // bind values
        $this->db->bind(':donor_id', $donor_id);
        $this->db->bind(':otp', $otp);
        $this->db->bind(':token', $token);
        return $this->db->single();
    }

    /**
     * Find donor by email
     * @param string $email
     * @return boolean
     */
    public function getDonorId($donor_id)
    {
        return $this->getSingle('*', ['donor_id' => $donor_id]);
    }
    /**
     * get donor by id and token
     *
     * @param integer $donor_id
     * @param integer $otp
     * @param string $token
     * @return object
     */
    public function isValidToken($donor_id, $token)
    {
        $query = 'SELECT * FROM  donors WHERE donor_id = :donor_id AND token = :token ';
        $this->db->query($query);
        // bind values
        $this->db->bind(':donor_id', $donor_id);
        $this->db->bind(':token', $token);
        $results = $this->db->single();
        return $results;
    }

    /**
     * get donor donations by donor_id
     *
     * @param integer $id
     * @return object
     */
    public function getDonationsById($id)
    {
        $query = 'SELECT orders.* FROM  orders, donors WHERE orders.donor_id = donors.donor_id 
                  AND donors.donor_id = :id AND orders.status <> 2 ORDER BY orders.create_date DESC';
        $this->db->query($query);
        // bind values
        $this->db->bind(':id', $id);
        return $this->db->resultSet();
    }

    /**
     * get first donor donation store id
     *
     * @param integer $donor_id
     * @return void
     */
    public function getDonorStoreId($donor_id)
    {
        $firstDonation = $this->getFromTable('orders', '*', ['donor_id' => $donor_id], 1, '', 'order_id', 'ASC LIMIT 1');
        return $firstDonation[0]->store_id;
    }

    /**
     * Delete donor by given id
     *
     * @param int $id
     * @return boolean
     */
    public function DeleteDonor($id)
    {
        $query = 'UPDATE donors SET deleted = 1 WHERE donor_id = :donor_id';
        $this->db->query($query);
        $this->db->bind(':donor_id', $id);
        // excute
        if ($this->db->excute()) {
            return true;
        } else {
            return false;
        }
    }


    /**
     * check  donor is Substitute by mobile
     *
     * @param integer $mobile
     * @return object
     */
    public function checkSubstitute($mobile)
    {
        $query = 'SELECT `substitutes`.*
          ,(SELECT  round(AVG(`badal_review`.rate) * 2 , 0) / 2
                FROM `badal_review`, `badal_orders` 
                WHERE `badal_orders`.`substitute_id` = `substitutes`.`substitute_id`
                AND `badal_review`.`badal_id` = `badal_orders`.`badal_id`
            ) AS rate 
         FROM  `substitutes`  WHERE `substitutes`.status <> 2 AND `substitutes`.phone LIKE CONCAT( "%", :phone, "%" ); ';
        $this->db->query($query);
        // bind values
        $this->db->bind(':phone', substr($mobile, -9));
        $results = $this->db->single();
        return $results;
    }


    /**
     * update donor is_Substitut bu true
     *
     * @param integer $mobile
     * @return object
     */
    public function updateDonerSubstitut($id)
    {
        $query = 'UPDATE donors SET is_substitute = 1,  modified_date = :modified_date  WHERE donor_id = :donor_id';
        $this->db->query($query);
        // binding values
        $this->db->bind(':donor_id', $id);
        $this->db->bind(':modified_date', time());
        // excute
        if ($this->db->excute()) {
            return true;
        } else {
            return false;
        }
    }



    /**
     * check  donor is exist or not by mobile
     *
     * @param integer $mobile
     * @return object
     */
    public function checkDonorExist($mobile)
    {
        $query = 'SELECT * FROM  donors  WHERE  mobile LIKE CONCAT( "%", :mobile, "%" ) AND `status` <> 2 ';
        $this->db->query($query);
        // bind values
        $this->db->bind(':mobile', substr($mobile, -9));
        $results = $this->db->single();
        return $results;
    }

    /**
     * get Donations By Mobail
     *
     * @param [string] $mobile
     * @return object
     */
    public function getDonationsByRelations($mobile)
    {
        $query = 'SELECT `donors`.*, `donors`.donor_id AS id, `orders`.donor_id , 
                    SUM(CASE WHEN `donors`.donor_id = `orders`.donor_id AND `orders`.status IN (1, 0) THEN `orders`.total END) AS total,
                    COUNT(CASE WHEN `donors`.donor_id = `orders`.donor_id AND `orders`.status IN (0, 1) THEN `orders`.total END) AS count ,
                    SUM(CASE WHEN `donors`.donor_id = `orders`.donor_id AND `orders`.status = 1 THEN `orders`.total END) AS confirm_total,
                    COUNT(CASE WHEN `donors`.donor_id = `orders`.donor_id AND `orders`.status = 1 THEN `orders`.total END) AS confirm_count,
                    SUM(CASE WHEN `donors`.donor_id = `orders`.donor_id AND `orders`.status = 0 THEN `orders`.total END) AS pending_total,
                    COUNT(CASE WHEN `donors`.donor_id = `orders`.donor_id AND `orders`.status = 0 THEN `orders`.total END) AS pending_count
                    FROM `donors`
                    LEFT JOIN  `orders`  ON  `donors`.donor_id = `orders`.donor_id  AND `orders`.status <> 2
                    WHERE `donors`.mobile = :mobile 
                    AND `donors`.status <> 2
                    GROUP BY `donors`.donor_id;
        ';
        $this->db->query($query);
        // bind values
        $this->db->bind(':mobile', $mobile);
        return $this->db->single();
    }

    /**
     * check  same donor mobile
     *
     * @param integer $mobile
     * @return object
     */
    public function checksamemobile($mobile, $donor_id)
    {
        $query = 'SELECT * FROM  donors  WHERE  mobile LIKE CONCAT( "%", :mobile, "%" ) AND donor_id = :donor_id ;';
        $this->db->query($query);
        // bind values
        $this->db->bind(':mobile', substr($mobile, -9));
        $this->db->bind(':donor_id', $donor_id);
        $results = $this->db->single();
        return $results;
    }

    /**
     * update donor mobile by mobile 
     *
     * @param integer $mobile
     * @return object
     */
    public function editmobile($mobile, $donor_id)
    {
        $query = 'UPDATE donors SET mobile = :mobile,  modified_date = :modified_date  WHERE donor_id = :donor_id';
        $this->db->query($query);
        // binding values
        $this->db->bind(':donor_id', $donor_id);
        $this->db->bind(':mobile', $mobile);
        $this->db->bind(':modified_date', time());
        // excute
        if ($this->db->excute()) {
            return true;
        } else {
            return false;
        }
    }



    /**
     * add new card
     * @param array $data
     * @return boolean
     */
    public function savecard($data)
    {
        $this->db->query('INSERT INTO credit_cards ( `donor_id`, `number`, `expired_month`, `expired_year`, `name`, `merchant_reference`, `default`,  `status`, modified_date, create_date)
        VALUES (:donor_id, :number,  :expired_month, :expired_year, :name, :merchant_reference, :default, :status, :modified_date, :create_date )');
        // binding values
        $this->db->bind(':donor_id', $data['donor_id']);
        $this->db->bind(':number', $data['number']);
        $this->db->bind(':expired_month', $data['expired_month']);
        $this->db->bind(':expired_year', $data['expired_year']);
        $this->db->bind(':name', $data['name']);
        $this->db->bind(':default', $data['default']);
        $this->db->bind(':merchant_reference', @$data['merchant_reference']);
        $this->db->bind(':status', 2);
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
     * active card
     * @param array $data
     * @return boolean
     */
    public function activeCard($merchant_reference)
    {
        $query = 'UPDATE `credit_cards` SET `status` = :status ,`default` = :default ,  `modified_date` = :modified_date  WHERE `merchant_reference` = :merchant_reference ';
        $this->db->query($query);
        // binding values
        $this->db->bind(':merchant_reference', $merchant_reference);
        $this->db->bind(':status', 1);
        $this->db->bind(':default', 0);
        $this->db->bind(':modified_date', time());
        // excute
        if ($this->db->excute()) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * add new card
     * @param array $data
     * @return boolean
     */
    public function confirm_card($card_id, $token_name)
    {
        $query = 'UPDATE `credit_cards` SET `token_name` = :token_name, `status` = :status ,  `modified_date` = :modified_date  WHERE `card_id` = :card_id ';
        $this->db->query($query);
        // binding values
        $this->db->bind(':card_id', $card_id);
        $this->db->bind(':token_name', $token_name);
        $this->db->bind(':status', 1);
        $this->db->bind(':modified_date', time());
        // excute
        if ($this->db->excute()) {
            return true;
        } else {
            return false;
        }
    }
    /**
     * add new card
     * @param array $data
     * @return boolean
     */
    public function updateMerchant($card_id, $merchant_reference)
    {
        $query = 'UPDATE `credit_cards` SET `merchant_reference` = :merchant_reference, `status` = :status ,  `modified_date` = :modified_date  WHERE `card_id` = :card_id ';
        $this->db->query($query);
        // binding values
        $this->db->bind(':card_id', $card_id);
        $this->db->bind(':merchant_reference', $merchant_reference);
        $this->db->bind(':status', 1);
        $this->db->bind(':modified_date', time());
        // excute
        if ($this->db->excute()) {
            return true;
        } else {
            return false;
        }
    }


    /**
     * add new card
     * @param array $data
     * @return boolean
     */
    public function savecardd($data)
    {
        $this->db->query('INSERT INTO credit_cards ( `donor_id`, `key`, `iv_key`, `number`, `expired_month`,  `status`, `modified_date`, `create_date`)
        VALUES (:donor_id, :key, :iv_key, :number, :expired_month,  :status, :modified_date, :create_date )');

        // binding values
        $this->db->bind(':donor_id', $data['donor_id']);
        $this->db->bind(':key', $data['key']);
        $this->db->bind(':iv_key', $data['iv_key']);
        $this->db->bind(':number', $data['number']);
        $this->db->bind(':expired_month', $data['expired_month']);
        $this->db->bind(':status', 1);
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
     * get card by donor id
     *
     * @param integer $mobile
     * @return object
     */
    public function getDonationcards($donor_id)
    {
        $query = 'SELECT * FROM  `credit_cards`  WHERE `status` = 1 AND `donor_id` = :donor_id ORDER BY `default` DESC;';
        $this->db->query($query);
        // bind values
        $this->db->bind(':donor_id', $donor_id);
        return $this->db->resultSet();
    }


    /**
     * get card by id
     *
     * @param integer $mobile
     * @return object
     */
    public function getCardById($card_id)
    {
        return $this->getSingle('*', ['card_id' => $card_id], 'credit_cards');
    }


    /**
     * remove default except id
     *
     * @param integer $donor_id
     * @param integer $except_id
     * @return object
     */
    public function removedefault($donor_id, $except_id)
    {
        $query = 'UPDATE `credit_cards` SET `default` = 0 ,  `modified_date` = :modified_date  WHERE `donor_id` = :donor_id AND `card_id` <> :except_id ';
        $this->db->query($query);
        // binding values
        $this->db->bind(':donor_id', $donor_id);
        $this->db->bind(':except_id', $except_id);
        $this->db->bind(':modified_date', time());
        // excute
        if ($this->db->excute()) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * set Default Card
     *
     * @param integer $donor_id
     * @return object
     */
    public function setDefaultCard($card_id)
    {
        $query = 'UPDATE `credit_cards` SET `default` = 1 , `modified_date` = :modified_date  WHERE `card_id` = :card_id ';
        $this->db->query($query);
        // binding values
        $this->db->bind(':card_id', $card_id);
        $this->db->bind(':modified_date', time());
        // excute
        if ($this->db->excute()) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * delete Card by id
     *
     * @param integer $card_id
     * @return object
     */
    public function deleteCard($card_id)
    {
        $query = 'UPDATE `credit_cards` SET `status` = 2 , `modified_date` = :modified_date  WHERE `card_id` = :card_id ';
        $this->db->query($query);
        // binding values
        $this->db->bind(':card_id', $card_id);
        $this->db->bind(':modified_date', time());
        // excute
        if ($this->db->excute()) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * set First Card Default
     *
     * @param integer $donor_id
     * @return object
     */
    public function setFirstCardDefault($donor_id)
    {
        $query = 'UPDATE `credit_cards` SET `default` = 1 , `modified_date` = :modified_date  WHERE `donor_id` = :donor_id  LIMIT 1';
        $this->db->query($query);
        // binding values
        $this->db->bind(':donor_id', $donor_id);
        $this->db->bind(':modified_date', time());
        // excute
        if ($this->db->excute()) {
            return true;
        } else {
            return false;
        }
    }


    public function updateTokenName($token_name, $donor_id)
    {
        $query = 'UPDATE `donors` SET `token_name` = :token_name , `modified_date` = :modified_date  WHERE `donor_id` = :donor_id  LIMIT 1';
        $this->db->query($query);
        $this->db->bind(':donor_id', $donor_id);
        $this->db->bind(':token_name', $token_name);
        $this->db->bind(':modified_date', time());
        // excute
        if ($this->db->excute()) {
            return true;
        } else {
            return false;
        }
    }

    public function updateSameCard($newCard)
    {
        $query = 'UPDATE `credit_cards` 
                  SET `status` = 2 , `modified_date` = :modified_date  
                  WHERE `donor_id` = :donor_id
                  AND `number` = :card_number
                  AND  `card_id` != :card_id ';

        $this->db->query($query);
        $this->db->bind(':donor_id', $newCard->donor_id);
        $this->db->bind(':card_number', $newCard->number);
        $this->db->bind(':card_id', $newCard->card_id);
        $this->db->bind(':modified_date', time());
        if ($this->db->excute()) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * close the account
     * string mobile
     */
    public function closeAccount($mobile)
    {
        $query = 'UPDATE `donors` 
                  SET `status` = 2 , `modified_date` = :modified_date  
                  WHERE `mobile` LIKE :mobile';
        $this->db->query($query);
        $this->db->bind(':mobile', $mobile);
        $this->db->bind(':modified_date', time());
        if ($this->db->excute()) {
            return true;
        } else {
            return false;
        }
    }


    /**
     * get store by donor
     *
     * @param string $mobile
     * @return object
     */
    public function getStoreDonor($mobile)
    {
        $query = 'SELECT store_id FROM  donors WHERE mobile = :mobile';
        $this->db->query($query);
        $this->db->bind(':mobile', $mobile);
        return $this->db->single();
    }

    /**
     * Find donor by email
     * @param string $email
     * @return boolean
     */
    public function checkIdentify($data)
    {
      
        $query = 'SELECT * FROM `donors` WHERE `identity` = :identity AND `mobile` != :mobile AND `status` != 2 LIMIT 1 ';
        $this->db->query($query);
        $this->db->bind(':identity', $data['identity']);
        $this->db->bind(':mobile', $data['mobile']);
        return $this->db->single();
    }


    /**
     * update user identity
     *
     * @param [array] $data
     * @return void
     */
    public function updateIdentity($data)
    {
        $query = 'UPDATE donors SET `identity` = :identity, deleted = 0  WHERE donor_id = :donor_id';
        $this->db->query($query);
        $this->db->bind(':donor_id', $data['donor_id']);
        $this->db->bind(':identity', $data['identity']);
        // excute
        if ($this->db->excute()) {
            return true;
        } else {
            return false;
        }
    }


      /**
     * Find donor by email
     * @param string $email
     * @return boolean
     */
    public function getdonorByMobileActive($mobile)
    {
        $query = 'SELECT * FROM  donors WHERE mobile = :mobile AND `status` <> 2';
        $this->db->query($query);
        $this->db->bind(':mobile', $mobile);
        return $this->db->single();
    }
}
