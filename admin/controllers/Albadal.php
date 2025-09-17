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

class Albadal extends ControllerAdmin
{

    private $projectModel;

    public function __construct()
    {
        $this->projectModel = $this->model('Project');
    }

    /**
     * loading index view with latest projects
     */
    public function index($current = '', $perpage = 50)
    {
        // get projects
        $cond = 'WHERE projects.status <> 2 AND badal = 1 AND project_categories.category_id = projects.category_id ';
        $bind = [];

        //check user action if the form has submitted
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // sanitize POST array
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

            //handling Delete
            if (isset($_POST['delete'])) {
                if (isset($_POST['record'])) {
                    if ($row_num = $this->projectModel->deleteById($_POST['record'], 'project_id')) {
                        flash('project_msg', 'تم حذف ' . $row_num . ' بنجاح');
                    } else {
                        flash('project_msg', 'لم يتم الحذف', 'alert alert-danger');
                    }
                }

                redirect('albadal');
            }

            //handling Publish
            if (isset($_POST['publish'])) {
                if (isset($_POST['record'])) {
                    if ($row_num = $this->projectModel->publishById($_POST['record'], 'project_id')) {
                        flash('project_msg', 'تم نشر ' . $row_num . ' بنجاح');
                    } else {
                        flash('project_msg', 'هناك خطأ ما يرجي المحاولة لاحقا', 'alert alert-danger');
                    }
                }
                redirect('albadal');
            }
            //handling Unpublish
            if (isset($_POST['unpublish'])) {

                if (isset($_POST['record'])) {
                    if ($row_num = $this->projectModel->unpublishById($_POST['record'], 'project_id')) {
                        flash('project_msg', 'تم ايقاف نشر ' . $row_num . ' بنجاح');
                    } else {
                        flash('project_msg', 'هناك خطأ ما يرجي المحاولة لاحقا', 'alert alert-danger');
                    }
                }
                redirect('albadal');
            }
            //handling featured
            if (isset($_POST['featured'])) {
                if (isset($_POST['record'])) {
                    if ($row_num = $this->projectModel->featuredById($_POST['record'], 'project_id')) {
                        flash('project_msg', 'تم [جعلة كا مميز] ' . $row_num . ' بنجاح');
                    } else {
                        flash('project_msg', 'هناك خطأ ما يرجي المحاولة لاحقا', 'alert alert-danger');
                    }
                }
                redirect('albadal');
            }
            //handling Unfeatured
            if (isset($_POST['unfeatured'])) {

                if (isset($_POST['record'])) {
                    if ($row_num = $this->projectModel->unfeaturedById($_POST['record'], 'project_id')) {
                        flash('project_msg', 'تم ايقاف [جعلة كا مميز] ' . $row_num . ' بنجاح');
                    } else {
                        flash('project_msg', 'هناك خطأ ما يرجي المحاولة لاحقا', 'alert alert-danger');
                    }
                }
                redirect('albadal');
            }
        }
        //handling search
        $searches = $this->projectModel->searchHandling(['name', 'project_number', 'category_id', 'badal_type',  'status'], $current);
        // filter by deceased_id
        if (!empty($_POST['search']['deceased_id'])) {
            if ($_POST['search']['deceased_id'] == 1) {
                $cond .= ' AND projects.deceased_id IS NOT NULL ';
            }
            if ($_POST['search']['deceased_id'] == 2) {
                $cond .= ' AND projects.deceased_id IS NULL';
            }
            $_SESSION['search']['deceased_id'] = $_POST['search']['deceased_id'];
        }
        $cond .= $searches['cond'];
        $bind = $searches['bind'];
        // get all records count after search and filtration
        $recordsCount = $this->projectModel->allProjectsCount(",project_categories " . $cond, $bind);
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
        //get all records for current project
        $projects = $this->projectModel->getProjects($cond, $bind, $limit, $bindLimit);

