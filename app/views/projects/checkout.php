<?php require APPROOT . '/app/views/inc/header.php'; ?>

<style>
    * {
        box-sizing: border-box;
    }

    body {
        background-color: #f1f1f1;
    }

    #regForm {
        background-color: #ffffff;
        margin: 100px auto;
        font-family: Raleway;
        padding: 40px;
        width: 70%;
        min-width: 300px;
    }

    h1 {
        text-align: center;
    }

    input {
        padding: 10px;
        width: 100%;
        font-size: 17px;
        font-family: Raleway;
        border: 1px solid #aaaaaa;
    }

    /* Mark input boxes that gets an error on validation: */
    input.invalid {
        background-color: #ffdddd;
    }

    /* Hide all steps by default: */
    .tab {
        display: none;
    }

    button {
        background-color: #04AA6D;
        color: #ffffff;
        border: none;
        padding: 10px 20px;
        font-size: 17px;
        font-family: Raleway;
        cursor: pointer;
    }

    button:hover {
        opacity: 0.8;
    }

    #prevBtn {
        background-color: #bbbbbb;
    }

    /* Make circles that indicate the steps of the form: */
    .step {
        height: 15px;
        width: 15px;
        margin: 0 2px;
        background-color: #bbbbbb;
        border: none;
        border-radius: 50%;
        display: inline-block;
        opacity: 0.5;
    }

    .step.active {
        opacity: 1;
    }

    /* Mark the steps that are finished and valid: */
    .step.finish {
        background-color: #04AA6D;
    }
</style>

<div class="container">
    <div class="msg"><?php flash('msg'); ?></div>
    <!-- Categories -->
    <section id="categories">
        <div class="row m-3 justify-content-center ">
            <div class="col">
                <form method="post" action="<?php root('projects'); ?>/redirect" id="pay regForm">
                    <h1> Check Out </h1>
                    <!-- One "tab" for each step in the form: -->
                    <div class="tab"> 
                        <div class="form-group row">
                            <label for="full-name" class="col-sm-2 col-form-label">الاسم بالكامل</label>
                            <div class="col-sm-10">
                                <input type="hidden" name="mobile_confirmed" value="no" id="mobile-confirmed">
                                <input type="hidden" name="project_id" value="<?php echo $data['project']->project_id; ?>" id="project_id">
                                <input type="text" class="form-control" name="full_name" id="full-name" data-inputmask-regex="^[\u0621-\u064Aa-zA-Z\-_\s]+$" placeholder="الاسم بالكامل" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="mobile" class="col-sm-2 col-form-label">رقم الجوال</label>
                            <div class="input-group col-sm-10 mobile-validate">
                                <input dir="ltr" class="form-control" name="mobile" type="text" placeholder="0500000000" id="mobile" data-inputmask="'mask': '9999999999'" required>
                                <?php if ($data['project']->mobile_confirmation == 1) : ?>
                                    <div class="">
                                        <a class="input-group-text activate" data-toggle="modal" data-target="#addcode-x">ارسال </a>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="form-group row mt-4">
                            <label for="email" class="col-sm-2 col-form-label"> البريد الالكتروني </label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="email" placeholder="هام لاستقبال رسائل التأكيد " required>
                            </div>
                        </div>
                    </div>

                    <div class="tab"> 
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
                                                        <input type="radio"  required ';
                                                echo $value->value == $price ? ' checked="checked"' : null;
                                                echo ' value ="' . $value->value . '" name="donation_type" required class="donation-value"> ' . $value->name . '
                                                        <input type="hidden" name="donation_type" value="" class="donation_type_name" required>
                                                    </label>';
                                            }
                                            break;
                                        case 'open':
                                            echo 'قم بكتابة المبلغ المراد التبرع به 
                                            <input type="hidden" name="donation_type" value="مفتوح" class="donation_type_name" required>
                                            ';
                                            break;
                                        case 'unit':
                                            if (isset($donation_type->value->item1->value)) $price = $donation_type->value->item1->value;
                                            foreach ($donation_type->value as $value) {
                                                echo '  <label class="btn btn-primary  m-1">
                                                        <input type="radio" required';
                                                echo $value->value == $price ? ' checked="checked"' : null;
                                                echo ' value ="' . $value->value . '" name="donation_type" class="donation-value"> ' . $value->name . '
                                                        <input type="hidden" name="donation_type" value="" class="donation_type_name" required>
                                                        </label>';
                                            }
                                            break;
                                        case 'fixed':
                                            $price =  $donation_type->value;

                                            echo '<label class="btn btn-primary  m-1">
                                                    <input type="radio" value ="' . $donation_type->value . '" name="donation_type" class="donation-value"> ' . $donation_type->value . 
                                                    ' <img src="' . MEDIAURL . '/rayal.png" width="25px">'. ' 
                                                        <input type="hidden" name="donation_type" value="قيمة ثابته" class="donation_type_name">
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
                                <input type="number" name="quantity" min="1" value="1" required id="quantity" class="form-control d-inline">
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
                    </div>

                    <div class="tab">
                        <?php if ($data['project']->gift) { ?>
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
                        <?php } else { ?>
                            <div class="gift-values form-group row">
                                لا يوجد اهداء
                            </div>
                        <?php }  ?>
                    </div>

                    <div class="tab"> 
                        <div class="form-group row">
                            <label for="" class="col-sm-2 col-form-label">وسيلة الدفع </label>
                            <div class="input-group col-sm-8 col-12 btn-group-toggle row" data-toggle="buttons">
                                <?php
                                foreach ($data['payment_methods'] as $payment_method) {
                                    if ($payment_method->payment_id == 10) {
                                        if (strpos(  $_SERVER['HTTP_USER_AGENT'], 'Safari') !== false){
                                            // echo '<label class="btn btn-dark mt-2 mr-1 col col-md-5 col-12 ">
                                            //         <input type="radio" value ="' . $payment_method->payment_id . '" name="payment_method" required class="payment_method">
                                            //         الدفع بواسطة <i class="icofont-apple-pay icofont-2x"></i>
                                            //     </label>';
                                            }
                                    } else {
                                        echo '<label class="btn btn-primary mt-2 mr-1 col col-md-5 col-12 ">
                                                <input type="radio" value ="' . $payment_method->payment_id . '" name="payment_method" required class="payment_method"> '
                                            . $payment_method->title . '
                                            </label>';
                                    }
                                }
                                ?>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="" class="col-sm-2 col-form-label">كود التحقق </label>
                            <div class="input-group col-sm-8 ">
                                <div class="g-recaptcha" data-sitekey="6LcVHY8bAAAAAMlrDHrlL1G-22ySTHpAFRYDZlQy"></div>
                            </div>
                        </div>
                    </div>

                    <div style="overflow:auto;">
                        <div style="float:right;">
                            <button type="button" id="nextBtn" onclick="nextPrev(1)">استمر</button>
                            <button type="button" id="prevBtn" onclick="nextPrev(-1)">رجوع</button>
                        </div>
                    </div>
                    <!-- Circles which indicates the steps of the form: -->
                    <div style="text-align:center;margin-top:40px;">
                        <span class="step"></span>
                        <span class="step"></span>
                        <span class="step"></span>
                        <span class="step"></span>
                    </div>
                </form>
            </div>
        </div>

    </section>
