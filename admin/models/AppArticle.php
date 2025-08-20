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

class AppArticle extends ModelAdmin
{

    public function __construct()
    {
        parent::__construct('app_articles');
    }

    /**
     * get all app_articles from datatbase
     *
     * @param  string $cond
     * @param  array $bind
     * @param  string $limit
     * @param  mixed $bindLimit
     *
     * @return object app_articles data
     */
    public function getAppArticles($cond = '', $bind = '', $limit = '', $bindLimit = 50)
    {
        $query = 'SELECT app_articles.*, app_sections.name AS section FROM app_articles ' . $cond . ' ORDER BY app_articles.create_date DESC ';
        return $this->getAll($query, $bind, $limit, $bindLimit);
    }

    /**
     * get count of all records
     * @param type $cond
     * @return type
     */
    public function allAppArticlesCount($cond = '', $bind = '')
    {
        return $this->countAll($cond, $bind);
    }

    /**
     * insert new page
     * @param array $data
     * @return boolean
     */
    public function addAppArticle($data)
    {
        $this->db->query('INSERT INTO app_articles( title, alias, section_id, content, image,status, modified_date, create_date)'
            . ' VALUES (:title, :alias, :section_id, :content, :image, :status, :modified_date, :create_date)');
        // binding values
        $this->db->bind(':title', $data['title']);
        $this->db->bind(':section_id', $data['section_id']);
        $this->db->bind(':alias', $data['alias']);
        $this->db->bind(':content', $data['content']);
        $this->db->bind(':image', $data['image']);
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

    public function updateAppArticle($data)
    {
        $query = 'UPDATE app_articles SET title = :title, content = :content, section_id = :section_id, status = :status, modified_date = :modified_date';
        (empty($data['image'])) ? null : $query .= ', image = :image';
        $query .= ' WHERE article_id = :article_id';
        $this->db->query($query);
        // binding values
        $this->db->bind(':article_id', $data['article_id']);
        $this->db->bind(':section_id', $data['section_id']);
        $this->db->bind(':title', $data['title']);
        $this->db->bind(':content', $data['content']);
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
     * get page by id
     * @param integer $id
     * @return object page data
     */
    public function getAppArticleById($id)
    {
        return $this->getById($id, 'article_id');
    }
}
