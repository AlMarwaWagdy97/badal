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

class AppArticle extends Model
{
    public function __construct()
    {
        parent::__construct('app_articles');
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
    public function getArticles($section, $start, $perpage)
    {
        return $this->get('*', ['status' => 1, 'section_id' => $section], $start, $perpage);
    }

    /**
     * get all article from datatbase
     * @return object page data
     */

    public function getArticleById($id)
    {
        return $this->getBy(['article_id' => $id, 'status' => 1]);
    }
}
