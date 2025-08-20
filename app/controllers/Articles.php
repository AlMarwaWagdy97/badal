<?php

class Articles extends Controller
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
    public function index($start = 1, $perpage = 100)
    {
        $data = [
            'pageTitle' => 'الاخبار والمقالات: ' . SITENAME,
            'settings' => $this->settings,
            'menu' => $this->menu,
            'slides' => $this->articlesModel->getSlides(),
            'newsTicker' => $this->articlesModel->getNewsTicker(),
            'articles' => $this->articlesModel->getArticles($start, $perpage),
            'pagination' => generatePagination($this->articlesModel->articlesCount()->count, $start, $perpage, 4, URLROOT, '/articles'),

        ];
        $data['settings']['site']->title =  'الاخبار والمقالات: ' . SITENAME;
        $this->view('articles/index', $data);
    }

    public function show($id = '', $title = "")
    {
        empty($id) ? redirect('articles', true) : null;
        $data = [
            'settings' => $this->settings,
            'menu' => $this->menu,
            'article' => $this->articlesModel->getArticleById($id),
        ];

        $data['settings']['seo']->meta_keywords = $data['article']->meta_keywords;
        $data['settings']['seo']->meta_description = $data['article']->meta_description;
        $data['settings']['site']->image = $data['article']->image;
        $data['settings']['site']->title = $data['pageTitle'] = $data['article']->name;
        //loading view
        $this->view('articles/show', $data);
    }
}
