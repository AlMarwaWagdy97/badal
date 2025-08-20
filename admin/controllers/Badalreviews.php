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

class Badalreviews extends ControllerAdmin
{

    private $model;

    public function __construct()
    {
        $this->model = $this->model('Badalreview');
    }

    /**
     * loading index view with latest badalorders
     */
    public function index($current = '', $perpage = 50)
    {
        // get badalorders
        $cond = ' WHERE badal_review.status <> 2  ';
        $bind = [];
        //check user action if the form has submitted
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // sanitize POST array
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            // date search
            if (!empty($_POST['search']['date_from'])) {
                $cond .= ' AND badal_review.create_date >= ' . strtotime($_POST['search']['date_from']) . ' ';
            }
            if (!empty($_POST['search']['date_to'])) {
                $cond .= ' AND badal_review.create_date <= ' . strtotime($_POST['search']['date_to']) . ' ';
            }
            //handling Delete
            if (isset($_POST['delete'])) {
                if (isset($_POST['record'])) {
                    if ($row_num = $this->model->deleteById($_POST['record'], 'review_id')) {
                        flash('badalreview_msg', 'تم حذف ' . $row_num . ' بنجاح');
                    } else {
                        flash('badalreview_msg', 'لم يتم الحذف', 'alert alert-danger');
                    }
                }
                redirect('badalreviews');
            }
        }
        //handling search
        $searches = $this->model->searchHandling(['rate', 'type'], $current);
        $cond .= $searches['cond'];
        $bind = $searches['bind'];
        // get all records count after search and filtration
        $recordsCount = $this->model->allBadalReviewsCount(" " . $cond, $bind);
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
        //get all records for current badalorder
        $badalreviews = $this->model->getBadalReviews($cond, $bind, $limit, $bindLimit);
        $data = [
            'current' => $current,
            'perpage' => $perpage,
            'header' => '',
            'title' => 'تقيم',
            'reviews' => $this->model->getReviews(),
            'badalreviews' => $badalreviews,
            'recordsCount' => $recordsCount->count,
            'footer' => '',
        ];
        $this->view('badalreview/index', $data);
    }

    /**
     * show record by review_id
     * @param integer $review_id
     */
    public function show($review_id)
    {
        if (!$review = $this->model->getReviewByID($review_id)) {
            flash('badalreview_msg', ' لا يوجد تقيم لهذا الطلب', 'alert alert-danger');
            redirect('badalreview');
        }
        $data = [
            'title' => ' تقيم الطلب',
            'review' => $review,
            'review_id' => $review_id,
        ];
        $this->view('badalreview/show', $data);
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
        redirect('badalreviews');
    }


    /**
     * update badalorder
     * @param integer $id
     */
    public function edit($id)
    {
        $id = (int) $id;
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // sanitize POST array
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

            $data = [
                'review_id'             => $id,
                'title'                 => ' تقيم الطلب',
                'badal_id'              => $_POST['badal_id'],
                'email_subject'         => $_POST['email_subject'],
                'email_msg'             => $_POST['email_msg'],
                'sms_msg'               => $_POST['sms_msg'],
                'email_subject_error'   => '',
                'email_msg_error'       => '',
                'sms_msg_error'         => '',
            ];
            // validate 
            !(empty($data['email_subject'])) ?: $data['email_subject_error'] = 'هذا الحقل مطلوب';
            !(empty($data['email_msg'])) ?: $data['email_msg_error'] = 'هذا الحقل مطلوب';
            !(empty($data['sms_msg'])) ?: $data['sms_msg_error'] = 'هذا الحقل مطلوب';

            //make sure there is no errors
            if (empty($data['email_subject_error'])  &&  empty($data['email_msg_error']) && empty($data['sms_msg_error'])) {
                //validated
                if ($this->model->updateBadalReviewReplay($data)) {
                    $reviewubdate =  $this->model->getDonorByReview($data);
                    // send email ---------------------------------
                    $this->model->Email($reviewubdate->email, $data['email_subject'], nl2br($data['email_msg']));
                    // send sms ---------------------------------
                    $this->model->SMS($reviewubdate->mobile, $data['sms_msg']);
                    flash('badalreview_msg', 'تم التعديل بنجاح');
                    redirect('badalreviews/show/' . $id);
                } else {
                    flash('badalreview_msg', 'هناك خطأ مه حاول مرة اخري', 'alert alert-danger');
                }
            } else {
                //load the view with error
                flash('badalreview_msg', 'الرجاء ملئ البينات', 'alert alert-danger');

                if (!$review = $this->model->getReviewByID($id)) {
                    redirect('badalreviews/show/' . $id);
                }
                $data = [
                    'title' => ' تقيم الطلب',
                    'review' => $review,
                    'review_id' => $id,
                    'email_subject_error' => $data['email_subject_error'],
                    'email_msg_error' => $data['email_msg_error'],
                    'sms_msg_error' => $data['sms_msg_error'],
                ];
                $this->view('badalreview/show', $data);
            }
        } else {
            redirect('badalreviews/show/' . $id);
        }
    }
}
