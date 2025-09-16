<?php


class Offers extends ApiController
{
    public $model;

    public function __construct()
    {
        $this->model = $this->model('Offer');
    }

    /**
     * add new offer
     *@param integar $substitute_id
     *@param integar $project_id
     *@param integar $amount
     *@param integar $start_at
     * @return response
     */
    public function add()
    {
        $data = $this->requiredArray(['substitute_id', 'project_id', 'amount', 'start_at']);
        // check if amount is possible
        $project = $this->model->getProject($data['project_id']);
        if( $data['amount'] < $project->min_price ){
            $this->error("الحد الادني : " . $project->min_price . ' ريال '); 
        }
        $data['offer_time'] = json_decode($this->model->getSettings('badal')->value)->offer_time;
        $checkexist = $this->model->checkPossibleTime($data);
        if(count($checkexist)){
            $this->error("لا يمكن اضافه العرض في هذا الوقت ,  يجب ان يكون مضي " .  $data['offer_time'] .  " ساعات علي اخر العرض ");
        }
        $offer = $this->model->addOffer($data);
        if(!$offer) $this->error("There is a problem .. Please try again"); 
        // send messages  (email - sms - whatsapp)
        // $offerData = $this->model->getOfferByIdWithRelations($offer); // get offer
        // $donors = $this->model->getAllDonors();   // get all donors to notify
        // $messaging = $this->model('Messaging');
        // foreach($donors as $donor){
        //     $sendData = [
        //         'mailto'            => $donor->email,
        //         'mobile'            => $donor->mobile,
        //         'total'             => $offerData->amount,
        //         'donor'             => $donor->full_name,
        //         'identifier'        => $offerData->project_name, //name of project 
        //         'project'           => $offerData->project_name,
        //         'substitute_name'   => $offerData->full_name,
        //         'substitute_start'  => $offerData->start_at,
        //     ];
        //     $messaging->sendNotfication($sendData, 'newOffer');
        // }
        $this->response("Offer sent successfully");
    }

    /**
     * cancel  offer from substitutes
     *@param integar $substitute_id
     *@param integar $project_id
     *@param integar $amount
     *@param integar $start_at
     * @return response
     */
    public function cancel()
    {
        $offer_id = $this->required('offer_id');
        $offer = $this->model->getOfferById($offer_id); // get offer
        if($offer == null)$this->error("Offer not found");
        // if($offer->status == 0)$this->error("Already canceled");
        $offer = $this->model->cancelOffer($offer_id);
        if($offer == true) $this->response("Offer cancel successfully");
        else {
            $this->error("There is a problem .. Please try again");
        }
    }

    
    /**
     * list offers by substitute
     *@param integar $substitute_id
     * @return response
     */
    public function substitute()
    {
        $data = $this->requiredArray(['substitute_id']);
        $offers = $this->model->getOffersBySubstitute($data['substitute_id']);
        $this->response($offers);
    }

    /**
     * list offers 
     * @return response
     */
    public function list()
    {
        $offers = $this->model->getOffers();
        $this->response($offers);
    }
}