<?php
class Sections extends ApiController
{

    public function __construct()
    {
        $this->model = $this->model('AppSection');
    }

    /**
     * get all project details by id
     *@param integar $id
     *
     * @return response
     */
    public function view()
    {
        $id = $this->required('id');
        if ($response = $this->model->getSectionById($id)) {
            //change image gallery to json object
            $galery = str_replace('&#34;', '', trim(trim($response->image, ']'), '['));
            $response->image = array_filter(explode(',', $galery), 'strlen');
            $this->response($response);
        } else {
            $this->error('Not found');
        }
    }

    /**
     * view list of categories 
     *
     * @return response
     */
    public function list()
    {
        if ($response = $this->model->getSections(1,'')) {
            $this->response($response);
        } else {
            $this->error('Not found');
        }
    }

    ///EOT
}
