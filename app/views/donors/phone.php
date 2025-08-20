<?php require APPROOT . '/app/views/inc/header.php'; ?>
<!-- Categories -->
<section id="donors" class="undermenu bg-light">
    <div class="container bg-white">
        <?php flash('msg'); ?>
        <div class="row mt-3">
            <div class="col-md-3">
                <?php require APPROOT . '/app/views/inc/donor-sidenavbar.php'; ?>
            </div>
            <div class="col-md-9">
                <div class="card mt-3 mb-3 card-info border-0 text-right" dir="rtl">
                    <div class="card-body h-100">
                        <h5 class="text-right mb-3"> تعديل رقم الجوال </h5>
                        <div class="card  edit-mobile m-3 p-3">
                            <form action="<?php root('donors'); ?>/editmobilepost" method="post" id="editmobile">
                                <div class="msg"></div>
                                <div class="form-group">
                                    <input type="hidden" name="donor_id" value="<?php echo @$data['donor']->id ?>" id="donor_id">
                                    <label for="">رقم الجوال</label>
                                    <input class="form-control" name="mobile" type="text" placeholder="Mobile num" id="mobile" required data-inputmask="'mask': '9999999999'" value="<?php echo @$data['donor']->mobile ?>">
                                </div>
                                <div class="col-12 mt-4 mb-4">
                                    <div class="g-recaptcha" data-sitekey="6LcVHY8bAAAAAMlrDHrlL1G-22ySTHpAFRYDZlQy" style="margin:auto; max-width:305px;"></div>
                                    <span class="text-danger"><?= $data['captcha_error'] ?? ''; ?></span>
                                </div>
                                <div class="col-12 mt-4 mb-4 text-center">
                                    <button class="btn submit-button rounded-pill px-md-5 " type="submit" name="editmobile" data-toggle="modal" data-target="#sendcode">تعديل </button>
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
                                            <form method="post" action="<?php root('donors'); ?>" id="active-code-editmobile">
                                                <input class="form-control" name="code" type="text" placeholder="code" aria-label="code">
                                                <input class="btn btn-success mt-2 float-right" name="verify" type="submit" value="تأكيد">
                                                <input class="btn btn-danger mt-2 float-left" name="verify" type="submit" data-dismiss="modal" value="غلق">
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</section>
<!-- end Categories -->
<?php
    $data['settings']['site']->footer_code .= '<script src="https://www.google.com/recaptcha/api.js?hl=ar" async defer></script>';
    require APPROOT . '/app/views/inc/footer.php';
  ?>