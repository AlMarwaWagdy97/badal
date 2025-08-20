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

class Volunteers extends ControllerAdmin
{
    private $volunteerModel;
    public function __construct()
    {
        $this->volunteerModel = $this->model('Volunteer');
    }
    /**
     * loading index view with latest volunteers
     */
    public function index($current = '', $perpage = 50)
    {
        // get volunteers
        $cond = 'WHERE status <> 2 ';
        $bind = [];
        //check user action if the form has submitted
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // sanitize POST array
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            //handling Delete
            if (isset($_POST['delete'])) {
                if (isset($_POST['record'])) {
                    if ($row_num = $this->volunteerModel->deleteById($_POST['record'], 'volunteer_id')) {
                        flash('volunteer_msg', 'تم حذف ' . $row_num . ' بنجاح');
                    } else {
                        flash('volunteer_msg', 'لم يتم الحذف', 'alert alert-danger');
                    }
                }
                redirect('volunteers');
            }
            //handling Publish
            if (isset($_POST['publish'])) {
                if (isset($_POST['record'])) {
                    if ($row_num = $this->volunteerModel->publishById($_POST['record'], 'volunteer_id')) {
                        flash('volunteer_msg', 'تم نشر ' . $row_num . ' بنجاح');
                    } else {
                        flash('volunteer_msg', 'هناك خطأ ما يرجي المحاولة لاحقا', 'alert alert-danger');
                    }
                }
                redirect('volunteers');
            }
            //handling Unpublish
            if (isset($_POST['unpublish'])) {
                if (isset($_POST['record'])) {
                    if ($row_num = $this->volunteerModel->unpublishById($_POST['record'], 'volunteer_id')) {
                        flash('volunteer_msg', 'تم ايقاف نشر ' . $row_num . ' بنجاح');
                    } else {
                        flash('volunteer_msg', 'هناك خطأ ما يرجي المحاولة لاحقا', 'alert alert-danger');
                    }
                }
                redirect('volunteers');
            }
        }
        //handling search
        $searches = $this->volunteerModel->searchHandling(['full_name', 'identity', 'phone', 'email', 'nationality', 'gender', 'status'], $current);
        $cond .= $searches['cond'];
        $bind = $searches['bind'];
        // get all records count after search and filtration
        $recordsCount = $this->volunteerModel->allVolunteersCount($cond, $bind);
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
        //get all records for current volunteer
        $volunteers = $this->volunteerModel->getVolunteers($cond, $bind, $limit, $bindLimit);
        $data = [
            'current' => $current,
            'perpage' => $perpage,
            'header' => '',
            'title' => 'المتطوعون',
            'volunteers' => $volunteers,
            'recordsCount' => $recordsCount->count,
            'footer' => '',
        ];
        $this->view('volunteers/index', $data);
    }

    /**
     * adding new volunteer
     */
    public function add()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // sanitize POST array
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $data = [
                'page_title' => 'المتطوعون',
                'identity' => trim($_POST['identity']),
                'image' => '',
                'full_name' => trim($_POST['full_name']),
                'phone' => trim($_POST['phone']),
                'nationality' => trim($_POST['nationality']),
                'gender' => trim($_POST['gender']),
                'email' => trim($_POST['email']),
                'status' => '',
                'status_error' => '',
                'email_error' => '',
                'gender_error' => '',
                'nationality_error' => '',
                'identity_error' => '',
                'phone_error' => '',
                'full_name_error' => '',
                'image_error' => '',
            ];
            // validate identity
            !(empty($data['identity'])) ?: $data['identity_error'] = 'هذا الحقل مطلوب';
            // validate gender
            !(empty($data['gender'])) ?: $data['gender_error'] = 'هذا الحقل مطلوب';
            // validate email
            !(empty($data['email'])) ?: $data['email_error'] = 'هذا الحقل مطلوب';
            // validate phone
            !(empty($data['phone'])) ?: $data['phone_error'] = 'هذا الحقل مطلوب';
            // validate nationality
            !(empty($data['nationality'])) ?: $data['nationality_error'] = 'هذا الحقل مطلوب';
            // validate full_name
            !(empty($data['full_name'])) ?: $data['full_name_error'] = 'هذا الحقل مطلوب';
            // validate status
            if (isset($_POST['status'])) {
                $data['status'] = trim($_POST['status']);
            }
            if ($data['status'] == '') {
                $data['status_error'] = 'من فضلك اختار حالة النشر';
            }
            // validate image
            if ($_FILES['image']['error'] != 4) {
                $image = uploadImage('image', ADMINROOT . '/../media/files/volunteers/', 5000000, false);
                if (empty($image['error'])) {
                    $data['image'] = $image['filename'];
                } else {
                    if (!isset($image['error']['nofile'])) {
                        $data['image_error'] = implode(',', $image['error']);
                    }
                }
            } else {
                $data['image_error'] = "من فضلك قم برفع ملف الهوية";
            }
            //make sure there is no errors
            if (
                empty($data['status_error']) && empty($data['full_name_error']) && empty($data['gender_error']) && empty($data['email_error'])
                && empty($data['phone_error']) && empty($data['image_error'])
            ) {
                //validated
                if ($this->volunteerModel->addVolunteer($data)) {
                    flash('volunteer_msg', 'تم الحفظ بنجاح');
                    redirect('volunteers');
                } else {
                    flash('volunteer_msg', 'هناك خطأ ما حاول مرة اخري', 'alert alert-danger');
                }
            } else {
                //load the view with error
                $this->view('volunteers/add', $data);
            }
        } else {
            $data = [
                'page_title' => 'المتطوعون',
                'identity' => '',
                'image' => '',
                'nationality' => '',
                'gender' => '',
                'email' => '',
                'district' => '',
                'message' => '',
                'full_name' => '',
                'phone' => '',
                'city' => '',
                'status' => 0,
                'status_error' => '',
                'email_error' => '',
                'gender_error' => '',
                'nationality_error' => '',
                'phone_error' => '',
                'identity_error' => '',
                'full_name_error' => '',
                'image_error' => '',
            ];
        }
        //loading the add volunteer view
        $this->view('volunteers/add', $data);
    }
    /**
     * update volunteer
     * @param integer $id
     */
    public function edit($id)
    {
        $id = (int) $id;
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // sanitize POST array
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $data = [
                'page_title' => 'المتطوعون',
                'volunteer_id' => $id,
                'identity' => trim($_POST['identity']),
                'image' => '',
                'full_name' => trim($_POST['full_name']),
                'phone' => trim($_POST['phone']),
                'nationality' => trim($_POST['nationality']),
                'gender' => trim($_POST['gender']),
                'email' => trim($_POST['email']),
                'status' => '',
                'status_error' => '',
                'email_error' => '',
                'identity_error' => '',
                'gender_error' => '',
                'nationality_error' => '',
                'phone_error' => '',
                'full_name_error' => '',
                'image_error' => '',
            ];
            // validate gender
            !(empty($data['gender'])) ?: $data['gender_error'] = 'هذا الحقل مطلوب';
            // validate email
            !(empty($data['email'])) ?: $data['email_error'] = 'هذا الحقل مطلوب';
            // validate phone
            !(empty($data['phone'])) ?: $data['phone_error'] = 'هذا الحقل مطلوب';
            // validate nationality
            !(empty($data['nationality'])) ?: $data['nationality_error'] = 'هذا الحقل مطلوب';
            // validate full_name
            !(empty($data['full_name'])) ?: $data['full_name_error'] = 'هذا الحقل مطلوب';
            // validate status
            if (isset($_POST['status'])) {
                $data['status'] = trim($_POST['status']);
            }
            if ($data['status'] == '') {
                $data['status_error'] = 'من فضلك اختار حالة النشر';
            }
            // validate image
            if ($_FILES['image']['error'] != 4) {
                $image = uploadImage('image', ADMINROOT . '/../media/files/volunteers/', 5000000, false);
                if (empty($image['error'])) {
                    $data['image'] = $image['filename'];
                } else {
                    if (!isset($image['error']['nofile'])) {
                        $data['image_error'] = implode(',', $image['error']);
                    }
                }
            }
            //make sure there is no errors
            if (
                empty($data['status_error']) && empty($data['full_name_error'])
                && empty($data['gender_error']) && empty($data['email_error']) && empty($data['phone_error']) && empty($data['image_error'])
            ) {
                //validated
                if ($this->volunteerModel->updateVolunteer($data)) {
                    flash('volunteer_msg', 'تم التعديل بنجاح');
                    isset($_POST['save']) ? redirect('volunteers/edit/' . $id) : redirect('volunteers');
                } else {
                    flash('volunteer_msg', 'هناك خطأ ما حاول مرة اخري', 'alert alert-danger');
                }
            } else {
                //load the view with error
                $this->view('volunteers/edit', $data);
            }
        } else {
            // featch volunteer
            if (!$volunteer = $this->volunteerModel->getVolunteerById($id)) {
                flash('volunteer_msg', 'هناك خطأ ما هذه الصفحة غير موجوده او ربما اتبعت رابط خاطيء ', 'alert alert-danger');
                redirect('volunteers');
            }
            $data = [
                'page_title' => 'المتطوعون',
                'volunteer_id' => $id,
                'full_name' => $volunteer->full_name,
                'identity' => $volunteer->identity,
                'image' => $volunteer->image,
                'phone' => $volunteer->phone,
                'nationality' => $volunteer->nationality,
                'gender' => $volunteer->gender,
                'email' => $volunteer->email,
                'status' => $volunteer->status,
                'status_error' => '',
                'email_error' => '',
                'identity_error' => '',
                'gender_error' => '',
                'nationality_error' => '',
                'phone_error' => '',

                'full_name_error' => '',
                'image_error' => '',
            ];
            $this->view('volunteers/edit', $data);
        }
    }

    /**
     * showing volunteer details
     * @param integer $id
     */
    public function show($id)
    {
        if (!$volunteer = $this->volunteerModel->getVolunteerById($id)) {
            flash('volunteer_msg', 'هناك خطأ ما هذه الصفحة غير موجوده او ربما اتبعت رابط خاطيء ', 'alert alert-danger');
            redirect('volunteers');
        }
        $this->volunteerModel->publishById([$id], 'volunteer_id');
        $data = [
            'page_title' => 'المتطوعون',
            'volunteer' => $volunteer,
        ];
        $this->view('volunteers/show', $data);
    }

    /**
     * delete record by id
     * @param integer $id
     */
    public function delete($id)
    {
        if ($row_num = $this->volunteerModel->deleteById([$id], 'volunteer_id')) {
            flash('volunteer_msg', 'تم حذف ' . $row_num . ' بنجاح');
        } else {
            flash('volunteer_msg', 'لم يتم الحذف', 'alert alert-danger');
        }
        redirect('volunteers');
    }

    /**
     * publish record by id
     * @param integer $id
     */
    public function publish($id)
    {
        if ($row_num = $this->volunteerModel->publishById([$id], 'volunteer_id')) {
            flash('volunteer_msg', 'تم تعليم كا مقروءة ' . $row_num . ' بنجاح');
        } else {
            flash('volunteer_msg', 'هناك خطأ ما يرجي المحاولة لاحقا', 'alert alert-danger');
        }
        redirect('volunteers');
    }

    /**
     * publish record by id
     * @param integer $id
     */
    public function unpublish($id)
    {
        if ($row_num = $this->volunteerModel->unpublishById([$id], 'volunteer_id')) {
            flash('volunteer_msg', 'تم تعليم كا غير مقروءة ' . $row_num . ' بنجاح');
        } else {
            flash('volunteer_msg', 'هناك خطأ ما يرجي المحاولة لاحقا', 'alert alert-danger');
        }
        redirect('volunteers');
    }
}
