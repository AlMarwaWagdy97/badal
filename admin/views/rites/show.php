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
$data['header'] = '
<style>
.bg-white{
    padding: 9px;
}
</style>';
header("Content-Type: text/html; charset=utf-8");

require ADMINROOT . '/views/inc/header.php';
?>

<!-- page content -->

<div class="right_col" role="main">
    <div class="clearfix"></div>
    <?php flash('rites_msg'); ?>
    <div class="page-title">
        <div class="title_right">
            <h3><?php echo $data['page_title']; ?> <small>عرض  مناسك الحج والعمره </small></h3>
        </div>
        <div class="title_left">
            <a href="<?php echo ADMINURL; ?>/rites" class="btn btn-success pull-left">عودة <i class="fa fa-reply"></i></a>
        </div>
    </div>

    <div class="clearfix"></div>

    <div class="row">
        <div class="col-md-12 col-sm-6 col-xs-12 page-header">
            
            <div class="form-group col-md-6 col-sm-12 col-xs-12">
                <label class="control-label"> الاسم  : </label>
                <div class="bg-white">
                    <?php echo ($data['rites']->title); ?>
                </div>
            </div>
           
            <div class="form-group col-md-6 col-sm-12 col-xs-12">
                <label class="control-label"> المشروع  : </label>
                <div class="bg-white">
                    <?php echo ($data['project']->name); ?>
                </div>
            </div>
        
 
            <div class="form-group col-md-6 col-sm-12 col-xs-12">
                <label class="control-label"> الترتيب  : </label>
                <div class="bg-white">
                    <?php echo ($data['project']->arrangement); ?>
                </div>
            </div>

            <div class="form-group col-md-6 col-sm-12 col-xs-12">
            <label>وقت  </label>
                <div class="bg-white">
                    <?php echo ($data['project']->time_taken); ?> دقيقة
                </div>
            </div>
        
        
       
            <div class="form-group col-md-6 col-sm-12 col-xs-12">
                <label class="control-label"> الاثبات  : </label>
                <div class="bg-white">
                    <?php echo $data['rites']->proof == 1 ? "نعم" : "لا" ; ?>
                </div>
            </div>


            <div class="form-group col-md-6 col-sm-12 col-xs-12">
                <label class="control-label"> حالة النشر   : </label>
                <div class="bg-white p-3">
                    <?php echo ($data['rites']->status == 1 ? "نعم" : "لا"); ?>
                </div>
            </div>

            <div class="col-md-6 col-sm-12">
                <a href="<?php echo empty($data['rites']->image) ? MEDIAURL . '/default.jpg' : MEDIAURL . '/../files/rites/' . $data['rites']->image; ?>" target="_blank"><img class="img-responsive img-rounded" src="<?php echo empty($data['rites']->image) ? MEDIAURL . '/default.jpg' :  MEDIAURL . '/../files/rites/' . $data['rites']->image; ?>" /></a>
            </div>

        </div>
        
            <div class="form-group">
                <a class="btn btn-info" href="<?php echo ADMINURL . '/managers/edit/' . $data['manager']->manager_id; ?>" >تعديل</a>
            </div>
    </div>
</div>

<?php
// loading plugin
$data['footer'] = '';


require ADMINROOT . '/views/inc/footer.php';
