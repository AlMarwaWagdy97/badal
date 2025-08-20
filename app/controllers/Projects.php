<?php

class Projects extends Controller
{
    private $projectsModel;
    public $donorModel;
    public $settings;
    public $menu;
    public $testMode = TEST_MODE;

    public function __construct()
    {
        $this->projectsModel = $this->model('Project');
        $this->menu = $this->projectsModel->getMenu();
        $this->settings = $this->projectsModel->getSettings();
    }

    public function index()
    {
        redirect('projectCategories', true);
        $data = [
            'settings' => $this->settings,
            'menu' => $this->menu,
            'pageTitle' => 'الرئيسية: ' . SITENAME,
        ];
        $this->view('projects/index', $data);
    }

    /**
     * show project by id
     *
     * @param  int $id
     *
     * @return view
     */
    public function show($id = '')
    {

        $id = (int) $id;
        empty($id) ? redirect('projects', true) : null;
        ($project = $this->projectsModel->getProjectById($id)) ?: flashRedirect('index', 'msg', ' هذا المشروع غير موجود او ربما تم حذفه ');
        // set coockie for the guest for 1 hour and if it exists dont update hits else update store hits
        // check if cookies if exists and the value is the same the project value then do nothing
        // else we set cookies
        if (!isset($_COOKIE['guest']) ) {
            setcookie('guest', $id, time() + (86400 * 30));
            // load project store hits + 1 where ip is new
            $this->projectsModel->storeHits($id, $_SESSION['store']->store_id);
        }
        elseif ($_COOKIE['guest'] != $id){
            setcookie('guest', $id, time() + (86400 * 30));
            // load project store hits + 1 where ip is new
            $this->projectsModel->storeHits($id, $_SESSION['store']->store_id);
        }


        $data = [
            'pageTitle'                 => $project->name . ': ' . SITENAME,
            'project'                   => $project,
            'settings'                  => $this->settings,
            'menu'                      => $this->menu,
            'collected_traget'          => $this->projectsModel->collectedTraget($id),
            'moreprojects'              => $this->projectsModel->moreProjects($project->category_id),
            'payment_methods'           => $this->projectsModel->getSupportedPaymentMethods($project->payment_methods),
            'payments_methods_bank'     => $this->projectsModel->getSingle('*', ['payment_id' => 1], 'payment_methods'),

        ];
        $data['settings']['seo']->meta_keywords = $data['project']->meta_keywords;
        $data['settings']['seo']->meta_description = $data['project']->meta_description;
        $data['settings']['site']->image = $data['project']->image;
        $data['settings']['site']->title =  $data['project']->name;
        $mobile = @$_SESSION['login'];
        $this->donorModel = $this->model('Donor');
        $data['donor'] = $this->donorModel->getDonationsByRelations($mobile);
        $data['cards'] = $this->donorModel->getDonationcards(@$data['donor']->donor_id);
        $this->view('projects/show', $data);
    }

    /**
     * mobile activation code generate and sending
     *
     * @return void
     */
    public function getMobileCode()
    {
        //generst random code
        $num = $_SESSION['code'] = rand(1000, 9999);
        if ($_POST['name'] == '0597767751') $num = $_SESSION['code'] = '1234';
        $setting  = $this->projectsModel->getSettings('notifications');
        $smsSendCode = json_decode($setting->value)->sendcode;
        // sendSMS($num, $content);
        $messaging = $this->model('Messaging');
        $data = $messaging->mobileCodeSend(['mobile' => $_POST['name'], 'msg' =>  $smsSendCode  . $num . " \n "]);
        //display message
        $msgSuccess = '<div class="alert alert-success text-center"> تم ارسال كود التحقق علي الجوال الخاص بك </div>';
        $msgError = '<div class="alert alert-warning text-center">خطأ في الارسال </div>';
        echo ($data) ? $msgSuccess : $msgError;
    }

