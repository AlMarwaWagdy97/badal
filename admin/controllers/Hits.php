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

class Hits extends ControllerAdmin
{

    private $projectModel;

    public function __construct()
    {
        $this->projectModel = $this->model('Project');
    }

    /**
     * @return [type]
     */
    public function index(){
        $projects = $this->projectModel->getProjectsHits();
        $data = [
            'page_title' => 'عدد الزوار',
            'title' => 'عدد الزوار',
            'projects' => $projects,
        ];

        $this->view('projects/hits', $data);

    }
}
