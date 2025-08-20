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
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <form action="<?php echo ADMINURL . '/settings/edit/' . $data['setting_id']; ?>" method="post" enctype="multipart/form-data" accept-charset="utf-8">
                <div class="form-group">
                    <label class="control-label" for="settingTitle">عنوان الاعداد : </label>
                    <div class="has-feedback">
                        <input type="text" id="settingTitle" class="form-control" name="title" placeholder="عنوان الاعداد" value="<?php echo $data['title']; ?>">
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label" for="settingTitle">facebook : </label>
                    <div class="has-feedback">
                        <input type="text" id="settingTitle" class="form-control" name="value[facebook]" placeholder="رابط  facebook" value="<?php echo $data['value']->facebook; ?>">
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label" for="settingTitle">twitter : </label>
                    <div class="has-feedback">
                        <input type="text" id="settingTitle" class="form-control" name="value[twitter]" placeholder="رابط  twitter" value="<?php echo $data['value']->twitter; ?>">
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label" for="settingTitle">instagram : </label>
                    <div class="has-feedback">
                        <input type="text" id="settingTitle" class="form-control" name="value[instagram]" placeholder="رابط  instagram" value="<?php echo $data['value']->instagram; ?>">
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label" for="settingTitle">linkedin : </label>
                    <div class="has-feedback">
                        <input type="text" id="settingTitle" class="form-control" name="value[linkedin]" placeholder="رابط  linkedin" value="<?php echo $data['value']->linkedin; ?>">
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label" for="settingTitle"> Tiktok : </label>
                    <div class="has-feedback">
                        <input type="text" id="settingTitle" class="form-control" name="value[tiktok]" placeholder="رابط  linkedin" value="<?php echo $data['value']->tiktok; ?>">
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label" for="settingTitle">youtube : </label>
                    <div class="has-feedback">
                        <input type="text" id="settingTitle" class="form-control" name="value[youtube]" placeholder="رابط  youtube" value="<?php echo $data['value']->youtube; ?>">
                    </div>
                </div>

                <hr>
                <h2> :ترتيب الشير</h2>
                <div class="row">
                    <div class="col-md-3">
                        <label class="control-label" for="settingTitle">whatsapp : </label>
                        <input type="number" class="form-control" name="value[sort][whatsapp]" value="<?php echo @$data['value']->sort->whatsapp ?? 1; ?>">
                    </div>
                    <div class="col-md-3">
                        <label class="control-label" for="settingTitle">Facebook : </label>
                        <input type="number" class="form-control" name="value[sort][facebook]" value="<?php echo @$data['value']->sort->facebook ?? 2; ?>">
                    </div>
                    <div class="col-md-3">
                        <label class="control-label" for="settingTitle">Twitter : </label>
                        <input type="number" class="form-control" name="value[sort][twitter]" value="<?php echo @$data['value']->sort->twitter ?? 3; ?>">
                    </div>
                    <div class="col-md-3">
                        <label class="control-label" for="settingTitle">Email : </label>
                        <input type="number" class="form-control" name="value[sort][email]" value="<?php echo @$data['value']->sort->email ?? 4; ?>">
                    </div>
                </div>
                <hr>

                <h2> :اللوان الشير</h2>
                <div class="row">
                    <div class="col-md-3">
                        <label class="control-label" for="settingTitle">السليدر : </label>
                        <input type="text" class="colorpicker form-control" name="value[color][slider]" value="<?php echo @$data['value']->color->slider ?? "FFF"; ?>">
                    </div>
                    <div class="col-md-3">
                        <label class="control-label" for="settingTitle">اقسام المنتجات : </label>
                        <input type="text" class="colorpicker form-control" name="value[color][categories]" value="<?php echo @$data['value']->color->categories ?? "FFF"; ?>">
                    </div>
                    <div class="col-md-3">
                        <label class="control-label" for="settingTitle">المنتجات : </label>
                        <input type="text" class="colorpicker form-control" name="value[color][products]" value="<?php echo @$data['value']->color->products ?? "FFF"; ?>">
                    </div>
                    <div class="col-md-3">
                        <label class="control-label" for="settingTitle">الاعلانات : </label>
                        <input type="text" class="colorpicker form-control" name="value[color][ads]" value="<?php echo @$data['value']->color->ads ?? "FFF"; ?>">
                    </div>
                </div>
                <hr>
                <div class="form-group">
                    <br>
                    <h2> : محتوي شير الواتس</h2>
                    <button type="button" class="btn btn-primary" onclick="$('#whatsShare').val($('#whatsShare').val() +'[[name]]') ;return false;" value=""> ارفاق الاسم </button>
                    <button type="button" class="btn btn-primary" onclick="$('#whatsShare').val($('#whatsShare').val() +'[[link]]') ;return false;" value="">ارفاق  الرابط  </button>
                    <small class="red ">سيتم استبدال المتغير الخاص بالقيمة </small>
                </div>
                <div class="form-group">
                    <label class="control-label">المحتوي : </label>
                    <div class="row">
                        <textarea id="whatsShare" name="value[whatsapp_content]" rows="6" class="form-control"><?php echo (@$data['value']->whatsapp_content); ?></textarea>
                    </div>
                </div>
                <hr>


                <div class="col-md-9 col-sm-9 col-xs-12 col-md-offset-3">
                    <button type="submit" name="save" class="btn btn-success">تعديل
                        <i class="fa fa-save"> </i></button>
                    <button type="submit" name="submit" class="btn btn-success">تعديل وعودة
                        <i class="fa fa-save"> </i></button>
                    <button type="reset" class="btn btn-danger">مسح
                        <i class="fa fa-trash "> </i></button>
                </div>

            </form>

        </div>
    </div>
</div>

<?php
// loading plugin
$data['footer'] = '<script src="' . ADMINURL . '/template/default/vendors/jquery.tagsinput/src/jquery.tagsinput.js"></script>' . "\n";

require ADMINROOT . '/views/inc/footer.php';
