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
    <?php flash('notification_msg'); ?>
    <div class="page-title">
        <div class="title_right">
            <h3><?php echo $data['page_title']; ?> <small>اضافة رسالة جديد </small></h3>
        </div>
        <div class="title_left">
            <a href="<?php echo ADMINURL; ?>/notifications" class="btn btn-success pull-left">عودة <i class="fa fa-reply"></i></a>
        </div>
    </div>

    <div class="clearfix"></div>

    <div class="row">

        <form action="<?php echo ADMINURL . '/notifications/add'; ?>" method="post" enctype="multipart/form-data" accept-charset="utf-8">
            <div class="col-lg-8 col-sm-12 col-xs-12">
                <div class="form-group  <?php echo (empty($data['subject_error'])) ?: 'has-error'; ?>">
                    <label class="control-label" for="pageTitle">الموضوع : </label>
                    <div class="has-feedback">
                        <input type="text" class="form-control" name="subject" placeholder="عنوان الموضوع" value="<?php echo $data['subject']; ?>">
                        <span class="fa fa-edit form-control-feedback" aria-hidden="true"></span>
                        <span class="help-block"><?php echo $data['subject_error']; ?></span>
                    </div>
                </div>
                <div class="form-group  <?php echo (empty($data['message_error'])) ?: 'has-error'; ?>">
                    <label class="control-label">نص الرسالة : </label>
                    <textarea rows="5" name="message" class="form-control"><?php echo ($data['message']); ?></textarea>
                    <span class="help-block"><?php echo $data['message_error']; ?></span>
                </div>
            </div>

            <div class="col-xs-12">
                <button type="submit" name="submit" class="btn btn-success">أضف
                    <i class="fa fa-save"> </i></button>
                <button type="reset" class="btn btn-danger">مسح
                    <i class="fa fa-trash "> </i></button>
            </div>

        </form>
    </div>
</div>
<?php
// loading plugin
$data['footer'] = '<script src="' . ADMINURL . '/template/default/vendors/ckeditor/ckeditor.js"></script>

                   <script src="' . ADMINURL . '/template/default/vendors/jquery.tagsinput/src/jquery.tagsinput.js"></script>';

require ADMINROOT . '/views/inc/footer.php';
