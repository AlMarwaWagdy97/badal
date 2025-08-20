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
<style>
    .radio label {
        padding-top: 2px;
    }
</style>
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
                <!--  Relations --------------------------------------------------------------------------------------------------------------------------------- -->
                <div class="form-group">
                    <label class="control-label" for="settingTitle">الصفه : </label>
                    <div class="has-feedback">
                        <div id="relation_section" class="parameter_section">
                            <?php if (isset($data['value']->relations)) { ?>
                                <?php foreach ($data['value']->relations as $key => $relation) { ?>
                                    <div class="relations mt-3" style="margin-top: 22px;">
                                        <div class="row">
                                            <div class="col-sm-4">
                                                <input type="text" class="form-control" name="value[relations][]" value="<?= $data['value']->relations[$key]  ?>">
                                            </div>

                                            <div class="col-sm-1">
                                                <button class="btn btn-danger btn-sm delete_var "><i class="fa fa-trash"></i></button>
                                            </div>
                                        </div>
                                    </div>
                                <?php } ?>
                            <?php } ?>
                        </div>
                    </div>
                    <div class="form-group" style="margin-top: 22px;">
                        <button type="button" id="add_relation" class="btn btn-success">اضافه صفه </button>
                    </div>
                </div>
                <hr>

                <!--  Type --------------------------------------------------------------------------------------------------------------------------------- -->
                <div class="form-group">
                    <label class="control-label" for="settingTitle"> النوع : </label>
                    <div id="type_section" class="parameter_section">
                        <?php if (isset($data['value']->types)) { ?>
                            <?php foreach ($data['value']->types as $key => $type) { ?>
                                <div class="types mt-3" style="margin-top: 22px;">
                                    <div class="row">
                                        <div class="col-sm-4">
                                            <input type="text" class="form-control" name="value[types][]" value="<?= $data['value']->types[$key]  ?>">
                                        </div>

                                        <div class="col-sm-1">
                                            <button class="btn btn-danger btn-sm delete_var "><i class="fa fa-trash"></i></button>
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>
                        <?php } ?>
                    </div>
                    <div class="form-group" style="margin-top: 22px;">
                        <button type="button" id="add_type" class="btn btn-success">اضافه نوع </button>
                    </div>
                </div>
                <hr>

                <!--  Language --------------------------------------------------------------------------------------------------------------------------------- -->
                <div class="form-group">
                    <label class="control-label" for="settingTitle"> لغه المعتمر: </label>
                    <div class="has-feedback">
                        <div id="language_section" class="parameter_section">
                            <?php if (isset($data['value']->languages)) { ?>
                                <?php foreach ($data['value']->languages as $key => $language) { ?>
                                    <div class="languages mt-3" style="margin-top: 22px;">
                                        <div class="row">
                                            <div class="col-sm-4">
                                                <input type="text" class="form-control" name="value[languages][]" value="<?= $data['value']->languages[$key]  ?>">
                                            </div>

                                            <div class="col-sm-1">
                                                <button class="btn btn-danger btn-sm delete_var "><i class="fa fa-trash"></i></button>
                                            </div>
                                        </div>
                                    </div>
                                <?php } ?>
                            <?php } ?>
                        </div>
                    </div>
                    <div class="form-group" style="margin-top: 22px;">
                        <button type="button" id="add_language" class="btn btn-success">اضافه لغه </button>
                    </div>
                </div>
                <hr>

                <!--  nationality --------------------------------------------------------------------------------------------------------------------------------- -->
                <div class="form-group">
                    <label class="control-label" for="settingTitle"> جنس المعتمر: </label>
                    <div class="has-feedback">
                        <div id="nationality_section" class="parameter_section">
                            <?php if (isset($data['value']->languages)) { ?>
                                <?php foreach ($data['value']->languages as $key => $nationality) { ?>
                                    <div class="nationality mt-3" style="margin-top: 22px;">
                                        <div class="row">
                                            <div class="col-sm-4">
                                                <input type="text" class="form-control" name="value[nationality][]" value="<?= $data['value']->languages[$key]  ?>">
                                            </div>

                                            <div class="col-sm-1">
                                                <button class="btn btn-danger btn-sm delete_var "><i class="fa fa-trash"></i></button>
                                            </div>
                                        </div>
                                    </div>
                                <?php } ?>
                            <?php } ?>
                        </div>
                    </div>
                    <div class="form-group" style="margin-top: 22px;">
                        <button type="button" id="add_nationality" class="btn btn-success">اضافه لغه </button>
                    </div>
                </div>
                <hr>

                <!--  late of start order --------------------------------------------------------------------------------------------------------------------------------- -->
                <div class="form-group">
                    <div class="row">
                        <div class="col-sm-3">
                            <label for="" class="form-label">مده ساعات الوقت بين العروض <span class="text-danger h6"> </span></label>
                            <input type="number" name="value[offer_time]" value="<?= @$data['value']->offer_time ?>" placeholder="hours" class="form-control col-md-6">
                        </div>
                    </div>
                </div>

                <!--  late of start order --------------------------------------------------------------------------------------------------------------------------------- -->
                <div class="form-group">
                    <div class="row">
                        <div class="col-sm-3">
                            <label for="" class="form-label">مده ساعات تأخير الطلب <span class="text-danger h6"> (عندما الطلب يتاخر , سيتم الغاءه واضافه الحج او العمره من جديد) </span></label>
                            <input type="number" name="value[late_time]" value="<?= @$data['value']->late_time ?>" placeholder="hours" class="form-control col-md-6">
                        </div>
                    </div>
                </div>
                <hr>

                <!--  new license img --------------------------------------------------------------------------------------------------------------------------------- -->
                <div class="form-group">
                    <div class="row">
                        <div class="col-sm-3">
                            <label for="" class="form-label"> رقم الرخصة </label>
                            <input type="hidden" name="value[license_img]" value="<?= $data['value']->license_img; ?>">
                            <input type="file" name="new_license_img"   class="form-control col-md-6">
                        </div>
                        <div class="col-md-2">
                        <a href="<?= URLROOT . "/media/files/badal/" . @$data['value']->license_img ?>" target="_blank">
                            <img src="<?= URLROOT . "/media/files/badal/" .  @$data['value']->license_img ?>" alt="" width="80" height="80" />
                        </a>
                    </div>
                    </div>
                </div>
                <hr>

                <div class="row haij mt-5">
                    <div class="col-md-2">
                        <label for="" class="form-label"> ايكون الحج </label>
                        <input type="hidden" name="value[haij_icon]" value="<?= $data['value']->haij_icon; ?>">
                        <input type="file" name="new_haij_icon" class="form-control col-md-6">

                    </div>
                    <div class="col-md-2">
                        <a href="<?= URLROOT . "/media/files/badal/" . @$data['value']->haij_icon ?>" target="_blank">
                            <img src="<?= URLROOT . "/media/files/badal/" .  @$data['value']->haij_icon ?>" alt="" width="80" height="80" />
                        </a>
                    </div>
                    <div class="col-md-2">
                        <label for="" class="form-label"> صوره الحج </label>
                        <input type="hidden" name="value[haij_image]" value="<?= $data['value']->haij_image; ?>">
                        <input type="file" name="new_haij_image" class="form-control col-md-6">

                    </div>
                    <div class="col-md-2">
                        <a href="<?= URLROOT . "/media/files/badal/" . @$data['value']->haij_image ?>" target="_blank">
                            <img src="<?= URLROOT . "/media/files/badal/" .  @$data['value']->haij_image ?>" alt="" width="80" height="80" />
                        </a>
                    </div>
                    <div class="col-md-2">
                        <label for="" class="form-label"> اسم الحج </label>
                        <input type="text" name="value[haij_text]" value="<?= @$data['value']->haij_text  ?>" class="form-control col-md-6">

                    </div>
                    <div class="col-md-2">
                        <label for="" class="form-label"> حالة الحج </label>
                        <div class="radio">
                            <label for="haij_status_1">
                                <input type="radio" class="flat" name="value[haij_status]" <?= (@$data['value']->haij_status == 1) ? 'checked' : ''; ?> value="1" id="haij_status_1"> مفعلة
                            </label>
                            <label for="haij_status_0">
                                <input type="radio" class="flat" name="value[haij_status]" <?= (@$data['value']->haij_status == '0') ? 'checked' : ''; ?> value="0" id="haij_status_0"> معلقة
                            </label>
                        </div>
                    </div>
                </div>

                <div class="row umrah" style="margin-top: 4rem;">
                    <div class="col-md-2">
                        <input type="hidden" name="value[umrah_icon]" value="<?= $data['value']->umrah_icon; ?>">
                        <label for="" class="form-label"> ايكون العمرة </label>
                        <input type="file" name="new_umrah_icon" class="form-control col-md-6">

                    </div>
                    <div class="col-md-2">
                        <a href="<?= URLROOT . "/media/files/badal/" . @$data['value']->umrah_icon ?>" target="_blank">
                            <img src="<?= URLROOT . "/media/files/badal/" .  @$data['value']->umrah_icon ?>" alt="" width="80" height="80" />
                        </a>
                    </div>
                    <div class="col-md-2">
                        <input type="hidden" name="value[umrah_image]" value="<?= $data['value']->umrah_image; ?>">
                        <label for="" class="form-label"> صوره العمرة </label>
                        <input type="file" name="new_umrah_image" class="form-control col-md-6">

                    </div>
                    <div class="col-md-2">
                        <a href="<?= URLROOT . "/media/files/badal/" . @$data['value']->umrah_image ?>" target="_blank">
                            <img src="<?= URLROOT . "/media/files/badal/" .  @$data['value']->umrah_image ?>" alt="" width="80" height="80" />
                        </a>
                    </div>
                    <div class="col-md-2">
                        <label for="" class="form-label"> اسم العمرة </label>
                        <input type="text" name="value[umrah_text]" value="<?= @$data['value']->umrah_text  ?>" class="form-control col-md-6">
                    </div>
                    <div class="col-md-2">
                        <label for="" class="form-label"> حالة العمرة </label>
                        <div class="radio">
                            <label for="umrah_status_1">
                                <input type="radio" class="flat" name="value[umrah_status]" <?= (@$data['value']->umrah_status == 1) ? 'checked' : ''; ?> value="1" id="umrah_status_1"> مفعلة
                            </label>
                            <label for="umrah_status_0">
                                <input type="radio" class="flat" name="value[umrah_status]" <?= (@$data['value']->umrah_status == '0') ? 'checked' : ''; ?> value="0" id="umrah_status_0"> معلقة
                            </label>
                        </div>
                    </div>
                </div>
                <hr>


                <div class="form-group col-xs-12 ">
                    <label class="control-label">تفعيل البوابة :</label>
                    <div class="radio">
                        <label for="badalenabled_1">
                            <input type="radio" class="flat" name="value[badalenabled]" <?= (@$data['value']->badalenabled == 1) ? 'checked' : ''; ?> value="1" id="badalenabled_1"> مفعلة
                        </label>
                        <label for="badalenabled_0">
                            <input type="radio" class="flat" name="value[badalenabled]" <?= (@$data['value']->badalenabled == '0') ? 'checked' : ''; ?> value="0" id="badalenabled_0"> معلقة
                        </label>
                    </div>
                </div>


                <div class="form-group col-xs-12 ">
                    <label class="control-label"> اختيار المشاريع لتظهر عند انتهاء طلب البدل :</label>
                    <div class="radio">

                    </div>
                    <?php
                    foreach ($data['projects'] as $project) {
                        echo '<div class="col-md-3">';
                        if (in_array($project->project_id, @$data['value']->badal_selected_projects ? (json_decode(@$data['value']->badal_selected_projects)) : [])) {
                            echo '<label class="btn btn-secondary  m-1">
                                            <input type="checkbox" ' . ' checked name="value[badal_selected_projects][' . $project->project_id . ']"  class="donation-value" > ' . $project->name . '
                                        </label>';
                        } else {
                            echo '<label class="btn btn-secondary  m-1">
                                            <input type="checkbox" ' . ' name="value[badal_selected_projects][' . $project->project_id . ']"  class="donation-value" > ' . $project->name . '
                                        </label>';
                        }
                        echo '</div>';
                    }

                    ?>
                </div>

                <div class="form-group col-xs-12 ">


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

        $('#add_relation').on('click', function() {
            $('#relation_section').append(
                `<div class="relations" >
                        <div class="row mt-3" style="margin-top: 22px;">
                            <div class="col-sm-4">
                                <input type="text" class="form-control" name="value[relations][]">
                            </div>
                            <div class="col-sm-1">
                                <button class="btn btn-danger btn-sm delete_var"><i class="fa fa-trash"></i></button>
                            </div>
                        </div>
                    </div>
                `
            );
        });

        $('#add_type').on('click', function() {
            $('#type_section').append(
                `<div class="types" >
                        <div class="row mt-3" style="margin-top: 22px;">
                            <div class="col-sm-4">
                                <input type="text" class="form-control" name="value[types][]">
                            </div>
                            <div class="col-sm-1">
                                <button class="btn btn-danger btn-sm delete_var"><i class="fa fa-trash"></i></button>
                            </div>
                        </div>
                    </div>
                `
            );
        });

        $('#add_language').on('click', function() {
            $('#language_section').append(
                `<div class="languages" >
                        <div class="row mt-3" style="margin-top: 22px;">
                            <div class="col-sm-4">
                                <input type="text" class="form-control" name="value[languages][]">
                            </div>
                            <div class="col-sm-1">
                                <button class="btn btn-danger btn-sm delete_var"><i class="fa fa-trash"></i></button>
                            </div>
                        </div>
                    </div>
                `
            );
        });

        $('#add_nationality').on('click', function() {
            $('#nationality_section').append(
                `<div class="nationality" >
                        <div class="row mt-3" style="margin-top: 22px;">
                            <div class="col-sm-4">
                                <input type="text" class="form-control" name="value[nationality][]">
                            </div>
                            <div class="col-sm-1">
                                <button class="btn btn-danger btn-sm delete_var"><i class="fa fa-trash"></i></button>
                            </div>
                        </div>
                    </div>
                `
            );
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