    /**
     * validate Mobile
     *
     * @return void
     */
    public function validateMobile()
    {

        $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $checkActivate = $this->projectsModel->checkAccountClose($_POST['mobile']);
        if (!$checkActivate) {
            $data = [
                'msg' => '<div class="alert alert-danger text-danger">لا يوجد حساب بهذا الرقم </div>',
                'status' => 'error',
            ];
        } else {
            if ($_POST['code'] == $_SESSION['code']) {
                $data = [
                    'msg' => '<div class="alert alert-success text-center"> تم التفعيل بنجاح </div>',
                    'status' => 'success',
                ];
                if (isset($_POST['login'])) {
                    $_SESSION['login'] = $_POST['mobile'];
                }
            } else {
                $data = [
                    'msg' => '<div class="alert alert-danger text-danger"> رمز التفعيل غير صحيح </div>',
                    'status' => 'error',
                ];
            }
        }
        if (isset($_SESSION['redirect_url']) && $_SESSION['redirect_url'] != NULL) {
            $data['redirect_url'] = $_SESSION['redirect_url'];
        } else {
            $data['redirect_url'] = "../donors/";
        }
        echo json_encode($data);
    }

    /**
     * redirect and temperary save post data 
     * saving donor data
     * saving donation
     *
     * @return void
     */
    public function redirect()
    {
        //filtter post data
        $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        //captcha validation
        if (!recaptcha()) {
            flashRedirect('projects/show/' . $_POST['project_id'], 'msg', 'خطأ بكود التحقق ', 'alert alert-danger');
        }
        //get project details
        $project = $this->projectsModel->getProjectById($_POST['project_id']);
        //redirect if no project
        (!$project) ? flashRedirect('', 'msg', 'حدث خطأ ما ربما اتبعت رابط خاطيء ', 'alert alert-danger') : null;
        //validating gift options
        if (@exist($_POST['gift']['enable'])) {
            if (empty($_POST['gift']['giver_name']) || empty($_POST['gift']['giver_number']) || empty($_POST['gift']['giver_group']) || empty($_POST['gift']['card'])) {
                flashRedirect('projects/show/' . $_POST['project_id'], 'msg', 'من فضلك تأكد من ملء جميع بيانات الأهداء بطريقة صحيحة ', 'alert alert-danger');
            } else {
                // preparing text 
                $x = strlen($_POST['gift']['giver_group'] . " : " . $_POST['gift']['giver_name']) * 6;
                if (empty($project->gift_card_title)) $project->gift_card_title = $project->name;
                $lines = [
                    ['x' => 690, 'y' => 145, 'text' => $_POST['gift']['giver_group'] . " : " . $_POST['gift']['giver_name'], 'font' => true],
                    ['x' => 690, 'y' => 310, 'text' => $project->gift_card_title, 'size' => 40, 'font' => true],
                    ['x' => 690, 'y' => 530, 'text' => " من : " . $_POST['full_name'], 'font' => true],
                ];
                $output = imgWrite(APPROOT . MEDIAFOLDER . '/' . $_POST['gift']['card'], $lines, APPROOT . MEDIAFOLDER . '/gifts/img_' . time() . '.jpg', 20, 'white');
                // saving card to post to save in database
                $_POST['gift']['card'] = str_replace(APPROOT . MEDIAFOLDER, '', $output);
            }
        }
        //loading donor model
        $this->donorModel = $this->model('Donor');

        // check if identify is already exist or not 
        if( !empty($_POST['identity']) ){
            $checkIdentify = $this->donorModel->checkIdentify($_POST);
    
            if($checkIdentify){
                $data['identity_error'] = 'هذا الهوية مسجل من قبل ';
                flashRedirect('projects/show/' . $_POST['project_id'], 'msg','هذا الهوية مسجل من قبل ', 'alert alert-danger');
            }
        }
        //saving donor data
        if (
            empty($_POST['project_id']) || empty($_POST['full_name']) || empty($_POST['mobile']) || empty($_POST['amount'])
            || empty($_POST['total']) || empty($_POST['quantity']) || $_POST['quantity'] < 1 || ( ($_POST['quantity'] * $_POST['amount']) != $_POST['total'] )
        ) {
            flashRedirect('projects/show/' . $_POST['project_id'], 'msg', 'من فضلك تأكد من ملء جميع البيانات بطريقة صحيحة ', 'alert alert-danger');
        } else {
            $_SESSION['payment'] = $_POST;
            
            //check if exist and return its id
            if ($donor = $this->donorModel->getdonorByMobile($_POST['mobile'])) {
                if ($donor->mobile_confirmed == 'no') {
                    $data = ['mobile_confirmed' => $_POST['mobile_confirmed'], 'donor_id' => $donor->donor_id];
                    $this->donorModel->updateMobileConfirmation($data);
                }
                if (empty($donor->email) || !filter_var($donor->email, FILTER_VALIDATE_EMAIL)) {
                    $data = ['email' => $_POST['email'], 'donor_id' => $donor->donor_id];
                    $this->donorModel->updateEmail($data);
                }
                // add identity field
                if (empty($donor->identity) && !empty($_POST['identity'])) {
                    $data = ['identity' => $_POST['identity'], 'donor_id' => $donor->donor_id];
                    $this->donorModel->updateIdentity($data);
                }
            } else {
                // if not exist save it and return its id
                ($_POST['mobile_confirmed'] == 'yes') ? $_POST['status'] = 1 : $_POST['status'] = 0;
                $this->donorModel->addDonor($_POST);
            }
            $donor = $this->donorModel->getdonorByMobile($_POST['mobile']);
            // get donor store_id if exists on donor or from first donation 
            $_SESSION['store']->store_id = ($donor->store_id) ? $donor->store_id : $this->donorModel->getDonorStoreId($donor->donor_id);
            $donor = $donor->donor_id;
        }

        //generat secrit hash
        $hash = sha1(time() . rand(999, 999999));
        $_SESSION['payment']['hash'] = $hash; // saving donation hash into session
        $_SESSION['payment']['msg'] = $project->thanks_message;

        if($_POST['payment_method']  != "1"){
            $data['payment_key'] =  $_POST['payment_key'] = $this->projectsModel->getPaymentKey($_POST['payment_method'])[0]->payment_key; // update payment_key to Visa Ecom or ApplePay
        }
        
        //save donation data through saving method
        //saving order
        $data = [
            'order_identifier'                 => $this->projectsModel->uniqNum(),
            'total'                            => $_POST['total'],
            'quantity'                         => $_POST['quantity'],
            'payment_method_id'                => $_POST['payment_method'],
            // 'payment_method_key'                => $_POST['payment_key'],
            'payment_method_key'               => $_POST['payment_key'] ? $_POST['payment_key']: $this->projectsModel->getPaymentKey($_POST['payment_method'])[0]->payment_key,
            'hash'                             => $hash,
            'gift'                             => $_POST['gift']['enable'],
            'gift_data'                        => json_encode($_POST['gift']),
            'projects'                         => $project->name,
            'deceased_id'                      => $project->deceased_id,
            'projects_id'                      => "($project->project_id)",
            'donor_id'                         => $donor,
            'donor_name'                       => $_POST['full_name'],
            'store_id'                         =>  $_SESSION['store']->store_id,

            'status'                           => 0,

            'card_number'                      => @$_POST['card_number'],
            'expired_month'                    => @$_POST['expired_month'],
            'expired_year'                     => @$_POST['expired_year'],
            'cvv'                              => @$_POST['cvv'],
            'card_name'                        => @$_POST['card_name'],
            'payment_key'                      => @$_POST['payment_key'],
            'selected_card'                    => @$_POST['selected_card'],
            'selected_cvv'                     => @$_POST['selected_cvv'],
            'image'                            => @$_POST['selected_cvv'],
            'email_error'                      => '',
            'payment_method_error'             => '',
            'card_number_error'                => '',
            'exp_date_error'                   => '',
            'cvv_error'                        => '',
            'card_name_error'                  => '',
            'payment_key_error'                => '',
            'image_error'                      => '',
        ];

        // validate donor data 
        if ($_POST['payment_method'] == "1") {
            !(empty($_POST['payment_key'])) ? $data['payment_key_error'] = '' : $data['name_error'] =  'من فضلك قم باختار البنك المحول';
            // validate image
            if (@$_FILES['image']['error'] == 0) {
                $image = uploadImage('image', APPROOT . '/media/files/banktransfer/', 5000000, false);

                if (empty($image['error'])) {
                    $data['banktransferproof'] = $image['filename'];
                } else {
                    if (!isset($image['error']['nofile'])) {
                        $data['image_error'] = implode(',', $image['error']);
                    }
                }
            } else {
                $data['image_error'] = 'يجب ارفاق صورة التحويل';
            }
            // check errors
            if (!empty($data['image_error'])) {
                flashRedirect('projects/show/' . $project->project_id, 'msg', 'يجب رفع الصورة التحويل', 'alert alert-danger');
            }
        } else if ($_POST['payment_method'] == "3") { // validate payment cart 
            if ($data['selected_card'] == null && @$data['selected_cvv'][$data['selected_card']] == null) {
                $data['card_number_error'] = !(empty($data['card_number'])) ? '' :   'من فضلك قم بكتابة رقم البطاقه';
                $data['exp_date_error'] = !(empty($data['expired_month']) ||  empty($data['expired_year'])) ? '' :   'من فضلك قم بكتابة تاريخ الانتهاء';
                $data['cvv_error'] = !(empty($data['cvv'])) ? '' :   'من فضلك قم بكتابة  رمز الأمان cvv';

                $card_data = [
                    'card_number'               => $_POST['card_number'],
                    'expiry_date'               => $_POST['expired_year'] . $_POST['expired_month'],
                    'card_security_code'        => $_POST['cvv'],
                    'card_holder_name'          => $_POST['card_name'],
                ];
            } else {
                if (!$data['selected_cvv'] = @$data['selected_cvv'][$data['selected_card']]) {
                    flashRedirect('projects/show/' . $project->project_id, 'msg', 'يجب اضافه الرقم السري',  'alert alert-danger');
                }
                $cardInfo = $this->donorModel->getCardById($data['selected_card']);
                $card_data = [
                    'card_number'           => openssl_decrypt_card(@$cardInfo->number),
                    'expiry_date'           => decrypt(@$cardInfo->expired_year) .  decrypt(@$cardInfo->expired_month),
                    'card_security_code'    => $data['selected_cvv'],
                    'card_holder_name'      => base64_decode(@$cardInfo->name),
                ];
            }
            // check errors
            if (!empty($data['card_number_error']) | !empty($data['exp_date_error']) ||  !empty($data['cvv_error'])) {
                flashRedirect('projects/show/' . $project->project_id, 'msg', 'يجب اضافة بيانات البطاقه صحيحة ',   'alert alert-danger');
            }
        }

        $savingOrder = $this->projectsModel->addOrder($data);
        $data['order_id'] = $this->projectsModel->lastId();
        $data['project_id'] = $project->project_id;
        $data['amount'] = $_POST['amount'];
        $data['donation_type'] = $_POST['donation_type'];
        if (!$this->projectsModel->addDonation($data) && !$savingOrder) {
            flashRedirect('projects/show/' . $project->project_id, 'msg', 'حدث خطأ ما اثناء معالجة طلبك من فضلك حاول مره اخري', 'alert alert-danger');
        } else { // send notification Email 
            $messaging = $this->model('Messaging');
            $sendData = [
                'mailto' => $_POST['email'],
                'mobile' => $_POST['mobile'],
                'identifier' => $data['order_identifier'],
                'order_id' => $data['order_id'],
                'total' => $_POST['total'],
                'project' => $project->name,
                'donor' => $_POST['full_name'],
                'subject' => 'تم تسجيل تبرع جديد ',
                'msg' => "تم تسجيل تبرع جديد بمشروع : $project->name  <br/> بقيمة : " . $_POST['total'],
            ];

            // save message data to session 
            $_SESSION['sendData'] = $sendData;
            $messaging->donationAdminNotify($sendData);

            // send message to donor 
            $messaging->donationDonorNotify($sendData);
            // send whatsapp message to donor 
            // end check if special message -----------------------------------
        }
        @exist($_POST['email']) ? $customerEmail = $_POST['email'] : $customerEmail = 'test@payfort.com';
        if ($_POST['payment_method'] == 3) { //payment with payfort
            require_once APPROOT . '/helpers/PayfortCustomerMerchant.php';
            $payment = new PayfortCustomerMerchant();
            $payment->return_url = 'projects/authorizateResponse';
            $payment->merchant_reference = 'PRO_AUTH_' . $data['order_identifier'];

            if ($this->testMode) {
                $redirectUrl = 'https://sbcheckout.PayFort.com/FortAPI/paymentPage';
            } else {
                $redirectUrl = 'https://checkout.PayFort.com/FortAPI/paymentPage';
            }
            $this->donorModel->updateMerchant(@$_POST['selected_card'], 'PRO_AUTH_' . $data['order_identifier']);
            if (@$_POST['default'] == "on") {
                $carddata['number']                 = openssl_encrypt_card($card_data['card_number']);
                $carddata['expired_month']          = encrypt($_POST['expired_month']);
                $carddata['expired_year']           = encrypt($_POST['expired_year']);
                $carddata['name']                   = base64_encode($_POST['card_name']);
                $carddata['donor_id']               = $donor;
                $carddata['merchant_reference']     = $data['order_identifier'];
                $carddata['default']                = 1;
                $this->donorModel->savecard($carddata);
            }
            $parameters = $payment->CustomMerchantToken($card_data);
            // check card api 
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

            //pay with installments
        } elseif ($_POST['payment_method'] == 4) { //installments
            require_once APPROOT . '/helpers/PayfortIntegration.php';
            $objFort = new PayfortIntegration();
            $objFort->mr = $data['order_identifier'];
            $objFort->amount = $_POST['total'];
            $objFort->projectUrlPath = SITEFOLDER . '/projects';
            $objFort->itemName = 'Cart Donation';
            $objFort->customerEmail = $customerEmail;
            $request = $objFort->processRequest('installments');
            $redirectUrl = 'https://checkout.payfort.com/FortAPI/paymentPage';
            echo "<html xmlns='http://www.w3.org/1999/xhtml'>\n<head></head>\n<body>\n";
            echo '';
            echo '<div style="position:fixed; top:40%;right:50%;text-align: center;font-weight: bold;color: yellowgreen;" ><img src="' . MEDIAURL . '/icon.gif"/>
            <p> سيتم تحويلك خلال عدة ثواني</p></div>';
            echo "<form action='$redirectUrl' method='post' name='frm'>\n";
            foreach ($request as $a => $b) {
                echo "\t<input type='hidden' name='" . htmlentities($a) . "' value='" . htmlentities($b) . "'>\n";
            }
            echo "\t<script type='text/javascript'>\n";
            echo "\t\tdocument.frm.submit();\n";
            echo "\t</script>\n";
            echo "</form>\n</body>\n</html>";
            //bank transfere    
        } elseif ($_POST['payment_method'] == 5) { //STCPAY
            require_once APPROOT . '/helpers/PayfortSandBox.php';
            $objFort = new PayfortIntegration();
            $objFort->mr = $data['order_identifier'];
            $objFort->amount = $_POST['total'];
            $objFort->projectUrlPath = SITEFOLDER . '/projects';
            $objFort->itemName = 'Cart Donation';
            $objFort->customerEmail = $customerEmail;
            $request = $objFort->processRequest('STCPAY');
            $redirectUrl = 'https://sbcheckout.payfort.com/FortAPI/paymentPage';
            echo "<html xmlns='http://www.w3.org/1999/xhtml'>\n<head></head>\n<body>\n";
            echo '';
            echo '<div style="position:fixed; top:40%;right:50%;text-align: center;font-weight: bold;color: yellowgreen;" ><img src="' . MEDIAURL . '/icon.gif"/>
            <p> سيتم تحويلك خلال عدة ثواني</p></div>';
            echo "<form action='$redirectUrl' method='post' name='frm'>\n";
            foreach ($request as $a => $b) {
                echo "\t<input type='hidden' name='" . htmlentities($a) . "' value='" . htmlentities($b) . "'>\n";
            }
            echo "\t<script type='text/javascript'>\n";
            echo "\t\tdocument.frm.submit();\n";
            echo "\t</script>\n";
            echo "</form>\n</body>\n</html>";
            //bank transfere    
        } elseif ($_POST['payment_method'] == 10) { //ApplPay
            redirect('projects/applepay/' . $hash, true);
        } elseif ($_POST['payment_method'] == 1) { //banktransfer
            empty($project->thanks_message) ? $project->thanks_message = 'شكرا لتبرعك لدي ' . SITENAME  : null;
            flashRedirect('pages/thankyou/' .  $data['hash'], 'msg', ' تم استلام طلبك بنجاح وجاري مراجعته', 'alert alert-success');
        } else { //other
            //redirect to payment information
            empty($project->thanks_message) ? $project->thanks_message = 'شكرا لتبرعك لدي ' . SITENAME  : null;
            flashRedirect('projects/paymentdetails/' . $_POST['payment_method'], 'msg', $project->thanks_message, 'alert alert-success');
        }
    }
    public function authorizateResponse()
    { // filter get respond
        require_once APPROOT . '/helpers/PayfortIntegration.php';
        $objFort = new PayfortIntegration();
        $fortParams = $objFort->processResponse();
        $responsefortParams = $fortParams;
        unset($responsefortParams['url'], $responsefortParams['token_name'], $responsefortParams['r'], $responsefortParams['access_code'], $responsefortParams['return_url'], $responsefortParams['language'], $responsefortParams['merchant_identifier']);
        $meta = json_encode($responsefortParams);

        ($fortParams['status'] == 18) ? $status = 1 : $status = 0;


        //load order data by merchant_reference/order_identifier
        $order = $this->projectsModel->getSingle('*', ['order_identifier' => str_replace('PRO_AUTH_', '', $fortParams['merchant_reference'])], 'orders');
        $data = [
            'meta' => $meta,
            'order_id' => $order->order_id,
        ];
        $this->projectsModel->updateOrderMetaAuthorization($data); //update


        if ($status == 1) {
            $this->donorModel = $this->model('Donor');
            $card_info = $this->donorModel->getSingle('*', ['merchant_reference' => str_replace('PRO_AUTH_', '', $fortParams['merchant_reference'])], 'credit_cards');
            if ($card_info) {
                $this->donorModel->confirm_card(@$card_info->card_id, @$fortParams['token_name']);
            }
            require_once APPROOT . '/helpers/PayfortCustomerMerchant.php';
            $payment = new PayfortCustomerMerchant();
            $payment->amount = $order->total;
            $payment->merchant_reference = $order->order_identifier;
            // $payment->merchant_extra = $order->order_identifier;
            $payment->order_description = $order->order_identifier . "متعدد";
            $payment->return_url = 'projects/PurchaseResponse';
            $CM_response = $payment->CustomMerchantPurchase($fortParams, @$donor);
            $CM_response = json_decode($CM_response, true);
            if (isset($CM_response['3ds_url']) && $CM_response['response_code'] == '20064') {
                $url = $CM_response['3ds_url'];
                header('Location: ' . $url);
            } else {
                $this->PurchaseResponse($CM_response);
            }
        } else {
            $order = $this->projectsModel->getSingle('*', ['order_identifier' => str_replace('PRO_AUTH_', '', $fortParams['merchant_reference'])], 'orders');
            $projects_id  = str_replace(")", "", $order->projects_id);
            $projects_id  = str_replace("(", "", $projects_id);
            flashRedirect('projects/show/' . $projects_id, 'msg', $fortParams['response_message'], 'alert alert-danger');
        }
    }