        $data = [
            'current' => $current,
            'perpage' => $perpage,
            'header' => '',
            'title' => 'المشروعات',
            'projects' => $projects,
            'categories' => $this->projectModel->categoriesList(),
            'recordsCount' => $recordsCount->count,
            'footer' => '',
        ];
        $this->view('albadal/index', $data);
    }

    /**
     * adding new project
     */
    public function add()
    {
        $categories = $this->projectModel->categoriesList(' WHERE status <> 2 ');
        // if (!$categories = $this->projectModel->categoriesList(' WHERE status <> 2 ')) {
        //     flash('project_msg', 'برجاء انشاء قسم اولا حتي تتمكن من انشاء مشروع جديد ', 'alert alert-danger');
        //     redirect('albadal');
        // }
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $description = $this->projectModel->cleanHTML($_POST['description']);
            // sanitize POST array
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            // set post of tags to an array if its empty
            isset($_POST['tags']) ? null : $_POST['tags'] = [];
            $data = [
                'page_title' => ' مشروعات البدل',
                'name' => trim($_POST['name']),
                'project_number' => trim($_POST['project_number']),
                'beneficiary' => trim($_POST['beneficiary']),
                'alias' => preg_replace("([~!@#$%^&*()_+=`{}\[\]\|\\:;'<>,.\/? ])", "-", $_POST['name']),
                'description' => $description,
                'secondary_image' => '',
                'secondary_image' => '',
                'enable_cart' => 0,
                'gift' => 0,
                'gift_card_title' => '',
                'mobile_confirmation' => 0,
                'donation_type' => $_POST['donation_type'],
                'donation_type_list' => ['share' => 'طلب بالاسهم', 'fixed' => 'قيمة ثابته', 'open' => 'طلب مفتوح', 'unit' => 'فئات'],
                'payment_methods' => [],
                'paymentMethodsList' => $this->projectModel->paymentMethodsList(' WHERE status <> 2 '),
                'target_price' => 0,
                'target_unit' => 0,
                'unit_price' => 0,
                'fake_target' => 0,
                'min_price' => $_POST['min_price'],
                'hidden' => trim($_POST['hidden']),
                'thanks_message' => trim($_POST['thanks_message']),
                'sms_msg' => trim($_POST['sms_msg']),
                'advertising_code' => trim($_POST['advertising_code']),
                'header_code' => trim($_POST['header_code']),
                'whatsapp' => trim($_POST['whatsapp']),
                'mobile' => trim($_POST['mobile']),
                'end_date' => strtotime($_POST['end_date']),
                'start_date' => strtotime($_POST['start_date']),
                'category_id' => trim($_POST['category_id']),
                'categories' => $categories,
                'tags' => $_POST['tags'],
                'tagsList' => $this->projectModel->tagsList(),
                'meta_keywords' => trim($_POST['meta_keywords']),
                'meta_description' => trim($_POST['meta_description']),
                'finished' => $_POST['finished'],
                'status' => '',
                'arrangement' => trim($_POST['arrangement']),
                'kafara' => trim($_POST['kafara']),
                'badal' => 1,
                'badal_type' => @$_POST['badal_type'],
                'back_home' => trim($_POST['back_home']),
                'background_image' => '',
                'background_color' => trim($_POST['background_color']),
                'featured' => trim($_POST['featured']),
                'project_number_error' => '',
                'name_error' => '',
                'category_id_error' => '',
                'category_id_error' => '',
                'donation_type_error' => '',
                'payment_methods_error' => '',
                'secondary_image_error' => '',
                'image_error' => '',
                'background_image_error' => '',
                'status_error' => '',
                'badal_type_error' => '',
            ];
            // validate name
            !(empty($data['name'])) ?: $data['name_error'] = 'هذا الحقل مطلوب';
            //validate donation type
            if (empty($data['donation_type']['type'])) {
                $data['donation_type_error'] = 'برجاء اختيار نوع الطلب';
            } else {
                if (empty($data['donation_type']['value']) && $data['donation_type']['type'] != 'open') {
                    $data['donation_type_error'] = 'برجاء اختيار قيمة الطلب';
                }
            }
            //validate project number
            $this->projectModel->itemExistAPI($_POST['project_number']) ?: $data['project_number_error'] = 'هذا الرقم غير متوافق مع برنامج AX';
            //validate category
            !empty($data['category_id']) ?: $data['category_id_error'] = 'يجب اختيار القسم الخاص بالمشروع';
            //validate badal type
            $data['badal_type'] == "" ? $data['badal_type_error'] = 'يجب اختيار نوع البدل ' :'';

            // validate payment methods
            empty($_POST['payment_methods']) ? $data['payment_methods_error'] = 'يجب اختيار وسيلة دفع واحدة علي الأقل' : $data['payment_methods'] = $_POST['payment_methods'];

            // validate image
            if (!empty($_FILES['secondary_image'])) {
                $image = uploadImage('secondary_image', ADMINROOT . '/../media/images/', 5000000, true);
                if (empty($image['error'])) {
                    $data['secondary_image'] = $image['filename'];
                } else {
                    if (!isset($image['error']['nofile'])) {
                        $data['secondary_image_error'] = implode(',', $image['error']);
                    }
                }
            }
            
          // validate image
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

            // validate start and end date
            if ($data['end_date'] < 0 || $data['end_date'] > 2147483648) $data['end_date'] = 0;
            if ($data['start_date'] < 0 || $data['start_date'] > 2147483648) $data['start_date'] = 0;
            
            // validate status
            if (isset($_POST['status'])) {
                $data['status'] = trim($_POST['status']);
            }
            
            if ($data['status'] == '') {
                $data['status_error'] = 'من فضلك اختار حالة النشر';
            }
            //make sure there is no errors
            if (
                empty($data['status_error']) && empty($data['name_error']) && empty($data['background_image_error']) && empty($data['donation_type_error'])
                && empty($data['category_id_error']) && empty($data['payment_methods_error']) && empty($data['secondary_image_error']) && empty($data['project_number_error'])
                && empty($data['badal_type_error'])
            ) {
                //validated
                if ($this->projectModel->addProject($data)) {
                    $this->projectModel->insertTags($data['tags'], $this->projectModel->lastId());

                    flash('project_msg', 'تم الحفظ بنجاح');
                    redirect('albadal');
                } else {
                    flash('project_msg', 'هناك خطأ ما حاول مرة اخري', 'alert alert-danger');
                }
            } else {
                //load the view with error
                $this->view('albadal/add', $data);
            }
        } else {

            $data = [
                'page_title' => ' مشروعات البدل',
                'project_number' => '',
                'beneficiary' => '',
                'name' => '',
                'description' => '',
                'image' => '',
                'secondary_image' => '',
                'enable_cart' => '',
                'gift' => '',
                'gift_card_title' => '',
                'mobile_confirmation' => '',
                'donation_type' => ['type' => ''],
                'donation_type_list' => ['share' => 'طلب بالاسهم', 'fixed' => 'قيمة ثابته', 'open' => 'طلب مفتوح', 'unit' => 'فئات'],
                'payment_methods' => array(),
                'paymentMethodsList' => $this->projectModel->paymentMethodsList(' WHERE status <> 2 '),
                'target_price' => '',
                'target_unit' => '',
                'unit_price' => '',
                'fake_target' => 0,
                'min_price' => '',
                'hidden' => '',
                'sms_msg' => '',
                'thanks_message' => '',
                'advertising_code' => '',
                'header_code' => '',
                'whatsapp' => '',
                'mobile' => '',
                'end_date' => "",
                'start_date' => "",
                'category_id' => '',
                'categories' => $categories,
                'tags' => [],
                'tagsList' => $this->projectModel->tagsList(),
                'meta_keywords' => '',
                'meta_description' => '',
                'status' => 1,
                'finished' => 1,
                'arrangement' => 0,
                'kafara' => '',
                'back_home' => 0,
                'background_image' => '',
                'background_color' => '',
                'featured' => 0,
                'badal_type' => '',
                'donation_type_error' => '',
                'category_id_error' => '',
                'name_error' => '',
                'project_number_error' => '',
                'status_error' => '',
                'secondary_image_error' => '',
                'image_error' => '',
                'payment_methods_error' => '',
                'background_image_error' => '',
                'badal_type_error' => '',
            ];
        }

        //loading the add project view
        $this->view('albadal/add', $data);
    }

    /**
     * update project
     * @param integer $id
     */
    public function edit($id)
    {
        $categories = $this->projectModel->categoriesList(' WHERE status <> 2 ');
        // if (!$categories = $this->projectModel->categoriesList(' WHERE status <> 2 ')) {
        //     flash('project_msg', 'برجاء انشاء قسم اولا حتي تتمكن من انشاء مشروع جديد ', 'alert alert-danger');
        //     redirect('albadal');
        // }
        $id = (int) $id;
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // sanitize POST array
            $description = $this->projectModel->cleanHTML($_POST['description']);
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            isset($_POST['tags']) ? '' : $_POST['tags'] = [];
            $data = [
                'project_id' => $id,
                'page_title' => ' المشروعات',
                'name' => trim($_POST['name']),
                'project_number' => trim($_POST['project_number']),
                'beneficiary' => trim($_POST['beneficiary']),
                'alias' => preg_replace("([~!@#$%^&*()_+=`{}\[\]\|\\:;'<>,.\/? ])", "-", $_POST['name']),
                'description' => $description,
                'image' => '',
                'secondary_image' => '',
                'enable_cart' => 0,
                'gift' => 0,
                'gift_card_title' => '',
                'mobile_confirmation' => 0,
                'donation_type' => $_POST['donation_type'],
                'donation_type_list' => ['share' => 'طلب بالاسهم', 'fixed' => 'قيمة ثابته', 'open' => 'طلب مفتوح', 'unit' => 'فئات'],
                'payment_methods' => [],
                'paymentMethodsList' => $this->projectModel->paymentMethodsList(' WHERE status <> 2 '),
                'target_price' => 0,
                'target_unit' => 0,
                'unit_price' => (int) 0,
                'fake_target' => 0,
                'min_price' => $_POST['min_price'],
                'hidden' => trim($_POST['hidden']),
                'sms_msg' => trim($_POST['sms_msg']),
                'thanks_message' => trim($_POST['thanks_message']),
                'advertising_code' => trim($_POST['advertising_code']),
                'header_code' => trim($_POST['header_code']),
                'whatsapp' => trim($_POST['whatsapp']),
                'mobile' => trim($_POST['mobile']),
                'end_date' => strtotime($_POST['end_date']),
                'start_date' => strtotime($_POST['start_date']),
                'category_id' => trim($_POST['category_id']),
                'categories' => $categories,
                // 'tags' => $this->projectModel->tagsListByProject($id),
                'tagsList' => $this->projectModel->tagsList(),
                'tags' => $_POST['tags'],
                'meta_keywords' => trim($_POST['meta_keywords']),
                'meta_description' => trim($_POST['meta_description']),
                'finished' =>  $_POST['finished'],
                'status' => '',
                'arrangement' => trim($_POST['arrangement']),
                'kafara' => trim($_POST['kafara']),
                'badal' => 1,
                'badal_type' => trim($_POST['badal_type']),
                'back_home' => trim($_POST['back_home']),
                'background_image' => '',
                'background_color' => trim($_POST['background_color']),
                'featured' => trim($_POST['featured']),
                'name_error' => '',
                'category_id_error' => '',
                'project_number_error' => '',
                'donation_type_error' => '',
                'payment_methods_error' => '',
                'secondary_image_error' => '',
                'image_error' => '',
                'background_image_error' => '',
                'status_error' => '',
                'badal_type_error' => '',
            ];
            // validate name
            !(empty($data['name'])) ?: $data['name_error'] = 'هذا الحقل مطلوب';
            //validate donation type
            if (empty($data['donation_type']['type'])) {
                $data['donation_type_error'] = 'برجاء اختيار نوع الطلب';
            } else {
                if (empty($data['donation_type']['value']) && $data['donation_type']['type'] != 'open') {
                    $data['donation_type_error'] = 'برجاء اختيار قيمة الطلب';
                }
            }
            //validate project number
            $this->projectModel->itemExistAPI($_POST['project_number']) ?: $data['project_number_error'] = 'هذا الرقم غير متوافق مع برنامج AX';
            //validate category
            !empty($data['category_id']) ?: $data['category_id_error'] = 'يجب اختيار القسم الخاص بالمشروع';

            //validate badal type
            $data['badal_type'] == "" ? $data['badal_type_error'] = 'يجب اختيار نوع البدل ' :'';

            // validate payment methods
            empty($_POST['payment_methods']) ? $data['payment_methods_error'] = 'يجب اختيار وسيلة دفع واحدة علي الأقل' : $data['payment_methods'] = $_POST['payment_methods'];

            // // validate secondary image 
            // if ($_FILES['secondary_image']['error'] != 4) { // no file has uploaded
            //     $image = $this->projectModel->validateImage('secondary_image');
            //     ($image[0]) ? $data['secondary_image'] = $image[1] : $data['secondary_image_error'] = $image[1];
            // }
            
            // validate image
            if (!empty($_FILES['secondary_image'])) {
                $image = uploadImage('secondary_image', ADMINROOT . '/../media/images/', 5000000, true);
                if (empty($image['error'])) {
                    $data['secondary_image'] = $image['filename'];
                } else {
                    if (!isset($image['error']['nofile'])) {
                        $data['secondary_image_error'] = implode(',', $image['error']);
                    }
                }
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
            
            // validate image
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
            
            // validate start and end date
            if ($data['end_date'] < 0 || $data['end_date'] > 2147483648) $data['end_date'] = 0;
            if ($data['start_date'] < 0 || $data['start_date'] > 2147483648) $data['start_date'] = 0;
            // validate background image
            // if ($_FILES['background_image']['error'] != 4) { // no file has uploaded
            //     $image = $this->projectModel->validateImage('background_image');
            //     ($image[0]) ? $data['background_image'] = $image[1] : $data['background_image_error'] = $image[1];
            // }
            // validate status
            if (isset($_POST['status'])) {
                $data['status'] = trim($_POST['status']);
            }
            if ($data['status'] == '') {
                $data['status_error'] = 'من فضلك اختار حالة النشر';
            }

            //make sue there is no errors
            if (
                empty($data['status_error']) && empty($data['name_error']) && empty($data['background_image_error']) && empty($data['donation_type_error'])
                && empty($data['category_id_error']) && empty($data['payment_methods_error']) && empty($data['secondary_image_error']) && empty($data['project_number_error']
                && empty($data['badal_type_error']))
            ) {
                //validated
                if (isset($_POST['save_new'])) {
                    // $data['secondary_image'] = $_POST['s_image'];
                    if ($this->projectModel->addProject($data)) {
                        $this->projectModel->insertTags($data['tags'], $this->projectModel->lastId());
                        flash('project_msg', 'تم الحفظ بنجاح');
                        redirect('albadal');
                    } else {
                        flash('project_msg', 'هناك خطأ ما حاول مرة اخري', 'alert alert-danger');
                    }
                } else {
                    if ($this->projectModel->updateProject($data)) {
                        //clear previous tags before inserting new values
                        $this->projectModel->deleteTagsByProjectId($id);
                        // insert new tags
                        $this->projectModel->insertTags($data['tags'], $id);
                        flash('project_msg', 'تم التعديل بنجاح');
                        isset($_POST['save']) ? redirect('albadal/edit/' . $id) : redirect('albadal');
                    } else {
                        flash('project_msg', 'هناك خطأ ما حاول مرة اخري', 'alert alert-danger');
                    }
                }
            } else {
                //load the view with error
                $this->view('albadal/edit', $data);
            }
        } else {
            // featch project
            if (!$project = $this->projectModel->getProjectById($id)) {
                flash('project_msg', 'هناك خطأ ما هذه الصفحة غير موجوده او ربما اتبعت رابط خاطيء ', 'alert alert-danger');
                redirect('albadal');
            }

            $data = [
                'page_title' => 'المشروعات',
                'project_id' => $id,
                'name' => $project->name,
                'project_number' => $project->project_number,
                'beneficiary' => $project->beneficiary,
                'description' => $project->description,
                'image' => $project->image,
                'meta_keywords' => $project->meta_keywords,
                'meta_description' => $project->meta_description,
                'finished' => $project->finished,
                'status' => $project->status,
                'arrangement' => $project->arrangement,
                'kafara' => $project->kafara,
                'back_home' => $project->back_home,
                'background_image' => $project->background_image,
                'image' => $project->image,
                'background_color' => $project->background_color,
                'featured' => $project->featured,
                'secondary_image' => $project->secondary_image,
                'enable_cart' => 0,
                'gift' => 0,
                'gift_card_title' => '',
                'mobile_confirmation' => 0,
                'donation_type' => json_decode($project->donation_type, true),
                'donation_type_list' => ['share' => 'طلب بالاسهم', 'fixed' => 'قيمة ثابته', 'open' => 'طلب مفتوح', 'unit' => 'فئات'],
                'payment_methods' => json_decode($project->payment_methods, true),
                'paymentMethodsList' => $this->projectModel->paymentMethodsList(' WHERE status <> 2 '),
                'target_price' => 0,
                'target_unit' => 0,
                'unit_price' => 0,
                'fake_target' => 0,
                'min_price' => $project->min_price,
                'hidden' => $project->hidden,
                'sms_msg' => $project->sms_msg,
                'thanks_message' => $project->thanks_message,
                'advertising_code' => $project->advertising_code,
                'header_code' => $project->header_code,
                'whatsapp' => $project->whatsapp,
                'mobile' => $project->mobile,
                'badal_type' => $project->badal_type??"",
                'end_date' => $project->end_date,
                'start_date' => $project->start_date,
                'category_id' => $project->category_id,
                'categories' => $categories,
                'tags' => $this->projectModel->tagsListByProject($id),
                'tagsList' => $this->projectModel->tagsList(),
                'donation_type_error' => '',
                'category_id_error' => '',
                'name_error' => '',
                'status_error' => '',
                'image_error' => '',
                'project_number_error' => '',
                'secondary_image_error' => '',
                'payment_methods_error' => '',
                'background_image_error' => '',
                'badal_type_error' => '',
            ];
            $this->view('albadal/edit', $data);
        }
    }

    /**
     * showing project details
     * @param integer $id
     */
    public function show($id)
    {
        if (!$project = $this->projectModel->getProjectById($id)) {
            flash('project_msg', 'هناك خطأ ما هذه الصفحة غير موجوده او ربما اتبعت رابط خاطيء ', 'alert alert-danger');
            redirect('albadal');
        }
        $data = [
            'page_title' => 'المشروعات',
            'donation_type_list' => ['share' => 'طلب بالاسهم', 'fixed' => 'قيمة ثابته', 'open' => 'طلب مفتوح', 'unit' => 'فئات'],
            'project' => $project,
            'paymentMethodsList' => $this->projectModel->paymentMethodsList(' WHERE payment_id IN (' . implode(',', json_decode($project->payment_methods, true)) . ') '),

        ];
        $this->view('albadal/show', $data);
    }

    /**
     * delete record by id
     * @param integer $id
     */
    public function delete($id)
    {
        if ($row_num = $this->projectModel->deleteById([$id], 'project_id')) {
            flash('project_msg', 'تم حذف ' . $row_num . ' بنجاح');
        } else {
            flash('project_msg', 'لم يتم الحذف', 'alert alert-danger');
        }
        redirect('albadal');
    }

    /**
     * publish record by id
     * @param integer $id
     */
    public function publish($id)
    {
        if ($row_num = $this->projectModel->publishById([$id], 'project_id')) {
            flash('project_msg', 'تم نشر ' . $row_num . ' بنجاح');
        } else {
            flash('project_msg', 'هناك خطأ ما يرجي المحاولة لاحقا', 'alert alert-danger');
        }
        redirect('albadal');
    }

    /**
     * publish record by id
     * @param integer $id
     */
    public function unpublish($id)
    {
        if ($row_num = $this->projectModel->unpublishById([$id], 'project_id')) {
            flash('project_msg', 'تم ايقاف نشر ' . $row_num . ' بنجاح');
        } else {
            flash('project_msg', 'هناك خطأ ما يرجي المحاولة لاحقا', 'alert alert-danger');
        }
        redirect('albadal');
    }

    /**
     * featured record by id
     * @param integer $id
     */
    public function featured($id)
    {
        if ($row_num = $this->projectModel->featuredById([$id], 'project_id')) {
            flash('project_msg', 'تم جعله كا مميز ' . $row_num . ' بنجاح');
        } else {
            flash('project_msg', 'هناك خطأ ما يرجي المحاولة لاحقا', 'alert alert-danger');
        }
        redirect('albadal');
    }

    /**
     * unfeatured record by id
     * @param integer $id
     */
    public function unfeatured($id)
    {
        if ($row_num = $this->projectModel->unfeaturedById([$id], 'project_id')) {
            flash('project_msg', 'تم ايقاف جعله كا مميز ' . $row_num . ' بنجاح');
        } else {
            flash('project_msg', 'هناك خطأ ما يرجي المحاولة لاحقا', 'alert alert-danger');
        }
        redirect('albadal');
    }

    public function arrangement()
    {
        $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        if (isset($_POST['arrangement']) && isset($_POST['project_id']) && $row_num = $this->projectModel->arrangeProject($_POST)) {
            $data = [
                'msg' => '<div class="alert alert-success text-center"> تم الترتيب بنجاح </div>',
                'status' => 'success',
                'arrangement' => $_POST['arrangement'],
                'project_id' => $_POST['project_id']
            ];
        } else {
            $data = [
                'msg' => '<div class="alert alert-danger text-danger"> حدث خطأ ما من فضلك حاول مرة اخري </div>',
                'status' => 'error',

            ];
        }
        echo json_encode($data);
    }
}
