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

class Appsections extends ControllerAdmin
{

    private $AppSectionModel;

    public function __construct()
    {
        $this->AppSectionModel = $this->model('AppSection');
    }

    /**
     * loading index view with latest AppSections
     */
    public function index($current = '', $perpage = 50)
    {
        // get AppSections
        $cond = 'WHERE status <> 2 ';
        $bind = [];

        //check user action if the form has submitted
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // sanitize POST array
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

            //handling Delete
            if (isset($_POST['delete'])) {
                if (isset($_POST['record'])) {
                    if ($row_num = $this->AppSectionModel->deleteById($_POST['record'], 'section_id')) {
                        flash('appsection_msg', 'تم حذف ' . $row_num . ' بنجاح');
                    } else {
                        flash('appsection_msg', 'لم يتم الحذف', 'alert alert-danger');
                    }
                }

                redirect('appsections');
            }

            //handling Publish
            if (isset($_POST['publish'])) {
                if (isset($_POST['record'])) {
                    if ($row_num = $this->AppSectionModel->publishById($_POST['record'], 'section_id')) {
                        flash('appsection_msg', 'تم نشر ' . $row_num . ' بنجاح');
                    } else {
                        flash('appsection_msg', 'هناك خطأ ما يرجي المحاولة لاحقا', 'alert alert-danger');
                    }
                }
                redirect('appsections');
            }

            //handling Unpublish
            if (isset($_POST['unpublish'])) {

                if (isset($_POST['record'])) {
                    if ($row_num = $this->AppSectionModel->unpublishById($_POST['record'], 'section_id')) {
                        flash('appsection_msg', 'تم ايقاف نشر ' . $row_num . ' بنجاح');
                    } else {
                        flash('appsection_msg', 'هناك خطأ ما يرجي المحاولة لاحقا', 'alert alert-danger');
                    }
                }
                redirect('appsections');
            }
        }

        //handling search
        $searches = $this->AppSectionModel->searchHandling(['name', 'description', 'status'], $current);
        $cond .= $searches['cond'];
        $bind = $searches['bind'];

        // get all records count after search and filtration
        $recordsCount = $this->AppSectionModel->allAppSectionsCount($cond, $bind);
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
        //get all records for current AppSection
        $AppSections = $this->AppSectionModel->getAppSections($cond, $bind, $limit, $bindLimit);

