<?php


class Orders extends ApiController
{
    public $model;
    public $projectModel;
    public $donorModel;
    public $testModel;
    public $BadalOrder;
    public $ritual;

    public function __construct()
    {
        $this->model = $this->model('Order');
        $this->projectModel = $this->model('Project');
        $this->donorModel = $this->model('Donor');
        $this->testModel = $this->model('Test');
        $this->BadalOrder = $this->model('Badalorder');
        $this->ritual = $this->model('Ritual');
    }

    /**
     * Save donation details
     * @param integer $donor_id
     * @param integer $total
     * @param integer $quantity
     * @param integer $payment_method_id
     * @param integer $project_id
     * @param string $payfortResponse
     * @return response
     */
    public function save()
    {
        $this->testModel->save(json_encode($_POST));

        $data = $this->requiredArray(['donor_id', 'total', 'quantity', 'payment_method_id', 'project_id', 'donationType', 'payfortResponse']);

        $image['filename'] = false;
        $payfortResponse = json_decode($data['payfortResponse']);
        $donor = $this->donorModel->getDonorId($data['donor_id']);
        if (!$donor) $this->error('Donor Not found');
        if ($data['payment_method_id'] == 1) {
            // validate image
            if ($_FILES['bankImage']['error'] == 0) {
                $image = uploadImage('bankImage', APPROOT . '/media/files/banktransfer/', 5000000, false);
                if (!empty($image['error'])) $this->error(implode(',', $image['error']));
            } else {
                $this->error('please upload an image');
            }
        }
        $payment = $this->projectModel->getPaymentKey($data['payment_method_id'])[0];
        if (!$payment) $this->error('Payment Not found');
        $project = $this->projectModel->getBy(['project_id' => $data['project_id']]);
        if (!$project) $this->error('Project Not found');
        if (isset($payfortResponse->status) && ($payfortResponse->status == 14)) {
            $status = 1;
        } else {
            $status = 0;
        }
        $order_identifier = isset($payfortResponse->merchant_reference) ? $payfortResponse->merchant_reference : $this->projectModel->uniqNum();
        $orderdata = [
            'order_identifier' => $order_identifier,
            'total' => $data['total'],
            'amount' => ($data['total'] / $data['quantity']),
            'quantity' => $data['quantity'],
            'payment_method_id' => $payment->payment_id,
            'payment_method_key' => $payment->payment_key,
            'payment_key' => $payment->payment_key,
            'projects_id' => "($project->project_id)",
            'donationType' => $data['donationType'],
            'project_id' => $project->project_id,
            'hash' => sha1(time() . rand(999, 999999)),
            'gift' => 0,
            'gift_data' => '',
            'image' => $image['filename'],
            'projects' => $project->name,
            'store_id' => null,
            'donor_id' => $donor->donor_id,
            'donor_name' => $donor->full_name,
            'meta' => $data['payfortResponse'],
            'donation_type' => $data['donationType'],
            'status' =>  $status,
            'app' => 'kafara',
        ];

        // addOrder
        if (!$orderdata['order_id'] = $this->projectModel->addOrder($orderdata)) {
            $this->error('Something went wrong while trying to save your order');
        }
        // addDonation
        //save donation data through saving method
        if (!$this->projectModel->addDonation($orderdata)) {
            $this->error('Something went wrong while trying to save the order Donations');
        }
        // update order with bank image if exists
        if ($image['filename']) {
            $hash = $this->projectModel->getOrderByHash($orderdata['hash']) ?: null;
            $orderdata['image'] = $image['filename'];
            $orderdata['hash'] = $hash;
            if (!$this->projectModel->updateOrderHash($orderdata)) {
                $this->error('Something went wrong while trying to save the order Donations');
            }
            $orderdata['hash'] = $hash->hash;
        }
        // update order source 
        $orderdata['app'] = ($project->badal) ? 'badal' : 'kafara';
        $this->projectModel->updateOrderMeta($orderdata);
        //retrive all data
        $orderdata['donation_id'] = $this->projectModel->lastId();
        $this->response($orderdata);
    }

