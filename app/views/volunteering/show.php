<?php require APPROOT . '/app/views/inc/header.php'; ?>
<div class="text-center py-5 mb-0 undermenu  bg-success text-light h3 bg-battern">
    <h3 class="py-4 mt-4"> <?= $data['volunteerpage']->title; ?> </h3>
</div>
<div class="bg-light">
    <div class="container text-right py-2">
        <?php flash('msg'); ?>
        <div class="row justify-content-md-center">
            <div class="col-lg-6 col-sm-12 py-5">
                <form action="<?= URLROOT . '/volunteering/show/' . $data['volunteerpage']->volunteerpage_id; ?>" method="post" enctype="multipart/form-data" accept-charset="utf-8" class="needs-validation">
                    <div class="form-group">
                        <label class="control-label" for="pageTitle">اسم المتطوع : </label>
                        <input type="text" class="form-control <?php if (!empty($data['full_name_error'])) echo 'is-invalid'; ?>" name="full_name" placeholder="الاسم بالكامل" value="<?= $data['full_name']; ?>">
                        <span class="invalid-feedback"><?= $data['full_name_error']; ?></span>
                    </div>
                    <div class="form-group">
                        <label class="control-label" for="pageTitle">رقم الهوية : </label>
                        <input type="text" class="form-control <?php if (!empty($data['identity_error'])) echo 'is-invalid'; ?>" name="identity" placeholder="رقم الهوية" value="<?= $data['identity']; ?>">
                        <span class="invalid-feedback"><?= $data['identity_error']; ?></span>
                    </div>
                    <div class="form-group">
                        <label class="control-label" for="pageTitle">رقم الجوال : </label>
                        <input type="text" class="form-control <?php if (!empty($data['phone_error'])) echo 'is-invalid'; ?>" name="phone" placeholder="رقم الجوال" value="<?= $data['phone']; ?>">
                        <span class="invalid-feedback"><?= $data['phone_error']; ?></span>
                    </div>
                    <div class="form-group">
                        <label class="control-label" for="pageTitle">البريد الالكتروني : </label>
                        <input type="text" class="form-control <?php if (!empty($data['email_error'])) echo 'is-invalid'; ?>" name="email" placeholder=" البريد الالكتروني" value="<?= $data['email']; ?>">
                        <span class="invalid-feedback"><?= $data['email_error']; ?></span>
                    </div>
                    <div class="form-group">
                        <div class="g-recaptcha" data-sitekey="6LcVHY8bAAAAAMlrDHrlL1G-22ySTHpAFRYDZlQy"></div>
                        <span class="text-danger"><?= $data['captcha_error']; ?></span>
                    </div>
                    <div class="col-xs-12 text-center">
                        <input type="hidden" name="volunteerpage_id" value="<?= $data['volunteerpage']->volunteerpage_id; ?>">
                        <button type="submit" name="submit" class="btn btn-primary px-5 py-2"> ارسال الطلب
                            <i class="fa fa-save"> </i></button>
                    </div>
                    <br>
                </form>
            </div>
        </div>
    </div>
</div>
<?php
$data['settings']['site']->footer_code .= '<script src="https://www.google.com/recaptcha/api.js" async defer></script>';
require APPROOT . '/app/views/inc/footer.php';
?>