<?php

class Volunteering extends Controller
{
    private $volunteerpages;
    private $pagesModel;
    public $settings;
    public $menu;

    public function __construct()
    {
        $this->volunteerpages = $this->model('Volunteerpage');
        $this->pagesModel = $this->model('Page');
        $this->menu = $this->pagesModel->getMenu();
        $this->settings = $this->pagesModel->getSettings();
    }


    /**
     * volunteering Hours page
     *
     * @return view
     */
    public function page($id)
    {

        if (!$volunteerpage = $this->volunteerpages->getSingle('*', ['volunteerpage_id' => $id])) {
            flashRedirect('', 'msg', 'هذه الصفحة غير موجودة ربما اتبعت رابط خاطئ', 'alert alert-danger');
        }
        $data = [
            'pageTitle' => $volunteerpage->title,
            'settings' => $this->settings,
            'menu' => $this->menu,
            'volunteerpage' => $volunteerpage,
        ];

        $data['settings']['site']->title = $data['pageTitle'];
        $data['settings']['site']->image = $volunteerpage->image;
        $data['settings']['seo']->meta_description = substr(strip_tags($volunteerpage->content), 0, 300);
        //loading view
        $this->view('volunteering/page', $data);
    }

    /**
     * volunteering Hours form
     *
     * @return view
     */
    public function show($id)
    {

        if (!$volunteerpage = $this->volunteerpages->getSingle('*', ['volunteerpage_id' => $id])) {
            flashRedirect('', 'msg', 'هذه الصفحة غير موجودة ربما اتبعت رابط خاطئ', 'alert alert-danger');
        }
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $data = [
                'pageTitle' => 'ساعات التطوع',
                'settings' => $this->settings,
                'menu' => $this->menu,
                'volunteerpage' => $volunteerpage,
                'identity' => trim($_POST['identity']),
                'full_name' => trim($_POST['full_name']),
                'phone' => trim($_POST['phone']),
                'email' => trim($_POST['email']),
                'otp' => rand(1000, 9999),
                'identity_error' => '',
                'full_name_error' => '',
                'phone_error' => '',
                'email_error' => '',
                'captcha_error' => '',
            ];
            // validate identity
            !(empty($data['identity']) || (strlen($data['phone']) < 10)) ?: $data['identity_error'] = 'هذا الحقل مطلوب. يجب ان يكون مكون من 10 ارقام مثال (1234567890)';
            // validate full_name
            !(empty($data['full_name'])) ?: $data['full_name_error'] = 'هذا الحقل مطلوب';
            // validate phone
            !(empty($data['phone']) || (strlen($data['phone']) < 10)) ?: $data['phone_error'] = 'هذا الحقل مطلوب. يجب ان يكون مكون من 10 ارقام مثال (050123456789)';
            // validate email
            !(empty($data['email'])) ?: $data['email_error'] = 'هذا الحقل مطلوب';
            // validate captcha
            recaptcha() ?: $data['captcha_error'] = 'خطأ بكود التحقق ';
            //make sure there is no errors
            if (empty($data['identity_error']) && empty($data['full_name_error']) && empty($data['email_error']) && empty($data['phone_error']) && empty($data['captcha_error'])) {
                //validated
                if ($id = $this->volunteerpages->addVolunteering($data)) {
                    if (!empty($data['settings']['volunteering']->email)) { //send notification
                        $msg = arrayLines($_POST);
                        $this->volunteerpages->SMS($data['phone'], 'جمعية ماء الاهلية كود التحقق الخاص بك : ' . $data['otp']);
                        if ($data['settings']['volunteering']->notify) {
                            $this->volunteerpages->Email($data['settings']['volunteering']->email, ': اشعار حول طلب تسجيل ساعات تطوع جديد ', $msg);
                        }
                    }
                    flash('msg', 'من فضلك قم بتأكيد رقم الجوال');
                    redirect('volunteering/otp/' . $id, true);
                } else {
                    flash('msg', 'هناك خطأ ما حاول مرة اخري', 'alert alert-danger');
                }
            }
        } else {
            $data = [
                'pageTitle' => 'ساعات التطوع',
                'settings' => $this->settings,
                'menu' => $this->menu,
                'volunteerpage' => $volunteerpage,
                'identity' => '',
                'full_name' => '',
                'phone' => '',
                'email' => '',
                'identity_error' => '',
                'full_name_error' => '',
                'phone_error' => '',
                'email_error' => '',
                'captcha_error' => '',
            ];
        }
        $data['settings']['site']->title = $data['pageTitle'];
        //loading view
        $this->view('volunteering/show', $data);
    }

    /**
     * volunteering page otp confirmation pages
     *
     * @param int $id
     * @return view
     */
    public function otp($id)
    {
        $id = (int) $id;
        empty($id) ? redirect('/', true) : null;
        ($this->volunteerpages->getSingle('*', ['volunteering_id' => $id, 'status' => 0], 'volunteering')) ?: flashRedirect('index', 'msg', ' هذه الصفحة غير موجوده او ربما تم حذفها ');

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $data = [
                'pageTitle' => 'رسالة تأكيد الجوال',
                'settings' => $this->settings,
                'menu' => $this->menu,
                'otp' => $_POST['otp'],
                'otp_error' => '',
                'id' => $id,
            ];
            // validate otp
            !(empty($data['otp'])) ?: $data['otp_error'] = 'هذا الحقل مطلوب';
            if (empty($data['otp_error'])) {
                //validated
                if ($this->volunteerpages->countAll(['otp' => $data['otp'], 'volunteering_id' => $id], 'volunteering')->count > 0) {
                    $this->volunteerpages->updateVolunteering($id);
                    flash('msg', 'من فضلك قم بمشاركة الرابط التالي للحصول علي ساعات التطوع');
                    redirect('volunteering/otpshare/' . $id, true);
                } else {
                    flash('msg', 'خطأ في كود التحقق', 'alert alert-info');
                }
            }
        } else {
            $data = [
                'pageTitle' => 'رسالة تأكيد الجوال',
                'settings' => $this->settings,
                'menu' => $this->menu,
                'otp' => '',
                'otp_error' => '',
                'id' => $id,
            ];
        }
        //loading view
        $this->view('volunteering/otp', $data);
    }
    /**
     * volunteering share icons page 
     *
     * @param int $id
     * @return view
     */

    public function otpshare($id)
    {
        $id = (int) $id;

        ($this->volunteerpages->getSingle('*', ['volunteering_id' => $id, 'status' => 1], 'volunteering')) ?: flashRedirect('index', 'msg', ' هذه الصفحة غير موجوده او ربما تم حذفها ');
        $data = [
            'pageTitle' => 'التأكيد والمشاركة',
            'settings' => $this->settings,
            'menu' => $this->menu,
            'id' => $id,
        ];
        $this->view('volunteering/otpshare', $data);
    }
    /**
     * confirm share 
     *
     * @param int $id
     * @return response
     */
    public function share($id, $chanel)
    {
        $id = (int) $id;
        empty($id) ? die('') : null;
        $this->volunteerpages->updateVolunteeringShare($id, $chanel);
    }

    /**
     * count share times
     *
     * @param int $id
     * @return response
     */
    public function sharing($id)
    {

        $id = (int) $id;
        empty($id) ? die('') : null;
        ($volunteering = $this->volunteerpages->getSingle('*', ['volunteering_id' => $id], 'volunteering')) ?: flashRedirect('index', 'msg', ' هذه الصفحة غير موجوده او ربما تم حذفها ');
        $this->volunteerpages->updatecount($id);
        $volunteerpage = $this->volunteerpages->getSingle('*', ['volunteerpage_id' => $volunteering->volunteerpage_id]);
        $data = [
            'pageTitle' => $volunteerpage->title,
            'settings' => $this->settings,
            'menu' => $this->menu,
            'volunteerpage' => $volunteerpage,
        ];
        $data['settings']['site']->title = $data['pageTitle'];
        $data['settings']['site']->image = $volunteerpage->image;
        $data['settings']['seo']->meta_description = substr(strip_tags($volunteerpage->content), 0, 300);
        //loading view
        $this->view('volunteering/page', $data);
    }



    /**
     * thankyou page 
     *
     * @return view
     */
    public function thankyou()
    {
        $data = [
            'pageTitle' => 'شكرا لك',
            'settings' => $this->settings,
            'menu' => $this->menu,
        ];
        //loading view
        $this->view('volunteering/thankyou', $data);
    }
}
