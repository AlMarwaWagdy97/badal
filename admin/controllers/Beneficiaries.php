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

class Beneficiaries extends ControllerAdmin
{

    private $beneficiaryModel;

    public function __construct()
    {
        $this->beneficiaryModel = $this->model('Beneficiary');
    }

    /**
     * loading index view with latest beneficiaries
     */
    public function index($current = '', $perpage = 50)
    {
        // get beneficiaries
        $cond = 'WHERE status <> 2 ';
        $bind = [];

        //check user action if the form has submitted
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // sanitize POST array
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

            //handling Delete
            if (isset($_POST['delete'])) {
                if (isset($_POST['record'])) {
                    if ($row_num = $this->beneficiaryModel->deleteById($_POST['record'], 'beneficiary_id')) {
                        flash('beneficiary_msg', 'تم حذف ' . $row_num . ' بنجاح');
                    } else {
                        flash('beneficiary_msg', 'لم يتم الحذف', 'alert alert-danger');
                    }
                }

                redirect('beneficiaries');
            }

            //handling Publish
            if (isset($_POST['publish'])) {
                if (isset($_POST['record'])) {
                    if ($row_num = $this->beneficiaryModel->publishById($_POST['record'], 'beneficiary_id')) {
                        flash('beneficiary_msg', 'تم نشر ' . $row_num . ' بنجاح');
                    } else {
                        flash('beneficiary_msg', 'هناك خطأ ما يرجي المحاولة لاحقا', 'alert alert-danger');
                    }
                }
                redirect('beneficiaries');
            }

            //handling Unpublish
            if (isset($_POST['unpublish'])) {

                if (isset($_POST['record'])) {
                    if ($row_num = $this->beneficiaryModel->unpublishById($_POST['record'], 'beneficiary_id')) {
                        flash('beneficiary_msg', 'تم ايقاف نشر ' . $row_num . ' بنجاح');
                    } else {
                        flash('beneficiary_msg', 'هناك خطأ ما يرجي المحاولة لاحقا', 'alert alert-danger');
                    }
                }
                redirect('beneficiaries');
            }
        }

        //handling search
        $searches = $this->beneficiaryModel->searchHandling(['full_name', 'identity', 'phone', 'family', 'district', 'city', 'nationality', 'gender', 'status'], $current);
        $cond .= $searches['cond'];
        $bind = $searches['bind'];
        // get all records count after search and filtration
        $recordsCount = $this->beneficiaryModel->allBeneficiariesCount($cond, $bind);
        //handling export
        if (isset($_POST['exportAll'])) {
            if ($recordsCount->count > 20000) {
                flash('beneficiary_msg', ' عدد النتائج اكثر من  20000 برجاء استخدام البحث لتقليل عدد النتائج', 'alert alert-danger');
                redirect('beneficiaries');
            }
            return $this->beneficiaryModel->exportAllBeneficiaries($cond, $bind);
        }
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
        //get all records for current beneficiary
        $beneficiaries = $this->beneficiaryModel->getBeneficiaries($cond, $bind, $limit, $bindLimit);