    /**
     * Save donation details from cart
     * @param integer $donor_id
     * @param integer $total
     * @param integer $payment_method_id
     * @param string $payfortResponse
     * @param string JSON object $donations
     * @return response
     */
    public function cart()
    {
        // $this->testModel->save(json_encode($_POST));

        $data = $this->requiredArray(['donor_id', 'total', 'payment_method_id', 'payfortResponse', 'donations']);

        $image['filename'] = false;
        $payfortResponse = json_decode($data['payfortResponse']);
        $donor = $this->donorModel->getDonorId($data['donor_id']);
        if (!$donor) $this->error('Donor Not found');
        if ($data['payment_method_id'] == 1) {
            // validate image
            if ($_FILES['bankImage']['error'] == 0) {
                $image = uploadImage('bankImage', APPROOT . '/media/files/banktransfer/', 5000000, false);
                if (!empty($image['error'])) $this->error(implode(',', $image['error']));
            } else {
                $this->error('please upload an image');
            }
        }
        $payment = $this->projectModel->getPaymentKey($data['payment_method_id'])[0];
        if (!$payment) $this->error('Payment Not found');
        if (isset($payfortResponse->status) && ($payfortResponse->status == 14)) {
            $status = 1;
        } else {
            $status = 0;
        }

        //convert donation json object
        $donations = json_decode($data['donations']);
        if (empty($donations)) $this->error('Donations is empty');
        $order_identifier = isset($payfortResponse->merchant_reference) ? $payfortResponse->merchant_reference : $this->projectModel->uniqNum();
        //prepar order data
        $orderdata = [
            'order_identifier' => $order_identifier,
            'gift' => 0,
            'gift_data' => '',
            'projects' => '',
            'total' => $data['total'],
            'quantity' => 0,
            'hash' => sha1(time() . rand(999, 999999)),
            'payment_method_id' => $payment->payment_id,
            'payment_method_key' => $payment->payment_key,
            'payment_key' => $payment->payment_key,
            'projects_id' => '',
            'donor_id' => $donor->donor_id,
            'donor_name' => $donor->full_name,
            'meta' => $data['payfortResponse'],
            'store_id' => null,
            'status' =>  $status,
            'app' => 'kafara'
        ];

        //loop through donations
        foreach ($donations as $key => $donation) {
            $project = $this->projectModel->getProjectByIdApp($donation->project_id);
            if (!$project) $this->error('Project Not found');
            $orderdata['projects_id'] .= "($project->project_id),";
            $orderdata['quantity'] += $donation->quantity;
            $orderdata['projects'] .= "$project->name, ";

            if ($project->badal) {
                // check for behafeof // relation // language // gender
                // if not any return error message
                $orderdata['app'] = 'badal';
                $error_msg = '';
                if (!exist(@$donation->behafeof)) $error_msg .= "behafeof field is mandatory \n\t ";
                if (!exist(@$donation->relation)) $error_msg .= "relation field is mandatory\n\t ";
                if (!exist(@$donation->language)) $error_msg .= "language field is mandatory\n\t ";
                if (!exist(@$donation->gender))   $error_msg .= "gender field is mandatory\n\t ";
                if (!empty($error_msg)) $this->error($error_msg);
            }
        }
        // addOrder
        if (!$orderdata['order_id'] = $this->projectModel->addOrder($orderdata)) {
            $this->error('Something went wrong while trying to save your order');
        }
        // save donations 
        foreach ($donations as $donation) {
            $project = $this->projectModel->getSingle(' project_id, badal', ['project_id' => $donation->project_id, 'status' => 1]);
            $subsitute = null;
            if (isset($donation->offer_id)) {
                $subsitute = $this->BadalOrder->getSubsitudeOffer($donation->offer_id);
            }
            $donationData = [
                'amount' => $donation->total / $donation->quantity,
                'total' => $donation->total,
                'quantity' => $donation->quantity,
                'donation_type' => $donation->donationType,
                'project_id' => $project->project_id,
                'order_id' => $orderdata['order_id'],
                'status' =>  $status,
                'substitute_id' => isset($donation->offer_id) ? @$subsitute->substitute_id :  null,
                'is_offer' => isset($donation->offer_id) ? 1 : 0,
                'offer_id' => isset($donation->offer_id) ? $donation->offer_id : null,
                'offer_start_at' => isset($donation->offer_id) ?  time() : null,
                'start_at' =>  null,
            ];
            //save donation data through saving method
            if (!$this->projectModel->addDonation($donationData)) {
                $this->error('Something went wrong while trying to save the order Donations');
            }
            //save Badal Order data 
            if ($project->badal) {
                $orderdata['app'] = 'badal';
                $donationData['behafeof'] = $donation->behafeof;
                $donationData['relation'] = $donation->relation;
                $donationData['language'] = $donation->language;
                $donationData['gender'] = $donation->gender;
                $badalId = $this->BadalOrder->addBadalOrder($donationData);
                if (!$badalId) {
                    $this->error('Something went wrong while trying to save the Badal Order');
                }
                $orderdata['badal_id'] = $badalId;
                // if order from offer hide offer
                if (isset($donation->offer_id)) {
                    $resquest = $this->BadalOrder->addRequestOffer($badalId, $donationData);
                    $offer = $this->BadalOrder->updateStatusOffer($donation->offer_id);
                }
            }
        }
        // update order with bank image if exists
        if ($image['filename']) {
            $hash = $this->projectModel->getOrderByHash($orderdata['hash']) ?: null;
            $orderdata['image'] = $image['filename'];
            $orderdata['hash'] = $hash;
            if (!$this->projectModel->updateOrderHash($orderdata)) {
                $this->error('Something went wrong while trying to save the order Donations');
            }
            $orderdata['hash'] = $hash->hash;
        }

        $this->projectModel->updateOrderMeta($orderdata);
        //prepare notification data
        $messaging = $this->model('Messaging');
        $sendData = [
            'mailto' => $donor->email,
            'mobile' => $donor->mobile,
            'identifier' => $orderdata['order_identifier'],
            'order_id' => $orderdata['order_id'],
            'total' => $orderdata['total'],
            'project' => $orderdata['projects'],
            'donor' => $orderdata['donor_name'],
            'subject' => 'تم تسجيل تبرع جديد ',
            'msg' => "تم تسجيل تبرع جديد بمشروع : {$orderdata['projects']} <br/> بقيمة : " . $orderdata['total'],

        ];
        //send Email and SMS confirmation
        $messaging->donationAdminNotify($sendData);
        // send message to donor 
        $messaging->donationDonorNotify($sendData);
        // send whatsapp message to donor 
        $messaging->ReciveOrdersApp("$sendData[mobile]", "$sendData[donor]", " $sendData[identifier]", "$_POST[total]", 'namaa.sa');
        // send sms if payment = 14 (payfort)
        if (@$payfortResponse->status == 14) {
            $order = $this->projectModel->getSingle('*', ['order_id' => $orderdata['order_id']], 'orders');
            if (!$order->notified) {
                $messaging->sendConfirmation($sendData);
                $this->projectModel->notified($orderdata['order_id']);

                // queue the subsitudes in queue table
                require_once APPROOT . '/admin/models/QueueTable.php';
                $queueTable = new QueueTable();
                $subsitutes = $queueTable->getAvailableSubsitudes();

                if ($subsitutes) {
                    foreach ($subsitutes as $subsitute) {
                        $QueuData['order_id'] = $orderdata['order_id'];
                        $QueuData['substitute_id'] = $subsitute->substitute_id;
                        $queueTable->addqueue($QueuData);
                    }
                }
            }
        }

        //retrive all data
        $this->response($orderdata);
    }

