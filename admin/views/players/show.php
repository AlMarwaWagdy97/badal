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
    <?php flash('player_msg');?>
    <div class="page-title">
        <div class="title_right">
            <h3><?php echo $data['page_title']; ?> <small>عرض محتوي الصفحة </small></h3>
        </div>
        <div class="title_left">
            <a href="<?php echo ADMINURL; ?>/players" class="btn btn-success pull-left">عودة <i class="fa fa-reply"></i></a>
        </div>
    </div>

    <div class="clearfix"></div>

    <div class="row">
        <div class="col-md-12 col-sm-12">
            <div class="form-group">
                <h3 class="prod_title">
                    <?php echo $data['player']->full_name; ?>
                </h3>
            </div>
            <div class="form-group col-md-6 col-sm-12">
                <label class="control-label">اللغز : </label>
                <?php echo $data['player']->puzzel ?: 'لا يوجد'; ?>
            </div>
            <div class="form-group col-md-6 col-sm-12">
                <label class="control-label">البريد الالكتروني : </label>
                <?php echo $data['player']->email; ?>
            </div>
            <div class="form-group col-md-6 col-sm-12">
                <label class="control-label">الهاتف : </label>
                <?php echo $data['player']->phone; ?>
            </div>
            <div class="form-group col-md-6 col-sm-12">
                <label class="control-label">الحالة : </label>
                <p><?php echo $data['player']->status ? 'مكتملة' : 'غير مكتملة'; ?></p>
            </div>
            <div class="form-group col-md-6 col-sm-12">
                <label class="control-label">اخر تحديث : </label>
                <p><?php echo $data['player']->modified_date ? date('d/ M/ Y', $data['player']->modified_date) : 'لا'; ?></p>
            </div>            
            <div class="form-group col-md-6 col-sm-12">
                <label class="control-label">وقت الإنشاء : </label>
                <p><?php echo $data['player']->create_date ? date('d/ M/ Y', $data['player']->create_date) : 'لا'; ?></p>
            </div>
            <div class="form-group col-sm-12">
            </div>


        </div>
    </div>
</div>

<?php
// loading plugin
$data['footer'] = '';

require ADMINROOT . '/views/inc/footer.php';
