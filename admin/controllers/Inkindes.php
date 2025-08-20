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

class Inkindes extends ControllerAdmin
{

    private $inkindModel;

    public function __construct()
    {
        $this->inkindModel = $this->model('Inkind');
    }

    /**
     * loading index view with latest inkindes
     */
    public function index($current = '', $perpage = 50)
    {
        // get inkindes
        $cond = 'WHERE status <> 2 ';
        $bind = [];

        //check user action if the form has submitted
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // sanitize POST array
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

            //handling Delete
            if (isset($_POST['delete'])) {
                if (isset($_POST['record'])) {
                    if ($row_num = $this->inkindModel->deleteById($_POST['record'], 'inkind_id')) {
                        flash('inkind_msg', 'تم حذف ' . $row_num . ' بنجاح');
                    } else {
                        flash('inkind_msg', 'لم يتم الحذف', 'alert alert-danger');
                    }
                }

                redirect('inkindes');
            }

            //handling Publish
            if (isset($_POST['publish'])) {
                if (isset($_POST['record'])) {
                    if ($row_num = $this->inkindModel->publishById($_POST['record'], 'inkind_id')) {
                        flash('inkind_msg', 'تم نشر ' . $row_num . ' بنجاح');
                    } else {
                        flash('inkind_msg', 'هناك خطأ ما يرجي المحاولة لاحقا', 'alert alert-danger');
                    }
                }
                redirect('inkindes');
            }

            //handling Unpublish
            if (isset($_POST['unpublish'])) {

                if (isset($_POST['record'])) {
                    if ($row_num = $this->inkindModel->unpublishById($_POST['record'], 'inkind_id')) {
                        flash('inkind_msg', 'تم ايقاف نشر ' . $row_num . ' بنجاح');
                    } else {
                        flash('inkind_msg', 'هناك خطأ ما يرجي المحاولة لاحقا', 'alert alert-danger');
                    }
                }
                redirect('inkindes');
            }
        }

        //handling search
        $searches = $this->inkindModel->searchHandling(['district', 'full_name', 'email', 'phone', 'street', 'status'], $current);
        $cond .= $searches['cond'];
        $bind = $searches['bind'];

        // get all records count after search and filtration
        $recordsCount = $this->inkindModel->allInkindesCount($cond, $bind);
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
        //get all records for current inkind
        $inkindes = $this->inkindModel->getInkindes($cond, $bind, $limit, $bindLimit);

