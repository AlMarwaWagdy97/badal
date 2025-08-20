<?php

/*
 * Copyright (C) 2018 Easy CMS Framework Ahmed Elmahdy
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License
 * @license    https://opensource.org/licenses/GPL-3.0
 *
 * @package    Easy CMS MVC framework
 * @author     Ahmed Elmahdy
 * @link       https://ahmedx.com
 *
 * For more information about the author , see <http://www.ahmedx.com/>.
 */

class AppArticles extends ControllerAdmin
{

    private $model;
    private $sections;
    public function __construct()
    {
        $this->model = $this->model('AppArticle');
        $this->sections = $this->model('AppSection');
    }

    /**
     * loading index view with latest apparticles
     */
    public function index($current = '', $perpage = 50)
    {
        // get apparticles
        $cond = ', app_sections WHERE app_articles.section_id = app_sections.section_id AND app_articles.status <> 2 ';
        $bind = [];

        //check user action if the form has submitted 
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // sanitize POST array
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

            //handling Delete
            if (isset($_POST['delete'])) {
                if (isset($_POST['record'])) {
                    if ($row_num = $this->model->deleteById($_POST['record'], 'article_id')) {
                        flash('appArticle_msg', 'تم حذف ' . $row_num . ' بنجاح');
                    } else {
                        flash('appArticle_msg', 'لم يتم الحذف', 'alert alert-danger');
                    }
                }

                redirect('apparticles');
            }

            //handling Publish
            if (isset($_POST['publish'])) {
                if (isset($_POST['record'])) {
                    if ($row_num = $this->model->publishById($_POST['record'], 'article_id')) {
                        flash('appArticle_msg', 'تم نشر ' . $row_num . ' بنجاح');
                    } else {
                        flash('appArticle_msg', 'هناك خطأ ما يرجي المحاولة لاحقا', 'alert alert-danger');
                    }
                }
                redirect('apparticles');
            }

            //handling Unpublish
            if (isset($_POST['unpublish'])) {

                if (isset($_POST['record'])) {
                    if ($row_num = $this->model->unpublishById($_POST['record'], 'article_id')) {
                        flash('appArticle_msg', 'تم ايقاف نشر ' . $row_num . ' بنجاح');
                    } else {
                        flash('appArticle_msg', 'هناك خطأ ما يرجي المحاولة لاحقا', 'alert alert-danger');
                    }
                }
                redirect('apparticles');
            }
        }

        //handling search
        $searches = $this->model->searchHandling(['title', 'status'], $current);
        $cond .= $searches['cond'];
        $bind = $searches['bind'];

        // get all records count after search and filtration 
        $recordsCount = $this->model->allAppArticlesCount($cond, $bind);
        // make sure its integer value and its usable
        $current = (int) $current;
        $perpage = (int) $perpage;

        ($perpage == 0) ? $perpage = 20 : NULL;
        if ($current <= 0 || $current > ceil($recordsCount->count / $perpage)) {
            $current = 1;
            $limit = 'LIMIT 0 , :perpage ';
            $bindLimit[':perpage'] = $perpage;
        } else {
            $limit = 'LIMIT  ' . (($current - 1) * $perpage) . ', :perpage';
            $bindLimit[':perpage'] = $perpage;
        }
        //get all records for current page
        $apparticles = $this->model->getAppArticles($cond, $bind, $limit, $bindLimit);

