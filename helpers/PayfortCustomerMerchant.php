<?php

class PayfortCustomerMerchant{


    public $testMode = TEST_MODE;
    public $SHARequestPhrase        = '82rJ.pmZVuyq1QaaTERA07@?'; //'egvierrbvjb';
    public $SHAResponsePhrase        = 'fvywgyswiui'; //'egvierrbvjb';
    public $amount                  = 100;
    public $currency                = 'SAR';
    public $language                = 'ar';
    public $return_url              = '/';
    public $merchant_reference      ='';
    public $paymentMethod           ='';
    public $order_description       = '';
    // public $merchant_extra          ='';

    public function getUrl($path) {
        $scheme = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https://' : 'https://';
            $url = $scheme . 'namaa.sa' . '/' . $path;
            // $url = $scheme . 'namaa.sa/devtest' . '/' . $path;
        return $url;
    }
    
    /**
     * Convert Amount with dicemal points
     * @param decimal $amount
     * @param string  $currencyCode
     * @return decimal
     */
    public function convertFortAmount($amount, $currencyCode){
        $new_amount = 0;
        $total = $amount;
        $decimalPoints = $this->getCurrencyDecimalPoints($currencyCode);
        $new_amount = round((float)$total, (float)$decimalPoints) * (pow(10, $decimalPoints));
        return $new_amount ?? 0;
    }

    /**
     *
     * @param string $currency
     * @param integer
     */
    public function getCurrencyDecimalPoints($currency){
        $decimalPoint = 2;
        $arrCurrencies = array(
            'JOD' => 3,
            'KWD' => 3,
            'OMR' => 3,
            'TND' => 3,
            'BHD' => 3,
            'LYD' => 3,
            'IQD' => 3,
        );
        if (isset($arrCurrencies[$currency])) {
            $decimalPoint = $arrCurrencies[$currency];
        }
        return $decimalPoint;
    }

    public function calculateSignature($requestData = []){
        $shaString  = '';
        ksort($requestData);
        foreach ($requestData as $k => $v) {
            $shaString .= "$k=$v";
        }
        $shaString = $this->SHARequestPhrase . $shaString . $this->SHARequestPhrase;
        $signature = hash('sha256', $shaString);
        return  $signature;
    }

    public function CustomMerchantToken($cardInfo = null) {
        if ($this->testMode) {
            $identifier = 'KTToIJFr';
            $accessCode = 'N0qFZwdUYTxibxDpnsef';
            $this->SHARequestPhrase = 'vuyculflgluv';
            $url = 'https://sbpaymentservices.payfort.com/FortAPI/paymentApi';
        } else {
            $identifier = 'BiZjlLxK';
            $accessCode = 'PFEiLpPP5luIGAsOyoFy';
            $this->SHARequestPhrase = 'egvierrbvjb';
            $this->SHAResponsePhrase = 'fvywgyswiui';
            $url = 'https://paymentservices.payfort.com/FortAPI/paymentApi';
        }
        $requestParams = [
            'service_command'         => 'TOKENIZATION',
            'language'                => $this->language,
            'merchant_identifier'     => $identifier,
            'access_code'             => $accessCode,
            'return_url'              => $this->getUrl($this->return_url),
            'merchant_reference'      => $this->merchant_reference,
        ];
        $signature = $this->calculateSignature($requestParams);
        $requestParams['signature'] = $signature;
        $requestParams['card_number'] = $cardInfo['card_number'];
        $requestParams['expiry_date'] = $cardInfo['expiry_date'];
        $requestParams['card_security_code'] = $cardInfo['card_security_code'];
        $requestParams['card_holder_name'] = $cardInfo['card_holder_name'];
        return $requestParams;
    }
    
    public function CustomMerchantPurchase($fortParams, $donor = null ){
        if ($this->testMode) {
            $this->SHARequestPhrase = 'vuyculflgluv';
            $url = 'https://sbpaymentservices.payfort.com/FortAPI/paymentApi';
        } else {
            $this->SHARequestPhrase = 'egvierrbvjb';
            $this->SHAResponsePhrase = 'fvywgyswiui';
            $url = 'https://paymentservices.payfort.com/FortAPI/paymentApi';
        }
        $data = [
            'command'               => 'PURCHASE',
            "access_code"           => $fortParams['access_code'],
            "merchant_identifier"   => $fortParams['merchant_identifier'],
            'merchant_reference'    => $this->merchant_reference,
            'language'              => $this->language,
            'amount'                => $this->convertFortAmount($this->amount, $this->currency),
            'currency'              => $this->currency,
            'customer_email'        => @$donor->email ?? 'almarwa.wagdy@gmail.com',
            'customer_ip'           => $_SERVER['REMOTE_ADDR'],
            // 'merchant_extra'        => $this->merchant_extra,
            'customer_name'         => @$donor->full_name ?? "AlMarwa Wagdy ElMonshed",
            'token_name'            => $fortParams['token_name'],
            'return_url'            => $this->getUrl($this->return_url),
            'order_description'     => substr(str_replace(',', ' - ', $this->order_description??"cart"),0 , 50),
        ];

        if ($this->paymentMethod == 'sadad') {
            $data['payment_option'] = 'SADAD';
        } elseif ($this->paymentMethod  == 'naps') {
            $data['payment_option'] = 'NAPS';
            $data['order_description'] = $this->order_description;
        } elseif ($this->paymentMethod  == 'installments') {
            $data['installments'] = 'STANDALONE';
        } elseif ($this->paymentMethod == 'STCPAY') {
            $data['digital_wallet'] = 'STCPAY';
        }



       $data['signature'] = $this->calculateSignature($data);
        $ch = curl_init($url);
        # Setup request to send json via POST.
        $data = json_encode($data);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
        header('Content-Type: application/json');
        # Return response instead of printing.
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        # Send request.
        $result = curl_exec($ch);
        $this->log($result);
        curl_close($ch);
        
        
        return $result;
    }


    
    /**
     * Log the error on the disk
     */
    public function log($messages)
    {
        $messages = "========================================================\n\n" . $messages . "\n\n";
        $file = __DIR__ . '/trace_payment.log';
        if (filesize($file) > 907200) {
            $fp = fopen($file, "r+");
            ftruncate($fp, 0);
            fclose($fp);
        }

        $myfile = fopen($file, "a+");
        fwrite($myfile, $messages);
        fclose($myfile);
    }
}
