<?php

class tracking extends Controller
{
    private $model;
    public $settings;
    public $menu;

    public function __construct()
    {
        $this->model = $this->model('Track');
        $this->menu = $this->model->getMenu();
        $this->settings = $this->model->getSettings();
    }


    public function eladha()
    {
        $eladha_data = $this->settings['eladha'];
        if(!$eladha_data->eladhaenabled){
            flashRedirect('', 'msg', 'هذا الرابط غير مفعل', 'alert alert-danger');
        }
        $data = [
            'pageTitle' => $eladha_data->title,
            'eladha' => $eladha_data,
            'settings' => $this->settings,
            'menu' => $this->menu,
        ];       
        $this->view('tracking/eladha', $data);
    }

    public function eladha2()
    {
        $eladha_data = $this->settings['eladha_2'];
        if(!$eladha_data->eladhaenabled){
            flashRedirect('', 'msg', 'هذا الرابط غير مفعل', 'alert alert-danger');
        }
        $data = [
            'pageTitle' => $eladha_data->title,
            'eladha' => $eladha_data,
            'settings' => $this->settings,
            'menu' => $this->menu,
        ];       
        $this->view('tracking/eladha_2', $data);
    }


    public function eladha3()
    {
        $eladha_data = $this->settings['eladha_3'];
        if(!$eladha_data->eladhaenabled){
            flashRedirect('', 'msg', 'هذا الرابط غير مفعل', 'alert alert-danger');
        }
        $data = [
            'pageTitle' => $eladha_data->title,
            'eladha' => $eladha_data,
            'settings' => $this->settings,
            'menu' => $this->menu,
        ];       
        $this->view('tracking/eladha_3', $data);
    }


    public function video($key, $day = null)
    {
        if($day != null){
            $eladha_data = $this->settings['eladha_' . $day];
        }else{
            $eladha_data = $this->settings['eladha'];
        }
        $data = [
            'pageTitle' => $eladha_data->title,
            'url' => @$eladha_data->tracking->video[base64_decode($key)],
            'settings' => $this->settings,
            'menu' => $this->menu,
        ];       

        $this->view('tracking/video', $data);
    }
}