        $data = [
            'current' => $current,
            'perpage' => $perpage,
            'header' => '',
            'title' => 'الأقسام',
            'AppSections' => $AppSections,
            'recordsCount' => $recordsCount->count,
            'footer' => '',
        ];
        $this->view('appsections/index', $data);
    }

    /**
     * adding new AppSection
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
                'image' => '',
                'status' => '',
                'arrangement' => trim($_POST['arrangement']),
                'featured' => trim($_POST['featured']),
                'status_error' => '',
                'name_error' => '',
                'image_error' => '',
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
            // validate status
            if (isset($_POST['status'])) {
                $data['status'] = trim($_POST['status']);
            }
            if ($data['status'] == '') {
                $data['status_error'] = 'من فضلك اختار حالة النشر';
            }
            //             make sure there is no errors
            if (
                empty($data['status_error']) && empty($data['image_error']) && empty($data['name_error'])
            ) {
                //validated
                if ($this->AppSectionModel->addAppSection($data)) {
                    flash('appsection_msg', 'تم الحفظ بنجاح');
                    redirect('appsections');
                } else {
                    flash('appsection_msg', 'هناك خطأ ما حاول مرة اخري', 'alert alert-danger');
                }
            } else {
                //load the view with error
                $this->view('appsections/add', $data);
            }
        } else {
            $data = [
                'page_title' => 'اقسام المشروعات',
                'name' => '',
                'level' => '',
                'description' => '',
                'image' => '',
                'status' => 0,
                'arrangement' => 0,
                'featured' => 0,
                'name_error' => '',
                'status_error' => '',
                'image_error' => '',
            ];
        }

        //loading the add AppSection view
        $this->view('appsections/add', $data);
    }

    /**
     * update AppSection
     * @param integer $id
     */
    public function edit($id, $onlyImg = false)
    {
        $id = (int) $id;
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // sanitize POST array
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $data = [
                'section_id' => $id,
                'page_title' => 'الأقسام',
                'name' => trim($_POST['name']),
                'image' => '',
                'description' => trim($_POST['description']),
                'status' => trim($_POST['status']),
                'arrangement' => trim($_POST['arrangement']),
                'featured' => trim($_POST['featured']),
                'status_error' => '',
                'name_error' => '',
                'image_error' => '',
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
            // validate status
            if (isset($_POST['status'])) {
                $data['status'] = trim($_POST['status']);
            }
            if ($data['status'] == '') {
                $data['status_error'] = 'من فضلك اختار حالة النشر';
            }
            // make sure there is no errors
            if (
                empty($data['status_error']) && empty($data['image_error']) && empty($data['name_error'])
            ) {
                //validated
                if ($this->AppSectionModel->updateAppSection($data)) {

                    if ($_POST['ads_banner_remove']) $this->AppSectionModel->removeAdsBanner($id, 'ads_banner');
                    flash('appsection_msg', 'تم التعديل بنجاح');
                    isset($_POST['save']) ? redirect('appsections/edit/' . $id) : redirect('appsections');
                } else {
                    flash('appsection_msg', 'هناك خطأ ما حاول مرة اخري', 'alert alert-danger');
                }
            } else {
                //load the view with error
                $this->view('appsections/edit', $data);
            }
        } else {
            // featch AppSection
            if (!$AppSection = $this->AppSectionModel->getAppSectionById($id)) {
                flash('appsection_msg', 'هناك خطأ ما هذه الصفحة غير موجوده او ربما اتبعت رابط خاطيء ', 'alert alert-danger');
                redirect('appsections');
            }

            $data = [
                'page_title' => 'الأقسام',
                'section_id' => $id,
                'name' => $AppSection->name,
                'arrangement' =>  $AppSection->arrangement,
                'description' => $AppSection->description,
                'image' => $AppSection->image,
                'status' => $AppSection->status,
                'featured' => $AppSection->featured,
                'status_error' => '',
                'name_error' => '',
                'image_error' => '',
            ];
            $this->view('appsections/edit', $data);
        }
    }

    /**
     * showing AppSection details
     * @param integer $id
     */
    public function show($id)
    {
        if (!$AppSection = $this->AppSectionModel->getAppSectionById($id)) {
            flash('appsection_msg', 'هناك خطأ ما هذه الصفحة غير موجوده او ربما اتبعت رابط خاطيء ', 'alert alert-danger');
            redirect('appsections');
        }
        $data = [
            'page_title' => 'الأقسام',
            'AppSection' => $AppSection,
        ];
        $this->view('appsections/show', $data);
    }

    /**
     * delete record by id
     * @param integer $id
     */
    public function delete($id)
    {
        if ($row_num = $this->AppSectionModel->deleteById([$id], 'section_id')) {
            flash('appsection_msg', 'تم حذف ' . $row_num . ' بنجاح');
        } else {
            flash('appsection_msg', 'لم يتم الحذف', 'alert alert-danger');
        }
        redirect('appsections');
    }

    /**
     * publish record by id
     * @param integer $id
     */
    public function publish($id)
    {
        if ($row_num = $this->AppSectionModel->publishById([$id], 'section_id')) {
            flash('appsection_msg', 'تم نشر ' . $row_num . ' بنجاح');
        } else {
            flash('appsection_msg', 'هناك خطأ ما يرجي المحاولة لاحقا', 'alert alert-danger');
        }
        redirect('appsections');
    }

    /**
     * publish record by id
     * @param integer $id
     */
    public function unpublish($id)
    {
        if ($row_num = $this->AppSectionModel->unpublishById([$id], 'section_id')) {
            flash('appsection_msg', 'تم ايقاف نشر ' . $row_num . ' بنجاح');
        } else {
            flash('appsection_msg', 'هناك خطأ ما يرجي المحاولة لاحقا', 'alert alert-danger');
        }
        redirect('appsections');
    }
}
