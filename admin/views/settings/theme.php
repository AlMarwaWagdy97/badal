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
    <?php flash('setting_msg');?>
    <div class="setting-title">
        <div class="title_right">
            <h3><small>التعديل علي  </small><?php echo $data['title']; ?> </h3>
        </div>
        <div class="title_left">
            <a href="<?php echo ADMINURL; ?>/settings" class="btn btn-success pull-left">عودة <i class="fa fa-reply"></i></a>
        </div>
    </div>
    <div class="clearfix"></div>
        <form class="row" action="<?php echo ADMINURL . '/settings/edit/' . $data['setting_id']; ?>" method="post" enctype="multipart/form-data" accept-charset="utf-8" >
            <div class="form-group col-xs-12">
                <label class="control-label" for="settingTitle">عنوان الاعداد : </label>
                <div class="has-feedback">
                    <input type="text" id="settingTitle" class="form-control" name="title" placeholder="عنوان الاعداد" value="<?php echo $data['title']; ?>">
                </div>
            </div>
            <div class="form-group col-xs-6">
                <label class="control-label" for="settingTitle">لون الخلفية : </label>
                <div class="has-feedback">
                    <input type="text" class="form-control colorpicker" name="value[background_color]" placeholder="لون الخلفية" value="<?php echo $data['value']->background_color; ?>">
                </div>
            </div>
            <div class="form-group col-xs-6">
                <label class="control-label" for="settingTitle">اللون الاساسي : </label>
                <div class="has-feedback">
                    <input type="text" class="form-control colorpicker" name="value[primary_color]" placeholder="اللون الاساسي" value="<?php echo $data['value']->primary_color; ?>">
                </div>
            </div>
            <div class="form-group col-xs-12">
                <label class="control-label" for="background_image">صورة الخلفية :
                </label>
                <div class="glr-group ">
                    <a data-toggle="modal"  href="javascript:;" data-target="#myModal" class="glr-btn col-xs-2" type="button">اختيار</a>
                    <input  id="background_image" readonly name="value[background_image]" class="glr-control  col-xs-9" type="text" value="<?php echo $data['value']->background_image; ?>" >
                    <a class="text-danger fa-lg" onclick="$('#background_image').val('');">&nbsp<i class="fa fa-close fa-lg  "></i></a>
                </div>
                <!-- /.modal -->
                <div class="modal fade" id="myModal" style=" margin-left: 0px;">
                    <div class="modal-dialog" style="width: 80%;">
                        <div class="modal-content">
                            <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            <h4 class="modal-title">اختيار الصور</h4>
                            </div>
                            <div class="modal-body" >
                            <iframe width="100%" height="500" src="<?php echo ADMINURL; ?>/helpers/filemanager/dialog.php?type=2&field_id=background_image&relative_url=1" frameborder="0" style="overflow: scroll; overflow-x: hidden; overflow-y: scroll; "></iframe>
                            </div>
                        </div><!-- /.modal-content -->
                    </div><!-- /.modal-dialog -->
                </div>
                <!-- /.modal -->
            </div>
            <div class="form-group col-xs-6">
                <label class="control-label" for="banner_image">صورة الفاصل اسفل البنر :
                </label>
                <div class="glr-group ">
                    <a data-toggle="modal"  href="javascript:;" data-target="#myModal1" class="glr-btn col-xs-2" type="button">اختيار</a>
                    <input  id="banner_image" readonly name="value[banner_image]" class="glr-control  col-xs-9" type="text" value="<?php echo $data['value']->banner_image; ?>" >
                    <a class="text-danger fa-lg" onclick="$('#banner_image').val('');">&nbsp<i class="fa fa-close fa-lg  "></i></a>
                </div>
                <!-- /.modal -->
                <div class="modal fade" id="myModal1" style=" margin-left: 0px;">
                    <div class="modal-dialog" style="width: 80%;">
                        <div class="modal-content">
                            <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            <h4 class="modal-title">اختيار الصور</h4>
                            </div>
                            <div class="modal-body" >
                            <iframe width="100%" height="500" src="<?php echo ADMINURL; ?>/helpers/filemanager/dialog.php?type=2&field_id=banner_image&relative_url=1" frameborder="0" style="overflow: scroll; overflow-x: hidden; overflow-y: scroll; "></iframe>
                            </div>
                        </div><!-- /.modal-content -->
                    </div><!-- /.modal-dialog -->
                </div>
                <!-- /.modal -->
            </div>
            <div class="form-group col-xs-6">
                <label class="control-label">رابط الفاصل اسفل البنر : </label>
                <div class="has-feedback">
                    <input type="text" class="form-control" name="value[banner_image_url]" placeholder="رابط الفاصل اسفل البنر" value="<?php echo $data['value']->banner_image_url; ?>">
                </div>
            </div><br class="clear">
            <div class="form-group col-xs-6">
                <label class="control-label" for="projects_image">صورة الفاصل اسفل المشروعات :
                </label>
                <div class="glr-group ">
                    <a data-toggle="modal"  href="javascript:;" data-target="#myModal2" class="glr-btn col-xs-2" type="button">اختيار</a>
                    <input  id="projects_image" readonly name="value[projects_image]" class="glr-control  col-xs-9" type="text" value="<?php echo $data['value']->projects_image; ?>" >
                    <a class="text-danger fa-lg" onclick="$('#projects_image').val('');">&nbsp<i class="fa fa-close fa-lg  "></i></a>
                </div>
                <!-- /.modal -->
                <div class="modal fade" id="myModal2" style=" margin-left: 0px;">
                    <div class="modal-dialog" style="width: 80%;">
                        <div class="modal-content">
                            <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            <h4 class="modal-title">اختيار الصور</h4>
                            </div>
                            <div class="modal-body" >
                            <iframe width="100%" height="500" src="<?php echo ADMINURL; ?>/helpers/filemanager/dialog.php?type=2&field_id=projects_image&relative_url=1" frameborder="0" style="overflow: scroll; overflow-x: hidden; overflow-y: scroll; "></iframe>
                            </div>
                        </div><!-- /.modal-content -->
                    </div><!-- /.modal-dialog -->
                </div>
                <!-- /.modal -->
            </div>
            <div class="form-group col-xs-6">
                <label class="control-label">رابط الفاصل اسفل المشروعات : </label>
                <div class="has-feedback">
                    <input type="text" class="form-control" name="value[projects_image_url]" placeholder="رابط الفاصل اسفل المشروعات" value="<?php echo $data['value']->projects_image_url; ?>">
                </div>
            </div><br class="clear">
            <div class="form-group col-xs-6">
                <label class="control-label" for="categories_image">صورة الفاصل اسفل الاقسام :
                </label>
                <div class="glr-group ">
                    <a data-toggle="modal"  href="javascript:;" data-target="#myModal3" class="glr-btn col-xs-2" type="button">اختيار</a>
                    <input  id="categories_image" readonly name="value[categories_image]" class="glr-control  col-xs-9" type="text" value="<?php echo $data['value']->categories_image; ?>" >
                    <a class="text-danger fa-lg" onclick="$('#categories_image').val('');">&nbsp<i class="fa fa-close fa-lg  "></i></a>
                </div>
                <!-- /.modal -->
                <div class="modal fade" id="myModal3" style=" margin-left: 0px;">
                    <div class="modal-dialog" style="width: 80%;">
                        <div class="modal-content">
                            <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            <h4 class="modal-title">اختيار الصور</h4>
                            </div>
                            <div class="modal-body" >
                            <iframe width="100%" height="500" src="<?php echo ADMINURL; ?>/helpers/filemanager/dialog.php?type=2&field_id=categories_image&relative_url=1" frameborder="0" style="overflow: scroll; overflow-x: hidden; overflow-y: scroll; "></iframe>
                            </div>
                        </div><!-- /.modal-content -->
                    </div><!-- /.modal-dialog -->
                </div>
                <!-- /.modal -->
            </div>
            <div class="form-group col-xs-6">
                <label class="control-label">رابط الفاصل اسفل الاقسام : </label>
                <div class="has-feedback">
                    <input type="text" class="form-control" name="value[categories_image_url]" placeholder="رابط الفاصل اسفل الاقسام" value="<?php echo $data['value']->categories_image_url; ?>">
                </div>
            </div><br class="clear">
            <div class="form-group col-xs-6">
                <label class="control-label" for="categories_image2"> صورة الفاصل اسفل الاقسام :</label> 2
                <div class="glr-group ">
                    <a data-toggle="modal"  href="javascript:;" data-target="#myModal4" class="glr-btn col-xs-2" type="button">اختيار</a>
                    <input  id="categories_image2" readonly name="value[categories_image2]" class="glr-control  col-xs-9" type="text" value="<?php echo $data['value']->categories_image2; ?>" >
                    <a class="text-danger fa-lg" onclick="$('#categories_image2').val('');">&nbsp<i class="fa fa-close fa-lg  "></i></a>
                </div>
                <!-- /.modal -->
                <div class="modal fade" id="myModal4" style=" margin-left: 0px;">
                    <div class="modal-dialog" style="width: 80%;">
                        <div class="modal-content">
                            <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            <h4 class="modal-title">اختيار الصور</h4>
                            </div>
                            <div class="modal-body" >
                            <iframe width="100%" height="500" src="<?php echo ADMINURL; ?>/helpers/filemanager/dialog.php?type=2&field_id=categories_image2&relative_url=1" frameborder="0" style="overflow: scroll; overflow-x: hidden; overflow-y: scroll; "></iframe>
                            </div>
                        </div><!-- /.modal-content -->
                    </div><!-- /.modal-dialog -->
                </div>
                <!-- /.modal -->
            </div>
            <div class="form-group col-xs-6">
                <label class="control-label">رابط الفاصل اسفل  الاقسام 2  : </label>
                <div class="has-feedback">
                    <input type="text" class="form-control" name="value[categories_image2_url]" placeholder="رابط الفاصل اسفل  الاقسام 2 " value="<?php echo $data['value']->categories_image2_url; ?>">
                </div>
            </div><br class="clear">
            <div class="form-group col-xs-6">
                <label class="control-label" for="categories_image3">صورة الفاصل اسفل الاقسام :</label> 3 
                <div class="glr-group ">
                    <a data-toggle="modal"  href="javascript:;" data-target="#myModal5" class="glr-btn col-xs-2" type="button">اختيار</a>
                    <input  id="categories_image3" readonly name="value[categories_image3]" class="glr-control  col-xs-9" type="text" value="<?php echo $data['value']->categories_image3; ?>" >
                    <a class="text-danger fa-lg" onclick="$('#categories_image3').val('');">&nbsp<i class="fa fa-close fa-lg  "></i></a>
                </div>
                <!-- /.modal -->
                <div class="modal fade" id="myModal5" style=" margin-left: 0px;">
                    <div class="modal-dialog" style="width: 80%;">
                        <div class="modal-content">
                            <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            <h4 class="modal-title">اختيار الصور</h4>
                            </div>
                            <div class="modal-body" >
                            <iframe width="100%" height="500" src="<?php echo ADMINURL; ?>/helpers/filemanager/dialog.php?type=2&field_id=categories_image3&relative_url=1" frameborder="0" style="overflow: scroll; overflow-x: hidden; overflow-y: scroll; "></iframe>
                            </div>
                        </div><!-- /.modal-content -->
                    </div><!-- /.modal-dialog -->
                </div>
                <!-- /.modal -->
            </div>
            <div class="form-group col-xs-6">
                <label class="control-label">رابط الفاصل اسفل  الاقسام 3  : </label>
                <div class="has-feedback">
                    <input type="text" class="form-control" name="value[categories_image3_url]" placeholder="رابط الفاصل اسفل  الاقسام 3 " value="<?php echo $data['value']->categories_image3_url; ?>">
                </div>
            </div><br class="clear">
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
// loading plugin
$data['footer'] = '<script src="' . ADMINURL . '/template/default/vendors/jquery.tagsinput/src/jquery.tagsinput.js"></script>' . "\n";

require ADMINROOT . '/views/inc/footer.php';
