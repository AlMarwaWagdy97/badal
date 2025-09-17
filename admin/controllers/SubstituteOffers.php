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

class SubstituteOffers extends ControllerAdmin
{
    private $model;

    public function __construct()
    {
        $this->model = $this->model('BadalOffer');
    }


    /**
     * showing substitute details
     * @param integer $id
     */
    public function show($id)
    {
        if (!$substituteOffer = $this->model->geOffersBySubsitute($id)) {
            flash('substitute_msg', 'هناك خطأ ما هذه الصفحة غير موجوده او ربما اتبعت رابط خاطيء ', 'alert alert-danger');
            redirect('substitutes');
        }
        $data = [
            'title' => 'عروض مقدمي الخدمة',
            'badaloffers' => $substituteOffer,
        ];
        $this->view('substitutes/offers', $data);
    }

    /**
     * delete record by id
     * @param integer $id
     */
    public function delete($id)
    {
        if ($row_num = $this->model->deleteById([$id], 'offer_id')) {
            flash('badaloffer_msg', 'تم حذف ' . $row_num . ' بنجاح');
        } else {
            flash('badaloffer_msg', 'لم يتم الحذف', 'alert alert-danger');
        }
        redirect('SubstituteOffers/show/'. array_slice (explode ('/', $_SERVER['HTTP_REFERER']), -1)[0]);
    }
    
    /**
     * publish record by id
     * @param integer $id
     */
    public function publish($id)
    {
        if ($row_num = $this->model->publishById([$id], 'offer_id')) {
            flash('badaloffer_msg', 'تم تعليم كا مقروءة ' . $row_num . ' بنجاح');
        } else {
            flash('badaloffer_msg', 'هناك خطأ ما يرجي المحاولة لاحقا', 'alert alert-danger');
        }
        
        redirect('SubstituteOffers/show/'. array_slice (explode ('/', $_SERVER['HTTP_REFERER']), -1)[0]);
    }

    /**
     * publish record by id
     * @param integer $id
     */
    public function unpublish($id)
    {
        if ($row_num = $this->model->unpublishById([$id], 'offer_id')) {
            flash('badaloffer_msg', 'تم تعليم كا غير مقروءة ' . $row_num . ' بنجاح');
        } else {
            flash('badaloffer_msg', 'هناك خطأ ما يرجي المحاولة لاحقا', 'alert alert-danger');
        }
        redirect('SubstituteOffers/show/'. array_slice (explode ('/', $_SERVER['HTTP_REFERER']), -1)[0]);
    }

}
