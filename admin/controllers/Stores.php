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

class Stores extends ControllerAdmin
{

    private $storeModel;

    public function __construct()
    {
        $this->storeModel = $this->model('Store');
    }

    /**
     * loading index view with latest stores
     */
    public function index($current = '', $perpage = 50)
    {
        // get stores
        $cond = 'WHERE status <> 2 ';
        $bind = [];

        //check user action if the form has submitted
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // sanitize POST array
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            //handling Delete
            if (isset($_POST['delete'])) {
                if (isset($_POST['record'])) {
                    if ($row_num = $this->storeModel->deleteById($_POST['record'], 'store_id')) {
                        flash('store_msg', 'تم حذف ' . $row_num . ' بنجاح');
                    } else {
                        flash('store_msg', 'لم يتم الحذف', 'alert alert-danger');
                    }
                }

                redirect('stores');
            }
            //handling Publish
            if (isset($_POST['publish'])) {
                if (isset($_POST['record'])) {
                    if ($row_num = $this->storeModel->publishById($_POST['record'], 'store_id')) {
                        flash('store_msg', 'تم نشر ' . $row_num . ' بنجاح');
                    } else {
                        flash('store_msg', 'هناك خطأ ما يرجي المحاولة لاحقا', 'alert alert-danger');
                    }
                }
                redirect('stores');
            }

            //handling Unpublish
            if (isset($_POST['unpublish'])) {

                if (isset($_POST['record'])) {
                    if ($row_num = $this->storeModel->unpublishById($_POST['record'], 'store_id')) {
                        flash('store_msg', 'تم ايقاف نشر ' . $row_num . ' بنجاح');
                    } else {
                        flash('store_msg', 'هناك خطأ ما يرجي المحاولة لاحقا', 'alert alert-danger');
                    }
                }
                redirect('stores');
            }
        }

        //handling search
        $searches = $this->storeModel->searchHandling(['name', 'employee_name', 'status'], $current);
        $cond .= $searches['cond'];
        $bind = $searches['bind'];

        // get all records count after search and filtration
        $recordsCount = $this->storeModel->allStoresCount($cond, $bind);
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
        //get all records for current store
        $stores = $this->storeModel->getStores($cond, $bind, $limit, $bindLimit);

