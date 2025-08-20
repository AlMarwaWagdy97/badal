<?php
class Carts extends Controller
{
    private $cartModel;
    public $settings;
    public $menu;

    public function __construct()
    {
        $this->cartModel = $this->model('Cart');
        $this->menu = $this->cartModel->getMenu();
        $this->settings = $this->cartModel->getSettings();
    }

    public function index()
    {
        $data = [
            'settings' => $this->settings,
            'menu' => $this->menu,
            'payment_methods' => $this->cartModel->getFromTable('payment_methods', '*', ['status' => 1, 'cart_show' => 1]),
            'pageTitle' => 'الرئيسية: ' . SITENAME,
        ];  
        // $this->view('cart/index', $data);
        $this->view('checkout/carts', $data);

    }

    /**
     * add project to the cart
     *
     * @param  mixed $project
     * @return void
     */
    public function add()
    {
        $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        if (!$_POST) {
            flashRedirect('', 'msg', 'هناك خطأ ما : ربما اتبعت رابط خاطئ', 'alert alert-danger');
        }
        // load project data
        $project = $this->cartModel->getSingle('name, project_id', 'deceased_id', ['project_id' => $_POST['project_id']], 'projects');
        $this->cartModel->add($project, $_POST['quantity'], $_SESSION['store']->store_id);
        if (isset($_POST['projectCategories'])) {
            flashRedirect('projectCategories/show/' . $_POST['projectCategories'], 'msg', ' تم اضافة المشروع بنجاح <a href="' . URLROOT . '/carts"> عرص السلة </a> ');
        } elseif (isset($_POST['tags'])) {
            flashRedirect('tags/show/' . $_POST['tags'], 'msg', ' تم اضافة المشروع بنجاح <a href="' . URLROOT . '/carts"> عرص السلة </a> ');
        }
        flashRedirect('', 'msg', ' تم اضافة المشروع بنجاح <a href="' . URLROOT . '/carts"> عرص السلة </a> ');
    }
    /**
     * add project to the cart
     *
     * @param  mixed $project
     * @return void
     */
    public function ajaxAdd()
    {
        $data = [
            'msg' => '<div class="text-center"> هناك خطأ ما برجاء حاول مرة اخري </div>',
            'status' => 'error',
        ];

        $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        if (!$_POST) {
            flashRedirect('', 'msg', 'هناك خطأ ما : ربما اتبعت رابط خاطئ', 'alert alert-danger');
        }
        if (empty($_POST['quantity']) || empty($_POST['amount']) || empty($_POST['donation_type']) || empty($_POST['project_id'])) {
            $data = [
                'msg' => '<div class="text-center"> هناك خطأ ما برجاء حاول مرة اخري </div>',
                'status' => 'error',
            ];
        } else {
            // load project data
            $project = $this->cartModel->getSingle('name, project_id, deceased_id,  finished, secondary_image', ['project_id' => $_POST['project_id']], 'projects');
            if ($project->finished == 1) {
                $data = [
                    'msg' => '<div class="text-center text-danger">عذرا :  تم غلق التبرع لهذا المشروع </div>',
                    'status' => 'error',
                ];
            } else {
                if ($_POST['donation_type'] == 'مفتوح') {
                    $_POST['quantity'] = 1;
                }
                $this->cartModel->add($project, $_POST['quantity'], $_SESSION['store']->store_id);
                $data = [
                    'msg' => '<div class="text-center py-3">  تم اضافة المشروع الي سلة التبرع  بنجاح   </div> ',
                    'status' => 'success',
                    'total' => $_SESSION['cart']['totalQty']
                ];
            }
        }

        echo json_encode($data);
    }

    /**
     * remove item from cart
     *
     * @param [int] $id
     * @return void
     */
    public function remove($id)
    {
        $this->cartModel->remove($id);
        flashRedirect('carts', 'msg', 'تم الحذف بنجاح ');
    }

    /**
     * clear cart
     *
     * @return void
     */
    public function removeAll()
    {
        unset($_SESSION['cart']);
        flashRedirect('', 'msg', 'تم افراغ محتويات السلة بنجاح ');
    }

    /**
     * update cart quantity
     *
     * @return void
     */
    public function setQuantity()
    {
        $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        if (!$_POST) {
            flashRedirect('', 'msg', 'هناك خطأ ما : ربما اتبعت رابط خاطئ', 'alert alert-danger');
        }
        if ($_POST['quantity'] < 1) $this->cartModel->remove($_POST['index']);

        $data = [
            'quantity' => intval(trim($_POST['quantity'])),
            'index' => trim($_POST['index']),
        ];
        $this->cartModel->updateQuantity($data);
        flashRedirect('carts', 'msg', 'تم تحديث الكمية بنجاح ');
    }
}
