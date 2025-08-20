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

class Volunteerpages extends ControllerAdmin
{

    private $model;

    public function __construct()
    {
        $this->model = $this->model('Volunteerpage');
    }

    /**
     * loading index view with latest volunteerpages
     */
    public function index($current = '', $perpage = 50)
    {
        // get volunteerpages
        $cond = 'WHERE status <> 2 ';
        $bind = [];

        //check user action if the form has submitted 
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // sanitize POST array
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

            //handling Delete
            if (isset($_POST['delete'])) {
                if (isset($_POST['record'])) {
                    if ($row_num = $this->model->deleteById($_POST['record'], 'volunteerpage_id')) {
                        flash('volunteerpage_msg', 'تم حذف ' . $row_num . ' بنجاح');
                    } else {
                        flash('volunteerpage_msg', 'لم يتم الحذف', 'alert alert-danger');
                    }
                }

                redirect('volunteerpages');
            }

            //handling Publish
            if (isset($_POST['publish'])) {
                if (isset($_POST['record'])) {
                    if ($row_num = $this->model->publishById($_POST['record'], 'volunteerpage_id')) {
                        flash('volunteerpage_msg', 'تم نشر ' . $row_num . ' بنجاح');
                    } else {
                        flash('volunteerpage_msg', 'هناك خطأ ما يرجي المحاولة لاحقا', 'alert alert-danger');
                    }
                }
                redirect('volunteerpages');
            }

            //handling Unpublish
            if (isset($_POST['unpublish'])) {

                if (isset($_POST['record'])) {
                    if ($row_num = $this->model->unpublishById($_POST['record'], 'volunteerpage_id')) {
                        flash('volunteerpage_msg', 'تم ايقاف نشر ' . $row_num . ' بنجاح');
                    } else {
                        flash('volunteerpage_msg', 'هناك خطأ ما يرجي المحاولة لاحقا', 'alert alert-danger');
                    }
                }
                redirect('volunteerpages');
            }
        }

        //handling search
        $searches = $this->model->searchHandling(['title', 'status'], $current);
        $cond .= $searches['cond'];
        $bind = $searches['bind'];

        // get all records count after search and filtration 
        $recordsCount = $this->model->allPagesCount($cond, $bind);
        // make sure its integer value and its usable
        $current = (int) $current;
        $perpage = (int) $perpage;

        ($perpage == 0) ? $perpage = 20 : NULL;
        if ($current <= 0 || $current > ceil($recordsCount->count / $perpage)) {
            $current = 1;
            $limit = 'LIMIT 0 , :perpage ';
            $bindLimit[':perpage'] = $perpage;
        } else {
            $limit = 'LIMIT  ' . (($current - 1) * $perpage) . ', :perpage';
            $bindLimit[':perpage'] = $perpage;
        }
        //get all records for current volunteerpage
        $volunteerpages = $this->model->getPages($cond, $bind, $limit, $bindLimit);

