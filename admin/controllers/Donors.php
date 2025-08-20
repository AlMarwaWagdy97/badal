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

class Donors extends ControllerAdmin
{

    private $donorModel, $storeModel;

    //    private $donorModel;

    public function __construct()
    {
        $this->donorModel = $this->model('Donor');
        $this->storeModel = $this->model('Store');
    }

    /**
     * loading index view with latest donors
     */
    public function index($current = '', $perpage = 50)
    {
        // get donors
        $cond = 'WHERE donors.status <> 2 ';
        $bind = [];

        //check donor action if the form has submitted
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // sanitize POST array
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            //handling Delete
            if (isset($_POST['delete'])) {
                if (isset($_POST['record'])) {
                    if ($row_num = $this->donorModel->deleteById($_POST['record'], 'donor_id')) {
                        flash('donor_msg', 'تم حذف ' . $row_num . ' بنجاح');
                    } else {
                        flash('donor_msg', 'لم يتم الحذف', 'alert alert-danger');
                    }
                }
                redirect('donors');
            }

            //handling Publish
            if (isset($_POST['publish'])) {
                if (isset($_POST['record'])) {
                    if ($row_num = $this->donorModel->publishById($_POST['record'], 'donor_id')) {
                        flash('donor_msg', 'تم تفعيل المتبرع ' . $row_num . ' بنجاح');
                    } else {
                        flash('donor_msg', 'هناك خطأ ما يرجي المحاولة لاحقا', 'alert alert-danger');
                    }
                }
                redirect('donors');
            }

            //handling Unpublish
            if (isset($_POST['unpublish'])) {

                if (isset($_POST['record'])) {
                    if ($row_num = $this->donorModel->unpublishById($_POST['record'], 'donor_id')) {
                        flash('donor_msg', 'تم تعليق المتبرع ' . $row_num . ' بنجاح');
                    } else {
                        flash('donor_msg', 'هناك خطأ ما يرجي المحاولة لاحقا', 'alert alert-danger');
                    }
                }
                redirect('donors');
            }
        }
        //handling search
        $searches = $this->donorModel->searchHandling(['full_name', 'mobile', 'email', 'status'], $current);
        $cond .= $searches['cond'];
        $bind = $searches['bind'];

        // date search
        if (!empty($_POST['search']['date_from'])) {
            $cond .= ' AND donors.create_date >= ' . strtotime($_POST['search']['date_from']) . ' ';
        }
        if (!empty($_POST['search']['date_to'])) {
            $cond .= ' AND donors.create_date <= ' . strtotime($_POST['search']['date_to']) . ' ';
        }
        // if (!empty($_POST['search']['date_from'])) {
        //     $cond .= ' AND create_date >= :date_from ';
        //     $bind[':date_from'] = strtotime($_POST['search']['date_from']);
        // }
        // if (!empty($_POST['search']['date_to'])) {
        //     $cond .= ' AND create_date <= :date_to ';
        //     $bind[':date_to'] = strtotime($_POST['search']['date_to']) + 86400;
        // }

        // get all records count after search and filtration
        $recordsCount = $this->donorModel->allDonorsCount($cond, $bind);
        //handling export
        if (isset($_POST['exportAll'])) {
            if ($recordsCount->count > 20000) {
                flash('donor_msg', ' عدد النتائج اكثر من  20000 برجاء استخدام البحث لتقليل عدد النتائج', 'alert alert-danger');
                redirect('donors');
            }
            return $this->donorModel->exportAll($cond, $bind);
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
        //get all records for current donor
        $donors = $this->donorModel->getDonors($cond, $bind, $limit, $bindLimit);

        $data = [
            'current' => $current,
            'perpage' => $perpage,
            'header' => '',
            'title' => 'المتبرعين',
            'donors' => $donors,
            'recordsCount' => $recordsCount->count,
            'footer' => '',
        ];
        $this->view('donors/index', $data);
    }

