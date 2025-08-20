<?php

class Gift extends Controller
{

    private $storeModel;


    public function __construct()
    {
        $this->storeModel = $this->model('Store');
    }
    public function index()
    {
        $img = explode('/', $_GET['url']);
        if (file_exists(APPROOT . MEDIAFOLDER . '/gifts/img_' . end($img) . '.jpg')) {
            $data['storeURL'] = URLROOT;
            if (count($img) == 3) {
                if ($store = $this->storeModel->getSingle('*', ['store_id'=> $img[1]], 'stores')) {
                    $data['storeURL'] = URLROOT . '/stores/' . $store->alias;
                }
            }
            $data['imgsrc'] =  MEDIAURL . '/gifts/img_' . end($img) . '.jpg';
            return $this->view('pages/gift', $data);
        } else {
            flashRedirect('', 'msg', 'This file is not exist', 'alert alert-danger');
        }
    }
}
