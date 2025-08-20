<?php
class Settings extends ApiController
{

    public function __construct()
    {
        $this->model = $this->model('AppArticle');
    }

    /**
     * get all project details by id
     *@param integar $id
     *
     * @return response
     */
    public function AppIntro()
    {
        if ($response = $this->model->getSettings('app')) {
            //change image gallery to json object
            $response->value = json_decode($response->value);
            $response->value->intro = MEDIAURL . '/' . $response->value->intro;
            $response->value->license_img  = URLROOT . "/media/files/badal/" .  @$response->value->license_img;
            $this->response($response->value);
        } else {
            $this->error('Not found');
        }
    }


    ///EOT
}
