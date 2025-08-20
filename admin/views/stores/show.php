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
    <?php flash('projecttag_msg');?>
    <div class="page-title">
        <div class="title_right">
            <h3><?php echo $data['page_title']; ?> <small>عرض محتوي الصفحة </small></h3>
        </div>
        <div class="title_left">
            <a href="<?php echo ADMINURL; ?>/projecttags" class="btn btn-success pull-left">عودة <i class="fa fa-reply"></i></a>
        </div>
    </div>

    <div class="clearfix"></div>

    <div class="row">
        <div class="col-md-12 col-sm-12">
            <div class="form-group">
                <h3 class="prod_title">
                    <?php echo $data['projecttag']->name; ?>
                </h3>
            </div>
            
            <div class="form-group">
                <h3 class="prod_title">
                    <label class="control-label">الرابط : </label>
                    <a href="<?php echo URLROOT . '/tags/show/' . $data['projecttag']->tag_id; ?>"><?php echo URLROOT . '/tags/show/' . $data['projecttag']->tag_id; ?></a>
                </h3>
            </div>
            <div class="well img-thumbnail col-md-6 col-sm-12">
                <img class="img-responsive img-rounded" src="<?php echo empty($data['projecttag']->image) ? MEDIAURL . '/default.jpg' : MEDIAURL . '/' . $data['projecttag']->image; ?>" />

            </div>
            <div class="form-group col-md-6 col-sm-12">
                <label class="control-label">الوصف : </label>
                <p><?php echo $data['projecttag']->description ?: 'لا يوجد'; ?></p>
            </div>
            <div class="form-group col-md-6 col-sm-12">
                <label class="control-label">الترتيب : </label>
                <p><?php echo $data['projecttag']->arrangement; ?></p>
            </div>
            <div class="form-group col-md-6 col-sm-12">
                <label class="control-label">العودة للرئيسية : </label>
                <p><?php echo $data['projecttag']->back_home ? 'نعم' : 'لا'; ?></p>
            </div>
            <div class="form-group col-md-6 col-sm-12">
                <label class="control-label">مميزة : </label>
                <p><?php echo $data['projecttag']->featured ? 'نعم' : 'لا'; ?></p>
            </div>
            <div class="form-group col-md-6 col-sm-12">
                <label class="control-label">حالة النشر : </label>
                <p><?php echo $data['projecttag']->status ? 'منشور' : 'غير منشور'; ?></p>
            </div>
            <div class="form-group col-md-6 col-sm-12">
                <label class="control-label">اخر تحديث : </label>
                <p><?php echo $data['projecttag']->modified_date ? date('d/ M/ Y', $data['projecttag']->modified_date) : 'لا'; ?></p>
            </div>            
            <div class="form-group col-md-6 col-sm-12">
                <label class="control-label">وقت الإنشاء : </label>
                <p><?php echo $data['projecttag']->create_date ? date('d/ M/ Y', $data['projecttag']->create_date) : 'لا'; ?></p>
            </div>
            <div class="form-group col-md-6 col-sm-12">
                <label class="control-label">وصف مختصر لمحرك البحث : </label>
                <div class="well">
                    <?php echo $data['projecttag']->meta_description ?: 'لا يوجد'; ?>
                </div>
            </div>
            <div class="form-group col-md-6 col-sm-12">
                <label class="control-label tags">الكلمات الدلالية    :</label>
                <div class=" well">
                    <?php echo $data['projecttag']->meta_keywords ?: 'لا يوجد'; ?>
                </div>
            </div>
            <div class="form-group">
                <a class="btn btn-info" href="<?php echo ADMINURL . '/projecttags/edit/' . $data['projecttag']->tag_id; ?>" >تعديل</a>
            </div>


        </div>
    </div>
</div>

<?php
// loading plugin
$data['footer'] = '';

require ADMINROOT . '/views/inc/footer.php';
