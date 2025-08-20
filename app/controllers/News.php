<?php

class News extends Controller
{
    private $articlesModel;
    public $settings;
    public $menu;

    public function __construct()
    {
        $this->articlesModel = $this->model('Article');
        $this->menu = $this->articlesModel->getMenu();
        $this->settings = $this->articlesModel->getSettings();
    }
    /**
     * home page
     */
    public function index($start = 1, $perpage = 21)
    {
        $data = [
            'pageTitle' => 'الاخبار : ' . SITENAME,
            'settings' => $this->settings,
            'menu' => $this->menu,
            'slides' => $this->articlesModel->getSlides(),
            'newsTicker' => $this->articlesModel->getNewsTicker(),
            'news' => $this->articlesModel->getNews($start, $perpage),
            'pagination' => generatePagination($this->articlesModel->newsCount()->count, $start, $perpage, 2, URLROOT, '/news/index'),

        ];
        $data['settings']['site']->title =  'الاخبار : ' . SITENAME;
        $this->view('news/index', $data);
    }

    public function show($id = '')
    {
        empty($id) ? redirect('news', true) : null;
        $data = [
            'settings' => $this->settings,
            'menu' => $this->menu,
            'article' => $this->articlesModel->getNewsById($id),
        ];

        $data['settings']['seo']->meta_keywords = $data['article']->meta_keywords;
        $data['settings']['seo']->meta_description = $data['article']->meta_description;
        $data['settings']['site']->image = $data['article']->image;
        $data['settings']['site']->title = $data['pageTitle'] = $data['article']->name;
        //loading view
        $this->view('news/show', $data);
    }
}
