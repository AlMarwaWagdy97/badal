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

class Managers extends ControllerAdmin
{

    private $managerModel;
    private $storeModel;

    //    private $userModel;

    public function __construct()
    {
        $this->managerModel = $this->model('Manager');
        $this->storeModel = $this->model('Store');
    }

    /**
     * loading index view with latest stores_managers
     */
    public function index($current = '', $perpage = 50)
    {
        // get stores_managers
        $cond = 'WHERE status <> 2 ';
        $bind = [];
        //check user action if the form has submitted
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // sanitize POST array
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            //handling Delete
            if (isset($_POST['delete'])) {
                if (isset($_POST['record'])) {
                    if ($row_num = $this->managerModel->deleteById($_POST['record'], 'manager_id')) {
                        flash('manager_msg', 'تم حذف ' . $row_num . ' بنجاح');
                    } else {
                        flash('manager_msg', 'لم يتم الحذف', 'alert alert-danger');
                    }
                }

                redirect('managers');
            }

            //handling Publish
            if (isset($_POST['publish'])) {
                if (isset($_POST['record'])) {
                    if ($row_num = $this->managerModel->publishById($_POST['record'], 'manager_id')) {
                        flash('manager_msg', 'تم تفعيل المدراء ' . $row_num . ' بنجاح');
                    } else {
                        flash('manager_msg', 'هناك خطأ ما يرجي المحاولة لاحقا', 'alert alert-danger');
                    }
                }
                redirect('managers');
            }

            //handling Unpublish
            if (isset($_POST['unpublish'])) {

                if (isset($_POST['record'])) {
                    if ($row_num = $this->managerModel->unpublishById($_POST['record'], 'manager_id')) {
                        flash('manager_msg', 'تم تعليق المدراء ' . $row_num . ' بنجاح');
                    } else {
                        flash('manager_msg', 'هناك خطأ ما يرجي المحاولة لاحقا', 'alert alert-danger');
                    }
                }
                redirect('managers');
            }
        }

        //handling search
        $searches = $this->managerModel->searchHandling(['name', 'email', 'status'], $current);
        $cond .= $searches['cond'];
        $bind = $searches['bind'];

        // get all records cout after search and filtration
        $recordsCount = $this->managerModel->allManagersCount($cond, $bind);
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
        //get all records for current manager
        $managers = $this->managerModel->getManagers($cond, $bind, $limit, $bindLimit);