    public function test()
    {
        print_r(json_decode('
        [
            {
              "quantity": "3",
              "donationType": "fixed",
              "project_id": "925",
              "total": "300"
            },
            {
              "quantity": "2",
              "donationType": "fixed",
              "project_id": "904",
              "total": "300"
            }            
          ]
        '));
    }

    /**
     * get badal order by donor 
     * @param integer $donor_id
     * @param string $status
     * @return response
     */
    public function donor()
    {
        $data = $this->requiredArray(['donor_id', 'status']);
        // get badal order by donor 
        if ($data['status'] == 3) {
            $Badalorders = $this->BadalOrder->getBadalOrderDonorComplete($data['donor_id'], $data['status']);
        } else {
            $Badalorders = $this->BadalOrder->getBadalOrderDonor($data['donor_id'], $data['status']);
        }
        if ($Badalorders == null) $this->error('No data');
        $this->response($Badalorders);
    }

    /**
     * get badal order by substitute 
     * @param integer $substitute_id
     * @param string $status
     * @return response
     */
    public function substitute()
    {
        $data = $this->requiredArray(['substitute_id', 'status']);
        // get order by substitute 
        $Badalorders = $this->BadalOrder->getBadalOrderSubstitute($data);

        if ($Badalorders == null) $this->error('No data');
        $this->response($Badalorders);
    }

    /**
     * get all badalOrder with no Substitute 
     *@param integar $substitute_id
     *
     * @return response
     */
    public function pending()
    {
        $Badalorders = $this->BadalOrder->getBadalOrderPending();
        if ($Badalorders == null) $this->error('No data');
        $this->response($Badalorders);
    }

    /**
     * update completed of badalOrder by id 
     *@param integar $substitute_id
     *
     * @return response
     */
    public function completed()
    {
        $data = $this->requiredArray(['badal_id']);
        // get order by id 
        $Badalorders = $this->BadalOrder->getBadalOrderById($data['badal_id']);
        if (!$Badalorders) $this->error('Not Found');
        if ($Badalorders->start_at == null) {
            $this->error('You must start first');
        }
        if ($Badalorders->complete_at != null) {
            $this->error('Already completed');
        }
        // check idf riutals not copleted 
        $riualsNotComplete = $this->BadalOrder->getuncompleteRituals($Badalorders->order_id);
        if ($riualsNotComplete) {
            $this->error('يرجى إكمال جميع المناسك أولاً');
            // $this->error('please complete all rituals first');
        }

        $this->BadalOrder->updateBadalOrderCompleted($data['badal_id']);
        // send messages  (email - sms - whatsapp)
        $donor = $this->BadalOrder->getDonorByOrderID($Badalorders->order_id);
        
        $sendData = [
            'order_id'              => @$Badalorders->order_id,
            'mailto'                => @$donor->email,
            'mobile'                => @$donor->mobile,
            'identifier'            => @$donor->order_identifier,
            'total'                 => @$donor->total,
            'project'               => @$donor->projects,
            'donor'                 => @$donor->donor_name,
            'substitute_phone'      => @$donor->substitute_phone,
            'notify_id'             => @$donor->donor_id,
            'notify'                => "تم اكتمال طلبك ",
        ];

        // send the notify of to the donor and subsitude 
        $messaging = $this->model('Messaging');
        $this->CompleRitesNotify($sendData, $messaging);

        // send messages
        // $messaging->sendNotfication($sendData, 'complete_order');
        $this->response($Badalorders);
    }

    public function CompleRitesNotify($data)
    {
        $data['name'] = $data['donor'];
        $data['project_name'] = $data['project'];
        $riualsProofed = $this->BadalOrder->getProofedRituals($data['order_id']);
        $links = "";
        foreach ($riualsProofed as $inf) {
            $links .= ($inf->title . ': ' . $inf->proof . ', ');
        }
        $data['links'] = $links;

        $whatsAppSettings = $this->model->getSettings('whatsapp'); // load whatsapp setting 
        $whatsAppSettings = json_decode($whatsAppSettings->value);

        $parameters = [
            ["name" => "name", "value" => $data['donor']],
            ["name" => "project_name", "value" => $data['project']],
            ["name" => "links", "value" => $links],
        ];
        if (!$whatsAppSettings->whatsappenabled) {
            return false;
        }

        $broadcast =  $whatsAppSettings->broadcast_name_complete_rites;
        $template =  $whatsAppSettings->template_name_complete_rites;
        // send data to donor 
        sendWhatsAppParameter($whatsAppSettings->gateurl, $whatsAppSettings->accessToken, $template, $broadcast, $data['mobile'], $parameters);

        // send data to subsitude
        sendWhatsAppParameter($whatsAppSettings->gateurl, $whatsAppSettings->accessToken, $template, $broadcast, $data['substitute_phone'], $parameters);
    }

    /**
     * start new Rituals  
     *
     * @param  mixed $projectId
     * @param  mixed $substituteId
     * @return object
     */
    public function start()
    {
        $data = $this->requiredArray(['project_id', 'substitute_id', 'order_id']);
        $Badalorders = $this->BadalOrder->getBadalOrderByOrderID($data['order_id']);
        if (!$Badalorders) {
            $this->error('Order Not Found');
        }
        // check the start date
        $requestBadal = $this->BadalOrder->getRequestByBadalOrderID($Badalorders->badal_id);

        $requestStartDate = date('d-m-Y', $requestBadal->start_at);
        $currentDate = date('d-m-Y');

        if ($requestStartDate > $currentDate) {
            $this->error('يجب بداء الطلب في الموعد المحدد');
        }
        require_once "../api/Rituals.php";
        $ritualClass = new Rituals;
        if ($Badalorders->start_at != null) {
            $rites = $this->ritual->getRitualsByOrder($data['order_id']);
            $this->response($rites, 200, 'Already Started');
        }
        $data = $ritualClass->start();
        // get badal order and change status 
        if (!empty($data['rituals'])) $Badalorders = $this->BadalOrder->updateBadalOrderStart($Badalorders->badal_id);

        if (!$Badalorders) $this->error('Not Found');
        // send messages  (email - sms - whatsapp)
        $messaging = $this->model('Messaging');
        $donor = $this->BadalOrder->getDonorByOrderID($data['order_id']);
        $sendData = [
            'mailto'                => $donor->email,
            'mobile'                => $donor->mobile,
            'identifier'            => $donor->order_identifier,
            'total'                 => $donor->total,
            'project'               => $donor->projects,
            'donor'                 => $donor->donor_name,
            'behafeof'              => $donor->behafeof,
            'substitute_name'       => $donor->substitute_name,
            'notify_id'             => $donor->donor_id,
            'notify'                => "تم بدء طلبك ",
        ];
        // send messages
        $messaging->sendNotfication($sendData, 'start_order');

        $this->response($data['rituals']);
    }

    /**
     * Form badal  
     *
     * @param  mixed $projectId
     * @param  mixed $substituteId
     * @return object
     */
    public function form()
    {
        $setting = $this->BadalOrder->getSettingById(15);
        if ($setting == null) {
            $this->error('No data');
        } else {
            $setting = json_decode($setting->value);
        }
        $this->response($setting);
    }

    /**
     * show order  
     *
     * @param  mixed $order_id
     * @return object
     */
    public function show()
    {
        $data = $this->requiredArray(['order_id']);
        //$order = $this->model->getOrderById($data['order_id']);

        $order = $this->BadalOrder->getBadalOrderByOrderID2($data['order_id']);

        // $order->banktransferproof = URLROOT . "/media/files/banktransfer/" . $order->banktransferproof;
        $this->response($order);
    }

    /**
     * show Donor  
     *
     * @param  mixed $order_id
     * @return object
     */
    public function showDonor()
    {
        $data = $this->requiredArray(['order_id']);
        $order = $this->model->getOrderById($data['order_id']);
        $donor =  $this->donorModel->getDonorId($order->donor_id);
        $this->response($donor);
    }

    /**
     * show substitute
     *
     * @param  mixed $order_id
     * @return object
     */
    public function showSubstitute()
    {
        $data = $this->requiredArray(['order_id']);
        $substitute =  $this->BadalOrder->getSsubstituteFromOrder($data['order_id']);
        $this->response($substitute);
    }
}
