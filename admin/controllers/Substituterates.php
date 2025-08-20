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

class SubstituteRates extends ControllerAdmin
{
    private $model;

    public function __construct()
    {
        $this->model = $this->model('Badalreview');
    }



    /**
     * showing substitute details
     * @param integer $id
     */
    public function show($id)
    {

        if (!$substituterates = $this->model->getReviewBySubstituteId($id)) {
            flash('substitute_msg', 'هناك خطأ ما هذه الصفحة غير موجوده او ربما اتبعت رابط خاطيء ', 'alert alert-danger');
            redirect('substitutes');
        }
        $data = [
            'title' => 'تقيممات المتطوع',
            'badalreviews' => $substituterates,
        ];
        $this->view('substitutes/review', $data);
    }

        /**
     * delete record by id
     * @param integer $id
     */
    public function delete($id)
    {
        if ($row_num = $this->model->deleteById([$id], 'review_id')) {
            flash('badalreview_msg', 'تم حذف ' . $row_num . ' بنجاح');
        } else {
            flash('badalreview_msg', 'لم يتم الحذف', 'alert alert-danger');
        }
        redirect('SubstituteRates/show/'. array_slice (explode ('/', $_SERVER['HTTP_REFERER']), -1)[0]);
    }


}
