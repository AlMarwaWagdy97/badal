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

<!-- setting content -->

<div class="right_col" role="main">
    <div class="clearfix"></div>
    <?php flash('setting_msg'); ?>
    <div class="setting-title">
        <div class="title_right">
            <h3><small>التعديل علي </small><?php echo $data['title']; ?> </h3>
        </div>
        <div class="title_left">
            <a href="<?php echo ADMINURL; ?>/settings" class="btn btn-success pull-left">عودة <i class="fa fa-reply"></i></a>
        </div>
    </div>
    <div class="clearfix"></div>
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <form action="<?php echo ADMINURL . '/settings/edit/' . $data['setting_id']; ?>" method="post" enctype="multipart/form-data" accept-charset="utf-8">
                <div class="form-group">
                    <label class="control-label" for="settingTitle">عنوان الاعداد : </label>
                    <div class="has-feedback">
                        <input type="text" id="settingTitle" class="form-control" name="title" placeholder="عنوان الاعداد" value="<?php echo $data['title']; ?>">
                    </div>
                </div>
                <div class="form-group col-xs-12 ">
                    <label class="control-label">نوع البوابة :</label>
                    <div class="radio">
                        <label>
                            <input type="radio" class="flat" <?php echo (@$data['value']->gateway == 'taqnyat') ? 'checked' : ''; ?> value="taqnyat" name="value[gateway]"> تقنيات
                        </label>
                        <label>
                            <input type="radio" class="flat" <?php echo (@$data['value']->gateway == 'other') ? 'checked' : ''; ?> value="0" name="value[gateway]"> اخري
                        </label>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label" for="settingTitle">رابط البوابة : </label>
                    <div class="has-feedback">
                        <input type="text" id="settingTitle" class="form-control" name="value[gateurl]" placeholder="رابط البوابة" value="<?php echo $data['value']->gateurl; ?>">
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label" for="settingTitle">اسم المستخدم : </label>
                    <div class="has-feedback">
                        <input type="text" id="settingTitle" class="form-control" name="value[sms_username]" placeholder="" value="<?php echo $data['value']->sms_username; ?>">
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label" for="settingTitle">اسم المرسل : </label>
                    <div class="has-feedback">
                        <input type="text" id="settingTitle" class="form-control" name="value[sender_name]" placeholder="" value="<?php echo $data['value']->sender_name; ?>">
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label" for="settingTitle">كلمة مرور البوابة : </label>
                    <div class="has-feedback">
                        <input type="text" id="settingTitle" class="form-control" name="value[sms_password]" placeholder="كلمة مرور البوابة" value="<?php echo $data['value']->sms_password; ?>">
                    </div>
                </div>

                <div class="form-group col-xs-12 ">
                    <label class="control-label">تفعيل البوابة :</label>
                    <div class="radio">
                        <label>
                            <input type="radio" class="flat" <?php echo ($data['value']->smsenabled == 1) ? 'checked' : ''; ?> value="1" name="value[smsenabled]"> مفعلة
                        </label>
                        <label>
                            <input type="radio" class="flat" <?php echo ($data['value']->smsenabled == '0') ? 'checked' : ''; ?> value="0" name="value[smsenabled]"> معلقة
                        </label>
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
</div>

<?php
// loading plugin
$data['footer'] = '<script src="' . ADMINURL . '/template/default/vendors/jquery.tagsinput/src/jquery.tagsinput.js"></script>' . "\n";

require ADMINROOT . '/views/inc/footer.php';
