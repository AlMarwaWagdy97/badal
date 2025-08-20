<?php

class Stores extends Controller
{

    private $storeModel;
    private $orderModel;
    public $settings;
    public $menu;


    public function __construct()
    {

        $this->storeModel = $this->model('Store');
        $this->orderModel = $this->model('Order');
        $this->menu = $this->storeModel->getMenu();
        $this->settings = $this->storeModel->getSettings();
    }
    /**
     * redirect with alias to load shorter store URL
     *
     * @return void
     */
    public function index()
    {
        $explo = str_replace('stores/', '', $_GET['url']); //getting alias from URL
        $explo = explode('/', $explo);
        if ($store = $this->storeModel->getStoreById($explo[0])) {
            setcookie('store', $store->store_id, time() + (86400 * 30), "/");
            $_SESSION['store'] = $store;
            if ($explo[1]) {
                redirect('projects/show/' . $explo[1], true);
            };
            redirect('', true);
        } else {
            unset($_SESSION['store']);
            setcookie('store', $store->store_id, time() - (86400 * 30), "/");
            flashRedirect('', 'msg', 'خطأ في التوجية ربما تكون اتبعت رابط خاطيء ');
        }
    }
    /**
     * login store admin by id
     *
     * @param  int $id
     *
     * @return view
     */
    public function login()
    {
        if (isset($_SESSION['storelogin'])) redirect('stores/orders', true); // check if user already logged in
        //check for post
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            //init data
            $data = [
                'username' => trim($_POST['username']),
                'password' => trim($_POST['password']),
                'username_error' => '',
                'password_error' => '',
                'pageTitle' => 'تسجيل دخول مدير الموقع  : ' . SITENAME,
                'settings' => $this->settings,
                'menu' => $this->menu,
            ];

            if (empty($data['username'])) { //validate user
                $data['username_error'] = '<div class="alert alert-danger">لا يمكن ترك حقل المستخدم خاليا</div>';
            } elseif (!$user = $this->storeModel->findUser($data['username'])) {
                $data['username_error'] = '<div class="alert alert-danger">هذ المستخدم ليس مسجل لدينا</div>';
            }

            if (empty($data['password'])) { //validate password
                $data['password_error'] = '<div class="alert alert-danger">لا يمكن ترك حقل كلمة المرور خاليا</div>';
            }
            if (empty($data['username_error']) && empty($data['password_error'])) {
                // validated

                if (password_verify($data['password'], $user->password)) { //check and login user
                    // dd($user);
                    //create session and setup the user premissions
                    $_SESSION['storelogin'] = $user;
                    // redirect user to orders
                    redirect('stores/orders', true);
                } else {
                    $data['password_error'] = '<div class="alert alert-danger">كلمة المرور غير صحيحة</div>';
                }
            }
        } else {
            $data = [
                'username' => '',
                'password' => '',
                'username_error' => '',
                'password_error' => '',
                'pageTitle' => 'تسجيل دخول مدير المتجر  : ' . SITENAME,
                'settings' => $this->settings,
                'menu' => $this->menu,
            ];
        }

