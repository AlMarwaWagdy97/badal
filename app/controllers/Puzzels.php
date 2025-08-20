.<?php

    class Puzzels extends Controller
    {
        private $model;
        public $settings;
        public $menu;

        public function __construct()
        {
            $this->model = $this->model('Puzzel');
            $this->menu = $this->model->getMenu();
            $this->settings = $this->model->getSettings();
        }
        /**
         * home page
         */
        public function index($start = 1, $perpage = 100)
        {
            redirect('', true);
            $data = [
                'pageTitle' => 'أحجية الصورة المقطوعة: ' . SITENAME,
                'settings' => $this->settings,
                'menu' => $this->menu,
                // 'slides' => $this->model->getSlides(),
                // 'newsTicker' => $this->model->getNewsTicker(),
                'puzzels' => $this->model->getPuzzels($start, $perpage),
                'pagination' => generatePagination($this->model->puzzelsCount()->count, $start, $perpage, 4, URLROOT, '/puzzels'),

            ];
            $data['settings']['site']->title =  'أحجية الصورة المقطوعة: ' . SITENAME;
            $this->view('puzzels/index', $data);
        }

        public function show($id = '')
        {
            empty($id) ? redirect('puzzels', true) : null;
            $data = [
                'settings' => $this->settings,
                'menu' => $this->menu,
                'puzzel' => $this->model->getPuzzelById($id),
            ];
            $data['settings']['site']->image = "../files/puzzels/" . $data['puzzel']->image;
            $data['settings']['site']->logo = "../files/puzzels/" . $data['puzzel']->image;
            if (!$data['puzzel']->puzzel_id) flashRedirect('', 'msg', 'هذه الصفحة غير موجوده ربما اتبعت رابط خاطيء', 'alert alert-info');
            $this->view('puzzels/show', $data);
        }

        public function player($id)
        {
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                $data = [
                    'settings' => $this->settings,
                    'menu' => $this->menu,
                    'puzzel_id' => (int) $id,
                    'puzzel' => $this->model->getPuzzelById($id),
                    'full_name' => trim($_POST['first_name']) . " " . trim($_POST['second_name']) . " " . trim($_POST['last_name']),
                    'email' => trim($_POST['email']),
                    'phone' => trim($_POST['phone']),
                    'time' => trim($_POST['time']),
                    'settings' => $this->model->getSettings()
                ];
                $data['settings']['site']->logo = "../files/puzzels/" . $data['puzzel']->image;
                $data['settings']['site']->image = "../files/puzzels/" . $data['puzzel']->image;
                $data['settings']['site']->title =  $data['puzzel']->name;
                if (!empty($data['full_name']) && !empty($data['email']) && !empty($data['phone']) && !empty($data['puzzel_id'])) {
                    //validated
                    if ($data['player'] = $this->model->addplayer($data)) {
                        // if (!empty($data['settings']['notifications']->contactEmail)) { //send notification
                        //     $msg = arrayLines($_POST);
                        //     $this->model->Email($data['settings']['notifications']->contactEmail, SITENAME . ': اشعار حول تسجيل لاعب جديد ', $msg);
                        // }
                        flash('msg', 'تم الارسال بنجاح');
                        $this->view('puzzels/thankyou', $data);
                    } else {
                        flash('msg', 'هناك خطأ ما حاول مرة اخري', 'alert alert-danger');
                    }
                }
            } else {
                redirect('puzzels/show/' . $id, true);
            }
        }

        public function update($id)
        {
            $this->model->updatePlayer($id);
        }
    }
