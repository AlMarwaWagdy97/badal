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

class Substitutes extends ControllerAdmin
{
    private $substituteModel;

    public function __construct()
    {
        $this->substituteModel = $this->model('Substitute');
    }

    /**
     * loading index view with latest substitutes
     */
    public function index($current = '', $perpage = 50)
    {
        // get substitutes
        $cond = 'WHERE status <> 2 ';
        $bind = [];
        //check user action if the form has submitted
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // sanitize POST array
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            //handling Delete
            if (isset($_POST['delete'])) {
                if (isset($_POST['record'])) {
                    if ($row_num = $this->substituteModel->deleteById($_POST['record'], 'substitute_id')) {
                        flash('substitute_msg', 'تم حذف ' . $row_num . ' بنجاح');
                    } else {
                        flash('substitute_msg', 'لم يتم الحذف', 'alert alert-danger');
                    }
                }
                redirect('substitutes');
            }
            //handling Publish
            if (isset($_POST['publish'])) {
                if (isset($_POST['record'])) {
                    if ($row_num = $this->substituteModel->publishById($_POST['record'], 'substitute_id')) {
                        flash('substitute_msg', 'تم نشر ' . $row_num . ' بنجاح');
                    } else {
                        flash('substitute_msg', 'هناك خطأ ما يرجي المحاولة لاحقا', 'alert alert-danger');
                    }
                }
                redirect('substitutes');
            }
            //handling Unpublish
            if (isset($_POST['unpublish'])) {
                if (isset($_POST['record'])) {
                    if ($row_num = $this->substituteModel->unpublishById($_POST['record'], 'substitute_id')) {
                        flash('substitute_msg', 'تم ايقاف نشر ' . $row_num . ' بنجاح');
                    } else {
                        flash('substitute_msg', 'هناك خطأ ما يرجي المحاولة لاحقا', 'alert alert-danger');
                    }
                }
                redirect('substitutes');
            }
        }
        //handling search
        $searches = $this->substituteModel->searchHandling(['full_name', 'identity', 'phone', 'email', 'nationality', 'gender', 'status'], $current);
        $cond .= $searches['cond'];
        $bind = $searches['bind'];
        // get all records count after search and filtration
        $recordsCount = $this->substituteModel->allSubstitutesCount($cond, $bind);
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
        //get all records for current substitute
        $substitutes = $this->substituteModel->getSubstitutes($cond, $bind, $limit, $bindLimit);
        $data = [
            'current' => $current,
            'perpage' => $perpage,
            'header' => '',
            'title' => 'المتطوعون',
            'substitutes' => $substitutes,
            'recordsCount' => $recordsCount->count,
            'footer' => '',
        ];
        $this->view('substitutes/index', $data);
    }

    /**
     * adding new substitute
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
                'languages' => $_POST['languages'],
                'proportion' => $_POST['proportion'],
                'status' => '',
                'status_error' => '',
                'email_error' => '',
                'gender_error' => '',
                'nationality_error' => '',
                'identity_error' => '',
                'phone_error' => '',
                'full_name_error' => '',
                'image_error' => '',
                'languages_error' => '',
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
            // validate languages
            !(empty($data['languages'])) ?: $data['languages_error'] = 'هذا الحقل مطلوب';
            // validate status
            if (isset($_POST['status'])) {
                $data['status'] = trim($_POST['status']);
            }
            if ($data['status'] == '') {
                $data['status_error'] = 'من فضلك اختار حالة النشر';
            }
            // validate image
            if ($_FILES['image']['error'] != 4) {
                $image = uploadImage('image', ADMINROOT . '/../media/files/substitutes/', 5000000, false);
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
                if ($this->substituteModel->addSubstitute($data)) {
                    flash('substitute_msg', 'تم الحفظ بنجاح');
                    redirect('substitutes');
                } else {
                    flash('substitute_msg', 'هناك خطأ ما حاول مرة اخري', 'alert alert-danger');
                }
            } else {
                //load the view with error
                $this->view('substitutes/add', $data);
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
                'proportion' => '',
                'phone' => '',
                'city' => '',
                'languages' => [],
                'status' => 0,
                'status_error' => '',
                'email_error' => '',
                'gender_error' => '',
                'nationality_error' => '',
                'phone_error' => '',
                'identity_error' => '',
                'full_name_error' => '',
                'image_error' => '',
                'languages_error' => '',
            ];
        }
        //loading the add substitute view
        $this->view('substitutes/add', $data);
    }

    /**
     * update substitute
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
                'substitute_id' => $id,
                'identity' => trim($_POST['identity']),
                'image' => '',
                'full_name' => trim($_POST['full_name']),
                'phone' => trim($_POST['phone']),
                'nationality' => trim($_POST['nationality']),
                'gender' => trim($_POST['gender']),
                'email' => trim($_POST['email']),
                'languages' => $_POST['languages'],
                'proportion' => $_POST['proportion'],
                'status' => '',
                'status_error' => '',
                'email_error' => '',
                'identity_error' => '',
                'gender_error' => '',
                'nationality_error' => '',
                'phone_error' => '',
                'full_name_error' => '',
                'image_error' => '',
                'languages_error' => '',
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
            // validate languages
            !(empty($data['languages'])) ?: $data['languages_error'] = 'هذا الحقل مطلوب';
            // validate status
            if (isset($_POST['status'])) {
                $data['status'] = trim($_POST['status']);
            }
            if ($data['status'] == '') {
                $data['status_error'] = 'من فضلك اختار حالة النشر';
            }

            // validate image
            if ($_FILES['image']['error'] != 4) {
                $image = uploadImage('image', ADMINROOT . '/../media/files/substitutes/', 5000000, false);
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
                if ($this->substituteModel->updateSubstitute($data)) {
                    flash('substitute_msg', 'تم التعديل بنجاح');
                    isset($_POST['save']) ? redirect('substitutes/edit/' . $id) : redirect('substitutes');
                } else {
                    flash('substitute_msg', 'هناك خطأ ما حاول مرة اخري', 'alert alert-danger');
                }
            } else {
                //load the view with error
                $this->view('substitutes/edit', $data);
            }
        } else {
            // featch substitute
            if (!$substitute = $this->substituteModel->getSubstituteById($id)) {
                flash('substitute_msg', 'هناك خطأ ما هذه الصفحة غير موجوده او ربما اتبعت رابط خاطيء ', 'alert alert-danger');
                redirect('substitutes');
            }
            $data = [
                'page_title' => 'المتطوعون',
                'substitute_id' => $id,
                'full_name' => $substitute->full_name,
                'identity' => $substitute->identity,
                'image' => $substitute->image,
                'phone' => $substitute->phone,
                'nationality' => $substitute->nationality,
                'gender' => $substitute->gender,
                'email' => $substitute->email,
                'proportion' => $substitute->proportion,
                'status' => $substitute->status,
                'languages' => explode(',', $substitute->languages)??[],
                'status_error' => '',
                'email_error' => '',
                'identity_error' => '',
                'gender_error' => '',
                'languages_error' => '',
                'nationality_error' => '',
                'phone_error' => '',
                'full_name_error' => '',
                'image_error' => '',
            ];
            $this->view('substitutes/edit', $data);
        }
    }

    /**
     * showing substitute details
     * @param integer $id
     */
    public function show($id)
    {
        if (!$substitute = $this->substituteModel->getSubstituteById($id)) {
            flash('substitute_msg', 'هناك خطأ ما هذه الصفحة غير موجوده او ربما اتبعت رابط خاطيء ', 'alert alert-danger');
            redirect('substitutes');
        }
        $this->substituteModel->publishById([$id], 'substitute_id');
        $offers = $this->substituteModel->getOffersBySubsitute($substitute->substitute_id);
        $reviews = $this->substituteModel->getReviewBySubstituteId($substitute->substitute_id);

        $data = [
            'page_title' => 'المتطوعون',
            'substitute' => $substitute,
            'offers' => $offers,
            'reviews' => $reviews,
        ];
        $this->view('substitutes/show', $data);
    }

    /**
     * delete record by id
     * @param integer $id
     */
    public function delete($id)
    {
        if ($row_num = $this->substituteModel->deleteById([$id], 'substitute_id')) {
            flash('substitute_msg', 'تم حذف ' . $row_num . ' بنجاح');
        } else {
            flash('substitute_msg', 'لم يتم الحذف', 'alert alert-danger');
        }
        redirect('substitutes');
    }

    /**
     * publish record by id
     * @param integer $id
     */
    public function publish($id)
    {
        if ($row_num = $this->substituteModel->publishById([$id], 'substitute_id')) {
            flash('substitute_msg', 'تم تعليم كا مقروءة ' . $row_num . ' بنجاح');
        } else {
            flash('substitute_msg', 'هناك خطأ ما يرجي المحاولة لاحقا', 'alert alert-danger');
        }
        redirect('substitutes');
    }

    /**
     * publish record by id
     * @param integer $id
     */
    public function unpublish($id)
    {
        if ($row_num = $this->substituteModel->unpublishById([$id], 'substitute_id')) {
            flash('substitute_msg', 'تم تعليم كا غير مقروءة ' . $row_num . ' بنجاح');
        } else {
            flash('substitute_msg', 'هناك خطأ ما يرجي المحاولة لاحقا', 'alert alert-danger');
        }
        redirect('substitutes');
    }

    
}
