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
                <div class="form-group">
                    <label class="control-label" for="settingTitle">بريد استقبال تنبيهات الطلبات : </label>
                    <div class="has-feedback">
                        <input type="text" id="settingTitle" class="form-control" name="value[donation_email]" placeholder="بريد استقبال تنبيهات الطلبات" value="<?php echo $data['value']->donation_email; ?>">
                    </div>
                </div>
                <div class="form-group col-xs-12 ">
                    <label class="control-label">الارسال عن طريق ال SMTP :</label>
                    <div class="radio">
                        <label>
                            <input type="radio" class="flat" <?php echo ($data['value']->smtp == 1) ? 'checked' : ''; ?> value="1" name="value[smtp]"> مفعلة
                        </label>
                        <label>
                            <input type="radio" class="flat" <?php echo ($data['value']->smtp == '0') ? 'checked' : ''; ?> value="0" name="value[smtp]"> معلقة
                        </label>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label" for="host">سيرفر الارسال عن طريق SMTP : </label>
                    <div class="has-feedback">
                        <input type="text" id="host" class="form-control" name="value[host]" placeholder="سيرفر الارسال عن طريق SMTP" value="<?php echo $data['value']->host; ?>">
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label" for="user">اسم المستخدم ل SMTP : </label>
                    <div class="has-feedback">
                        <input type="text" id="user" class="form-control" name="value[user]" placeholder="اسم المستخدم ل  SMTP" value="<?php echo $data['value']->user; ?>">
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label" for="password">كلمة المرور ل SMTP : </label>
                    <div class="has-feedback">
                        <input type="text" id="password" class="form-control" name="value[password]" placeholder="كلمة المرور ل SMTP" value="<?php echo $data['value']->password; ?>">
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label" for="port">port SMTP : </label>
                    <div class="has-feedback">
                        <input type="text" id="port" class="form-control" name="value[port]" placeholder="port SMTP" value="<?php echo $data['value']->port; ?>">
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label" for="settingTitle">بريد الارسال : </label>
                    <div class="has-feedback">
                        <input type="text" id="settingTitle" class="form-control" name="value[sending_email]" placeholder="بريد الارسال" value="<?php echo $data['value']->sending_email; ?>">
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label" for="settingTitle">اسم المرسل : </label>
                    <div class="has-feedback">
                        <input type="text" id="settingTitle" class="form-control" name="value[sending_name]" placeholder="اسم المرسل" value="<?php echo $data['value']->sending_name; ?>">
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
