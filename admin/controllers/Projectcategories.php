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

class ProjectCategories extends ControllerAdmin
{

    private $projectcategoryModel;

    public function __construct()
    {
        $this->projectcategoryModel = $this->model('ProjectCategory');
    }

    /**
     * loading index view with latest projectcategories
     */
    public function index($current = '', $perpage = 50)
    {
        // get projectcategories
        $cond = 'WHERE status <> 2 ';
        $bind = [];

        //check user action if the form has submitted
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // sanitize POST array
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

            //handling Delete
            if (isset($_POST['delete'])) {
                if (isset($_POST['record'])) {
                    if ($row_num = $this->projectcategoryModel->deleteById($_POST['record'], 'category_id')) {
                        flash('projectcategory_msg', 'تم حذف ' . $row_num . ' بنجاح');
                    } else {
                        flash('projectcategory_msg', 'لم يتم الحذف', 'alert alert-danger');
                    }
                }

                redirect('projectcategories');
            }

            //handling Publish
            if (isset($_POST['publish'])) {
                if (isset($_POST['record'])) {
                    if ($row_num = $this->projectcategoryModel->publishById($_POST['record'], 'category_id')) {
                        flash('projectcategory_msg', 'تم نشر ' . $row_num . ' بنجاح');
                    } else {
                        flash('projectcategory_msg', 'هناك خطأ ما يرجي المحاولة لاحقا', 'alert alert-danger');
                    }
                }
                redirect('projectcategories');
            }

            //handling Unpublish
            if (isset($_POST['unpublish'])) {

                if (isset($_POST['record'])) {
                    if ($row_num = $this->projectcategoryModel->unpublishById($_POST['record'], 'category_id')) {
                        flash('projectcategory_msg', 'تم ايقاف نشر ' . $row_num . ' بنجاح');
                    } else {
                        flash('projectcategory_msg', 'هناك خطأ ما يرجي المحاولة لاحقا', 'alert alert-danger');
                    }
                }
                redirect('projectcategories');
            }
        }

        //handling search
        $searches = $this->projectcategoryModel->searchHandling(['name', 'description', 'status'], $current);
        $cond .= $searches['cond'];
        $bind = $searches['bind'];

        // get all records count after search and filtration
        $recordsCount = $this->projectcategoryModel->allProjectCategoriesCount($cond, $bind);
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
        //get all records for current projectcategory
        $projectcategories = $this->projectcategoryModel->getProjectCategories($cond, $bind, $limit, $bindLimit);

