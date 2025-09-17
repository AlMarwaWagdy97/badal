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

class Statuses extends ControllerAdmin
{

    private $statusesModel;

    public function __construct()
    {
        $this->statusesModel = $this->model('Status');
    }

    /**
     * loading index view with latest statuses
     */
    public function index($current = '', $perpage = 50)
    {
        // get statuses
        $cond = 'WHERE status <> 2 ';
        $bind = [];

        //check user action if the form has submitted
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // sanitize POST array
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

            //handling Delete
            if (isset($_POST['delete'])) {
                if (isset($_POST['record'])) {
                    if ($row_num = $this->statusesModel->deleteById($_POST['record'], 'status_id')) {
                        flash('status_msg', 'تم حذف ' . $row_num . ' بنجاح');
                    } else {
                        flash('status_msg', 'لم يتم الحذف', 'alert alert-danger');
                    }
                }

                redirect('statuses');
            }

            //handling Publish
            if (isset($_POST['publish'])) {
                if (isset($_POST['record'])) {
                    if ($row_num = $this->statusesModel->publishById($_POST['record'], 'status_id')) {
                        flash('status_msg', 'تم نشر ' . $row_num . ' بنجاح');
                    } else {
                        flash('status_msg', 'هناك خطأ ما يرجي المحاولة لاحقا', 'alert alert-danger');
                    }
                }
                redirect('statuses');
            }

            //handling Unpublish
            if (isset($_POST['unpublish'])) {

                if (isset($_POST['record'])) {
                    if ($row_num = $this->statusesModel->unpublishById($_POST['record'], 'status_id')) {
                        flash('status_msg', 'تم ايقاف نشر ' . $row_num . ' بنجاح');
                    } else {
                        flash('status_msg', 'هناك خطأ ما يرجي المحاولة لاحقا', 'alert alert-danger');
                    }
                }
                redirect('statuses');
            }
        }

        //handling search
        $searches = $this->statusesModel->searchHandling(['name', 'description', 'status'], $current);
        $cond .= $searches['cond'];
        $bind = $searches['bind'];

        // get all records count after search and filtration
        $recordsCount = $this->statusesModel->allStatusesCount($cond, $bind);
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
        //get all records for current status
        $statuses = $this->statusesModel->getStatuses($cond, $bind, $limit, $bindLimit);

