<?php

class Cart extends Model
{
    public $items = [];
    public $totalQty;
    public $totalPrice;

    public function __Construct($cart = null)
    {
        parent::__construct('cart');

        if ($cart) {

            $this->items = $cart->items;
            $this->totalQty = $cart->totalQty;
            $this->totalPrice = $cart->totalPrice;
        } else {

            $this->items = [];
            $this->totalQty = 0;
            $this->totalPrice = 0;
        }
    }

    public function addx($project)
    {
        $item = [
            'name' => $project->name,
            'project_id' => $project->project_id,
            'quantity' => 1,
            'amount' => [$_POST['amount']],
            'donation_type' => [$_POST['donation_type']],
        ];
        if (isset($_SESSION['cart'])) { // existing cart
            if (array_key_exists($project->project_id, $_SESSION['cart'])) { // existing project
                if (!in_array($_POST['donation_type'], $_SESSION['cart'][$project->project_id]['donation_type'])) { //if the project added with different type
                    $oldType = $_SESSION['cart'][$project->project_id]['donation_type'];
                    $oldType[] = $_POST['donation_type'];
                    $item['donation_type'] = $oldType;
                    $oldAmount = $_SESSION['cart'][$project->project_id]['amount'];
                    $oldAmount[] = $_POST['amount'];
                    $item['amount'] = $oldAmount;
                }
                //update item quantity
                $item['quantity'] = $_SESSION['cart'][$project->project_id]['quantity'] + 1;
            }
            $totalQty = $_SESSION['cart']['totalQty'] + 1;
        } else {
            $totalQty = 1;
        }
        $_SESSION['cart']['totalQty'] = $totalQty;
        $_SESSION['cart'][$project->project_id] = $item;
    }
    public function add($project, $quantity =1)
    {
        $item = [
            'name' => $project->name,
            'project_id' => $project->project_id,
            'deceased_id' => $project->deceased_id,
            'quantity' => $quantity,
            'amount' => (int)$_POST['amount'],
            'donation_type' => $_POST['donation_type'],
            'image' => MEDIAURL . '/' . $project->secondary_image,
        ];
        if (isset($_SESSION['cart'])) { // existing cart
            $x = false;
            foreach ($_SESSION['cart']['items'] as $key => $value) {
                if ($value['project_id'] == $project->project_id && $value['donation_type'] == $_POST['donation_type'] && 'مفتوح' != $_POST['donation_type']) {
                    $x = true;
                }
            }
            if ($x) {
                $_SESSION['cart']['items'][$key]['quantity'] = $_SESSION['cart']['items'][$key]['quantity'] + $quantity;
            } else {
                $_SESSION['cart']['items'][] = $item;
            }
            $totalQty = $_SESSION['cart']['totalQty'] + $quantity;
            $_SESSION['cart']['totalQty'] = $totalQty;
        } else {
            $totalQty = $quantity;
            $_SESSION['cart']['totalQty'] = $totalQty;
            $_SESSION['cart']['items'][] = $item;
        }
    }
    /**
     * remove item from the cart
     * @param $id 
     */
    public function remove($id)
    {
        if (array_key_exists($id, $_SESSION['cart']['items'])) {
            $_SESSION['cart']['totalQty'] = $_SESSION['cart']['totalQty'] - $_SESSION['cart']['items'][$id]['quantity'];
            unset($_SESSION['cart']['items'][$id]);
        }
        if ($_SESSION['cart']['totalQty'] == 0) unset($_SESSION['cart']);
    }

    public function updateQuantity($data)
    {
        if (array_key_exists($data['index'], $_SESSION['cart']['items'])) {
            //update total quantity
            $_SESSION['cart']['totalQty'] = $_SESSION['cart']['totalQty'] - $_SESSION['cart']['items'][$data['index']]['quantity'];
            $_SESSION['cart']['totalQty'] += $data['quantity'];
            //update item quantity
            $_SESSION['cart']['items'][$data['index']]['quantity'] = $data['quantity'];
        }
        if ($_SESSION['cart']['totalQty'] == 0) unset($_SESSION['cart']);
    }
}
