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

class Test extends Model
{
    public function __construct()
    {
        parent::__construct('tests');
    }

    public function save($data)
    {
        $query = 'INSERT INTO tests (data)'
            . ' VALUES (:data)';
        $this->db->query($query);
        // binding values
        $this->db->bind(':data', $data);
        // excute
        if ($this->db->excute()) {
            return true;
        } else {
            return false;
        }
    }


     
}
