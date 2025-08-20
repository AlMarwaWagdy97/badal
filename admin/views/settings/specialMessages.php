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

require ADMINROOT . '/views/inc/header.php'; ?>

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
                
               

                
                <!-- WhatsApp Message ----------------------------------------------------------------------------------- -->
                <div class="x_panel tile ">
                    <h4 class="x_title">  تاكيد الطلب  </h4>
                    <div class="form-group">
                        <label class="control-label" for="settingTitle"> اسم    template </label>
                        <div class="has-feedback">
                            <input type="text" id="" class="form-control" name="value[template_name_special_confirm]" placeholder="Template  Name" value="<?= @$data['value']->template_name_special_confirm; ?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label" for="settingTitle"> اسم المرسل   : </label>
                        <div class="has-feedback">
                            <input type="text" id="" class="form-control" name="value[broadcast_name_special_confirm]" placeholder="broadcast name" value="<?= @$data['value']->broadcast_name_special_confirm; ?>">
                        </div>
                    </div>
                </div>

                <!-- SMS & Email  ----------------------------------------------------------------------------------------------- -->
                <!-- <div class="col-lg-12 col-sm-12 col-xs-12 options">
                    <div class="accordion">
                        <div class="card">
                            <div class="x_panel tile ">
                                <div class="select-request">
                                    <div class="card-header" data-toggle="collapse" data-target="#collapsedeceaseds" aria-expanded="true" aria-controls="collapsedeceaseds">
                                        <span> رسايل الطلب </span>
                                    </div>
                                    <div id="collapsedeceaseds" class="collapse card-body" aria-labelledby="headingdeceaseds">
                                        <div class="row badal">
                                        <div class="email-container">
                                            <h3> البريد الاكتروني</h3>
                                            <div class="form-group">
                                                <label class="control-label">تفعيل الارسال :</label>
                                                <div class="radio">
                                                    <label>
                                                        <input type="radio" class="flat" <?php echo (@$data['value']->email_enabled == 1) ? 'checked' : ''; ?> value="1" name="value[email_enabled]"> مفعلة
                                                    </label>
                                                    <label>
                                                        <input type="radio" class="flat" <?php echo (@$data['value']->email_enabled == '0') ? 'checked' : ''; ?> value="0" name="value[email_enabled]"> معلقة
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label" for="inform_subject">عنوان الرسالة : </label>
                                                <div class="has-feedback">
                                                    <input type="text" id="inform_subject" class="form-control" name="value[special_subject]" placeholder="عنوان الرسالة" value="<?php echo @$data['value']->special_subject; ?>">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <br>
                                                <button type="button" class="btn btn-primary" onclick="$('#deceased_msg').val($('#deceased_msg').val() +'[[name]]') ;return false;" value="">ارفاق اسم المتطوع  </button>
                                                <button type="button" class="btn btn-primary" onclick="$('#deceased_msg').val($('#deceased_msg').val() +'[[identifier]]') ;return false;" value="">ارفاق اسم المتوفي </button>
                                                <button type="button" class="btn btn-primary" onclick="$('#deceased_msg').val($('#deceased_msg').val() +'[[total]]') ;return false;" value=""> ارفاق المبلغ المستهدف </button>
                                                <button type="button" class="btn btn-primary" onclick="$('#deceased_msg').val($('#deceased_msg').val() +'[[project]]') ;return false;" value="">ارفاق اسم المشروع </button>
                                                <small class="red ">سيتم استبدال المتغير الخاص بالقيمة </small>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label">المحتوي : </label>
                                                <div class="row">
                                                    <textarea id="deceased_msg" name="value[special_msg]" rows="6" class="form-control"><?php echo (@$data['value']->special_msg); ?></textarea>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="sms">
                                            <h3> رساله ال SMS</h3>
                                            <div class="form-group">
                                                <label class="control-label">تفعيل الارسال :</label>
                                                <div class="radio">
                                                    <label>
                                                        <input type="radio" class="flat" <?php echo (@$data['value']->special_sms == 1) ? 'checked' : ''; ?> value="1" name="value[special_sms]"> مفعلة
                                                    </label>
                                                    <label>
                                                        <input type="radio" class="flat" <?php echo (@$data['value']->special_sms == '0') ? 'checked' : ''; ?> value="0" name="value[special_sms]"> معلقة
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <br>
                                                <button type="button" class="btn btn-primary" onclick="$('#deceased_sms_msg').val($('#deceased_sms_msg').val() +'[[name]]') ;return false;" value="">ارفاق اسم المتطوع  </button>
                                                <button type="button" class="btn btn-primary" onclick="$('#deceased_sms_msg').val($('#deceased_sms_msg').val() +'[[identifier]]') ;return false;" value="">ارفاق اسم المتطوع </button>
                                                <button type="button" class="btn btn-primary" onclick="$('#deceased_sms_msg').val($('#deceased_sms_msg').val() +'[[total]]') ;return false;" value=""> ارفاق المبلغ المستهدف </button>
                                                <button type="button" class="btn btn-primary" onclick="$('#deceased_sms_msg').val($('#deceased_sms_msg').val() +'[[project]]') ;return false;" value="">ارفاق اسم المشروع </button>
                                                <small class="red ">سيتم استبدال المتغير الخاص بالقيمة </small>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label">المحتوي : </label>
                                                <div class="row">
                                                    <textarea id="deceased_sms_msg" name="value[special_sms_msg]" rows="6" class="form-control"><?php echo (@$data['value']->special_sms_msg); ?></textarea>
                                                </div>
                                            </div>
                                        </div>
                                
                                
                                    </div>
                                </div>
                                <br>
                            </div>
                        </div>
                    </div>
                </div> -->

                <!-- enable ----------------------------------------------------------------------------------------------- -->
                <div class="form-group col-xs-12 ">
                    <label class="control-label">تفعيل  رسائل المخصوصة  :</label>
                    <div class="radio">

                        <label>
                            <input type="radio" class="flat" value="1" name="value[specialenabled]" <?= (@$data['value']->specialenabled == 1) ? 'checked' : ''; ?>> مفعلة
                        </label>
                        <label>
                            <input type="radio" class="flat" value="0" name="value[specialenabled]" <?= (@$data['value']->specialenabled == '0') ? 'checked' : ''; ?>> معلقة
                        </label>
                    </div>
                </div>
                
                <!-- Projects ----------------------------------------------------------------------------------------------- -->
                <div class="form-group col-xs-12 ">
                    <label class="control-label">اختيار المشاريع :</label>
                    <div class="radio">

                    </div>
                    <?php
                    foreach ($data['projects'] as $project) {
                        echo '<div class="col-md-3">';
                        if (@in_array($project->project_id, (json_decode(@$data['value']->projects) ?? [] ))) {
                            echo '<label class="btn btn-secondary  m-1">
                                            <input type="checkbox" ' . ' checked name="value[projects][' . $project->project_id . ']"  class="donation-value" > ' . substr($project->name, 0, 75)  . '
                                        </label>';
                        } else {
                            echo '<label class="btn btn-secondary  m-1">
                                            <input type="checkbox" ' . ' name="value[projects][' . $project->project_id . ']"  class="donation-value" > ' . substr($project->name, 0, 75)  . '
                                        </label>';
                        }
                        echo '</div>';
                    }

                    ?>
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
$data['footer'] = '<script src="' . ADMINURL . '/template/default/vendors/ckeditor/ckeditor.js"></script>
                   <script src="' . ADMINURL . '/template/default/vendors/jquery.tagsinput/src/jquery.tagsinput.js"></script>';

require ADMINROOT . '/views/inc/footer.php';
