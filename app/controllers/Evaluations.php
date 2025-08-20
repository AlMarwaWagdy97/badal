<?php

class Evaluations extends Controller
{
    private $evaluationAnswersModel;
    public $settings;
    public $menu;

    public function __construct()
    {
        $this->evaluationAnswersModel = $this->model('Evaluation');
        $this->menu = $this->evaluationAnswersModel->getMenu();
        $this->settings = $this->evaluationAnswersModel->getSettings();
    }


    public function index()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
           
            $data = [
                'page_title' => 'اختبار الاستقرار المالي والنجاح',
                'settings' => $this->settings,
                'menu' => $this->menu,
                'questions' => $this->questions(),
                'answers' => $this->answers(),
                'student_questions' => $this->studentQuestions(),
                'student_answers' => $this->studentAnswers(),
                'type' => trim($_POST['client_type']),
                'name' => trim($_POST['name']),
                'mobile' => trim($_POST['mobile']),
                'email' => trim($_POST['email']),
                'type_error' => '',
                'name_error' => '',
                'mobile_error' => '',
                'email_error' => '',
            ];


            !(empty($data['type'])) ?: $data['type_error'] = 'هذا الحقل مطلوب';
            !(empty($data['name'])) ?: $data['name_error'] = 'هذا الحقل مطلوب';
            !(empty($data['mobile'])) ?: $data['mobile_error'] = 'هذا الحقل مطلوب';
            !(empty($data['client_answer'])) ?: $data['answer_error'] = 'هذا الحقل مطلوب';

            if (empty($data['type_error']) && empty($data['name_error']) && empty($data['mobile_error']) && empty($data['type_error']) ) {  //validated

                if($data['type'] == "employee"){
                    $data['points'] = array_sum($_POST['client_answer']);
                    $data['client_answer'] = json_encode($_POST['client_answer']);
                    $data['points_text'] = $this->pointsText(array_sum($_POST['client_answer']));
                }else{
                    $data['points'] = array_sum($_POST['student_answer']);
                    $data['client_answer'] = json_encode($_POST['student_answer']);
                    $data['points_text'] = $this->studentPointsText(array_sum($_POST['student_answer']));
                }
              
                if ($this->evaluationAnswersModel->addAnswer($data)) {
                       $data['page_title'] = "نتيجة الاختبار";
                        return $this->view('evaluation/result', $data);
                    // flashRedirect('Evaluations/result', 'msg', 'تم ارسال التقييم بنجاح (' . $data['points_text'] .' ).  ', 'alert alert-success');
                } else {
                    $data['showEvaluations'] = 1;
                    flash('msg', 'هناك خطأ ما حاول مرة اخري', 'alert alert-danger', $data);
                }
            } else {
                //load the view with error
                $this->view('evaluation/form', $data);
            }
             
        } else {

            $data = [
                'page_title' => 'اختبار الاستقرار المالي والنجاح',
                'settings' => $this->settings,
                'menu' => $this->menu,
                'questions' => $this->questions(),
                'answers' => $this->answers(),
                'student_questions' => $this->studentQuestions(),
                'student_answers' => $this->studentAnswers(),
                'type' => '',
                'name' => '',
                'mobile' => '',
                'email' => '',
                'answer' => '',
                'type_error' => '',
                'name_error' => '',
                'mobile_error' => '',
                'email_error' => '',
            ];
        }
        $this->view('evaluation/form', $data);
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

    public function pointsText($val){
        if( in_array($val, range(0,2)) ) return "في حالة مالية ممتازة";
        if( in_array($val, range(3,4)) ) return " في حالة مستقرة";
        if( in_array($val, range(5,7)) ) return "يحتاج إلى مساندة";
        if( in_array($val, range(8,30)) ) return "غير مستقر ويحتاج إلى العديد من الإجراءات لتصحيح المسار";
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

    public function studentPointsText($val){
        if( in_array($val, range(0,2)) ) return "من المتوقع أن تكون لديك قدرات جيدة تساعدك على تحقيق استقرار مالي مستقبلي";
        if( in_array($val, range(3,4)) ) return "لديك أساس جيد، ومع مزيد من تطوير المهارات التنظيمية وإدارة الموارد، ستكون قادرًا على تحقيق الاستقرار المالي";
        if( in_array($val, range(5,7)) ) return "ينصح بتحسين الالتزام والتنظيم لاستقرار مالي مستقبلي أفضل";
        if( in_array($val, range(8,30)) ) return "بحاجة إلى متابعة مكثفة وتطوير المهارات الأساسية لتجنب الوقوع في تحديات مالية مستقبليًا";
    }


  
}
