<?php
require APPROOT . '/app/views/inc/header.php';
?>
<div class="text-center py-5 mb-0 undermenu  bg-success text-light h3 bg-battern">
    <h3 class="py-4 mt-4"> سلة التبرع </h3>
</div>
<div class="container cart-container">
    <?php flash('msg'); ?>
    <div class="cart">
        <div class="row">
            <?php
            $total = 0;
            $itemLayers = [];
            if (isset($_SESSION['cart'])) {
            ?>
                <div class="col-12 col-lg-8 text-right">
                    <?php foreach ($_SESSION['cart']['items'] as $key => $value) { ?>
                        <div class="card rounded-3 mb-4">
                            <div class="card-body <?= count($_SESSION['cart']['items']) ==  1 ? 'p-5' : '' ?>">
                                <div class="row d-flex justify-content-between align-items-center">
                                    <div class="col-sm-3 col-6 m-auto img-section">
                                        <a href="<?= URLROOT . "/projects/show/ " . $value['project_id'] ?>">
                                            <img src="<?php echo (empty($value['image'])) ? MEDIAURL . '/default.jpg' : $value['image']; ?>" class="img-fluid rounded-3" alt="<?php echo $value['name']; ?>"">
                                        </a>
                                    </div>
                                    <div class=" col-sm-3 col-6 m-auto">
                                            <a href="<?= URLROOT . "/projects/show/" . $value['project_id'] ?>">
                                                <b><?= $value['name'] ?></b>
                                            </a>
                                            <p class="mb-0 mt-1"><?= $value['donation_type'] ?> </p>
                                            <p class="green-text mb-0"><?= $value['amount'] ?>
                                            <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                                                viewBox="0 0 1024 900" style="enable-background:new 0 0 1024 900;width:20px;" xml:space="preserve">
                                            <style type="text/css">
                                                .st0{fill:#6f822b;}
                                            </style>
                                            <path class="st0" d="M596.8,735.6L596.8,735.6c-12.6,28-20.6,57.9-23.7,88.4L835,768.3c12.6-28,20.6-57.9,23.7-88.4L596.8,735.6z"/>
                                            <path class="st0" d="M835,601.6c12.6-28,20.6-57.9,23.7-88.4l-204,43.4v-83.4L835,434.8c12.6-28,20.6-57.9,23.7-88.4l-204,43.3V89.9
                                                c-31.2,17.5-58.9,40.8-81.6,68.5v248.8l-81.6,17.3V49.1c-31.2,17.5-58.9,40.8-81.6,68.5v324.2l-182.5,38.8
                                                c-12.6,28-20.6,57.9-23.7,88.5L410,525.2v105l-221,47c-12.6,28-20.6,57.9-23.7,88.4l231.3-49.2c18.5-3.9,34.9-14.8,45.5-30.4
                                                l42.4-62.9l0,0c4.6-6.7,7-14.7,7-22.8v-92.5l81.6-17.3v166.8L835,601.6L835,601.6z"/>
                                            </svg>
                                            </p>
                                    </div>
                                    <div class="col-sm-3 col-6 d-flex sec-dev">
                                        <form class="form-row" action="<?= URLROOT . '/carts/setQuantity' ?>" method="post">
                                            <input min="0" name="quantity" value="<?= $value['quantity'] ?>" class="form-control form-control-sm text-right col-sm-6" type="number" />
                                            <button class="btn btn-sm btn-dark mr-2 mt-1" name="index" type="submit" value="<?= $key ?>">تعديل</button>
                                        </form>
                                    </div>
                                    <div class="col-sm-2 col-4 d-flex m-auto offset-lg-1 text-center sec-dev">
                                        <h5 class="mb-0 ml-2"><?= $value['amount'] * $value['quantity']  ?>
                                            <img src="<?php echo MEDIAURL . '/rayal.png'; ?>" width="20px">
                                        </h5>
                                    </div>
                                    <div class="col-sm-1 col-2 d-flex m-auto offset-lg-1 text-end sec-dev">
                                        <a href="<?= URLROOT . '/carts/remove/' . $key ?>" class="btn btn-danger btn-sm p-1 text-end"><i class="icofont-close"></i></a>
                                    </div>

                                </div>
                            </div>
                        </div>


                    <?php
                        $total += ($value['amount'] * $value['quantity']);

                        $itemLayers[] = [
                            'item_id' =>  $value['project_id'],
                            'item_name' =>  $value['name'],
                            'currency' =>  'SAR',
                            'price' =>  $value['amount'],
                            'quantity' =>  $value['quantity'],
                        ];
                    }
                    ?>
                </div>
                <div class="col-md-4">
                    <div class="card rounded-3 mb-4">
                        <div class="card-body p-4">
                            <div class="row">
                                <div class="col-md-6 col-6 text-right h5">
                                    <p class="h5">المجموع</p>
                                </div>
                                <div class="col-md-6 col-6">
                                    <h4 class="text-primary"> <?= $total ?>
                                    <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                                                viewBox="0 0 1024 900" style="enable-background:new 0 0 1024 900;width:35px;" xml:space="preserve">
                                            <style type="text/css">
                                                .st0{fill:#354e9a;}
                                            </style>
                                            <path class="st0" d="M596.8,735.6L596.8,735.6c-12.6,28-20.6,57.9-23.7,88.4L835,768.3c12.6-28,20.6-57.9,23.7-88.4L596.8,735.6z"/>
                                            <path class="st0" d="M835,601.6c12.6-28,20.6-57.9,23.7-88.4l-204,43.4v-83.4L835,434.8c12.6-28,20.6-57.9,23.7-88.4l-204,43.3V89.9
                                                c-31.2,17.5-58.9,40.8-81.6,68.5v248.8l-81.6,17.3V49.1c-31.2,17.5-58.9,40.8-81.6,68.5v324.2l-182.5,38.8
                                                c-12.6,28-20.6,57.9-23.7,88.5L410,525.2v105l-221,47c-12.6,28-20.6,57.9-23.7,88.4l231.3-49.2c18.5-3.9,34.9-14.8,45.5-30.4
                                                l42.4-62.9l0,0c4.6-6.7,7-14.7,7-22.8v-92.5l81.6-17.3v166.8L835,601.6L835,601.6z"/>
                                            </svg>
                                    </h4>
                                </div>
                            </div>
                            <hr>
                            <div class="text-center mt-3">
                                <a class="btn btn-success px-5 btn-lg" href="<?= URLROOT; ?>/checkout"> المتابعه للدفع</a>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="row"></div>

            <?php } else {  ?>
                <div class="col-md-12 ">
                    <div class="alert alert-primary text-center" role="alert"> لا يوجد منتجات في السلة </div>
                </div>
            <?php } ?>
        </div>

    </div>





    <div class="text-center mt-5 mb-2">
        <a class="btn btn-success px-5 btn-lg" href="<?php echo URLROOT; ?>">العودة الي الرئيسية</a>
    </div>
</div>

<?php
$dataLayer = [
    'event' => 'view_cart',
    'ecommerce' => [
        'currency' => 'SAR',
        'value' => $total,
        'items' => $itemLayers,
    ],
];
?>

<script>
    if (window.dataLayer) {
        dataLayer.push(<?php echo json_encode($dataLayer); ?>);
    }
    console.log(dataLayer);
</script>


<?php
$data['settings']['site']->footer_code .= '<script src="https://www.google.com/recaptcha/api.js" async defer></script>' . "\n\t";
require APPROOT . '/app/views/inc/footer.php'; ?>