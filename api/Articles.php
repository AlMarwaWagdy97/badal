<?php
class Articles extends ApiController
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
    public function view()
    {
        $id = $this->required('id');
        if ($response = $this->model->getArticleById($id)) {
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
        $id = $this->required('section_id');
        if ($response = $this->model->getArticles($id, 1, '')) {
            $this->response($response);
        } else {
            $this->error('Not found');
        }
    }

    ///EOT
}
