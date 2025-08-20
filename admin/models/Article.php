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

class Article extends ModelAdmin
{

    public function __construct()
    {
        parent::__construct('articles');
    }

    /**
     * get all articles from datatbase
     *
     * @param  string $cond
     * @param  array $bind
     * @param  string $limit
     * @param  mixed $bindLimit
     *
     * @return object articles data
     */
    public function getArticles($cond = '', $bind = '', $limit = '', $bindLimit = 50)
    {
        $query = 'SELECT * FROM articles ' . $cond . ' ORDER BY articles.create_date DESC ';

        return $this->getAll($query, $bind, $limit, $bindLimit);
    }

    /**
     * get count of all records
     * @param type $cond
     * @return type
     */
    public function allArticlesCount($cond = '', $bind = '')
    {
        return $this->countAll($cond, $bind);
    }

    /**
     * insert new articles
     * @param array $data
     * @return boolean
     */
    public function addArticle($data)
    {
        $this->db->query('INSERT INTO articles( name, alias, description, image, arrangement, content, featured, news_ticker, meta_keywords, meta_description, status, modified_date, create_date)'
            . ' VALUES (:name, :alias, :description, :image, :arrangement, :content, :featured, :news_ticker, :meta_keywords, :meta_description, :status, :modified_date, :create_date)');
        // binding values
        $this->db->bind(':name', $data['name']);
        $this->db->bind(':alias', $data['alias']);
        $this->db->bind(':description', $data['description']);
        $this->db->bind(':image', $data['image']);
        $this->db->bind(':arrangement', $data['arrangement']);
        $this->db->bind(':content', $data['content']);
        $this->db->bind(':featured', $data['featured']);
        $this->db->bind(':news_ticker', $data['news_ticker']);
        $this->db->bind(':meta_keywords', $data['meta_keywords']);
        $this->db->bind(':meta_description', $data['meta_description']);
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

    public function updateArticle($data)
    {
        $query = 'UPDATE articles SET name = :name, description = :description, arrangement = :arrangement, news_ticker = :news_ticker, meta_keywords = :meta_keywords,'
            . ' content =:content, featured=:featured, meta_description = :meta_description, status = :status, modified_date = :modified_date';

        (empty($data['image'])) ? null : $query .= ', image = :image';

        $query .= ' WHERE article_id = :article_id';
        $this->db->query($query);
        // binding values
        $this->db->bind(':article_id', $data['article_id']);
        $this->db->bind(':name', $data['name']);
        $this->db->bind(':description', $data['description']);
        $this->db->bind(':arrangement', $data['arrangement']);
        $this->db->bind(':news_ticker', $data['news_ticker']);
        $this->db->bind(':content', $data['content']);
        $this->db->bind(':featured', $data['featured']);
        $this->db->bind(':meta_keywords', $data['meta_keywords']);
        $this->db->bind(':meta_description', $data['meta_description']);
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
     * get articles by id
     * @param integer $id
     * @return object articles data
     */
    public function getArticleById($id)
    {
        return $this->getById($id, 'article_id');
    }

}