        $data = [
            'current' => $current,
            'perpage' => $perpage,
            'header' => '',
            'title' => 'المستفيدون',
            'beneficiaries' => $beneficiaries,
            'recordsCount' => $recordsCount->count,
            'footer' => '',
        ];
        $this->view('beneficiaries/index', $data);
    }

    /**
     * adding new beneficiary
     */
    public function add()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // sanitize POST array
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

            $data = [
                'page_title' => 'المستفيدون',
                'identity' => trim($_POST['identity']),
                'image' => '',
                'full_name' => trim($_POST['full_name']),
                'phone' => trim($_POST['phone']),
                'city' => trim($_POST['city']),
                'district' => trim($_POST['district']),
                'nationality' => trim($_POST['nationality']),
                'gender' => trim($_POST['gender']),
                'family' => trim($_POST['family']),
                'income' => trim($_POST['income']),
                'message' => trim($_POST['message']),
                'status' => '',
                'status_error' => '',
                'district_error' => '',
                'city_error' => '',
                'income_error' => '',
                'family_error' => '',
                'gender_error' => '',
                'nationality_error' => '',
                'identity_error' => '',
                'phone_error' => '',
                'message_error' => '',
                'full_name_error' => '',
                'image_error' => '',
            ];
            // validate identity
            !(empty($data['identity'])) ?: $data['identity_error'] = 'هذا الحقل مطلوب';
            // validate gender
            !(empty($data['gender'])) ?: $data['gender_error'] = 'هذا الحقل مطلوب';
            // validate family
            !(empty($data['family'])) ?: $data['family_error'] = 'هذا الحقل مطلوب';
            // validate income
            !(empty($data['income'])) ?: $data['income_error'] = 'هذا الحقل مطلوب';
            // validate phone
            !(empty($data['phone'])) ?: $data['phone_error'] = 'هذا الحقل مطلوب';
            // validate nationality
            !(empty($data['nationality'])) ?: $data['nationality_error'] = 'هذا الحقل مطلوب';
            // validate city
            !(empty($data['city'])) ?: $data['city_error'] = 'هذا الحقل مطلوب';
            // validate district
            !(empty($data['district'])) ?: $data['district_error'] = 'هذا الحقل مطلوب';
            // validate message
            !(empty($data['message'])) ?: $data['message_error'] = 'هذا الحقل مطلوب';
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
                $image = uploadImage('image', ADMINROOT . '/../media/files/beneficiaries/', 5000000, false);
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
                empty($data['status_error']) && empty($data['district_error']) && empty($data['message_error']) && empty($data['full_name_error']) && empty($data['income_error'])
                && empty($data['gender_error']) && empty($data['family_error']) && empty($data['phone_error']) && empty($data['city_error']) && empty($data['image_error'])
            ) {
                //validated
                if ($this->beneficiaryModel->addBeneficiary($data)) {
                    flash('beneficiary_msg', 'تم الحفظ بنجاح');
                    redirect('beneficiaries');
                } else {
                    flash('beneficiary_msg', 'هناك خطأ ما حاول مرة اخري', 'alert alert-danger');
                }
            } else {
                //load the view with error
                $this->view('beneficiaries/add', $data);
            }
        } else {
            $data = [
                'page_title' => 'المستفيدون',
                'identity' => '',
                'image' => '',
                'nationality' => '',
                'gender' => '',
                'family' => '',
                'income' => '',
                'district' => '',
                'message' => '',
                'full_name' => '',
                'phone' => '',
                'city' => '',
                'status' => 0,
                'status_error' => '',
                'district_error' => '',
                'city_error' => '',
                'income_error' => '',
                'family_error' => '',
                'gender_error' => '',
                'nationality_error' => '',
                'phone_error' => '',
                'identity_error' => '',
                'message_error' => '',
                'full_name_error' => '',
                'image_error' => '',
            ];
        }

        //loading the add beneficiary view
        $this->view('beneficiaries/add', $data);
    }

    /**
     * update beneficiary
     * @param integer $id
     */
    public function edit($id)
    {
        $id = (int) $id;
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // sanitize POST array
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

            $data = [
                'page_title' => 'المستفيدون',
                'beneficiary_id' => $id,
                'identity' => trim($_POST['identity']),
                'image' => '',
                'full_name' => trim($_POST['full_name']),
                'phone' => trim($_POST['phone']),
                'city' => trim($_POST['city']),
                'district' => trim($_POST['district']),
                'nationality' => trim($_POST['nationality']),
                'gender' => trim($_POST['gender']),
                'family' => trim($_POST['family']),
                'income' => trim($_POST['income']),
                'message' => trim($_POST['message']),
                'status' => '',
                'status_error' => '',
                'district_error' => '',
                'city_error' => '',
                'income_error' => '',
                'family_error' => '',
                'identity_error' => '',
                'gender_error' => '',
                'nationality_error' => '',
                'phone_error' => '',
                'message_error' => '',
                'full_name_error' => '',
                'image_error' => '',
            ];
            // validate gender
            !(empty($data['gender'])) ?: $data['gender_error'] = 'هذا الحقل مطلوب';
            // validate family
            !(empty($data['family'])) ?: $data['family_error'] = 'هذا الحقل مطلوب';
            // validate income
            !(empty($data['income'])) ?: $data['income_error'] = 'هذا الحقل مطلوب';
            // validate phone
            !(empty($data['phone'])) ?: $data['phone_error'] = 'هذا الحقل مطلوب';
            // validate nationality
            !(empty($data['nationality'])) ?: $data['nationality_error'] = 'هذا الحقل مطلوب';
            // validate city
            !(empty($data['city'])) ?: $data['city_error'] = 'هذا الحقل مطلوب';
            // validate district
            !(empty($data['district'])) ?: $data['district_error'] = 'هذا الحقل مطلوب';
            // validate message
            !(empty($data['message'])) ?: $data['message_error'] = 'هذا الحقل مطلوب';
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
                $image = uploadImage('image', ADMINROOT . '/../media/files/beneficiaries/', 5000000, false);
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
                empty($data['status_error']) && empty($data['district_error']) && empty($data['message_error']) && empty($data['full_name_error'])
                && empty($data['gender_error']) && empty($data['family_error']) && empty($data['phone_error']) && empty($data['city_error']) && empty($data['image_error'])
            ) {
                //validated
                if ($this->beneficiaryModel->updateBeneficiary($data)) {
                    flash('beneficiary_msg', 'تم التعديل بنجاح');
                    isset($_POST['save']) ? redirect('beneficiaries/edit/' . $id) : redirect('beneficiaries');
                } else {
                    flash('beneficiary_msg', 'هناك خطأ ما حاول مرة اخري', 'alert alert-danger');
                }
            } else {
                //load the view with error
                $this->view('beneficiaries/edit', $data);
            }
        } else {
            // featch beneficiary
            if (!$beneficiary = $this->beneficiaryModel->getBeneficiaryById($id)) {
                flash('beneficiary_msg', 'هناك خطأ ما هذه الصفحة غير موجوده او ربما اتبعت رابط خاطيء ', 'alert alert-danger');
                redirect('beneficiaries');
            }

            $data = [
                'page_title' => 'المستفيدون',
                'beneficiary_id' => $id,
                'district' => $beneficiary->district,
                'message' => $beneficiary->message,
                'full_name' => $beneficiary->full_name,
                'identity' => $beneficiary->identity,
                'image' => $beneficiary->image,
                'phone' => $beneficiary->phone,
                'city' => $beneficiary->city,
                'nationality' => $beneficiary->nationality,
                'gender' => $beneficiary->gender,
                'family' => $beneficiary->family,
                'income' => $beneficiary->income,
                'status' => $beneficiary->status,
                'status_error' => '',
                'district_error' => '',
                'city_error' => '',
                'income_error' => '',
                'family_error' => '',
                'identity_error' => '',
                'gender_error' => '',
                'nationality_error' => '',
                'phone_error' => '',
                'message_error' => '',
                'full_name_error' => '',
                'image_error' => '',
            ];
            $this->view('beneficiaries/edit', $data);
        }
    }

    /**
     * showing beneficiary details
     * @param integer $id
     */
    public function show($id)
    {
        if (!$beneficiary = $this->beneficiaryModel->getBeneficiaryById($id)) {
            flash('beneficiary_msg', 'هناك خطأ ما هذه الصفحة غير موجوده او ربما اتبعت رابط خاطيء ', 'alert alert-danger');
            redirect('beneficiaries');
        }
        $this->beneficiaryModel->publishById([$id], 'beneficiary_id');
        $data = [
            'page_title' => 'المستفيدون',
            'beneficiary' => $beneficiary,
        ];
        $this->view('beneficiaries/show', $data);
    }

    /**
     * delete record by id
     * @param integer $id
     */
    public function delete($id)
    {
        if ($row_num = $this->beneficiaryModel->deleteById([$id], 'beneficiary_id')) {
            flash('beneficiary_msg', 'تم حذف ' . $row_num . ' بنجاح');
        } else {
            flash('beneficiary_msg', 'لم يتم الحذف', 'alert alert-danger');
        }
        redirect('beneficiaries');
    }

    /**
     * publish record by id
     * @param integer $id
     */
    public function publish($id)
    {
        if ($row_num = $this->beneficiaryModel->publishById([$id], 'beneficiary_id')) {
            flash('beneficiary_msg', 'تم تعليم كا مقروءة ' . $row_num . ' بنجاح');
        } else {
            flash('beneficiary_msg', 'هناك خطأ ما يرجي المحاولة لاحقا', 'alert alert-danger');
        }
        redirect('beneficiaries');
    }

    /**
     * publish record by id
     * @param integer $id
     */
    public function unpublish($id)
    {
        if ($row_num = $this->beneficiaryModel->unpublishById([$id], 'beneficiary_id')) {
            flash('beneficiary_msg', 'تم تعليم كا غير مقروءة ' . $row_num . ' بنجاح');
        } else {
            flash('beneficiary_msg', 'هناك خطأ ما يرجي المحاولة لاحقا', 'alert alert-danger');
        }
        redirect('beneficiaries');
    }
}
