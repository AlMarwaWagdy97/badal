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

class Articles extends ControllerAdmin
{

    private $article;

    public function __construct()
    {
        $this->article = $this->model('Article');
    }

    /**
     * loading index view with latest articles
     */
    public function index($current = '', $perpage = 50)
    {
        // get articles
        $cond = 'WHERE status <> 2 ';
        $bind = [];

        //check user action if the form has submitted
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // sanitize POST array
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

            //handling Delete
            if (isset($_POST['delete'])) {
                if (isset($_POST['record'])) {
                    if ($row_num = $this->article->deleteById($_POST['record'], 'article_id')) {
                        flash('articles_msg', 'تم حذف ' . $row_num . ' بنجاح');
                    } else {
                        flash('articles_msg', 'لم يتم الحذف', 'alert alert-danger');
                    }
                }

                redirect('articles');
            }

            //handling Publish
            if (isset($_POST['publish'])) {
                if (isset($_POST['record'])) {
                    if ($row_num = $this->article->publishById($_POST['record'], 'article_id')) {
                        flash('articles_msg', 'تم نشر ' . $row_num . ' بنجاح');
                    } else {
                        flash('articles_msg', 'هناك خطأ ما يرجي المحاولة لاحقا', 'alert alert-danger');
                    }
                }
                redirect('articles');
            }

            //handling Unpublish
            if (isset($_POST['unpublish'])) {

                if (isset($_POST['record'])) {
                    if ($row_num = $this->article->unpublishById($_POST['record'], 'article_id')) {
                        flash('articles_msg', 'تم ايقاف نشر ' . $row_num . ' بنجاح');
                    } else {
                        flash('articles_msg', 'هناك خطأ ما يرجي المحاولة لاحقا', 'alert alert-danger');
                    }
                }
                redirect('articles');
            }
        }

        //handling search
        $searches = $this->article->searchHandling(['name', 'description', 'status'], $current);
        $cond .= $searches['cond'];
        $bind = $searches['bind'];

        // get all records count after search and filtration
        $recordsCount = $this->article->allArticlesCount($cond, $bind);
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
        //get all records for current articles
        $article = $this->article->getArticles($cond, $bind, $limit, $bindLimit);

        $data = [
            'current' => $current,
            'perpage' => $perpage,
            'header' => '',
            'title' => 'الاخبار والمقالات',
            'articles' => $article,
            'recordsCount' => $recordsCount->count,
            'footer' => '',
        ];
        $this->view('articles/index', $data);
    }

    /**
     * adding new articles
     */
    public function add()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // sanitize POST array
            $description = $this->article->cleanHTML($_POST['description']);
            $content = $this->article->cleanHTML($_POST['content']);
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $data = [
                'page_title' => 'الاخبار والمقالات',
                'name' => trim($_POST['name']),
                'alias' => preg_replace("([~!@#$%^&*()_+=`{}\[\]\|\\:;'<>,.\/? ])", "-", $_POST['name']),
                'description' => $description,
                'image' => '',
                'meta_keywords' => trim($_POST['meta_keywords']),
                'meta_description' => trim($_POST['meta_description']),
                'status' => '',
                'arrangement' => trim($_POST['arrangement']),
                'news_ticker' => trim($_POST['news_ticker']),
                'content' => $content,
                'featured' => trim($_POST['featured']),
                'status_error' => '',
                'name_error' => '',
                'image_error' => '',
                'background_image_error' => '',
            ];
