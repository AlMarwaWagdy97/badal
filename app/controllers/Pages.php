<?php

class Pages extends Controller
{
    private $pagesModel;
    private $orderModel;
    public $settings;
    public $menu;

    public function __construct()
    {
        $this->pagesModel = $this->model('Page');
        $this->orderModel = $this->model('Order');
        $this->menu = $this->pagesModel->getMenu();
        $this->settings = $this->pagesModel->getSettings();
    }
    /**
     * home page
     */
    public function index()
    {
        $data = [
            'pageTitle' => 'الرئيسية: ' . SITENAME,
            'settings' => $this->settings,
            'menu' => $this->menu,
            'slides' => $this->pagesModel->getSlides(),
            'newsTicker' => $this->pagesModel->getNewsTicker(),
            'articles' => $this->pagesModel->getArticles(),
            'projects' => $this->pagesModel->getProjects(),
            'tags' => $this->pagesModel->getProjectsTags('tag_id, name, alias'),
            'categories' => $this->pagesModel->getProjectCategories('*', ['status' => 1, 'kafara' => 'web']),
        ];
        //loading the view
        $this->view('pages/index', $data);
    }

    public function show($id = '')
    {
        empty($id) ? redirect('pages', true) : null;
        ($page = $this->pagesModel->getPageById($id)) ? null :  redirect('pages', true);
        $data = [
            'settings' => $this->settings,
            'menu' => $this->menu,
            'page' => $page,
        ];

        $data['settings']['seo']->meta_keywords = $data['page']->meta_keywords;
        $data['settings']['seo']->meta_description = $data['page']->meta_description;
        $data['settings']['site']->image = $data['page']->image;
        $data['settings']['site']->title = $data['pageTitle'] = $data['page']->title;
        //loading view
        $this->view('pages/show', $data);
    }
    /**
     * contact us page
     *
     * @return view
     */
    public function contact()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $data = [
                'pageTitle' => 'اتصل بنا: ' . SITENAME,
                'settings' => $this->settings,
                'menu' => $this->menu,
                'subject' => trim($_POST['subject']),
                'full_name' => trim($_POST['full_name']),
                'city' => trim($_POST['city']),
                'message' => trim($_POST['message']),
                'email' => trim($_POST['email']),
                'phone' => trim($_POST['phone']),
                'types' => ['شكوى', 'اقتراح', 'استفسار'],
                'type' => trim($_POST['type']),
                'subject_error' => '',
                'city_error' => '',
                'full_name_error' => '',
                'message_error' => '',
                'type_error' => '',
                'captcha_error' => '',
                'phone_error' => '',
            ];
            // validate subject
            if (empty($_POST['subject'])) {
                $data['subject_error'] = 'من فضلك قم بكتابة عنوان الرسالة';
            }
            // validate full_name
            if (empty($_POST['full_name'])) {
                $data['full_name_error'] = 'من فضلك قم بكتابة الاسم بالكامل';
            }
            // validate city
            if (empty($_POST['city'])) {
                $data['city_error'] = 'من فضلك قم بكتابة المدينة';
            }
            // validate message
            if (empty($_POST['message'])) {
                $data['message_error'] = 'من فضلك قم بكتابة محتوي الرسالة';
            }
            // validate type_
            if (empty($_POST['type'])) {
                $data['type_error'] = 'من فضلك قم بكتابة غرض الرسالة';
            }
            // validate phone
            if (empty($_POST['phone'])) {
                $data['phone_error'] = 'من فضلك قم بكتابة رقم الهاتف';
            } else {
                if (strlen($_POST['phone']) != 10) {
                    $data['phone_error'] = 'من فضلك قم بكتابة رقم الهاتف بطريقة صحيحة';
                }
            }
            // validate captcha
            recaptcha() ?: $data['captcha_error'] = 'خطأ بكود التحقق ';
            //make sure there is no errors
            if (
                empty($data['type_error']) && empty($data['message_error']) && empty($data['subject_error']) &&
                empty($data['full_name_error']) && empty($data['captcha_error']) && empty($data['phone_error']) && empty($data['city_error'])
            ) {
                //validated
                if ($this->pagesModel->addContacts($data)) {
                    if (!empty($data['settings']['notifications']->contactEmail)) { //send notification
                        $msg = arrayLines($_POST);
                        $this->pagesModel->Email($data['settings']['notifications']->contactEmail, SITENAME . ': اشعار حول رسالة تواصل جديدة ', $msg);
                    }
                    flash('msg', 'تم الارسال بنجاح');
                    redirect('pages/contacts', true);
                } else {
                    flash('msg', 'هناك خطأ ما حاول مرة اخري', 'alert alert-danger');
                }
            }
        } else {
            $data = [
                'pageTitle' => 'اتصل بنا: ' . SITENAME,
                'settings' => $this->settings,
                'menu' => $this->menu,
                'subject' => '',
                'full_name' => '',
                'city' => '',
                'message' => '',
                'email' => '',
                'phone' => '',
                'types' => ['شكوى', 'اقتراح', 'استفسار'],
                'type' => '',
                'subject_error' => '',
                'full_name_error' => '',
                'city_error' => '',
                'message_error' => '',
                'captcha_error' => '',
                'phone_error' => '',
                'type_error' => '',
            ];
        }

        $data['settings']['site']->title = $data['pageTitle'];
        //loading view
        $this->view('pages/contacts', $data);
    }
    /**
     * in kindes donation page
     *
     * @return view
     */
    public function inkindes()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

            $data = [
                'pageTitle' => 'التبرعات العينية',
                'settings' => $this->settings,
                'menu' => $this->menu,
                'full_name' => trim($_POST['full_name']),
                'phone' => trim($_POST['phone']),
                'email' => trim($_POST['email']),
                'district' => trim($_POST['district']),
                'street' => trim($_POST['street']),
                'message' => trim($_POST['message']),
                'status' => '',
                'status_error' => '',
                'district_error' => '',
                'email_error' => '',
                'street_error' => '',
                'phone_error' => '',
                'message_error' => '',
                'captcha_error' => '',
                'full_name_error' => '',
            ];
            // validate phone
            !(empty($data['phone'])) ?: $data['phone_error'] = 'هذا الحقل مطلوب';
            // validate street
            !(empty($data['street'])) ?: $data['street_error'] = 'هذا الحقل مطلوب';
            // validate email
            !(empty($data['email'])) ?: $data['email_error'] = 'هذا الحقل مطلوب';
            // validate district
            !(empty($data['district'])) ?: $data['district_error'] = 'هذا الحقل مطلوب';
            // validate message
            !(empty($data['message'])) ?: $data['message_error'] = 'هذا الحقل مطلوب';
            // validate full_name
            !(empty($data['full_name'])) ?: $data['full_name_error'] = 'هذا الحقل مطلوب';
            //validate captcha
            if ($_SESSION['captcha'] != $_POST['captcha']) {
                $data['captcha_error'] = 'خطأ بكود التحقق ';
            }
            //make sure there is no errors
            if (
                empty($data['street_error']) && empty($data['district_error']) && empty($data['message_error']) && empty($data['full_name_error'])
                && empty($data['phone_error']) && empty($data['email_error']) && empty($data['captcha_error'])
            ) {
                //validated
                if ($this->pagesModel->addInkinde($data)) {
                    if (!empty($data['settings']['notifications']->inkindEmail)) { //send notification
                        $msg = arrayLines($_POST);
                        $this->pagesModel->Email($data['settings']['notifications']->inkindEmail, SITENAME . ': اشعار حول طلب تبرع عيني جديد ', $msg);
                    }
                    flash('msg', 'تم استلام طلبك بنجاح وجاري مراجعته');
                    redirect('pages/inkindes', true);
                } else {
                    flash('msg', 'هناك خطأ ما حاول مرة اخري', 'alert alert-danger');
                }
            }
        } else {
            $data = [
                'pageTitle' => 'التبرعات العينية',
                'settings' => $this->settings,
                'menu' => $this->menu,
                'street' => '',
                'district' => '',
                'message' => '',
                'full_name' => '',
                'phone' => '',
                'email' => '',
                'status' => 0,
                'status_error' => '',
                'district_error' => '',
                'email_error' => '',
                'street_error' => '',
                'phone_error' => '',
                'captcha_error' => '',
                'message_error' => '',
                'full_name_error' => '',
            ];
        }
        $data['settings']['site']->title = $data['pageTitle'];
        //loading view
        $this->view('pages/inkindes', $data);
    }
    /**
     * benficiry subscription page
     *
     * @return view
     */
    public function beneficiaries()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

            $data = [
                'pageTitle' => 'المستفيدون',
                'settings' => $this->settings,
                'menu' => $this->menu,
                'identity' => trim($_POST['identity']),
                'full_name' => trim($_POST['full_name']),
                'phone' => trim($_POST['phone']),
                'city' => trim($_POST['city']),
                'district' => trim($_POST['district']),
                'nationality' => trim($_POST['nationality']),
                'gender' => trim($_POST['gender']),
                'family' => (int)trim($_POST['family']),
                'income' => trim($_POST['income']),
                'message' => trim($_POST['message']),
                'image' => '',
                'status' => '',
                'status_error' => '',
                'district_error' => '',
                'city_error' => '',
                'family_error' => '',
                'income_error' => '',
                'gender_error' => '',
                'nationality_error' => '',
                'identity_error' => '',
                'phone_error' => '',
                'message_error' => '',
                'full_name_error' => '',
                'captcha_error' => '',
                'image_error' => '',
            ];
            // validate identity
            !(empty($data['identity'])) ?: $data['identity_error'] = 'هذا الحقل مطلوب';
            // validate gender
            !(empty($data['gender'])) ?: $data['gender_error'] = 'هذا الحقل مطلوب';
            // validate family
            !(empty($data['family'])) ?: $data['family_error'] = 'هذا الحقل مطلوب هذا الحقل يقبل قيمة رقمية فقط';
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
            // validate image
            if ($_FILES['image']['error'] == 0) {
                $image = uploadImage('image', APPROOT . '/media/files/beneficiaries/', 2048000, false);
                if (empty($image['error'])) {
                    $data['image'] = $image['filename'];
                } else {
                    if (!isset($image['error']['nofile'])) {
                        $data['image_error'] = implode(',', $image['error']);
                    }
                }
            } else {
                $data['image_error'] = 'يجب ارفاق صورة الهوية';
            }
            //validate captcha
            if ($_SESSION['captcha'] != $_POST['captcha']) {
                $data['captcha_error'] = 'خطأ بكود التحقق ';
            }
            //make sure there is no errors
            if (
                empty($data['district_error']) && empty($data['message_error']) && empty($data['full_name_error']) && empty($data['image_error']) && empty($data['income_error'])
                && empty($data['gender_error']) && empty($data['family_error']) && empty($data['phone_error']) && empty($data['city_error']) && empty($data['captcha_error'])
            ) {
                //validated
                if ($this->pagesModel->addBeneficiaries($data)) {
                    if (!empty($data['settings']['notifications']->beneficiaryEmail)) { //send notification
                        $msg = arrayLines($_POST);
                        $this->pagesModel->Email(
                            $data['settings']['notifications']->beneficiaryEmail,
                            SITENAME . ': اشعار حول طلب تسجيل مستفيد جديد ',
                            $msg,
                            APPROOT . '/media/files/beneficiaries/' . $data['image']
                        );
                    }
                    flash('msg', 'تم استلام طلبك بنجاح وجاري مراجعته');
                    redirect('pages/beneficiaries', true);
                } else {
                    flash('msg', 'هناك خطأ ما حاول مرة اخري', 'alert alert-danger');
                }
            }
        } else {
            $data = [
                'pageTitle' => 'اضافة مستفيد',
                'settings' => $this->settings,
                'menu' => $this->menu,
                'identity' => '',
                'nationality' => '',
                'gender' => '',
                'family' => '',
                'income' => '',
                'district' => '',
                'message' => '',
                'full_name' => '',
                'phone' => '',
                'city' => '',
                'image' => '',
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
                'captcha_error' => '',
                'image_error' => '',
            ];
        }
        $data['settings']['site']->title = $data['pageTitle'];
        //loading view
        $this->view('pages/beneficiaries', $data);
    }


    /**
     * volunteers subscription page
     *
     * @return view
     */
    public function volunteers()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

            $data = [
                'pageTitle' => 'المتطوعين',
                'settings' => $this->settings,
                'menu' => $this->menu,
                'identity' => trim($_POST['identity']),
                'full_name' => trim($_POST['full_name']),
                'phone' => trim($_POST['phone']),
                'nationality' => trim($_POST['nationality']),
                'gender' => trim($_POST['gender']),
                'email' => trim($_POST['email']),
                'image' => '',
                'status' => '',
                'status_error' => '',
                'email_error' => '',
                'gender_error' => '',
                'nationality_error' => '',
                'identity_error' => '',
                'phone_error' => '',
                'full_name_error' => '',
                'captcha_error' => '',
                'image_error' => '',
            ];
            // validate identity
            !(empty($data['identity'])) ?: $data['identity_error'] = 'هذا الحقل مطلوب';
            // validate gender
            !(empty($data['gender'])) ?: $data['gender_error'] = 'هذا الحقل مطلوب';
            // validate family
            !(empty($data['email'])) ?: $data['email_error'] = 'هذا الحقل مطلوب';
            // validate phone
            !(empty($data['phone'])) ?: $data['phone_error'] = 'هذا الحقل مطلوب';
            // validate nationality
            !(empty($data['nationality'])) ?: $data['nationality_error'] = 'هذا الحقل مطلوب';
            // validate full_name
            !(empty($data['full_name'])) ?: $data['full_name_error'] = 'هذا الحقل مطلوب';
            // validate image
            // if ($_FILES['image']['error'] == 0) {
            //     $image = uploadImage('image', APPROOT . '/media/files/volunteers/', 2048000, false);
            //     if (empty($image['error'])) {
            //         $data['image'] = $image['filename'];
            //     } else {
            //         if (!isset($image['error']['nofile'])) {
            //             $data['image_error'] = implode(',', $image['error']);
            //         }
            //     }
            // } else {
            //     $data['image_error'] = 'يجب ارفاق صورة الهوية';
            // }
            //validate captcha
            if ($_SESSION['captcha'] != $_POST['captcha']) {
                $data['captcha_error'] = 'خطأ بكود التحقق ';
            }
            //make sure there is no errors
            if (empty($data['full_name_error']) && empty($data['gender_error']) && empty($data['email_error']) && empty($data['phone_error']) && empty($data['captcha_error'])) {
                //validated
                if ($this->pagesModel->addVolunteer($data)) {
                    if (!empty($data['settings']['notifications']->volunteerEmail)) { //send notification
                        $msg = arrayLines($_POST);
                        $this->pagesModel->Email(
                            $data['settings']['notifications']->volunteerEmail,
                            ': اشعار حول طلب تسجيل متطوع جديد ',
                            $msg,
                            APPROOT . '/media/files/beneficiaries/' . $data['image']
                        );
                    }
                    flash('msg', 'تم استلام طلبك بنجاح وجاري مراجعته');
                    redirect('pages/volunteers', true);
                } else {
                    flash('msg', 'هناك خطأ ما حاول مرة اخري', 'alert alert-danger');
                }
            }
        } else {
            $data = [
                'pageTitle' => 'المتطوعين',
                'settings' => $this->settings,
                'menu' => $this->menu,
                'identity' => '',
                'nationality' => '',
                'gender' => '',
                'email' => '',
                'full_name' => '',
                'phone' => '',
                'image' => '',
                'status' => 0,
                'status_error' => '',
                'email_error' => '',
                'gender_error' => '',
                'nationality_error' => '',
                'phone_error' => '',
                'identity_error' => '',
                'full_name_error' => '',
                'captcha_error' => '',
                'image_error' => '',
            ];
        }
        $data['settings']['site']->title = $data['pageTitle'];
        //loading view
        $this->view('pages/volunteers', $data);
    }

    /**
     * generate captcha code and store it in session for comparison 
     */
    public function captcha()
    {
        $code = rand('10000', '99999');
        $_SESSION['captcha'] = $code;
        $image = imagecreate(200, 70);
        $bg = imagecolorallocatealpha($image, 100, 100, 100, 0);
        $black = imagecolorallocate($image, 0, 0, 0);
        $white = imagecolorallocate($image, 255, 255, 255);
        $gray = imagecolorallocatealpha($image, 150, 150, 150, 0);
        imagettftext($image, 66, 0, 10, 70, $gray, APPROOT . '/public/templates/default/css/fonts/ae_AlHor.ttf', '@#0% +');
        imagettftext($image, 66, 0, 10, 70, $gray, APPROOT . '/public/templates/default/css/fonts/ae_AlHor.ttf', '+#@ 0%');
        imagettftext($image, 36, 0, 30, 50, $white, APPROOT . '/public/templates/default/css/fonts/ae_AlHor.ttf', $code);
        header('Content-Type: image/png');
        imagepng($image);
    }

    /**
     * generate captcha code and store it in session for comparison 
     */
    public function captcha_calc()
    {
        $num1 = rand('0', '9');
        $num2 = rand('0', '9');
        $num3 = rand('0', '9');
        $code = $num1 + $num2 + $num3;
        $_SESSION['captcha'] = $code;
        $image = imagecreate(200, 70);
        $bg = imagecolorallocatealpha($image, 100, 100, 100, 0);
        $black = imagecolorallocate($image, 0, 0, 0);
        $white = imagecolorallocate($image, 255, 255, 255);
        $gray = imagecolorallocatealpha($image, 150, 150, 150, 0);
        imagettftext($image, 66, 0, 10, 70, $gray, APPROOT . '/public/templates/default/css/fonts/ae_AlHor.ttf', '@#0% +');
        imagettftext($image, 66, 0, 10, 70, $gray, APPROOT . '/public/templates/default/css/fonts/ae_AlHor.ttf', '+#@ 0%');
        imagettftext($image, 36, 0, 30, 50, $white, APPROOT . '/public/templates/default/css/fonts/ae_AlHor.ttf', $num1 . '+' . $num2 . '+' . $num3);
        header('Content-Type: image/png');
        imagepng($image);
    }
    /**
     * redirect to bank transfer page
     *
     * @param int $order_id
     * @return void
     */
    public function bp($order_id = null)
    {
        if ($order = $this->pagesModel->getSingle('*', ['order_id' => $order_id], 'orders')) {
            if ($order->hash) {
                redirect('projects/banktransfer/' . $order->hash, true);
            } else {
                flashRedirect('', 'msg', 'هذه الصفحة غير موجودة ربما اتبعت رابط خاطئ', 'alert alert-danger');
            }
        }
    }

    /**
     * thankyou page 
     *
     * @return view
     */
    public function thankyou($hash = null, $total = null)
    {
        $data = [
            'pageTitle' => 'شكرا لك',
            'settings' => $this->settings,
            'menu' => $this->menu,
            'total' => $total,
        ];

        if($hash){
            $data['order'] = $this->orderModel->getOrderByHash($hash);
            $data['donations'] = $this->orderModel->getDonationsByOrderId(@$data['order']->order_id);
            $data['paymentMethod'] = "";
            switch(@$data['order']->payment_method_id){
                case '1': 
                    $data['paymentMethod'] = "BankTransfer";
                    break;
                case '3': 
                    $data['paymentMethod'] = "Visa";
                    break;
                case '10': 
                    $data['paymentMethod'] = "ApplePay";
                    break;
                default:
                    $data['paymentMethod'] = "other";
                    break;
            }
            $this->orderModel->removeOrderHash($hash);
        }

        //loading view
        $this->view('pages/thankyou', $data);
    }
}