        $data = [
            'current' => $current,
            'perpage' => $perpage,
            'header' => '',
            'title' => 'الموضوعات',
            'apparticles' => $apparticles,
            'recordsCount' => $recordsCount->count,
            'footer' => ''
        ];
        $this->view('apparticles/index', $data);
    }

    /**
     * adding new page
     */
    public function add()
    {
        if (!$sections = $this->sections->getAppSections(' WHERE status <> 2 ', '', '', '', '')) {
            flash('project_msg', 'برجاء انشاء قسم اولا حتي تتمكن من انشاء مشروع جديد ', 'alert alert-danger');
            redirect('appsections');
        }
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            $content = $this->model->cleanHTML($_POST['content']);
            // sanitize POST array
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

            $data = [
                'page_title' => 'الموضوعات',
                'title' => trim($_POST['title']),
                'alias' => preg_replace("([~!@#$%^&*()_+=`{}\[\]\|\\:;'<>,.\/? ])", "-", $_POST['title']),
                'content' => $content,
                'sections' => $sections,
                'section_id' => $_POST['section_id'],
                'image' => '',
                'status_error' => '',
                'image_error' => '',
                'section_id_error' => ''
            ];

            // validate image
            if (!empty($_FILES['image'])) {
                $image = uploadImage('image', ADMINROOT . '/../media/images/', 5000000, TRUE);
                if (empty($image['error'])) {
                    $data['image'] = $image['filename'];
                } else {
                    if (!isset($image['error']['nofile'])) {
                        $data['image_error'] = implode(',', $image['error']);
                    }
                }
            }
            // validate status
            if (isset($_POST['status'])) {
                $data['status'] = trim($_POST['status']);
            }
            if ($data['status'] == '') {
                $data['status_error'] = 'من فضلك اختار حالة النشر';
            }
            //             make sure there is no errors
            if (empty($data['status_error']) && empty($data['image_error'])) {
                //validated 
                if ($this->model->addAppArticle($data)) {
                    flash('appArticle_msg', 'تم الحفظ بنجاح');
                    redirect('apparticles');
                } else {
                    flash('appArticle_msg', 'هناك خطأ ما حاول مرة اخري', 'alert alert-danger');
                }
            } else {
                //load the view with error
                $this->view('apparticles/add', $data);
            }
        } else {
            $data = [
                'page_title' => 'الموضوعات',
                'title' => '',
                'content' => '',
                'section_id' => '',
                'sections' => $sections,
                'image' => '',
                'status' => 0,
                'title_error' => '',
                'status_error' => '',
                'image_error' => '',
                'section_id_error' => ''
            ];
        }

        //loading the add page view
        $this->view('apparticles/add', $data);
    }

    /**
     * update page
     * @param integer $id
     */
    public function edit($id)
    {
        if (!$sections = $this->sections->getAppSections(' WHERE status <> 2 ', '', '', '', '')) {
            flash('project_msg', 'برجاء انشاء قسم اولا حتي تتمكن من انشاء مشروع جديد ', 'alert alert-danger');
            redirect('appsections');
        }
        $id = (int) $id;
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            //cleare html content from malicious
            $content = $this->model->cleanHTML($_POST['content']);
            // sanitize POST array
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

            $data = [
                'article_id' => $id,
                'page_title' => 'الموضوعات',
                'title' => trim($_POST['title']),
                'section_id' => $_POST['section_id'],
                'content' => $content,
                'sections' => $sections,
                'image' => '',
                'status' => '',
                'status_error' => '',
                'image_error' => '',
                'section_id_error' => ''
            ];

            // validate image
            if (!empty($_FILES['image'])) {
                $image = uploadImage('image', ADMINROOT . '/../media/images/', 5000000, TRUE);
                if (empty($image['error'])) {
                    $data['image'] = $image['filename'];
                } else {
                    if (!isset($image['error']['nofile'])) {
                        $data['image_error'] = implode(',', $image['error']);
                    }
                }
            }
            // validate status
            if (isset($_POST['status'])) {
                $data['status'] = trim($_POST['status']);
            }
            if ($data['status'] == '') {
                $data['status_error'] = 'من فضلك اختار حالة النشر';
            }
            //             make sure there is no errors
            if (empty($data['status_error']) && empty($data['image_error'])) {
                //validated 
                if ($this->model->updateAppArticle($data)) {
                    flash('appArticle_msg', 'تم التعديل بنجاح');
                    isset($_POST['save']) ? redirect('apparticles/edit/' . $id) : redirect('apparticles');
                } else {
                    flash('appArticle_msg', 'هناك خطأ ما حاول مرة اخري', 'alert alert-danger');
                }
            } else {
                //load the view with error
                $this->view('apparticles/edit', $data);
            }
        } else {
            // featch page       
            if (!$articles = $this->model->getAppArticleById($id)) {
                flash('appArticle_msg', 'هناك خطأ ما هذه الصفحة غير موجوده او ربما اتبعت رابط خاطيء ', 'alert alert-danger');
                redirect('apparticles');
            }

            $data = [
                'page_title' => 'الموضوعات',
                'article_id' => $id,
                'title' => $articles->title,
                'sections' => $sections,
                'content' => $articles->content,
                'image' => $articles->image,
                'status' => $articles->status,
                'section_id' => $articles->section_id,
                'title_error' => '',
                'status_error' => '',
                'image_error' => '',
                'section_id_error' => ''
            ];
            $this->view('apparticles/edit', $data);
        }
    }

    /**
     * showing apparticle details
     * @param integer $id
     */
    public function show($id)
    {
        if (!$articles = $this->model->getAppArticleById($id)) {
            flash('appArticle_msg', 'هناك خطأ ما هذه الصفحة غير موجوده او ربما اتبعت رابط خاطيء ', 'alert alert-danger');
            redirect('apparticles');
        }
        $data = [
            'page_title' => 'الموضوعات',
            'article' => $articles
        ];
        $this->view('apparticles/show', $data);
    }

    /**
     * delete record by id 
     * @param integer $id
     */
    public function delete($id)
    {
        if ($row_num = $this->model->deleteById([$id], 'article_id')) {
            flash('appArticle_msg', 'تم حذف ' . $row_num . ' بنجاح');
        } else {
            flash('appArticle_msg', 'لم يتم الحذف', 'alert alert-danger');
        }
        redirect('apparticles');
    }

    /**
     * publish record by id 
     * @param integer $id
     */
    public function publish($id)
    {
        if ($row_num = $this->model->publishById([$id], 'article_id')) {
            flash('appArticle_msg', 'تم نشر ' . $row_num . ' بنجاح');
        } else {
            flash('appArticle_msg', 'هناك خطأ ما يرجي المحاولة لاحقا', 'alert alert-danger');
        }
        redirect('apparticles');
    }

    /**
     * publish record by id 
     * @param integer $id
     */
    public function unpublish($id)
    {
        if ($row_num = $this->model->unpublishById([$id], 'article_id')) {
            flash('appArticle_msg', 'تم ايقاف نشر ' . $row_num . ' بنجاح');
        } else {
            flash('appArticle_msg', 'هناك خطأ ما يرجي المحاولة لاحقا', 'alert alert-danger');
        }
        redirect('apparticles');
    }
}