        $data = [
            'current' => $current,
            'perpage' => $perpage,
            'header' => '',
            'title' => 'حملات التطوع',
            'volunteerpages' => $volunteerpages,
            'recordsCount' => $recordsCount->count,
            'footer' => ''
        ];
        $this->view('volunteerpages/index', $data);
    }

    /**
     * adding new volunteerpage
     */
    public function add()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            $content = $this->model->cleanHTML($_POST['content']);
            // sanitize POST array
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

            $data = [
                'page_title' => 'حملات التطوع',
                'title' => trim($_POST['title']),
                'alias' => preg_replace("([~!@#$%^&*()_+=`{}\[\]\|\\:;'<>,.\/? ])", "-", $_POST['title']),
                'content' => $content,
                'image' => '',
                'meta_keywords' => trim($_POST['meta_keywords']),
                'meta_description' => trim($_POST['meta_description']),
                'status' => '',
                'status_error' => '',
                'image_error' => ''
            ];

            // validate image
            if (!empty($_FILES['image'])) {
                $image = uploadImage('image', ADMINROOT . '/../media/images/', 5000000, TRUE);
                if (empty($image['error'])) {
                    $data['image'] = $image['filename'];
                } else {
                    if (!isset($image['error']['nofile'])) {
                        $data['image_error'] = implode(',', $image['error']);
                    }
                }
            }
            // validate status
            if (isset($_POST['status'])) {
                $data['status'] = trim($_POST['status']);
            }
            if ($data['status'] == '') {
                $data['status_error'] = 'من فضلك اختار حالة النشر';
            }
            //             make sure there is no errors
            if (empty($data['status_error']) && empty($data['image_error'])) {
                //validated 
                if ($this->model->addPage($data)) {
                    flash('volunteerpage_msg', 'تم الحفظ بنجاح');
                    redirect('volunteerpages');
                } else {
                    flash('volunteerpage_msg', 'هناك خطأ ما حاول مرة اخري', 'alert alert-danger');
                }
            } else {
                //load the view with error
                $this->view('volunteerpages/add', $data);
            }
        } else {
            $data = [
                'page_title' => 'حملات التطوع',
                'title' => '',
                'content' => '',
                'image' => '',
                'meta_keywords' => '',
                'meta_description' => '',
                'status' => 0,
                'title_error' => '',
                'status_error' => '',
                'image_error' => '',
            ];
        }

        //loading the add volunteerpage view
        $this->view('volunteerpages/add', $data);
    }

    /**
     * update volunteerpage
     * @param integer $id
     */
    public function edit($id)
    {
        $id = (int) $id;
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            //cleare html content from malicious
            $content = $this->model->cleanHTML($_POST['content']);
            // sanitize POST array
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

            $data = [
                'volunteerpage_id' => $id,
                'page_title' => 'حملات التطوع',
                'title' => trim($_POST['title']),
                'content' => $content,
                'image' => '',
                'meta_keywords' => trim($_POST['meta_keywords']),
                'meta_description' => trim($_POST['meta_description']),
                'status' => '',
                'status_error' => '',
                'image_error' => ''
            ];

            // validate image
            if (!empty($_FILES['image'])) {
                $image = uploadImage('image', ADMINROOT . '/../media/images/', 5000000, TRUE);
                if (empty($image['error'])) {
                    $data['image'] = $image['filename'];
                } else {
                    if (!isset($image['error']['nofile'])) {
                        $data['image_error'] = implode(',', $image['error']);
                    }
                }
            }
            // validate status
            if (isset($_POST['status'])) {
                $data['status'] = trim($_POST['status']);
            }
            if ($data['status'] == '') {
                $data['status_error'] = 'من فضلك اختار حالة النشر';
            }
            //             make sure there is no errors
            if (empty($data['status_error']) && empty($data['image_error'])) {
                //validated 
                if ($this->model->updatePage($data)) {
                    flash('volunteerpage_msg', 'تم التعديل بنجاح');
                    isset($_POST['save']) ? redirect('volunteerpages/edit/' . $id) : redirect('volunteerpages');
                } else {
                    flash('volunteerpage_msg', 'هناك خطأ ما حاول مرة اخري', 'alert alert-danger');
                }
            } else {
                //load the view with error
                $this->view('volunteerpages/edit', $data);
            }
        } else {
            // featch volunteerpage       
            if (!$volunteerpage = $this->model->getPageById($id)) {
                flash('volunteerpage_msg', 'هناك خطأ ما هذه الصفحة غير موجوده او ربما اتبعت رابط خاطيء ', 'alert alert-danger');
                redirect('volunteerpages');
            }

            $data = [
                'page_title' => 'حملات التطوع',
                'volunteerpage_id' => $id,
                'title' => $volunteerpage->title,
                'content' => $volunteerpage->content,
                'image' => $volunteerpage->image,
                'meta_keywords' => $volunteerpage->meta_keywords,
                'meta_description' => $volunteerpage->meta_description,
                'status' => $volunteerpage->status,
                'title_error' => '',
                'status_error' => '',
                'image_error' => '',
            ];
            $this->view('volunteerpages/edit', $data);
        }
    }

    /**
     * showing volunteerpage details
     * @param integer $id
     */
    public function show($id)
    {
        if (!$volunteerpage = $this->model->getPageById($id)) {
            flash('volunteerpage_msg', 'هناك خطأ ما هذه الصفحة غير موجوده او ربما اتبعت رابط خاطيء ', 'alert alert-danger');
            redirect('volunteerpages');
        }
        $data = [
            'page_title' => 'حملات التطوع',
            'volunteerpage' => $volunteerpage
        ];
        $this->view('volunteerpages/show', $data);
    }

    /**
     * delete record by id 
     * @param integer $id
     */
    public function delete($id)
    {
        if ($row_num = $this->model->deleteById([$id], 'volunteerpage_id')) {
            flash('volunteerpage_msg', 'تم حذف ' . $row_num . ' بنجاح');
        } else {
            flash('volunteerpage_msg', 'لم يتم الحذف', 'alert alert-danger');
        }
        redirect('volunteerpages');
    }

    /**
     * publish record by id 
     * @param integer $id
     */
    public function publish($id)
    {
        if ($row_num = $this->model->publishById([$id], 'volunteerpage_id')) {
            flash('volunteerpage_msg', 'تم نشر ' . $row_num . ' بنجاح');
        } else {
            flash('volunteerpage_msg', 'هناك خطأ ما يرجي المحاولة لاحقا', 'alert alert-danger');
        }
        redirect('volunteerpages');
    }

    /**
     * publish record by id 
     * @param integer $id
     */
    public function unpublish($id)
    {
        if ($row_num = $this->model->unpublishById([$id], 'volunteerpage_id')) {
            flash('volunteerpage_msg', 'تم ايقاف نشر ' . $row_num . ' بنجاح');
        } else {
            flash('volunteerpage_msg', 'هناك خطأ ما يرجي المحاولة لاحقا', 'alert alert-danger');
        }
        redirect('volunteerpages');
    }
}
