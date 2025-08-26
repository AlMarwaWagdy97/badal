<?php

namespace Helpers;

class Log
{

    protected $actions = ['publish', 'unpublish', 'featured', 'unfeatured', 'delete', 'add'];
    public $url = [];
    public $model;
    public $records;
    public $user;
    public $action;

    public function __construct()
    {
        $this->setUrl();
        $this->setUser();
        $this->setModel();
        $this->setAction();
        $this->setRecords();
    }

    public function setUrl()
    {
        if (isset($_GET['url'])) {
            $this->url = explode('/', $_GET['url']);
        }
    }

    public function setUser()
    {
        if (@$_SESSION['admin']) {
            $this->user = $_SESSION['admin'];
        }
    }
    public function setModel()
    {
        if (@$this->url[0]) {
            $this->model = $this->url[0];
        }
    }
    public function setAction()
    {
        if (count($this->url) > 1) {
            if (in_array($this->url[1], $this->actions)) {
                $action = $this->url[1];
            }
        }
        if (!empty($_POST)) {
            if (@$this->url[1] == 'edit' || @$this->url[1] == 'add' || @$this->url[1] == 'send') {
                $action = $this->url[1];
            } else {
                $action = $_POST;
                unset($action['search'], $action['perpage'], $action['record']);
                if (is_array($action)) {
                    $action = implode(',', $action);
                }
            }
        }
        if (!isset($action)) {
            $this->action = null;
        } else {
            $this->action = $action;
        }
    }

    public function setRecords()
    {
        if (isset($_POST['record'])) {
            $records =  $_POST['record'];
            $records = implode(', ', $records);
        } elseif (count($this->url) > 2) {
            $records = end($this->url);
        } else {
            $records = null;
        }
        return $this->records = $records;
    }
}
