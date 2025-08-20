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

class Slides extends ControllerAdmin
{

    private $slideModel;

    public function __construct()
    {
        $this->slideModel = $this->model('Slide');
    }

    /**
     * loading index view with latest slides
     */
    public function index($current = '', $perpage = 50)
    {
        // get slides
        $cond = 'WHERE status <> 2 ';
        $bind = [];

        //check user action if the form has submitted
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // sanitize POST array
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

            //handling Delete
            if (isset($_POST['delete'])) {
                if (isset($_POST['record'])) {
                    if ($row_num = $this->slideModel->deleteById($_POST['record'], 'slide_id')) {
                        flash('slide_msg', 'تم حذف ' . $row_num . ' بنجاح');
                    } else {
                        flash('slide_msg', 'لم يتم الحذف', 'alert alert-danger');
                    }
                }

                redirect('slides');
            }

            //handling Publish
            if (isset($_POST['publish'])) {
                if (isset($_POST['record'])) {
                    if ($row_num = $this->slideModel->publishById($_POST['record'], 'slide_id')) {
                        flash('slide_msg', 'تم نشر ' . $row_num . ' بنجاح');
                    } else {
                        flash('slide_msg', 'هناك خطأ ما يرجي المحاولة لاحقا', 'alert alert-danger');
                    }
                }
                redirect('slides');
            }

            //handling Unpublish
            if (isset($_POST['unpublish'])) {

                if (isset($_POST['record'])) {
                    if ($row_num = $this->slideModel->unpublishById($_POST['record'], 'slide_id')) {
                        flash('slide_msg', 'تم ايقاف نشر ' . $row_num . ' بنجاح');
                    } else {
                        flash('slide_msg', 'هناك خطأ ما يرجي المحاولة لاحقا', 'alert alert-danger');
                    }
                }
                redirect('slides');
            }
        }

        //handling search
        $searches = $this->slideModel->searchHandling(['name', 'url', 'description', 'status'], $current);
        $cond .= $searches['cond'];
        $bind = $searches['bind'];

        // get all records count after search and filtration
        $recordsCount = $this->slideModel->allSlidesCount($cond, $bind);
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
        //get all records for current slide
        $slides = $this->slideModel->getSlides($cond, $bind, $limit, $bindLimit);