    /**
     * adding new donor
     */
    public function add()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            // sanitize POST array
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $data = [
                'page_title' => 'المتبرعين',
                'full_name' => trim($_POST['full_name']),
                'email' => trim($_POST['email']),
                'mobile_confirmed' => trim($_POST['mobile_confirmed']),
                'mobile' => trim($_POST['mobile']),
                'identity' => trim($_POST['identity']),
                'status' => trim($_POST['status']),
                'full_name_error' => '',
                'mobile_error' => '',
                'identity_error' => '',
                'status_error' => '',
            ];
            // validate name
            if (empty($data['full_name'])) {
                $data['full_name_error'] = 'من فضلك اختار اسم للمتبرع';
            }
            // validate mobile
            if (empty($data['mobile'])) {
                $data['mobile_error'] = 'من فضلك اضف رقم جوال للمتبرع';
            }
            // validate identity
            if (empty($data['identity'])) {
                $data['identity_error'] = 'من فضلك اضف رقم الهوية للمتبرع';
            }
            // validate status
            if ($data['status'] == '') {
                $data['status_error'] = 'من فضلك اختار حالة المتبرع';
            }
            //make sure there is no errors
            if (empty($data['full_name_error']) && empty($data['status_error']) && empty($data['identity_error']) && empty($data['mobile_error'])) {
                //validated
                if ($this->donorModel->addDonor($data)) {
                    flash('donor_msg', 'تم الحفظ بنجاح');
                    redirect('donors');
                } else {
                    flash('donor_msg', 'هناك خطأ ما حاول مرة اخري', 'alert alert-danger');
                }
            }
            //load the view with error
            $this->view('donors/add', $data);
        } else {
            $data = [
                'page_title' => 'المتبرعين',
                'full_name' => '',
                'email' => '',
                'mobile' => '',
                'identity' => '',
                'mobile_confirmed' => 'no',
                'status' => '0',
                'identity_error' => '',
                'mobile_error' => '',
                'full_name_error' => '',
                'status_error' => '',
            ];
        }

        //loading the add donor view
        $this->view('donors/add', $data);
    }

    /**
     * update donor
     * @param integer $id
     */
    public function edit($id)
    {
        $id = (int) $id;
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            // sanitize POST array
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $data = [
                'donor_id' => $id,
                'page_title' => 'المتبرعين',
                'full_name' => trim($_POST['full_name']),
                'email' => trim($_POST['email']),
                'mobile_confirmed' => trim($_POST['mobile_confirmed']),
                'mobile' => trim($_POST['mobile']),
                'identity' => trim($_POST['identity']),
                'status' => trim($_POST['status']),
                'store_id' => trim($_POST['store_id']),
                'stores' => $this->storeModel->getStores(),
                'full_name_error' => '',
                'mobile_error' => '',
                'status_error' => '',
                'identity_error' => '',
            ];
            // validate name
            if (empty($data['full_name'])) {
                $data['full_name_error'] = 'من فضلك اختار اسم للمتبرع';
            }
            // validate mobile
            if (empty($data['mobile'])) {
                $data['mobile_error'] = 'من فضلك اضف رقم جوال للمتبرع';
            }
            // validate status
            if ($data['status'] == '') {
                $data['status_error'] = 'من فضلك اختار حالة المتبرع';
            }
             // validate identity
             if (empty($data['identity'])) {
                $data['identity_error'] = 'من فضلك اضف رقم الهوية للمتبرع';
            }
            //make sure there is no errors
            if (empty($data['full_name_error']) && empty($data['mobile_error']) && empty($data['identity_error']) && empty($data['status_error'])) {
                //validated
                if ($this->donorModel->updateDonor($data)) {
                    flash('donor_msg', 'تم التعديل بنجاح');
                    isset($_POST['save']) ? redirect('donors/edit/' . $id) : redirect('donors');
                } else {
                    flash('donor_msg', 'هناك خطأ ما حاول مرة اخري', 'alert alert-danger');
                }
            } else {
                //load the view with error
                $this->view('donors/edit', $data);
            }
        } else {
            // featch donors
            if (!$donor = $this->donorModel->getDonorById($id)) {
                flash('donor_msg', 'هناك خطأ ما هذه الصفحة غير موجوده او ربما اتبعت رابط خاطيء ', 'alert alert-danger');
                redirect('donors');
            }

            $data = [
                'donor_id' => $id,
                'page_title' => 'المتبرعين',
                'full_name' => $donor->full_name,
                'email' => $donor->email,
                'mobile' => $donor->mobile,
                'identity' => $donor->identity,
                'store_id' => $donor->store_id,
                'status' => $donor->status,
                'mobile_confirmed' => $donor->mobile_confirmed,
                'stores' => $this->storeModel->getStores(),
                'full_name_error' => '',
                'mobile_error' => '',
                'identity_error' => '',
                'status_error' => '',
            ];
            $this->view('donors/edit', $data);
        }
    }

    /**
     * showing donor details
     * @param integer $id
     */
    public function show($id)
    {
        if (!$donor = $this->donorModel->getDonorById($id)) {
            flash('donor_msg', 'هناك خطأ ما هذه الصفحة غير موجوده او ربما اتبعت رابط خاطيء ', 'alert alert-danger');
            redirect('donors');
        }
        $data = [
            'donor_id' => $id,
            'page_title' => 'المتبرعين',
            'donor' => $donor,
            'donations' => $this->donorModel->getDonerDonations($id),
        ];
        $this->view('donors/show', $data);
    }

    /**
     * delete record by id
     * @param integer $id
     */
    public function delete($id)
    {
        if ($row_num = $this->donorModel->deleteById([$id], 'donor_id')) {
            flash('donor_msg', 'تم حذف ' . $row_num . ' بنجاح');
        } else {
            flash('donor_msg', 'لم يتم الحذف', 'alert alert-danger');
        }
        redirect('donors');
    }

    /**
     * publish record by id
     * @param integer $id
     */
    public function publish($id)
    {
        if ($row_num = $this->donorModel->publishById([$id], 'donor_id')) {
            flash('donor_msg', 'تم نشر ' . $row_num . ' بنجاح');
        } else {
            flash('donor_msg', 'هناك خطأ ما يرجي المحاولة لاحقا', 'alert alert-danger');
        }
        redirect('donors');
    }

    /**
     * publish record by id
     * @param integer $id
     */
    public function unpublish($id)
    {
        if ($row_num = $this->donorModel->unpublishById([$id], 'donor_id')) {
            flash('donor_msg', 'تم ايقاف نشر ' . $row_num . ' بنجاح');
        } else {
            flash('donor_msg', 'هناك خطأ ما يرجي المحاولة لاحقا', 'alert alert-danger');
        }
        redirect('donors');
    }

    /**
     * handling donor login and create donor session
     */
    public function login()
    {
        //check for post
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            //init data
            $data = [
                'email' => trim($_POST['email']),
                'password' => trim($_POST['password']),
                'email_error' => '',
                'password_error' => '',
            ];
            //validate email
            if (empty($data['email'])) {
                $data['email_error'] = 'لا يمكن ترك حقل البريد خاليا ';
            } elseif (!$this->donorModel->findDonorByEmail($data['email'])) {
                $data['email_error'] = 'هذ البريد ليس مسجل لدينا';
            }
            //validate password
            if (empty($data['password'])) {
                $data['password_error'] = 'لا يمكن ترك حقل كلمة المرور خاليا';
            }
            if (empty($data['email_error']) && empty($data['password_error'])) {
                // validated
                //check and login donor
                $loggedInDonor = $this->donorModel->login($data['email'], $data['password']);
                if ($loggedInDonor) {
                    //create session and setup the donor premissions
                    $this->donorModel->createDonorSession($loggedInDonor);
                    // redirect donor to dashboard
                    redirect('dashboard');
                } else {
                    $data['password_error'] = 'كلمة المرور غير صحيحة';
                    $this->view('donors/login', $data);
                }
            } else {

                $this->view('donors/login', $data);
            }
        } else {
            //init data
            $data = [
                'email' => '',
                'password' => '',
                'email_error' => '',
                'password_error' => '',
            ];
            //load view
            $this->view('donors/login', $data);
        }
    }

    /**
     * handling donor password restor through sending email activation
     */
    public function forget()
    {
        //check for post
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            //init data
            $data = [
                'email' => trim($_POST['email']),
                'email_error' => '',
            ];
            //validate email
            if (empty($data['email'])) {
                $data['email_error'] = 'لا يمكن ترك حقل البريد خاليا ';
            } elseif (!$this->donorModel->findDonorByEmail($data['email'])) {
                $data['email_error'] = 'هذ البريد ليس مسجل لدينا';
            }
            if (empty($data['email_error'])) {
                // validated
                $this->donorModel->forget($data['email']);
                flash('donor_msg', 'تم ارسال رابط تفعيل الحساب علي البريد المسجل لدينا ');
                redirect('donors/forget');
            } else {
                $this->view('donors/forget', $data);
            }
        } else {
            //init data
            $data = [
                'email' => '',
                'email_error' => '',
            ];
            //load view
            $this->view('donors/forget', $data);
        }
    }

    /**
     * logging donor out and clean session data
     */
    public function logout()
    {
        logout();
        redirect('donors/login');
    }

    /**
     * reset donor password
     * @param string $code
     */
    public function reset($code)
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

            ///password validation and reset and redirect to login
            $data = [
                'code' => $code,
                'password' => trim($_POST['password']),
                'password_repeat' => trim($_POST['password_repeat']),
                'password_error' => '',
                'password_repeat_error' => '',
            ];
            // Validate Password
            if (empty($data['password'])) {
                $data['password_error'] = 'من فضلك قم بأدخال كلمة مرور مناسبة';
            } elseif (strlen($data['password']) < 6) {
                $data['password_error'] = 'كلمة المرور لا يجب ان تكون اقل من 6 احرف';
            }
            if (empty($data['password_repeat'])) {
                $data['password_repeat_error'] = 'من فضلك قم بأعادة كتابة كلمة المرور ';
            } elseif ($data['password'] != $data['password_repeat']) {
                $data['password_repeat_error'] = 'من فضلك اعد كتابة كلمة المرور بشكل صحيح';
            }

            //make sure there is no errors
            if (empty($data['password_error']) && empty($data['password_repeat_error'])) {
                // Hash Password
                $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
                //validated
                if ($this->donorModel->updatePassword($data['password'], $code)) {
                    flash('donor_msg', 'تم تحديث كلمة المرور بنجاح ');
                    redirect('donors/login');
                } else {
                    flash('donor_msg', 'هناك خطأ ما حاول مرة اخري', 'alert alert-danger');
                    redirect('donors/reset/' . $code);
                }
            }
            $this->view('donors/reset', $data);
        } else {
            //if donor click on the activation code
            if (!empty($code)) {
                if ($this->donorModel->checkCodeValidation($code)) {
                    flash('donor_msg', 'تم تأكيد البريد الخاص بك قم بأدخال كلمة المرور الجديده للتمكن من الدخول الي حسابك');
                    $data = [
                        'code' => $code,
                        'password' => '',
                        'password_repeat' => '',
                        'password_error' => '',
                        'password_repeat_error' => '',
                    ];
                    $this->view('donors/reset', $data);
                } else {
                    flash('donor_msg', 'عذرا لقد انتهت صلاحية هذا الرابط ', 'alert alert-danger');
                    redirect('donors/login');
                }
            } else {
                redirect('donors/login');
            }
        }
    }

    /**
     * loading error view if donor has no premission
     */
    public function error()
    {
        //init data
        $data = [];
        //load view
        $this->view('donors/error', $data);
    }
}
