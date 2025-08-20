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

class Player extends ModelAdmin
{

    public function __construct()
    {
        parent::__construct('players');
    }

    /**
     * get all players from datatbase
     *
     * @param  string $cond
     * @param  array $bind
     * @param  string $limit
     * @param  mixed $bindLimit
     *
     * @return object players data
     */
    public function getPlayers($cond = '', $bind = '', $limit = '', $bindLimit = 50)
    {
        $query = 'SELECT players.*, puzzels.name as puzzel FROM players, puzzels ' . $cond . ' ORDER BY players.create_date DESC ';

        return $this->getAll($query, $bind, $limit, $bindLimit);
    }

    /**
     * get count of all records
     * @param type $cond
     * @return type
     */
    public function allPlayersCount($cond = '', $bind = '')
    {
        return $this->countAll($cond, $bind);
    }

    /**
     * insert new players
     * @param array $data
     * @return boolean
     */
    public function addPlayer($data)
    {
        $this->db->query('INSERT INTO players( subject, message, full_name, city, email, phone, type, status, modified_date, create_date)'
            . ' VALUES (:subject, :message, :full_name, :city, :email, :phone, :type, :status, :modified_date, :create_date)');
        // binding values
        $this->db->bind(':subject', $data['subject']);
        $this->db->bind(':message', $data['message']);
        $this->db->bind(':full_name', $data['full_name']);
        $this->db->bind(':city', $data['city']);
        $this->db->bind(':email', $data['email']);
        $this->db->bind(':phone', $data['phone']);
        $this->db->bind(':type', $data['type']);
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

    public function updatePlayer($data)
    {
        $query = 'UPDATE players SET subject = :subject, message = :message, full_name = :full_name, city = :city, email = :email, status = :status, 
         phone = :phone, type = :type, modified_date = :modified_date WHERE player_id = :player_id';

        $this->db->query($query);
        // binding values
        $this->db->bind(':player_id', $data['player_id']);
        $this->db->bind(':subject', $data['subject']);
        $this->db->bind(':message', $data['message']);
        $this->db->bind(':city', $data['city']);
        $this->db->bind(':full_name', $data['full_name']);
        $this->db->bind(':email', $data['email']);
        $this->db->bind(':phone', $data['phone']);
        $this->db->bind(':type', $data['type']);
        $this->db->bind(':status', $data['status']);
        $this->db->bind(':modified_date', time());
        // excute
        if ($this->db->excute()) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * get player by id
     * @param integer $id
     * @return object player data
     */
    public function getPlayerById($puzzel_id)
    {
        $this->db->query('SELECT players.*,puzzels.name as puzzel FROM players, puzzels WHERE players.puzzel_id = puzzels.puzzel_id AND players.puzzel_id = :puzzel_id');
        $this->db->bind(':puzzel_id' , $puzzel_id);
        $row = $this->db->single();
        return $row;
    }

    /**
     * handling Search Condition, creating bind array and handling search session
     *
     * @param  array $searches
     * @return array of condation and bind array
     */
    public function handlingSearchCondition($searches)
    {
        //reset search session
        unset($_SESSION['search']);
        $cond = '';
        $bind = [];
        if (!empty($searches)) {
            foreach ($searches as $keyword) {
                if ($keyword == 'puzzel') {
                    $cond .= ' AND puzzels.name LIKE :' . $keyword . ' ';
                } else {
                    $cond .= ' AND ' . $this->table . '.' . $keyword . ' LIKE :' . $keyword . ' ';
                }
                $bind[':' . $keyword] = $_POST['search'][$keyword];
                $_SESSION['search'][$keyword] = $_POST['search'][$keyword];
            }
        }
        return $data = ['cond' => $cond, 'bind' => $bind];
    }
    

    /**
     * export selected orders 
     *
     * @param array $records
     * @return export
     */
    public function exportAll($cond, $bind)
    {
        $total =  $this->allPlayersCount(",puzzels " . $cond, $bind);
        if ($total->count > 20000) {
            return false;
        }
        $results = $this->getPlayers($cond, $bind, '', '');
        $data[] = [
            'player_id' =>  'player_id',
            'puzzel_id' =>  'puzzel_id',
            'full_name' =>  'الاسم بالكامل',
            'email' => 'الايميل',
            'phone' =>  'الهاتف',
            'share' =>  'حالة المشاركة',
            'status' =>  '  ',
            'create_date' =>  'تاريخ الاضافة',
            'modified_date' =>  'اخر تعديل',
            'puzzel' =>  'اللغز',
        ];
        $results = array_merge($data, $results);
        $this->exportToExcel($results);
    }
}
