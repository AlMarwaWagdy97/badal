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
    <?php flash('donation_msg'); ?>
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
            <form action="<?php echo ADMINURL . '/donations/edit/' . $data['donation_id']; ?>" method="post" enctype="multipart/form-data" accept-charset="utf-8">
                <div class="col-sm-12 col-xs-12">
                    <div class="form-group">
                        <label class="control-label" for="amount">قيمة التبرع : </label>
                        <div class="has-feedback">
                            <input type="number" class="form-control" name="amount" required value="<?php echo $data['amount']; ?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label" for="quantity"> الكمية : </label>
                        <div class="has-feedback">
                            <input type="number" class="form-control" name="quantity" required value="<?php echo $data['quantity']; ?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label" for="total"> الاجمالي : </label>
                        <div class="has-feedback">
                            <input type="number" class="form-control" name="total" required value="<?php echo $data['total']; ?>">
                        </div>
                    </div>
                    <div class="form-group <?php echo (!empty($data['project_id_error'])) ? 'has-error' : ''; ?>">
                        <label class="control-label">المشروع</label>
                        <div class="has-feedback">
                            <select name="project_id" class="form-control">
                                <option value="">اختار المشروع </option>
                                <?php foreach ($data['projectList'] as $project) : ?>
                                    <option value="<?php echo $project->project_id; ?>" <?php echo ($project->project_id == $data['project_id']) ? " selected " : ''; ?>>
                                        <?php echo $project->name; ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                            <span class="fa fa-folder form-control-feedback" aria-hidden="true"></span>
                        </div>
                        <span class="help-block"><?php echo $data['project_id_error']; ?></span>
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
