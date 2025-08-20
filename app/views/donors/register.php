<?php
require APPROOT . '/app/views/inc/header.php';
flash('msg'); ?>
<div class="container page">
    <style>
        label{
            width: 100%;
            text-align: right;
            color: #208fee;
        }
    </style>
    <!--- Products Start --->
    <section class="products mb-5 pb-5">
        <div class="row mt-4 justify-content-md-center">
            <div class="col-12">
                <h3 class="text-center">
                    <img src="<?php echo URLROOT; ?>/templates/default/images/namaa-icon.png" alt="namaa-icon" class="ml-1">
                    <?php echo 'تسجيل حساب جديد '; ?>
                </h3>
            </div>
            <div class="col-lg-6 col-sm-12 py-5 ">

                <div class="card  mb-5">
                    <div class="card-header text-center bg-dark text-light">
                        حساب جديد
                    </div>
                    <div class="card-body h-100">
                        <form action="<?php root('donors'); ?>/validate" method="post" id="register">
                            <div class="msg  w-100 text-center"></div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-12 mt-4">
                                        <label class="control-label" dir="rtl" for=""> الاسم </label>
                                        <input  class="form-control" name="full_name" type="text" placeholder="الاسم بالكامل" id="full_name">
                                    </div>
                                    <div class="col-12 mt-4">
                                        <label class="control-label" for=""> البريد الإلكتروني</label>
                                        <input class="form-control" name="email" type="email" placeholder="البريد الإلكتروني" id="email">
                                    </div>
                                    <div class="col-12 mt-4">
                                        <label class="control-label" for="">رقم الجوال</label>
                                        <input class="form-control" name="mobile" type="text" placeholder="05XXXXXXXX" id="mobile" data-inputmask="'mask': '9999999999'">
                                    </div>
                                    <!-- <div class="col-12 mt-4  mb-4">
                                        <label class="control-label" for="">رقم الهوية</label>
                                        <input class="form-control" name="identity" type="text" placeholder="رقم الهوية" id="identity" maxlength="10" required>
                                    </div> -->
                                    <div class="col-12 mt-4 mb-4">
                                        <div class="g-recaptcha" data-sitekey="6LcVHY8bAAAAAMlrDHrlL1G-22ySTHpAFRYDZlQy" style="margin:auto; max-width:305px;"></div>
                                        <span class="text-danger"><?= $data['captcha_error'] ?? ''; ?></span>
                                    </div>
                                    <div class="col-12 text-center">
                                        <button class="btn btn-dark m-2 px-5" name="register" type="submit" data-toggle="modal" data-target="#sendcode">انشاء حساب جديد </button>
                                    </div>
                                </div>
                               
                            </div>
                            <div class="col-md-12 w-100 text-center">
                                <span>هل لديك حساب ؟ </span><a href="/donors/login">تسجيل الدخول</a>
                            </div>
                        </form>
                        <div id="" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="sendcode-title" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button class="close m-0 p-0" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                        <h5 class="modal-title mx-auto" id="sendcode-title">كود التفعيل</h5>
                                    </div>
                                    <div class="msg"></div>
                                    <div class="modal-body">
                                        <form method="post" action="<?php root('donors'); ?>" id="active-code-register">
                                            <input class="form-control" name="code" type="text" placeholder="code" aria-label="code">
                                            <input class="btn btn-success mt-2 float-right" name="verify" type="submit" value="تأكيد">
                                            <input class="btn btn-danger mt-2 float-left" name="verify" type="submit" data-dismiss="modal" value="غلق">
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- end products -->
</div>

<?php
    $data['settings']['site']->footer_code .= '<script src="https://www.google.com/recaptcha/api.js?hl=ar" async defer></script>';
    require APPROOT . '/app/views/inc/footer.php'; 
?>