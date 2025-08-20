<?php

class Invoices extends Controller
{

    private $orderModel;

    public function __construct()
    {
        $this->orderModel = $this->model('Order');
    }



    /**
     * show invoices
     */
    public function show($id = null)
    {

        $id = orderIdentifier($id); //86202
        $order = $this->orderModel->getOrderById($id);
        $donation = $this->orderModel->getDonationsByOrderId($id);

        if ($order) {
            $data = [
                'order' => $order,
                'donations' => $donation,
            ];

            $this->view('pages/invoices', $data);
        } else {
            http_response_code(404);
            header('Content-type: text/html');
        }
    }
}
