<?php
class Tokens extends ApiController
{

    public $messaging;


    public function __construct()
    {
        $this->model = $this->model('Token');
    }


    public function send()
    {
        $fields = $this->requiredArray(['title', 'body']);
        if (isset($_POST['donor_id'])) {
            $data = $this->model->getDonorToken($_POST['donor_id']);
        } else {
            $data = $this->model->getFcmTokens();
        }
        $title = $fields['title'];
        $body = $fields['body'];

        foreach ($data as $user) {
            $token = $user->fcm_token;

            $payload = [
                "to" => $token,
                "notification" =>
                [
                    "title" => $title,
                    "body" => $body,
                ],
            ];

            $dataString = json_encode($payload);

            $headers = [
                'Authorization: key=AAAA2IStuMw:APA91bFgHxCs1Sb2zoF0NfDeprLK3RZ3jMUi1AAj-E7gFUesf2hXDsEQSOEAa1dxUQyidnpiSy8YuJKNItdPhasjgJa8jV06EVHZAmhRp0q_LXq1m_XYkl1d7ANVd10PKfpLYBx-pSiG',
                'Content-Type: application/json',
            ];

            $ch = curl_init();

            curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $dataString);

            curl_exec($ch);
        }



        $this->response($data);
    }


    public function save()
    {
        //validate all data
        $fields = $this->requiredArray(['device_id', 'fcm_token']);

        if ($this->model->getToken($_POST['device_id'])) {

            $data = [
                'device_id' => $_POST['device_id'],
                'fcm_token' => $_POST['fcm_token'],
                'donor_id' => $_POST['donor_id'],
            ];

            //save donor
            $data['token_id'] = $this->model->updateToken($data);
            $this->response($data);
        }
        //prepar data for save
        $data = [
            'device_id' => $_POST['device_id'],
            'fcm_token' => $_POST['fcm_token'],
            'donor_id' => $_POST['donor_id'],
        ];
        //save donor
        $data['token_id'] = $this->model->addToken($data);


        $this->response($data);
    }
}
