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

class Badalritual extends ModelAdmin
{

    public function __construct()
    {
        parent::__construct('requests');
    }

    /**
     * get all rituals from datatbase by order_id
     *
     * @param  string $order_id
     *
     * @return object badal rituals data
     */
    public function getBadalRituals($order_id)
    {
        $query = 'SELECT `ritual_id`, `title`, `proof`, `start`, `complete` FROM `rituals`  WHERE `status` <> 2 AND `order_id` =  ' . $order_id . '  ORDER BY create_date';
        $this->db->query($query);
        return $this->db->resultSet();
    }

}
