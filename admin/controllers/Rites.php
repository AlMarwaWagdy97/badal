<?php

class Rites extends ControllerAdmin
{
    private $ritualModel;

    public function __construct()
    {
        $this->ritualModel = $this->model('Rite');
    }

    /**
     * loading index view with latest Rites
     */
    public function index($current = '', $perpage = 50)
    {
        // get Rites
        $cond = 'WHERE rites.status <> 2 AND  rites.project_id = projects.project_id  ';
        $bind = [];
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // sanitize POST array
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            //handling Delete
            if (isset($_POST['delete'])) {
                if (isset($_POST['record'])) {
                    if ($row_num = $this->ritualModel->deleteById($_POST['record'], 'rite_id ')) {
                        flash('rites_msg', 'تم حذف ' . $row_num . ' بنجاح');
                    } else {
                        flash('rites_msg', 'لم يتم الحذف', 'alert alert-danger');
                    }
                }
                redirect('rites');
            }

            //handling Publish
            if (isset($_POST['publish'])) {
                if (isset($_POST['record'])) {
                    if ($row_num = $this->ritualModel->publishById($_POST['record'], 'rite_id ')) {
                        flash('rites_msg', 'تم تفعيل حملة المتوفي ' . $row_num . ' بنجاح');
                    } else {
                        flash('rites_msg', 'هناك خطأ ما يرجي المحاولة لاحقا', 'alert alert-danger');
                    }
                }
                redirect('rites');
            }

            //handling Unpublish
            if (isset($_POST['unpublish'])) {
                if (isset($_POST['record'])) {
                    if ($row_num = $this->ritualModel->unpublishById($_POST['record'], 'rite_id ')) {
                        flash('rites_msg', 'تم تعليق  حملة المتوفي ' . $row_num . ' بنجاح');
                    } else {
                        flash('rites_msg', 'هناك خطأ ما يرجي المحاولة لاحقا', 'alert alert-danger');
                    }
                }
                redirect('rites');
            }
        }
        //handling search
        $searches = $this->ritualModel->searchHandling(['title',  'proof', 'status'], $current);

        $cond .= $searches['cond'];
        $bind = $searches['bind'];
        // date project
        if (!empty($_POST['search']['project_ids'])) {
            $cond .= ' AND rites.project_id in ( ' . implode(',',  $_POST['search']['project_ids']) . ' ) ';
            $_SESSION['search']['project_ids'] = $_POST['search']['project_ids'];
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
        $recordsCount = $this->ritualModel->allRitesCount();


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
        $rituals = $this->ritualModel->getRites($cond, $bind, $limit, $bindLimit);
        $projects =  $this->ritualModel->getProjects();


        $data = [
            'current'                   => $current,
            'perpage'                   => $perpage,
            'header'                    => '',
            'title'                     => 'مناسك الحج والعمره',
            'rites'                     => $rituals,
            'projects'                  => $projects,
            'recordsCount'              => $recordsCount->count,
            'footer'                    => '',
        ];
        $this->view('rites/index', $data);
    }


    /**
        * add rites
        *
        */
    public function add()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // sanitize POST array
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        
            $data = [
                'page_title'                => 'مناسك الحج والعمره',
                'projects'                  => $this->ritualModel->getProjects(' WHERE status = 1 '),
                'title'                     => trim($_POST['title']),
                'project_id'                => $_POST['project_id'],
                'proof'                     => trim($_POST['proof']),
                'status'                    => trim($_POST['status']),
                'arrangement'               => $_POST['arrangement'],
                'time_taken'               => $_POST['time_taken']??0,
                'title_error'               => '',
                'project_id_error'          => '',
                'proof_error'               => '',
                'status_error'              => '',
                'image_error'               => '',

            ];
            !(empty($data['title'])) ?: $data['title_error'] = 'هذا الحقل مطلوب';
            !(empty($data['project_id'])) ?: $data['project_id_error'] = 'هذا الحقل مطلوب';
             // validate image
             if (!empty($_FILES['image'])) {
                $image = uploadImage('image',   ADMINROOT . '/../media/files/rites/', 5000000, true);
                if (empty($image['error'])) {
                    $data['image'] = $image['filename'];
                } else {
                    if (!isset($image['error']['nofile'])) {
                        $data['image_error'] = implode(',', $image['error']);
                    }
                }
            }
        
