<?php require APPROOT . '/app/views/inc/header.php'; ?>
<div class="text-center py-5 mb-0 undermenu  bg-success text-light h3 bg-battern">
    <h3 class="py-4 mt-4"> إضافة متطوع بالجمعية </h3>
</div>
<div class="bg-light">
    <div class="container text-right py-2">
        <?php flash('msg'); ?>
        <div class="row justify-content-md-center">
            <div class="col-lg-12 py-3">
                <?php if (@exist($data['settings']['notifications']->volunteerContent)) echo $data['settings']['notifications']->volunteerContent; ?>
            </div>
            <div class="col-lg-6 col-sm-12 py-5">
                <form action="<?php echo URLROOT . '/pages/volunteers'; ?>" method="post" enctype="multipart/form-data" accept-charset="utf-8" class="needs-validation">
                    <div class="form-group">
                        <label class="control-label" for="pageTitle">اسم المتطوع : </label>
                        <input type="text" class="form-control <?php if (!empty($data['full_name_error'])) echo 'is-invalid'; ?>" name="full_name" placeholder="الاسم بالكامل" value="<?php echo $data['full_name']; ?>">
                        <span class="invalid-feedback"><?php echo $data['full_name_error']; ?></span>
                    </div>
                    <div class="form-group">
                        <label class="control-label" for="pageTitle">رقم الهوية : </label>
                        <input type="text" class="form-control <?php if (!empty($data['identity_error'])) echo 'is-invalid'; ?>" name="identity" placeholder="رقم الهوية" value="<?php echo $data['identity']; ?>">
                        <span class="invalid-feedback"><?php echo $data['identity_error']; ?></span>
                    </div>
                    <div class="form-group <?php echo (!empty($data['image_error'])) ? 'is-invalid' : ''; ?>">
                        <label class="control-label" for="imageUpload">صورة الهوية : </label>
                        <div class="has-feedback input-group">
                            <span class="input-group-btn">
                                <span class="btn btn-primary" onclick="$(this).parent().find('input[type=file]').click();">اختار الملف</span>
                                <input name="image" value="<?php echo ($data['image']); ?>" onchange="$(this).parent().parent().find('.form-control').html($(this).val().split(/[\\|/]/).pop());" style="display: none;" type="file">
                            </span>
                            <span class="form-control"><small><?php echo empty($data['image']) ? ' قم بأختيار صورة مناسبةاو ملف PDF' : $data['image']; ?></small></span>
                        </div>
                        <div class="text-danger"><?php echo $data['image_error']; ?></div>
                    </div>
                    <div class="form-group">
                        <label class="control-label" for="pageTitle">رقم الجوال : </label>
                        <input type="text" class="form-control <?php if (!empty($data['phone_error'])) echo 'is-invalid'; ?>" name="phone" placeholder="رقم الجوال" value="<?php echo $data['phone']; ?>">
                        <span class="invalid-feedback"><?php echo $data['phone_error']; ?></span>
                    </div>
                    <div class="form-group">
                        <label class="control-label" for="pageTitle">الجنسية : </label>
                        <input type="text" class="form-control <?php if (!empty($data['nationality_error'])) echo 'is-invalid'; ?>" name="nationality" placeholder=" الجنسية" value="<?php echo $data['nationality']; ?>">
                        <span class="invalid-feedback"><?php echo $data['nationality_error']; ?></span>
                    </div>
                    <div class="form-group">
                        <label class="control-label" for="pageTitle">الجنس : </label>
                        <select class="form-control <?php if (!empty($data['gender_error'])) echo 'is-invalid'; ?>" name="gender" id="gender">
                            <option <?php if ($data['gender'] == "ذكر") echo  'selected'; ?> value="ذكر">ذكر</option>
                            <option <?php if ($data['gender'] == "انثي") echo  'selected'; ?> value="انثي">انثي</option>
                        </select>
                        <span class="invalid-feedback"><?php echo $data['nationality_error']; ?></span>
                    </div>
                    <div class="form-group">
                        <label class="control-label" for="pageTitle">البريد الالكتروني : </label>
                        <input type="text" class="form-control <?php if (!empty($data['email_error'])) echo 'is-invalid'; ?>" name="email" placeholder=" البريد الالكتروني" value="<?php echo $data['email']; ?>">
                        <span class="invalid-feedback"><?php echo $data['email_error']; ?></span>
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