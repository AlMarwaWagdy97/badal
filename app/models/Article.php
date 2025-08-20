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

class Article extends Model
{
    public function __construct()
    {
        parent::__construct('articles');
    }
    /**
     * categoriesCount
     *
     * @return void
     */
    public function articlesCount()
    {
        return $this->countAll(['status' => 1]);
    }
    /**
     * get all articles from datatbase
     * @return object page data
     */
    public function getArticles($start, $perpage )
    {
        return $this->get('*', ['status' => 1], $start, $perpage);
    }

    /**
     * get all slides from datatbase
     * @return object slides data
     */
    public function getSlides($cols = '*', $bind = ['status' => 1])
    {
        $results = $this->getFromTable('slides', $cols, $bind, '', '', 'arrangement', 'ASC');
        return $results;
    }

    /**
     * get all article from datatbase
     * @return object page data
     */

    public function getArticleById($id)
    {
        return $this->getBy(['article_id' => $id, 'status' => 1]);
    }


    public function getNewsTicker()
    {
        $results = $this->getFromTable('articles', 'article_id, description', ['news_ticker' => 1], '', '', 'arrangement', 'ASC');
        return $results;
    }
}
