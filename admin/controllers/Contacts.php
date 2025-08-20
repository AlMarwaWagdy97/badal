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

class Contacts extends ControllerAdmin
{

    private $contactModel;

    public function __construct()
    {
        $this->contactModel = $this->model('Contact');
    }

    /**
     * loading index view with latest contacts
     */
    public function index($current = '', $perpage = 50)
    {
        // get contacts
        $cond = 'WHERE status <> 2 ';
        $bind = [];

        //check user action if the form has submitted
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // sanitize POST array
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

            //handling Delete
            if (isset($_POST['delete'])) {
                if (isset($_POST['record'])) {
                    if ($row_num = $this->contactModel->deleteById($_POST['record'], 'contact_id')) {
                        flash('contact_msg', 'تم حذف ' . $row_num . ' بنجاح');
                    } else {
                        flash('contact_msg', 'لم يتم الحذف', 'alert alert-danger');
                    }
                }

                redirect('contacts');
            }

            //handling Publish
            if (isset($_POST['publish'])) {
                if (isset($_POST['record'])) {
                    if ($row_num = $this->contactModel->publishById($_POST['record'], 'contact_id')) {
                        flash('contact_msg', 'تم نشر ' . $row_num . ' بنجاح');
                    } else {
                        flash('contact_msg', 'هناك خطأ ما يرجي المحاولة لاحقا', 'alert alert-danger');
                    }
                }
                redirect('contacts');
            }

            //handling Unpublish
            if (isset($_POST['unpublish'])) {

                if (isset($_POST['record'])) {
                    if ($row_num = $this->contactModel->unpublishById($_POST['record'], 'contact_id')) {
                        flash('contact_msg', 'تم ايقاف نشر ' . $row_num . ' بنجاح');
                    } else {
                        flash('contact_msg', 'هناك خطأ ما يرجي المحاولة لاحقا', 'alert alert-danger');
                    }
                }
                redirect('contacts');
            }
        }

        //handling search
        $searches = $this->contactModel->searchHandling(['subject', 'full_name', 'city', 'email', 'phone', 'type', 'status'], $current);
        $cond .= $searches['cond'];
        $bind = $searches['bind'];

        // get all records count after search and filtration
        $recordsCount = $this->contactModel->allContactsCount($cond, $bind);
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
        //get all records for current contact
        $contacts = $this->contactModel->getContacts($cond, $bind, $limit, $bindLimit);

