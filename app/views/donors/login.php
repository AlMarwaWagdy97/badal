<?php    
require APPROOT . '/app/views/inc/header.php';
flash('msg'); ?>
<div class="container page">
    <!--- Products Start --->
    <section class="products mb-5 pb-5">
        <div class="row mt-4 justify-content-md-center">
            <div class="col-12">
                <h3 class="text-center">
                    <img src="<?php echo URLROOT; ?>/templates/default/images/namaa-icon.png" alt="namaa-icon" class="ml-1">
                    <?php echo 'سجل التبرعات الشخصية '; ?>
                </h3>
            </div>
            <div class="col-lg-6 col-sm-12 py-5 ">

                <div class="card text-center mb-5">
                    <div class="card-header bg-dark text-light">
                        تسجيل الدخول
                    </div>
                    <div class="card-body h-100">
                        <p>تسجيل الدخول من خلال رقم الجوال</p>
                        <h4 class="card-title">رقم الجوال</h4>
                        <p class="card-text">
                        <form action="<?php root('donors'); ?>/validate" method="post" id="login">
                            <div class="msg"></div>
                            <div class="form-group">
                                <input dir="ltr" class="form-control" name="mobile" type="text" placeholder="Mobile num" id="mobile" data-inputmask="'mask': '9999999999'">
                            </div>
                            <div class="col-12 mt-4 mb-4">
                                <div class="g-recaptcha" data-sitekey="6LcVHY8bAAAAAMlrDHrlL1G-22ySTHpAFRYDZlQy" style="margin:auto; max-width:305px;"></div>
                                <span class="text-danger"><?= $data['captcha_error'] ?? ''; ?></span>
                            </div>
                            <button class="btn btn-dark m-2 px-5" name="login" type="submit" data-toggle="modal" data-target="#sendcode">ارسال </button>
                        </form>
                        <div class="col-md-12 w-100 text-center mt-3" id="register">
                            <span>ليس لديك حساب ؟</span><a href="/donors/register" class="text-primary"> إنشاء حساب</a>
                        </div>
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
                                        <form method="post" action="<?php root('projects'); ?>" id="active-code">
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