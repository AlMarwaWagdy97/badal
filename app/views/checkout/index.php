<?php
require APPROOT . '/app/views/inc/header.php';
?>
<div class="text-center py-5 mb-0 undermenu  bg-success text-light h3 bg-battern">
    <h3 class="py-4 mt-4"> الدفع </h3>
</div>
<div class="container checkout-container">
    <div class="cart">
        <div class="mt-3">
            <?php flash('msg'); ?>
        </div>
        <div class="row">
            <?php
            $itemLayers = [];
            $total = 0;
            if (isset($_SESSION['cart'])) {
            ?>

                <div class="col-12 col-lg-6 text-right">
                    <div class="card">
                        <div class="mt-3">
                            <div class="card-body text-center <?= count($_SESSION['cart']['items']) ==  1 ? '' : '' ?>">
                                <div class="row d-flex justify-content-between align-items-center">
                                    <div class=" col-md-4 col-lg-4 col-xl-4 col-4 m-auto">
                                        <a>
                                            <b>الاسم</b>
                                        </a>
                                    </div>
                                    <div class="col-md-3 col-lg-2 col-xl-2 col-3 m-auto offset-lg-1 text-center">
                                        <p class="green-text mb-0">السعر </p>
                                    </div>
                                    <div class="col-md-2 col-lg-2 col-xl-2 col-2 m-auto offset-lg-1 text-center">
                                        <p class="green-text mb-0" style="white-space: nowrap;"> الكمية </p>
                                    </div>
                                    <div class="col-md-3 col-lg-3 col-xl-2 col-3 m-auto text-end">
                                        <p class="mb-0">الاجمالي</p>
                                    </div>
                                </div>
                                <hr>
                            </div>
                            <?php foreach ($_SESSION['cart']['items'] as $key => $value) { ?>
                                <div class="card-body text-center <?= count($_SESSION['cart']['items']) ==  1 ? '' : '' ?>">
                                    <div class="row d-flex justify-content-between align-items-center">
                                        <div class=" col-md-4 col-lg-4 col-xl-4 col-4 m-auto">
                                            <a href="<?= URLROOT . "/projects/show/ " . $value['project_id'] ?>">
                                                <b><?= $value['name'] ?></b>
                                            </a>
                                        </div>
                                        <div class="col-md-3 col-lg-2 col-xl-2 col-3 m-auto offset-lg-1 text-center">
                                            <p class="green-text mb-0"><?= $value['amount'] ?> 
                                            <img src="<?php echo MEDIAURL . '/rayal.png' ; ?>" width="20px">
                                            </p>
                                        </div>
                                        <div class="col-md-2 col-lg-2 col-xl-2 col-2 m-auto offset-lg-1 text-center">
                                            <p class="green-text mb-0"><?= $value['quantity'] ?> </p>
                                        </div>
                                        <div class="col-md-3 col-lg-3 col-xl-2 col-3 m-auto text-end">
                                            <p class="mb-0"><span style="white-space: nowrap;"><?= $value['amount'] * $value['quantity']  ?> </span> <img src="<?php echo MEDIAURL . '/rayal.png' ; ?>" width="20px"></p>
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
                            } ?>
                            <hr>
                            <div class="card-body <?= count($_SESSION['cart']['items']) ==  1 ? '' : '' ?>">
                                <div class="row d-flex justify-content-between align-items-center">
                                    <div class=" col-md-4 col-lg-4 col-xl-4 col-6">
                                        <p class="h5">الاجمالي : </p>
                                    </div>
                                    <div class="col-md-4 col-lg-4 col-xl-4 col-6 text-end">
                                        <h4 class="text-primary"> <?= $total ?> 
                                            <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                                                    viewBox="0 0 1024 900" style="enable-background:new 0 0 1024 900;width:38px;" xml:space="preserve">
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
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card rounded-3 mb-4">
                        <form method="post" action="<?= URLROOT . '/checkout'; ?>" enctype="multipart/form-data" accept-charset="utf-8">
                            <div class="card-body p-4 text-right mt-2">
                                <div class="user-data" style="display: <?= $data['donor'] != '' ? 'none' : 'block' ?>;">
                                    <!--  Name -------------------------------------------------------------------------------------------------------- -->
                                    <div class="form-group row">
                                        <label for="full-name" class="col-lg-3 col-form-label">الاسم بالكامل : </label>
                                        <div class="col-lg-8">
                                            <input type="hidden" name="mobile_confirmed" value="no" id="mobile-confirmed">
                                            <input type="hidden" name="total" value="<?php echo $total; ?>" id="total">
                                            <input type="text" class="form-control  <?php if (!empty($data['full_name_error'])) echo 'is-invalid'; ?>" name="full_name" id="full-name" value="<?= @$data['donor']->full_name  ?? @$data['full_name'] ?>" data-inputmask-regex="^[\u0621-\u064Aa-zA-Z\-_\s]+$" placeholder="الاسم بالكامل" required>
                                            <span class="invalid-feedback"><?= $data['full_name_error']; ?></span>
                                        </div>
                                    </div>
                                    <!--  Mobile ------------------------------------------------------------------------------------------------------ -->
                                    <div class="form-group row">
                                        <label for="mobile" class="col-lg-3 col-form-label">رقم الجوال :</label>
                                        <div class="input-group col-lg-8 mobile-validate">
                                            <input dir="ltr" class="form-control  <?php if (!empty($data['mobile_error'])) echo 'is-invalid'; ?>" name="mobile" type="text" value="<?= @$data['donor']->mobile ?? @$data['mobile'] ?>" placeholder="0500000000" id="mobile" data-inputmask="'mask': '9999999999'" required>
                                            <span class="invalid-feedback"><?= $data['mobile_error']; ?></span>
                                            <?php if ($data['settings']['site']->mobile_validation) { ?>
                                                <div class="">
                                                    <a class="input-group-text activate" data-toggle="modal" data-target="#addcode-x">ارسال </a>
                                                </div>
                                            <?php } ?>
                                        </div>
                                    </div>
                                    <!--  Identity -------------------------------------------------------------------------------------------------------- -->
                                    <!-- <div class="form-group row">
                                        <label for="full-name" class="col-lg-3 col-form-label">رقم الهوية: </label>
                                        <div class="col-lg-8">
                                            <input type="text" class="form-control  <?php if (!empty($data['identity_error'])) echo 'is-invalid'; ?>" name="identity" maxlength="10" value="<?= @$data['donor']->identity  ?? @$data['identity'] ?>" pattern="[0-9]{10}" placeholder="رقم الهوية">
                                            <span class="invalid-feedback"><?= $data['identity_error']; ?></span>
                                        </div>
                                    </div> -->
                                    <!--  Email -------------------------------------------------------------------------------------------------------- -->
                                    <div class="form-group row">
                                        <label for="full-name" class="col-lg-3 col-form-label">البريد الالكتروني :</label>
                                        <div class="col-lg-8">
                                            <input type="email" class="form-control  <?php if (!empty($data['email_error'])) echo 'is-invalid'; ?>" name="email" placeholder="هام لاستقبال رسائل التأكيد" value="<?= @$data['donor']->email ?? @$data['email'] ?>">
                                            <span class="invalid-feedback"><?= $data['email_error']; ?></span>
                                        </div>
                                    </div>
                                </div>

                                <!--  payment method ----------------------------------------------------------------------------------------------- -->
                                <div class="form-group row" dir="rtl">
                                    <label class="col-lg-3 col-form-label"> وسيلة الدفع :</label>
                                    <div class="btn-group-toggle text-right payments_methods" data-toggle="buttons">
                                        <?php
                                        foreach ($data['payment_methods'] as $payment_method) {
                                            if ($payment_method->payment_id == 4 && $total < 1000) {
                                                continue;
                                            }
                                            if ($payment_method->payment_id == 10) {
                                                $user_agent = $_SERVER['HTTP_USER_AGENT'];
                                                if (stripos($user_agent, 'Safari') !== false &&  !(stripos($user_agent, 'Chrome') !== false)) {
                                                    echo '<label class="btn btn-dark mt-2 mr-1 col col-md-5 col-12">
                                                        <input type="radio" value ="' . $payment_method->payment_id . '" name="payment_method" requiredclass="payment_method">
                                                         الدفع بواسطة <i class="icofont-apple-pay icofont-2x"></i>
                                                    </label>';
                                                }
                                            } else {
                                                if ($data['payment_method'] == $payment_method->payment_id) {
                                                    echo '<label class="btn btn-primary btn-sm mt-2 px-4 mx-1">
                                                        <input  required type="radio" checked  value ="' . $payment_method->payment_id . '" name="payment_method" required class="payment_method"> ' . $payment_method->title . '
                                                        </label>';
                                                } else {
                                                    echo '<label class="btn btn-primary btn-sm mt-2 px-4 mx-1">
                                                        <input  required type="radio"  value ="' . $payment_method->payment_id . '" name="payment_method" required class="payment_method"> ' . $payment_method->title . '
                                                        </label>';
                                                }
                                            }
                                        }
                                        ?>
                                        <span class="invalid-feedback"><?= $data['payment_method_error']; ?></span>
                                    </div>
                                </div>
                                <hr>
                                <!-- Payment method by Card ---------------------------------------------------------------------------------------- -->
                                <div class="payment-card payment-white p-3" id="paymentByCard" <?= $data['payment_method'] == 1 || $data['payment_method'] == null ? 'style="display: none;"' : '' ?>>
                                    <?php
                                    if ($data['cards']) {
                                        foreach ($data['cards'] as $card) {
                                            echo '  
                                                <div class="row selected_saved_card" >
                                                    <div class="col-md-3" >
                                                        <div class="selected_cvv" style="display: none" >
                                                            <input type="text" name="selected_cvv[' . $card->card_id . ']" placeholder="CVV" maxlength="3" inputmode="numeric" pattern="[0-9]*"
                                                                class="form-control only-number card-exp valid"  >
                                                        </div>
                                                    </div>
                                                    <div class="col-md-8 text-left" dir="ltr" >
                                                        <label class="checkcontainer"> 
                                                            <input type="radio" name="selected_card" value="' . $card->card_id . '" class="select_card">
                                                            <img src="' . URLROOT . '/public/templates/namaa/images/visa.jpg" alt="visa" width="30" class="rounded-0 m-1">
                                                                <span style="color:black">
                                                                ' . str_repeat('*', 4) . substr(openssl_decrypt_card($card->number), -4) . '
                                                                </span>
                                                                (' . base64_decode($card->name) . ') ' . '
                                                        </label>
                                                    </div>
                                                </div>
                                                <hr>
                                                ';
                                        }
                                        echo '
                                                <label class="row text-left ml-4" dir="ltr" id="add_new_card"> 
                                                <div class="col-md-12" >
                                                    <i class="icofont-plus me-2" aria-hidden="true"></i>  أضف بطاقة جديدة
                                                </div>
                                                </label>
                                                <hr>
                                            ';
                                    }
                                    ?>
                                    <div class="row add_new mt-3" <?php echo $data['cards'] ? 'style="display:none"' : '' ?>>
                                        <div class="col-md-12 col-lg-12">
                                            <div class="form-group mb-3">
                                                <label class="form-label" for="cardNumber">رقم البطاقة</label>
                                                <div class="card-number">
                                                    <input type="text" name="card_number" autocomplete="off" value="<?= $data['card_number'] ?? ''; ?>" required class="form-control only-number-with-paste auto-complete-off  <?php if (!empty($data['card_number_error'])) echo 'is-invalid'; ?>" id="cardNumber" maxlength="16" maxlength="19" placeholder="xxxx xxxx xxxx xxxx" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');">
                                                    <span class="invalid-feedback"><?= $data['card_number_error']; ?></span>
                                                </div>
                                            </div>
                                            <div class="d-flex justify-content-between">
                                                <div class="form-group mb-3 expiry-dates me-2" id="expiration-date" role="group" aria-label="تاريخ الانتهاء">
                                                    <label class="form-label">تاريخ الانتهاء</label>
                                                    <div class="card-dates d-flex">
                                                        <input type="text" autocomplete="off" name="expired_month" value="<?= $data['expired_month'] ?? ''; ?>" required class="form-control only-number card-exp" id="expMonth" placeholder="MM" maxlength="2" inputmode="numeric" pattern="(0[1-9]|1[0-2])" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');">
                                                        <input type="text" autocomplete="off" name="expired_year" value="<?= $data['expired_year'] ?? ''; ?>" required class="form-control only-number card-exp" id="expYear" placeholder="YY" maxlength="2" inputmode="numeric" pattern="[0-9]*" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');">
                                                        <span class="invalid-feedback"><?= $data['exp_date_error']; ?></span>
                                                    </div>
                                                </div>
                                                <div class="form-group mb-3 cvv">
                                                    <label class="form-label" for="cvv">رمز الأمان - CVV</label>
                                                    <input type="text" autocomplete="off" name="cvv" value="<?= $data['cvv'] ?? ''; ?>" required class="form-control only-number valid  <?php if (!empty($data['cvv_error'])) echo 'is-invalid'; ?>" id="cvv" placeholder="CVV" maxlength="3" inputmode="numeric" pattern="[0-9]*" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');">
                                                    <span class="invalid-feedback"><?= $data['cvv_error']; ?></span>
                                                </div>
                                            </div>

                                            <div class="form-group mb-3">
                                                <label class="form-label" for="member">الاسم المسجل على البطاقة</label>
                                                <input type="text" autocomplete="off" name="card_name" value="<?= $data['card_name'] ?? ''; ?>" required class="form-control card-holder-name english-only error  <?php if (!empty($data['card_name_error'])) echo 'is-invalid'; ?>" data-space="false" id="card_name" maxlength="50">
                                                <span class="invalid-feedback"><?= $data['card_name_error']; ?></span>
                                            </div>
                                            <?php
                                            if (@$_SESSION['login']) {
                                                echo '<div class="form-group mb-3">
                                                            <input type="checkbox" name="savecard">
                                                            <label class="form-label">احفظ البطاقة للتبرع مستقبلاً</label>
                                                        </div>';
                                            } else {
                                                echo ' <p> حفظ بيانات البطاقة لتبرع مستقبلاً من خلال  <a href="' . URLROOT . '/donors/login?redirect=1"> تسجبل الدخول </a></p> ';
                                            }
                                            ?>
                                        </div>
                                        <div class="col-md-6 col-lg-6 card-image">
                                            <img src="<?php echo URLROOT; ?>/public/templates/namaa/images/payment-cards.png" class="w-100">
                                        </div>
                                    </div>
                                </div>
                                <!-- upload image -------------------------------------------------------------------------------------------------- -->
                                <div class="bank-transfer payment-white p-3" id="bankTransImg" <?= $data['payment_method'] != 1 || $data['payment_method'] == null ? 'style="display: none;"' : '' ?>>
                                    <small>
                                        <div class="row mt-3">
                                            <div class="col-12  text-center p-0">
                                                <label class="control-label h4">الحسابات البنكية : </label>
                                                <table class="table table-striped jambo_table text-center table-responsive d-lg-table">
                                                    <thead>
                                                        <tr class="headings  text-center">
                                                            <th class="">اسم البنك </th>
                                                            <th class="">رقم الحساب </th>
                                                            <th class="">IBAN </th>
                                                            <th class="">رابط البنك </th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="items">
                                                        <?php
                                                        $meta = json_decode($data['payments_methods']->meta, true);
                                                        if (!empty($meta)) {
                                                            $x = 1;
                                                            foreach ($meta as $bank) {
                                                                echo '<tr class="">
                                                                <td>' . $bank['bankname'] . '</td>
                                                                <td>' . $bank['account_type'] . '</td>
                                                                <td>' . $bank['iban'] . '</td>
                                                                <td><a href="' . $bank['url'] . '" rel="no-fllow" target="_blank" >ذهاب</a></td>
                                                                </tr>';
                                                                $x++;
                                                            }
                                                        }
                                                        ?>
                                                    </tbody>
                                                </table>
                                                <h1 class="h3 text-center">ارفاق صورة التحويل</h1>
                                                <div class="form-group">
                                                    <label class="control-label" for="payment_key"> اختار البنك المحول اليه : </label>
                                                    <div class="has-feedback col-md-12">
                                                        <select class="form-control" name="payment_key" id="payment_key" required>
                                                            <option value=""></option>
                                                            <?php
                                                            foreach ($meta as $bank) {
                                                                if (@$data['payment_key'] == $bank['payment_key']) {
                                                                    echo '<option value="' . $bank['payment_key'] . '" selected>' . $bank['bankname'] .  ' </option>';
                                                                } else {
                                                                    echo '<option value="' . $bank['payment_key'] . '">' . $bank['bankname'] .  ' </option>';
                                                                }
                                                            }
                                                            ?>
                                                        </select>
                                                        <span class="invalid-feedback"><?= $data['payment_key_error']; ?></span>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="control-label" for="imageUpload">صورة الايصال : </label>
                                                    <div class="has-feedback input-group">
                                                        <span class="input-group-btn">
                                                            <input name="image" class="form-control  border-0" type="file">
                                                            <span id="image-error"><?= $data['image_error']; ?></span>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </small>
                                </div>
                                <!-- recaptcha  --------------------------------------------------------------------------------------------------- -->
                                <div class="form-group row mt-3 d-flex align-items-center justify-content-center">
                                    <div class="input-group col-sm-8  ">
                                        <div class="g-recaptcha <?php if (!empty($data['recaptcha_error'])) echo 'is-invalid'; ?>" data-sitekey="6LcVHY8bAAAAAMlrDHrlL1G-22ySTHpAFRYDZlQy"></div>
                                        <span class="invalid-feedback"> <?= $data['recaptcha_error']; ?></span>
                                    </div>
                                </div>
                                <!-- button    ----------------------------------------------------------------------------------------------------- -->
                                <div class="text-center mt-3">
                                    <button type="submit" id="submit" class="btn btn-success px-5 btn-lg"> إتمام التبرع </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="row"></div>

            <?php } else {  ?>
                <div class="col-md-12">
                    <div class="alert alert-primary text-center" role="alert"> لا يوجد منتجات في السلة </div>
                </div>
            <?php } ?>
        </div>

    </div>
    <div class="text-center mt-5">
        <a class="btn btn-success px-5 btn-lg" href="<?php echo URLROOT; ?>">العودة الي الرئيسية</a>
    </div>
