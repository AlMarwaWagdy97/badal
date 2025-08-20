<?php
/*
 * Copyright (C) 2024 Easy CMS Framework Ahmed Elmahdy
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

class EvaluationsAnswers extends ControllerAdmin
{
    private $evaluationsAnswerModel;

    public function __construct()
    {
        $this->evaluationsAnswerModel = $this->model('EvaluationsAnswer');
    }

    /**
     * loading index view with latest evaluations
     */
    public function index($current = '', $perpage = 50)
    {
        // get evaluations
        $cond = 'WHERE status <> 2 ';
        $bind = [];
        //check user action if the form has submitted
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // sanitize POST array
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            //handling Delete
            if (isset($_POST['delete'])) {
                if (isset($_POST['record'])) {
                    if ($row_num = $this->evaluationsAnswerModel->deleteById($_POST['record'], 'evaluation_answers_id')) {
                        flash('evaluation_msg', 'تم حذف ' . $row_num . ' بنجاح');
                    } else {
                        flash('evaluation_msg', 'لم يتم الحذف', 'alert alert-danger');
                    }
                }
                redirect('EvaluationsAnswers');
            }
            //handling Publish
            if (isset($_POST['publish'])) {
                if (isset($_POST['record'])) {
                    if ($row_num = $this->evaluationsAnswerModel->publishById($_POST['record'], 'evaluation_answers_id')) {
                        flash('evaluation_msg', 'تم نشر ' . $row_num . ' بنجاح');
                    } else {
                        flash('evaluation_msg', 'هناك خطأ ما يرجي المحاولة لاحقا', 'alert alert-danger');
                    }
                }
                redirect('EvaluationsAnswers');
            }
            //handling Unpublish
            if (isset($_POST['unpublish'])) {
                if (isset($_POST['record'])) {
                    if ($row_num = $this->evaluationsAnswerModel->unpublishById($_POST['record'], 'evaluation_answers_id')) {
                        flash('evaluation_msg', 'تم ايقاف نشر ' . $row_num . ' بنجاح');
                    } else {
                        flash('evaluation_msg', 'هناك خطأ ما يرجي المحاولة لاحقا', 'alert alert-danger');
                    }
                }
                redirect('EvaluationsAnswers');
            }
        }
        //handling search
        $searches = $this->evaluationsAnswerModel->searchHandling(['name', 'mobile', 'email', 'points', 'points_text', 'status', 'type'], $current);
        if (!empty($_POST['search']['date_from'])) {
            $cond .= ' AND evaluation_answers.create_date >= ' . strtotime($_POST['search']['date_from']) . ' ';
        }
        if (!empty($_POST['search']['date_to'])) {
            $cond .= ' AND evaluation_answers.create_date <= ' . strtotime($_POST['search']['date_to']) . ' ';
        }

        $cond .= $searches['cond'];
        $bind = $searches['bind'];
        // get all records count after search and filtration
        $recordsCount = $this->evaluationsAnswerModel->allEvaluationAnswersCount($cond, $bind);
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
        //get all records for current substitute
        $evaluationAnswers = $this->evaluationsAnswerModel->getEvaluationAnswers($cond, $bind, $limit, $bindLimit);
        
        $data = [
            'current' => $current,
            'perpage' => $perpage,
            'header' => '',
            'title' => 'التقييم',
            'evaluationAnswers' => $evaluationAnswers,
            'recordsCount' => $recordsCount->count,
            'footer' => '',
        ];
        $this->view('evaluation/answers', $data);
    }

   

   

    /**
     * showing substitute details
     * @param integer $id
     */
    public function show($id)
    {
        if (!$evaluationAnswer = $this->evaluationsAnswerModel->getEvaluationAnswerById($id)) {
            flash('evaluation_msg', 'هناك خطأ ما هذه الصفحة غير موجوده او ربما اتبعت رابط خاطيء ', 'alert alert-danger');
            redirect('EvaluationsAnswers');
        }
      
        $data = [
            'page_title' => 'اجابات التقييم',
            'evaluationAnswer' => $evaluationAnswer,
            'answerQuestions' => json_decode($evaluationAnswer->answers),
        ];

        if($evaluationAnswer->type == "employee"){
            $data['questions'] = $this->questions();
            $data['answers'] = $this->answers();
        }
        else{
            $data['questions'] = $this->studentQuestions();
            $data['answers'] = $this->studentAnswers();
        }
        $this->view('evaluation/show', $data);
    }

    /**
     * delete record by id
     * @param integer $id
     */
    public function delete($id)
    {
        if ($row_num = $this->evaluationsAnswerModel->deleteById([$id], 'evaluation_answers_id')) {
            flash('evaluation_msg', 'تم حذف ' . $row_num . ' بنجاح');
        } else {
            flash('evaluation_msg', 'لم يتم الحذف', 'alert alert-danger');
        }
        redirect('EvaluationsAnswers');
    }

    /**
     * publish record by id
     * @param integer $id
     */
    public function publish($id)
    {
        if ($row_num = $this->evaluationsAnswerModel->publishById([$id], 'evaluation_answers_id')) {
            flash('evaluation_msg', 'تم تعليم كا مقروءة ' . $row_num . ' بنجاح');
        } else {
            flash('evaluation_msg', 'هناك خطأ ما يرجي المحاولة لاحقا', 'alert alert-danger');
        }
        redirect('EvaluationsAnswers');
    }

    /**
     * publish record by id
     * @param integer $id
     */
    public function unpublish($id)
    {
        if ($row_num = $this->evaluationsAnswerModel->unpublishById([$id], 'evaluation_answers_id')) {
            flash('evaluation_msg', 'تم تعليم كا غير مقروءة ' . $row_num . ' بنجاح');
        } else {
            flash('evaluation_msg', 'هناك خطأ ما يرجي المحاولة لاحقا', 'alert alert-danger');
        }
        redirect('EvaluationsAnswers');
    }


    public function questions(){
        $questions = [
            "1) هل تمتلك دخلاً شهريًا ثابتًا؟",
            "2) هل يغطي دخلك الشهري جميع احتياجاتك الأساسية (مثل الغذاء، السكن، المواصلات) ؟",
            "3) هل تمتلك سكنًا خاصًا بك أو مسكنًا ثابتًا لا يهددك خطر فقدانه؟",
            "4) هل تستطيع توفير مصروفات التعليم والعلاج لك ولأفراد أسرتك عند الحاجة؟",
            "5) هل عليك ديون أو التزامات مالية كبيرة تؤثر على استقرارك المالي؟",
            "6) هل لديك ادخار أو مبلغ احتياطي لحالات الطوارئ؟",
            "7) هل تضطر للبحث عن قروض أو دعم مالي من الآخرين لتغطية احتياجاتك الأساسية؟",
            "8) هل يتوفر لديك دخل إضافي أو مصدر مالي آخر يساعدك على تحسين مستوى معيشتك؟",
            "9) هل تتوفر لك وسائل التنقل اليومية، أو أنك تعتمد على وسائل النقل العامة وتجد صعوبة في تغطية تكاليفها؟",
            "10) هل تغطي دخلك الشهري مصاريفك الترفيهية والاحتياجات غير الأساسية؟",
        ];
        return $questions;
    }
    public function answers(){
        $answers = [
           [2 => "لا", 1 => "أحيانًا", 0 => "نعم"],
           [2 => "لا", 1 => "أحيانًا", 0 => "نعم"],
           [2 => "لا", 1 => "أحيانًا", 0 => "نعم"],
           [2 => "لا", 1 => "أحيانًا", 0 => "نعم"],
           [2 => "نعم، بشكل كبير", 1 => "نعم، ولكن بشكل محدود", 0 => "لا"],
           [2 => "لا", 1 => "قليلًا", 0 => "نعم"],
           [2 => "دائمًا ", 1 => "أحيانًا ", 0 =>  "نادرًا أو لا "],
           [2 => "لا", 1 => "أحيانًا  ", 0 => "نعم "],
           [2 => "أجد صعوبة كبيرة ", 1 => "أحيانًا أجد صعوبة  ", 0 => "لا "],
           [2 => "لا، إطلاقًا", 1 => "أحيانًا ", 0 => "نعم"],
        ];
        return $answers;
    }


    public function studentQuestions(){
        $questions = [
            "1) هل تحضر جميع محاضراتك وجلساتك الدراسية في الوقت المحدد وبدون تأخير؟",
            "2) هل تقوم بإنهاء واجباتك الدراسية بدقة وضمن الموعد المحدد؟",
            "3) هل تقوم بالتخطيط لأهدافك الدراسية وتحديد المهام الأسبوعية بانتظام؟",
            "4) هل تلتزم بجميع المواعيد النهائية للمشاريع والتقارير الدراسية وتخصص وقتًا كافيًا لإنجازها؟",
            "5) هل تستفيد من الموارد المتاحة، مثل المكتبة، والمساعدة الأكاديمية، والمصادر الإلكترونية لتحسين أدائك الدراسي؟",
            "6) هل تحافظ على الأدوات الدراسية (الكتب، الأجهزة الإلكترونية) وتتجنب فقدانها أو تلفها بسهولة؟",
            "7) هل تلتزم بوضع ميزانية شخصية لمصاريفك وتتابع تنفيذها بدقة؟",
            "8) هل تطلب المساعدة من زملائك أو أساتذتك عند الحاجة ولا تترك الأمور تتراكم دون حل؟",
            "9) هل تستخدم وقتك بفعالية وتلتزم بجدول زمني يومي أو أسبوعي ينظم دراستك وأنشطتك؟",
            "10) هل تسعى لتحسين كفاءتك الدراسية ومرونتك في مواجهة تحديات جديدة وتطور مهاراتك باستمرار؟",
        ];
        return $questions;
    }

    public function studentAnswers(){
        $answers = [
           [2 => "لا", 1 => "أحيانًا", 0 => "نعم"],
           [2 => "لا", 1 => "أحيانًا", 0 => "نعم"],
           [2 => "لا", 1 => "أحيانًا", 0 => "نعم"],
           [2 => "لا", 1 => "أحيانًا", 0 => "نعم"],
           [2 => "لا", 1 => "أحيانًا", 0 => "نعم"],
           [2 => "لا", 1 => "أحيانًا", 0 => "نعم"],
           [2 => "لا", 1 => "أحيانًا", 0 => "نعم"],
           [2 => "لا", 1 => "أحيانًا", 0 => "نعم"],
           [2 => "لا", 1 => "أحيانًا", 0 => "نعم"],
           [2 => "لا", 1 => "أحيانًا", 0 => "نعم"],
        ];
        return $answers;
    }
    
}