        $data = [
            'current' => $current,
            'perpage' => $perpage,
            'header' => '',
            'title' => 'الشرائح',
            'slides' => $slides,
            'recordsCount' => $recordsCount->count,
            'footer' => '',
        ];
        $this->view('slides/index', $data);
    }

    /**
     * adding new slide
     */
    public function add()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // sanitize POST array
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

            $data = [
                'page_title' => 'الشرائح',
                'name' => trim($_POST['name']),
                'alias' => preg_replace("([~!@#$%^&*()_+=`{}\[\]\|\\:;'<>,.\/? ])", "-", $_POST['name']),
                'url' => trim($_POST['url']),
                'description' => trim($_POST['description']),
                'image' => '',
                'status' => '',
                'arrangement' => trim($_POST['arrangement']),
                'status_error' => '',
                'name_error' => '',
                'image_error' => '',
            ];

            // // validate image
            // $image = $this->slideModel->validateImage('image');
            // ($image[0]) ? $data['image'] = $image[1] : $data['image_error'] = $image[1];
            
            
             if (!empty($_FILES['image'])) {
                $image = uploadImage('image', ADMINROOT . '/../media/images/', 5000000, true);
                if (empty($image['error'])) {
                    $data['image'] = $image['filename'];
                } else {
                    if (!isset($image['error']['nofile'])) {
                        $data['image_error'] = implode(',', $image['error']);
                    }
                }
            }
            
            if ($_FILES['image']['error'] > 0) {
                $data['image_error'] = 'لم تقم بأختيار ملف';
            }
            // validate status
            if (isset($_POST['status'])) {
                $data['status'] = trim($_POST['status']);
            }
            if ($data['status'] == '') {
                $data['status_error'] = 'من فضلك اختار حالة النشر';
            }
            //make sure there is no errors
            if (empty($data['status_error']) && empty($data['image_error'])) {
                //validated
                if ($this->slideModel->addSlide($data)) {
                    flash('slide_msg', 'تم الحفظ بنجاح');
                    redirect('slides');
                } else {
                    flash('slide_msg', 'هناك خطأ ما حاول مرة اخري', 'alert alert-danger');
                }
            } else {
                //load the view with error
                $this->view('slides/add', $data);
            }
        } else {
            $data = [
                'page_title' => 'الشرائح',
                'name' => '',
                'description' => '',
                'image' => '',
                'url' => '',
                'status' => 0,
                'arrangement' => 0,
                'featured' => 0,
                'name_error' => '',
                'status_error' => '',
                'image_error' => '',
            ];
        }

        //loading the add slide view
        $this->view('slides/add', $data);
    }

    /**
     * update slide
     * @param integer $id
     */
    public function edit($id)
    {
        $id = (int) $id;
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // sanitize POST array
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

            $data = [
                'slide_id' => $id,
                'page_title' => 'الشرائح',
                'name' => trim($_POST['name']),
                'image' => '',
                'description' => trim($_POST['description']),
                'url' => trim($_POST['url']),
                'status' => trim($_POST['status']),
                'arrangement' => trim($_POST['arrangement']),
                'status_error' => '',
                'name_error' => '',
                'image_error' => '',
            ];
            // validate image 
            // if ($_FILES['image']['error'] != 4) { // no file has uploaded
            //     $image = $this->slideModel->validateImage('image');
            //     ($image[0]) ? $data['image'] = $image[1] : $data['image_error'] = $image[1];
            // }
             if (!empty($_FILES['image'])) {
                $image = uploadImage('image', ADMINROOT . '/../media/images/', 5000000, true);
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
            // make sure there is no errors
            if (empty($data['status_error']) && empty($data['image_error'])) {
                //validated
                if ($this->slideModel->updateSlide($data)) {
                    flash('slide_msg', 'تم التعديل بنجاح');
                    isset($_POST['save']) ? redirect('slides/edit/' . $id) : redirect('slides');
                } else {
                    flash('slide_msg', 'هناك خطأ ما حاول مرة اخري', 'alert alert-danger');
                }
            } else {
                //load the view with error
                $this->view('slides/edit', $data);
            }
        } else {
            // featch slide
            if (!$slide = $this->slideModel->getSlideById($id)) {
                flash('slide_msg', 'هناك خطأ ما هذه الصفحة غير موجوده او ربما اتبعت رابط خاطيء ', 'alert alert-danger');
                redirect('slides');
            }

            $data = [
                'page_title' => 'الشرائح',
                'slide_id' => $id,
                'name' => $slide->name,
                'description' => $slide->description,
                'image' => $slide->image,
                'url' => $slide->url,
                'status' => $slide->status,
                'arrangement' => $slide->arrangement,
                'status_error' => '',
                'name_error' => '',
                'image_error' => '',
            ];
            $this->view('slides/edit', $data);
        }
    }

    /**
     * showing slide details
     * @param integer $id
     */
    public function show($id)
    {
        if (!$slide = $this->slideModel->getSlideById($id)) {
            flash('slide_msg', 'هناك خطأ ما هذه الصفحة غير موجوده او ربما اتبعت رابط خاطيء ', 'alert alert-danger');
            redirect('slides');
        }
        $data = [
            'page_title' => 'الشرائح',
            'slide' => $slide,
        ];
        $this->view('slides/show', $data);
    }

    /**
     * delete record by id
     * @param integer $id
     */
    public function delete($id)
    {
        if ($row_num = $this->slideModel->deleteById([$id], 'slide_id')) {
            flash('slide_msg', 'تم حذف ' . $row_num . ' بنجاح');
        } else {
            flash('slide_msg', 'لم يتم الحذف', 'alert alert-danger');
        }
        redirect('slides');
    }

    /**
     * publish record by id
     * @param integer $id
     */
    public function publish($id)
    {
        if ($row_num = $this->slideModel->publishById([$id], 'slide_id')) {
            flash('slide_msg', 'تم نشر ' . $row_num . ' بنجاح');
        } else {
            flash('slide_msg', 'هناك خطأ ما يرجي المحاولة لاحقا', 'alert alert-danger');
        }
        redirect('slides');
    }

    /**
     * publish record by id
     * @param integer $id
     */
    public function unpublish($id)
    {
        if ($row_num = $this->slideModel->unpublishById([$id], 'slide_id')) {
            flash('slide_msg', 'تم ايقاف نشر ' . $row_num . ' بنجاح');
        } else {
            flash('slide_msg', 'هناك خطأ ما يرجي المحاولة لاحقا', 'alert alert-danger');
        }
        redirect('slides');
    }
}
