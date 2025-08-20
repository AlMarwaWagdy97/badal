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
        <h3><?php echo $data['page_title']; ?> <small>عرض تفاصيل المناسك </small></h3>
        </div>
        <div class="title_left">
            <a href="<?php echo ADMINURL; ?>/badalorders" class="btn btn-success pull-left">عودة <i class="fa fa-reply"></i></a>
        </div>
    </div>

    <div class="clearfix"></div>

    <div class="row">
        <div class="col-md-12 col-sm-12">
            <?php foreach($data['Badalrituals'] as $ritual){ ?>
                <div class="form-group col-md-3 col-sm-12">
                    <label class="control-label">الاسم : </label>
                    <span><?= $ritual->title ?'نعم': 'لا يوجد'; ?></span>
                </div>
                <div class="form-group col-md-3 col-sm-12">
                    <label class="control-label">بداء : </label>
                    <span><?= $ritual->start ?'نعم': 'لا'; ?></span>
                </div>
                <div class="form-group col-md-3 col-sm-12">
                    <label class="control-label">انتهي : </label>
                    <span><?= $ritual->complete ?'نعم': 'لا'; ?></span>
                </div>
                <div class="form-group col-md-3 col-sm-12">
                    <label class="control-label">الفيديو : </label>
                    <p></p>
                    <?php if( $ritual->proof == '0') { ?> ليس مطلوب
                    <?php } elseif($ritual->proof == '1') { ?> لا يوجد
                    <?php } else { ?>
                        <video  width="200" height="200" controls>
                            <source src="<?= $ritual->proof?>" type="video/mp4">
                        </video>
                    <?php } ?>
                </div>
            <?php } ?>

        </div>
    </div>
</div>

<?php
// loading plugin
$data['footer'] = '';

require ADMINROOT . '/views/inc/footer.php';
