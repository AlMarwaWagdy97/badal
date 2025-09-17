x<?php
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
                <div class="x_panel tile ">
                    <h4 class="x_title">رسالة بريدية لتأكيد استلام المبلغ</h4>
                    <div class="form-group col-xs-12 ">
                        <label class="control-label">تفعيل الارسال :</label>
                        <div class="radio">
                            <label>
                                <input type="radio" class="flat" <?php echo ($data['value']->confirm_enabled == 1) ? 'checked' : ''; ?> value="1" name="value[confirm_enabled]"> مفعلة
                            </label>
                            <label>
                                <input type="radio" class="flat" <?php echo ($data['value']->confirm_enabled == '0') ? 'checked' : ''; ?> value="0" name="value[confirm_enabled]"> معلقة
                            </label>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label" for="confirm_subject">عنوان الرسالة : </label>
                        <div class="has-feedback">
                            <input type="text" id="confirm_subject" class="form-control" name="value[confirm_subject]" placeholder="عنوان الرسالة" value="<?php echo $data['value']->confirm_subject; ?>">
                        </div>
                    </div>
                    <div class="form-group col-xs-12 ">
                        <br>
                        <button type="button" class="btn btn-primary" onclick="$('#confirm_msg').val($('#confirm_msg').val() +'[[name]]') ;return false;" value="">ارفاق الاسم </button>
                        <button type="button" class="btn btn-primary" onclick="$('#confirm_msg').val($('#confirm_msg').val() +'[[identifier]]') ;return false;" value="">ارفاق رقم الطلب </button>
                        <button type="button" class="btn btn-primary" onclick="$('#confirm_msg').val($('#confirm_msg').val() +'[[total]]') ;return false;" value="">ارفاق المبلغ </button>
                        <button type="button" class="btn btn-primary" onclick="$('#confirm_msg').val($('#confirm_msg').val() +'[[project]]') ;return false;" value="">ارفاق اسم المشروع </button>
                        <small class="red ">سيتم استبدال المتغير الخاص بالقيمة </small>
                    </div>
                    <div class="form-group col-md-12">

                        <label class="control-label">المحتوي : </label>
                        <div class="row">
                            <textarea id="confirm_msg" name="value[confirm_msg]" rows="6" class="form-control"><?php echo ($data['value']->confirm_msg); ?></textarea>
                        </div>
                    </div>
                </div>
                <div class="x_panel tile ">
                    <h4 class="x_title">رسالة بريديه تنبيه باستلام طلب طلب</h4>
                    <div class="form-group col-xs-12 ">
                        <label class="control-label">تفعيل الارسال :</label>
                        <div class="radio">
                            <label>
                                <input type="radio" class="flat" <?php echo ($data['value']->inform_enabled == 1) ? 'checked' : ''; ?> value="1" name="value[inform_enabled]"> مفعلة
                            </label>
                            <label>
                                <input type="radio" class="flat" <?php echo ($data['value']->inform_enabled == '0') ? 'checked' : ''; ?> value="0" name="value[inform_enabled]"> معلقة
                            </label>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label" for="inform_subject">عنوان الرسالة : </label>
                        <div class="has-feedback">
                            <input type="text" id="inform_subject" class="form-control" name="value[inform_subject]" placeholder="عنوان الرسالة" value="<?php echo $data['value']->inform_subject; ?>">
                        </div>
                    </div>
                    <div class="form-group col-xs-12 ">
                        <br>
                        <button type="button" class="btn btn-primary" onclick="$('#inform_msg').val($('#inform_msg').val() +'[[name]]') ;return false;" value="">ارفاق الاسم </button>
                        <button type="button" class="btn btn-primary" onclick="$('#inform_msg').val($('#inform_msg').val() +'[[identifier]]') ;return false;" value="">ارفاق رقم الطلب </button>
                        <button type="button" class="btn btn-primary" onclick="$('#inform_msg').val($('#inform_msg').val() +'[[total]]') ;return false;" value="">ارفاق المبلغ </button>
                        <button type="button" class="btn btn-primary" onclick="$('#inform_msg').val($('#inform_msg').val() +'[[project]]') ;return false;" value="">ارفاق اسم المشروع </button>
                        <small class="red ">سيتم استبدال المتغير الخاص بالقيمة </small>
                    </div>
                    <div class="form-group col-md-12">
                        <label class="control-label">المحتوي : </label>
                        <div class="row">
                            <textarea id="inform_msg" name="value[inform_msg]" rows="6" class="form-control"><?php echo ($data['value']->inform_msg); ?></textarea>
                        </div>
                    </div>
                </div>
                <div class="x_panel tile ">
                    <h4 class="x_title">رسالة SMS لتأكيد الطلب</h4>
                    <div class="form-group col-xs-12 ">
                        <label class="control-label">تفعيل الارسال :</label>
                        <div class="radio">
                            <label>
                                <input type="radio" class="flat" <?php echo ($data['value']->confirm_sms == 1) ? 'checked' : ''; ?> value="1" name="value[confirm_sms]"> مفعلة
                            </label>
                            <label>
                                <input type="radio" class="flat" <?php echo ($data['value']->confirm_sms == '0') ? 'checked' : ''; ?> value="0" name="value[confirm_sms]"> معلقة
                            </label>
                        </div>
                    </div>
                    <div class="form-group col-xs-12 ">
                        <br>
                        <button type="button" class="btn btn-primary" onclick="$('#confirm_sms_msg').val($('#confirm_sms_msg').val() +'[[name]]') ;return false;" value="">ارفاق الاسم </button>
                        <button type="button" class="btn btn-primary" onclick="$('#confirm_sms_msg').val($('#confirm_sms_msg').val() +'[[identifier]]') ;return false;" value="">ارفاق رقم الطلب </button>
                        <button type="button" class="btn btn-primary" onclick="$('#confirm_sms_msg').val($('#confirm_sms_msg').val() +'[[total]]') ;return false;" value="">ارفاق المبلغ </button>
                        <button type="button" class="btn btn-primary" onclick="$('#confirm_sms_msg').val($('#confirm_sms_msg').val() +'[[project]]') ;return false;" value="">ارفاق اسم المشروع </button>
                        <small class="red ">سيتم استبدال المتغير الخاص بالقيمة </small>
                    </div>
                    <div class="form-group col-md-12">
                        <label class="control-label">المحتوي : </label>
                        <div class="row">
                            <textarea id="confirm_sms_msg" name="value[confirm_sms_msg]" rows="6" class="form-control"><?php echo ($data['value']->confirm_sms_msg); ?></textarea>
                        </div>
                    </div>
                </div>

                <div id="contacts" class="x_panel tile ">
                    <h4 class="x_title">اعدادات نموزج اتصل بنا</h4>
                    <div class="form-group">
                        <label class="control-label" for="contactEmail">البريد الخاص بتلقي التنبيهات : </label>
                        <div class="has-feedback">
                            <input type="text" id="contactEmail" class="form-control" name="value[contactEmail]" placeholder="البريد الخاص بتلقي التنبيهات" value="<?php echo $data['value']->contactEmail; ?>">
                        </div>
                    </div>
                </div>
                <div id="volunteer" class="x_panel tile ">
                    <h4 class="x_title">اعدادات نموزج التطوع</h4>
                    <div class="form-group">
                        <label class="control-label" for="volunteerEmail">البريد الخاص بتلقي التنبيهات : </label>
                        <div class="has-feedback">
                            <input type="text" id="volunteerEmail" class="form-control" name="value[volunteerEmail]" placeholder="البريد الخاص بتلقي التنبيهات" value="<?php echo $data['value']->volunteerEmail; ?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label" for="volunteerContent">محتوي الصفحة : </label>
                        <div class="has-feedback">
                            <textarea id="ckeditor" name="value[volunteerContent]" rows="6" class="form-control ckeditor"><?php echo ($data['value']->volunteerContent); ?></textarea>
                        </div>
                    </div>
                </div>
                <div id="beneficiary" class="x_panel tile ">
                    <h4 class="x_title">اعدادات نموزج تسجيل مستفيد</h4>
                    <div class="form-group">
                        <label class="control-label" for="beneficiaryEmail">البريد الخاص بتلقي التنبيهات : </label>
                        <div class="has-feedback">
                            <input type="text" id="beneficiaryEmail" class="form-control" name="value[beneficiaryEmail]" placeholder="البريد الخاص بتلقي التنبيهات" value="<?php echo $data['value']->beneficiaryEmail; ?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label" for="beneficiaryContent">محتوي الصفحة : </label>
                        <div class="has-feedback">
                            <textarea id="ckeditor2" name="value[beneficiaryContent]" rows="6" class="form-control ckeditor"><?php echo ($data['value']->beneficiaryContent); ?></textarea>
                        </div>
                    </div>
                </div>
                <div id="inkind" class="x_panel tile ">
                    <h4 class="x_title">اعدادات نموزج الطلب العيني</h4>
                    <div class="form-group">
                        <label class="control-label" for="inkindEmail">البريد الخاص بتلقي التنبيهات : </label>
                        <div class="has-feedback">
                            <input type="text" id="inkindEmail" class="form-control" name="value[inkindEmail]" placeholder="البريد الخاص بتلقي التنبيهات" value="<?php echo $data['value']->inkindEmail; ?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label" for="inkindContent">محتوي الصفحة : </label>
                        <div class="has-feedback">
                            <textarea id="ckeditor3" name="value[inkindContent]" rows="6" class="form-control ckeditor"><?php echo ($data['value']->inkindContent); ?></textarea>
                        </div>
                    </div>
                </div>

                <div id="sendcode" class="x_panel tile ">
                    <h4 class="x_title">اعدادات  رساله التحقيق  </h4>
                    <div class="form-group">
                        <label class="control-label" for="sendcode">محتوي الصفحة : </label>
                        <div class="has-feedback">
                        <textarea id="ckeditor3" name="value[sendcode]" rows="6" class="form-control ckeditor"><?php echo ($data['value']->sendcode); ?></textarea>
                        </div>
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
            <br><br>
        </div>
    </div>
