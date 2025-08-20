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

class Puzzel extends ModelAdmin
{

    public function __construct()
    {
        parent::__construct('puzzels');
    }

    /**
     * get all Puzzels from datatbase
     *
     * @param  string $cond
     * @param  array $bind
     * @param  string $limit
     * @param  mixed $bindLimit
     *
     * @return object Puzzels data
     */
    public function getPuzzels($cond = '', $bind = '', $limit = '', $bindLimit = 50)
    {
        $query = 'SELECT * FROM puzzels ' . $cond . ' ORDER BY puzzels.create_date DESC ';

        return $this->getAll($query, $bind, $limit, $bindLimit);
    }

    /**
     * get count of all records
     * @param type $cond
     * @return type
     */
    public function allPuzzelsCount($cond = '', $bind = '')
    {
        return $this->countAll($cond, $bind);
    }

    /**
     * insert new Puzzels
     * @param array $data
     * @return boolean
     */
    public function addPuzzel($data)
    {
        $this->db->query('INSERT INTO puzzels( name, description, image, image2, width, height, piecesx, piecesy, timeout, rotate, status, modified_date, create_date)'
            . ' VALUES (:name, :description, :image, :image2, :width, :height, :piecesx, :piecesy, :timeout, :rotate, :status, :modified_date, :create_date)');
        // binding values
        $this->db->bind(':name', $data['name']);
        $this->db->bind(':image', $data['image']);
        $this->db->bind(':image2', $data['image2']);
        $this->db->bind(':width', $data['width']);
        $this->db->bind(':height', $data['height']);
        $this->db->bind(':piecesx', $data['piecesx']);
        $this->db->bind(':piecesy', $data['piecesy']);
        $this->db->bind(':timeout', $data['timeout']);
        $this->db->bind(':rotate', $data['rotate']);
        $this->db->bind(':description', $data['description']);
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

    public function updatePuzzel($data)
    {
        $query = 'UPDATE puzzels SET name = :name, description = :description, width = :width, height = :height, piecesx = :piecesx,
         piecesy = :piecesy, timeout = :timeout, rotate = :rotate, status = :status, modified_date = :modified_date';
        (empty($data['image'])) ? null : $query .= ', image = :image ';
        (empty($data['image2'])) ? null : $query .= ', image2 = :image2 ';
        $query .= ' WHERE puzzel_id = :puzzel_id';

        $this->db->query($query);
        // binding values
        $this->db->bind(':puzzel_id', $data['puzzel_id']);
        $this->db->bind(':name', $data['name']);
        $this->db->bind(':width', $data['width']);
        $this->db->bind(':height', $data['height']);
        $this->db->bind(':piecesx', $data['piecesx']);
        $this->db->bind(':piecesy', $data['piecesy']);
        $this->db->bind(':timeout', $data['timeout']);
        $this->db->bind(':rotate', $data['rotate']);
        $this->db->bind(':description', $data['description']);
        $this->db->bind(':status', $data['status']);
        $this->db->bind(':modified_date', time());
        empty($data['image2']) ? null : $this->db->bind(':image2', $data['image2']);
        empty($data['image']) ? null : $this->db->bind(':image', $data['image']);
        // excute
        if ($this->db->excute()) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * get puzzel by id
     * @param integer $id
     * @return object puzzel data
     */
    public function getPuzzelById($id)
    {
        return $this->getById($id, 'puzzel_id');
    }
    /**
     * export selected orders 
     *
     * @param array $records
     * @return export
     */
    public function exportAllPuzzels($cond, $bind)
    {
        $total =  $this->allPuzzelsCount($cond, $bind);
        if ($total->count > 20000) {
            return false;
        }
        $results = $this->getPuzzels($cond, $bind, '', '');
        $data[] = [
            'puzzel_id' =>  'puzzel_id',
            'identity' =>  'رقم الهوية',
            'image' =>  'صورة ',
            'full_name' =>  'الاسم بالكامل',
            'nationality' =>  'الجنسية',
            'gender' =>  'النوع',
            'email' => 'الايميل',
            'phone' =>  'الهاتف',
            'district' =>  'المنطقة',
            'city' =>  'المدينة',
            'family' =>  'عدد افراد الاسرة',
            'income' => 'الدخل',
            'description' =>  'نوع الاحتياج المطلوب',
            'status' =>  'حالة الرسالة',
            'create_date' =>  'تاريخ الاضافة',
            'modified_date' =>  'اخر تعديل',
        ];
        $results = array_merge($data, $results);
        $this->exportToExcel($results);
    }
}