        $data = [
            'current' => $current,
            'perpage' => $perpage,
            'header' => '',
            'title' => 'رسائل التواصل',
            'contacts' => $contacts,
            'recordsCount' => $recordsCount->count,
            'footer' => '',
        ];
        $this->view('contacts/index', $data);
    }

    /**
     * adding new contact
     */
    public function add()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // sanitize POST array
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

            $data = [
                'page_title' => 'رسائل التواصل',
                'subject' => trim($_POST['subject']),
                'message' => trim($_POST['message']),
                'full_name' => trim($_POST['full_name']),
                'city' => trim($_POST['city']),
                'email' => trim($_POST['email']),
                'phone' => trim($_POST['phone']),
                'type' => trim($_POST['type']),
                'types' => ['شكوي', 'طلب', 'اقتراح', 'استفسار'],
                'status' => '',
                'status_error' => '',
                'subject_error' => '',
                'message_error' => '',
                'full_name_error' => '',
            ];
            // validate subject
            !(empty($data['subject'])) ?: $data['subject_error'] = 'هذا الحقل مطلوب';
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
            //make sure there is no errors
            if (empty($data['status_error']) && empty($data['subject_error']) && empty($data['message_error']) && empty($data['full_name_error'])) {
                //validated
                if ($this->contactModel->addContact($data)) {
                    flash('contact_msg', 'تم الحفظ بنجاح');
                    redirect('contacts');
                } else {
                    flash('contact_msg', 'هناك خطأ ما حاول مرة اخري', 'alert alert-danger');
                }
            } else {
                //load the view with error
                $this->view('contacts/add', $data);
            }
        } else {
            $data = [
                'page_title' => 'رسائل التواصل',
                'subject' => '',
                'message' => '',
                'full_name' => '',
                'city' => '',
                'email' => '',
                'phone' => '',
                'types' => ['شكوي', 'طلب', 'اقتراح', 'استفسار'],
                'type' => '',
                'status' => 0,
                'status_error' => '',
                'subject_error' => '',
                'message_error' => '',
                'full_name_error' => '',
            ];
        }

        //loading the add contact view
        $this->view('contacts/add', $data);
    }

    /**
     * update contact
     * @param integer $id
     */
    public function edit($id)
    {
        $id = (int) $id;
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // sanitize POST array
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

            $data = [
                'contact_id' => $id,
                'page_title' => 'رسائل التواصل',
                'subject' => trim($_POST['subject']),
                'message' => trim($_POST['message']),
                'full_name' => trim($_POST['full_name']),
                'city' => trim($_POST['city']),
                'email' => trim($_POST['email']),
                'phone' => trim($_POST['phone']),
                'type' => trim($_POST['type']),
                'types' => ['شكوي', 'طلب', 'اقتراح', 'استفسار'],
                'status' => '',
                'status_error' => '',
                'subject_error' => '',
                'message_error' => '',
                'full_name_error' => '',
            ];
            
            // validate subject
            !(empty($data['subject'])) ?: $data['subject_error'] = 'هذا الحقل مطلوب';
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
            // make sure there is no errors
            if (empty($data['status_error']) && empty($data['subject_error']) && empty($data['message_error']) && empty($data['full_name_error'])) {
                //validated
                if ($this->contactModel->updateContact($data)) {
                    flash('contact_msg', 'تم التعديل بنجاح');
                    isset($_POST['save']) ? redirect('contacts/edit/' . $id) : redirect('contacts');
                } else {
                    flash('contact_msg', 'هناك خطأ ما حاول مرة اخري', 'alert alert-danger');
                }
            } else {
                //load the view with error
                $this->view('contacts/edit', $data);
            }
        } else {
            // featch contact
            if (!$contact = $this->contactModel->getContactById($id)) {
                flash('contact_msg', 'هناك خطأ ما هذه الصفحة غير موجوده او ربما اتبعت رابط خاطيء ', 'alert alert-danger');
                redirect('contacts');
            }

            $data = [
                'page_title' => 'رسائل التواصل',
                'contact_id' => $id,
                'subject' => $contact->subject,
                'message' => $contact->message,
                'full_name' => $contact->full_name,
                'city' => $contact->city,
                'email' => $contact->email,
                'phone' => $contact->phone,
                'types' => ['شكوي', 'طلب', 'اقتراح', 'استفسار'],
                'type' => $contact->type,
                'status' => $contact->status,
                'status_error' => '',
                'subject_error' => '',
                'message_error' => '',
                'full_name_error' => '',
            ];
            $this->view('contacts/edit', $data);
        }
    }

    /**
     * showing contact details
     * @param integer $id
     */
    public function show($id)
    {
        if (!$contact = $this->contactModel->getContactById($id)) {
            flash('contact_msg', 'هناك خطأ ما هذه الصفحة غير موجوده او ربما اتبعت رابط خاطيء ', 'alert alert-danger');
            redirect('contacts');
        }
        $this->contactModel->publishById([$id], 'contact_id');
        $data = [
            'page_title' => 'رسائل التواصل',
            'contact' => $contact,
        ];
        $this->view('contacts/show', $data);
    }

    /**
     * delete record by id
     * @param integer $id
     */
    public function delete($id)
    {
        if ($row_num = $this->contactModel->deleteById([$id], 'contact_id')) {
            flash('contact_msg', 'تم حذف ' . $row_num . ' بنجاح');
        } else {
            flash('contact_msg', 'لم يتم الحذف', 'alert alert-danger');
        }
        redirect('contacts');
    }

    /**
     * publish record by id
     * @param integer $id
     */
    public function publish($id)
    {
        if ($row_num = $this->contactModel->publishById([$id], 'contact_id')) {
            flash('contact_msg', 'تم تعليم كا مقروءة ' . $row_num . ' بنجاح');
        } else {
            flash('contact_msg', 'هناك خطأ ما يرجي المحاولة لاحقا', 'alert alert-danger');
        }
        redirect('contacts');
    }

    /**
     * publish record by id
     * @param integer $id
     */
    public function unpublish($id)
    {
        if ($row_num = $this->contactModel->unpublishById([$id], 'contact_id')) {
            flash('contact_msg', 'تم تعليم كا غير مقروءة ' . $row_num . ' بنجاح');
        } else {
            flash('contact_msg', 'هناك خطأ ما يرجي المحاولة لاحقا', 'alert alert-danger');
        }
        redirect('contacts');
    }

}