</div>


<?php
// Data to be pushed to the data layer
$dataLayer = [
    'event' => 'begin_checkout',
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
</script>

<?php
$data['settings']['site']->footer_code .= '<script src="https://www.google.com/recaptcha/api.js" async defer></script>' . "\n\t";
require APPROOT . '/app/views/inc/footer.php'; ?>

<script>
    $(':radio[name="payment_method"]').change(function() {
        var paymentId = $(this).filter(':checked').val();
        if (paymentId != 1 && paymentId == 3) {
            $('#paymentByCard').show();
            $('#bankTransImg').hide();
            $('#payment_key').attr("required", false);
            $('#cardNumber').attr("required", true);
            $('#card_name').attr("required", true);
            $('#expMonth').attr("required", true);
            $('#expYear').attr("required", true);
            $('#cvv').attr("required", true);
        } else if (paymentId == 1) {
            $('#bankTransImg').show();
            $('#paymentByCard').hide();
            $('#payment_key').attr("required", true);
            $('#cardNumber').attr("required", false);
            $('#card_name').attr("required", false);
            $('#expMonth').attr("required", false);
            $('#expYear').attr("required", false);
            $('#cvv').attr("required", false);
        } else {
            $('#bankTransImg').hide();
            $('#paymentByCard').hide();
            $('#payment_key').attr("required", false);
            $('#cardNumber').attr("required", false);
            $('#card_name').attr("required", false);
            $('#expMonth').attr("required", false);
            $('#expYear').attr("required", false);
            $('#cvv').attr("required", false);
        }
    });


    var paymentId = $(':radio[name="payment_method"]').filter(':checked').val();
    var card_id = $(':radio[name="select_card"]').filter(':checked').val();
    $(document).ready(function() {
        if (paymentId != 1 && paymentId == 3) {
            $('#paymentByCard').show();
            $('#bankTransImg').hide();
            $('#payment_key').attr("required", false);
            $('#cardNumber').attr("required", true);
            $('#card_name').attr("required", true);
            $('#expMonth').attr("required", true);
            $('#expYear').attr("required", true);
            $('#cvv').attr("required", true);
        } else if (paymentId == 1) {
            $('#bankTransImg').show();
            $('#paymentByCard').hide();
            $('#payment_key').attr("required", true);
            $('#cardNumber').attr("required", false);
            $('#card_name').attr("required", false);
            $('#expMonth').attr("required", false);
            $('#expYear').attr("required", false);
            $('#cvv').attr("required", false);
            ca
        } else {
            $('#bankTransImg').hide();
            $('#paymentByCard').hide();
            $('#payment_key').attr("required", false);
            $('#cardNumber').attr("required", false);
            $('#card_name').attr("required", false);
            $('#expMonth').attr("required", false);
            $('#expYear').attr("required", false);
            $('#cvv').attr("required", false);
        }
        // select "old card" 
        $('.select_card').on('change', function() {
            $('.selected_cvv').hide();
            $('.add_new').hide();
            $(this).closest('.selected_saved_card').find('.selected_cvv').show();
            $('#cardNumber').attr("required", false);
            $('#card_name').attr("required", false);
            $('#expMonth').attr("required", false);
            $('#expYear').attr("required", false);
            $('#cvv').attr("required", false);
        });
        // select "add new payment card" 
        $('#add_new_card').on('click', function() {
            $('.selected_cvv').hide();
            $('.select_card').prop('checked', false);
            $('.add_new').show();
            $('#payment_key').attr("required", false);
            $('#cardNumber').attr("required", true);
            $('#card_name').attr("required", true);
            $('#expMonth').attr("required", true);
            $('#expYear').attr("required", true);
            $('#cvv').attr("required", true);
        });


    });
</script>