<?php require APPROOT . '/app/views/inc/header.php'; ?>
<section id="slider" class="wow bounceInUp container-md p-0">
    <div class="owl-carousel">
        <?php
        $galery = str_replace('&quot;', '', trim(trim($data['project']->image, ']'), '['));
        $galery = str_replace('&#34;', '', trim(trim($galery, ']'), '['));
        $galery = array_filter(explode(',', $galery), 'strlen');
        foreach ($galery as $key => $img) : ?>
            <div class="banner">
                <img class="d-block w-100" src="<?php echo MEDIAURL . '/' . str_replace('&#34;', '', trim(trim($img, ']'), '[')); ?>" alt="<?= $data['project']->name; ?>">
            </div>
        <?php endforeach; ?>
    </div>
    <h1 class="project-name"><?php echo $data['project']->name; ?></h1>

</section>
<!-- slider end -->
<div class="container-md battern">
    <!--- Product Start --->
    <section id="products">
        <div class="product mt-3 wow zoomIn text-right">
            <div class="target p-3">
                <div class=" pt-1 d-flex">
                    <span class="col"> المستهدف:
                        <?php echo $data['project']->target_price;
                        if (empty($data['project']->target_unit)) {
                            echo '<svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                                                            viewBox="0 0 1024 900" style="enable-background:new 0 0 1024 900;width:15px" xml:space="preserve">
                                                       <style type="text/css">
                                                           .st0{fill:#444444;}
                                                       </style>
                                                       <path class="st0" d="M596.8,735.6L596.8,735.6c-12.6,28-20.6,57.9-23.7,88.4L835,768.3c12.6-28,20.6-57.9,23.7-88.4L596.8,735.6z"/>
                                                       <path class="st0" d="M835,601.6c12.6-28,20.6-57.9,23.7-88.4l-204,43.4v-83.4L835,434.8c12.6-28,20.6-57.9,23.7-88.4l-204,43.3V89.9
                                                           c-31.2,17.5-58.9,40.8-81.6,68.5v248.8l-81.6,17.3V49.1c-31.2,17.5-58.9,40.8-81.6,68.5v324.2l-182.5,38.8
                                                           c-12.6,28-20.6,57.9-23.7,88.5L410,525.2v105l-221,47c-12.6,28-20.6,57.9-23.7,88.4l231.3-49.2c18.5-3.9,34.9-14.8,45.5-30.4
                                                           l42.4-62.9l0,0c4.6-6.7,7-14.7,7-22.8v-92.5l81.6-17.3v166.8L835,601.6L835,601.6z"/>
                                                       </svg>';;
                        } else {
                            echo  $data['project']->target_unit;
                        }  ?>
                    </span>
                    <span class="col text-left">تم جمع
                        <?php
                        if (!empty($data['project']->target_unit) && !empty($data['project']->unit_price)) { // check if user set unit and unit price
                            echo  $target = ceil(($data['collected_traget'] / $data['project']->unit_price) + $data['project']->fake_target);
                            echo  " " . $data['project']->target_unit;
                        } else {
                            echo  $target = $data['collected_traget'] + $data['project']->fake_target;
                            echo ' <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                                                            viewBox="0 0 1024 900" style="enable-background:new 0 0 1024 900;width:15px" xml:space="preserve">
                                                       <style type="text/css">
                                                           .st0{fill:#444444;}
                                                       </style>
                                                       <path class="st0" d="M596.8,735.6L596.8,735.6c-12.6,28-20.6,57.9-23.7,88.4L835,768.3c12.6-28,20.6-57.9,23.7-88.4L596.8,735.6z"/>
                                                       <path class="st0" d="M835,601.6c12.6-28,20.6-57.9,23.7-88.4l-204,43.4v-83.4L835,434.8c12.6-28,20.6-57.9,23.7-88.4l-204,43.3V89.9
                                                           c-31.2,17.5-58.9,40.8-81.6,68.5v248.8l-81.6,17.3V49.1c-31.2,17.5-58.9,40.8-81.6,68.5v324.2l-182.5,38.8
                                                           c-12.6,28-20.6,57.9-23.7,88.5L410,525.2v105l-221,47c-12.6,28-20.6,57.9-23.7,88.4l231.3-49.2c18.5-3.9,34.9-14.8,45.5-30.4
                                                           l42.4-62.9l0,0c4.6-6.7,7-14.7,7-22.8v-92.5l81.6-17.3v166.8L835,601.6L835,601.6z"/>
                                                       </svg> ';
                        }
                        ($data['project']->target_price) ?: $data['project']->target_price = 1;
                        ?>
                    </span>
                </div>
                <div class="progress my-1" style="height: 15px; direction:ltr">
                    <div data-toggle="tooltip" data-placement="top" title="<?php echo ceil($target * 100 / $data['project']->target_price) . "%"; ?>" class="bg-dark progress-bar-striped" role="progressbar" style="width: <?php echo ceil($target * 100 / $data['project']->target_price) . "%"; ?>;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
            </div>
            <div class="m-2">
                <div class="p-2"><?php echo $data['project']->description; ?></div>
            </div>
            <?php if (!$data['project']->finished) : ?>
                <div class="text-center bg-primary rounded py-2" id="donate">
                    <h4 class="text-white h5"> ملء معلومات الطلب </h4>
                </div>
                <div class="pay-form p-5">
                    <div class="msg"><?php flash('msg'); ?></div>
                    <form method="post" action="<?php root('projects'); ?>/redirect" id="pay" enctype="multipart/form-data" accept-charset="utf-8">
                        <div class="user-data" style="display: <?= $data['donor'] != '' ? 'none' : 'block' ?>;">
                            <div class="form-group row">
                                <label for="full-name" class="col-sm-2 col-form-label">الاسم بالكامل</label>
                                <div class="col-sm-10">
                                    <input type="hidden" name="mobile_confirmed" value="no" id="mobile-confirmed">
                                    <input type="hidden" name="project_id" value="<?php echo $data['project']->project_id; ?>" id="project_id">
                                    <input type="text" class="form-control" name="full_name" id="full-name" value="<?= @$data['donor']->full_name ?>" data-inputmask-regex="^[\u0621-\u064Aa-zA-Z\-_\s]+$" placeholder="الاسم بالكامل" required>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="mobile" class="col-sm-2 col-form-label">رقم الجوال</label>
                                <div class="input-group col-sm-10 mobile-validate">
                                    <input dir="ltr" class="form-control" name="mobile" type="text" value="<?= @$data['donor']->mobile ?>" placeholder="0500000000" id="mobile" data-inputmask="'mask': '9999999999'" required>
                                    <?php if ($data['project']->mobile_confirmation == 1) : ?>
                                        <div class="">
                                            <a class="input-group-text activate" data-toggle="modal" data-target="#addcode-x">ارسال </a>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <!-- <div class="form-group row">
                                <label for="identity" class="col-sm-2 col-form-label">رقم الهوية</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="identity" id="identity" value="<?= @$data['donor']->identity ?>" placeholder="رقم الهوية" maxlength="10" pattern="[0-9]{10}">
                                    <span class="invalid-feedback"><?= $data['identity_error']; ?></span>
                                </div>
                            </div> -->
                            <div class="form-group row mt-4">
                                <label for="email" class="col-sm-2 col-form-label"> البريد الالكتروني </label>
                                <div class="col-sm-10">
                                    <input type="email" class="form-control" name="email" value="<?= @$data['donor']->email ?>" placeholder="هام لاستقبال رسائل التأكيد ">
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="" class="col-sm-2 col-form-label"> خيارات التبرع </label>
                            <?php
                            $donation_type = json_decode($data['project']->donation_type);
                            ?>
                            <div class="input-group col-sm-8">
                                <div class=" btn-group-toggle" data-toggle="buttons">
                                    <?php
                                    $price = 0;
                                    switch ($donation_type->type) {
                                        case 'share':
                                            if (isset($donation_type->value->item1->value)) $price = $donation_type->value->item1->value;
                                            foreach ($donation_type->value as $value) {
                                                echo '<label class="btn btn-primary  m-1">
                                                        <input type="radio"  ';
                                                echo $value->value == $price ? ' checked="checked"' : null;
                                                echo ' value ="' . $value->value . '" name="donation_type" required class="donation-value"> ' . $value->name . '
                                                        <input type="hidden" name="donation_type" value="" class="donation_type_name">
                                                    </label>';
                                            }
                                            break;
                                        case 'open':
                                            echo 'قم بكتابة المبلغ المراد التبرع به 
                                            <input type="hidden" name="donation_type" value="مفتوح" class="donation_type_name">
                                            ';
                                            break;
                                        case 'unit':
                                            if (isset($donation_type->value->item1->value)) $price = $donation_type->value->item1->value;
                                            foreach ($donation_type->value as $value) {
                                                echo '  <label class="btn btn-primary  m-1">
                                                        <input type="radio" ';
                                                echo $value->value == $price ? ' checked="checked"' : null;
                                                echo ' value ="' . $value->value . '" name="donation_type" class="donation-value"> ' . $value->name . '
                                                        <input type="hidden" name="donation_type" value="" class="donation_type_name">
                                                        </label>';
                                            }
                                            break;
                                        case 'fixed':
                                            $price =  $donation_type->value;

                                            echo '<label class="btn btn-primary  m-1">
                                                    <input type="radio" value ="' . $donation_type->value . '" name="donation_type" class="donation-value"> ' . $donation_type->value .
                                                ' <img src="' . MEDIAURL . '/rayal.png" width="25px">'
                                                .  ' <input type="hidden" name="donation_type" value="قيمة ثابته" class="donation_type_name">
                                                </label>';
                                            break;
                                    }
                                    ?>
                                    <span class="donation_type_error"></span>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="" class="col-sm-2 col-form-label"> القيمة : </label>
                            <div class="input-group col-sm-2">
                                <input placeholder="القيمة" value="<?= $price ?>" min="1" type="number" class="form-control amount" <?php echo ($donation_type->type == 'fixed' || $donation_type->type == 'share') ? 'readonly' : ''; ?> required name="amount">
                            </div>
                            <span class="amout_error"></span>
                        </div>
                        <div class="form-group row <?php echo ($donation_type->type == 'open') ? "d-none" : ""; ?>">
                            <label for="" class="col-sm-2 col-form-label"> الكمية: </label>
                            <div class="input-group col-sm-2">
                                <input type="number" name="quantity" min="1" value="1" required id="quantity" class="form-control d-inline" onkeypress="return isNumberKey(event)"  >
                            </div>
                            <span class="quantity_error"></span>
                        </div>
                        <div class="form-group row">
                            <label for="" class="col-sm-2 col-form-label">القيمة الاجمالية: </label>
                            <div class="input-group col-sm-2">
                                <input type="number" readonly name="total" value="<?= $price ?>" id="total" class="form-control d-inline">
                            </div>
                            <span class="total_error"></span>
                        </div>
                        <?php if ($data['project']->gift) : ?>
                            <div class="gift-options form-group row">
                                <label for="" class=" col-sm-2 col-form-label"> الاهداء الخيري </label>
                                <div class="input-group col-12 col-sm-10 btn-group-toggle" data-toggle="buttons">
                                    <label class="btn btn-primary mt-2 col-6">
                                        <input type="radio" value="1" name="gift[enable]" class="gift"> اهداء هذا التبرع
                                    </label>
                                    <label class="btn btn-danger mt-2 col-5 mr-2">
                                        <input type="radio" value="0" checked name="gift[enable]" class="gift"> الغاء
                                    </label>
                                </div>
                            </div>
                            <div class="gift-values form-group row">
                                <label for="" class="col-sm-2 col-form-label"> اسم المهدي الية </label>
                                <div class="input-group col-sm-10">
                                    <input type="text" class="form-control" name="gift[giver_name]" id="giver_name" data-inputmask-regex="^[\u0621-\u064Aa-zA-Z\-_\s]+$" value="">
                                </div>
                            </div>
                            <div class="gift-values form-group row">
                                <label for="" class="col-sm-2 col-form-label"> رقم المهدي الية </label>
                                <div class="input-group col-sm-10">
                                    <input type="text" class="form-control ltr" name="gift[giver_number]" id="giver_number" data-inputmask="'mask': '9999999999'" placeholder="رقم المهدي اليه">
                                </div>
                            </div>
                            <div class="gift-values form-group row">
                                <label for="" class="col-sm-2 col-form-label"> بريد المهدي الية </label>
                                <div class="input-group col-sm-10">
                                    <input type="text" class="form-control" name="gift[giver_email]" id="giver_email" placeholder="بريد المهدي اليه لاستقبال  كارت الاهداء">
                                </div>
                            </div>
                            <div class="gift-values form-group row">
                                <label for="" class="col-sm-2 col-form-label"> فئات الاهداء </label>
                                <div class="input-group col-sm-10">
                                    <select name="gift[giver_group]" id="giver_group" class="custom-select">
                                        <option value="">اختار فئة الإهداء</option>
                                        <?php
                                        foreach ($data['settings']['gift'] as $key => $value) {
                                            echo  '<option id="' . str_replace('_name', '', $key) . '" value="' . $value->name . '">' . $value->name . '</option>';
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="gift-values form-group row">
                                <label for="" class="col-7 col-sm-2 col-form-label"> كارت الاهداء </label>
                                <div class="input-group col-5 col-sm-10">
                                    <div class=" btn-group-toggle" data-toggle="buttons">
                                        <?php
                                        foreach ($data['settings']['gift'] as $key => $value) {
                                            if ($key == 'subject' || $key == 'msg') continue;
                                            $values = explode(',', $value->image);
                                            foreach ($values as $val) {
                                                $val = str_replace('&quot;', '', trim(trim($val, ']'), '['));
                                                echo '<label class="btn btn-light group-img d-none" id="' . $key . '">
                                                    <input type="radio" class="d-relative" value="' . $val . '" name="gift[card]" >
                                                    <img width="100" src="' . MEDIAURL . "/" . $val . '" class="h-100 img-thumbnail"  alt="lightbox">
                                                  </label>
                                                  ';
                                            }
                                        }
                                        ?>
                                    </div>
                                </div>
                            </div>
                        <?php endif; ?>
                        <div class="form-group row">
                            <label for="" class="col-sm-2 col-form-label">وسيلة الدفع </label>
                            <div class="input-group col-sm-8 col-12 btn-group-toggle row" data-toggle="buttons">
                                <?php
                                foreach ($data['payment_methods'] as $payment_method) {
                                    if ($payment_method->payment_id == 10) {
                                        $user_agent = $_SERVER['HTTP_USER_AGENT'];
                                        if (stripos($user_agent, 'Safari') !== false &&  !(stripos($user_agent, 'Chrome') !== false)) {
                                            echo '<label class="btn btn-dark mt-2 mr-1 col col-md-5 col-12 "">
                                                <input type="radio" value ="' . $payment_method->payment_id . '" name="payment_method" requiredclass="payment_method">
                                                 الدفع بواسطة <i class="icofont-apple-pay icofont-2x"></i>
                                            </label>';
                                        }
                                    } else {
                                        echo '<label class="btn btn-primary mt-2 mr-1 col col-md-5 col-12" id="payment_' . $payment_method->payment_id . '">
                                                <input type="radio" value ="' . $payment_method->payment_id . '" name="payment_method" required class="payment_method"> '
                                            . $payment_method->title . '
                                            </label>';
                                    }
                                }
                                ?>
                            </div>
                        </div>
                        <div class="card-payment form-group row d-flex flex-grow-1 justify-content-center align-items-center mt-3">
                            <div class="project-card col-md-9 m-3">
                                <!-- Payment method by Card ---------------------------------------------------------------------------------------- -->
                                <div class="payment-card payment-white p-4" id="paymentByCard" <?= @$data['payment_method'] == 1 || @$data['payment_method'] == null ? 'style="display: none;"' : '' ?>>
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
                                    <div class="row add_new mt-3  justify-content-center align-items-center" <?php echo $data['cards'] ? 'style="display:none"' : '' ?>>
                                        <div class="">
                                            <div class="card mt-3 mb-3 card-info border-0" dir="rtl">
                                                <div class="card-body">
                                                    <h5 class="text-right mb-3"> بطاقات الدفع </h5>
                                                    <div class="card payment-card p-3">
                                                        <div class="row mt-3">
                                                            <div class="col-md-6 col-lg-6">
                                                                <div class="form-group mb-3">
                                                                    <label class="form-label" for="cardNumber">رقم البطاقة</label>
                                                                    <div class="card-number">
                                                                        <input type="text" name="card_number" autocomplete="off" value="<?= $data['card_number'] ?? ''; ?>" required class="form-control only-number-with-paste  <?php if (!empty($data['card_number_error'])) echo 'is-invalid'; ?>" id="cardNumber" maxlength="16" autocomplete="cc-number" maxlength="19" placeholder="xxxx xxxx xxxx xxxx" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');">
                                                                        <span class="invalid-feedback"><?= $data['card_number_error']; ?></span>
                                                                    </div>
                                                                </div>
                                                                <div class="d-flex justify-content-between">
                                                                    <div class="form-group mb-3 expiry-dates me-2" id="expiration-date" role="group" aria-label="تاريخ الانتهاء">
                                                                        <label class="form-label">تاريخ الانتهاء</label>
                                                                        <div class="card-dates d-flex">
                                                                            <input type="text" name="expired_month" autocomplete="off" value="<?= $data['expired_month'] ?? ''; ?>" required class="form-control only-number card-exp  <?php if (!empty($data['expired_month_error'])) echo 'is-invalid'; ?>" id="expMonth" placeholder="MM" maxlength="2" inputmode="numeric" pattern="(0[1-9]|1[0-2])" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');">
                                                                            <input type="text" name="expired_year" autocomplete="off" value="<?= $data['expired_year'] ?? ''; ?>" required class="form-control only-number card-exp  <?php if (!empty($data['expired_year_error'])) echo 'is-invalid'; ?>" id="expYear" placeholder="YY" maxlength="2" inputmode="numeric" pattern="[0-9]*" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');">
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group mb-3 cvv">
                                                                        <label class="form-label" for="cvv">رمز الأمان - CVV</label>
                                                                        <input type="text" autocomplete="off" name="cvv" value="<?= $data['cvv'] ?? ''; ?>" required class="form-control only-number card-exp valid  <?php if (!empty($data['cvv_error'])) echo 'is-invalid'; ?>" id="cvv" placeholder="CVV" maxlength="3" inputmode="numeric" pattern="[0-9]*" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');">
                                                                    </div>
                                                                </div>

                                                                <div class="form-group mb-3">
                                                                    <label class="form-label" for="member">الاسم المسجل على البطاقة</label>
                                                                    <input type="text" name="card_name" autocomplete="off" value="<?= $data['card_name'] ?? ''; ?>" id="card_name" required class="form-control card-holder-name english-only error  <?php if (!empty($data['name_error'])) echo 'is-invalid'; ?>" data-space="false" id="member" maxlength="50">
                                                                </div>
                                                            </div>

                                                            <div class="col-md-6 col-lg-6 card-image">
                                                                <img src="<?php echo URLROOT; ?>/public/templates/namaa/images/payment-cards.png" class="w-100">
                                                            </div>
                                                        </div>
                                                        <?php
                                                        if (@$_SESSION['login']) {
                                                            echo '<div class="form-group mb-3">
                                                                                <input type="checkbox" name="default">
                                                                                <label class="form-label">احفظ البطاقة للتبرع مستقبلاً</label>
                                                                            </div>';
                                                        } else {
                                                            echo ' <p> حفظ بيانات البطاقة لتبرع مستقبلاً من خلال <a href="' . URLROOT . '/donors/login?redirect=1"> تسجبل الدخول </a> </p> ';
                                                        }
                                                        ?>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- upload image -------------------------------------------------------------------------------------------------- -->
                                <div class="bank-transfer payment-white p-3" id="bankTransImg" <?= @$data['payment_method'] != 1 || @$data['payment_method'] == null ? 'style="display: none;"' : '' ?>>
                                    <div class="row mt-3">
                                        <div class="col-12  text-center">
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
                                                    $meta = json_decode($data['payments_methods_bank']->meta, true);
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
                                                <div class="has-feedback ">
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
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>



                        <div class="form-group row">
                            <label for="" class="col-sm-2 col-form-label">كود التحقق </label>
                            <div class="input-group col-sm-8 ">
                                <div class="g-recaptcha" data-sitekey="6LcVHY8bAAAAAMlrDHrlL1G-22ySTHpAFRYDZlQy"></div>
                            </div>
                        </div>
                        <div class="form-group text-center">
                            <button class="btn btn-primary btn-lg m-2 px-5" name="pay" type="submit">دفع
                                <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                                    viewBox="0 0 16 16" style="enable-background:new 0 0 16 16;width: 26px;" xml:space="preserve">
                                    <style type="text/css">
                                        .st0 {fill: #FFFFFF; }
                                    </style>
                                    <g>
                                        <path class="st0" d="M9.6,13.8L9.6,13.8c-0.2,0.5-0.4,1.1-0.5,1.7l5.1-1.1c0.2-0.5,0.4-1.1,0.5-1.7L9.6,13.8z" />
                                        <path class="st0" d="M14.2,11.2c0.2-0.5,0.4-1.1,0.5-1.7l-3.9,0.8V8.7L14.2,8c0.2-0.5,0.4-1.1,0.5-1.7l-3.9,0.8V1.3
                                        c-0.6,0.3-1.1,0.8-1.6,1.3v4.8L7.6,7.8V0.5C7,0.8,6.5,1.3,6,1.8v6.3L2.5,8.9C2.3,9.4,2.1,10,2,10.6l4-0.8v2l-4.3,0.9
                                        c-0.2,0.5-0.4,1.1-0.5,1.7l4.5-1c0.4-0.1,0.7-0.3,0.9-0.6l0.8-1.2l0,0c0.1-0.1,0.1-0.3,0.1-0.4V9.4L9.2,9v3.2L14.2,11.2L14.2,11.2z
                                        " />
                                    </g>
                                </svg>
                            </button>
                            <?php if ($data['project']->enable_cart) : ?>
                                <a href="<?php echo URLROOT . '/carts/ajaxAdd'; ?>" id="addToCart" class="btn btn-lg p-2 btn-success"> أضف إلى السلة <i class="icofont-cart-alt"></i> </a>
                            <?php endif; ?>
                        </div>
                    </form>
                </div>
                <h3 class="my-4 text-center h5"><i class="icofont-stylish-right"></i> تصدق بالنشر ولك الأجر فالدال على الخير كفاعله<i class="icofont-stylish-left"></i></h3>
                <!-- code activation modal -->
                <div id="addcode" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="addcode-title" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button class="close m-0 p-0" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                                <h5 class="modal-title mx-auto" id="addcode-title">كود التفعيل</h5>
                            </div>
                            <div class="modal-body">
                                <form method="post" action="<?php root('projects'); ?>" id="active-code">
                                    <div class="msg"></div>
                                    <input class="form-control" name="code" type="text" placeholder="code" aria-label="code">
                                    <input class="btn btn-success mt-2" name="verify" type="submit" value="تفعيل">
                                    <input class="btn btn-danger mt-2 float-left" name="verify" type="submit" data-dismiss="modal" value="غلق">
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            <?php else : echo '<p class="text-center border p-2 text-success"> تم اغلاق التبرع لهذا المشروع </p>';
            endif; ?>
            <div class="row justify-content-center">
                <!-- Go to www.addthis.com/dashboard to customize your tools -->
                <div class="addthis_inline_share_toolbox"></div>
            </div>
            <section id="categories" class="my-5 text-center">
                <div class="owl-carousel">
                    <?php foreach ($data['moreprojects'] as $moreprojects) : ?>
                        <div class="project-category">
                            <div class="category-container my-3">
                                <img class="" src="<?php echo (empty($moreprojects->secondary_image)) ? MEDIAURL . '/default.jpg' : MEDIAURL . '/' . $moreprojects->secondary_image; ?>" alt="<?php echo $moreprojects->name; ?>">
                                <a href="<?php echo URLROOT . '/projects/show/' . $moreprojects->project_id . '-' . $moreprojects->alias; ?>" class="category-title">
                                    <h1 class="h6 my-3"><?php echo $moreprojects->name; ?></h1>
                                </a>
                                <a class="btn btn-outline-secondary btn-sm mb-3 category-btn" href="<?php echo URLROOT . '/projects/show/' . $moreprojects->project_id . '-' . $moreprojects->alias; ?>">التفاصيل</a>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </section>
            <div class="text-center my-3">
                <?php
                if (@exist($_SESSION['store']->whatsapp)) {
                    echo '<a class="m-2 btn px-5 btn-success" href="https://wa.me/' . $_SESSION['store']->whatsapp . '"><i class=" icofont-whatsapp"></i> ' . $_SESSION['store']->whatsapp . '</a>';
                } elseif (@exist($data['project']->whatsapp)) {
                    echo '<a class="m-2 btn px-5 btn-success" href="https://wa.me/' . $data['project']->whatsapp . '"><i class=" icofont-whatsapp"></i> ' . $data['project']->whatsapp . '</a>';
                } elseif (@exist($data['settings']['contact']->whatsapp)) {
                    echo '<a class="m-2 btn px-5 btn-success" href="https://wa.me/' . $data['settings']['contact']->whatsapp . '"><i class=" icofont-whatsapp"></i> ' . $data['settings']['contact']->whatsapp . '</a>';
                }
                if (@exist($_SESSION['store']->mobile)) {
                    echo '<a class="m-2 btn px-5 btn-primary" href="tel:' . $_SESSION['store']->mobile . '"><i class=" icofont-phone"></i> ' . $_SESSION['store']->mobile . '</a>';
                } elseif (@exist($data['project']->mobile)) {
                    echo '<a class="m-2 btn px-5 btn-primary" href="tel:' . $data['project']->mobile . '"><i class=" icofont-phone"></i> ' . $data['project']->mobile . '</a>';
                } elseif (@exist($data['settings']['contact']->mobile)) {
                    echo '<a class="m-2 btn px-5 btn-primary" href="tel:' . $data['settings']['contact']->mobile . '"><i class=" icofont-phone"></i> ' . $data['settings']['contact']->mobile . '</a>';
                }
                ?>
                <br>
                <?php echo ($data['project']->back_home) ? '<a class="mt-2 btn px-5 btn-secondary" href="' . URLROOT . '">
                <i class=" icofont-home"></i> العودة الي الرئيسية</a>' : ''; ?>
            </div>

        </div>
    </section>
    <!-- alertModal -->
    <div class="modal fade" id="alertModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body">
                </div>
                <div class="p-2 border-top">
                    <a href="<?php root('carts') ?>" class="btn btn-primary mx-2">عرض السلة</a>
                    <button type="button" class="btn btn-danger float-left" data-dismiss="modal">اغلاق</button>
                </div>

            </div>
        </div>
    </div>
    <!-- card image popup Modal -->
    <div class="modal fade" id="popup">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-body">
                </div>
            </div>
        </div>
    </div>
    <!-- End product -->
</div>


<?php
// Data to be pushed to the data layer
$dataLayer = [
    'event' => 'view_item',
    'ecommerce' => [
        'items' => [
            'item_id' => $data['project']->project_id,
            'item_name' => $data['project']->name,
            'currency' => 'SAR',
        ]
    ],
];
?>

<script>
    if (window.dataLayer) {
        dataLayer.push(<?php echo json_encode($dataLayer); ?>);
        console.log(dataLayer);
    }
</script>


<?php
$data['settings']['site']->footer_code .= '<script src="https://www.google.com/recaptcha/api.js" async defer></script>
     <script src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-508116077910fef8"></script>' . "\n\t";
require APPROOT . '/app/views/inc/footer.php'; ?>


<script>
    // 1 -> banktransfer
    // 2 -> الدفع من خلال فروعنا 
    // 3 -> visa
    // 4 -> installment
    // 5 -> STC pay
    // 6 -> payed from panda
    // 7 -> Cash in drivery 
    // 8 -> ApplePay

    function isNumberKey(evt) {
        var charCode = (evt.which) ? evt.which : evt.keyCode
        if (charCode > 31 && (charCode < 48 || charCode > 57))
            return false;
        return true;
    }


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