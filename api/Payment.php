<?php


class Payment extends ApiController
{
    public $model;
    public    $SHARequestPhrase = '82rJ.pmZVuyq1QaaTERA07@?'; //'egvierrbvjb';

    public function __construct()
    {
        $this->model = $this->model('Project');
    }

    /**
     * get all payment methods
     *
     * @return response
     */
    public function methods()
    {
        $methods = $this->model->getFromTable('payment_methods', 'payment_id, title, payment_key');
        return $this->response($methods);
    }

    /**
     * get all Bank accounts
     *
     * @return response
     */
    public function bankAccounts()
    {
        $bankaccounts = $this->model->getBankAccounts();
        $bankaccounts = json_decode($bankaccounts->meta);
        $banks = [];
        if($bankaccounts){
            foreach($bankaccounts as $bankaccount){
                $banks[] = [
                    'image'         => MEDIAURL . '/' . $bankaccount->image,
                    'bankname'      =>  $bankaccount->bankname,
                    'account_type'  =>  $bankaccount->account_type,
                    'iban'          =>  $bankaccount->iban,
                    'payment_key'   =>  $bankaccount->payment_key,
                    'url'           =>  $bankaccount->url,
                ];
            }
        }
        return $this->response($banks);
    }

    /**
     * calculate request signature and generare Token Request
     * @param string $device_id
     * @return response
     */
    public function tokenRequest()
    {
        $data = $this->requiredArray(['device_id', 'isApplePay']);
        // How to calculate request signature
        $shaString  = '';


        $test = false;

        if ($test) {
            $identifier = 'KTToIJFr';
            $url = 'https://sbpaymentservices.payfort.com/FortAPI/paymentApi';

            if ($data['isApplePay'] == 'false') {
                $accessCode = 'N0qFZwdUYTxibxDpnsef';
                $this->SHARequestPhrase = 'vuyculflgluv';
            } else {
                $accessCode = '3SVETdHDjxuJrhF099qX';
                $this->SHARequestPhrase = '65TNlKz4amrEH9TVJkIzEJ_?';
            }
        } else {
            $identifier = 'BiZjlLxK';
            $url = 'https://paymentservices.payfort.com/FortAPI/paymentApi';

            if ($data['isApplePay'] == 'false') {
                $accessCode = 'PFEiLpPP5luIGAsOyoFy';
                $this->SHARequestPhrase = 'egvierrbvjb';
            } else {
                $accessCode = 'nB4tY4pRnItey1PwrGCM';
                $this->SHARequestPhrase = $this->SHARequestPhrase;
            }
        }
        // array request
        $arrData = [
            'service_command' => 'SDK_TOKEN',
            'access_code' => $accessCode,
            'merchant_identifier' => $identifier,
            'language' => 'ar',
            'device_id' => $data['device_id']
        ];
        ksort($arrData);
        foreach ($arrData as $k => $v) {
            $shaString .= "$k=$v";
        }
        $shaString = $this->SHARequestPhrase . $shaString . $this->SHARequestPhrase;
        $signature = hash('sha256', $shaString);
        $arrData['signature'] = $signature;
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => json_encode($arrData),
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json'
            ),
        ));

        $response = json_decode(curl_exec($curl));

        curl_close($curl);
        $this->response($response);
    }



    // Start AlMarwaaaa---------------------------------------------------------

    public function PURCHASE()
    {
        $data = [
            'command'               => 'PURCHASE',
            "access_code"           => "N0qFZwdUYTxibxDpnsef",
            "merchant_identifier"   => "KTToIJFr",
            'merchant_reference'    =>  'XYZ' . rand(1000, 9999) . '-' . generateRandomString(2) . rand(100, 999),
            'amount'                => '200',
            'currency'              => 'SAR',
            'language'              => 'ar',
            'customer_email'        => 'almarwa.wagdy@gmail.com',
            'customer_name'         => "AlMarwa Wagdy ElMonshed",
            'token_name'            => '4d35e17ed83e4a20a57b15ca9fd32167',
            
        ];
        //   cal signature -----------------------------
        ksort($data);
        $this->SHARequestPhrase = 'vuyculflgluv';
        $shaString  = '';
        foreach ($data as $k => $v) {
            $shaString .= "$k=$v";
        }
        $shaString = $this->SHARequestPhrase . $shaString . $this->SHARequestPhrase;
        $signature = hash('sha256', $shaString);
        // $this->response($signature);
        $data['signature'] = $signature;

        $url = 'https://sbpaymentservices.payfort.com/FortAPI/paymentApi';


        $ch = curl_init($url);
        # Setup request to send json via POST.
        $data = json_encode($data);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
        # Return response instead of printing.
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        # Send request.
        $result = curl_exec($ch);
        curl_close($ch);
        # Print response.
        $this->response(json_decode($result));
    }

    public function refreshToken()
    {

//  start test --------------------------------------------------------------------------------------
        $requestParams = array(
            'command' => 'AUTHORIZATION',
            'access_code'           => 'N0qFZwdUYTxibxDpnsef',
            'merchant_identifier'   => 'KTToIJFr',
            'merchant_reference'    =>  'XYZ' . rand(1000, 9999) . '-' . generateRandomString(2) . rand(100, 999),
            'amount'                => '10000',
            'currency' => 'AED',
            'language' => 'ar',
            'customer_email' => 'test@payfort.com',
            'order_description' => 'iPhone 6-S',
            'order_description' => 'iPhone 6-S'
            );
            ksort($requestParams);
            $this->SHARequestPhrase = 'vuyculflgluv';
            $shaString  = '';
            foreach ($requestParams as $k => $v) {
                $shaString .= "$k=$v";
            }
            $shaString = $this->SHARequestPhrase . $shaString . $this->SHARequestPhrase;
            $signature = hash('sha256', $shaString);
            // $this->response($signature);
            $requestParams['signature'] = $signature;
            
            $redirectUrl = 'https://sbcheckout.payfort.com/FortAPI/paymentPage';
            echo "<html xmlns='https://www.w3.org/1999/xhtml'>\n<head></head>\n<body>\n";
            echo "<form action='$redirectUrl' method='post' name='frm'>\n";
            foreach ($requestParams as $a => $b) {
                echo "\t<input type='hidden' name='".htmlentities($a)."' value='".htmlentities($b)."'>\n";
            }
            echo "\t<script type='text/javascript'>\n";
            echo "\t\tdocument.frm.submit();\n";
            echo "\t</script>\n";
            echo "</form>\n</body>\n</html>";
//  End test --------------------------------------------------------------------------------------

        // $data = [
        //     'service_command'       => 'CREATE_TOKEN',
        //     "access_code"           => "N0qFZwdUYTxibxDpnsef",
        //     "merchant_identifier"   => "KTToIJFr",
        //     'merchant_reference'    =>  'XYZ' . rand(1000, 9999) . '-' . generateRandomString(2) . rand(100, 999),
        //     'amount'                => '200',
        //     'currency'              => 'SAR',
        //     'language'              => 'ar',
        // ];
       
        // //   cal signature -----------------------------
        // ksort($data);
        // $this->SHARequestPhrase = 'vuyculflgluv';
        // $shaString  = '';
        // foreach ($data as $k => $v) {
        //     $shaString .= "$k=$v";
        // }
        // $shaString = $this->SHARequestPhrase . $shaString . $this->SHARequestPhrase;
        // $signature = hash('sha256', $shaString);
        // // $this->response($signature);
        // $data['signature'] = $signature;
        // $data['expiry_date'] = "2505";
        // $data['card_number'] = "4005550000000001";

        // dd($data);
        // $url = 'https://sbcheckout.PayFort.com/FortAPI/paymentPage';


        // $ch = curl_init($url);
        // # Setup request to send json via POST.
        // $data = json_encode($data);
        // curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        // curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
        // # Return response instead of printing.
        // curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        // # Send request.
        // $result = curl_exec($ch);
        // curl_close($ch);
        // # Print response.
        // $this->response(json_decode($result));
    }
    // End AlMarwaaaa---------------------------------------------------------
    public function test()
    {
         
        //  $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
         print_r($_POST);
       return response([
        'name' => 'almarwa'
       ]);
    }
}
