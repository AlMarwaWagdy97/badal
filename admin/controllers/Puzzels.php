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

class Puzzels extends ControllerAdmin
{

    private $model;

    public function __construct()
    {

        $this->model = $this->model('Puzzel');
    }

    /**
     * loading index view with latest puzzels
     */
    public function index($current = '', $perpage = 50)
    {
        // get puzzels
        $cond = 'WHERE status <> 2 ';
        $bind = [];

        //check user action if the form has submitted
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // sanitize POST array
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

            //handling Delete
            if (isset($_POST['delete'])) {
                if (isset($_POST['record'])) {
                    if ($row_num = $this->model->deleteById($_POST['record'], 'puzzel_id')) {
                        flash('puzzel_msg', 'تم حذف ' . $row_num . ' بنجاح');
                    } else {
                        flash('puzzel_msg', 'لم يتم الحذف', 'alert alert-danger');
                    }
                }

                redirect('puzzels');
            }

            //handling Publish
            if (isset($_POST['publish'])) {
                if (isset($_POST['record'])) {
                    if ($row_num = $this->model->publishById($_POST['record'], 'puzzel_id')) {
                        flash('puzzel_msg', 'تم نشر ' . $row_num . ' بنجاح');
                    } else {
                        flash('puzzel_msg', 'هناك خطأ ما يرجي المحاولة لاحقا', 'alert alert-danger');
                    }
                }
                redirect('puzzels');
            }

            //handling Unpublish
            if (isset($_POST['unpublish'])) {

                if (isset($_POST['record'])) {
                    if ($row_num = $this->model->unpublishById($_POST['record'], 'puzzel_id')) {
                        flash('puzzel_msg', 'تم ايقاف نشر ' . $row_num . ' بنجاح');
                    } else {
                        flash('puzzel_msg', 'هناك خطأ ما يرجي المحاولة لاحقا', 'alert alert-danger');
                    }
                }
                redirect('puzzels');
            }
        }

        //handling search
        $searches = $this->model->searchHandling(['name', 'description', 'status'], $current);
        $cond .= $searches['cond'];
        $bind = $searches['bind'];
        // get all records count after search and filtration
        $recordsCount = $this->model->allPuzzelsCount($cond, $bind);

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
        //get all records for current puzzel
        $puzzels = $this->model->getPuzzels($cond, $bind, $limit, $bindLimit);

