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

class Logs extends ControllerAdmin
{

    private $logModel;

    public function __construct()
    {
        $this->logModel = $this->model('Log');
    }

    /**
     * loading index view with latest logs
     */
    public function index($current = '', $perpage = 50)
    {
        // get logs
        $cond = '';
        $bind = [];

        //check user action if the form has submitted
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // sanitize POST array
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        //handling search
        $searches = $this->logModel->searchHandling(['user_name', 'action', 'records', 'model'], $current);
        $cond .= 'WHERE ' . substr($searches['cond'], 4);
        $bind = $searches['bind'];
        }


        // get all records count after search and filtration
        $recordsCount = $this->logModel->allLogsCount($cond, $bind);
        // make sure its integer value and its usable
        $current = (int) $current;
        $perpage = (int) $perpage;

        ($perpage == 0) ? $perpage = 20 : null;
        if ($current <= 0 || $current > ceil($recordsCount->count / $perpage)) {
            $current = 1;
            $limit = 'LIMIT 0 , :perpage ';
            $bindLimit[':perpage'] = $perpage;
        } else {
            $limit = 'LIMIT  ' . (($current - 1) * $perpage) . ', :perpage';
            $bindLimit[':perpage'] = $perpage;
        }
        //get all records for current log

        $logs = $this->logModel->getLogs($cond, $bind, $limit, $bindLimit);

        $data = [
            'current' => $current,
            'perpage' => $perpage,
            'header' => '',
            'title' => ' سجل عمليات الادارة',
            'logs' => $logs,
            'recordsCount' => $recordsCount->count,
            'footer' => '',
        ];
        $this->view('logs/index', $data);
    }
}
