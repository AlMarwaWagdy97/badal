<?php

class Deceaseds extends Controller
{
    private $deceasedModel;
    public $settings;
    public $menu;

    public function __construct()
    {
        $this->deceasedModel = $this->model('Deceased');
        $this->menu = $this->deceasedModel->getMenu();
        $this->settings = $this->deceasedModel->getSettings();
    }


    public function index()
    {
        if ($this->settings['deceased']->campaignenabled != 1) {
            flashRedirect('', 'msg', 'هذا الرابط غير مفعل', 'alert alert-danger');
        }
        //  get projects  -------------------------------------------------------
        $projectsIds = $this->settings['deceased']->campaign_projects;
        $projects =  $this->model('Deceased')->getProjectsWithIds($projectsIds);
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // sanitize POST array
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

            $data = [
                'pageTitle' => $this->settings['deceased']->campaign_name,
                'settings' => $this->settings,
                'menu' => $this->menu,
                'projects' => $projects,
                'name'                      => trim($_POST['name']),
                'mobile'                    => trim($_POST['mobile']),
                'email'                     => trim($_POST['email']),
                'target_price'              => trim($_POST['target_price']),
                'project_id'                => trim($_POST['project_id']),
                'description'               => trim($_POST['description']),
                'deceased_name'             => trim($_POST['deceased_name']),
                'relative_relation'         => trim($_POST['relative_relation']),
                'status'                    => 0,
                'image'                     => '',
                'deceased_image'            => '',
                'name_error'                => '',
                'mobile_error'              => '',
                'email_error'               => '',
                'target_price_error'        => '',
                'description_error'         => '',
                'project_id_error'          => '',
                'image_error'               => '',
                'deceased_image_error'      => '',
                'deceased_name_error'       => '',
                'relative_relation_error'   => '',
                'captcha_error'             => '',
            ];
            // validate full_nam
            !(empty($data['name'])) ? $data['name_error'] = '' : $data['name_error'] =  'من فضلك قم بكتابة الاسم بالكامل';

            // validate target_price
            !(empty($data['target_price'])) ?: $data['target_price_error'] = 'من فضلك قم بكتابة المبلغ المتوقع';

            // validate target_price
            !(empty($data['project_id'])) ?: $data['project_id_error'] = 'من فضلك قم بأختيار المشروع';

            // validate deceased_name
            !(empty($data['deceased_name'])) ?: $data['deceased_name_error'] = 'من فضلك قم بكتابة اسم المتوفي';

            // validate relative_relation
            !(empty($data['relative_relation'])) ?: $data['relative_relation_error'] = 'من فضلك قم بكتابة صله القرابه';


            // validate phone
            !(empty($data['mobile'])) ?: $data['mobile_error'] = 'من فضلك قم بكتابة رقم الهاتف';
            if (strlen($_POST['mobile']) != 10) {
                $data['mobile_error'] = 'من فضلك قم بكتابة رقم الهاتف بطريقة صحيحة';
            }
            // upload deceased image 
            if ($_FILES['deceased_image']['error'] == 0) {
                $image = uploadImage('deceased_image', APPROOT . '/media/files/deceased/', 2048000);
                if (empty($image['error'])) {
                    $data['deceased_image'] = $image['filename'];
                    $_SESSION['deceased_image'] = $image['filename'];
                } else {
                    if (!isset($image['error']['nofile'])) {
                        $data['deceased_image_error'] = implode(',', $image['error']);
                    }
                }
            } elseif (isset($_SESSION['deceased_image'])) {
                $data['deceased_image'] = $_SESSION['deceased_image'];
            }

            // // upload  image 
            // if ($_FILES['image']['error'] == 0) {
            // $image = uploadImage('image', APPROOT . '/media/files/deceased/', 2048000);
            // if (empty($image['error'])) {
            //     $data['image'] = $image['filename'];
            //     $_SESSION['image'] = $image['filename'];
            // } else {
            //     if (!isset($image['error']['nofile'])) {
            //         $data['image_error'] = implode(',', $image['error']);
            //     }
            // }
            // } elseif (isset($_SESSION['image'])) {
            //     $data['image'] = $_SESSION['image'];
            // }



            // validate captcha
            recaptcha() ?: $data['captcha_error'] = 'خطأ بكود التحقق ';
            if (
                empty($data['name_error']) && empty($data['target_price_error']) && empty($data['project_id_error']) && empty($data['mobile_error'])
                && empty($data['mobile_error']) && empty($data['captcha_error']) && empty($data['deceased_image_error'])
            ) {

                $this->deceasedModel->addDeceased($data);
                            // send messages  (email - sms - whatsapp)
                $messaging = $this->model('Messaging');
                $sendData = [
                    'name'                  => $data['name'],
                    'mailto'                => $data['email'],
                    'mobile'                => $data['mobile'],
                    'identifier'            => $data['deceased_name'],
                    'total'                 => $data['target_price'],
                    'project'               => $data['mobile'],
                ];
                // send messages
                $messaging->deceasedsNoitfy($sendData, 'deceased');
                flashRedirect('deceaseds/form', 'msg', 'تم استقبال طلبكم .. وجاري مراجعته.  ', 'alert alert-success');
            } else {
                flash('msg', 'هناك خطأ ما حاول مرة اخري', 'alert alert-danger');
            }
        } else {

            $data = [
                'pageTitle' => $this->settings['deceased']->campaign_name,
                'settings' => $this->settings,
                'menu' => $this->menu,
                'projects' => $projects,
            ];
        }
        $this->view('deceased/form', $data);
    }
}
