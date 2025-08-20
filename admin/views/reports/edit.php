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
$data['header'] = '<!-- Select2 -->
<link rel="stylesheet" href="' . ADMINURL . '/template/default/vendors/select2/dist/css/select2.min.css">';
header("Content-Type: text/html; charset=utf-8");

require ADMINROOT . '/views/inc/header.php';
?>

<!-- page content -->

<div class="right_col" role="main">
    <div class="clearfix"></div>
    <?php flash('donation_msg');?>
    <div class="page-title">
        <div class="title_right">
            <h3><?php echo $data['page_title']; ?> <small>التعديل علي التبرع </small></h3>
        </div>
        <div class="title_left">
            <a href="<?php echo ADMINURL; ?>/donations" class="btn btn-success pull-left">عودة <i class="fa fa-reply"></i></a>
        </div>
    </div>

    <div class="clearfix"></div>

    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <form action="<?php echo ADMINURL . '/donations/edit/' . $data['donation_id']; ?>" method="post" enctype="multipart/form-data" accept-charset="utf-8" >

            <div class="col-sm-12 col-xs-12">
                <div class="form-group">
                    <label class="control-label" for="pageTitle">معرف التبرع : </label>
                    <div class="has-feedback">
                        <input type="text" class="form-control" name="donation_identifier" readonly value="<?php echo $data['donation_identifier']; ?>">
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label" for="pageTitle">قيمة التبرع : </label>
                    <div class="has-feedback">
                        <input type="number" class="form-control" name="amount" required value="<?php echo $data['amount']; ?>">
                    </div>
                </div>
                <div class="form-group <?php echo (!empty($data['project_id_error'])) ? 'has-error' : ''; ?>">
                    <label class="control-label">المشروع</label>
                    <div class="has-feedback">
                        <select name="project_id" class="form-control">
                            <option value="">اختار المشروع </option>
                            <?php foreach ($data['projectList'] as $project): ?>
                                <option value="<?php echo $project->project_id; ?>" <?php echo ($project->project_id == $data['project_id']) ? " selected " : ''; ?>>
                                    <?php echo $project->name; ?>
                                </option>
                            <?php endforeach;?>
                        </select>
                        <span class="fa fa-folder form-control-feedback" aria-hidden="true"></span>
                    </div>
                    <span class="help-block"><?php echo $data['project_id_error']; ?></span>
                </div>
                <div class="form-group <?php echo (!empty($data['payment_method_id_error'])) ? 'has-error' : ''; ?>">
                    <label class="control-label">وسيلة التبرع</label>
                    <div class="has-feedback">
                        <select name="payment_method_id" class="form-control">
                            <option value="">اختار وسيلة التبرع </option>
                            <?php foreach ($data['paymentMethodsList'] as $payment_method): ?>
                                <option value="<?php echo $payment_method->payment_id; ?>" <?php echo ($payment_method->payment_id == $data['payment_method_id']) ? " selected " : ''; ?>>
                                    <?php echo $payment_method->title; ?>
                                </option>
                            <?php endforeach;?>
                        </select>
                        <span class="fa fa-folder form-control-feedback" aria-hidden="true"></span>
                    </div>
                    <span class="help-block"><?php echo $data['payment_method_id_error']; ?></span>
                </div>
                <div class="form-group">
                    <label class="control-label">الوسوم</label>
                    <select class="form-control select2" name="tags[]" multiple="multiple" data-placeholder="اختار الوسوم المناسبة" style="width: 100%;">
                    <?php foreach ($data['tagsList'] as $tag): ?>
                                <option value="<?php echo $tag->tag_id; ?>" <?php echo in_array($tag->tag_id, $data['tags']) ? " selected " : 'no'; ?>>
                                    <?php echo $tag->name; ?>
                                </option>
                    <?php endforeach;?>
                    </select>
                </div>
                <div class="">
                    <label class="control-label" for="imageUpload">اثبات التبرع : </label>
                    
                    <div class="form-group <?php echo (empty($data['banktransferproof_error'])) ?: 'has-error'; ?>">
                        <label class="control-label" for="imageUpload"> اثبات التبرع : </label>
                        <div class="has-feedback input-group">
                            <span class="input-group-btn">
                                <span class="btn btn-dark" onclick="$(this).parent().find('input[type=file]').click();">اختار الملف</span>
                                <input name="banktransferproof" value="<?php echo ($data['banktransferproof']); ?>" onchange="$(this).parent().parent().find('.form-control').html($(this).val().split(/[\\|/]/).pop());" style="display: none;" type="file">
                            </span>
                            <span class="form-control"><small><?php echo empty($data['banktransferproof']) ? 'قم بأختيار صورة مناسبة' : $data['banktransferproof']; ?></small></span>
                        </div>
                        <div class="help-block"><?php echo $data['banktransferproof_error']; ?></div>
                    </div>
                </div>

                <div class="form-group col-xs-12 <?php echo (!empty($data['status_error'])) ? 'has-error' : ''; ?>">
                    <label class="control-label">حالة التبرع :</label>
                    <div class="radio">
                        <label>
                            <input type="radio" class="flat" <?php echo ($data['status'] == 1) ? 'checked' : ''; ?> value="1" name="status"> مؤكد
                        </label>
                        <label>
                            <input type="radio" class="flat" <?php echo ($data['status'] == 0) ? 'checked' : ''; ?> value="0" name="status"> غير مؤكد
                        </label>
                        <span class="help-block"><?php echo $data['status_error']; ?></span>
                    </div>
                </div>
            </div>
            <div class="col-xs-12 col-md-offset-3">
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
<script src="' . ADMINURL . '/template/default/vendors/select2/dist/js/select2.full.min.js"></script>
<script src="' . ADMINURL . '/template/default/vendors/jquery.tagsinput/src/jquery.tagsinput.js"></script>
<script>
$(".select2").select2({dir: "rtl"});
//filemanagesr for ck editor
 CKEDITOR.replace("ckeditor", {
     filebrowserBrowseUrl: "' . ADMINURL . '/helpers/filemanager/dialog.php?type=2&editor=ckeditor&fldr=" ,
     filebrowserUploadUrl: "' . ADMINURL . '/helpers/filemanager/dialog.php?type=2&editor=ckeditor&fldr=",
     filebrowserImageBrowseUrl: "' . ADMINURL . '/helpers/filemanager/dialog.php?type=1&editor=ckeditor&fldr="
 });
</script>';

require ADMINROOT . '/views/inc/footer.php';
