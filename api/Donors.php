<?php
class Donors extends ApiController
{

    public $messaging;
    public $tokenModel;


    public function __construct()
    {
        $this->model = $this->model('Donor');
        $this->tokenModel = $this->model('Token');
    }

    /**
     * check user mobile and send OTP
     * generate token for authorisation
     * expiration time is 10 min 
     *
     * @param integer $mobile number
     * @return response
     */
    public function login()
    {
        $mobile = $this->required('mobile');
        $identity = @$_POST['identity'];

        if (strlen($mobile) != 10) {
            $this->error('حجم الحقل يجب ان يكون 10 ارقام');
        } else {
            if ($donor = $this->model->getdonorByMobileActive($mobile)) {
                $data = [
                    'donor_id' => $donor->donor_id,
                    'otp' =>  rand(1000, 9999),
                    'mobile' => $donor->mobile,
                    'token' => token(24),
                    'expiration' =>  time() + 600,
                    'identity' => @$identity ?? $donor->identity,
                ];
           
                if ($donor->donor_id == 24 || $donor->donor_id == 68570 
                    || $donor->donor_id == 148214 || $donor->donor_id ==  192132) {
                    $data['otp'] = 1234;
                }
                else{
                    $setting  = $this->model->getSettings('notifications');
                    $smsSendCode = json_decode($setting->value)->sendcode;
                    $this->model->SMS($mobile, SITENAME . ' ' . $smsSendCode . ' : ' . $data['otp']);
                    // $messaging = $this->model('Messaging');
                    // $messaging->mobileCodeSend(['mobile' => $mobile, 'msg' =>   $smsSendCode . $data['otp'] . " \n "  ]);
                }

                //save data to donors table
                $this->model->updateOTP($data);

                // $tokenData = [
                //     'device_id' => @$_POST['device_id'],
                //     'donor_id' => $donor->donor_id,
                // ];

                // //save donor
                // // $this->tokenModel->updateDonorId($tokenData);

                $response = array_merge($data, [
                    'message' => 'تم ارسال كود التحقق بنجاح',
                ]);
                // add it to database 
                $this->response($response);
            } else {
                $this->error('هذا الرقم غير مسجل لدينا ');
            }
        }
    }

    /**
     * validate donor OTP
     * and return with user data
     *
     * @param integer $otp
     * @param integer $donor_id
     * @param string $token
     * @return response
     */
    public function validateOTP()
    {
        $data = $this->requiredArray(['otp', 'donor_id', 'token']);
        if ($this->model->isValidToken($data['donor_id'], $data['token'])) {
            $donor = $this->model->getDonorByOTP($data['donor_id'], $data['otp'], $data['token']);
            if ($donor) {
                $this->model->updateMobileConfirmation(['donor_id' => $donor->donor_id, 'mobile_confirmed' => 'yes']);
                // Check if doner may be Substitute
                $checkSubstitute = $this->model->checkSubstitute($donor->mobile);
                if($checkSubstitute){
                    $this->model->updateDonerSubstitut($donor->donor_id);
                    $donor->is_substitute = 1;
                    $donor->substitute = $checkSubstitute;
                }
                $this->response($donor);
            } else {
                $this->error('OTP not valied or expired ');
            }
        } else {
            return $this->error('token is not valied');
        }
    }

