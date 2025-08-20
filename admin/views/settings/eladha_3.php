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
<div class="right_col" role="main">
    <div class="clearfix"></div>
    <?php flash('setting_msg'); ?>
    <div class="setting-title">
        <div class="title_right">
            <h3><small>التعديل علي </small><?= $data['title']; ?> </h3>
        </div>
        <div class="title_left">
            <a href="<?= ADMINURL; ?>/settings" class="btn btn-success pull-left">عودة <i class="fa fa-reply"></i></a>
        </div>
    </div>
    <div class="clearfix"></div>
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <form action="<?= ADMINURL . '/settings/edit/' . $data['setting_id']; ?>" method="post" enctype="multipart/form-data" accept-charset="utf-8">
                <div class="form-group">
                    <label class="control-label" for="settingTitle">عنوان الاعداد : </label>
                    <div class="has-feedback">
                        <input type="text" id="settingTitle" class="form-control" name="title" placeholder="عنوان الاعداد" value="<?= $data['title']; ?>">
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label" for="settingTitle">الرابط :  </label>
                    <a class="text-danger" href="<?= URLROOT . '/tracking/eladha3' ?>" target="_blank"><?= URLROOT . 'tracking/eladha3' ?></a>
                </div>

                <div class="form-group">
                    <label class="control-label" for="settingTitle">عنوان الصفحه : </label>
                    <div class="has-feedback">
                        <input type="text" class="form-control" name="value[title]" placeholder="عنوان الصفحه" value="<?= @$data['value']->title; ?>">
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-md-6">
                        <label class="control-label" for="settingTitle">لوجو الصفحه : </label>
                        <div class="has-feedback">
                            <input type="hidden" name="value[logo]" value="<?= @$data['value']->logo; ?>">
                            <input type="file" class="form-control" name="new_logo" placeholder="لوجو الصفحه " value="">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <?php if (@$data['value']->logo != null) { ?>
                            <div class="form-group">
                                <a href="<?= URLROOT. '/media/files/eladha/' . @$data['value']->logo ?>">
                                    <img src="<?= URLROOT . '/media/files/eladha/' . @$data['value']->logo ?>" alt="<?= @$data['value']->title; ?>" width="150">
                                </a>
                            </div>
                        <?php } ?>
                    </div>
                </div>
                <hr>

                <!--  tracking --------------------------------------------------------------------------------------------------------------------------------- -->
                <div class="form-group">
                    <label class="control-label" for="settingTitle">الصفه : </label>
                    <div class="has-feedback">
                        <div id="tracking_section" class="parameter_section">
                            <?php if (isset($data['value']->tracking)) {   ?>
                                <?php foreach ($data['value']->tracking->name as $key => $track) {  ?>
                                    <div class="tracking mt-3" style="margin-top: 22px;">
                                        <div class="row">
                                            <div class="col-sm-4 col-md-3">
                                                <label for="">الاسم </label>
                                                <input type="text" required class="form-control" name="value[tracking][name][]" value="<?= @$data['value']->tracking->name[$key] ?>">
                                            </div>
                                            <div class="col-sm-4 col-md-3">
                                                <label for="">بداء</label>
                                                <select name="value[tracking][start][]" required class="form-control">
                                                    <option value="2" <?= @$data['value']->tracking->start[$key] == 2 ? 'selected' : '' ?>> لا </option>
                                                    <option value="1" <?= @$data['value']->tracking->start[$key] == 1 ? 'selected' : '' ?>> نعم </option>
                                                </select>
                                            </div>
                                            <div class="col-sm-4 col-md-3">
                                                <label for="">انتهي</label>
                                                <select name="value[tracking][end][]" required class="form-control">
                                                    <option value="2" <?= @$data['value']->tracking->end[$key] == 2 ? 'selected' : '' ?>> لا </option>
                                                    <option value="1" <?= @$data['value']->tracking->end[$key] == 1 ? 'selected' : '' ?>> نعم </option>
                                                </select>
                                            </div>
                                            <div class="col-sm-4 col-md-12"></div>
                                            
                                            
                                            <div class="col-sm-4 col-md-3">
                                                <label for="">لوجو </label>
                                                <input type="hidden" name="value[tracking][logo][]" value="<?= @$data['value']->tracking->logo[$key] ?>">
                                                <input type="file" class="form-control" name="tracking_logo_<?= $key?>">
                                            </div>
                                            <div class="col-sm-4 col-md-3">
                                                <label for="">الفيديو </label>
                                                <input type="hidden" name="value[tracking][video][]" class="video" value="<?= @$data['value']->tracking->video[$key] ?>">
                                                <input type="file" class="form-control" name="tracking_video_<?= $key?>">
                                            </div>

                                            <div class="col-sm-4 col-md-2" style="margin-top: 27px;">
                                                <?php if (@$data['value']->tracking->logo[$key]!= null) { ?>
                                                    <div class="form-group">
                                                        <a href="<?= URLROOT. '/media/files/eladha/' . @$data['value']->tracking->video[$key] ?>">
                                                            <img src="<?= URLROOT . '/media/files/eladha/' . @$data['value']->tracking->logo[$key] ?>" alt="<?= @$data['value']->tracking->logo[$key] ?>" width="50">
                                                        </a>
                                                    </div>
                                                <?php } ?>
                                            </div>
                                            <div class="col-sm-4 col-md-2">
                                                <?php if (@$data['value']->tracking->video[$key]!= null) { ?>
                                                    <div class="form-group">
                                                        <a href="<?= URLROOT . '/media/files/eladha/' . @$data['value']->tracking->video[$key] ?>" target="_blank" class="video-show">
                                                            <p class="mt-3" style="margin-top: 27px;">مشاهدة الفيديو</p>
                                                        </a>
                                                        <button type="button" class="video-delete btn btn-sm btn-danger">مسح الفيديو</a>
                                                    </div>
                                                <?php } ?>
                                            </div>

                                            <div class="col-sm-1 col-md-1" style="margin-top: 25px">
                                                <button class="btn btn-danger btn-sm delete_var mt-5"><i class="fa fa-trash"></i></button>
                                            </div>
                                        </div>
                                    </div>
                                    <hr>
                                <?php }  ?>
                            <?php } ?>
                        </div>
                    </div>
                    <div class="form-group" style="margin-top: 22px;">
                        <button type="button" id="add_track" class="btn btn-success">اضافه  </button>
                    </div>
                </div>






                <div class="form-group col-xs-12 ">
                    <label class="control-label">تفعيل البوابة :</label>
                    <div class="radio">
                        <label>
                            <input type="radio" class="flat" name="value[eladhaenabled]" <?= (@$data['value']->eladhaenabled == 1) ? 'checked' : ''; ?> value="1"> مفعلة
                        </label>
                        <label>
                            <input type="radio" class="flat" name="value[eladhaenabled]" <?= (@$data['value']->eladhaenabled == '0') ? 'checked' : ''; ?> value="0"> معلقة
                        </label>
                    </div>
                </div>


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


