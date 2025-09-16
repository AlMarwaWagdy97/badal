<?php
class Reviews extends ApiController
{

    public $messaging;

    public function __construct()
    {
        $this->model = $this->model('Review');
    }

    /**
     * list Reviews
     * @return response
     */
    public function list()
    {
        $request = [
            "5" => "راضي تماما",
            "4" => "راضي نوعا ما ",
            "3" => "محايد",
            "2" => "غير راضي نوعا ما",
            "1" => "غير راضي",
        ];
        
        $this->response($request);
    }

    /**
     * add new Review
     *@param integar $badal_id
     *@param integar $type
     *@param integar $type_id
     *@param integar $rate
     * @return response
     */
    public function add()
    {
        $data = $this->requiredArray(['badal_id', 'rate', 'description']);
        $checkReviewExist = $this->model->checkeview($data);
        if($checkReviewExist){  $this->error('Review is already exist');}
        $review = $this->model->addReview($data);
        if($review == true){
            $substitute =  $this->model->getSubstitute($data['badal_id']);
            // send messages  (email - sms - whatsapp)
            $messaging = $this->model('Messaging');
            $sendData = [
                'mailto'                => $substitute->full_name,
                'mobile'                => $substitute->phone,
                'identifier'            => $substitute->order_identifier,
                'total'                 => $substitute->total,
                'project'               => $substitute->projects,
                'donor'                 => $substitute->donor_name,
                'rate'                  => $data['rate'],
            ];
            // send messages
            $messaging->sendNotfication($sendData, 'review');
            $this->response("Review sent successfully");
        } 
        else {
            $this->error("There is a problem .. Please try again");
        }
    }
}
