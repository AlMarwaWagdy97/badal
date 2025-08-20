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
    <?php flash('badaloffer_msg');?>
    <div class="page-title">
        <div class="title_right">
        <h3><?php echo $data['page_title']; ?> <small>عرض تفاصيل العرض </small></h3>
        </div>
        <div class="title_left">
            <a href="<?php echo ADMINURL; ?>/badaloffers" class="btn btn-success pull-left">عودة <i class="fa fa-reply"></i></a>
        </div>
    </div>

    <div class="clearfix"></div>

    <div class="row">
        <div class="col-md-12 col-sm-12">
            <div class="form-group">
                <h3 class="prod_title">
                    <label class="control-label">الاسم : </label>
                    <?= $data['BadalOffers']->substitute_name; ?>
                </h3>
            </div>
            <div class="form-group col-md-6 col-sm-12">
                <label class="control-label">المشروع : </label>
                <p><?php echo $data['BadalOffers']->project ?: 'لا يوجد'; ?></p>
            </div>
            <div class="form-group col-md-6 col-sm-12">
                <label class="control-label">القيمه : </label>
                <p><?php echo $data['BadalOffers']->amount ?: 'لا يوجد'; ?></p>
            </div>
            <div class="form-group col-md-6 col-sm-12">
                <label class="control-label">رقم الهوية : </label>
                <p><?php echo $data['BadalOffers']->identity ?: 'لا يوجد'; ?></p>
            </div>
            <div class="form-group col-md-6 col-sm-12">
                <label class="control-label">صورة الهوية: </label>
                <a href="<?= $data['BadalOffers']->substitute_image ?>"><img src="<?= $data['BadalOffers']->substitute_image ?>" alt="" width="100"></a>
            </div>
            <div class="form-group col-md-6 col-sm-12">
                <label class="control-label">الجنسية : </label>
                <p><?php echo $data['BadalOffers']->nationality ?: 'لا يوجد'; ?></p>
            </div>
            <div class="form-group col-md-6 col-sm-12">
                <label class="control-label">النوع : </label>
                <p><?php echo $data['BadalOffers']->gender ?: 'لا يوجد'; ?></p>
            </div>
            <div class="form-group col-md-6 col-sm-12">
                <label class="control-label">البريد الاكتروني : </label>
                <p><?php echo $data['BadalOffers']->email ?: 'لا يوجد'; ?></p>
            </div>
            <div class="form-group col-md-6 col-sm-12">
                <label class="control-label">رقم الهاتف : </label>
                <p><?php echo $data['BadalOffers']->phone ?: 'لا يوجد'; ?></p>
            </div>
            <div class="form-group col-md-6 col-sm-12">
                <label class="control-label">اللغة : </label>
                <p><?php echo $data['BadalOffers']->languages ?: 'لا يوجد'; ?></p>
            </div>
            <div class="form-group col-md-6 col-sm-12">
                <label class="control-label">النوع : </label>
                <p><?php echo $data['BadalOffers']->gender ?: 'لا يوجد'; ?></p>
            </div>
            <div class="form-group col-md-6 col-sm-12">
                <label class="control-label">البداء: </label>
                <p><?php echo $data['BadalOffers']->modified_date ? date('d/ M/ Y', $data['BadalOffers']->modified_date) : 'لا'; ?></p>
            </div>   
        </div>
    </div>
</div>

<?php
// loading plugin
$data['footer'] = '';

require ADMINROOT . '/views/inc/footer.php';
