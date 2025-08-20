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

class Token extends Model
{

    /**
     * setting table name
     */
    public function __construct()
    {
        parent::__construct('fcm_tokens');
    }


    public function addToken($data)
    {
        $this->db->query('INSERT INTO fcm_tokens( donor_id, device_id, fcm_token, create_date, modified_date)'
            . ' VALUES (:donor_id, :device_id, :fcm_token, :create_date, :modified_date)');
        // binding values
        $this->db->bind(':device_id', $data['device_id']);
        $this->db->bind(':donor_id', $data['donor_id']);
        $this->db->bind(':fcm_token', $data['fcm_token']);
        $this->db->bind(':create_date', time());
        $this->db->bind(':modified_date', time());

        // excute
        if ($this->db->excute()) {
            return true;
        } else {
            return false;
        }
    }

    public function updateToken($data)
    {
        $query = 'UPDATE fcm_tokens SET fcm_token = :fcm_token, donor_id = :donor_id';
        $query .= ', modified_date = :modified_date  WHERE device_id = :device_id';

        $this->db->query($query);
        // binding values
        $this->db->bind(':device_id', $data['device_id']);
        $this->db->bind(':donor_id', $data['donor_id']);
        $this->db->bind(':fcm_token', $data['fcm_token']);
        $this->db->bind(':modified_date', time());
        // excute
        if ($this->db->excute()) {
            return true;
        } else {
            return false;
        }
    }

    public function updateDonorId($data)
    {
        $query = 'UPDATE fcm_tokens SET donor_id = :donor_id';
        $query .= ', modified_date = :modified_date  WHERE device_id = :device_id';

        $this->db->query($query);
        // binding values
        $this->db->bind(':device_id', $data['device_id']);
        $this->db->bind(':donor_id', $data['donor_id']);
        $this->db->bind(':modified_date', time());
        // excute
        if ($this->db->excute()) {
            return true;
        } else {
            return false;
        }
    }

    public function getToken($device_id)
    {
        return $this->getSingle('*', ['device_id' => $device_id]);
    }

    public function getDonorToken($donor_id)
    {
        return $this->get('*', ['donor_id' => $donor_id]);
    }

    public function getFcmTokens()
    {
        return $this->get('*');
    }
}