        $data = [
            'current' => $current,
            'perpage' => $perpage,
            'header' => '',
            'title' => 'مدراء المتاجر',
            'managers' => $managers,
            'recordsCount' => $recordsCount->count,
            'footer' => '',
        ];
        $this->view('managers/index', $data);
    }

    /**
     * adding new manager
     */
    public function add()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // sanitize POST array
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

            $data = [
                'page_title' => 'مدراء المتاجر',
                'name' => trim($_POST['name']),
                'email' => trim($_POST['email']),
                'password' => trim($_POST['password']),
                'storesList' => $this->storeModel->getStores(),
                'stores' => (array) $_POST['stores'],
                'status' => '',
                'status_error' => '',
                'email_error' => '',
                'password_error' => '',
                'name_error' => '',
            ];

            // validate status
            if (isset($_POST['status'])) {
                $data['status'] = trim($_POST['status']);
            }
            if ($data['status'] == '') {
                $data['status_error'] = 'من فضلك اختار حالة المدراء';
            }
            // validate name
            if (empty($data['name'])) {
                $data['name_error'] = 'من فضلك اختار اسم للمدراء';
            }
            // validate name
            if (empty($data['email'])) {
                $data['email_error'] = 'من فضلك اختار اسم للمدراء';
            }
            // Validate Password
            if (empty($data['password'])) {
                $data['password_error'] = 'من فضلك قم بأدخال كلمة مرور مناسبة';
            } elseif (strlen($data['password']) < 6) {
                $data['password_error'] = 'كلمة المرور لا يجب ان تكون اقل من 6 احرف';
            }
            //             make sure there is no errors
            if (empty($data['status_error']) && empty($data['name_error']) && empty($data['email_error']) && empty($data['password_error'])) {
                //validated
                if ($this->managerModel->addManager($data)) {
                    flash('manager_msg', 'تم الحفظ بنجاح');
                    redirect('managers');
                } else {
                    flash('manager_msg', 'هناك خطأ ما حاول مرة اخري', 'alert alert-danger');
                }
            } else {
                //load the view with error
                $this->view('managers/add', $data);
            }
        } else {
            $data = [
                'page_title' => 'مدراء المتاجر',
                'name' => '',
                'password' => '',
                'email' => '',
                'storesList' => $this->storeModel->getStores(),
                'stores' => [],
                'status' => 0,
                'name_error' => '',
                'password_error' => '',
                'email_error' => '',
                'status_error' => '',
            ];
        }
        //loading the add manager view
        $this->view('managers/add', $data);
    }

    /**
     * update manager
     * @param integer $id
     */
    public function edit($id)
    {
        $id = (int) $id;
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            // dd($_POST);
            $data = [
                'manager_id' => $id,
                'page_title' => 'مدراء المتاجر',
                'name' => trim($_POST['name']),
                'email' => trim($_POST['email']),
                'password' => trim($_POST['password']),
                'storesList' => $this->storeModel->getStores(),
                'stores' => (array) $_POST['stores'],
                'status' => trim($_POST['status']),
                'status_error' => '',
                'name_error' => '',
                'email_error' => '',
                'password_error' => '',
            ];

            // validate status
            if ($data['status'] == '') {
                $data['status_error'] = 'من فضلك اختار حالة المدراء';
            }
            // validate name
            if (empty($data['name'])) {
                $data['name_error'] = 'من فضلك اختار اسم للمدراء';
            }

            // validate email
            if (empty($data['email'])) {
                $data['email_error'] = 'من فضلك اختار اسم للمدراء';
            }
            // Validate Password
            if (!empty($data['password'])) {
                if (strlen($data['password']) < 6) {
                    $data['password_error'] = 'كلمة المرور لا يجب ان تكون اقل من 6 احرف';
                }
            }
            // make sure there is no errors
            if (empty($data['status_error']) && empty($data['name_error']) && empty($data['email_error']) && empty($data['password_error'])) {
                //validated
                unset($data['storesList']);
                if ($this->managerModel->updateManager($data)) {
                    flash('manager_msg', 'تم التعديل بنجاح');
                    isset($_POST['save']) ? redirect('managers/edit/' . $id) : redirect('managers');
                } else {
                    flash('manager_msg', 'هناك خطأ ما حاول مرة اخري', 'alert alert-danger');
                }
            } else {
                //load the view with error
                $this->view('managers/add', $data);
            }
        } else {
            // featch manager
            if (!$manager = $this->managerModel->getManagerById($id)) {
                flash('manager_msg', 'هناك خطأ ما هذه الصفحة غير موجوده او ربما اتبعت رابط خاطيء ', 'alert alert-danger');
                redirect('managers');
            }

            $data = [
                'manager_id' => $id,
                'page_title' => 'مدراء المتاجر',
                'name' => $manager->name,
                'email' => $manager->email,
                'password' => '',
                'stores' => json_decode($manager->stores),
                'storesList' => $this->storeModel->getStores(),
                'status' => $manager->status,
                'name_error' => '',
                'status_error' => '',
                'email_error' => '',
                'password_error' => '',
            ];
            $this->view('managers/edit', $data);
        }
    }

    /**
     * showing manager details
     * @param integer $id
     */
    public function show($id)
    {
        if (!$manager = $this->managerModel->getManagerById($id)) {
            flash('manager_msg', 'هناك خطأ ما هذه الصفحة غير موجوده او ربما اتبعت رابط خاطيء ', 'alert alert-danger');
            redirect('managers');
        }
        $data = [
            'page_title' => 'مدراء المتاجر',
            'manager' => $manager,
            'storesList' => $this->storeModel->getStores(),
        ];
        $this->view('managers/show', $data);
    }

    /**
     * delete record by id
     * @param integer $id
     */
    public function delete($id)
    {
        if ($row_num = $this->managerModel->deleteById([$id], 'manager_id')) {
            flash('manager_msg', 'تم حذف ' . $row_num . ' بنجاح');
        } else {
            flash('manager_msg', 'لم يتم الحذف', 'alert alert-danger');
        }
        redirect('managers');
    }

    /**
     * publish record by id
     * @param integer $id
     */
    public function publish($id)
    {
        if ($row_num = $this->managerModel->publishById([$id], 'manager_id')) {
            flash('manager_msg', 'تم نشر ' . $row_num . ' بنجاح');
        } else {
            flash('manager_msg', 'هناك خطأ ما يرجي المحاولة لاحقا', 'alert alert-danger');
        }
        redirect('managers');
    }

    /**
     * publish record by id
     * @param integer $id
     */
    public function unpublish($id)
    {
        if ($row_num = $this->managerModel->unpublishById([$id], 'manager_id')) {
            flash('manager_msg', 'تم ايقاف نشر ' . $row_num . ' بنجاح');
        } else {
            flash('manager_msg', 'هناك خطأ ما يرجي المحاولة لاحقا', 'alert alert-danger');
        }
        redirect('managers');
    }
}
