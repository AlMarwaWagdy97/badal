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

class Setting extends ModelAdmin
{

    public function __construct()
    {
        parent::__construct('settings');
    }

    /**
     * get all settings from datatbase
     *
     * @param  string $cond
     *
     * @return object settings data
     */
    public function getSettings($cond ="")
    {
        $query = 'SELECT * FROM settings ORDER BY settings.create_date DESC ';

        return $this->getAll($query);
    }

    public function updateSetting($data)
    {
        $query = 'UPDATE settings SET title = :title, value = :value, modified_date = :modified_date';
        $query .= ' WHERE setting_id = :setting_id';
        $this->db->query($query);
        // binding values
        $this->db->bind(':setting_id', $data['setting_id']);
        $this->db->bind(':title', $data['title']);
        $this->db->bind(':value', $data['value']);
        $this->db->bind(':modified_date', time());
        // excute
        if ($this->db->excute()) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * get setting by id
     * @param integer $id
     * @return object setting data
     */
    public function getSettingById($id)
    {
        return $this->getById($id, 'setting_id');
    }

}
