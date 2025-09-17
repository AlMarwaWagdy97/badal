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
    <?php flash('donor_msg');?>
    <div class="page-title">
        <div class="title_right">
            <h3><?php echo $data['page_title']; ?> <small>تعديل بيانات طالب خدمة </small></h3>
        </div>
        <div class="title_left">
            <a href="<?php echo ADMINURL; ?>/donors" class="btn btn-success pull-left">عودة <i class="fa fa-reply"></i></a>
        </div>
    </div>

    <div class="clearfix"></div>

    <div class="row">
        <form action="<?php echo ADMINURL . '/donors/edit/' . $data['donor_id']; ?>" method="post" enctype="multipart/form-data" accept-charset="utf-8" >
        <div class="col-xs-12 form-group <?php echo (!empty($data['full_name_error'])) ? 'has-error' : ''; ?>">
                <label class="control-label" for="pageTitle">اسم طالب الخدمة : </label>
                <div class="has-feedback">
                    <input type="text" id="pageTitle" class="form-control" name="full_name" placeholder="اسم طالب الخدمة" value="<?php echo $data['full_name']; ?>">
                    <span class="fa fa-edit form-control-feedback" aria-hidden="true"></span>
                    <span class="help-block"><?php echo $data['full_name_error']; ?></span>
                </div>
            </div>
            <div class="col-xs-12 form-group ">
                <label class="control-label" for="email">البريد الالكتروني : </label>
                <div class="has-feedback">
                    <input type="email" id="email" class="form-control" name="email" placeholder="بريد طالب الخدمة" value="<?php echo $data['email']; ?>">
                    <span class="fa fa-envelope form-control-feedback" aria-hidden="true"></span>
                </div>
            </div>
            <div class="col-xs-12 form-group <?php echo (!empty($data['mobile_error'])) ? 'has-error' : ''; ?>">
                <label class="control-label" for="mobile">رقم الجوال : </label>
                <div class="has-feedback">
                    <input type="text" id="mobile" class="form-control" name="mobile" placeholder="رقم الجوال" value="<?php echo $data['mobile']; ?>">
                    <span class="fa fa-phone form-control-feedback" aria-hidden="true"></span>
                    <span class="help-block"><?php echo $data['mobile_error']; ?></span>
                </div>
            </div>
            <div class="col-xs-12 form-group <?php echo (!empty($data['identity_error'])) ? 'has-error' : ''; ?>">
                <label class="control-label" for="identity"> رقم الهوية : </label>
                <div class="has-feedback">
                    <input type="text" id="identity" class="form-control" name="identity" placeholder="رقم الهوية" value="<?php echo $data['identity']; ?>">
                    <span class="fa fa-phone form-control-feedback" aria-hidden="true"></span>
                    <span class="help-block"><?php echo $data['identity_error']; ?></span>
                </div>
            </div>
            <div class="col-xs-12 form-group">
                <label class="control-label" for="mobile"> متجر فرعي : </label>
                <div class="has-feedback">
                    <select name="store_id" class="form-control">
                    <option value="">اختار متجر فرعي  </option>
                        <?php  if($data['stores']) {
                            foreach($data['stores'] as $store) { ?>
                                <option value="<?php echo $store->store_id; ?>" <?php echo ($store->store_id == $data['store_id']) ? " selected " : ''; ?>>
                                    <?php echo $store->name; ?>
                                </option>
                        <?php } 
                            } 
                        ?>
                    </select>
                </div>
            </div>
            <div class="col-xs-12 form-group ">
                <label class="control-label">حالة تفعيل الجوال  :</label>
                <div class="radio">
                    <label>
                        <input type="radio" class="flat" <?php echo ($data['mobile_confirmed'] == 'yes') ? 'checked' : ''; ?> value="yes" name="mobile_confirmed"> مفعل
                    </label>
                    <label>
                        <input type="radio" class="flat" <?php echo ($data['mobile_confirmed'] == 'no') ? 'checked' : ''; ?> value="no" name="mobile_confirmed"> غير مفعل
                    </label>
                </div>
            </div>
            <div class="col-xs-12 form-group <?php echo (!empty($data['status_error'])) ? 'has-error' : ''; ?>">
                <label class="control-label">حالة طالب الخدمة :</label>
                <div class="radio">
                    <label>
                        <input type="radio" class="flat" <?php echo ($data['status'] == 1) ? 'checked' : ''; ?> value="1" name="status"> نشط
                    </label>
                    <label>
                        <input type="radio" class="flat" <?php echo ($data['status'] == '0') ? 'checked' : ''; ?> value="0" name="status"> محظور
                    </label>
                    <span class="help-block"><?php echo $data['status_error']; ?></span>
                </div>
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
<?php
// loading plugin
$data['footer'] = '<script src="' . ADMINURL . '/template/default/vendors/jquery.tagsinput/src/jquery.tagsinput.js"></script>';

require ADMINROOT . '/views/inc/footer.php';
