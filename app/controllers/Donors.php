<?php

class Donors extends Controller
{
    private $donorModel;
    public $settings;
    public $menu;
    public $testMode = TEST_MODE;

    public function __construct()
    {
        $this->donorModel = $this->model('Donor');
        $this->menu = $this->donorModel->getMenu();
        $this->settings = $this->donorModel->getSettings();
    }

    public function index($start = 1, $perpage = 100)
    {
        if (!$_SESSION['login']) {
            flashRedirect('donors/login', 'msg', 'عذرا يجب تسجيل الدخول اولا  ', 'alert alert-danger');
        }
        // $data = [
        //     'pageTitle' => 'الرئيسية: ' . SITENAME,
        //     'donations' => $this->donorModel->getDonationsByMobail($_SESSION['login']),
        //     'settings' => $this->settings,
        //     'menu' => $this->menu,
        // ];

        // $this->view('donors/index', $data);
        $data = [
            'pageTitle' => 'حسابي الشخصي: ' . SITENAME,
            'donor' => $this->donorModel->getDonationsByRelations($_SESSION['login']),
            'settings' => $this->settings,
            'menu' => $this->menu,
        ];
        $this->view('donors/account', $data);
    }

    /**
     * login donor by id
     *
     * @param  int $id
     *
     * @return view
     */
    public function login()
    {
        if (isset($_SESSION['login'])) redirect('donors', true);
        if( !isset($_SESSION['redirect_url']) && isset($_GET['redirect']) && $_GET['redirect'] == 1){
            $_SESSION['redirect_url'] = @$_SERVER['HTTP_REFERER'];
        }
        else if(!isset($_GET['redirect'])){
            unset($_SESSION['redirect_url']);
        }
        $data = [
            'pageTitle' => 'تسجيل دخول متبرع : ' . SITENAME,
            'settings' => $this->settings,
            'menu' => $this->menu,
        ];

        $this->view('donors/login', $data);
    }

    /**
     * view donor profile
     *
     * @return view
     */
    public function profile()
    {
        $data = [
            'pageTitle' => 'الرئيسية: ' . SITENAME,
            'donor' => $this->donorModel->getdonorByMobile($_SESSION['login']),
            'settings' => $this->settings,
            'menu' => $this->menu,
        ];
        // $this->view('donors/account', $data);
        $this->view('donors/profile1', $data);
    }

