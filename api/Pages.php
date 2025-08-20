<?php
class Pages extends ApiController
{

    private $pageModel;

    public function __construct()
    {
        $this->pageModel = $this->model('Page');
    }


    /**
     * get Polices pages
     * @param integer $id
     */
    public function getPolicyPages()
    {
        if (!$page = $this->pageModel->getPolicyPages([53, 54, 55])) {
            return $this->error('Not Found');

        }
        $data = [
            'terms_and_conditions' => $page[0],
            'privacy_policy' => $page[1],
            'return_policy' => $page[2],
        ];
        $this->response($data);
    }
    

}