        $this->view('stores/login', $data);
    }

    public function logout()
    {
        unset($_SESSION['storelogin']);
        flashRedirect('stores/login', 'msg', 'تم تسجيل الخروج بنجاح  ', 'alert alert-info');
    }
    /**
     * view store orders
     *
     * @return view
     */
    public function orders($current = '', $perpage = 50)
    {
        if (!isset($_SESSION['storelogin'])) redirect('stores/login', true); // check if user already logged in
        // get orders
        $cond = 'WHERE ord.status <> 2 AND donors.donor_id = ord.donor_id AND ord.payment_method_id = payment_methods.payment_id AND ord.store_id = ' . $_SESSION['storelogin']->store_id;
        $bind = [];
        //check user action if the form has submitted
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // sanitize POST array
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            //search handling
            if (isset($_POST['search']['submit'])) {
                unset($_SESSION['search']);
                // date search
                if (!empty($_POST['search']['date_from'])) {
                    $cond .= ' AND ord.create_date >= :date_from ';
                    $bind[':date_from'] = strtotime($_POST['search']['date_from']);
                }
                if (!empty($_POST['search']['date_to'])) {
                    $cond .= ' AND ord.create_date <= :date_to ';
                    $bind[':date_to'] = strtotime($_POST['search']['date_to']) + 86400;
                }
                // total search
                if (!empty($_POST['search']['total_from'])) {
                    $cond .= ' AND ord.total >= :total_from ';
                    $bind[':total_from'] = $_POST['search']['total_from'];
                }
                if (!empty($_POST['search']['total_to'])) {
                    $cond .= ' AND ord.total <= :total_to ';
                    $bind[':total_to'] = $_POST['search']['total_to'];
                }
                // order_identifier search
                if (!empty($_POST['search']['order_identifier'])) {
                    $cond .= ' AND ord.order_identifier LIKE  :order_identifier ';
                    $bind[':order_identifier'] = '%' . $_POST['search']['order_identifier'] . '%';
                }
                // mobile search
                if (!empty($_POST['search']['mobile'])) {
                    $cond .= ' AND donors.mobile LIKE  :mobile ';
                    $bind[':mobile'] = '%' . $_POST['search']['mobile'] . '%';
                }
                // full_name search
                if (!empty($_POST['search']['full_name'])) {
                    $cond .= ' AND donors.full_name LIKE  :full_name ';
                    $bind[':full_name'] = '%' . $_POST['search']['full_name'] . '%';
                }
                // status search
                if (!empty($_POST['search']['status'])) {
                    if ($_POST['search']['status'] == 5) $_POST['search']['status'] = 0;
                    $cond .= ' AND ord.status =  :status ';
                    $bind[':status'] =  $_POST['search']['status'];
                }
                // custom status search
                if (!empty($_POST['search']['status_id'])) {
                    $status_ids = array_filter($_POST['search']['status_id']);
                    $cond .= ' AND ord.status_id  in (' . strIncRepeat(':status_id', count($status_ids)) . ')';
                    foreach ($status_ids as $key => $status) {
                        if (!empty($status)) {
                            $bind[':status_id' . $key] = $status;
                        }
                    }
                }
                // payment_method search
                if (!empty($_POST['search']['payment_method'])) {
                    $payment_methods = array_filter($_POST['search']['payment_method']);
                    $cond .= ' AND ord.payment_method_id  in ('  . strIncRepeat(':payment_method', count($payment_methods)) . ')';
                    foreach ($payment_methods as $key => $payment_method) {
                        if (!empty($payment_method)) {
                            $bind[':payment_method' . $key] = $payment_method;
                        }
                    }
                }
                // projects search 
                if (!empty($_POST['search']['projects'])) {
                    $projects = array_filter($_POST['search']['projects']);
                    $cond .= ' AND ord.projects_id REGEXP '  . rtrim(strIncRepeat(':projects_id', count($projects), "|"), "|") . '';
                    foreach ($projects as $key => $project) {
                        if (!empty($project)) {
                            $bind[':projects_id' . $key] = "($project)";
                        }
                    }
                }
                // storing search data into session
                $_SESSION['search']['cond'] = $cond;
                $_SESSION['search']['bind'] = $bind;
                //store status and payment method for saving search attribute 
                if (isset($_POST['search']['payment_method'])) $_SESSION['search']['payment_method'] = $_POST['search']['payment_method'];
                if (isset($_POST['search']['status_id'])) $_SESSION['search']['status_id'] = $_POST['search']['status_id'];
                if (isset($_POST['search']['store_id'])) $_SESSION['search']['store_id'] = $_POST['search']['store_id'];
            } elseif (isset($_POST['search']['clearSearch'])) {
                unset($_SESSION['search']);
            }

            //handling Publish
            if (isset($_POST['publish'])) {
                if (isset($_POST['record'])) {
                    // if ($row_num = $this->orderModel->publishById($_POST['record'], 'order_id')) {
                    if ($row_num = $this->orderModel->publishByIdOrderBankTrans($_POST['record'], 'order_id')) {
                        //update donations publishing status after updating the order
                        $this->orderModel->publishDonations($_POST['record'], 'order_id');
                        flash('order_msg', 'تم تأكيد  ' . $row_num . ' بنجاح');
                    } else {
                        flash('order_msg', 'هناك خطأ ما يرجي المحاولة لاحقا', 'alert alert-danger');
                    }
                    //send confirmation to user 
                    $this->orderModel->sendConfirmation($_POST['record']);
                }
                redirect('stores/orders', true);
            }
            //handling Unpublish
            if (isset($_POST['unpublish'])) {
                if (isset($_POST['record'])) {
                    if ($row_num = $this->orderModel->unpublishById($_POST['record'], 'order_id')) {
                        //update donations publishing status after updating the order
                        $this->orderModel->unpublishDonations($_POST['record'], 'order_id');
                        flash('order_msg', 'تم الغاء تأكيد  ' . $row_num . ' بنجاح');
                    } else {
                        flash('order_msg', 'هناك خطأ ما يرجي المحاولة لاحقا', 'alert alert-danger');
                    }
                }
                redirect('stores/orders', true);
            }
            //handling waiting
            if (isset($_POST['waiting'])) {
                if (isset($_POST['record'])) {
                    if ($row_num = $this->orderModel->waitingById($_POST['record'], 'order_id')) {
                        flash('order_msg', 'تم وضع في الانتظار  ' . $row_num . ' بنجاح');
                    } else {
                        flash('order_msg', 'هناك خطأ ما يرجي المحاولة لاحقا', 'alert alert-danger');
                    }
                }
                redirect('stores/orders', true);
            }
            //handling canceled
            if (isset($_POST['canceled'])) {

                if (isset($_POST['record'])) {
                    if ($row_num = $this->orderModel->canceledById($_POST['record'], 'order_id')) {
                        flash('order_msg', 'تم الغاء   ' . $row_num . ' بنجاح');
                    } else {
                        flash('order_msg', 'هناك خطأ ما يرجي المحاولة لاحقا', 'alert alert-danger');
                    }
                }
                redirect('stores/orders', true);
            }
            //handling send
            if (isset($_POST['send'])) {
                if (isset($_POST['record'])) {
                    $data = [
                        'header' => '',
                        'title' => 'المراسلات',
                        'type' => $_POST['send'],
                        'members' => $this->orderModel->getUsersData($_POST['record']),
                        'footer' => '',
                    ];
                    return $this->view('messagings/index', $data);
                } else {
                    flash('order_msg', 'لم تقم بأختيار اي تبرع', 'alert alert-danger');
                }
            }
            //handling status
            if (isset($_POST['status_id'])) {
                if (isset($_POST['record'])) {
                    if ($row_num = $this->orderModel->setOrderStatuses($_POST['record'], $_POST['status_id'])) {
                        flash('order_msg', 'تم اضافة ' . $row_num . ' بنجاح');
                    } else {
                        flash('order_msg', 'هناك خطأ ما يرجي المحاولة لاحقا', 'alert alert-danger');
                    }
                }
                redirect('stores/orders', true);
            }
            //clear status
            if (isset($_POST['clear'])) {
                if (isset($_POST['record'])) {
                    if ($row_num = $this->orderModel->clearAllStatusesByOrdersId($_POST['record'])) {
                        flash('order_msg', 'تم الغاء   ' . $row_num . ' بنجاح');
                    } else {
                        flash('order_msg', 'هناك خطأ ما يرجي المحاولة لاحقا', 'alert alert-danger');
                    }
                }
                redirect('stores/orders', true);
            }
        } else {
            if (isset($_SESSION['search']['bind'])) {
                $cond = $_SESSION['search']['cond'];
                $bind = $_SESSION['search']['bind'];
            }
        }
        // get all records count after search and filtration
        $recordsCount = $this->orderModel->allOrdersCount(", donors, payment_methods " . $cond, $bind);
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
        ($store = $this->storeModel->getStoreById($_SESSION['storelogin']->alias)) ?: flashRedirect('index', 'msg', ' هذا المتجر غير موجود او ربما تم حذفه ');
        $_SESSION['store']->alias = $_SESSION['storelogin']->alias;
        //get all records for current order
        $orders = $this->orderModel->getOrders($cond, $bind, $limit, $bindLimit);
        $data = [
            'pageTitle' => 'عرض سجل التبرعات  : ' . SITENAME,
            'store' => $store,
            'settings' => $this->settings,
            'menu' => $this->menu,
            'current' => $current,
            'perpage' => $perpage,
            'header' => '',
            'statuses' => $this->orderModel->statusesList(' WHERE status = 1'),
            'paymentMethodsList' => $this->orderModel->paymentMethodsList(' WHERE status <> 2 '),
            'projects' => $this->orderModel->projectsList(' WHERE status = 1'),
            'orders' => $orders,
            'recordsCount' => $recordsCount->count,
            'footer' => '',
        ];
        $this->view('stores/orders', $data);
    }

    /**
     * change store password
     *
     * @return void
     */
    public function password()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // sanitize POST array
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            echo $this->storeModel->updatePassword($_POST['store_id'], $_POST['password']);
            redirect('stores/logout', true);
        } else {
            flash('order_msg', 'هناك خطأ ما لقد اتبعت رابط خاطيء', 'alert alert-danger');
            redirect('stores/orders', true);
        }
    }


    /**
     * show projects hits
     *
     * @return void
     */
    public function projects()
    {
        $store = $this->storeModel->getStoreById($_SESSION['storelogin']->alias);
        $projectsHits = $this->storeModel->getProjectsHits($store->store_id);

        $data = [
            'pageTitle' => 'عرض عدد الزوار  : ' . SITENAME,
            'store' => $store,
            'menu' => $this->menu,
            'settings' => $this->settings,
            'projectsHits' => $projectsHits,
            'header' => '',
            'footer' => '',
        ];

        $this->view('stores/projectsHits', $data);
    }

}
