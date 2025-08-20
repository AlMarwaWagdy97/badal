<?php

class Deceaseds extends ControllerAdmin
{
    private $deceasedModel, $projectModel, $orderModel;

    public function __construct()
    {
        $this->deceasedModel = $this->model('Deceased');
        $this->projectModel = $this->model('Project');
        $this->orderModel = $this->model('Order');

    }

    /**
     * loading index view with latest deceaseds
     */
    public function index($current = '', $perpage = 50)
    {
        // get deceaseds
        $cond = 'WHERE deceaseds.status <> 2 AND  projects.project_id = deceaseds.project_id ';
        $bind = [];
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // sanitize POST array
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            //handling Delete
            if (isset($_POST['delete'])) {
                if (isset($_POST['record'])) {
                    if ($row_num = $this->deceasedModel->deleteById($_POST['record'], 'deceased_id')) {
                        flash('deceased_msg', 'تم حذف ' . $row_num . ' بنجاح');
                    } else {
                        flash('deceased_msg_msg', 'لم يتم الحذف', 'alert alert-danger');
                    }
                }
                redirect('deceaseds');
            }

            //handling Publish
            if (isset($_POST['publish'])) {
                if (isset($_POST['record'])) {
                    if ($row_num = $this->deceasedModel->publishById($_POST['record'], 'deceased_id')) {
                        flash('deceased_msg', 'تم تفعيل حملة المتوفي ' . $row_num . ' بنجاح');
                    } else {
                        flash('deceased_msg', 'هناك خطأ ما يرجي المحاولة لاحقا', 'alert alert-danger');
                    }
                }
                redirect('deceaseds');
            }

            //handling Unpublish
            if (isset($_POST['unpublish'])) {

                if (isset($_POST['record'])) {
                    if ($row_num = $this->deceasedModel->unpublishById($_POST['record'], 'deceased_id')) {
                        flash('deceased_msg', 'تم تعليق  حملة المتوفي ' . $row_num . ' بنجاح');
                    } else {
                        flash('deceased_msg', 'هناك خطأ ما يرجي المحاولة لاحقا', 'alert alert-danger');
                    }
                }
                redirect('deceaseds');
            }
        }
        //handling search
        $searches = $this->deceasedModel->searchHandling(['name', 'mobile', 'email', 'deceased_name', 'target_price', 'status', 'confirmed'], $current);

        $cond .= $searches['cond'];
        $bind = $searches['bind'];
        // date project
        if (!empty($_POST['search']['project_id'])) {
            $cond .= ' AND deceaseds.project_id =  ' . $_POST['search']['project_id'];
            $_SESSION['search']['project_id'] = $_POST['search']['project_id'];
        }
        // date search
        if (!empty($_POST['search']['date_from'])) {
            $cond .= ' AND create_date >= :date_from ';
            $bind[':date_from'] = strtotime($_POST['search']['date_from']);
        }
        if (!empty($_POST['search']['date_to'])) {
            $cond .= ' AND create_date <= :date_to ';
            $bind[':date_to'] = strtotime($_POST['search']['date_to']) + 86400;
        }

        // get all records count after search and filtration
        $recordsCount = $this->deceasedModel->allDeceasedCount();


        // make sure its integer value and its usable
        $current = (int) $current;
        $perpage = (int) $perpage;

        ($perpage == 0) ? $perpage = 20 : null;
        if ($current <= 0 || $current > ceil($recordsCount->count / $perpage)) {
            $current = 1;
            $limit = 'LIMIT 0 , :perpage ';
            $bindLimit[':perpage'] = $perpage;
        } else {
            $limit = 'LIMIT  ' . (($current - 1) * $perpage) . ', :perpage';
            $bindLimit[':perpage'] = $perpage;
        }
        //get all records for current deceased
        $deceased = $this->deceasedModel->getDeceased($cond, $bind, $limit, $bindLimit);
        // get Projects deceased
        $projectsIds =  $this->deceasedModel->getProjectsSettingIds()->campaign_projects;
        $projects =  $this->deceasedModel->getProjectsWithIds($projectsIds);


