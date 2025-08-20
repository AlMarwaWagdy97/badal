<?php

class ProjectCategories extends Controller
{

    private $categoriesModel;
    public $settings;
    public $menu;


    public function __construct()
    {
        $this->categoriesModel = $this->model('ProjectCategory');
        $this->menu = $this->categoriesModel->getMenu();
        $this->settings = $this->categoriesModel->getSettings();
        
    }

    public function index($start = 1, $perpage = 100)
    {
        $start = (int) $start;
        $perpage = (int) $perpage;
        empty($start) ? $start = 0 : '';
        empty($perpage) ? $perpage = 100 : '';
        $categories = $this->categoriesModel->getCategories($start, $perpage);
        $data = [
            'pageTitle' => 'الرئيسية: ' . SITENAME,
            'settings' => $this->settings,
            'menu' => $this->menu,
            'pagination' => generatePagination($this->categoriesModel->categoriesCount()->count, $start, $perpage, 4, URLROOT, '/ProjectCategories/index'),
            'categories' => $categories,
        ];
        $this->view('categories/index', $data);
    }

    /**
     * show category by id
     *
     * @param  int $id
     *
     * @return view
     */
    public function show($id = '', $start = 0, $perpage = 100)
    {
        $start = (int) $start;
        $perpage = (int) $perpage;
        empty($id) ? redirect('categories', true) : null;
        empty($start) ? $start = 0 : '';
        empty($perpage) ? $perpage = 100 : '';
        ($category = $this->categoriesModel->getCategoryById($id)) ?: flashRedirect('index', 'msg', ' هذا القسم غير موجود او ربما تم حذفه ');
        $data = [
            'pageTitle' => $category->name .': ' . SITENAME,
            'category' => $category,
            'subcategories' => $this->categoriesModel->getSubCategories($id),
            'settings' => $this->settings,
            'menu' => $this->menu,
            'projects' => $this->categoriesModel->getProductsByCategory($id, $start, $perpage),
            'pagination' => generatePagination($this->categoriesModel->projectsCount($id)->count, $start, $perpage, 4, URLROOT, '/ProjectCategories/show/' . $id),
        ];
        
        $data['settings']['seo']->meta_keywords = $data['category']->meta_keywords;
        $data['settings']['seo']->meta_description = $data['category']->meta_description;
        $data['settings']['site']->image = $data['category']->image;
        $data['settings']['site']->title =  $data['category']->name;

        $this->view('categories/show', $data);
    }
}