        $data = [
            'current' => $current,
            'perpage' => $perpage,
            'header' => '',
            'title' => 'المتاجر الفرعية',
            'stores' => $stores,
            'recordsCount' => $recordsCount->count,
            'footer' => '',
        ];
        $this->view('stores/index', $data);
    }

    /**
     * adding new store
     */
    public function add()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // sanitize POST array
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

            $data = [
                'page_title' => 'المتاجر الفرعية',
                'name' => trim($_POST['name']),
                'alias' => trim($_POST['alias']),
                'user' => preg_replace("([~!@#$%^&*()_+=`{}\[\]\|\\:;'<>,.\/? ])", "-", $_POST['user']),
                'password' => trim($_POST['password']),
                'email' => trim($_POST['email']),
                'employee_name' => trim($_POST['employee_name']),
                'employee_image' => '',
                'employee_number' => trim($_POST['employee_number']),
                'department' => trim($_POST['department']),
                'ax_store_number' => trim($_POST['ax_store_number']),
                'job' => trim($_POST['job']),
                'location' => trim($_POST['location']),
                'mobile' => trim($_POST['mobile']),
                'whatsapp' => trim($_POST['whatsapp']),
                'details' => trim($_POST['details']),
                'meta_keywords' => trim($_POST['meta_keywords']),
                'meta_description' => trim($_POST['meta_description']),
                'status' => '',
                'background_image' => '',
                'background_color' => trim($_POST['background_color']),
                'name_error' => '',
                'alias_error' => '',
                'user_error' => '',
                'password_error' => '',
                'employee_name_error' => '',
                'employee_image_error' => '',
                'employee_number_error' => '',
                'status_error' => '',
                'background_image_error' => '',
            ];
            // validate name
            (!empty($data['name'])) ?: $data['name_error'] = 'هذا الحقل مطلوب';
            // validate alias
            (!empty($data['alias'])) ?: $data['alias_error'] = 'هذا الحقل مطلوب';
            //check alias dublication
            if (empty($data['alias_error'])) {
                $this->storeModel->aliasExist($data['alias']) ? '' : $data['alias_error'] = 'هذا الاسم موجود من قبل';
            }
            // validate user
            (!empty($data['user'])) ?: $data['user_error'] = 'هذا الحقل مطلوب';
            // validate password
            (!empty($data['password'])) ?: $data['password_error'] = 'هذا الحقل مطلوب';
            // validate employee_name
            (!empty($data['employee_name'])) ?: $data['employee_name_error'] = 'هذا الحقل مطلوب';
            // validate employee_number
            (!empty($data['employee_number'])) ?: $data['employee_number_error'] = 'هذا الحقل مطلوب';
            // validate image
            $image = $this->storeModel->validateImage('employee_image');
            ($image[0]) ? $data['employee_image'] = $image[1] : $data['employee_image_error'] = $image[1];
            // validate background image
            $image = $this->storeModel->validateImage('background_image');
            ($image[0]) ? $data['background_image'] = $image[1] : $data['background_image_error'] = $image[1];
            // validate status
            if (isset($_POST['status'])) {
                $data['status'] = trim($_POST['status']);
            }
            if ($data['status'] == '') {
                $data['status_error'] = 'من فضلك اختار حالة النشر';
            }
            // make sure there is no errors
            if (
                empty($data['name_error']) && empty($data['alias_error']) && empty($data['user_error']) && empty($data['password_error']) && empty($data['employee_name_error'])
                && empty($data['employee_image_error']) && empty($data['employee_number_error']) && empty($data['status_error']) && empty($data['background_image_error'])
            ) {
                // validated
                if ($this->storeModel->addStore($data)) {
                    flash('store_msg', 'تم الحفظ بنجاح');
                    redirect('stores');
                } else {
                    flash('store_msg', 'هناك خطأ ما حاول مرة اخري', 'alert alert-danger');
                }
            } else {
                //load the view with error
                $this->view('stores/add', $data);
            }
        } else {
            $data = [
                'page_title' => 'المتاجر الفرعية',
                'alias' => '',
                'name' => '',
                'user' => '',
                'password' => '',
                'email' => '',
                'employee_name' => '',
                'employee_image' => '',
                'employee_number' => '',
                'department' => '',
                'ax_store_number' => '',
                'job' => '',
                'location' => '',
                'mobile' => '',
                'whatsapp' => '',
                'details' => '',
                'background_color' => '',
                'background_image' => '',
                'meta_keywords' => '',
                'meta_description' => '',
                'status' => 0,
                'name_error' => '',
                'alias_error' => '',
                'user_error' => '',
                'password_error' => '',
                'employee_name_error' => '',
                'employee_image_error' => '',
                'employee_number_error' => '',
                'status_error' => '',
                'image_error' => '',
                'background_image_error' => '',
            ];
        }

        //loading the add store view
        $this->view('stores/add', $data);
    }

    /**
     * update store
     * @param integer $id
     */
    public function edit($id)
    {
        $id = (int) $id;
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // sanitize POST array
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

            $data = [
                'page_title' => 'المتاجر الفرعية',
                'store_id' => $id,
                'name' => trim($_POST['name']),
                'alias' => trim($_POST['alias']),
                'user' => preg_replace("([~!@#$%^&*()_+=`{}\[\]\|\\:;'<>,.\/? ])", "-", $_POST['user']),
                'password' => trim($_POST['password']),
                'email' => trim($_POST['email']),
                'employee_name' => trim($_POST['employee_name']),
                'employee_image' => '',
                'employee_number' => trim($_POST['employee_number']),
                'department' => trim($_POST['department']),
                'ax_store_number' => trim($_POST['ax_store_number']),
                'job' => trim($_POST['job']),
                'location' => trim($_POST['location']),
                'mobile' => trim($_POST['mobile']),
                'whatsapp' => trim($_POST['whatsapp']),
                'details' => trim($_POST['details']),
                'meta_keywords' => trim($_POST['meta_keywords']),
                'meta_description' => trim($_POST['meta_description']),
                'status' => '',
                'background_image' => '',
                'background_color' => trim($_POST['background_color']),
                'name_error' => '',
                'alias_error' => '',
                'user_error' => '',
                'password_error' => '',
                'employee_name_error' => '',
                'employee_image_error' => '',
                'employee_number_error' => '',
                'status_error' => '',
                'background_image_error' => '',
            ];
            // validate name
            (!empty($data['name'])) ?: $data['name_error'] = 'هذا الحقل مطلوب';
            // validate alias
            (!empty($data['alias'])) ?: $data['alias_error'] = 'هذا الحقل مطلوب';
            //check alias dublication
            if (empty($data['alias_error'])) {
                $this->storeModel->aliasUpdate($data['alias'], $id) ? '' : $data['alias_error'] = 'هذا الاسم موجود من قبل';
            }
            // validate user
            (!empty($data['user'])) ?: $data['user_error'] = 'هذا الحقل مطلوب';
            // validate employee_name
            (!empty($data['employee_name'])) ?: $data['employee_name_error'] = 'هذا الحقل مطلوب';
            // validate employee_number
            (!empty($data['employee_number'])) ?: $data['employee_number_error'] = 'هذا الحقل مطلوب';
            // validate image
            if ($_FILES['employee_image']['error'] != 4) { // no file has uploaded
                $image = $this->storeModel->validateImage('employee_image');
                ($image[0]) ? $data['employee_image'] = $image[1] : $data['employee_image_error'] = $image[1];
            }
            // validate background image
            if ($_FILES['background_image']['error'] != 4) { // no file has uploaded
                $image = $this->storeModel->validateImage('background_image');
                ($image[0]) ? $data['background_image'] = $image[1] : $data['background_image_error'] = $image[1];
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
                empty($data['name_error']) && empty($data['alias_error']) && empty($data['user_error']) && empty($data['employee_name_error']) && empty($data['employee_image_error'])
                && empty($data['employee_number_error']) && empty($data['status_error']) && empty($data['background_image_error'])
            ) {
                if ($this->storeModel->updateStore($data)) {
                    flash('store_msg', 'تم التعديل بنجاح');
                    isset($_POST['save']) ? redirect('stores/edit/' . $id) : redirect('stores');
                } else {
                    flash('store_msg', 'هناك خطأ ما حاول مرة اخري', 'alert alert-danger');
                }
            } else {
                //load the view with error
                $this->view('stores/edit', $data);
            }
        } else {
            // featch store
            if (!$store = $this->storeModel->getStoreById($id)) {
                flash('store_msg', 'هناك خطأ ما هذه الصفحة غير موجوده او ربما اتبعت رابط خاطيء ', 'alert alert-danger');
                redirect('stores');
            }

            $data = [
                'page_title' => 'المتاجر الفرعية',
                'store_id' => $id,
                'page_title' => 'المتاجر الفرعية',
                'alias' => $store->alias,
                'name' => $store->name,
                'user' => $store->user,
                'password' => '',
                'email' => $store->email,
                'employee_name' => $store->employee_name,
                'employee_image' => $store->employee_image,
                'employee_number' => $store->employee_number,
                'department' => $store->department,
                'ax_store_number' => $store->ax_store_number,
                'job' => $store->job,
                'location' => $store->location,
                'mobile' => $store->mobile,
                'whatsapp' => $store->whatsapp,
                'details' => $store->details,
                'background_color' => $store->background_color,
                'background_image' => $store->background_image,
                'meta_keywords' => $store->meta_keywords,
                'meta_description' => $store->meta_description,
                'status' => $store->status,
                'name_error' => '',
                'alias_error' => '',
                'user_error' => '',
                'password_error' => '',
                'employee_name_error' => '',
                'employee_image_error' => '',
                'employee_number_error' => '',
                'status_error' => '',
                'background_image_error' => '',
            ];
            $this->view('stores/edit', $data);
        }
    }

    /**
     * showing store details
     * @param integer $id
     */
    public function show($id)
    {
        if (!$store = $this->storeModel->getStoreById($id)) {
            flash('store_msg', 'هناك خطأ ما هذه الصفحة غير موجوده او ربما اتبعت رابط خاطيء ', 'alert alert-danger');
            redirect('stores');
        }
        $data = [
            'page_title' => 'المتاجر الفرعية',
            'store' => $store,
        ];
        $this->view('stores/show', $data);
    }

    /**
     * delete record by id
     * @param integer $id
     */
    public function delete($id)
    {
        if ($row_num = $this->storeModel->deleteById([$id], 'store_id')) {
            flash('store_msg', 'تم حذف ' . $row_num . ' بنجاح');
        } else {
            flash('store_msg', 'لم يتم الحذف', 'alert alert-danger');
        }
        redirect('stores');
    }

    /**
     * publish record by id
     * @param integer $id
     */
    public function publish($id)
    {
        if ($row_num = $this->storeModel->publishById([$id], 'store_id')) {
            flash('store_msg', 'تم نشر ' . $row_num . ' بنجاح');
        } else {
            flash('store_msg', 'هناك خطأ ما يرجي المحاولة لاحقا', 'alert alert-danger');
        }
        redirect('stores');
    }

    /**
     * publish record by id
     * @param integer $id
     */
    public function unpublish($id)
    {
        if ($row_num = $this->storeModel->unpublishById([$id], 'store_id')) {
            flash('store_msg', 'تم ايقاف نشر ' . $row_num . ' بنجاح');
        } else {
            flash('store_msg', 'هناك خطأ ما يرجي المحاولة لاحقا', 'alert alert-danger');
        }
        redirect('stores');
    }

    /**
     * adding project to store 
     *
     * @param [int] $store_id
     * @return void
     */
    public function addprojects($store_id = null)
    {
        if (isset($store_id)) :
            // sanitize POST array
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

            //handling Delete
            if (isset($_POST['add'])) {
                if (isset($_POST['record'])) {
                    if ($row_num = $this->storeModel->addProjectToStore($_POST['record'], $store_id)) {
                        flash('store_msg', 'تم ادراج  ' . $row_num . ' مشروعات بنجاح ');
                    }
                }

                redirect('stores');
            }
            //get all records for current project
            $projects = $this->storeModel->getProjects(' WHERE status <> 2 AND project_id NOT IN (SELECT project_id FROM stores_projects WHERE store_id = ' . $store_id . ')');

            $data = [
                'header' => '',
                'title' => 'المشروعات',
                'projects' => $projects,
                'footer' => '',
            ];
            $this->view('stores/addprojects', $data);
        else :
            flash('store_msg', 'هناك خطأ ما يرجي المحاولة لاحقا', 'alert alert-danger');
            redirect('stores');
        endif;
    }

    /**
     * redirect to orders with store id 
     *
     * @param [int] $store_id
     * @return void
     */
    public function orders($store_id = null)
    {
        if (isset($store_id)) :
            echo "<html xmlns='http://www.w3.org/1999/xhtml'>\n<head></head>\n<body>\n";
            echo "<form action='" . ADMINURL . "/orders' method='post' name='frm'>\n";
            echo "\t<input type='hidden' name='search[store_id][]' value='" . $store_id . "'>\n";
            echo '<input type="hidden" name="search[submit]" value="بحـث" />';
            echo "\t<script type='text/javascript'>\n";
            echo "\t\tdocument.frm.submit();\n";
            echo "\t</script>\n";
            echo "</form>\n</body>\n</html>";
        else :
            flash('store_msg', 'هناك خطأ ما يرجي المحاولة لاحقا', 'alert alert-danger');
            redirect('stores');
        endif;
    }

    public function projects($store_id = null)
    {
        if (isset($store_id)) :
            // sanitize POST array
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            //handling publish
            if (isset($_POST['publish'])) {
                if (isset($_POST['record'])) {
                    if ($row_num = $this->storeModel->publishProjectToStore($_POST['record'], $store_id)) {
                        flash('store_msg', 'تم نشر  ' . $row_num . ' مشروع بنجاح ');
                    }
                }
                // redirect('stores/projects/' . $store_id);
            }
            //handling unpublish
            if (isset($_POST['unpublish'])) {
                if (isset($_POST['record'])) {
                    if ($row_num = $this->storeModel->unpublishProjectToStore($_POST['record'], $store_id)) {
                        flash('store_msg', 'تم تعليق نشر  ' . $row_num . ' مشروع بنجاح ');
                    }
                }
                redirect('stores/projects/' . $store_id);
            }
            //handling delete
            if (isset($_POST['delete'])) {
                if (isset($_POST['record'])) {
                    if ($row_num = $this->storeModel->deleteProjectFromStore($_POST['record'], $store_id)) {
                        flash('store_msg', 'تم حذف  ' . $row_num . ' مشروع بنجاح ');
                    }
                }
                redirect('stores/projects/' . $store_id);
            }
            //get all records for current project
            $projects = $this->storeModel->getStoreProjects($store_id);

            $data = [
                'header' => '',
                'title' => 'المشروعات',
                'projects' => $projects,
                'footer' => '',
            ];
            $this->view('stores/projects', $data);
        else :
            flash('store_msg', 'هناك خطأ ما يرجي المحاولة لاحقا', 'alert alert-danger');
            redirect('stores');
        endif;
    }
}