        $data = [
            'current' => $current,
            'perpage' => $perpage,
            'header' => '',
            'title' => 'حملة المتوفي',
            'deceaseds' => $deceased,
            'projects' => $projects,
            'recordsCount' => $recordsCount->count,
            'footer' => '',
        ];
        $this->view('deceased/index', $data);
    }

    /**
     * delete record by id
     * @param integer $id
     */
    public function delete($id)
    {

        if ($row_num = $this->deceasedModel->deleteById([$id], 'deceased_id')) {
            flash('deceased_msg', 'تم حذف ' . $row_num . ' بنجاح');
        } else {
            flash('deceased_msg', 'لم يتم الحذف', 'alert alert-danger');
        }
        redirect('deceaseds');
    }

    /**
     * publish record by id
     * @param integer $id
     */
    public function publish($id)
    {
        if ($row_num = $this->deceasedModel->publishById([$id], 'deceased_id')) {
            flash('deceased_msg', 'تم نشر ' . $row_num . ' بنجاح');
        } else {
            flash('deceased_msg', 'هناك خطأ ما يرجي المحاولة لاحقا', 'alert alert-danger');
        }
        redirect('deceaseds');
    }

    /**
     * publish record by id
     * @param integer $id
     */
    public function unpublish($id)
    {
        if ($row_num = $this->deceasedModel->unpublishById([$id], 'deceased_id')) {
            flash('deceased_msg', 'تم ايقاف نشر ' . $row_num . ' بنجاح');
        } else {
            flash('deceased_msg', 'هناك خطأ ما يرجي المحاولة لاحقا', 'alert alert-danger');
        }
        redirect('deceaseds');
    }

    /**
     * show record by id
     * @param integer $id
     */
    public function show($id)
    {
        $deceased = $this->deceasedModel->getDeceasedById($id);
        $project = $this->projectModel->getProjectById($deceased->project_id);
        $project->category = $this->deceasedModel->getProjectCategoryById($project->category_id);
        $cond = '';
        $bind = [];
        $orders = $this->deceasedModel->getOrdersByDeseasedID($id, $cond, $bind);
        $totalorders = $this->deceasedModel->getOrderTotalById($id,  $cond, $bind);
        $data = [
            'page_title' => ' عرض حمله المتوفي',
            'deceased' => $deceased,
            'project' => $project,
            'totalorders' => $totalorders,
            'orders' => $orders,
            'paymentMethodsList' => $this->orderModel->paymentMethodsList(' WHERE status <> 2 '),
            'statusesList' => $this->orderModel->statusesList(),
        ];
        
        $this->view('deceased/show', $data);
    }

    /**
     * confirm record by id
     * @param integer $id
     */
    public function edit($id)
    {
        $deceased = $this->deceasedModel->getDeceasedById($id);
        $project = $this->projectModel->getProjectById($deceased->project_id);
        $categories =  $this->projectModel->categoriesList(' WHERE status <> 2 ');
        if (!$project) {
            flash('project_msg', 'هناك خطأ ما هذه الصفحة غير موجوده او ربما اتبعت رابط خاطيء ', 'alert alert-danger');
            redirect('deceaseds');
        }

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            // sanitize POST array
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            // set post of tags to an array if its empty
            isset($_POST['tags']) ? null : $_POST['tags'] = [];
            $description = html_entity_decode($_POST['description']);

            $data = [
                'page_title' => ' تاكيد حمله المتوفي',
                'name' => trim($_POST['name']),
                'project_number' => trim($_POST['project_number']),
                'beneficiary' => trim($_POST['beneficiary']),
                'alias' => preg_replace("([~!@#$%^&*()_+=`{}\[\]\|\\:;'<>,.\/? ])", "-", $_POST['name']),
                'description' => $description,
                'image' => trim($_POST['image']),
                'secondary_image' => '',
                'enable_cart' => trim($_POST['enable_cart']),
                'gift' => trim($_POST['gift']),
                'gift_card_title' => trim($_POST['gift_card_title']),
                'mobile_confirmation' => trim($_POST['mobile_confirmation']),
                'donation_type' => $_POST['donation_type'],
                'donation_type_list' => ['share' => 'تبرع بالاسهم', 'fixed' => 'قيمة ثابته', 'open' => 'تبرع مفتوح', 'unit' => 'فئات'],
                'payment_methods' => [],
                'paymentMethodsList' => $this->projectModel->paymentMethodsList(' WHERE status <> 2 '),
                'target_price' => trim($_POST['target_price']),
                'target_unit' => trim($_POST['target_unit']),
                'unit_price' => (int) $_POST['unit_price'],
                'fake_target' => trim($_POST['fake_target']),
                'hidden' => trim($_POST['hidden']),
                'thanks_message' => trim($_POST['thanks_message']),
                'sms_msg' => trim($_POST['sms_msg']),
                'advertising_code' => trim($_POST['advertising_code']),
                'header_code' => trim($_POST['header_code']),
                'whatsapp' => trim($_POST['whatsapp']),
                'mobile' => trim($_POST['mobile']),
                'end_date' => strtotime($_POST['end_date']),
                'start_date' => strtotime($_POST['start_date']),
                'category_id' => trim($_POST['category_id']),
                'categories' => $categories,
                'tags' => $_POST['tags'],
                'tagsList' => $this->projectModel->tagsList(),
                'meta_keywords' => trim($_POST['meta_keywords']),
                'meta_description' => trim($_POST['meta_description']),
                'finished' => $_POST['finished'],
                'status' => '',
                'arrangement' => trim($_POST['arrangement']),
                'badal' => 0,
                'kafara' => trim($_POST['kafara']),
                'back_home' => trim($_POST['back_home']),
                'background_image' => '',
                'background_color' => trim($_POST['background_color']),
                'featured' => trim($_POST['featured']),
                'project_number_error' => '',
                'name_error' => '',
                'category_id_error' => '',
                'donation_type_error' => '',
                'payment_methods_error' => '',
                'secondary_image_error' => '',
                'background_image_error' => '',
                'status_error' => '',
            ];

            // validate name
            !(empty($data['name'])) ?: $data['name_error'] = 'هذا الحقل مطلوب';
            //validate donation type
            if (empty($data['donation_type']['type'])) {
                $data['donation_type_error'] = 'برجاء اختيار نوع التبرع';
            } else {
                if (empty($data['donation_type']['value']) && $data['donation_type']['type'] != 'open') {
                    $data['donation_type_error'] = 'برجاء اختيار قيمة التبرع';
                }
            }

            //validate project number
            $this->projectModel->itemExistAPI($_POST['project_number']) ?: $data['project_number_error'] = 'هذا الرقم غير متوافق مع برنامج AX';
            //validate category
            !empty($data['category_id']) ?: $data['category_id_error'] = 'يجب اختيار القسم الخاص بالمشروع';
            // validate payment methods
            empty($_POST['payment_methods']) ? $data['payment_methods_error'] = 'يجب اختيار وسيلة دفع واحدة علي الأقل' : $data['payment_methods'] = $_POST['payment_methods'];
           
           
            // validate secondary image
            // $image = $this->projectModel->validateImage('secondary_image');
            // ($image[0]) ? $data['secondary_image'] = $image[1] : $data['secondary_image_error'] = $image[1];
              if (!empty($_FILES['secondary_image'])) {
                $image = uploadImage('secondary_image', ADMINROOT . '/../media/images/', 5000000, true);
                if (empty($image['error'])) {
                    $data['secondary_image'] = $image['filename'];
                } else {
                    if (!isset($image['error']['nofile'])) {
                        $data['secondary_image_error'] = implode(',', $image['error']);
                    }
                }
            }







            // validate background image
            // $image = $this->projectModel->validateImage('background_image');
            // ($image[0]) ? $data['background_image'] = $image[1] : $data['background_image_error'] = $image[1];
            
            if (!empty($_FILES['background_image'])) {
                $image = uploadImage('background_image', ADMINROOT . '/../media/images/', 5000000, true);
                if (empty($image['error'])) {
                    $data['background_image'] = $image['filename'];
                } else {
                    if (!isset($image['error']['nofile'])) {
                        $data['background_image_error'] = implode(',', $image['error']);
                    }
                }
            }


            // validate start and end date
            if ($data['end_date'] < 0 || $data['end_date'] > 2147483648) $data['end_date'] = 0;
            if ($data['start_date'] < 0 || $data['start_date'] > 2147483648) $data['start_date'] = 0;
            // validate status
            if (isset($_POST['status'])) {
                $data['status'] = trim($_POST['status']);
            }
            if ($data['status'] == '') {
                $data['status_error'] = 'من فضلك اختار حالة النشر';
            }
            //make sure there is no errors
            if (
                empty($data['status_error']) && empty($data['name_error']) && empty($data['background_image_error']) && empty($data['donation_type_error'])
                && empty($data['category_id_error']) && empty($data['payment_methods_error']) && empty($data['secondary_image_error']) && empty($data['project_number_error'])
            ) {
                //validated
                if ($projectId = $this->projectModel->addProject($data)) {
                    $this->projectModel->insertTags($data['tags'], $projectId);
                    $this->deceasedModel->updateProjectDeceaseds($id, $projectId);
                    $this->deceasedModel->updateDeceasedsProject($id, $projectId);
                    $this->deceasedModel->updateDeceasedsConfirmed($id);
                    $this->deceasedModel->sendConfirmation($data['mobile'] , $projectId);

                    flash('confirmed_msg', 'تم الحفظ بنجاح');
                    redirect('deceaseds/show/' . $id);
                } else {
                    flash('confirmed_msg', 'هناك خطأ ما حاول مرة اخري', 'alert alert-danger');
                    $this->view('deceased/confirm', $data);
                }
            } else {
                //load the view with error
                $this->view('deceased/confirm', $data);
            }
        } else {
            $id = (int) $id;
            $categories =  $this->projectModel->categoriesList(' WHERE status <> 2 ');
            $data = [
                'page_title'                => 'تاكيد حمله المتوفي',
                'id'                        => $id,
                'deceased'                  => $deceased,
                'project_id'                => $project->project_id,
                'name'                      => $project->name,
                'project_number'            => $project->project_number,
                'beneficiary'               => $project->beneficiary,
                'description'               => $project->description,
                'image'                     => $project->image,
                'meta_keywords'             => $project->meta_keywords,
                'meta_description'          => $project->meta_description,
                'finished'                  => $project->finished,
                'status'                    => $project->status,
                'arrangement'               => $project->arrangement,
                'kafara'                    => $project->kafara,
                'back_home'                 => $project->back_home,
                'background_image'          => $project->background_image,
                'background_color'          => $project->background_color,
                'featured'                  => $project->featured,
                'secondary_image'           => $project->secondary_image,
                'enable_cart'               => $project->enable_cart,
                'gift'                      => $project->gift,
                'gift_card_title'           => $project->gift_card_title,
                'mobile_confirmation'       => $project->mobile_confirmation,
                'donation_type'             => json_decode($project->donation_type, true),
                'donation_type_list'        => ['share' => 'تبرع بالاسهم', 'fixed' => 'قيمة ثابته', 'open' => 'تبرع مفتوح', 'unit' => 'فئات'],
                'payment_methods'           => json_decode($project->payment_methods, true),
                'paymentMethodsList'        => $this->projectModel->paymentMethodsList(' WHERE status <> 2 '),
                'target_price'              => $deceased->target_price,
                'target_unit'               => 0,
                'unit_price'                => 0,
                'fake_target'               => 0,
                'hidden'                    => 1,
                'sms_msg'                   => $project->sms_msg,
                'thanks_message'            => $project->thanks_message,
                'advertising_code'          => $project->advertising_code,
                'header_code'               => $project->header_code,
                'whatsapp'                  => $project->whatsapp,
                'mobile'                    => $project->mobile,
                'end_date'                  => $project->end_date,
                'start_date'                => $project->start_date,
                'category_id'               => $project->category_id,
                'categories'                => $categories,
                'tags'                      => $this->projectModel->tagsListByProject($id),
                'tagsList'                  => $this->projectModel->tagsList(),
                'donation_type_error'       => '',
                'category_id_error'         => '',
                'name_error'                => '',
                'status_error'              => '',
                'image_error'               => '',
                'project_number_error'      => '',
                'secondary_image_error'     => '',
                'payment_methods_error'     => '',
                'background_image_error'    => '',
            ];

            if (!$project) {
                flash('project_msg', 'هناك خطأ ما هذه الصفحة غير موجوده او ربما اتبعت رابط خاطيء ', 'alert alert-danger');
                redirect('deceaseds');
            }
            $this->view('deceased/confirm', $data);
        }
    }

  



}