        $data = [
            'current' => $current,
            'perpage' => $perpage,
            'header' => '',
            'title' => 'التبرعات العينية',
            'inkindes' => $inkindes,
            'recordsCount' => $recordsCount->count,
            'footer' => '',
        ];
        $this->view('inkindes/index', $data);
    }

    /**
     * adding new inkind
     */
    public function add()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // sanitize POST array
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

            $data = [
                'page_title' => 'التبرعات العينية',
                'district' => trim($_POST['district']),
                'message' => trim($_POST['message']),
                'full_name' => trim($_POST['full_name']),
                'email' => trim($_POST['email']),
                'phone' => trim($_POST['phone']),
                'street' => trim($_POST['street']),
                'status' => '',
                'status_error' => '',
                'district_error' => '',
                'message_error' => '',
                'full_name_error' => '',
            ];
            // validate district
            !(empty($data['district'])) ?: $data['district_error'] = 'هذا الحقل مطلوب';
            // validate message
            !(empty($data['message'])) ?: $data['message_error'] = 'هذا الحقل مطلوب';
            // validate full_name
            !(empty($data['full_name'])) ?: $data['full_name_error'] = 'هذا الحقل مطلوب';
            // validate status
            if (isset($_POST['status'])) {
                $data['status'] = trim($_POST['status']);
            }
            if ($data['status'] == '') {
                $data['status_error'] = 'من فضلك اختار حالة النشر';
            }
            //make sure there is no errors
            if (empty($data['status_error']) && empty($data['district_error']) && empty($data['message_error']) && empty($data['full_name_error'])) {
                //validated
                if ($this->inkindModel->addInkind($data)) {
                    flash('inkind_msg', 'تم الحفظ بنجاح');
                    redirect('inkindes');
                } else {
                    flash('inkind_msg', 'هناك خطأ ما حاول مرة اخري', 'alert alert-danger');
                }
            } else {
                //load the view with error
                $this->view('inkindes/add', $data);
            }
        } else {
            $data = [
                'page_title' => 'التبرعات العينية',
                'district' => '',
                'message' => '',
                'full_name' => '',
                'email' => '',
                'phone' => '',
                'street' => '',
                'status' => 0,
                'status_error' => '',
                'district_error' => '',
                'message_error' => '',
                'full_name_error' => '',
            ];
        }

        //loading the add inkind view
        $this->view('inkindes/add', $data);
    }

    /**
     * update inkind
     * @param integer $id
     */
    public function edit($id)
    {
        $id = (int) $id;
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // sanitize POST array
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

            $data = [
                'inkind_id' => $id,
                'page_title' => 'التبرعات العينية',
                'district' => trim($_POST['district']),
                'message' => trim($_POST['message']),
                'full_name' => trim($_POST['full_name']),
                'email' => trim($_POST['email']),
                'phone' => trim($_POST['phone']),
                'street' => trim($_POST['street']),
                'status' => '',
                'status_error' => '',
                'district_error' => '',
                'message_error' => '',
                'full_name_error' => '',
            ];
            
            // validate district
            !(empty($data['district'])) ?: $data['district_error'] = 'هذا الحقل مطلوب';
            // validate message
            !(empty($data['message'])) ?: $data['message_error'] = 'هذا الحقل مطلوب';
            // validate full_name
            !(empty($data['full_name'])) ?: $data['full_name_error'] = 'هذا الحقل مطلوب';

            // validate status
            if (isset($_POST['status'])) {
                $data['status'] = trim($_POST['status']);
            }
            if ($data['status'] == '') {
                $data['status_error'] = 'من فضلك اختار حالة النشر';
            }
            // make sure there is no errors
            if (empty($data['status_error']) && empty($data['district_error']) && empty($data['message_error']) && empty($data['full_name_error'])) {
                //validated
                if ($this->inkindModel->updateInkind($data)) {
                    flash('inkind_msg', 'تم التعديل بنجاح');
                    isset($_POST['save']) ? redirect('inkindes/edit/' . $id) : redirect('inkindes');
                } else {
                    flash('inkind_msg', 'هناك خطأ ما حاول مرة اخري', 'alert alert-danger');
                }
            } else {
                //load the view with error
                $this->view('inkindes/edit', $data);
            }
        } else {
            // featch inkind
            if (!$inkind = $this->inkindModel->getInkindById($id)) {
                flash('inkind_msg', 'هناك خطأ ما هذه الصفحة غير موجوده او ربما اتبعت رابط خاطيء ', 'alert alert-danger');
                redirect('inkindes');
            }

            $data = [
                'page_title' => 'التبرعات العينية',
                'inkind_id' => $id,
                'district' => $inkind->district,
                'message' => $inkind->message,
                'full_name' => $inkind->full_name,
                'email' => $inkind->email,
                'phone' => $inkind->phone,
                'street' => $inkind->street,
                'status' => $inkind->status,
                'status_error' => '',
                'district_error' => '',
                'message_error' => '',
                'full_name_error' => '',
            ];
            $this->view('inkindes/edit', $data);
        }
    }

    /**
     * showing inkind details
     * @param integer $id
     */
    public function show($id)
    {
        if (!$inkind = $this->inkindModel->getInkindById($id)) {
            flash('inkind_msg', 'هناك خطأ ما هذه الصفحة غير موجوده او ربما اتبعت رابط خاطيء ', 'alert alert-danger');
            redirect('inkindes');
        }
        $this->inkindModel->publishById([$id], 'inkind_id');
        $data = [
            'page_title' => 'التبرعات العينية',
            'inkind' => $inkind,
        ];
        $this->view('inkindes/show', $data);
    }

    /**
     * delete record by id
     * @param integer $id
     */
    public function delete($id)
    {
        if ($row_num = $this->inkindModel->deleteById([$id], 'inkind_id')) {
            flash('inkind_msg', 'تم حذف ' . $row_num . ' بنجاح');
        } else {
            flash('inkind_msg', 'لم يتم الحذف', 'alert alert-danger');
        }
        redirect('inkindes');
    }

    /**
     * publish record by id
     * @param integer $id
     */
    public function publish($id)
    {
        if ($row_num = $this->inkindModel->publishById([$id], 'inkind_id')) {
            flash('inkind_msg', 'تم تعليم كا مقروءة ' . $row_num . ' بنجاح');
        } else {
            flash('inkind_msg', 'هناك خطأ ما يرجي المحاولة لاحقا', 'alert alert-danger');
        }
        redirect('inkindes');
    }

    /**
     * publish record by id
     * @param integer $id
     */
    public function unpublish($id)
    {
        if ($row_num = $this->inkindModel->unpublishById([$id], 'inkind_id')) {
            flash('inkind_msg', 'تم تعليم كا غير مقروءة ' . $row_num . ' بنجاح');
        } else {
            flash('inkind_msg', 'هناك خطأ ما يرجي المحاولة لاحقا', 'alert alert-danger');
        }
        redirect('inkindes');
    }

}
