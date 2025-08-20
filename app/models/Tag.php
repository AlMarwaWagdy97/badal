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

class Tag extends Model
{
    public function __construct()
    {
        parent::__construct('project_tags');
    }

    /**
     * get all pages from datatbase
     * @return object page data
     */
    public function getPagesTitle()
    {
        $results = $this->getFromTable('pages', 'page_id, title, alias', ['status' => 1]);
        return $results;
    }

    /**
     * getTagById
     *
     * @param  mixed $id
     *
     * @return object tag
     */
    public function getTagById($id)
    {
        return $this->getBy(['tag_id' => $id, 'status' => 1]);
    }

    /**
     * get Products By Tag
     *
     * @param  int  $id
     *
     * @return object
     */
    public function getProductsByTag($id, $start, $perpage)
    {
        $query = 'SELECT pj.*, project_tags.tag_id, project_tags.name as tag,
        (SELECT SUM(total) FROM donations WHERE pj.project_id =donations.project_id AND status = 1 LIMIT 1 ) as total 
         FROM `projects` pj ,tags_projects,project_tags 
        WHERE tags_projects.tag_id = :tag_id AND pj.start_date <= ' . time() . ' AND pj.end_date >= ' . time() . ' AND pj.project_id = tags_projects.project_id 
        AND pj.status = 1 AND project_tags.tag_id = tags_projects.tag_id AND pj.hidden = 0  LIMIT ' . $start . ' ,' . $perpage;
        $this->db->query($query);
        $this->db->bind(':tag_id', $id);
        return $this->db->resultSet();
    }

    /**
     * projects Count
     *
     * @param  mixed $id
     * @return void
     */
    public function projectsCount($id)
    {
        return $this->countAll(['status' => 1, 'hidden' => 0], 'projects');
    }

    /**
     * categoriesCount
     *
     * @return void
     */
    public function tagsCount()
    {
        return $this->countAll(['status' => 1]);
    }

    /**
     * get all getTags
     *
     * @param  mixed $cond
     * @param  mixed $start
     * @param  mixed $perpage
     * @return object
     */
    public function getTags($start, $perpage)
    {
        return $this->get('*', ['status' => 1], $start, $perpage);
    }
}
