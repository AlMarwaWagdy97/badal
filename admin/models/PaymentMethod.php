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

class PaymentMethod extends ModelAdmin
{

    public function __construct()
    {
        parent::__construct('payment_methods');
    }

    /**
     * get all payment_methods from datatbase
     *
     * @param  string $cond
     * @param  array $bind
     * @param  string $limit
     * @param  mixed $bindLimit
     *
     * @return object payment_methods data
     */
    public function getPaymentMethods($cond = '', $bind = '', $limit = '', $bindLimit = 50)
    {
        $query = 'SELECT * FROM payment_methods ' . $cond . ' ORDER BY payment_methods.create_date DESC ';

        return $this->getAll($query, $bind, $limit, $bindLimit);
    }

    /**
     * get count of all records
     * @param type $cond
     * @return type
     */
    public function allPaymentMethodsCount($cond = '', $bind = '')
    {
        return $this->countAll( $cond, $bind);        
    }

    /**
     * insert new payment_methods
     * @param array $data
     * @return boolean
     */
    public function addPaymentMethod($data)
    {
        $this->db->query('INSERT INTO payment_methods( title, content, payment_key, image, cart_show, status, modified_date, create_date)'
            . ' VALUES (:title, :content, :payment_key, :image, :cart_show, :status, :modified_date, :create_date)');
        // binding values
        $this->db->bind(':title', $data['title']);
        $this->db->bind(':content', $data['content']);
        $this->db->bind(':payment_key', $data['payment_key']);
        $this->db->bind(':image', $data['image']);
        $this->db->bind(':cart_show', $data['cart_show']);
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

    public function updatePaymentMethod($data)
    {
        $query = 'UPDATE payment_methods SET title = :title, content = :content, payment_key = :payment_key, meta = :meta, cart_show = :cart_show, status = :status, modified_date = :modified_date';
        (empty($data['image'])) ? null : $query .= ', image = :image';
        $query .= ' WHERE payment_id = :payment_id';
        $this->db->query($query);
        // binding values
        $this->db->bind(':payment_id', $data['payment_id']);
        $this->db->bind(':title', $data['title']);
        $this->db->bind(':meta', $data['meta']);
        $this->db->bind(':content', $data['content']);
        $this->db->bind(':payment_key', $data['payment_key']);
        $this->db->bind(':cart_show', $data['cart_show']);
        $this->db->bind(':status', $data['status']);
        $this->db->bind(':modified_date', time());
        empty($data['image']) ? null : $this->db->bind(':image', $data['image']);
        // excute
        if ($this->db->excute()) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * get payment_methods by id
     * @param integer $id
     * @return object payment_methods data
     */
    public function getPaymentMethodById($id)
    {
        return $this->getById($id, 'payment_id');
    }


}
