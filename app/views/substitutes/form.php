<?php require APPROOT . '/app/views/inc/header.php'; ?>
<style>
    .btn-primary {
        background-color: #a3bc40 !important;
        border-color: #a3bc40;
    }
</style>
<div class="container bg-light text-right py-2">
    <?php flash('msg'); ?>

    <div class="row justify-content-md-center">
      
        <div class="col-lg-6 col-sm-12 py-5">
            <div class="text-center py-2">
                <h4 class="text-secondary h5"> بيانات الطلب</h4>
            </div>
            <form action="<?php URLROOT . '/Substitutes/index'; ?>" method="post" enctype="multipart/form-data" accept-charset="utf-8">
            <div class="col-lg-12 col-sm-12 col-xs-12">
                <div class="form-group  <?php echo (empty($data['full_name_error'])) ?: 'has-error'; ?>">
                    <label class="control-label" for="pageTitle">الاسم بالكامل : </label>
                    <div class="has-feedback">
                        <input type="text" class="form-control <?php if (!empty($data['full_name_error'])) echo 'is-invalid'; ?>" name="full_name" placeholder="الاسم بالكامل" value="<?php echo $data['full_name']; ?>">
                        <span class="invalid-feedback"><?php echo $data['full_name_error']; ?></span>
                    </div>
                </div>
                <div class="form-group  <?php echo (empty($data['email_error'])) ?: 'has-error'; ?>">
                    <label class="control-label" for="pageTitle">البريد الالكتروني : </label>
                    <div class="has-feedback">
                        <input type="text" class="form-control <?php if (!empty($data['email_error'])) echo 'is-invalid'; ?>" name="email" placeholder=" البريد الالكتروني" value="<?php echo $data['email']; ?>">
                        <span class="fa fa-edit form-control-feedback" aria-hidden="true"></span>
                        <span class="invalid-feedback"><?php echo $data['email_error']; ?></span>
                    </div>
                </div>
                <div class="form-group   <?php echo (empty($data['phone_error'])) ?: 'has-error'; ?>">
                    <label class="control-label" for="pageTitle">رقم الجوال : </label>
                    <div class="has-feedback">
                        <input type="text" class="form-control <?php if (!empty($data['phone_error'])) echo 'is-invalid'; ?>" name="phone"  placeholder="0500000000" id="mobile" data-inputmask="'mask': '9999999999'" value="<?php echo $data['phone']; ?>">
                        <span class="fa fa-edit form-control-feedback" aria-hidden="true"></span>
                        <span class="invalid-feedback"><?php echo $data['phone_error']; ?></span>
                    </div>
                </div>
                <div class="form-group   <?php echo (empty($data['identity_error'])) ?: 'has-error'; ?>">
                    <label class="control-label" for="pageTitle">رقم الهوية : </label>
                    <div class="has-feedback">
                        <input type="text" class="form-control <?php if (!empty($data['identity_error'])) echo 'is-invalid'; ?>" name="identity" placeholder="رقم الهوية" value="<?php echo $data['identity']; ?>">
                        <span class="invalid-feedback"><?php echo $data['identity_error']; ?></span>
                    </div>
                </div>
                <div class="form-group <?php echo (!empty($data['image_error'])) ? 'has-error' : ''; ?>">
                    <label class="control-label" for="imageUpload">صورة الهوية : </label>
                    <div class="has-feedback input-group">
                        <span class="input-group-btn">
                            <span class="btn btn-dark" onclick="$(this).parent().find('input[type=file]').click();">اختار الملف</span>
                            <input name="image" value="<?php echo ($data['image']); ?>" onchange="$(this).parent().parent().find('.form-control').html($(this).val().split(/[\\|/]/).pop());" style="display: none;" type="file">
                        </span>
                        <span class="form-control <?php if (!empty($data['image_error'])) echo 'is-invalid'; ?>"><small><?php echo empty($data['image']) ? 'قم بأختيار صورة مناسبة' : $data['image']; ?></small></span>
                    </div>
                    <div class="invalid-feedback"><?php echo $data['image_error']; ?></div>
                </div>
                
                <div class="form-group  <?php echo (empty($data['nationality_error'])) ?: 'has-error'; ?>">
                    <label class="control-label" for="pageTitle">الجنسية : </label>
                    <div class="has-feedback">
                        <input type="text" class="form-control <?php if (!empty($data['nationality_error'])) echo 'is-invalid'; ?>" name="nationality" placeholder=" الجنسية" value="<?php echo $data['nationality']; ?>">
                        <span class="fa fa-edit form-control-feedback " aria-hidden="true"></span>
                        <span class="invalid-feedback"><?php echo $data['nationality_error']; ?></span>
                    </div>
                </div>
                <div class="form-group  <?php echo (empty($data['gender_error'])) ?: 'has-error'; ?>">
                    <label class="control-label" for="pageTitle">الجنس : </label>
                    <div class="has-feedback">
                        <select class="form-control <?php if (!empty($data['gender_error'])) echo 'is-invalid'; ?>" name="gender" id="gender">
                            <option <?php if ($data['gender'] == "ذكر") echo  'selected'; ?> value="ذكر">ذكر</option>
                            <option <?php if ($data['gender'] == "انثي") echo  'selected'; ?> value="انثي">انثي</option>
                        </select>
                        <span class="invalid-feedback"><?php echo $data['gender_error']; ?></span>
                    </div>
                </div>
                <div class="form-group  <?php echo (empty($data['languages_error'])) ?: 'has-error'; ?>">
                    <label class="control-label" for="pageTitle">اللغة : </label>
                    <div class="has-feedback">
                        <div class="row">
                            <div class="col-md-3">
                                <input type="checkbox" id="languages" name="languages[]" value="عربي" <?php if (in_array("عربي", $data['languages']) ) echo  'checked'; ?>>
                                <label for="عربي"> عربي</label><br>
                            </div>
                            <div class="col-md-3">
                                <input type="checkbox" id="languages" name="languages[]" value="انجليزي" <?php if (in_array("انجليزي", $data['languages']) ) echo  'checked'; ?>>
                                <label for="انجليزي"> انجليزي </label><br>
                            </div>
                            <div class="col-md-3">
                                <input type="checkbox" id="languages" name="languages[]" value="اوردو" <?php if (in_array( "اوردو", $data['languages']) ) echo  'checked'; ?>>
                                <label for="اوردو"> اوردو</label><br>
                            </div>
                        </div>
                    
                        <span class="invalid-feedback"><?php echo $data['languages_error']; ?></span>
                    </div>
                </div>


            </div>

            <div class="col-xs-12">
                <button type="submit" name="submit" class="btn btn-success">أضف
                    <i class="fa fa-save"> </i></button>
                <button type="reset" class="btn btn-danger">مسح
                    <i class="fa fa-trash "> </i></button>
            </div>
        </form>
        </div>

    </div>
</div>

<?php
$data['settings']['site']->footer_code .= '<script src="https://www.google.com/recaptcha/api.js" async defer></script>';
require APPROOT . '/app/views/inc/footer.php';
?>