<?php
/*
 * Copyright (C) 2018 Easy CMS Framework Ahmed Elmahdy
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License
 * @license    https://opensource.org/licenses/GPL-3.0
 *
 * @package    Easy CMS MVC framework
 * @author     Ahmed Elmahdy
 * @link       https://ahmedx.com
 *
 * For more information about the author , see <http://www.ahmedx.com/>.
 */

// loading plugin style
$data['header'] = '';
header("Content-Type: text/html; charset=utf-8");

require ADMINROOT . '/views/inc/header.php';
?>

<!-- page content -->

<div class="right_col" role="main">
    <div class="clearfix"></div>
    <?php flash('volunteer_msg'); ?>
    <div class="page-title">
        <div class="title_right">
            <h3><?php echo $data['page_title']; ?> <small>التعديل علي متطوع </small></h3>
        </div>
        <div class="title_left">
            <a href="<?php echo ADMINURL; ?>/volunteers" class="btn btn-success pull-left">عودة <i class="fa fa-reply"></i></a>
        </div>
    </div>

    <div class="clearfix"></div>

    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <form action="<?php echo ADMINURL . '/volunteers/edit/' . $data['volunteer_id']; ?>" method="post" enctype="multipart/form-data" accept-charset="utf-8">
                <div class="col-lg-8 col-sm-12 col-xs-12">
                    <div class="form-group  <?php echo (empty($data['full_name_error'])) ?: 'has-error'; ?>">
                        <label class="control-label" for="pageTitle">الاسم بالكامل : </label>
                        <div class="has-feedback">
                            <input type="text" class="form-control" name="full_name" placeholder="الاسم بالكامل" value="<?php echo $data['full_name']; ?>">
                            <span class="fa fa-edit form-control-feedback" aria-hidden="true"></span>
                            <span class="help-block"><?php echo $data['full_name_error']; ?></span>
                        </div>
                    </div>
                    <div class="form-group   <?php echo (empty($data['identity_error'])) ?: 'has-error'; ?>">
                        <label class="control-label" for="pageTitle">رقم الهوية : </label>
                        <div class="has-feedback">
                            <input type="text" class="form-control" name="identity" placeholder="رقم الهوية" value="<?php echo $data['identity']; ?>">
                            <span class="fa fa-edit form-control-feedback" aria-hidden="true"></span>
                            <span class="help-block"><?php echo $data['identity_error']; ?></span>
                        </div>
                    </div>
                    <div class="form-group <?php echo (!empty($data['image_error'])) ? 'has-error' : ''; ?>">
                        <label class="control-label" for="imageUpload">صورة الهوية : </label>
                        <div class="has-feedback input-group">
                            <span class="input-group-btn">
                                <span class="btn btn-dark" onclick="$(this).parent().find('input[type=file]').click();">اختار الملف</span>
                                <input name="image" value="<?php echo ($data['image']); ?>" onchange="$(this).parent().parent().find('.form-control').html($(this).val().split(/[\\|/]/).pop());" style="display: none;" type="file">
                            </span>
                            <span class="form-control"><small><?php echo empty($data['image']) ? 'قم بأختيار صورة مناسبة' : $data['image']; ?></small></span>
                        </div>
                        <div class="help-block"><?php echo $data['image_error']; ?></div>
                    </div>
                    <div class="form-group   <?php echo (empty($data['phone_error'])) ?: 'has-error'; ?>">
                        <label class="control-label" for="pageTitle">رقم الجوال : </label>
                        <div class="has-feedback">
                            <input type="text" class="form-control" name="phone" placeholder="رقم الجوال" value="<?php echo $data['phone']; ?>">
                            <span class="fa fa-edit form-control-feedback" aria-hidden="true"></span>
                            <span class="help-block"><?php echo $data['phone_error']; ?></span>
                        </div>
                    </div>
                    <div class="form-group  <?php echo (empty($data['nationality_error'])) ?: 'has-error'; ?>">
                        <label class="control-label" for="pageTitle">الجنسية : </label>
                        <div class="has-feedback">
                            <input type="text" class="form-control" name="nationality" placeholder=" الجنسية" value="<?php echo $data['nationality']; ?>">
                            <span class="fa fa-edit form-control-feedback" aria-hidden="true"></span>
                            <span class="help-block"><?php echo $data['nationality_error']; ?></span>
                        </div>
                    </div>
                    <div class="form-group  <?php echo (empty($data['nationality_error'])) ?: 'has-error'; ?>">
                        <label class="control-label" for="pageTitle">الجنس : </label>
                        <div class="has-feedback">
                            <select class="form-control" name="gender" id="gender">
                                <option <?php if ($data['gender'] == "ذكر") echo  'selected'; ?> value="ذكر">ذكر</option>
                                <option <?php if ($data['gender'] == "انثي") echo  'selected'; ?> value="انثي">انثي</option>
                            </select>
                            <span class="help-block"><?php echo $data['nationality_error']; ?></span>
                        </div>
                    </div>
                    <div class="form-group  <?php echo (empty($data['email_error'])) ?: 'has-error'; ?>">
                        <label class="control-label" for="pageTitle">البريد الالكتروني : </label>
                        <div class="has-feedback">
                            <input type="text" class="form-control" name="email" placeholder=" البريد الالكتروني" value="<?php echo $data['email']; ?>">
                            <span class="fa fa-edit form-control-feedback" aria-hidden="true"></span>
                            <span class="help-block"><?php echo $data['email_error']; ?></span>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-sm-12 col-xs-12 options">
                    <h4>الاعدادات</h4>
                    <div class="accordion">
                        <div class="card">
                            <div class="card-header" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                <span> الاعدادات </span>
                            </div>
                            <div id="collapseOne" class="collapse card-body in" aria-labelledby="headingOne">
                                <div class="form-group col-xs-12 <?php echo (!empty($data['status_error'])) ? 'has-error' : ''; ?>">
                                    <label class="control-label">الحالة :</label>
                                    <div class="radio">
                                        <label>
                                            <input type="radio" class="flat" <?php echo ($data['status'] == 1) ? 'checked' : ''; ?> value="1" name="status"> مقروء
                                        </label>
                                        <label>
                                            <input type="radio" class="flat" <?php echo ($data['status'] == '0') ? 'checked' : ''; ?> value="0" name="status"> غير مقروء
                                        </label>
                                        <span class="help-block"><?php echo $data['status_error']; ?></span>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                    <br><br>



                </div>




                <div class="col-md-9 col-sm-9 col-xs-12 col-md-offset-3">
                    <button type="submit" name="save" class="btn btn-success">تعديل
                        <i class="fa fa-save"> </i></button>
                    <button type="submit" name="submit" class="btn btn-success">تعديل وعودة
                        <i class="fa fa-save"> </i></button>
                    <button type="reset" class="btn btn-danger">مسح
                        <i class="fa fa-trash "> </i></button>
                </div>

            </form>
        </div>
    </div>
</div>

<?php
// loading plugin
$data['footer'] = '';

require ADMINROOT . '/views/inc/footer.php';
