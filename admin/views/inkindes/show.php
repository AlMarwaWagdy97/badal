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
    <?php flash('inkind_msg');?>
    <div class="page-title">
        <div class="title_right">
            <h3><?php echo $data['page_title']; ?> <small>عرض محتوي التبرع العيني </small></h3>
        </div>
        <div class="title_left">
            <a href="<?php echo ADMINURL; ?>/inkindes" class="btn btn-success pull-left">عودة <i class="fa fa-reply"></i></a>
        </div>
    </div>

    <div class="clearfix"></div>

    <div class="row">
        <div class="col-md-12 col-sm-12">
            <div class="form-group">
                <h3 class="prod_title">
                    <?php echo $data['inkind']->full_name; ?>
                </h3>
            </div>
            <div class="form-group col-md-6 col-sm-12">
                <label class="control-label">البريد الالكتروني : </label>
                <?php echo $data['inkind']->email; ?>
            </div>
            <div class="form-group col-md-6 col-sm-12">
                <label class="control-label">الهاتف : </label>
                <?php echo $data['inkind']->phone; ?>
            </div>
            <div class="form-group col-md-6 col-sm-12">
                <label class="control-label">التبرع : </label>
                <p><?php echo $data['inkind']->message ?: 'لا يوجد'; ?></p>
            </div>
            <div class="form-group col-md-6 col-sm-12">
                <label class="control-label">الحي  : </label>
                <?php echo $data['inkind']->district ?: 'لا يوجد'; ?>
            </div>
            <div class="form-group col-md-6 col-sm-12">
                <label class="control-label">الشارع  : </label>
                <?php echo $data['inkind']->street ?: 'لا يوجد'; ?>
            </div>
            <div class="form-group col-md-6 col-sm-12">
                <label class="control-label">الحالة : </label>
                <p><?php echo $data['inkind']->status ? 'مقروءة' : 'غير مقروءة'; ?></p>
            </div>
            <div class="form-group col-md-6 col-sm-12">
                <label class="control-label">اخر تحديث : </label>
                <p><?php echo $data['inkind']->modified_date ? date('d/ M/ Y', $data['inkind']->modified_date) : 'لا'; ?></p>
            </div>            
            <div class="form-group col-md-6 col-sm-12">
                <label class="control-label">وقت الإنشاء : </label>
                <p><?php echo $data['inkind']->create_date ? date('d/ M/ Y', $data['inkind']->create_date) : 'لا'; ?></p>
            </div>
            <div class="form-group col-sm-12">
                <a class="btn btn-info" href="<?php echo ADMINURL . '/inkindes/edit/' . $data['inkind']->inkind_id; ?>" >تعديل</a>
            </div>


        </div>
    </div>
</div>

<?php
// loading plugin
$data['footer'] = '';

require ADMINROOT . '/views/inc/footer.php';
