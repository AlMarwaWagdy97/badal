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
    <?php flash('manager_msg'); ?>
    <div class="page-title">
        <div class="title_right">
            <h3><?php echo $data['page_title']; ?> <small>اضافة مدير لمتجر </small></h3>
        </div>
        <div class="title_left">
            <a href="<?php echo ADMINURL; ?>/managers" class="btn btn-success pull-left">عودة <i class="fa fa-reply"></i></a>
        </div>
    </div>

    <div class="clearfix"></div>

    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">

            <form action="<?php echo ADMINURL . '/managers/add'; ?>" method="post" enctype="multipart/form-data" accept-charset="utf-8">
                <div class="form-group <?php echo (!empty($data['name_error'])) ? 'has-error' : ''; ?>">
                    <label class="control-label" for="pageTitle">اسم المدير : </label>
                    <div class="has-feedback">
                        <input type="text" id="pageTitle" class="form-control" name="name" placeholder="اسم المدير" value="<?php echo $data['name']; ?>">
                        <span class="fa fa-edit form-control-feedback" aria-hidden="true"></span>
                        <span class="help-block"><?php echo $data['name_error']; ?></span>
                    </div>
                </div>
                <div class="form-group <?php echo (!empty($data['email_error'])) ? 'has-error' : ''; ?>">
                    <label class="control-label" for="pageTitle">بريد المدير : </label>
                    <div class="has-feedback">
                        <input type="email" id="pageTitle" class="form-control" name="email" placeholder="بريد المدير" value="<?php echo $data['email']; ?>">
                        <span class="fa fa-edit form-control-feedback" aria-hidden="true"></span>
                        <span class="help-block"><?php echo $data['email_error']; ?></span>
                    </div>
                </div>
                <div class="form-group <?php echo (!empty($data['password_error'])) ? 'has-error' : ''; ?>">
                    <label class="control-label" for="pageTitle">كلمة المرور : </label>
                    <div class="has-feedback">
                        <input type="password" id="pageTitle" class="form-control" name="password" placeholder="كلمة المرور" value="<?php echo $data['password']; ?>">
                        <span class="fa fa-edit form-control-feedback" aria-hidden="true"></span>
                        <span class="help-block"><?php echo $data['password_error']; ?></span>
                    </div>
                </div>
                <div class="form-group col-xs-12 <?php echo (!empty($data['status_error'])) ? 'has-error' : ''; ?>">
                    <label class="control-label">حالة المدير :</label>
                    <div class="radio">
                        <label>
                            <input type="radio" class="flat" <?php echo ($data['status'] == 1) ? 'checked' : ''; ?> value="1" name="status"> مفعلة
                        </label>
                        <label>
                            <input type="radio" class="flat" <?php echo ($data['status'] == '0') ? 'checked' : ''; ?> value="0" name="status"> معطلة
                        </label>
                        <span class="help-block"><?php echo $data['status_error']; ?></span>
                    </div>
                </div>
                <h2 class="page-header col-lg-12">الصلاحيات</h2>
                <div class="row">
                    <div class="col-sm-2"></div>
                    <label onclick="selectAll()" class=" col-sm-2 btn btn-success"> تحديد الكل</label>
                    <div class="col-sm-1"></div>
                    <label onclick="selectNon()" class=" col-sm-2 btn btn-success"> الغاء تحديد الكل</label>
                    <script>
                        function selectAll() {
                            $('.prevlages input[type="checkbox"]').prop("checked", "checked");
                            $('.icheckbox_flat-green').addClass("checked");
                        }

                        function selectNon() {
                            $('.prevlages input[type="checkbox"]').removeAttr('checked');
                            $('.icheckbox_flat-green').removeClass("checked");
                        }
                    </script>
                </div>
                <hr class="clear" />
                <div class="form-group prevlages">
                    <ul class="to_do">
                        <?php foreach ($data['storesList'] as $store) : ?>
                            <li class="col-lg-3 col-md-4 col-sm-6">
                                <p><input type="checkbox" class="flat" <?php echo in_array($store->store_id, $data['stores'])? 'checked': ""; ?> value="<?php echo $store->store_id; ?>" name="stores[]"> <?php echo $store->name; ?> </p>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
                <div class="col-md-9 col-sm-9 col-xs-12 col-md-offset-3">
                    <button type="submit" name="submit" class="btn btn-success">أضف <i class="fa fa-save"> </i></button>
                    <button type="reset" class="btn btn-danger">مسح <i class="fa fa-trash "> </i></button>
                </div>

            </form>

        </div>
    </div>
</div>
<?php
// loading plugin
$data['footer'] = '<script src="' . ADMINURL . '/template/default/vendors/jquery.tagsinput/src/jquery.tagsinput.js"></script>';


require ADMINROOT . '/views/inc/footer.php';