</div>

<?php
// loading plugin
$data['footer'] = '<script src="' . ADMINURL . '/template/default/vendors/ckeditor/ckeditor.js"></script>
                    <script src="' . ADMINURL . '/template/default/vendors/jquery.tagsinput/src/jquery.tagsinput.js"></script>
                    <script>
                    //filemanagesr for ck editor
                    CKEDITOR.replace("ckeditor", {
                        filebrowserBrowseUrl: "' . ADMINURL . '/helpers/filemanager/dialog.php?type=2&editor=ckeditor&fldr=" ,
                        filebrowserUploadUrl: "' . ADMINURL . '/helpers/filemanager/dialog.php?type=2&editor=ckeditor&fldr=",
                        filebrowserImageBrowseUrl: "' . ADMINURL . '/helpers/filemanager/dialog.php?type=1&editor=ckeditor&fldr="
                    });
                    CKEDITOR.replace("ckeditor2", {
                        filebrowserBrowseUrl: "' . ADMINURL . '/helpers/filemanager/dialog.php?type=2&editor=ckeditor&fldr=" ,
                        filebrowserUploadUrl: "' . ADMINURL . '/helpers/filemanager/dialog.php?type=2&editor=ckeditor&fldr=",
                        filebrowserImageBrowseUrl: "' . ADMINURL . '/helpers/filemanager/dialog.php?type=1&editor=ckeditor&fldr="
                    });
                    CKEDITOR.replace("ckeditor3", {
                        filebrowserBrowseUrl: "' . ADMINURL . '/helpers/filemanager/dialog.php?type=2&editor=ckeditor&fldr=" ,
                        filebrowserUploadUrl: "' . ADMINURL . '/helpers/filemanager/dialog.php?type=2&editor=ckeditor&fldr=",
                        filebrowserImageBrowseUrl: "' . ADMINURL . '/helpers/filemanager/dialog.php?type=1&editor=ckeditor&fldr="
                    });
                    </script>' . "\n";
require ADMINROOT . '/views/inc/footer.php';
