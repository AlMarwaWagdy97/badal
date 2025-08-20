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

class AppSection extends Model
{
    public function __construct()
    {
        parent::__construct('app_sections');
    }
    /**
     * categoriesCount
     *
     * @return void
     */
    public function sectionsCount()
    {
        return $this->countAll(['status' => 1]);
    }
    /**
     * get all sections from datatbase
     * @return object page data
     */
    public function getSections($start, $perpage)
    {
        return $this->get('*', ['status' => 1], $start, $perpage, null, 'arrangement', 'ASC');
    }

    /**
     * get all section from datatbase
     * @return object page data
     */

    public function getSectionById($id)
    {
        return $this->getBy(['section_id' => $id, 'status' => 1]);
    }


    public function getNewsTicker()
    {
        $results = $this->getFromTable('app_sections', 'section_id, description', '', '', '', 'arrangement', 'ASC');
        return $results;
    }
}
