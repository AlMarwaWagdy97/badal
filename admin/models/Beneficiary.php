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

class Beneficiary extends ModelAdmin
{

    public function __construct()
    {
        parent::__construct('beneficiaries');
    }

    /**
     * get all Beneficiaries from datatbase
     *
     * @param  string $cond
     * @param  array $bind
     * @param  string $limit
     * @param  mixed $bindLimit
     *
     * @return object Beneficiaries data
     */
    public function getBeneficiaries($cond = '', $bind = '', $limit = '', $bindLimit = 50)
    {
        $query = 'SELECT * FROM beneficiaries ' . $cond . ' ORDER BY beneficiaries.create_date DESC ';

        return $this->getAll($query, $bind, $limit, $bindLimit);
    }

    /**
     * get count of all records
     * @param type $cond
     * @return type
     */
    public function allBeneficiariesCount($cond = '', $bind = '')
    {
        return $this->countAll($cond, $bind);
    }

    /**
     * insert new Beneficiaries
     * @param array $data
     * @return boolean
     */
    public function addBeneficiary($data)
    {
        $this->db->query('INSERT INTO beneficiaries( district, message, image, full_name, identity, phone, nationality, gender, family, income, city, status, modified_date, create_date)'
            . ' VALUES (:district, :message, :image, :full_name, :identity, :phone, :nationality, :gender, :family, :income, :city, :status, :modified_date, :create_date)');
        // binding values
        $this->db->bind(':identity', $data['identity']);
        $this->db->bind(':image', $data['image']);
        $this->db->bind(':full_name', $data['full_name']);
        $this->db->bind(':phone', $data['phone']);
        $this->db->bind(':nationality', $data['nationality']);
        $this->db->bind(':gender', $data['gender']);
        $this->db->bind(':income', $data['income']);
        $this->db->bind(':family', $data['family']);
        $this->db->bind(':city', $data['city']);
        $this->db->bind(':district', $data['district']);
        $this->db->bind(':message', $data['message']);
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

    public function updateBeneficiary($data)
    {
        $query = 'UPDATE beneficiaries SET full_name = :full_name, identity = :identity, image = :image, district = :district, message = :message, status = :status,
         phone = :phone, city = :city, nationality = :nationality, gender = :gender, family = :family, income = :income, modified_date = :modified_date WHERE beneficiary_id = :beneficiary_id';

        $this->db->query($query);
        // binding values
        $this->db->bind(':beneficiary_id', $data['beneficiary_id']);
        $this->db->bind(':identity', $data['identity']);
        $this->db->bind(':image', $data['image']);
        $this->db->bind(':full_name', $data['full_name']);
        $this->db->bind(':phone', $data['phone']);
        $this->db->bind(':nationality', $data['nationality']);
        $this->db->bind(':gender', $data['gender']);
        $this->db->bind(':family', $data['family']);
        $this->db->bind(':income', $data['income']);
        $this->db->bind(':city', $data['city']);
        $this->db->bind(':district', $data['district']);
        $this->db->bind(':message', $data['message']);
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
     * get beneficiary by id
     * @param integer $id
     * @return object beneficiary data
     */
    public function getBeneficiaryById($id)
    {
        return $this->getById($id, 'beneficiary_id');
    }
    /**
     * export selected orders 
     *
     * @param array $records
     * @return export
     */
    public function exportAllBeneficiaries($cond, $bind)
    {
        $total =  $this->allBeneficiariesCount($cond, $bind);
        if ($total->count > 20000) {
            return false;
        }
        $results = $this->getBeneficiaries($cond, $bind, '', '');
        $data[] = [
            'beneficiary_id' =>  'beneficiary_id',
            'identity' =>  'رقم الهوية',
            'image' =>  'صورة الهوية',
            'full_name' =>  'الاسم بالكامل',
            'nationality' =>  'الجنسية',
            'gender' =>  'النوع',
            'email' => 'الايميل',
            'phone' =>  'الهاتف',
            'district' =>  'المنطقة',
            'city' =>  'المدينة',
            'family' =>  'عدد افراد الاسرة',
            'income' => 'الدخل',
            'message' =>  'نوع الاحتياج المطلوب',
            'status' =>  'حالة الرسالة',
            'create_date' =>  'تاريخ الاضافة',
            'modified_date' =>  'اخر تعديل',
        ];
        $results = array_merge($data, $results);
        $this->exportToExcel($results);
    }
}
