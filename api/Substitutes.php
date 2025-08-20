<?php


class Substitutes extends ApiController
{
    public $model;
    public $messaging;

    public function __construct()
    {
        $this->model = $this->model('Substitute');
        $this->messaging = $this->model('Messaging');

    }



    /**
     * get all Substitutes
     *@param integar $id
     *
     * @return response Data Substitutes
     */
    public function list()
    {
        $substitutes =  $this->model->getSubstitutes();
        if($substitutes != null){
            $this->response($substitutes);
        }
        else{
            $this->error('Not found');
        }
    }

    /**
     * select Substitute all Substitutes
     *@param integar $id
     *
     * @return response Data Substitutes
     */
    public function selectSubstitute()
    {
        $data = $this->requiredArray(['substitute_id', 'badal_id']);
        $substitutes =  $this->model->selectSubstitutes($data);
        if($substitutes){
            $this->response("The agent has been selected successfully");
        }
        else{
            $this->error('Please try again');
        }
    }



    //  cron jobs --------
    /**
     * sen notify to all Substitutes which has order today
     *@param integar $id
     *
     * @return response Data Substitutes
     */
    public function substituteNotify()
    {
        $substitutes =  $this->model->gettSubstitutesHasOrderToday();
        if($substitutes){
            foreach($substitutes as $substitute){
                $sendData = [
                    'mailto'            => $substitute->email,
                    'mobile'            => $substitute->phone,
                    'total'             => $substitute->total,
                    'donor'             => $substitute->full_name,
                    'identifier'        => $substitute->order_identifier, 
                    'project'           => $substitute->project_name,
                    'substitute_start'  => $substitute->start_at,
                ];
                // send messages  (email - sms - whatsapp)
                $this->messaging->sendNotfication($sendData, 'notify_order');
            }
        }
        $this->response("The Notify has been send successfully" );
    }

}