    /**
     * update donor data
     *
     * @return void
     */
    public function update()
    {
        if (!$_SESSION['login']) {
            flashRedirect('donors/login', 'msg', 'عذرا يجب تسجيل الدخول اولا  ', 'alert alert-danger');
        }
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // sanitize POST array
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $donor = $this->donorModel->getdonorByMobile($_SESSION['login']);
            $data = [
                'donor_id' => $donor->donor_id,
                'full_name' => trim($_POST['full_name']),
                'email' => trim($_POST['email']),
            ];
            $this->donorModel->updateDonor($data);
            flashRedirect('donors/profile', 'msg', 'تم تحديث البيانات بنجاح  ', 'alert alert-success');
        } else {
            flashRedirect('donors', 'msg', 'عذرا لا يمكن عرض هذة الصفحة ربما اتبعت رابط خاطيء  ', 'alert alert-danger');
        }
    }

    /**
     * logout donor
     *
     * @return redirect
     */
    public function logout()
    {
        unset($_SESSION['login']);
        flashRedirect('donors/login', 'msg', 'تم تسجيل الخروج بنجاح  ', 'alert alert-info');
    }
    /**
     * logout donor
     *
     * @return redirect
     */
    public function closed()
    {
        $mobile = $_SESSION['login'];
        $this->donorModel->closeAccount($mobile);
        unset($_SESSION['login']);
        flashRedirect('donors/login', 'msg', 'تم تسجيل حذف الحساب بنجاح  ', 'alert alert-info');
    }

    /** 
     * register
     *
     *
     * @return view
     */
    public function register()
    {
        if (isset($_SESSION['login'])) redirect('donors', true);
        $data = [
            'pageTitle' => 'تسجيل حساب جديد : ' . SITENAME,
            'settings' => $this->settings,
            'menu' => $this->menu,
        ];

        $this->view('donors/register', $data);
    }

    /**
     * check exist donor by mobile
     *
     * @return void
     */
    public function checkExistDonor()
    {
        $mobile = $_POST['mobile'];
        $donor = $this->donorModel->checkDonorExist($mobile);
        echo $donor ? json_encode(true) :  json_encode(false);
    }

    /**
     * validate Mobile
     *
     * @return void
     */
    public function validateMobile()
    {
        $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        if ($_POST['code'] == $_SESSION['code']) {
            $data = [
                'msg' => '<div class="alert alert-success text-center"> تم التفعيل بنجاح </div>',
                'status' => 'success',
            ];

            $_POST['mobile_confirmed'] = "yes";
            $_POST['status'] = 1;
            // register
            $this->donorModel->addDonor($_POST);
            // login 
            $_SESSION['login'] = $_POST['mobile'];
        } else {
            $data = [
                'msg' => '<div class="alert alert-danger text-danger"> رمز التفعيل غير صحيح </div>',
                'status' => 'error',
            ];
        }
        echo json_encode($data);
    }

    /**
     * view donor account
     *
     * @return view
     */
    public function account()
    {
        if (!isset($_SESSION['login'])) redirect('donors/login', true);
        $data = [
            'pageTitle' => 'حسابي الشخصي: ' . SITENAME,
            'donor' => $this->donorModel->getDonationsByRelations($_SESSION['login']),
            'settings' => $this->settings,
            'menu' => $this->menu,
        ];
        $this->view('donors/account', $data);
    }

    /**
     * view donor paymentmethod
     *
     * @return view
     */
    public function cards()
    {
        if (!isset($_SESSION['login'])) redirect('donors/login', true);
        $donor = $this->donorModel->getdonorByMobile($_SESSION['login']);
        $cards =  $this->donorModel->getDonationcards($donor->donor_id);
        $data = [
            'pageTitle'     => ' بطاقات الدفع: ' . SITENAME,
            'donor'         => $donor,
            'cards'         => $cards,
            'settings'      => $this->settings,
            'menu'          => $this->menu,
        ];
        $this->view('donors/cards', $data);
    }

    /**
     * view donor addpayment
     *
     * @return view
     */
    public function addcard()
    {

        if (!isset($_SESSION['login'])) redirect('donors/login', true);

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // sanitize POST array
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $data = [
                'pageTitle' => ' إضافة بطاقات الدفع  ' . SITENAME,
                'settings' => $this->settings,
                'donor' => $this->donorModel->getdonorByMobile($_SESSION['login']),
                'menu' => $this->menu,
                'number'                    => ($_POST['number']),
                'expired_month'             => ($_POST['expired_month']),
                'expired_year'              => ($_POST['expired_year']),
                'cvv'                       => $_POST['cvv'],
                'name'                      => ($_POST['name']),
                'default'                   => @$_POST['default'] ? 1 : 0,
                'number_error'              => '',
                'expired_month_error'       => '',
                'expired_year_error'        => '',
                // 'cvv_error'                 => '',
                'name_error'                => '',
                'default_error'             => '',
            ];

            // validate number, expired_month, expired_year, cvv, name -----------------
            !(empty($data['number'])) ? $data['number_error'] = '' : $data['number_error'] =  'هذا الحقل مطلوب';
            !(empty($data['expired_month'])) ? $data['expired_month_error'] = '' : $data['expired_month_error'] =  'هذا الحقل مطلوب';
            !(empty($data['expired_year'])) ? $data['expired_year_error'] = '' : $data['expired_year_error'] =  'هذا الحقل مطلوب';
            !(empty($data['cvv'])) ? $data['cvv_error'] = '' : $data['cvv_error'] =  'هذا الحقل مطلوب';
            !(empty($data['name'])) ? $data['name_error'] = '' : $data['name_error'] = 'هذا الحقل مطلوب';


            if (
                empty($data['number_error']) && empty($data['cvv_error']) && empty($data['name_error'])
                && empty($data['expired_month_error']) && empty($data['expired_year_error'])
            ) {
                // Check if payment card info is correct
                $cardInfo['card_number'] = $data['number'];
                $cardInfo['expiry_date'] = $data['expired_year'] . $data['expired_month'];
                $cardInfo['card_security_code'] = $data['cvv'];
                $cardInfo['card_holder_name'] = $data['name'];
                // save card info with encrypt
                $carddata['number']                 = openssl_encrypt_card($data['number']);
                $carddata['expired_month']          = encrypt($data['expired_month']);
                $carddata['expired_year']           = encrypt($data['expired_year']);
                $carddata['name']                   = base64_encode($data['name']);
                $carddata['donor_id']               = $data['donor']->donor_id;
                $carddata['default']                = $data['default'];
                $savedCard = $this->donorModel->savecard($carddata);
                // check card 
                require_once APPROOT . '/helpers/PayfortCustomerMerchant.php';
                $payment = new PayfortCustomerMerchant();
                $payment->return_url = 'donors/payfortrespondSaveCard';
                $payment->merchant_reference = 'CARD_'.encrypt($savedCard);
                $parameters = $payment->CustomMerchantToken($cardInfo);
                // check car api 
                if($this->testMode){
                    $redirectUrl = 'https://sbcheckout.PayFort.com/FortAPI/paymentPage';
                }else{
                    $redirectUrl = 'https://checkout.PayFort.com/FortAPI/paymentPage';
                }
                echo "<html xmlns='http://www.w3.org/1999/xhtml'>\n<head></head>\n<body>\n";
                echo '';
                echo '<div style="position:fixed; top:40%;right:50%;text-align: center;font-weight: bold;color: yellowgreen;" ><img src="' . MEDIAURL . '/icon.gif"/>
                <p>   سيتم التحقيق من البينات </p></div>';
                    echo "<form action='$redirectUrl' method='post' name='frm'>\n";
                foreach ($parameters as $a => $b) {
                    echo "\t<input type='hidden' name='" . htmlentities($a) . "' value='" . htmlentities($b) . "'>\n";
                }
                echo "\t<script type='text/javascript'>\n";
                echo "\t\tdocument.frm.submit();\n";
                echo "\t</script>\n";
                echo "</form>\n</body>\n</html>";
            } else {
                flash('msg', 'البطاقه غير صحيحه', 'alert alert-danger');
            }
        } else {
            $data = [
                'pageTitle'                 => ' إضافة بطاقات الدفع  ' . SITENAME,
                'donor'                     => $this->donorModel->getdonorByMobile($_SESSION['login']),
                'settings'                  => $this->settings,
                'menu'                      => $this->menu,
                'number'                    => '',
                'expired_month'             => '',
                'expired_year'              => '',
                'cvv'                       => '',
                'name'                      => '',
                'default'                   => '',
                'number_error'              => '',
                'expired_month_error'       => '',
                'expired_year_error'        => '',
                'cvv_error'                 => '',
                'name_error'                => '',
                'default_error'             => '',
            ];
        }
        $this->view('donors/addcard', $data);
    }

    public function payfortrespondSaveCard()
    { // filter get respond
        require_once APPROOT . '/helpers/PayfortIntegration.php';
        $objFort = new PayfortIntegration();
        $fortParams = $objFort->processResponse();
        ($fortParams['status'] == 18) ? $status = 1 : $status = 0;
        //load order data by merchant_reference/order_identifier
        if($status == 1){
            $card_info = $this->donorModel->getSingle('*', ['card_id' => decrypt( str_replace('CARD_', '', $fortParams['merchant_reference'])) ], 'credit_cards');
            $this->donorModel->confirm_card( $card_info->card_id, $fortParams['token_name']);
            // if donor have same card will updated 
            $updatedCards = $this->donorModel->updateSameCard( $card_info);
            if ($card_info->default == 1) {
                $this->donorModel->removedefault($card_info->donor_id, $card_info->card_id);
            }
            flashRedirect('donors/cards', 'msg', 'تم حفظ البطاقة بنجاح.  ', 'alert alert-success');
        }
        else{
            flashRedirect('donors/addcard', 'msg', $fortParams['response_message'], 'alert alert-danger');
        }
    }



    /**
     * view donor edit mobile
     *
     * @return view
     */
    public function editmobile()
    {
        if (!isset($_SESSION['login'])) redirect('donors/login', true);
        $data = [
            'pageTitle' => ' تعديل رقم الجوال   ' . SITENAME,
            'donor' => $this->donorModel->getDonationsByRelations($_SESSION['login']),
            'settings' => $this->settings,
            'menu' => $this->menu,
        ];
        $this->view('donors/phone', $data);
    }

    /**
     * check same donor mobile
     *
     * @return void
     */
    public function checksamemobile()
    {
        $mobile = $_POST['mobile'];
        $donor_id = $_POST['donor_id'];
        $mobile = $this->donorModel->checksamemobile($mobile, $donor_id);
        echo $mobile ? json_encode(true) :  json_encode(false);
    }

    /**
     * edit mobile and logout then redirect to login
     *
     * @return view
     */
    public function editmobilepost()
    {
        $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        if ($_POST['code'] == $_SESSION['code']) {
            $data = [
                'msg' => '<div class="alert alert-success text-center"> تم التفعيل بنجاح </div>',
                'status' => 'success',
            ];
            $update = $this->donorModel->editmobile($_POST['mobile'], $_POST['donor_id']);
            unset($_SESSION['login']);
        } else {
            $data = [
                'msg' => '<div class="alert alert-danger text-danger"> رمز التفعيل غير صحيح </div>',
                'status' => 'error',
            ];
        }
        echo json_encode($data);
    }

    /**
     * view donor edit mobile
     *
     * @return view
     */
    public function orders()
    {
        if (!isset($_SESSION['login'])) redirect('donors/login', true);
        $data = [
            'pageTitle' => '  سجل التبرعات ' . SITENAME,
            'donations' => $this->donorModel->getDonationsByMobail($_SESSION['login']),
            'donor' => $this->donorModel->getDonationsByRelations($_SESSION['login']),
            'settings' => $this->settings,
            'menu' => $this->menu,
        ];
        $this->view('donors/orders', $data);
    }

    /**
     * view  donor profile edit
     *
     * @return view
     */
    public function editprofile()
    {
        $data = [
            'pageTitle' => 'الرئيسية: ' . SITENAME,
            'donor' => $this->donorModel->getdonorByMobile($_SESSION['login']),
            'settings' => $this->settings,
            'menu' => $this->menu,
        ];
        $this->view('donors/profile', $data);
    }


    /**
     * update donor data
     *
     * @return void
     */
    public function updateprofile()
    {
        if (!$_SESSION['login']) {
            flashRedirect('donors/login', 'msg', 'عذرا يجب تسجيل الدخول اولا  ', 'alert alert-danger');
        }
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // sanitize POST array
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $donor = $this->donorModel->getdonorByMobile($_SESSION['login']);
            $data = [
                'donor_id' => $donor->donor_id,
                'full_name' => trim($_POST['full_name']),
                'email' => trim($_POST['email']),
                'identity' => trim($_POST['identity']),
            ];
            $this->donorModel->updateDonor($data);
            flashRedirect('donors/editprofile', 'msg', 'تم تحديث البيانات بنجاح  ', 'alert alert-success');
        } else {
            flashRedirect('donors', 'msg', 'عذرا لا يمكن عرض هذة الصفحة ربما اتبعت رابط خاطيء  ', 'alert alert-danger');
        }
    }

    /**
     * actions on card data (update default and delete)
     *
     * @return void
     */
    public function cardactions()
    {
        if (!$_SESSION['login']) {
            flashRedirect('donors/login', 'msg', 'عذرا يجب تسجيل الدخول اولا  ', 'alert alert-danger');
        }

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // sanitize POST array
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $donor = $this->donorModel->getdonorByMobile($_SESSION['login']);
            if (@$_POST['action'] == 'default') {
                $donor = $this->donorModel->removedefault($donor->donor_id, 0);
                $donor = $this->donorModel->setDefaultCard($_POST['card_id']);
            } elseif (@$_POST['action'] == 'delete') {
                $this->donorModel->deleteCard($_POST['card_id']);
                if ($_POST['is_default'] == 1) {
                    $donor = $this->donorModel->setFirstCardDefault($donor->donor_id);
                }
            }
            flashRedirect('donors/cards', 'msg', 'تم تحديث البيانات بنجاح  ', 'alert alert-success');
        } else {
            flashRedirect('donors/cards', 'msg', 'عذرا لا يمكن عرض هذة الصفحة ربما اتبعت رابط خاطيء  ', 'alert alert-danger');
        }
    }
}
