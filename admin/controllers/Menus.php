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

class Menus extends ControllerAdmin
{

    private $menuModel;

    public function __construct()
    {
        $this->menuModel = $this->model('Menu');
    }

    /**
     * loading index view with latest menus
     */
    public function index($current = '', $perpage = 50)
    {
        // get menus
        $cond = 'WHERE status <> 2 ';
        $bind = [];

        //check user action if the form has submitted
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // sanitize POST array
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

            //handling Delete
            if (isset($_POST['delete'])) {
                if (isset($_POST['record'])) {
                    if ($row_num = $this->menuModel->deleteById($_POST['record'], 'menu_id')) {
                        flash('menu_msg', 'تم حذف ' . $row_num . ' بنجاح');
                    } else {
                        flash('menu_msg', 'لم يتم الحذف', 'alert alert-danger');
                    }
                }

                redirect('menus');
            }

            //handling Publish
            if (isset($_POST['publish'])) {
                if (isset($_POST['record'])) {
                    if ($row_num = $this->menuModel->publishById($_POST['record'], 'menu_id')) {
                        flash('menu_msg', 'تم نشر ' . $row_num . ' بنجاح');
                    } else {
                        flash('menu_msg', 'هناك خطأ ما يرجي المحاولة لاحقا', 'alert alert-danger');
                    }
                }
                redirect('menus');
            }

            //handling Unpublish
            if (isset($_POST['unpublish'])) {

                if (isset($_POST['record'])) {
                    if ($row_num = $this->menuModel->unpublishById($_POST['record'], 'menu_id')) {
                        flash('menu_msg', 'تم ايقاف نشر ' . $row_num . ' بنجاح');
                    } else {
                        flash('menu_msg', 'هناك خطأ ما يرجي المحاولة لاحقا', 'alert alert-danger');
                    }
                }
                redirect('menus');
            }
        }

        //handling search
        $searches = $this->menuModel->searchHandling(['name', 'url', 'status'], $current);
        $cond .= $searches['cond'];
        $bind = $searches['bind'];