// validate name
            if (empty($data['name'])) {
                $data['name_error'] = 'هذا الحقل مطلوب';
            }
            // validate image
            if (!empty($_FILES['image'])) {
                $image = uploadImage('image', ADMINROOT . '/../media/images/', 5000000, true);
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
            if (empty($data['status_error']) && empty($data['image_error']) && empty($data['name_error'])) {
                //validated
                if ($this->article->addArticle($data)) {
                    flash('articles_msg', 'تم الحفظ بنجاح');
                    redirect('articles');
                } else {
                    flash('articles_msg', 'هناك خطأ ما حاول مرة اخري', 'alert alert-danger');
                }
            } else {
                //load the view with error
                $this->view('articles/add', $data);
            }
        } else {
            $data = [
                'page_title' => 'الاخبار والمقالات',
                'name' => '',
                'description' => '',
                'image' => '',
                'meta_keywords' => '',
                'meta_description' => '',
                'status' => 0,
                'arrangement' => 0,
                'news_ticker' => 0,
                'content' => '',
                'featured' => 0,
                'name_error' => '',
                'status_error' => '',
                'image_error' => '',
            ];
        }

        //loading the add articles view
        $this->view('articles/add', $data);
    }

    /**
     * update articles
     * @param integer $id
     */
    public function edit($id)
    {
        $id = (int) $id;
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // sanitize POST array
            $description = $this->article->cleanHTML($_POST['description']);
            $content = $this->article->cleanHTML($_POST['content']);
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $data = [
                'article_id' => $id,
                'page_title' => 'الاخبار والمقالات',
                'name' => trim($_POST['name']),
                'image' => '',
                'description' => $description,
                'meta_keywords' => trim($_POST['meta_keywords']),
                'meta_description' => trim($_POST['meta_description']),
                'status' => trim($_POST['status']),
                'arrangement' => trim($_POST['arrangement']),
                'news_ticker' => trim($_POST['news_ticker']),
                'content' => $content,
                'featured' => trim($_POST['featured']),
                'status_error' => '',
                'name_error' => '',
                'image_error' => '',
            ];

            // validate name
            if (empty($data['name'])) {
                $data['name_error'] = 'هذا الحقل مطلوب';
            }
            // validate image
            if (!empty($_FILES['image'])) {
                $image = uploadImage('image', ADMINROOT . '/../media/images/', 5000000, true);
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
            // make sure there is no errors
            if (empty($data['status_error']) && empty($data['image_error']) && empty($data['name_error'])) {
                //validated
                if ($this->article->updateArticle($data)) {
                    flash('articles_msg', 'تم التعديل بنجاح');
                    isset($_POST['save']) ? redirect('articles/edit/' . $id) : redirect('articles');
                } else {
                    flash('articles_msg', 'هناك خطأ ما حاول مرة اخري', 'alert alert-danger');
                }
            } else {
                //load the view with error
                $this->view('articles/edit', $data);
            }
        } else {
            // featch articles
            if (!$article = $this->article->getArticleById($id)) {
                flash('articles_msg', 'هناك خطأ ما هذه الصفحة غير موجوده او ربما اتبعت رابط خاطيء ', 'alert alert-danger');
                redirect('articles');
            }

            $data = [
                'page_title' => 'الاخبار والمقالات',
                'article_id' => $id,
                'name' => $article->name,
                'description' => $article->description,
                'image' => $article->image,
                'meta_keywords' => $article->meta_keywords,
                'meta_description' => $article->meta_description,
                'status' => $article->status,
                'arrangement' => $article->arrangement,
                'news_ticker' => $article->news_ticker,
                'content' => $article->content,
                'featured' => $article->featured,
                'status_error' => '',
                'name_error' => '',
                'image_error' => '',
            ];
            $this->view('articles/edit', $data);
        }
    }

    /**
     * showing articles details
     * @param integer $id
     */
    public function show($id)
    {
        if (!$article = $this->article->getArticleById($id)) {
            flash('articles_msg', 'هناك خطأ ما هذه الصفحة غير موجوده او ربما اتبعت رابط خاطيء ', 'alert alert-danger');
            redirect('articles');
        }
        $data = [
            'page_title' => 'الاخبار والمقالات',
            'article' => $article,
        ];
        $this->view('articles/show', $data);
    }

    /**
     * delete record by id
     * @param integer $id
     */
    public function delete($id)
    {
        if ($row_num = $this->article->deleteById([$id], 'article_id')) {
            flash('articles_msg', 'تم حذف ' . $row_num . ' بنجاح');
        } else {
            flash('articles_msg', 'لم يتم الحذف', 'alert alert-danger');
        }
        redirect('articles');
    }

    /**
     * publish record by id
     * @param integer $id
     */
    public function publish($id)
    {
        if ($row_num = $this->article->publishById([$id], 'article_id')) {
            flash('articles_msg', 'تم نشر ' . $row_num . ' بنجاح');
        } else {
            flash('articles_msg', 'هناك خطأ ما يرجي المحاولة لاحقا', 'alert alert-danger');
        }
        redirect('articles');
    }

    /**
     * publish record by id
     * @param integer $id
     */
    public function unpublish($id)
    {
        if ($row_num = $this->article->unpublishById([$id], 'article_id')) {
            flash('articles_msg', 'تم ايقاف نشر ' . $row_num . ' بنجاح');
        } else {
            flash('articles_msg', 'هناك خطأ ما يرجي المحاولة لاحقا', 'alert alert-danger');
        }
        redirect('articles');
    }

}