        $data = [
            'current' => $current,
            'perpage' => $perpage,
            'header' => '',
            'title' => 'الحالات',
            'statuses' => $statuses,
            'recordsCount' => $recordsCount->count,
            'footer' => '',
        ];
        $this->view('statuses/index', $data);
    }

    /**
     * adding new status
     */
    public function add()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // sanitize POST array
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

            $data = [
                'page_title' => 'الحالات',
                'name' => trim($_POST['name']),
                'alias' => preg_replace("([~!@#$%^&*()_+=`{}\[\]\|\\:;'<>,.\/? ])", "-", $_POST['name']),
                'description' => trim($_POST['description']),
                'status' => '',
                'status_error' => '',
                'name_error' => '',
            ];
            // validate name
            if (empty($data['name'])) {
                $data['name_error'] = 'هذا الحقل مطلوب';
            }
            // validate status
            if (isset($_POST['status'])) {
                $data['status'] = trim($_POST['status']);
            }
            if ($data['status'] == '') {
                $data['status_error'] = 'من فضلك اختار حالة النشر';
            }
            //make sure there is no errors
            if (empty($data['status_error']) && empty($data['name_error'])) {
                //validated
                if ($this->statusesModel->addStatus($data)) {
                    flash('status_msg', 'تم الحفظ بنجاح');
                    redirect('statuses');
                } else {
                    flash('status_msg', 'هناك خطأ ما حاول مرة اخري', 'alert alert-danger');
                }
            } else {
                //load the view with error
                $this->view('statuses/add', $data);
            }
        } else {
            $data = [
                'page_title' => 'حالات الطلبات',
                'name' => '',
                'description' => '',
                'status' => 0,
                'name_error' => '',
                'status_error' => '',
            ];
        }

        //loading the add status view
        $this->view('statuses/add', $data);
    }

    /**
     * update status
     * @param integer $id
     */
    public function edit($id)
    {
        $id = (int) $id;
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // sanitize POST array
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

            $data = [
                'status_id' => $id,
                'page_title' => 'الحالات',
                'name' => trim($_POST['name']),
                'description' => trim($_POST['description']),
                'status' => trim($_POST['status']),
                'status_error' => '',
                'name_error' => '',
            ];

            // validate name
            if (empty($data['name'])) {
                $data['name_error'] = 'هذا الحقل مطلوب';
            }
            // validate status
            if (isset($_POST['status'])) {
                $data['status'] = trim($_POST['status']);
            }
            if ($data['status'] == '') {
                $data['status_error'] = 'من فضلك اختار حالة النشر';
            }
            // make sure there is no errors
            if (empty($data['status_error']) && empty($data['name_error'])) {
                //validated
                if ($this->statusesModel->updateStatus($data)) {
                    flash('status_msg', 'تم التعديل بنجاح');
                    isset($_POST['save']) ? redirect('statuses/edit/' . $id) : redirect('statuses');
                } else {
                    flash('status_msg', 'هناك خطأ ما حاول مرة اخري', 'alert alert-danger');
                }
            } else {
                //load the view with error
                $this->view('statuses/edit', $data);
            }
        } else {
            // featch status
            if (!$status = $this->statusesModel->getStatusById($id)) {
                flash('status_msg', 'هناك خطأ ما هذه الصفحة غير موجوده او ربما اتبعت رابط خاطيء ', 'alert alert-danger');
                redirect('statuses');
            }

            $data = [
                'page_title' => 'الحالات',
                'status_id' => $id,
                'name' => $status->name,
                'description' => $status->description,
                'status' => $status->status,
                'status_error' => '',
                'name_error' => '',
            ];
            $this->view('statuses/edit', $data);
        }
    }

    /**
     * showing status details
     * @param integer $id
     */
    public function show($id)
    {
        if (!$status = $this->statusesModel->getStatusById($id)) {
            flash('status_msg', 'هناك خطأ ما هذه الصفحة غير موجوده او ربما اتبعت رابط خاطيء ', 'alert alert-danger');
            redirect('statuses');
        }
        $data = [
            'page_title' => 'الحالات',
            'status' => $status,
        ];
        $this->view('statuses/show', $data);
    }

    /**
     * delete record by id
     * @param integer $id
     */
    public function delete($id)
    {
        if ($row_num = $this->statusesModel->deleteById([$id], 'status_id')) {
            flash('status_msg', 'تم حذف ' . $row_num . ' بنجاح');
        } else {
            flash('status_msg', 'لم يتم الحذف', 'alert alert-danger');
        }
        redirect('statuses');
    }

    /**
     * publish record by id
     * @param integer $id
     */
    public function publish($id)
    {
        if ($row_num = $this->statusesModel->publishById([$id], 'status_id')) {
            flash('status_msg', 'تم نشر ' . $row_num . ' بنجاح');
        } else {
            flash('status_msg', 'هناك خطأ ما يرجي المحاولة لاحقا', 'alert alert-danger');
        }
        redirect('statuses');
    }

    /**
     * publish record by id
     * @param integer $id
     */
    public function unpublish($id)
    {
        if ($row_num = $this->statusesModel->unpublishById([$id], 'status_id')) {
            flash('status_msg', 'تم ايقاف نشر ' . $row_num . ' بنجاح');
        } else {
            flash('status_msg', 'هناك خطأ ما يرجي المحاولة لاحقا', 'alert alert-danger');
        }
        redirect('statuses');
    }

}