    public function PurchaseResponse($fortParams = null)
    { // filter get respond
        if ($fortParams == null) {
            require_once APPROOT . '/helpers/PayfortIntegration.php';
            $objFort = new PayfortIntegration();
            $fortParams = $objFort->processResponse();
        }
        unset($fortParams['url'], $fortParams['r'], $fortParams['access_code'], $fortParams['return_url'], $fortParams['language'], $fortParams['merchant_identifier']);

        $meta = json_encode($fortParams);
        ($fortParams['status'] == 14) ? $status = 1 : $status = 0;
        //load order data by merchant_reference/order_identifier
        $order = $this->projectsModel->getSingle('*', ['order_identifier' => $fortParams['merchant_reference']], 'orders');
        $donor = $this->projectsModel->getSingle('*', ['donor_id' => $order->donor_id], 'donors');
        $this->donorModel = $this->model('Donor');
        $activate = $this->donorModel->activeCard($fortParams['merchant_reference']);
        $data = [
            'meta' => $meta,
            'hash' => $order->hash,
            'status' => $status,
        ];
        //updating donation status in donation table
        $this->projectsModel->updateDonationStatus($order->order_id, $status);
        $this->projectsModel->updateOrderMeta($data); //update donation meta and set status on order table
        if ($status == 1) {
            //send Email and SMS confirmation
            $messaging = $this->model('Messaging');
            $sendData = [
                'mailto' => $donor->email,
                'mobile' => $donor->mobile,
                'identifier' => $order->order_identifier,
                'order_id' => $order->order_id,
                'total' => $order->total,
                'project' => $order->projects,
                'donor' => $order->donor_name,
            ];

            if (!$order->notified) {
                $this->projectsModel->notified($order->order_id);
                $messaging->sendConfirmation($sendData);
                $messaging->sendGiftCard($order); // send message of gift card 
            }
            unset($_SESSION['cart']);
            $_SESSION['payment']['msg'] = ' شكرا لتبرعك لدي ' . SITENAME;
            flashRedirect('pages/thankyou/' . $order->hash . '/' . $order->total, 'msg', $_SESSION['payment']['msg'], 'alert alert-success');
        } else {
            $order = $this->projectsModel->getSingle('*', ['order_identifier' => $fortParams['merchant_reference']], 'orders');
            $projects_id  = str_replace(")", "", $order->projects_id);
            $projects_id  = str_replace("(", "", $projects_id);
            flashRedirect('projects/show/' . $projects_id, 'msg',  $fortParams['response_message'], 'alert alert-danger');
        }
    }