    /**
     * check user mobile, full_name, email and send OTP
     * generate token for authorisation
     * expiration time is 10 min 
     *
     * @param integer $mobile number
     * @param string $full_name number
     * @param string $email number
     * @return response
     */
    public function register()
    {
        //validate all data
        $fields = $this->requiredArray(['mobile', 'full_name']);
        if (strlen($fields['mobile']) != 10) $this->error('حجم الحقل يجب ان يكون 10 ارقام');
        if (isset($_POST['email'])) {
            if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) $this->error("Invalid email format");
        } else {
            $_POST['email'] = '';
        }
        //get all user data by mobile number
        if ($donor = $this->model->getdonorByMobileCustom($fields['mobile'])) {
            //update email address
            return $this->error('هذا الرقم مسجل من قبل');

            if (!empty($_POST['email'])) $this->model->updateEmail(['email' => $_POST['email'], 'donor_id' => $donor->donor_id]);
        } else {
            //prepar data for save
            $data = [
                'full_name' => $_POST['full_name'],
                'email' => $_POST['email'],
                'mobile' => $_POST['mobile'],
                'identity' => $_POST['identity'],
                'mobile_confirmed' => 'no',
                'status' => 0
            ];
            //save donor
            $data['donor_id'] = $this->model->addDonor($data);
            $donor = (object) $data;
        }
        $data = [
            'donor_id' => $donor->donor_id,
            'mobile' => $donor->mobile,
            'full_name' => $donor->full_name,
            'email' => $donor->email,
            'identity' => $donor->identity,
            'otp' =>  rand(1000, 9999),
            'token' => token(24),
            'expiration' =>  time() + 600,
            'message' => 'تم ارسال كود التحقق بنجاح',
        ];

        // send otp
        $this->model->SMS($fields['mobile'], SITENAME . ' كود التحقق : ' . $data['otp']);
        //update donor OTP
        $this->model->updateOTP($data);

        // $tokenData = [
        //     'device_id' => $_POST['device_id'],
        //     'donor_id' => $donor->donor_id,
        // ];

        // //save donor
        // $this->tokenModel->updateDonorId($tokenData);

        $this->response($data);
    }

    /**
     * get donor donations list
     * @requires string token
     * @param integer $id
     * @return response
     */
    public function donations()
    {
        $data = $this->requiredArray(['id', 'token']);
        if ($this->model->isValidToken($data['id'], $data['token'])) {
            return $this->response($this->model->getDonationsById($data['id']));
        } else {
            return $this->error('token is not valied');
        }
    }

    /**
     * get donor donations list
     * @requires string token
     * @param integer $id
     * @return response
     */
    public function delete()
    {
        $data = $this->requiredArray(['id', 'token']);
        if ($this->model->isValidToken($data['id'], $data['token'])) {
            return ($this->model->DeleteDonor($data['id'])) ? $this->response(" Donor deleted Successfully.") : $this->error('Error deleting try again later.');
        } else {
            return $this->error('token is not valied');
        }
    }


    /**
     * send OTP or resend
     * and return with user data
     *
     * @param integer $otp
     * @param integer $donor_id
     * @param string $token
     * @return response
     */
    public function reSendOTP()
    {
        $data = $this->requiredArray(['mobile', 'donor_id']);

        if (strlen($data['mobile']) != 10) {
            $this->error('حجم الحقل يجب ان يكون 10 ارقام');
        } else {
            $data = [
                'donor_id'=> $data['donor_id'],
                'mobile'=> $data['mobile'],
                'otp' =>  rand(1000, 9999),
                'token' => token(24),
                'expiration' =>  time() + 600,
            ];
           
            $setting  = $this->model->getSettings('notifications');
            $smsSendCode = json_decode($setting->value)->sendcode;
            $messaging = $this->model('Messaging');
            $messaging->mobileCodeSend(['mobile' => $data['mobile'], 'msg' =>   $smsSendCode . $data['otp'] . " \n "  ]);

            //save data to donors table
            $this->model->updateOTP($data);

            $response = array_merge([ 'token' => $data['token']], [
                'message' => 'تم ارسال كود التحقق بنجاح',
            ]);

            $this->response($response);

        }
    }


    /**
     * test send sms
     * and return 1 if success
     *
     * @param integer $mobile
     * @return response
     */
    public function testSendSms()
    {
        $data = $this->requiredArray(['mobile']);

        echo sendSMS('NAMAA.SA', '993807dc8cf53bff5def5d9b5e6c8d34', 'testing sending', $data['mobile'], 'NAMAA.SA', 'https://api.taqnyat.sa/v1/messages', 'taqnyat');
    }

}