        $data = [
            'current' => $current,
            'perpage' => $perpage,
            'header' => '',
            'title' => 'الأقسام',
            'projectcategories' => $projectcategories,
            'recordsCount' => $recordsCount->count,
            'footer' => '',
        ];
        $this->view('projectcategories/index', $data);
    }

    /**
     * adding new projectcategory
     */
    public function add()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // sanitize POST array
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $data = [
                'page_title' => 'الأقسام',
                'name' => trim($_POST['name']),
                'alias' => preg_replace("([~!@#$%^&*()_+=`{}\[\]\|\\:;'<>,.\/? ])", "-", $_POST['name']),
                'description' => trim($_POST['description']),
                'categories' => $this->projectcategoryModel->getProjectCategories('WHERE status <> 2 ', '', '', '', 'category_id, name, level, parent_id'),
                'image' => '',
                'meta_keywords' => trim($_POST['meta_keywords']),
                'meta_description' => trim($_POST['meta_description']),
                'status' => '',
                'arrangement' => trim($_POST['arrangement']),
                'kafara' => trim($_POST['kafara']),
                'back_home' => trim($_POST['back_home']),
                'background_image' => '',
                'ads_banner' => '',
                'ads_url' => trim($_POST['ads_url']),
                'ads2_banner' => '',
                'ads2_url' => trim($_POST['ads2_url']),
                'section_bg' => trim($_POST['section_bg']),
                'background_color' => trim($_POST['background_color']),
                'featured' => trim($_POST['featured']),
                'parent_id_error' => '',
                'status_error' => '',
                'name_error' => '',
                'image_error' => '',
                'background_image_error' => '',
                'ads_banner_error' => '',
                'ads2_banner_error' => '',
            ];
            // validate name
            if (empty($data['name'])) {
                $data['name_error'] = 'هذا الحقل مطلوب';
            }
            // validate Subcategory
            if (empty($_POST['parent_id'])) {
                $data['parent_id_error'] = 'هذا الحقل مطلوب';
                $data['parent_id'] = explode(',', $_POST['parent_id'])[0];
                $data['level'] =  explode(',', $_POST['parent_id'])[1];
            } else {
                $data['parent_id'] = explode(',', $_POST['parent_id'])[0];
                $data['level'] =  explode(',', $_POST['parent_id'])[1];
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
            // validate ads_banner
            if (!empty($_FILES['ads_banner'])) {
                $image = uploadImage('ads_banner', ADMINROOT . '/../media/images/', 5000000, true);
                if (empty($image['error'])) {
                    $data['ads_banner'] = $image['filename'];
                } else {
                    if (!isset($image['error']['nofile'])) {
                        $data['ads_banner_error'] = implode(',', $image['error']);
                    }
                }
            }
            // validate ads_banner
            if (!empty($_FILES['ads2_banner'])) {
                $image = uploadImage('ads2_banner', ADMINROOT . '/../media/images/', 5000000, true);
                if (empty($image['error'])) {
                    $data['ads2_banner'] = $image['filename'];
                } else {
                    if (!isset($image['error']['nofile'])) {
                        $data['ads2_banner_error'] = implode(',', $image['error']);
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
            if (
                empty($data['status_error']) && empty($data['image_error'])  && empty($data['parent_id_error']) && empty($data['name_error'])
                && empty($data['background_image_error']) && empty($data['ads_banner_error']) && empty($data['ads2_banner_error'])
            ) {
                //validated
                if ($this->projectcategoryModel->addProjectCategory($data)) {
                    flash('projectcategory_msg', 'تم الحفظ بنجاح');
                    redirect('projectcategories');
                } else {
                    flash('projectcategory_msg', 'هناك خطأ ما حاول مرة اخري', 'alert alert-danger');
                }
            } else {
                //load the view with error
                $this->view('projectcategories/add', $data);
            }
        } else {
            $data = [
                'page_title' => 'اقسام المشروعات',
                'name' => '',
                'categories' => $this->projectcategoryModel->getProjectCategories('WHERE status <> 2 ', '', '', '', 'category_id, name, level, parent_id'),
                'parent_id' => '',
                'level' => '',
                'description' => '',
                'image' => '',
                'ads_url' => '',
                'ads_banner' => '',
                'ads2_url' => '',
                'ads2_banner' => '',
                'section_bg' => '',
                'meta_keywords' => '',
                'meta_description' => '',
                'status' => 0,
                'arrangement' => 0,
                'back_home' => 0,
                'background_image' => '',
                'ads_url' => '',
                'background_color' => '',
                'featured' => 0,
                'name_error' => '',
                'parent_id_error' => '',
                'status_error' => '',
                'image_error' => '',
                'background_image_error' => '',
                'ads_banner_error' => '',
                'ads2_banner_error' => '',
                'kafara' => '',
            ];
        }

        //loading the add projectcategory view
        $this->view('projectcategories/add', $data);
    }

    /**
     * update projectcategory
     * @param integer $id
     */
    public function edit($id, $onlyImg = false)
    {
        $id = (int) $id;
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // sanitize POST array
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $data = [
                'category_id' => $id,
                'page_title' => 'الأقسام',
                'name' => trim($_POST['name']),
                'image' => '',
                'categories' => $this->projectcategoryModel->getProjectCategories('WHERE status <> 2 ', '', '', '', 'category_id, name, level, parent_id'),
                'description' => trim($_POST['description']),
                'meta_keywords' => trim($_POST['meta_keywords']),
                'meta_description' => trim($_POST['meta_description']),
                'status' => trim($_POST['status']),
                'arrangement' => trim($_POST['arrangement']),
                'kafara' => trim($_POST['kafara']),
                'back_home' => trim($_POST['back_home']),
                'background_image' => '',
                'background_color' => trim($_POST['background_color']),
                'ads_banner' => '',
                'ads_url' => trim($_POST['ads_url']),
                'ads2_banner' => '',
                'ads2_url' => trim($_POST['ads2_url']),
                'section_bg' => trim($_POST['section_bg']),
                'featured' => trim($_POST['featured']),
                'status_error' => '',
                'name_error' => '',
                'parent_id_error' => '',
                'image_error' => '',
                'background_image_error' => '',
                'ads_banner_error' => '',
                'ads2_banner_error' => '',
            ];
            // validate name
            if (empty($data['name'])) {
                $data['name_error'] = 'هذا الحقل مطلوب';
            }
            // validate Subcategory
            if (empty($_POST['parent_id'])) {
                $data['parent_id_error'] = 'هذا الحقل مطلوب';
                $data['parent_id'] = explode(',', $_POST['parent_id'])[0];
                $data['level'] =  explode(',', $_POST['parent_id'])[1];
            } else {
                $data['parent_id'] = explode(',', $_POST['parent_id'])[0];
                $data['level'] =  explode(',', $_POST['parent_id'])[1];
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
            // validate ads_banner
            if (!empty($_FILES['ads_banner'])) {
                $image = uploadImage('ads_banner', ADMINROOT . '/../media/images/', 5000000, true);
                if (empty($image['error'])) {
                    $data['ads_banner'] = $image['filename'];
                } else {
                    if (!isset($image['error']['nofile'])) {
                        $data['ads_banner_error'] = implode(',', $image['error']);
                    }
                }
            }

            if (!empty($_FILES['ads2_banner'])) {
                $image = uploadImage('ads2_banner', ADMINROOT . '/../media/images/', 5000000, true);
                if (empty($image['error'])) {
                    $data['ads2_banner'] = $image['filename'];
                } else {
                    if (!isset($image['error']['nofile'])) {
                        $data['ads2_banner_error'] = implode(',', $image['error']);
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
            if (
                empty($data['status_error'])  && empty($data['parent_id_error']) && empty($data['image_error']) && empty($data['name_error'])
                && empty($data['background_image_error']) && empty($data['ads_banner_error']) && empty($data['ads2_banner_error'])
            ) {
                //validated
                if ($this->projectcategoryModel->updateProjectCategory($data)) {

                    if ($_POST['ads_banner_remove']) $this->projectcategoryModel->removeAdsBanner($id, 'ads_banner');
                    flash('projectcategory_msg', 'تم التعديل بنجاح');

                    if ($_POST['ads2_banner_remove']) $this->projectcategoryModel->removeAdsBanner($id, 'ads2_banner');
                    flash('projectcategory_msg', 'تم التعديل بنجاح');
                    isset($_POST['save']) ? redirect('projectcategories/edit/' . $id) : redirect('projectcategories');
                } else {
                    flash('projectcategory_msg', 'هناك خطأ ما حاول مرة اخري', 'alert alert-danger');
                }
            } else {
                //load the view with error
                $this->view('projectcategories/edit', $data);
            }
        } else {
            // featch projectcategory
            if (!$projectcategory = $this->projectcategoryModel->getProjectCategoryById($id)) {
                flash('projectcategory_msg', 'هناك خطأ ما هذه الصفحة غير موجوده او ربما اتبعت رابط خاطيء ', 'alert alert-danger');
                redirect('projectcategories');
            }

            $data = [
                'page_title' => 'الأقسام',
                'category_id' => $id,
                'name' => $projectcategory->name,
                'categories' => $this->projectcategoryModel->getProjectCategories('WHERE status <> 2 ', '', '', '', 'category_id, name, level, parent_id'),
                'parent_id' => $projectcategory->parent_id,
                'level' =>  $projectcategory->level,
                'description' => $projectcategory->description,
                'image' => $projectcategory->image,
                'meta_keywords' => $projectcategory->meta_keywords,
                'meta_description' => $projectcategory->meta_description,
                'status' => $projectcategory->status,
                'arrangement' => $projectcategory->arrangement,
                'back_home' => $projectcategory->back_home,
                'background_image' => $projectcategory->background_image,
                'ads_banner' => '',
                'ads_url' => $projectcategory->ads_url,
                'ads2_banner' => '',
                'ads2_url' => $projectcategory->ads2_url,
                'section_bg' => $projectcategory->section_bg,
                'background_color' => $projectcategory->background_color,
                'featured' => $projectcategory->featured,
                'status_error' => '',
                'parent_id_error' => '',
                'name_error' => '',
                'image_error' => '',
                'background_image_error' => '',
                'ads_banner_error' => '',
                'ads2_banner_error' => '',
                'kafara' =>  $projectcategory->kafara,
            ];
            $this->view('projectcategories/edit', $data);
        }
    }

    /**
     * showing projectcategory details
     * @param integer $id
     */
    public function show($id)
    {
        if (!$projectcategory = $this->projectcategoryModel->getProjectCategoryById($id)) {
            flash('projectcategory_msg', 'هناك خطأ ما هذه الصفحة غير موجوده او ربما اتبعت رابط خاطيء ', 'alert alert-danger');
            redirect('projectcategories');
        }
        $data = [
            'page_title' => 'الأقسام',
            'projectcategory' => $projectcategory,
        ];
        $this->view('projectcategories/show', $data);
    }

    /**
     * delete record by id
     * @param integer $id
     */
    public function delete($id)
    {
        if ($row_num = $this->projectcategoryModel->deleteById([$id], 'category_id')) {
            flash('projectcategory_msg', 'تم حذف ' . $row_num . ' بنجاح');
        } else {
            flash('projectcategory_msg', 'لم يتم الحذف', 'alert alert-danger');
        }
        redirect('projectcategories');
    }

    /**
     * publish record by id
     * @param integer $id
     */
    public function publish($id)
    {
        if ($row_num = $this->projectcategoryModel->publishById([$id], 'category_id')) {
            flash('projectcategory_msg', 'تم نشر ' . $row_num . ' بنجاح');
        } else {
            flash('projectcategory_msg', 'هناك خطأ ما يرجي المحاولة لاحقا', 'alert alert-danger');
        }
        redirect('projectcategories');
    }

    /**
     * publish record by id
     * @param integer $id
     */
    public function unpublish($id)
    {
        if ($row_num = $this->projectcategoryModel->unpublishById([$id], 'category_id')) {
            flash('projectcategory_msg', 'تم ايقاف نشر ' . $row_num . ' بنجاح');
        } else {
            flash('projectcategory_msg', 'هناك خطأ ما يرجي المحاولة لاحقا', 'alert alert-danger');
        }
        redirect('projectcategories');
    }
}