        $data = [
            'current' => $current,
            'perpage' => $perpage,
            'header' => '',
            'title' => 'الالغاز',
            'puzzels' => $puzzels,
            'recordsCount' => $recordsCount->count,
            'footer' => '',
        ];
        $this->view('puzzels/index', $data);
    }

    /**
     * adding new puzzel
     */
    public function add()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // sanitize POST array
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

            $data = [
                'page_title' => 'الالغاز',
                'description' => trim($_POST['description']),
                'image' => '',
                'image2' => '',
                'name' => trim($_POST['name']),
                'width' => trim($_POST['width']),
                'height' => trim($_POST['height']),
                'piecesx' => trim($_POST['piecesx']),
                'piecesy' => trim($_POST['piecesy']),
                'rotate' => trim($_POST['rotate']),
                'timeout' => trim($_POST['timeout']),
                'timeout_url' => trim($_POST['timeout_url']),
                'status' => '',
                'status_error' => '',
                'name_error' => '',
                'image2_error' => '',
                'image_error' => '',
                'width_error' => '',
                'height_error' => '',
                'piecesx_error' => '',
                'piecesy_error' => '',
                'rotate_error' => '',
                'timeout_error' => '',
            ];
            // validate name
            !(empty($data['name'])) ?: $data['name_error'] = 'هذا الحقل مطلوب';
            !(empty($data['width'])) ?: $data['width_error'] = 'هذا الحقل مطلوب';
            !(empty($data['height'])) ?: $data['height_error'] = 'هذا الحقل مطلوب';
            !(empty($data['piecesx'])) ?: $data['piecesx_error'] = 'هذا الحقل مطلوب';
            !(empty($data['piecesy'])) ?: $data['piecesy_error'] = 'هذا الحقل مطلوب';
            !(empty($data['timeout'])) ?: $data['timeout_error'] = 'هذا الحقل مطلوب';
            // validate status
            if (isset($_POST['status'])) {
                $data['status'] = trim($_POST['status']);
            }
            if ($data['status'] == '') {
                $data['status_error'] = 'من فضلك اختار حالة النشر';
            }
            if (isset($_POST['rotate'])) {
                $data['rotate'] = trim($_POST['rotate']);
            }
            if ($data['rotate'] == '') {
                $data['rotate_error'] = 'من فضلك اختار حالة النشر';
            }
            // validate image
            if ($_FILES['image']['error'] != 4) {
                $image = uploadImage('image', ADMINROOT . '/../media/files/puzzels/', 5000000, false);
                if (empty($image['error'])) {
                    $data['image'] = $image['filename'];
                } else {
                    if (!isset($image['error']['nofile'])) {
                        $data['image_error'] = implode(',', $image['error']);
                    }
                }
            } else {
                $data['image_error'] = "من فضلك قم برفع صورة";
            }
            //make sure there is no errors
            if (
                empty($data['status_error']) && empty($data['name_error']) && empty($data['image_error']) && empty($data['width_error'])
                && empty($data['height_error']) && empty($data['piecesx_error']) && empty($data['piecesy_error']) && empty($data['rotate_error'])
                && empty($data['timeout_error'])
            ) {
                //validated
                if ($this->model->addPuzzel($data)) {
                    flash('puzzel_msg', 'تم الحفظ بنجاح');
                    redirect('puzzels');
                } else {
                    flash('puzzel_msg', 'هناك خطأ ما حاول مرة اخري', 'alert alert-danger');
                }
            } else {
                //load the view with error
                $this->view('puzzels/add', $data);
            }
        } else {
            $data = [
                'page_title' => 'الالغاز',
                'description' => '',
                'image' => '',
                'image' => '',
                'name' => '',
                'width' => '',
                'height' => '',
                'piecesx' => '',
                'piecesy' => '',
                'rotate' => '',
                'timeout' => '',
                'timeout_url' => '',
                'status' => 0,
                'status_error' => '',
                'name_error' => '',
                'image_error' => '',
                'image2_error' => '',
                'height_error' => '',
                'width_error' => '',
                'piecesx_error' => '',
                'piecesy_error' => '',
                'rotate_error' => '',
                'timeout_error' => '',
            ];
        }

        //loading the add puzzel view
        $this->view('puzzels/add', $data);
    }

    /**
     * update puzzel
     * @param integer $id
     */
    public function edit($id)
    {
        $id = (int) $id;
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // sanitize POST array
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

            $data = [
                'page_title' => 'الالغاز',
                'puzzel_id' => $id,
                'description' => trim($_POST['description']),
                'image' => '',
                'image2' => '',
                'name' => trim($_POST['name']),
                'width' => trim($_POST['width']),
                'height' => trim($_POST['height']),
                'piecesx' => trim($_POST['piecesx']),
                'piecesy' => trim($_POST['piecesy']),
                'rotate' => trim($_POST['rotate']),
                'timeout' => trim($_POST['timeout']),
                'timeout_url' => trim($_POST['timeout_url']),
                'status' => '',
                'status_error' => '',
                'name_error' => '',
                'image_error' => '',
                'image2_error' => '',
                'width_error' => '',
                'height_error' => '',
                'piecesx_error' => '',
                'piecesy_error' => '',
                'rotate_error' => '',
                'timeout_error' => '',
            ];
            // validate 
            !(empty($data['name'])) ?: $data['name_error'] = 'هذا الحقل مطلوب';
            !(empty($data['width'])) ?: $data['width_error'] = 'هذا الحقل مطلوب';
            !(empty($data['height'])) ?: $data['height_error'] = 'هذا الحقل مطلوب';
            !(empty($data['piecesx'])) ?: $data['piecesx_error'] = 'هذا الحقل مطلوب';
            !(empty($data['piecesy'])) ?: $data['piecesy_error'] = 'هذا الحقل مطلوب';
            !(empty($data['timeout'])) ?: $data['timeout_error'] = 'هذا الحقل مطلوب';
            if (isset($_POST['status'])) {
                $data['status'] = trim($_POST['status']);
            }
            if ($data['status'] == '') {
                $data['status_error'] = 'من فضلك اختار حالة النشر';
            }
            if (isset($_POST['rotate'])) {
                $data['rotate'] = trim($_POST['rotate']);
            }
            if ($data['rotate'] == '') {
                $data['rotate_error'] = 'من فضلك اختار حالة النشر';
            }
            // validate image
            if ($_FILES['image']['error'] != 4) {
                $image = uploadImage('image', ADMINROOT . '/../media/files/puzzels/', 5000000, false);
                if (empty($image['error'])) {
                    $data['image'] = $image['filename'];
                } else {
                    if (!isset($image['error']['nofile'])) {
                        $data['image_error'] = implode(',', $image['error']);
                    }
                }
            }
            // validate image
            if ($_FILES['image2']['error'] != 4) {
                $image = uploadImage('image2', ADMINROOT . '/../media/files/puzzels/', 5000000, false);
                if (empty($image['error'])) {
                    $data['image2'] = $image['filename'];
                } else {
                    if (!isset($image['error']['nofile'])) {
                        $data['image2_error'] = implode(',', $image['error']);
                    }
                }
            }
            //make sure there is no errors
            if (
                empty($data['status_error']) && empty($data['name_error']) && empty($data['width_error'])
                && empty($data['height_error']) && empty($data['piecesx_error']) && empty($data['piecesy_error']) && empty($data['rotate_error'])
                && empty($data['timeout_error'])
            ) {
                //validated
                if ($this->model->updatePuzzel($data)) {
                    flash('puzzel_msg', 'تم التعديل بنجاح');
                    isset($_POST['save']) ? redirect('puzzels/edit/' . $id) : redirect('puzzels');
                } else {
                    flash('puzzel_msg', 'هناك خطأ ما حاول مرة اخري', 'alert alert-danger');
                }
            } else {
                //load the view with error
                $this->view('puzzels/edit', $data);
            }
        } else {
            // featch puzzel
            if (!$puzzel = $this->model->getPuzzelById($id)) {
                flash('puzzel_msg', 'هناك خطأ ما هذه الصفحة غير موجوده او ربما اتبعت رابط خاطيء ', 'alert alert-danger');
                redirect('puzzels');
            }

            $data = [
                'page_title' => 'الالغاز',
                'puzzel_id' => $id,
                'name' => $puzzel->name,
                'width' => $puzzel->width,
                'height' => $puzzel->height,
                'piecesx' => $puzzel->piecesx,
                'piecesy' => $puzzel->piecesy,
                'rotate' => $puzzel->rotate,
                'timeout' => $puzzel->timeout,
                'timeout_url' => $puzzel->timeout_url,
                'description' => $puzzel->description,
                'status' =>  $puzzel->status,
                'status_error' => '',
                'name_error' => '',
                'image_error' => '',
                'image2_error' => '',
                'width_error' => '',
                'height_error' => '',
                'piecesx_error' => '',
                'piecesy_error' => '',
                'rotate_error' => '',
                'timeout_error' => '',
            ];
            $this->view('puzzels/edit', $data);
        }
    }

    /**
     * showing puzzel details
     * @param integer $id
     */
    public function show($id)
    {
        if (!$puzzel = $this->model->getPuzzelById($id)) {
            flash('puzzel_msg', 'هناك خطأ ما هذه الصفحة غير موجوده او ربما اتبعت رابط خاطيء ', 'alert alert-danger');
            redirect('puzzels');
        }
        $this->model->publishById([$id], 'puzzel_id');
        $data = [
            'page_title' => 'الالغاز',
            'puzzel' => $puzzel,
        ];
        $this->view('puzzels/show', $data);
    }

    /**
     * delete record by id
     * @param integer $id
     */
    public function delete($id)
    {
        if ($row_num = $this->model->deleteById([$id], 'puzzel_id')) {
            flash('puzzel_msg', 'تم حذف ' . $row_num . ' بنجاح');
        } else {
            flash('puzzel_msg', 'لم يتم الحذف', 'alert alert-danger');
        }
        redirect('puzzels');
    }

    /**
     * publish record by id
     * @param integer $id
     */
    public function publish($id)
    {
        if ($row_num = $this->model->publishById([$id], 'puzzel_id')) {
            flash('puzzel_msg', 'تم تعليم كا مقروءة ' . $row_num . ' بنجاح');
        } else {
            flash('puzzel_msg', 'هناك خطأ ما يرجي المحاولة لاحقا', 'alert alert-danger');
        }
        redirect('puzzels');
    }

    /**
     * publish record by id
     * @param integer $id
     */
    public function unpublish($id)
    {
        if ($row_num = $this->model->unpublishById([$id], 'puzzel_id')) {
            flash('puzzel_msg', 'تم تعليم كا غير مقروءة ' . $row_num . ' بنجاح');
        } else {
            flash('puzzel_msg', 'هناك خطأ ما يرجي المحاولة لاحقا', 'alert alert-danger');
        }
        redirect('puzzels');
    }
}
