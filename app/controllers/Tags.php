<?php

class Tags extends Controller
{

    private $tagModel;
    public $settings;
    public $menu;

    public function __construct()
    {
        $this->tagModel = $this->model('Tag');
        $this->menu = $this->tagModel->getMenu();
        $this->settings = $this->tagModel->getSettings();
    }

    public function index($start = 1, $perpage = 100)
    {
        $start = (int) $start;
        $perpage = (int) $perpage;
        empty($start) ? $start = 0 : '';
        empty($perpage) ? $perpage = 100 : '';
        $tags = $this->tagModel->getTags($start, $perpage);
        $data = [
            'pageTitle' => 'الرئيسية: ' . SITENAME,
            'settings' => $this->settings,
            'menu' => $this->menu,
            'pagination' => generatePagination($this->tagModel->tagsCount()->count, $start, $perpage, 4, URLROOT, '/tags/index'),
            'tags' => $tags,
        ];
        $this->view('tags/index', $data);
    }

    /**
     * show tag by id
     *
     * @param  int $id
     *
     * @return view
     */
    public function show($id = '', $start = 0, $perpage = 100)
    {
        $start = (int) $start;
        $perpage = (int) $perpage;
        empty($id) ? redirect('tags', true) : null;
        empty($start) ? $start = 0 : '';
        empty($perpage) ? $perpage = 100 : '';
        ($tag = $this->tagModel->getTagById($id)) ?: flashRedirect('index', 'msg', ' هذا الوسم غير موجود او ربما تم حذفه ');
        $data = [
            'tag' => $tag,
            'pageTitle' => $tag->name . ': ' . SITENAME,
            'settings' => $this->settings,
            'menu' => $this->menu,
            'projects' => $this->tagModel->getProductsByTag($id, $start, $perpage),
            'pagination' => generatePagination($this->tagModel->projectsCount($id)->count, $start, $perpage, 4, URLROOT, '/tags/show/' . $id),
        ];
        
        $data['settings']['seo']->meta_keywords = $data['tag']->meta_keywords;
        $data['settings']['seo']->meta_description = $data['tag']->meta_description;
        $data['settings']['site']->image = $data['tag']->image;
        $data['settings']['site']->title =  $data['tag']->name;
        $this->view('tags/show', $data);
    }
}
