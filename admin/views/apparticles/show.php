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
    <?php flash('appArticle_msg'); ?>
    <div class="page-title">
        <div class="title_right">
            <h3><?php echo $data['page_title']; ?> <small>عرض محتوي الصفحة </small></h3>
        </div>
        <div class="title_left">
            <a href="<?php echo ADMINURL; ?>/apparticles" class="btn btn-success pull-left">عودة <i class="fa fa-reply"></i></a>
        </div>
    </div>
    <div class="form-group">
        <h3 class="prod_title">
            <label class="control-label">الرابط : </label>
            <a href="<?php echo URLROOT . '/apparticles/show/' . $data['article']->article_id; ?>"><?php echo URLROOT . '/apparticles/show/' . $data['article']->article_id; ?></a>
        </h3>
    </div>
    <div class="clearfix"></div>
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="form-group">
                <h3 class="prod_title">
                    <?php echo $data['article']->title; ?>
                </h3>
            </div>
            <div class="well img-thumbnail row">                    
                <img class="img-responsive img-rounded" src="<?php echo empty($data['article']->image) ? MEDIAURL . '/page-default.jpg' : MEDIAURL . '/' . $data['article']->image; ?>" />

            </div>
            <div class="form-group col-md-12">
                <p><?php echo $data['article']->content; ?></p>
            </div>
            <div class="form-group">
                <a class="btn btn-info" href="<?php echo ADMINURL . '/apparticles/edit/' . $data['article']->article_id; ?>" >تعديل</a>
            </div>
        </div>
    </div>
</div>
<?php
// loading plugin
$data['footer'] = '';
require ADMINROOT . '/views/inc/footer.php';
