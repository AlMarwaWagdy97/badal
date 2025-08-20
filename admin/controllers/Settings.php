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

class Settings extends ControllerAdmin
{

    private $settingModel;

    public function __construct()
    {
        $this->settingModel = $this->model('Setting');
    }

    /**
     * loading index view with latest settings
     */
    public function index()
    {
        $settings = $this->settingModel->getsettings();
        $data = [
            'title' => 'الأعدادات',
            'settings' => $settings,
        ];
        $this->view('settings/index', $data);
    }

    /**
     * update setting
     * @param integer $id
     */
    public function edit($id)
    {
        $id = (int) $id;

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if (isset($_POST['value']['thankyou'])) $thankyou = $this->settingModel->cleanHTML($_POST['value']['thankyou']);
            if (isset($_POST['value']['volunteerContent'])) $volunteerContent = $this->settingModel->cleanHTML($_POST['value']['volunteerContent']);
            if (isset($_POST['value']['beneficiaryContent'])) $beneficiaryContent = $this->settingModel->cleanHTML($_POST['value']['beneficiaryContent']);
            if (isset($_POST['value']['inkindContent'])) $inkindContent = $this->settingModel->cleanHTML($_POST['value']['inkindContent']);
            if (isset($_POST['value']['header_code'])) $header_code = ($_POST['value']['header_code']);
            if (isset($_POST['value']['footer_code'])) $footer_code = ($_POST['value']['footer_code']);
            // sanitize POST array
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            if (isset($_POST['value']['thankyou'])) $_POST['value']['thankyou'] = $thankyou;
            if (isset($_POST['value']['volunteerContent'])) $_POST['value']['volunteerContent'] = $volunteerContent;
            if (isset($_POST['value']['beneficiaryContent'])) $_POST['value']['beneficiaryContent'] = $beneficiaryContent;
            if (isset($_POST['value']['inkindContent'])) $_POST['value']['inkindContent'] = $inkindContent;
            if (isset($_POST['value']['header_code'])) $_POST['value']['header_code'] = $header_code;
            if (isset($_POST['value']['footer_code'])) $_POST['value']['footer_code'] = $footer_code;
            if (isset($_POST['value']['campaign_description'])) $_POST['value']['campaign_description'] = (html_entity_decode( ( $_POST['value']['campaign_description'] ) ));
            if (isset($_POST['value']['campaign_projects'])) $_POST['value']['campaign_projects'] = json_encode(array_keys($_POST['value']['campaign_projects']));
            if (isset($_POST['value']['projects'])) $_POST['value']['projects'] = json_encode(array_keys($_POST['value']['projects']));
            if (isset($_POST['value']['badal_selected_projects'])) $_POST['value']['badal_selected_projects'] = json_encode(array_keys($_POST['value']['badal_selected_projects']));
            
          
            if (isset($_FILES['new_campaign_image'])){
                $image = uploadImage('new_campaign_image', APPROOT . '/media/files/deceased/', 2048000);
                if (empty($image['error'])) {
                    $_POST['value']['campaign_image'] = $image['filename'];
                } else {
                    if (!isset($image['error']['nofile'])) {
                        $_POST['value']['campaign_image'] = implode(',', $image['error']);
                    }
                }
            }
              if (isset($_FILES['new_license_img'])){
                $image = uploadImage('new_license_img', APPROOT . '/media/files/badal/', 2048000);
                if (empty($image['error'])) {
                    $_POST['value']['license_img'] = $image['filename'];
                } else {
                    if (!isset($image['error']['nofile'])) {
                        $_POST['value']['license_img'] = implode(',', $image['error']);
                    }
                }
            }
            if (isset($_FILES['new_haij_icon'])){
                $image = uploadImage('new_haij_icon', APPROOT . '/media/files/badal/', 2048000);
                if (empty($image['error'])) {
                    $_POST['value']['haij_icon'] = $image['filename'];
                } else {
                    if (!isset($image['error']['nofile'])) {
                        $_POST['value']['haij_icon'] = implode(',', $image['error']);
                    }
                }
            }
            if (isset($_FILES['new_umrah_icon'])){
                $image = uploadImage('new_umrah_icon', APPROOT . '/media/files/badal/', 2048000);
                if (empty($image['error'])) {
                    $_POST['value']['umrah_icon'] = $image['filename'];
                } else {
                    if (!isset($image['error']['nofile'])) {
                        $_POST['value']['umrah_icon'] = implode(',', $image['error']);
                    }
                }
            }

            if (isset($_FILES['new_haij_image'])){
                $image = uploadImage('new_haij_image', APPROOT . '/media/files/badal/', 2048000);
                if (empty($image['error'])) {
                    $_POST['value']['haij_image'] = $image['filename'];
                } else {
                    if (!isset($image['error']['nofile'])) {
                        $_POST['value']['haij_image'] = implode(',', $image['error']);
                    }
                }
            }
            if (isset($_FILES['new_umrah_image'])){
                $image = uploadImage('new_umrah_image', APPROOT . '/media/files/badal/', 2048000);
                if (empty($image['error'])) {
                    $_POST['value']['umrah_image'] = $image['filename'];
                } else {
                    if (!isset($image['error']['nofile'])) {
                        $_POST['value']['umrah_image'] = implode(',', $image['error']);
                    }
                }
            }

            // start save images in eladha --------------------------------------------------
            if($id == 17 || $id == 19 || $id == 20){
                if (isset($_FILES['new_logo'])){
                    $image = uploadImage('new_logo', APPROOT . '/media/files/eladha/', 2048000);
                    if (empty($image['error'])) {
                        $_POST['value']['logo'] =  $image['filename'];
                    } else {
                        if (!isset($image['error']['nofile'])) {
                            $_POST['value']['logo'] = implode(',', $image['error']);
                        }
                    }
                }
                if(isset($_POST['value']['tracking'])){
                    foreach($_POST['value']['tracking']['name'] as $key => $track){
                        if (isset($_FILES['tracking_logo_'. $key])){
                            $image = uploadImage('tracking_logo_'.$key, APPROOT . '/media/files/eladha/', 20971520);
                            if (empty($image['error'])) {
                                $_POST['value']['tracking']['logo'][$key] = $image['filename'];
                            } else {
                                if (!isset($image['error']['nofile'])) {
                                    $_POST['value']['tracking']['logo'][$key] = implode(',', $image['error']);
                                }
                            }
                        }
                        
                        if (isset($_FILES['tracking_video_'. $key])){
                            $image = uploadImage('tracking_video_'.$key, APPROOT . '/media/files/eladha/', 20971520, false);
                            if (empty($image['error'])) {
                                $_POST['value']['tracking']['video'][$key] = $image['filename'];
                            } else {
                                if (!isset($image['error']['nofile'])) {
                                    $_POST['value']['tracking']['video'][$key] = implode(',', $image['error']);
                                }
                            }
                        }
                    }
                }

            }
            // end save images in eladha ----------------------------------------------------
          
            
            // validate images
            $data = [
                'setting_id' => $id,
                'page_title' => 'الأعدادات',
                'title' => trim($_POST['title']),
                'value' => $_POST['value'],
                'title_error' => '',
                'value_error' => '',
            ];
            // validate name
            if (empty($data['title'])) {
                $data['title_error'] = 'من فضلك قم بكتابة عنوان الاعدادات';
            }
            //make sue there is no errors
            if (empty($data['title_error']) && empty($data['value_error'])) {
                //encode values
                $data['value'] = json_encode($_POST['value']);
                //validated
                if ($this->settingModel->updateSetting($data)) {
                    flash('setting_msg', 'تم التعديل بنجاح');
                    isset($_POST['save']) ? redirect('settings/edit/' . $id) : redirect('settings');
                } else {
                    flash('setting_msg', $data['value_error'], 'alert alert-danger');
                }
            }
        } else {
            // featch setting
            if (!$setting = $this->settingModel->getSettingById($id)) {
                flash('setting_msg', 'هناك خطأ ما هذه الأعدادات غير موجوده او ربما اتبعت رابط خاطيء ', 'alert alert-danger');
                redirect('settings');
            }

            $data = [
                'page_title' => 'الأعدادات',
                'setting_id' => $id,
                'title' => $setting->title,
                'value' => @json_decode($setting->value),
                'title_error' => '',
                'value_error' => '',
            ];
        }
        switch ($id) {
            case '1':
                $this->view('settings/site', $data);
                break;
            case '2':
                $this->view('settings/contact', $data);
                break;
            case '3':
                $this->view('settings/seo', $data);
                break;
            case '4':
                $this->view('settings/social', $data);
                break;
            case '5':
                $this->view('settings/email', $data);
                break;
            case '6':
                $this->view('settings/sms', $data);
                break;
            case '7':
                $this->view('settings/theme', $data);
                break;
            case '8':
                $this->view('settings/gift', $data);
                break;
            case '9':
                $this->view('settings/api', $data);
                break;
            case '10':
                $this->view('settings/notifications', $data);
                break;
            case '11':
                $this->view('settings/app', $data);
                break;
            case '12':
                $this->view('settings/whatsapp', $data);
                break;
            case '13':
                $this->view('settings/volunteering', $data);
                break;
            case '14':
                $data['projects'] = $this->model('Project')->getProjectsActive();
                $this->view('settings/deceased', $data);
                break;
            case '15':
                $data['projects'] = $this->model('Project')->getProjectsActive();
                $this->view('settings/badal', $data);
                break;
            case '16':
                $this->view('settings/badalNotifications', $data);
                break;
            case '17':
                $this->view('settings/eladha', $data);
                break;
            case '18':
                $data['projects'] = $this->model('Project')->getProjectsActive();
                $this->view('settings/specialMessages', $data);
                break;
            case '19':
                $this->view('settings/eladha_2', $data);
                break;
            case '20':
                $this->view('settings/eladha_3', $data);
                break;
            default:
                redirect('settings');
                break;
        }
    }
}
