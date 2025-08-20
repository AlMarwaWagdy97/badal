<?php


class QueueNotify extends ApiController
{
  
    public function sendNotify(){
        require_once APPROOT . '/admin/models/QueueTable.php';
        $queueTable = new QueueTable();
        $subQueue = $queueTable->getTopTenQueue();
        
        if(!empty($subQueue)){
            foreach($subQueue as $queue){
                // send notification
                $queueTable->notify($queue);
                //  update send status of queue
                $queueTable->updateSend($info->queue_table_id, 1);
            }
            $this->response("The notifications have been sent successfully");
        }
        $this->response("There isn't any substitutes to notify" );

    }
}
    