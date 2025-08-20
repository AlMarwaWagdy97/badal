<?php require APPROOT . '/app/views/inc/header.php'; ?>
<div class="text-center py-5 mb-0 undermenu  bg-success text-light h3 bg-battern">
    <h3 class="py-4 mt-4"> إضافة تبرع عيني </h3>
</div>
<div class="bg-light">
    <div class="container text-right py-2">
        <?php flash('msg'); ?>
        <div class="row justify-content-md-center">
            <div class="col-lg-12 py-3">
                <?php if (@exist($data['settings']['notifications']->inkindContent)) echo $data['settings']['notifications']->inkindContent; ?>
            </div>
            <div class="col-lg-6 col-sm-12 py-5">
                <form action="<?php echo URLROOT . '/pages/inkindes'; ?>" method="post" enctype="multipart/form-data" accept-charset="utf-8" class="needs-validation">
                    <div class="form-group">
                        <label class="control-label" for="pageTitle">اسم المتبرع : </label>
                        <input type="text" class="form-control <?php if (!empty($data['full_name_error'])) echo 'is-invalid'; ?>" name="full_name" placeholder="الاسم بالكامل" value="<?php echo $data['full_name']; ?>">
                        <span class="invalid-feedback"><?php echo $data['full_name_error']; ?></span>
                    </div>
                    <div class="form-group">
                        <label class="control-label" for="pageTitle">البريد الالكتروني : </label>
                        <input type="text" class="form-control <?php if (!empty($data['email_error'])) echo 'is-invalid'; ?>" name="email" placeholder=" البريد الالكتروني" value="<?php echo $data['email']; ?>">
                        <span class="invalid-feedback"><?php echo $data['email_error']; ?></span>
                    </div>
                    <div class="form-group">
                        <label class="control-label" for="pageTitle">رقم الجوال : </label>
                        <input type="text" class="form-control <?php if (!empty($data['phone_error'])) echo 'is-invalid'; ?>" name="phone" placeholder="رقم الجوال" value="<?php echo $data['phone']; ?>">
                        <span class="invalid-feedback"><?php echo $data['phone_error']; ?></span>
                    </div>
                    <div class="form-group">
                        <label class="control-label" for="pageTitle">الشارع : </label>
                        <input type="text" class="form-control <?php if (!empty($data['street_error'])) echo 'is-invalid'; ?>" name="street" placeholder=" المدينة" value="<?php echo $data['street']; ?>">
                        <span class="invalid-feedback"><?php echo $data['street_error']; ?></span>
                    </div>
                    <div class="form-group">
                        <label class="control-label" for="pageTitle">الحي : </label>
                        <input type="text" class="form-control <?php if (!empty($data['district_error'])) echo 'is-invalid'; ?>" name="district" placeholder="عنوان الحي" value="<?php echo $data['district']; ?>">
                        <span class="invalid-feedback"><?php echo $data['district_error']; ?></span>
                    </div>
                    <div class="form-group">
                        <label class="control-label">التفاصيل : </label>
                        <textarea rows="5" name="message" class="form-control <?php if (!empty($data['message_error'])) echo 'is-invalid'; ?>"><?php echo ($data['message']); ?></textarea>
                        <span class="invalid-feedback"><?php echo $data['message_error']; ?></span>
                    </div>
                    <div class="form-group d-flex">
                        <img src="<?php echo URLROOT; ?>/pages/captcha" alt="captcha" width="100px">
                        <input type="text" class="form-control mr-2 <?php if (!empty($data['captcha_error'])) echo 'is-invalid'; ?>" name="captcha" placeholder=" كود التحقق">
                        <span class="invalid-feedback p-2"><?php echo $data['captcha_error']; ?></span>
                    </div>
                    <div class="col-xs-12 text-center">
                        <button type="submit" name="submit" class="btn btn-primary px-5 py-2"> ارسال الطلب
                            <i class="fa fa-save"> </i></button>
                    </div>
                    <br>
                </form>
            </div>
        </div>
    </div>
</div>
<?php require APPROOT . '/app/views/inc/footer.php'; ?>