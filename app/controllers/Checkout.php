<?php

class Checkout extends Controller
{
    private $projectsModel;
    private $cartModel;
    public $donorModel;
    public $settings;
    public $menu;
    public $testMode = TEST_MODE;

    public function __construct()
    {
        $this->projectsModel = $this->model('Project');
        $this->settings = $this->projectsModel->getSettings();
        $this->cartModel = $this->model('Cart');
        $this->menu = $this->cartModel->getMenu();
        $this->donorModel = $this->model('Donor');
    }

    public function cart()
    {
        $data = [
            'settings' => $this->settings,
            'menu' => $this->menu,
            'payment_methods' => $this->cartModel->getFromTable('payment_methods', '*', ['status' => 1, 'cart_show' => 1]),
            'pageTitle' => 'الرئيسية: ' . SITENAME,
        ];
        // dd($_SESSION['cart']['items'] );
        $this->view('checkout/carts', $data);
    }



    public function index()
    {
        // filtter post data
        $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $mobile = @$_SESSION['login']; //= "0555555555";
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            // $donor = $this->donorModel->getdonorByMobile($mobile);
            $donor = $this->donorModel->getdonorByMobile($_POST['mobile'] ?? $mobile);
            $data = [
                'pageTitle'             =>  'الدفع: ' . SITENAME,
                'settings'              => $this->settings,
                'menu'                  => $this->menu,
                'payment_methods'       => $this->cartModel->getFromTable('payment_methods', '*', ['status' => 1, 'cart_show' => 1]),
                'donor'                 => $donor,
                'cards'                 => $this->donorModel->getDonationcards(@$donor->donor_id),
                'payments_methods'      => $this->projectsModel->getSingle('*', ['payment_id' => 1], 'payment_methods'),
                'full_name'             => @$_POST['full_name'],
                'mobile'                => @$_POST['mobile'],
                'email'                 => @$_POST['email'],
                'identity'              => @$_POST['identity'],
                'payment_method'        => @$_POST['payment_method'],
                'card_number'           => @$_POST['card_number'],
                'expired_month'         => @$_POST['expired_month'],
                'expired_year'          => @$_POST['expired_year'],
                'cvv'                   => @$_POST['cvv'],
                'card_name'             => @$_POST['card_name'],
                'payment_key'           => @$_POST['payment_key'],
                'selected_card'         => @$_POST['selected_card'],
                'selected_cvv'          => @$_POST['selected_cvv'],
                'image'                 => '',
                'full_name_error'       => '',
                'mobile_error'          => '',
                'identity_error'        => '',
                'email_error'           => '',
                'payment_method_error'  => '',
                'card_number_error'     => '',
                'exp_date_error'        => '',
                'cvv_error'             => '',
                'card_name_error'       => '',
                'payment_key_error'     => '',
                'image_error'           => '',
                'recaptcha_error'       => '',
            ];
            // validate recaptcha
            if (!recaptcha()) {
                $data['recaptcha_error'] = "خطأ بكود التحقق";
                flash('msg', 'خطأ بكود التحقق ', 'alert alert-danger');
                return $this->view('checkout/index', $data);
            }
            // validate donor data 
            $data['full_name_error'] = !(empty($data['full_name'])) ? '' :   'من فضلك قم بكتابة الاسم بالكامل';
            $data['mobile_error'] = !(empty($data['mobile'])) ? '' :   'من فضلك قم بكتابة رقم الجوال';
            $data['email_error'] = !(empty($data['email'])) ? '' :   'من فضلك قم بكتابةالبريد الاكتروني';

            // check if identify is already exist or not 
            if( !empty($data['identity']) ){
                $checkIdentify = $this->donorModel->checkIdentify($_POST);
                if($checkIdentify){
                    $data['identity_error'] = 'هذا الهوية مسجل من قبل ';
                    $data['donor'] = "";
                    flash('msg', 'هناك خطأ ما حاول مرة خري', 'alert alert-danger');
                    goto page;
                }
              }
            // validate bank transfer
            if ($data['payment_method'] == "1") {
                !(empty($data['payment_key'])) ? $data['payment_key_error'] = '' : $data['name_error'] =  'من فضلك قم باختار البنك المحول';
                // validate image
                if (@$_FILES['image']['error'] == 0) {
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
                // check errors
                if (
                    !empty($data['full_name_error']) || !empty($data['mobile_error']) || !empty($data['email_error']) || !empty($data['payment_method_error'])
                    || !empty($data['payment_key_error']) | !empty($data['image_error'])  ||  !empty($data['recaptcha_error'])
                ) {
                    flash('msg', 'هناك خطأ ما حاول مرة اخري', 'alert alert-danger');
                    goto page;
                }
            } elseif ($_POST['payment_method'] == "3") { // validate payment cart 
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
                        flash('msg', 'يجب اضافه الرقم السري', 'alert alert-danger');
                        goto page;
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
                if (
                    !empty($data['full_name_error']) || !empty($data['mobile_error']) || !empty($data['email_error']) || !empty($data['payment_method_error'])
                    || !empty($data['card_number_error']) | !empty($data['exp_date_error']) ||  !empty($data['cvv_error']) ||  !empty($data['recaptcha_error'])
                ) {
                    flash('msg', 'هناك خطأ ما حاول مرة اخري', 'alert alert-danger');
                    goto page;
                }
            }

            if($_POST['payment_method']  != "1"){
                $data['payment_key'] = $this->projectsModel->getPaymentKey($_POST['payment_method'])[0]->payment_key; // update payment_key to Visa Ecom or ApplePay
            }

            // saving donor data
            $_SESSION['payment'] = $_POST;
            //loading donor model
            $this->donorModel = $this->model('Donor');
            //check if exist donor and return its id
            if ($donor = $this->donorModel->getdonorByMobile($_POST['mobile'])) {
                if ($donor->mobile_confirmed == 'no') {
                    $donordata = ['mobile_confirmed' => $_POST['mobile_confirmed'], 'donor_id' => $donor->donor_id];
                    $this->donorModel->updateMobileConfirmation($donordata);
                }

                if (empty($donor->email) || !filter_var($donor->email, FILTER_VALIDATE_EMAIL)) {
                    $data = ['email' => $_POST['email'], 'donor_id' => $donor->donor_id];
                    $this->donorModel->updateEmail($data);
                }
                // add identity field
                if (empty($donor->identity) && !empty($data['identity'])) {
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
            //generat secrit hash
            $hash = sha1(time() . rand(999, 999999));
            $_SESSION['payment']['hash'] = $hash; // saving donation hash into session
            $projects = [];
            $projects_id = [];
            $card_project_ids = [];
            $card_projects = [];
            $deceased = null;
            $validData = true;
            foreach ($_SESSION['cart']['items'] as $item) {
                $projects[] = $item['name'];
                $projects_id[] = "(" . $item['project_id'] . ")";
                $deceased = ($item['deceased_id']) ? $item['deceased_id'] :  $deceased;
                $card_project_ids[] = $item['project_id'];
                $card_projects[$item['project_id']] = $item['name'];
                 if($item['quantity'] < 1 ) { $validData = false; } 
            }
            // saving order project id
            $_SESSION['payment']['project_id'] = null;
            //saving order
            $orderdata = [
                'order_identifier' => $this->projectsModel->uniqNum(),
                'total' => $_POST['total'],
                'quantity' => $_SESSION['cart']['totalQty'],
                // 'payment_method_key'    => $this->projectsModel->getPaymentKey($_POST['payment_method'])[0]->payment_key,
                'payment_method_id' => $_POST['payment_method'],
                'payment_method_key'    => $data['payment_key'] ?: $this->projectsModel->getPaymentKey($_POST['payment_method'])[0]->payment_key,
                'banktransferproof' => $data['image'],
                'hash' => $hash,
                'gift' => 0,
                'gift_data' => '',
                'projects_id' => implode(',', $projects_id),
                'projects' => implode(',', $projects),
                'deceased_id' => $deceased,
                'store_id' => $_SESSION['store']->store_id,
                'donor_id' => $donor,
                'donor_name' => $_POST['full_name'],
                'status' => 0,
            ];
            //save order data through saving method
            if (empty($orderdata['projects_id']) || empty($orderdata['projects']) || !$validData ) {
                flashRedirect('checkout', 'msg', 'حدث خطأ ما اثناء معالجة طلبك من فضلك حاول مره اخري', 'alert alert-danger');
            }
            //save order data through saving method
            if (!$this->projectsModel->addOrder($orderdata)) {
                flashRedirect('checkout', 'msg', 'حدث خطأ ما اثناء معالجة طلبك من فضلك حاول مره اخري', 'alert alert-danger');
            }
            $order_id = $this->projectsModel->lastId();
            // saving donations
            foreach ($_SESSION['cart']['items']  as $item) {
                $data = [
                    'amount' => $item['amount'],
                    'total' => ($item['amount'] * $item['quantity']),
                    'quantity' => $item['quantity'],
                    'donation_type' => $item['donation_type'],
                    'project_id' => $item['project_id'],
                    'order_id' => $order_id,
                    'status' => 0,
                ];
                //save donation data through saving method
                if (!$this->projectsModel->addDonation($data)) {
                    flashRedirect('carts', 'msg', 'حدث خطأ ما اثناء معالجة طلبك من فضلك حاول مره اخري', 'alert alert-danger');
                }
            }
            $messaging = $this->model('Messaging');
            $sendData = [
                'mailto' => $_POST['email'],
                'mobile' => $_POST['mobile'],
                'identifier' => $orderdata['order_identifier'],
                'order_id' => $order_id,
                'total' => $_POST['total'],
                'project' => implode(',', $projects),
                'donor' => $_POST['full_name'],
                'subject' => 'تم تسجيل تبرع جديد ',
                'msg' => "تم تسجيل تبرع جديد  :  <br/> بقيمة : " . $_POST['total'],
            ];

            // save message data to session 
            $_SESSION['sendData'] = $sendData;
            //send message to external store manager
            if (@exist($_SESSION['store']->email)) {
                $messaging->Email($_SESSION['store']->email, 'تنبيه للتاجر : ' . $sendData['subject'], $sendData['msg']);
            }
            $messaging->donationAdminNotify($sendData);
            // send message to donor 
            $messaging->donationDonorNotify($sendData);
            // send whatsapp message to donor 
            $messaging->ReciveOrdersApp("$sendData[mobile]", "$sendData[donor]", " $sendData[identifier]", "$_POST[total]", 'namaa.sa');

            if ($_POST['payment_method'] == 1) { // banktransfer
                //empty cart clear session 
                unset($_SESSION['cart']);
                flashRedirect('pages/thankyou/' . $orderdata['hash'], 'msg', ' تم استلام طلبك بنجاح وجاري مراجعته', 'alert alert-success');
            }

            require_once APPROOT . '/helpers/PayfortCustomerMerchant.php';
            $payment = new PayfortCustomerMerchant();
            $payment->return_url = 'checkout/authorizateResponse';
            $payment->merchant_reference = 'AUTH3_' . $orderdata['order_identifier'];
            if ($this->testMode) {
                $redirectUrl = 'https://sbcheckout.PayFort.com/FortAPI/paymentPage';
            } else {
                $redirectUrl = 'https://checkout.PayFort.com/FortAPI/paymentPage';
            }
            $this->donorModel->updateMerchant(@$_POST['selected_card'], 'AUTH3_' . $orderdata['order_identifier']);
            @exist($_POST['email']) ? $customerEmail = $_POST['email'] : $customerEmail = 'test@payfort.com';
            // if checked to save card 
            if (@$_POST['savecard'] == "on") {
                $carddata['number']                 = openssl_encrypt_card($card_data['card_number']);
                $carddata['expired_month']          = encrypt($_POST['expired_month']);
                $carddata['expired_year']           = encrypt($_POST['expired_year']);
                $carddata['name']                   = base64_encode($_POST['card_name']);
                $carddata['donor_id']               = $donor;
                $carddata['merchant_reference']     = $orderdata['order_identifier'];
                $carddata['default']                = 1;
                $this->donorModel->savecard($carddata);
            }

            if ($_POST['payment_method'] == 3) {  //payment with payfort (Visa)
                $payment->paymentMethod = 'visa';
            } elseif ($_POST['payment_method'] == 4) {  //payment with payfort installment
                // $payment->paymentMethod = 'installments';
                require_once APPROOT . '/helpers/PayfortIntegration.php';
                $objFort = new PayfortIntegration();
                $objFort->mr = $orderdata['order_identifier'];
                $objFort->amount = $_POST['total'];
                $objFort->projectUrlPath = SITEFOLDER . '/projects';
                $objFort->itemName = 'Cart Donation';
                $objFort->customerEmail = $customerEmail;
                $request = $objFort->processRequest('installments');
                if ($this->testMode) {
                    $redirectUrl = 'https://sbcheckout.payfort.com/FortAPI/paymentPage';
                } else {
                    $redirectUrl = 'https://checkout.payfort.com/FortAPI/paymentPage';
                }
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
            } elseif ($_POST['payment_method'] == 5) { //STCPAY
                require_once APPROOT . '/helpers/PayfortSandBox.php';
                $objFort = new PayfortIntegration();
                $objFort->mr = $orderdata['order_identifier'];
                $objFort->amount = $_POST['total'];
                $objFort->projectUrlPath = SITEFOLDER . '/projects';
                $objFort->itemName = 'Cart Donation';
                $objFort->customerEmail = $customerEmail;
                $request = $objFort->processRequest('STCPAY');
                if ($this->testMode) {
                    $redirectUrl = 'https://sbcheckout.payfort.com/FortAPI/paymentPage';
                } else {
                    $redirectUrl = 'https://checkout.payfort.com/FortAPI/paymentPage';
                }
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
            } elseif ($_POST['payment_method'] == 10) { // ApplPay
                redirect('projects/applepay/' . $hash, true);
            } else { //other
                //redirect to payment information
                empty($project->thanks_message) ? $project->thanks_message = 'شكرا لتبرعك لدي ' . SITENAME : null;
                flashRedirect('projects/paymentdetails/' . $_POST['payment_method'], 'msg', 'شكرا لتبرعك لدي ' . SITENAME, 'alert alert-success');
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
        } else {
            $donor = $this->donorModel->getDonationsByRelations($mobile);
            $data = [
                'pageTitle'             =>  'الدفع: ' . SITENAME,
                'settings'              => $this->settings,
                'menu'                  => $this->menu,
                'payment_methods'       => $this->cartModel->getFromTable('payment_methods', '*', ['status' => 1, 'cart_show' => 1]),
                'donor'                 =>  $donor,
                'cards'                 => $this->donorModel->getDonationcards(@$donor->donor_id),
                'payments_methods'      => $this->projectsModel->getSingle('*', ['payment_id' => 1], 'payment_methods'),
                'full_name'             => '',
                'mobile'                => '',
                'identity'              => '',
                'email'                 => '',
                'payment_method'        => '',
                'card_number'           => '',
                'expired_month'         => '',
                'expired_year'          => '',
                'cvv'                   => '',
                'card_name'             => '',
                'payment_key'           => '',
                'selected_card'         => '',
                'selected_cvv'          => '',
                'image'                 => '',
                'full_name_error'       => '',
                'mobile_error'          => '',
                'email_error'           => '',
                'identity_error'        => '',
                'payment_method_error'  => '',
                'card_number_error'     => '',
                'exp_date_error'         => '',
                'cvv_error'             => '',
                'card_name_error'       => '',
                'payment_key_error'     => '',
                'image_error'           => '',
                'recaptcha_error'       => '',
            ];
        }
        page:
        $this->view('checkout/index', $data);
    }



    public function authorizateResponse()
    { // filter get respond
        require_once APPROOT . '/helpers/PayfortIntegration.php';
        $objFort = new PayfortIntegration();
        $fortParams = $objFort->processResponse();
        $responsefortParams = $fortParams;
        unset($responsefortParams['url'], $responsefortParams['token_name'], $responsefortParams['r'], $responsefortParams['access_code'], $responsefortParams['return_url'], $responsefortParams['language'], $responsefortParams['merchant_identifier']);
        $meta = json_encode($responsefortParams);

        // $this->donorModel->confirm_card($card_info->card_id, $fortParams['token_name']);
        $order = $this->projectsModel->getSingle('*', ['order_identifier' => str_replace('AUTH3_', '', $fortParams['merchant_reference'])], 'orders');

        $data = [
            'meta' => $meta,
            'order_id' => $order->order_id,
        ];
        $this->projectsModel->updateOrderMetaAuthorization($data); //update


        ($fortParams['status'] == 18) ? $status = 1 : $status = 0;
        //load order data by merchant_reference/order_identifier
        if ($status == 1) {
            // $card_info = $this->donorModel->getSingle('*', ['merchant_reference' => str_replace('AUTH3_', '', $fortParams['merchant_reference'])], 'credit_cards');
            require_once APPROOT . '/helpers/PayfortCustomerMerchant.php';
            $payment = new PayfortCustomerMerchant();
            $payment->amount = $order->total;
            $payment->merchant_reference = $order->order_identifier;
            // $payment->merchant_extra = $order->order_identifier;
            $payment->order_description = @$order->order_identifier . "متعدد" ?? "Checkout";
            $payment->return_url = 'checkout/PurchaseResponse';
            $CM_response = $payment->CustomMerchantPurchase($fortParams, $donor);
            $CM_response = json_decode($CM_response, true);
            if (isset($CM_response['3ds_url']) && $CM_response['response_code'] == '20064') {
                $url = $CM_response['3ds_url'];
                header('Location: ' . $url);
            } else {
                $this->PurchaseResponse($CM_response);
            }
        } else {
            flashRedirect('checkout', 'msg', $fortParams['response_message'], 'alert alert-danger');
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

        // if already called befor
        if ($order->status == 1) return flashRedirect('/' . $order->hash . '/' . $order->total, 'msg', 'عملية مؤكدة', 'alert alert-success');


        $donor = $this->projectsModel->getSingle('*', ['donor_id' => $order->donor_id], 'donors');
        $this->donorModel->activeCard($fortParams['merchant_reference']);
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
            flashRedirect('checkout', 'msg',  $fortParams['response_message'], 'alert alert-danger');
        }
    }
}