        // get all records count after search and filtration
        $recordsCount = $this->menuModel->allMenusCount($cond, $bind);
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
        //get all records for current menu
        $menus = $this->menuModel->getMenus($cond, $bind, $limit, $bindLimit);
        // dd($bindLimit);
        $data = [
            'current' => $current,
            'perpage' => $perpage,
            'header' => '',
            'title' => 'الروابط',
            'menus' => $menus,
            'recordsCount' => $recordsCount->count,
            'footer' => '',
        ];
        $this->view('menus/index', $data);
    }

    /**
     * adding new menu
     */
    public function add()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // sanitize POST array
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

            $data = [
                'page_title' => 'الروابط',
                'name' => trim($_POST['name']),
                'alias' => preg_replace("([~!@#$%^&*()_+=`{}\[\]\|\\:;'<>,.\/? ])", "-", $_POST['name']),
                'url' => trim($_POST['url']),
                'type' => trim($_POST['type']),
                'menus' => $this->menuModel->getMenus('WHERE status <> 2 ', '', '', '', 'menu_id, name, level, parent_id'),
                'status' => '',
                'arrangement' => trim($_POST['arrangement']),
                'status_error' => '',
                'name_error' => '',
                'url_error' => '',
                'parent_id_error' => '',
            ];

            // validate url
            if (empty($data['url'])) {
                $data['url_error'] = 'من فضلك قم بكتابة عنوان الرابط';
            }
            // validate name
            if (empty($data['name'])) {
                $data['name_error'] = 'من فضلك قم بكتابة عنوان الرابط';
            }
            // validate status
            if (isset($_POST['status'])) {
                $data['status'] = trim($_POST['status']);
            }
            if ($data['status'] == '') {
                $data['status_error'] = 'من فضلك اختار حالة النشر';
            }
            // validate Submenu
            if (empty($_POST['parent_id'])) {
                $data['parent_id_error'] = 'هذا الحقل مطلوب';
                $data['parent_id'] = explode(',', $_POST['parent_id'])[0];
                $data['level'] =  explode(',', $_POST['parent_id'])[1];
            } else {
                $data['parent_id'] = explode(',', $_POST['parent_id'])[0];
                $data['level'] =  explode(',', $_POST['parent_id'])[1];
            }
            //make sure there is no errors
            if (empty($data['status_error']) && empty($data['parent_id_error']) && empty($data['name_error']) && empty($data['url_error'])) {
                //validated
                if ($this->menuModel->addMenu($data)) {
                    flash('menu_msg', 'تم الحفظ بنجاح');
                    redirect('menus');
                } else {
                    flash('menu_msg', 'هناك خطأ ما حاول مرة اخري', 'alert alert-danger');
                }
            } else {
                //load the view with error
                $this->view('menus/add', $data);
            }
        } else {
            $data = [
                'page_title' => 'الروابط',
                'menus' => $this->menuModel->getMenus('WHERE status <> 2 ', '', '', '', 'menu_id, name, level, parent_id'),
                'name' => '',
                'description' => '',
                'type' => '',
                'parent_id' => '',
                'level' => '',
                'url' => '',
                'status' => 0,
                'arrangement' => 0,
                'name_error' => '',
                'url_error' => '',
                'parent_id_error' => '',
                'status_error' => '',
            ];
        }

        //loading the add menu view
        $this->view('menus/add', $data);
    }

    /**
     * update menu
     * @param integer $id
     */
    public function edit($id)
    {
        $id = (int) $id;
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // sanitize POST array
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $data = [
                'menu_id' => $id,
                'page_title' => 'الروابط',
                'name' => trim($_POST['name']),
                'alias' => preg_replace("([~!@#$%^&*()_+=`{}\[\]\|\\:;'<>,.\/? ])", "-", $_POST['name']),
                'menus' => $this->menuModel->getMenus('WHERE status <> 2 ', '', '', '', 'menu_id, name, level, parent_id'),
                'url' => trim($_POST['url']),
                'type' => trim($_POST['type']),
                'status' => '',
                'arrangement' => trim($_POST['arrangement']),
                'status_error' => '',
                'name_error' => '',
                'parent_id_error' => '',
                'url_error' => '',
            ];

            // validate url
            if (empty($data['url'])) {
                $data['url_error'] = 'من فضلك قم بكتابة عنوان الرابط';
            }
            // validate name
            if (empty($data['name'])) {
                $data['name_error'] = 'من فضلك قم بكتابة عنوان الرابط';
            }
            // validate status
            if (isset($_POST['status'])) {
                $data['status'] = trim($_POST['status']);
            }
            if ($data['status'] == '') {
                $data['status_error'] = 'من فضلك اختار حالة النشر';
            }
            // validate Submenu
            if (empty($_POST['parent_id'])) {
                $data['parent_id_error'] = 'هذا الحقل مطلوب';
                $data['parent_id'] = explode(',', $_POST['parent_id'])[0];
                $data['level'] =  explode(',', $_POST['parent_id'])[1];
            } else {
                $data['parent_id'] = explode(',', $_POST['parent_id'])[0];
                $data['level'] =  explode(',', $_POST['parent_id'])[1];
            }
            // make sure there is no errors
            if (empty($data['status_error'])  && empty($data['parent_id_error']) && empty($data['name_error']) && empty($data['url_error'])) {
                //validated
                if ($this->menuModel->updateMenu($data)) {
                    flash('menu_msg', 'تم التعديل بنجاح');
                    isset($_POST['save']) ? redirect('menus/edit/' . $id) : redirect('menus');
                } else {
                    flash('menu_msg', 'هناك خطأ ما حاول مرة اخري', 'alert alert-danger');
                }
            } else {
                //load the view with error
                $this->view('menus/edit', $data);
            }
        } else {
            // featch menu
            if (!$menu = $this->menuModel->getMenuById($id)) {
                flash('menu_msg', 'هناك خطأ ما هذه الصفحة غير موجوده او ربما اتبعت رابط خاطيء ', 'alert alert-danger');
                redirect('menus');
            }

            $data = [
                'page_title' => 'الروابط',
                'menus' => $this->menuModel->getMenus('WHERE status <> 2 ', '', '', '', 'menu_id, name, level, parent_id'),
                'menu_id' => $id,
                'name' => $menu->name,
                'url' => $menu->url,
                'level' => $menu->level,
                'parent_id' => $menu->parent_id,
                'type' => $menu->type,
                'status' => $menu->status,
                'arrangement' => $menu->arrangement,
                'status_error' => '',
                'name_error' => '',
                'parent_id_error' => '',
                'url_error' => '',
            ];
            $this->view('menus/edit', $data);
        }
    }

    /**
     * showing menu details
     * @param integer $id
     */
    public function show($id)
    {
        if (!$menu = $this->menuModel->getMenuById($id)) {
            flash('menu_msg', 'هناك خطأ ما هذه الصفحة غير موجوده او ربما اتبعت رابط خاطيء ', 'alert alert-danger');
            redirect('menus');
        }
        $data = [
            'page_title' => 'الروابط',
            'menu' => $menu,
        ];
        $this->view('menus/show', $data);
    }

    /**
     * delete record by id
     * @param integer $id
     */
    public function delete($id)
    {
        if ($row_num = $this->menuModel->deleteById([$id], 'menu_id')) {
            flash('menu_msg', 'تم حذف ' . $row_num . ' بنجاح');
        } else {
            flash('menu_msg', 'لم يتم الحذف', 'alert alert-danger');
        }
        redirect('menus');
    }

    /**
     * publish record by id
     * @param integer $id
     */
    public function publish($id)
    {
        if ($row_num = $this->menuModel->publishById([$id], 'menu_id')) {
            flash('menu_msg', 'تم نشر ' . $row_num . ' بنجاح');
        } else {
            flash('menu_msg', 'هناك خطأ ما يرجي المحاولة لاحقا', 'alert alert-danger');
        }
        redirect('menus');
    }

    /**
     * publish record by id
     * @param integer $id
     */
    public function unpublish($id)
    {
        if ($row_num = $this->menuModel->unpublishById([$id], 'menu_id')) {
            flash('menu_msg', 'تم ايقاف نشر ' . $row_num . ' بنجاح');
        } else {
            flash('menu_msg', 'هناك خطأ ما يرجي المحاولة لاحقا', 'alert alert-danger');
        }
        redirect('menus');
    }
}
