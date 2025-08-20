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
$volunteer = (object) $data['volunteer'];
?>

<!-- page content -->

<div class="right_col" role="main">
    <div class="clearfix"></div>
    <?php flash('volunteer_msg'); ?>
    <div class="page-title">
        <div class="title_right">
            <h3><?php echo $data['page_title']; ?> <small>عرض متطوع </small></h3>
        </div>
        <div class="title_left">
            <a href="<?php echo ADMINURL; ?>/volunteers" class="btn btn-success pull-left">عودة <i class="fa fa-reply"></i></a>
        </div>
    </div>

    <div class="clearfix"></div>

    <div class="row">
        <div class="col-xs-12 col-xs-12">
            <div class="form-group">
                <h3 class="prod_title">
                    <?php echo $volunteer->full_name; ?>
                </h3>
            </div>
            <div class="form-group col-xs-12">
                <label class="control-label">الهوية : </label>
                <?php echo $volunteer->identity; ?>
                <br>
                <a href="<?php echo URLROOT . "/media/files/volunteers/" . $volunteer->image; ?>" target="blank">
                    <img src="<?php echo URLROOT . "/media/files/thumbs/" . $volunteer->image; ?>">
                </a>
            </div>
            <div class="form-group col-xs-12">
                <label class="control-label">الجنسية : </label>
                <?php echo $volunteer->nationality; ?>
            </div>
            <div class="form-group col-xs-12">
                <label class="control-label">الجنس : </label>
                <?php echo $volunteer->gender; ?>
            </div>
            <div class="form-group col-xs-12">
                <label class="control-label">البريد الالكتروني : </label>
                <?php echo $volunteer->email; ?>
            </div>
            <div class="form-group col-xs-12">
                <label class="control-label">الهاتف : </label>
                <?php echo $volunteer->phone; ?>
            </div>
            <div class="form-group col-xs-12">
                <label class="control-label">الحالة : </label>
                <p><?php echo $volunteer->status ? 'مقروءة' : 'غير مقروءة'; ?></p>
            </div>
            <div class="form-group col-xs-12">
                <label class="control-label">اخر تحديث : </label>
                <p><?php echo $volunteer->modified_date ? date('d/ M/ Y', $volunteer->modified_date) : 'لا'; ?></p>
            </div>
            <div class="form-group col-xs-12">
                <label class="control-label">وقت الإنشاء : </label>
                <p><?php echo $volunteer->create_date ? date('d/ M/ Y', $volunteer->create_date) : 'لا'; ?></p>
            </div>
            <div class="form-group col-xs-12">
                <a class="btn btn-info" href="<?php echo ADMINURL . '/volunteers/edit/' . $volunteer->volunteer_id; ?>">تعديل</a>
            </div>


        </div>
    </div>
</div>

<?php
// loading plugin
$data['footer'] = '';

require ADMINROOT . '/views/inc/footer.php';