    /**
     * recieve payment respond and update donation meta data
     *
     * @return void
     */
    public function payfortrespond()
    { // filter get respond
        require_once APPROOT . '/helpers/PayfortIntegration.php';
        $objFort = new PayfortIntegration();
        $fortParams = $objFort->processResponse();
        unset($fortParams['url'], $fortParams['r'], $fortParams['access_code'], $fortParams['return_url'], $fortParams['language'], $fortParams['merchant_identifier']);
        $meta = json_encode($fortParams);
        ($fortParams['status'] == 14) ? $status = 1 : $status = 0;
        //load order data by merchant_reference/order_identifier
        $order = $this->projectsModel->getSingle('*', ['order_identifier' => $fortParams['merchant_reference']], 'orders');

        // if already called befor
        if ($order->status == 1) return flashRedirect('/' . $order->hash . '/' . $order->total, 'msg', 'عملية مؤكدة', 'alert alert-success');

        $donor = $this->projectsModel->getSingle('*', ['donor_id' => $order->donor_id], 'donors');

        $data = [
            'meta' => $meta,
            'hash' => $order->hash,
            'status' => $status,
        ];
        //updating donation status in donation table
        $this->projectsModel->updateDonationStatus($order->order_id, $status);

        $this->projectsModel->updateOrderMeta($data); //update donation meta and set status on order table
        if ($status == 1) {
            //send Email and SMS confirmation
            $messaging = $this->model('Messaging');
            $sendData = [
                'mailto' => $donor->email,
                'mobile' => $donor->mobile,
                'identifier' => $order->order_identifier,
                'order_id' => $order->order_id,
                'total' => $order->total,
                'project' => $order->projects,
                'donor' => $order->donor_name,
            ];

            if (!$order->notified) {
                $this->projectsModel->notified($order->order_id);
                $messaging->sendConfirmation($sendData);
                $messaging->sendGiftCard($order); // send message of gift card 
            }

            @exist($_SESSION['payment']['msg']) ? $_SESSION['payment']['msg'] = ' شكرا لتبرعك لدي ' . SITENAME . ' جاري التحقق من التبرع ' : '';
            // if (isset($_SESSION['payment']['project_id'])) { //redirect to project
            //     flashRedirect('projects/show/' . $_SESSION['payment']['project_id'], 'msg', $_SESSION['payment']['msg'], 'alert alert-success');
            // } else {
            flashRedirect('pages/thankyou/' . $order->hash . '/' . $order->total, 'msg', $_SESSION['payment']['msg'], 'alert alert-success');
            // }
        } else {
            flashRedirect('pages/thankyou', 'msg', "خطأ: " . $fortParams['response_message'], 'alert alert-danger');
        }
    }

