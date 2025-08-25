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

/**
 * create URL & Loads Core controller
 * @example URL format -/controller/method/params
 */

class Core
{
    protected $currentController = 'Pages';
    protected $currentMethod = 'index';
    protected $apiController = 'error404';
    protected $apiMethod = 'notFound';
    protected $parms = [];
    
    public function __construct()
    {
     
        $url = $this->getUrl();
        // if ($url[0] != 'admin'  ) {
        //     $this->apiRoute($url);
        // }
     
        //look in controller for the controller existing and instantiate it
        if (file_exists('../app/controllers/' . ucfirst($url[0]) . '.php')) {
            $this->currentController = ucwords($url[0]);
            //unset 0 index
            unset($url[0]);
        }
        //require the controller
        require_once '../app/controllers/' . $this->currentController . '.php';
        //init controller
        $this->currentController = new $this->currentController;
        //looking for the method exist in the current controller and loading it as a page
        //checking second part of the url
        if (isset($url[1])) {
            // check if method exist
            if (method_exists($this->currentController, $url[1])) {
                $this->currentMethod = $url[1];
            }
            unset($url[1]);
        }
        //get params
        $this->parms = $url ? array_values($url) : [];
        //call a callback with array of params
        call_user_func_array([$this->currentController, $this->currentMethod], $this->parms);
    }


    public function apiRoute($url)
    {
        isset($url[1]) ?: $url[1] = 'error404';
        //look in controller for the controller existing 
        if (file_exists('../api/' . ucfirst($url[1]) . '.php')) {
            $this->apiController = ucwords($url[1]);
            //unset 0 index
            unset($url[0], $url[1]);
            //require the controller
        }
        require_once '../api/' . $this->apiController . '.php';
        //init controller
        $controller = new $this->apiController;


        //looking for the method exist in the current controller and loading it as a page
        //checking second part of the url
        if (isset($url[2])) {
            // check if method exist
            if (method_exists($this->apiController, $url[2])) {
                $this->apiMethod = $url[2];
            }
            unset($url[2]);
        } else {
            $this->apiController = 'error404';
        }
        //get params
        $this->parms = $url ? array_values($url) : [];
        //call a callback with array of params
        call_user_func_array([$controller, $this->apiMethod], $this->parms);
    }
    /**
     * @param string $_get URL
     * @return array url
     * 
     */
    public function getUrl()
    {
        $url = [''];
        if (isset($_GET['url'])) {
            $url = rtrim($_GET['url'], '/');
            $url = filter_var($url, FILTER_SANITIZE_URL);
            $url = explode('/', $url);
        }
        return $url;
    }
}
