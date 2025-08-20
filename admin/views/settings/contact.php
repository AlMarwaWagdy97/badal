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
                <div class="form-group col-md-12">
                    <label class="control-label" for="settingTitle">عنوان الاعداد : </label>
                    <div class="has-feedback">
                        <input type="text" id="settingTitle" class="form-control" name="title" placeholder="عنوان الاعداد" value="<?php echo $data['title']; ?>">
                    </div>
                </div>
                <div class="form-group col-md-6">
                    <label class="control-label" for="settingTitle">رقم هاتف : </label>
                    <div class="has-feedback">
                        <input type="text" id="settingTitle" class="form-control" name="value[phone]" placeholder="رقم هاتف " value="<?php echo $data['value']->phone; ?>">
                    </div>
                </div>
                <div class="form-group col-md-6">
                    <label class="control-label" for="settingTitle">رقم هاتف 2 : </label>
                    <div class="has-feedback">
                        <input type="text" id="settingTitle" class="form-control" name="value[phone2]" placeholder="رقم هاتف 2" value="<?php echo $data['value']->phone2; ?>">
                    </div>
                </div>
                <div class="form-group col-md-4">
                    <label class="control-label" for="settingTitle">رقم جوال : </label>
                    <div class="has-feedback">
                        <input type="text" id="settingTitle" class="form-control" name="value[mobile]" placeholder="رقم جوال" value="<?php echo $data['value']->mobile; ?>">
                    </div>
                </div>
                <div class="form-group col-md-4">
                    <label class="control-label" for="settingTitle">رقم جوال 2 : </label>
                    <div class="has-feedback">
                        <input type="text" id="settingTitle" class="form-control" name="value[mobile2]" placeholder="رقم جوال 2" value="<?php echo $data['value']->mobile2; ?>">
                    </div>
                </div>
                <div class="form-group col-md-4">
                    <label class="control-label" for="settingTitle">WhatsApp : </label>
                    <div class="has-feedback">
                        <input type="text" id="settingTitle" class="form-control" name="value[whatsapp]" placeholder="WhatsApp" value="<?php echo $data['value']->whatsapp; ?>">
                    </div>
                </div>
                <div class="form-group col-md-6">
                    <label class="control-label" for="settingTitle">رقم فاكس : </label>
                    <div class="has-feedback">
                        <input type="text" id="settingTitle" class="form-control" name="value[fax]" placeholder="رقم فاكس" value="<?php echo $data['value']->fax; ?>">
                    </div>
                </div>
                <div class="form-group col-md-6">
                    <label class="control-label">البريد الالكتروني : </label>
                    <div class="row">
                        <input type="text" id="email" class="form-control" name="value[email]" placeholder="البريد الالكتروني" value="<?php echo $data['value']->email; ?>">
                    </div>
                </div>
                <div class="form-group col-md-6">
                    <label class="control-label">العنوان : </label>
                    <div class="">
                        <textarea name="value[address]" class="form-control"><?php echo ($data['value']->address); ?></textarea>
                    </div>
                </div>
                <div class="form-group col-md-6">
                    <label class="control-label">الخريطة : </label>
                    <div class="">
                        <textarea name="value[map]" class="form-control"><?php echo ($data['value']->map); ?></textarea>
                    </div>
                </div>
                <fieldset class="form-group row ">
                    <legend class="col-form-legend col-sm-1-12">الشكاوى والمقترحات</legend>
                    <div class="form-group col-md-4">
                        <label class="control-label" for="settingTitle">رقم هاتف : </label>
                        <div class="has-feedback">
                            <input type="text" id="settingTitle" class="form-control" name="value[cphone]" placeholder="رقم هاتف " value="<?php echo $data['value']->cphone; ?>">
                        </div>
                    </div>
                    <div class="form-group col-md-2">
                        <label class="control-label" for="settingTitle">رقم التحويلة : </label>
                        <div class="has-feedback">
                            <input type="text" id="settingTitle" class="form-control" name="value[ctphone]" placeholder="رقم التحويلة " value="<?php echo $data['value']->ctphone; ?>">
                        </div>
                    </div>
                    <div class="form-group col-md-6">
                        <label class="control-label" for="settingTitle">رقم جوال : </label>
                        <div class="has-feedback">
                            <input type="text" id="settingTitle" class="form-control" name="value[cmobile]" placeholder="رقم جوال " value="<?php echo $data['value']->cmobile; ?>">
                        </div>
                    </div>
                    <div class="form-group col-md-6">
                        <label class="control-label" for="settingTitle"> فاكس : </label>
                        <div class="has-feedback">
                            <input type="text" id="settingTitle" class="form-control" name="value[cfax]" placeholder=" فاكس " value="<?php echo $data['value']->cfax; ?>">
                        </div>
                    </div>
                    <div class="form-group col-md-6">
                        <label class="control-label" for="settingTitle">العنوان : </label>
                        <div class="has-feedback">
                            <input type="text" id="settingTitle" class="form-control" name="value[caddress]" placeholder="العنوان " value="<?php echo $data['value']->caddress; ?>">
                        </div>
                    </div>
                </fieldset>
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
