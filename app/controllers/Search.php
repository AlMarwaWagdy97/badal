<?php

class Search extends Controller
{
    private $projectsModel;
    public $settings;
    public $menu;
    public function __construct()
    {
        $this->projectsModel = $this->model('Project');
        $this->menu = $this->projectsModel->getMenu();
        $this->settings = $this->projectsModel->getSettings();
    }

    public function index()
    {
        $_GET = filter_input_array(INPUT_GET, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $result = [];
        if (isset($_GET['search'])) {
            if (isset($_GET['section']) && isset($_GET['keyword'])) {
                switch ($_GET['section']) {
                    case 'projects':
                        $table = 'projects';
                        $search = ['name' => $_GET['keyword']];
                        break;
                    case 'categories':
                        $table = 'project_categories';
                        $search = ['name' => $_GET['keyword']];
                        break;
                    default:
                        $table = 'pages';
                        $search = ['title' => $_GET['keyword']];
                        break;
                }
                if (empty($_GET['keyword'])) $search = '';
                $cols = '*';
                if ($table == 'pages') {
                    $cols .= ', title as name';
                }
                $result = $this->projectsModel->search($cols, ['status' => 1], 1, 200, $table, 'create_date', 'DESC', $search);
            }
        }
        $data = [
            'result' => $result,
            'pageTitle' =>  'البحث : ' . SITENAME,
            'settings' => $this->settings,
            'menu' => $this->menu,
        ];
        $this->view('search/index', $data);
    }
}