            //make sure there is no errors
            if (empty($data['title_error'])  && empty($data['project_id_error'])
               &&  $data['proof'] != "" && $data['status'] != "" ) {
                //validated
                if ($this->ritualModel->addRites($data)) {
                    flash('rites_msg', 'تم الحفظ بنجاح');
                    redirect('rites');
                } else {
                    flash('rites_msg', 'هناك خطأ ما حاول مرة اخري', 'alert alert-danger');
                }
            } else {
                //load the view with error
                $this->view('rites/add', $data);
            }
        } else {
          
            $data = [
                'page_title'                => 'مناسك الحج والعمره',
                'projects'                  => $this->ritualModel->getProjects(' WHERE status = 1 '),
                'title'                     => '',
                'project_id'                => '',
                'proof'                     => '',
                'image  '                   => '',
                'arrangement'               => 0,
                'time_taken'                => 0,
                'status'                    => 0,
                'title_error'               => '',
                'project_id_error'          => '',
                'proof_error'               => '',
                'status_error'              => '',
                'image_error'               => '',

            ];
            $this->view('rites/add', $data);
        }
    }

    /**
     * delete record by id
     * @param integer $id
     */
    public function delete($id)
    {

        if ($row_num = $this->ritualModel->deleteById([$id], 'rite_id')) {
            flash('rites_msg', 'تم حذف ' . $row_num . ' بنجاح');
        } else {
            flash('rites_msg', 'لم يتم الحذف', 'alert alert-danger');
        }
        redirect('rites');
    }

    /**
     * publish record by id
     * @param integer $id
     */
    public function publish($id)
    {
        if ($row_num = $this->ritualModel->publishById([$id], 'rite_id')) {
            flash('rites_msg', 'تم نشر ' . $row_num . ' بنجاح');
        } else {
            flash('rites_msg', 'هناك خطأ ما يرجي المحاولة لاحقا', 'alert alert-danger');
        }
        redirect('rites');
    }

    /**
     * publish record by id
     * @param integer $id
     */
    public function unpublish($id)
    {
        if ($row_num = $this->ritualModel->unpublishById([$id], 'rite_id')) {
            flash('rites_msg', 'تم ايقاف نشر ' . $row_num . ' بنجاح');
        } else {
            flash('rites_msg', 'هناك خطأ ما يرجي المحاولة لاحقا', 'alert alert-danger');
        }
        redirect('rites');
    }

    /**
     * show record by id
     * @param integer $id
     */
    public function show($id)
    {
        $id = (int) $id;
        $rites = $this->ritualModel->getRituaById($id);
        $project = $this->ritualModel->getProjectById($rites->project_id);
        $data = [
            'page_title'                => 'مناسك الحج والعمره',
            'rites'                     => $rites,
            'project'                   => $project,
        ];
        
        $this->view('rites/show', $data);
    }

    /**
     * confirm record by id
     * @param integer $id
     */
    public function edit($id)
    {
        $id = (int) $id;
        $rites = $this->ritualModel->getRituaById($id);
        if (!$rites) {
            flash('rites_msg', 'هناك خطأ ما هذه الصفحة غير موجوده او ربما اتبعت رابط خاطيء ', 'alert alert-danger');
            redirect('rites_msg');
        }

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // sanitize POST array
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            // set post of tags to an array if its empty
         
            $data = [
                'page_title'                => 'مناسك الحج والعمره',
                'projects'                  => $this->ritualModel->getProjects(' WHERE status = 1 '),
                'rite_id'                   => $rites->rite_id,
                'title'                     => trim($_POST['title']),
                'project_id'                => $_POST['project_id'],
                'proof'                     => trim($_POST['proof']),
                'status'                    => trim($_POST['status']),
                'arrangement'               => $_POST['arrangement'],
                'time_taken'                => $_POST['time_taken'] ?? 0,
                'image'                     => '',
                'title_error'               => '',
                'project_id_error'          => '',
                'proof_error'               => '',
                'status_error'              => '',
                'image_error'               => '',
            ];
            !(empty($data['title'])) ?: $data['title_error'] = 'هذا الحقل مطلوب';
            !(empty($data['project_id'])) ?: $data['project_id_error'] = 'هذا الحقل مطلوب';
            // validate image
            if (!empty($_FILES['image'])) {
                $image = uploadImage('image',   ADMINROOT . '/../media/files/rites/', 5000000, true);
                if (empty($image['error'])) {
                    $data['image'] = $image['filename'];
                } else {
                    if (!isset($image['error']['nofile'])) {
                        $data['image_error'] = implode(',', $image['error']);
                    }
                }
            }
            //make sure there is no errors
            if (empty($data['title_error']) && empty($data['project_id_error'])
               && empty($data['image_error']) && $data['proof'] != "" && $data['status'] != "" ) {
                //validated
                if ($this->ritualModel->updateRites($data)) {
                    flash('rites_msg', 'تم التعديل بنجاح');
                    isset($_POST['save']) ? redirect('rites/edit/' . $id) : redirect('rites');
                } else {
                    flash('rites_msg', 'هناك خطأ ما حاول مرة اخري', 'alert alert-danger');
                }
            } else {
                //load the view with error
                $this->view('rites/edit', $data);
            }
        } else {
            $data = [
                'page_title'                => 'مناسك الحج والعمره',
                'projects'                  => $this->ritualModel->getProjects(' WHERE status = 1 '),
                'rite_id'                   => $rites->rite_id,
                'title'                     => $rites->title,
                'project_id'                => $rites->project_id,
                'proof'                     => $rites->proof,
                'status'                    => $rites->status,
                'image'                     => $rites->image,
                'arrangement'               => $rites->arrangement,
                'time_taken'               => $rites->time_taken,
                'title_error'               => '',
                'project_id_error'          => '',
                'proof_error'               => '',
                'status_error'              => '',
                'image_error'               => '',
            ];
            $this->view('rites/edit', $data);
        }
    }

  
 


}