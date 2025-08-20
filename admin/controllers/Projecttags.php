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

class ProjectTags extends ControllerAdmin
{

    private $projectTagModel;

    public function __construct()
    {
        $this->projectTagModel = $this->model('ProjectTag');
    }

    /**
     * loading index view with latest projecttags
     */
    public function index($current = '', $perpage = 50)
    {
        // get projecttags
        $cond = 'WHERE status <> 2 ';
        $bind = [];

        //check user action if the form has submitted
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // sanitize POST array
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

            //handling Delete
            if (isset($_POST['delete'])) {
                if (isset($_POST['record'])) {
                    if ($row_num = $this->projectTagModel->deleteById($_POST['record'], 'tag_id')) {
                        flash('projecttag_msg', 'تم حذف ' . $row_num . ' بنجاح');
                    } else {
                        flash('projecttag_msg', 'لم يتم الحذف', 'alert alert-danger');
                    }
                }

                redirect('projecttags');
            }

            //handling Publish
            if (isset($_POST['publish'])) {
                if (isset($_POST['record'])) {
                    if ($row_num = $this->projectTagModel->publishById($_POST['record'], 'tag_id')) {
                        flash('projecttag_msg', 'تم نشر ' . $row_num . ' بنجاح');
                    } else {
                        flash('projecttag_msg', 'هناك خطأ ما يرجي المحاولة لاحقا', 'alert alert-danger');
                    }
                }
                redirect('projecttags');
            }

            //handling Unpublish
            if (isset($_POST['unpublish'])) {

                if (isset($_POST['record'])) {
                    if ($row_num = $this->projectTagModel->unpublishById($_POST['record'], 'tag_id')) {
                        flash('projecttag_msg', 'تم ايقاف نشر ' . $row_num . ' بنجاح');
                    } else {
                        flash('projecttag_msg', 'هناك خطأ ما يرجي المحاولة لاحقا', 'alert alert-danger');
                    }
                }
                redirect('projecttags');
            }
        }

        //handling search
        $searches = $this->projectTagModel->searchHandling(['name', 'description', 'status'], $current);
        $cond .= $searches['cond'];
        $bind = $searches['bind'];

        // get all records count after search and filtration
        $recordsCount = $this->projectTagModel->allProjectTagsCount($cond, $bind);
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
        //get all records for current projecttag
        $projecttags = $this->projectTagModel->getProjectTags($cond, $bind, $limit, $bindLimit);

        $data = [
            'current' => $current,
            'perpage' => $perpage,
            'header' => '',
            'title' => 'الوسوم',
            'projecttags' => $projecttags,
            'recordsCount' => $recordsCount->count,
            'footer' => '',
        ];
        $this->view('projecttags/index', $data);
    }

    /**
     * adding new projecttag
     */
    public function add()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // sanitize POST array
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

            $data = [
                'page_title' => 'الوسوم',
                'name' => trim($_POST['name']),
                'alias' => preg_replace("([~!@#$%^&*()_+=`{}\[\]\|\\:;'<>,.\/? ])", "-", $_POST['name']),
                'description' => trim($_POST['description']),
                'image' => '',
                'meta_keywords' => trim($_POST['meta_keywords']),
                'meta_description' => trim($_POST['meta_description']),
                'status' => '',
                'arrangement' => trim($_POST['arrangement']),
                'back_home' => trim($_POST['back_home']),
                'background_image' => '',
                'background_color' => trim($_POST['background_color']),
                'featured' => trim($_POST['featured']),
                'status_error' => '',
                'name_error' => '',
                'image_error' => '',
                'background_image_error' => '',
            ];
