<?php

include 'bootstrap.php';
// require_once 'config/config.php';

class QueueNotfications 
{


    public function __construct()
    {
        $this->sendNotify();
    }


    public function sendNotify(){
        require_once  'admin/models/QueueTable.php';
        $queueTable = new QueueTable();
        $subQueue = $queueTable->getTopTenQueue();
       
        if(!empty($subQueue)){
            foreach($subQueue as $queue){
                // send notification
                $queueTable->notify($queue);
                //  update send status of queue
                $queueTable->updateSend($queue->queue_table_id, 1);
            }
            echo "The notifications have been sent successfully";
        }
        else {
            echo "There isn't any substitutes to notify" ;
        }
    }   
    
}

new QueueNotfications();