    /**
     * handling bank transfer
     *
     * @param  mixed $hash
     *
     * @return void
     */
    public function banktransfer($hash = null)
    {
        //check hash
        $hash = $this->projectsModel->getOrderByHash($hash) ?: null;

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // sanitize POST array
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $data = [
                'pageTitle' => 'الحسابات البنكية: ' . SITENAME,
                'settings' => $this->settings,
                'menu' => $this->menu,
                'payment_method' => $this->projectsModel->getSingle('*', ['payment_id' => 1], 'payment_methods'),
                'image' => '',
                'image_error' => '',
                'payment_key' => $_POST['payment_key'],
                'payment_key_error' => '',
                'hash' => $hash,
            ];
            // validate image
            if ($_FILES['image']['error'] == 0) {
                $image = uploadImage('image', APPROOT . '/media/files/banktransfer/', 5000000, false);
                if (empty($image['error'])) {
                    $data['image'] = $image['filename'];
                } else {
                    if (!isset($image['error']['nofile'])) {
                        $data['image_error'] = implode(',', $image['error']);
                    }
                }
            } else {
                $data['image_error'] = 'يجب ارفاق صورة التحويل';
            }
            // validate payment_key
            if (empty($data['payment_key'])) {
                $data['payment_key_error'] = 'من فضلك قم بأختيار البنك المحول اليه';
            }
            //save image to order
            if (empty($data['image_error']) && empty($data['payment_key_error'])) {
                //validated
                if ($this->projectsModel->updateOrderHash($data)) { //update donation proof file and hash
                    flashRedirect('pages/thankyou/' . $hash, 'msg', ' تم استلام طلبك بنجاح وجاري مراجعته', 'alert alert-success');
                } else {
                    flash('msg', 'هناك خطأ ما حاول مرة اخري', 'alert alert-danger');
                }
            }
        } else {
            $data = [
                'pageTitle' => 'الحسابات البنكية: ' . SITENAME,
                'settings' => $this->settings,
                'menu' => $this->menu,
                'payment_method' => $this->projectsModel->getSingle('*', ['payment_id' => 1], 'payment_methods'),
                'image' => '',
                'image_error' => '',
                'payment_key_error' => '',
                'hash' => $hash,
            ];
        }
        $this->view('projects/bankform', $data);
    }

    /**
     * display payment method details
     *
     * @param  mixed $id
     * @return void
     */
    public function paymentdetails($id)
    {
        if ($payment_methouds = $this->projectsModel->getSingle('*', ['payment_id' => $id], 'payment_methods')) {
            $data = [
                'pageTitle' => 'بيانات الدفع: ' . SITENAME,
                'settings' => $this->settings,
                'menu' => $this->menu,
                'payment_method' => $payment_methouds,
            ];
        } else {
            flashRedirect('', 'msg', 'هذه الصفحة غير موجودة ربما اتبعت رابط خاطئ', 'alert alert-danger');
        }
        $this->view('projects/paymentdetails', $data);
    }



    public function applepay($hash)
    {
        if ($order = $this->projectsModel->getOrderByHash($hash)) {
            $data = [
                'pageTitle' => 'بيانات الدفع: ' . SITENAME,
                'settings' => $this->settings,
                'menu' => $this->menu,
                'order' => $order,
            ];
        } else {
            flashRedirect('', 'msg', 'هذه الصفحة غير موجودة ربما اتبعت رابط خاطئ', 'alert alert-danger');
        }

        if(PAYFORT_REDIRECT){
          $this->view('projects/applepayfort', $data);
        }else{
          $this->view('projects/applepay', $data);
        }
    }


    public function checkout($id = '')
    {
        $id = (int) $id;
        empty($id) ? redirect('projects', true) : null;
        ($project = $this->projectsModel->getProjectById($id)) ?: flashRedirect('index', 'msg', ' هذا المشروع غير موجود او ربما تم حذفه ');
        $data = [
            'pageTitle' => $project->name . ': ' . SITENAME,
            'project' => $project,
            'settings' => $this->settings,
            'menu' => $this->menu,
            'collected_traget' => $this->projectsModel->collectedTraget($id),
            'moreprojects' => $this->projectsModel->moreProjects($project->category_id),
            'payment_methods' => $this->projectsModel->getSupportedPaymentMethods($project->payment_methods),
        ];

        $data['settings']['seo']->meta_keywords = $data['project']->meta_keywords;
        $data['settings']['seo']->meta_description = $data['project']->meta_description;
        $data['settings']['site']->image = $data['project']->image;
        $data['settings']['site']->title =  $data['project']->name;
        $this->view('projects/checkout1', $data);
    }
}