<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
<script>
    $(document).ready(function() {


        $('#add_track').on('click', function() {
            $('#tracking_section').append(
                `<div class="tracking" >
                    <div class="row mt-3" style="margin-top: 22px;">
                        <div class="col-sm-4 col-md-3">
                            <label for="">الاسم </label>
                            <input type="text" required class="form-control" name="value[tracking][name][]" >
                        </div>
                        <div class="col-sm-4 col-md-3">
                            <label for="">بداء</label>
                            <select name="value[tracking][start][]" required class="form-control">
                                <option value="2"> لا </option>
                                <option value="1"> نعم </option>
                            </select>
                        </div>
                        <div class="col-sm-4 col-md-3">
                            <label for="">انتهي</label>
                            <select name="value[tracking][end][]" required class="form-control">
                                <option value="2" > لا </option>
                                <option value="1"> نعم </option>
                            </select>
                        </div>
                        <div class="col-sm-4 col-md-12"></div>

                        <div class="col-sm-1">
                            <button class="btn btn-danger btn-sm delete_var"><i class="fa fa-trash"></i></button>
                        </div>
                    </div>
                </div>
                `
            );
        });



        $('.video-delete').on('click', function() {
            $(this).parent().parent().parent().find('.video').val("");
            $(this).parent().parent().parent().find('.video-show').hide();
            $(this).hide("");
        });


        $('.parameter_section').on('click', '.delete_var', function(e) {
            $(this).parent().parent().remove();
        })
    });
</script>

<?php


// loading plugin
$data['footer'] = '<script src="' . ADMINURL . '/template/default/vendors/jquery.tagsinput/src/jquery.tagsinput.js"></script>' . "\n";

require ADMINROOT . '/views/inc/footer.php';