// validate name
            if (empty($data['name'])) {
                $data['name_error'] = 'هذا الحقل مطلوب';
            }
            // validate image
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
            // validate background image
            if (!empty($_FILES['background_image'])) {
                $image = uploadImage('background_image', ADMINROOT . '/../media/images/', 5000000, true);
                if (empty($image['error'])) {
                    $data['background_image'] = $image['filename'];
                } else {
                    if (!isset($image['error']['nofile'])) {
                        $data['background_image_error'] = implode(',', $image['error']);
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
            if (empty($data['status_error']) && empty($data['image_error']) && empty($data['name_error']) && empty($data['background_image_error'])) {
                //validated
                if ($this->projectTagModel->addProjectTag($data)) {
                    flash('projecttag_msg', 'تم الحفظ بنجاح');
                    redirect('projecttags');
                } else {
                    flash('projecttag_msg', 'هناك خطأ ما حاول مرة اخري', 'alert alert-danger');
                }
            } else {
                //load the view with error
                $this->view('projecttags/add', $data);
            }
        } else {
            $data = [
                'page_title' => 'وسوم المشروعات',
                'name' => '',
                'description' => '',
                'image' => '',
                'meta_keywords' => '',
                'meta_description' => '',
                'status' => 0,
                'arrangement' => 0,
                'back_home' => 0,
                'background_image' => '',
                'background_color' => '',
                'featured' => 0,
                'name_error' => '',
                'status_error' => '',
                'image_error' => '',
                'background_image_error' => '',
            ];
        }

        //loading the add projecttag view
        $this->view('projecttags/add', $data);
    }

    /**
     * update projecttag
     * @param integer $id
     */
    public function edit($id)
    {
        $id = (int) $id;
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // sanitize POST array
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

            $data = [
                'tag_id' => $id,
                'page_title' => 'الوسوم',
                'name' => trim($_POST['name']),
                'image' => '',
                'description' => trim($_POST['description']),
                'meta_keywords' => trim($_POST['meta_keywords']),
                'meta_description' => trim($_POST['meta_description']),
                'status' => trim($_POST['status']),
                'arrangement' => trim($_POST['arrangement']),
                'back_home' => trim($_POST['back_home']),
                'background_image' => '',
                'background_color' => trim($_POST['background_color']),
                'featured' => trim($_POST['featured']),
                'status_error' => '',
                'name_error' => '',
                'image_error' => '',
                'background_image_error' => '',

            ];

            // validate name
            if (empty($data['name'])) {
                $data['name_error'] = 'هذا الحقل مطلوب';
            }
            // validate image
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
            // validate background image
            if (!empty($_FILES['background_image'])) {
                $image = uploadImage('background_image', ADMINROOT . '/../media/images/', 5000000, true);
                if (empty($image['error'])) {
                    $data['background_image'] = $image['filename'];
                } else {
                    if (!isset($image['error']['nofile'])) {
                        $data['background_image_error'] = implode(',', $image['error']);
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
            if (empty($data['status_error']) && empty($data['image_error']) && empty($data['name_error']) && empty($data['background_image_error'])) {
                //validated
                if ($this->projectTagModel->updateProjectTag($data)) {
                    flash('projecttag_msg', 'تم التعديل بنجاح');
                    isset($_POST['save']) ? redirect('projecttags/edit/' . $id) : redirect('projecttags');
                } else {
                    flash('projecttag_msg', 'هناك خطأ ما حاول مرة اخري', 'alert alert-danger');
                }
            } else {
                //load the view with error
                $this->view('projecttags/edit', $data);
            }
        } else {
            // featch projecttag
            if (!$projecttag = $this->projectTagModel->getProjectTagById($id)) {
                flash('projecttag_msg', 'هناك خطأ ما هذه الصفحة غير موجوده او ربما اتبعت رابط خاطيء ', 'alert alert-danger');
                redirect('projecttags');
            }

            $data = [
                'page_title' => 'الوسوم',
                'tag_id' => $id,
                'name' => $projecttag->name,
                'description' => $projecttag->description,
                'image' => $projecttag->image,
                'meta_keywords' => $projecttag->meta_keywords,
                'meta_description' => $projecttag->meta_description,
                'status' => $projecttag->status,
                'arrangement' => $projecttag->arrangement,
                'back_home' => $projecttag->back_home,
                'background_image' => $projecttag->background_image,
                'background_color' => $projecttag->background_color,
                'featured' => $projecttag->featured,
                'status_error' => '',
                'name_error' => '',
                'image_error' => '',
                'background_image_error' => '',
            ];
            $this->view('projecttags/edit', $data);
        }
    }

    /**
     * showing projecttag details
     * @param integer $id
     */
    public function show($id)
    {
        if (!$projecttag = $this->projectTagModel->getProjectTagById($id)) {
            flash('projecttag_msg', 'هناك خطأ ما هذه الصفحة غير موجوده او ربما اتبعت رابط خاطيء ', 'alert alert-danger');
            redirect('projecttags');
        }
        $data = [
            'page_title' => 'الوسوم',
            'projecttag' => $projecttag,
        ];
        $this->view('projecttags/show', $data);
    }

    /**
     * delete record by id
     * @param integer $id
     */
    public function delete($id)
    {
        if ($row_num = $this->projectTagModel->deleteById([$id], 'tag_id')) {
            flash('projecttag_msg', 'تم حذف ' . $row_num . ' بنجاح');
        } else {
            flash('projecttag_msg', 'لم يتم الحذف', 'alert alert-danger');
        }
        redirect('projecttags');
    }

    /**
     * publish record by id
     * @param integer $id
     */
    public function publish($id)
    {
        if ($row_num = $this->projectTagModel->publishById([$id], 'tag_id')) {
            flash('projecttag_msg', 'تم نشر ' . $row_num . ' بنجاح');
        } else {
            flash('projecttag_msg', 'هناك خطأ ما يرجي المحاولة لاحقا', 'alert alert-danger');
        }
        redirect('projecttags');
    }

    /**
     * publish record by id
     * @param integer $id
     */
    public function unpublish($id)
    {
        if ($row_num = $this->projectTagModel->unpublishById([$id], 'tag_id')) {
            flash('projecttag_msg', 'تم ايقاف نشر ' . $row_num . ' بنجاح');
        } else {
            flash('projecttag_msg', 'هناك خطأ ما يرجي المحاولة لاحقا', 'alert alert-danger');
        }
        redirect('projecttags');
    }

}
