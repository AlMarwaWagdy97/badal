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

class Players extends ControllerAdmin
{

    private $playerModel;

    public function __construct()
    {
        $this->playerModel = $this->model('Player');
    }

    /**
     * loading index view with latest players
     */
    public function index($current = '', $perpage = 50)
    {
        // get players
        $cond = 'WHERE puzzels.puzzel_id = players.puzzel_id AND players.status <> 2 ';
        $bind = [];

        //check user action if the form has submitted
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // sanitize POST array
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

            //handling Delete
            if (isset($_POST['delete'])) {
                if (isset($_POST['record'])) {
                    if ($row_num = $this->playerModel->deleteById($_POST['record'], 'player_id')) {
                        flash('player_msg', 'تم حذف ' . $row_num . ' بنجاح');
                    } else {
                        flash('player_msg', 'لم يتم الحذف', 'alert alert-danger');
                    }
                }

                redirect('players');
            }

            //handling Publish
            if (isset($_POST['publish'])) {
                if (isset($_POST['record'])) {
                    if ($row_num = $this->playerModel->publishById($_POST['record'], 'player_id')) {
                        flash('player_msg', 'تم نشر ' . $row_num . ' بنجاح');
                    } else {
                        flash('player_msg', 'هناك خطأ ما يرجي المحاولة لاحقا', 'alert alert-danger');
                    }
                }
                redirect('players');
            }

            //handling Unpublish
            if (isset($_POST['unpublish'])) {

                if (isset($_POST['record'])) {
                    if ($row_num = $this->playerModel->unpublishById($_POST['record'], 'player_id')) {
                        flash('player_msg', 'تم ايقاف نشر ' . $row_num . ' بنجاح');
                    } else {
                        flash('player_msg', 'هناك خطأ ما يرجي المحاولة لاحقا', 'alert alert-danger');
                    }
                }
                redirect('players');
            }
        }

        //handling search
        $searches = $this->playerModel->searchHandling(['puzzel', 'full_name', 'email', 'phone',  'status'], $current);
        $cond .= $searches['cond'];
        $bind = $searches['bind'];
        // get all records count after search and filtration
        $recordsCount = $this->playerModel->allPlayersCount(",puzzels " . $cond, $bind);
        //handling export
        if (isset($_POST['exportAll'])) {
            if ($recordsCount->count > 20000) {
                flash('puzzel_msg', ' عدد النتائج اكثر من  20000 برجاء استخدام البحث لتقليل عدد النتائج', 'alert alert-danger');
                redirect('puzzels');
            }
            return $this->playerModel->exportAll($cond, $bind);
        }
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
        //get all records for current player
        $players = $this->playerModel->getPlayers($cond, $bind, $limit, $bindLimit);

        $data = [
            'current' => $current,
            'perpage' => $perpage,
            'header' => '',
            'title' => 'بيانات المشاركين',
            'players' => $players,
            'recordsCount' => $recordsCount->count,
            'footer' => '',
        ];
        $this->view('players/index', $data);
    }


    /**
     * showing player details
     * @param integer $id
     */
    public function show($id)
    {
        if (!$player = $this->playerModel->getPlayerById($id)) {
            flash('player_msg', 'هناك خطأ ما هذه الصفحة غير موجوده او ربما اتبعت رابط خاطيء ', 'alert alert-danger');
            redirect('players');
        }
        $this->playerModel->publishById([$id], 'player_id');
        $data = [
            'page_title' => 'بيانات المشاركين',
            'player' => $player,
        ];
        $this->view('players/show', $data);
    }

    /**
     * delete record by id
     * @param integer $id
     */
    public function delete($id)
    {
        if ($row_num = $this->playerModel->deleteById([$id], 'player_id')) {
            flash('player_msg', 'تم حذف ' . $row_num . ' بنجاح');
        } else {
            flash('player_msg', 'لم يتم الحذف', 'alert alert-danger');
        }
        redirect('players');
    }

    /**
     * publish record by id
     * @param integer $id
     */
    public function publish($id)
    {
        if ($row_num = $this->playerModel->publishById([$id], 'player_id')) {
            flash('player_msg', 'تم تعليم كا مقروءة ' . $row_num . ' بنجاح');
        } else {
            flash('player_msg', 'هناك خطأ ما يرجي المحاولة لاحقا', 'alert alert-danger');
        }
        redirect('players');
    }

    /**
     * publish record by id
     * @param integer $id
     */
    public function unpublish($id)
    {
        if ($row_num = $this->playerModel->unpublishById([$id], 'player_id')) {
            flash('player_msg', 'تم تعليم كا غير مقروءة ' . $row_num . ' بنجاح');
        } else {
            flash('player_msg', 'هناك خطأ ما يرجي المحاولة لاحقا', 'alert alert-danger');
        }
        redirect('players');
    }
}
