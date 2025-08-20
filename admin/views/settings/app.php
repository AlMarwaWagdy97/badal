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

<!-- setting content -->

<div class="right_col" role="main">
    <div class="clearfix"></div>
    <?php flash('setting_msg'); ?>
    <div class="setting-title">
        <div class="title_right">
            <h3><small>التعديل علي </small><?php echo $data['title']; ?> </h3>
        </div>
        <div class="title_left">
            <a href="<?php echo ADMINURL; ?>/settings" class="btn btn-success pull-left">عودة <i class="fa fa-reply"></i></a>
        </div>
    </div>
    <div class="clearfix"></div>
    <form class="row" action="<?php echo ADMINURL . '/settings/edit/' . $data['setting_id']; ?>" method="post" enctype="multipart/form-data" accept-charset="utf-8">
        <div class="form-group col-xs-12">
            <label class="control-label" for="settingTitle">عنوان الاعداد : </label>
            <div class="has-feedback">
                <input type="text" id="settingTitle" class="form-control" name="title" placeholder="عنوان الاعداد" value="<?php echo $data['title']; ?>">
            </div>
        </div>

        <div class="form-group col-xs-12">
            <label class="control-label" for="intro">صورة واجهة التطبيق : </label>
            <div class="glr-group ">
                <a data-toggle="modal" href="javascript:;" data-target="#myModal" class="glr-btn col-xs-2" type="button">اختيار</a>
                <input id="intro" readonly name="value[intro]" class="glr-control  col-xs-9" type="text" value="<?php echo $data['value']->intro; ?>">
                <a class="text-danger fa-lg" onclick="$('#intro').val('');">&nbsp<i class="fa fa-close fa-lg  "></i></a>
            </div>
            <div class="modal fade" id="myModal" style=" margin-left: 0px;">
                <div class="modal-dialog" style="width: 80%;">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            <h4 class="modal-title">اختيار الصور</h4>
                        </div>
                        <div class="modal-body">
                            <iframe width="100%" height="500" src="<?php echo ADMINURL; ?>/helpers/filemanager/dialog.php?type=2&field_id=intro&relative_url=1" frameborder="0" style="overflow: scroll; overflow-x: hidden; overflow-y: scroll; "></iframe>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="form-group col-md-4">
            <label class="control-label">رابط الفيديو الاعلاني Youtube : </label>
            <div class="row">
                <input type="text" id="video" class="form-control" name="value[video]" placeholder="رابط الفيديو الاعلاني" value="<?php echo $data['value']->video; ?>">
            </div>
        </div>
        <div class="form-group col-md-2">
            <label class="control-label"> تشغيل الفيديو بعد مرور [ ] ثانية</label>
            <div class="row">
                <input type="text" id="video" class="form-control" name="value[video_time]" placeholder="رابط الفيديو الاعلاني" value="<?php echo $data['value']->video_time; ?>">
            </div>
        </div>
        <div class="form-group col-md-5 ">
            <label class="control-label">حالة الفيديو :</label>
            <div class="radio pt-0">
                <label>
                    <input type="radio" class="flat" <?php echo ($data['value']->show_video == 1) ? 'checked' : ''; ?> value="1" name="value[show_video]"> اظهار الفيديو
                </label>
                <label>
                    <input type="radio" class="flat" <?php echo ($data['value']->show_video == '0') ? 'checked' : ''; ?> value="0" name="value[show_video]"> اخفاء الفيديو
                </label>
            </div>
        </div>

        <div class="form-group col-md-6">
            <label class="control-label"> رابط البنر الاعلاني </label>
            <div class="row">
                <input type="text" id="footer_ads_url" class="form-control" name="value[footer_ads_url]" placeholder="رابط البنر الاعلاني" value="<?php echo $data['value']->footer_ads_url; ?>">
            </div>
        </div>
        <div class="form-group col-md-6">
            <label class="control-label"> البنر الاعلاني </label>
            <div class="row">
                <input type="text" class="form-control" name="value[footer_ads]" placeholder=" البنر الاعلاني" value="<?php echo $data['value']->footer_ads; ?>">
            </div>
        </div>
        
        <div class="form-group col-md-6">
            <label class="control-label"> token </label>
            <div class="row">
                <input type="text" id="token" class="form-control" name="value[token]" placeholder="رابط البنر الاعلاني" value="<?php echo $data['value']->token; ?>">
            </div>
        </div>
        <br class="clear">
        <!--  new license img --------------------------------------------------------------------------------------------------------------------------------- -->
        <div class="form-group">
            <div class="row">
                <div class="col-sm-3">
                    <label for="" class="form-label"> رقم الرخصة </label>
                    <input type="hidden" name="value[license_img]" value="<?= $data['value']->license_img; ?>">
                    <input type="file" name="new_license_img" class="form-control col-md-6">
                </div>
                <div class="col-md-2">
                    <a href="<?= URLROOT . "/media/files/badal/" . @$data['value']->license_img ?>" target="_blank">
                        <img src="<?= URLROOT . "/media/files/badal/" .  @$data['value']->license_img ?>" alt="" width="80" height="80" />
                    </a>
                </div>
            </div>
        </div>
        <hr>
        <br class="clear">
        <div class="col-xs-6"><br><br>
            <button type="submit" name="save" class="btn btn-success">تعديل
                <i class="fa fa-save"> </i></button>
            <button type="submit" name="submit" class="btn btn-success">تعديل وعودة
                <i class="fa fa-save"> </i></button>
            <button type="reset" class="btn btn-danger">مسح
                <i class="fa fa-trash "> </i></button>
        </div>
    </form>
</div>

<?php
$data['footer'] = '';
require ADMINROOT . '/views/inc/footer.php';
