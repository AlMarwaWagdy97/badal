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
    <?php flash('donation_msg'); ?>
    <div class="page-title">
        <div class="title_right">
            <h3><?php echo $data['page_title']; ?> <small>عرض محتوي التبرع </small></h3>
        </div>
        <div class="title_left">
            <a href="<?php echo ADMINURL; ?>/donations" class="btn btn-success pull-left">عودة <i class="fa fa-reply"></i></a>
        </div>
    </div>

    <div class="clearfix"></div>

    <div class="row">
        <div class="col-md-12 col-sm-12">
            <div class="form-groupcol-xs-12">
                <label class="control-label">قيمة التبرع : </label>
                <p><?php echo $data['donation']->amount; ?></p>
            </div>
            <div class="form-groupcol-xs-12">
                <label class="control-label">اسم المشروع : </label>
                <p><?php echo $data['donation']->project_id; ?></p>
            </div>
            <div class="form-groupcol-xs-12">
                <label class="control-label">اخر تحديث : </label>
                <p><?php echo $data['donation']->modified_date ? date('d/ M/ Y', $data['donation']->modified_date) : 'لا'; ?></p>
            </div>
            <div class="form-groupcol-xs-12">
                <label class="control-label">وقت الإنشاء : </label>
                <p><?php echo $data['donation']->create_date ? date('d/ M/ Y', $data['donation']->create_date) : 'لا'; ?></p>
            </div>

            <div class="form-group col-xs-12">
                <a class="btn btn-info" href="<?php echo ADMINURL . '/donations/edit/' . $data['donation']->donation_id; ?>">تعديل</a>
            </div>


        </div>
    </div>
</div>

<?php
// loading plugin
$data['footer'] = '';

require ADMINROOT . '/views/inc/footer.php';