</div>
<script>
    var currentTab = 0; // Current tab is set to be the first tab (0)
    showTab(currentTab); // Display the current tab

    function showTab(n) {
        // This function will display the specified tab of the form...
        var x = document.getElementsByClassName("tab");
        x[n].style.display = "block";
        //... and fix the Previous/Next buttons:
        if (n == 0) {
            document.getElementById("prevBtn").style.display = "none";
            
        } else {
            document.getElementById("prevBtn").style.display = "inline";
        }
        if (n == (x.length - 1)) {
            document.getElementById("nextBtn").innerHTML = "دفع";
            document.getElementById("nextBtn").setAttribute('type', 'submit');
        } else {
            document.getElementById("nextBtn").innerHTML = "استمر";
            document.getElementById("nextBtn").setAttribute('type', 'button');
        }
        //... and run a function that will display the correct step indicator:
        fixStepIndicator(n)
    }

    function nextPrev(n) {
        // This function will figure out which tab to display
        var x = document.getElementsByClassName("tab");
        // Exit the function if any field in the current tab is invalid:
        if (n == 1 && !validateForm()) return false;
        // Hide the current tab:
        x[currentTab].style.display = "none";
        // Increase or decrease the current tab by 1:
        currentTab = currentTab + n;
        // if you have reached the end of the form...
        if (currentTab >= x.length) {
            // ... the form gets submitted:
            document.getElementById("regForm").submit();
            return false;
        }
        // Otherwise, display the correct tab:
        showTab(currentTab);
    }

    function validateForm() {
        // This function deals with validation of the form fields
        var x, y, i, valid = true;
        x = document.getElementsByClassName("tab");
        y = x[currentTab].getElementsByTagName("input");
        // A loop that checks every input field in the current tab:
        for (i = 0; i < y.length; i++) {
            // If a field is empty...
            if (y[i].value == "" & y[i].hasAttribute('required')) {
                // add an "invalid" class to the field:
                y[i].className += " invalid";
                // and set the current valid status to false
                valid = false;
            }
        }
        // If the valid status is true, mark the step as finished and valid:
        if (valid) {
            document.getElementsByClassName("step")[currentTab].className += " finish";
        }
        return valid; // return the valid status
    }

    function fixStepIndicator(n) {
        // This function removes the "active" class of all steps...
        var i, x = document.getElementsByClassName("step");
        for (i = 0; i < x.length; i++) {
            x[i].className = x[i].className.replace(" active", "");
        }
        //... and adds the "active" class on the current step:
        x[n].className += " active";
    }
</script>
<!-- end Categories -->
<?php 
    $data['settings']['site']->footer_code .= '<script src="https://www.google.com/recaptcha/api.js" async defer></script>';    
    require APPROOT . '/app/views/inc/footer.php'; 
?>