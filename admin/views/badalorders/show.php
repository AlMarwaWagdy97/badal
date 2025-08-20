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
    <?php flash('badalorder_msg'); ?>
    <div class="page-title">
        <div class="title_right">
            <h3><?php echo $data['page_title']; ?> <small>عرض محتوي التبرع </small></h3>
        </div>
        <div class="title_left">
            <a href="<?php echo ADMINURL; ?>/badalorders" class="btn btn-success pull-left">عودة <i class="fa fa-reply"></i></a>
        </div>
    </div>

    <div class="clearfix"></div>

    <div class="row">
        <div class="col-md-12 col-sm-12">
            <div class="form-groupcol-xs-12">
                <label class="control-label">قيمة التبرع : </label>
                <p><?php echo $data['badalorder']->amount; ?></p>
            </div>
            <div class="form-groupcol-xs-12">
                <label class="control-label">اسم المشروع : </label>
                <p><?php echo $data['badalorder']->project_id; ?></p>
            </div>
            <div class="form-groupcol-xs-12">
                <label class="control-label">اخر تحديث : </label>
                <p><?php echo $data['badalorder']->modified_date ? date('d/ M/ Y', $data['badalorder']->modified_date) : 'لا'; ?></p>
            </div>
            <div class="form-groupcol-xs-12">
                <label class="control-label">وقت الإنشاء : </label>
                <p><?php echo $data['badalorder']->create_date ? date('d/ M/ Y', $data['badalorder']->create_date) : 'لا'; ?></p>
            </div>

            <div class="form-group col-xs-12">
                <a class="btn btn-info" href="<?php echo ADMINURL . '/badalorders/edit/' . $data['badalorder']->badal_id; ?>">تعديل</a>
            </div>


        </div>
    </div>
</div>

<?php
// loading plugin
$data['footer'] = '';

require ADMINROOT . '/views/inc/footer.php';
