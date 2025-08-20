<?php

class Substitutes extends Controller
{
    private $substituteModel;
    public $settings;
    public $menu;

    public function __construct()
    {
        $this->substituteModel = $this->model('Substitute');
        $this->menu = $this->substituteModel->getMenu();
        $this->settings = $this->substituteModel->getSettings();
    }


    public function index()
    {
    //   dd($_REQUEST['POST']);
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
             // sanitize POST array
             $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
             $data = [
                 'page_title' => 'المتطوعون',
                 'identity' => trim($_POST['identity']),
                 'image' => '',
                 'full_name' => trim($_POST['full_name']),
                 'phone' => trim($_POST['phone']),
                 'nationality' => trim($_POST['nationality']),
                 'gender' => trim($_POST['gender']),
                 'email' => trim($_POST['email']),
                 'languages' => @$_POST['languages'],
                 'status_error' => '',
                 'email_error' => '',
                 'gender_error' => '',
                 'nationality_error' => '',
                 'identity_error' => '',
                 'phone_error' => '',
                 'full_name_error' => '',
                 'image_error' => '',
                 'languages_error' => '',
                 'settings' => $this->settings,
                 'menu' => $this->menu,
             ];
            
             // validate identity
             if(empty($data['identity'])){
                $data['identity_error'] = 'هذا الحقل مطلوب';
             }elseif(!is_numeric($data['identity'])){

                $data['identity_error'] = 'هذا الحقل  غير صحيح';
                
             }
             // validate gender
             !(empty($data['gender'])) ?: $data['gender_error'] = 'هذا الحقل مطلوب';
             // validate email
             !(empty($data['email'])) ?: $data['email_error'] = 'هذا الحقل مطلوب';
             // validate phone
             !(empty($data['phone'])) ?: $data['phone_error'] = 'هذا الحقل مطلوب';
             // validate nationality
             !(empty($data['nationality'])) ?: $data['nationality_error'] = 'هذا الحقل مطلوب';
             // validate full_name
             !(empty($data['full_name'])) ?: $data['full_name_error'] = 'هذا الحقل مطلوب';
             // validate languages
             !(empty($data['languages'])) ? : $data['languages_error'] = 'هذا الحقل مطلوب';
             // validate status
           
                
             // validate image
             if ($_FILES['image']['error'] == 0) {
                 $image = uploadImage('image', APPROOT . '/media/files/substitutes/', 2048000);
                 
                 if (empty($image['error'])) {
                     $data['image'] = $image['filename'];
                    } else {
                        if (!isset($image['error']['nofile'])) {
                            $data['image_error'] = implode(',', $image['error']);
                        }
                    }
                } else {
                    $data['image_error'] = "من فضلك قم برفع ملف الهوية";
                }
            //make sure there is no errors
            if (
                 empty($data['full_name_error']) && empty($data['gender_error']) && empty($data['email_error'])
                && empty($data['phone_error']) && empty($data['image_error']) && empty($data['languages_error'])
                ) {
                    //validated
                    if ($this->substituteModel->addSubstitute($data)) {
                    //  flash('msg', 'تم الحفظ بنجاح');
                    //  redirect('substitutes');
                     flashRedirect('substitutes/form', 'msg', 'تم الحفظ بنجاح.  ', 'alert alert-success');
                 } else {
                     flash('msg', 'هناك خطأ ما حاول مرة اخري', 'alert alert-danger', $data);
                 }
             } else {
                 //load the view with error
                 
                 $this->view('substitutes/form', $data);
             }
        } else {

            $data = [
                'page_title' => 'المتطوعون',
                'identity' => '',
                'image' => '',
                'nationality' => '',
                'gender' => '',
                'email' => '',
                'district' => '',
                'message' => '',
                'full_name' => '',
                'phone' => '',
                'city' => '',
                'languages' => [],
                'status' => 0,
                'email_error' => '',
                'gender_error' => '',
                'nationality_error' => '',
                'phone_error' => '',
                'identity_error' => '',
                'full_name_error' => '',
                'languages_error' => '',
                'image_error' => '',
                'settings' => $this->settings,
                'menu' => $this->menu,
                // 'projects' => $projects,
            ];
        }
        $this->view('substitutes/form', $data);
    }
}
