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
                    <label class="control-label" for="settingTitle">عنوان الموقع : </label>
                    <div class="has-feedback">
                        <input type="text" id="settingTitle" class="form-control" name="value[title]" placeholder="عنوان الموقع" value="<?php echo $data['value']->title; ?>">
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label" for="settingTitle">عن الجمعية : </label>
                    <div class="has-feedback">
                        <textarea type="text" id="settingTitle" class="form-control" name="value[about]" placeholder="عن الجمعية"><?php echo $data['value']->about; ?></textarea>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label" for="settingTitle">رسالة الترحيب : </label>
                    <div class="has-feedback">
                        <input type="text" id="settingTitle" class="form-control" name="value[welcomeText]" placeholder="رسالة الترحيب" value="<?php echo $data['value']->welcomeText; ?>">
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label" for="imageUpload">اللوجو : </label>
                    <div class="glr-group ">
                        <a data-toggle="modal" href="javascript:;" data-target="#myModal" class="glr-btn col-xs-2" type="button">اختيار</a>
                        <input id="galery" readonly name="value[logo]" class="glr-control  col-xs-10" type="text" value="<?php echo $data['value']->logo; ?>">
                    </div>
                    <!-- /.modal -->
                    <div class="modal fade" id="myModal" style=" margin-left: 0px;">
                        <div class="modal-dialog" style="width: 80%;">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                    <h4 class="modal-title">اختيار الصور</h4>
                                </div>
                                <div class="modal-body">
                                    <iframe width="100%" height="500" src="<?php echo ADMINURL; ?>/helpers/filemanager/dialog.php?type=2&field_id=galery&relative_url=1" frameborder="0" style="overflow: scroll; overflow-x: hidden; overflow-y: scroll; "></iframe>
                                </div>
                            </div><!-- /.modal-content -->
                        </div><!-- /.modal-dialog -->
                    </div>
                    <!-- /.modal -->
                </div>
                <div class="form-group col-md-12">
                    <label class="control-label">كود الهيدر : </label>
                    <div class="row">
                        <textarea name="value[header_code]" class="form-control"><?php echo ($data['value']->header_code); ?></textarea>
                    </div>
                </div>
                <div class="form-group col-md-12">
                    <label class="control-label">كود الفوتر : </label>
                    <div class="row">
                        <textarea name="value[footer_code]" class="form-control"><?php echo ($data['value']->footer_code); ?></textarea>
                    </div>
                </div>
                <div class="form-group col-xs-12 ">
                    <label class="control-label">يجب تأكيد الجوال اثناء الشراء من خلال السلة :</label>
                    <div class="radio">
                        <label>
                            <input type="radio" class="flat" <?php echo ($data['value']->mobile_validation == 1) ? 'checked' : ''; ?> value="1" name="value[mobile_validation]"> نعم
                        </label>
                        <label>
                            <input type="radio" class="flat" <?php echo ($data['value']->mobile_validation == '0') ? 'checked' : ''; ?> value="0" name="value[mobile_validation]"> لا
                    </div>
                </div>
                <div class="form-group col-xs-12 ">
                    <label class="control-label">حالة الاسلايدر :</label>
                    <div class="radio">
                        <label>
                            <input type="radio" class="flat" <?php echo ($data['value']->show_banner == 1) ? 'checked' : ''; ?> value="1" name="value[show_banner]"> اظهار الاسلايدر
                        </label>
                        <label>
                            <input type="radio" class="flat" <?php echo ($data['value']->show_banner == '0') ? 'checked' : ''; ?> value="0" name="value[show_banner]"> اخفاء الاسلايدر
                        </label>
                    </div>
                </div>
                 <div class="form-group col-xs-12 ">
                    <label class="control-label">حالة شريط الاخبار :</label>
                    <div class="radio">
                        <label>
                            <input type="radio" class="flat" <?php echo ($data['value']->show_news == 1) ? 'checked' : ''; ?> value="1" name="value[show_news]"> اظهار شريط الاخبار
                        </label>
                        <label>
                            <input type="radio" class="flat" <?php echo ($data['value']->show_news == '0') ? 'checked' : ''; ?> value="0" name="value[show_news]"> اخفاء شريط الاخبار
                        </label>
                    </div>
                </div>
                <div class="form-group col-xs-12 ">
                    <label class="control-label">حالة التبرع السريع :</label>
                    <div class="radio">
                        <label>
                            <input type="radio" class="flat" <?php echo ($data['value']->showQuickDonation == 1) ? 'checked' : ''; ?> value="1" name="value[showQuickDonation]"> اظهار التبرع السريع
                        </label>
                        <label>
                            <input type="radio" class="flat" <?php echo ($data['value']->showQuickDonation == '0') ? 'checked' : ''; ?> value="0" name="value[showQuickDonation]"> اخفاء التبرع السريع
                        </label>
                    </div>
                </div>
                <div class="form-group col-xs-12 ">
                    <label class="control-label">حالة الوسوم :</label>
                    <div class="radio">
                        <label>
                            <input type="radio" class="flat" <?php echo ($data['value']->enableTages == 1) ? 'checked' : ''; ?> value="1" name="value[enableTages]"> اظهار الوسوم
                        </label>
                        <label>
                            <input type="radio" class="flat" <?php echo ($data['value']->enableTages == '0') ? 'checked' : ''; ?> value="0" name="value[enableTages]"> اخفاء الوسوم
                        </label>
                    </div>
                </div>
                <div class="form-group col-xs-12 ">
                    <label class="control-label">حالة المشروعات :</label>
                    <div class="radio">
                        <label>
                            <input type="radio" class="flat" <?php echo ($data['value']->show_projects == 1) ? 'checked' : ''; ?> value="1" name="value[show_projects]"> اظهار المشروعات
                        </label>
                        <label>
                            <input type="radio" class="flat" <?php echo ($data['value']->show_projects == '0') ? 'checked' : ''; ?> value="0" name="value[show_projects]"> اخفاء المشروعات
                        </label>
                    </div>
                    <label class="control-label" for="project_text">عنوان المشروعات : </label>
                    <div class="has-feedback">
                        <input type="text" id="project_text" class="form-control" name="value[project_text]" placeholder="عنوان الموقع" value="<?php echo $data['value']->project_text; ?>">
                    </div>
                </div>
                <div class="form-group col-xs-12 ">
                    <label class="control-label">حالة الاقسام :</label>
                    <div class="radio">
                        <label>
                            <input type="radio" class="flat" <?php echo ($data['value']->show_categories == 1) ? 'checked' : ''; ?> value="1" name="value[show_categories]"> اظهار الاقسام
                        </label>
                        <label>
                            <input type="radio" class="flat" <?php echo ($data['value']->show_categories == '0') ? 'checked' : ''; ?> value="0" name="value[show_categories]"> اخفاء الاقسام
                        </label>
                    </div>
                    <label class="control-label" for="category_text">عنوان الاقسام : </label>
                    <div class="has-feedback">
                        <input type="text" id="category_text" class="form-control" name="value[category_text]" placeholder="عنوان الاقسام" value="<?php echo $data['value']->category_text; ?>">
                    </div>
                </div>
                <div class="form-group col-xs-12 ">
                    <label class="control-label">حالة المركز الاعلامي :</label>
                    <div class="radio">
                        <label>
                            <input type="radio" class="flat" <?php echo ($data['value']->show_media == 1) ? 'checked' : ''; ?> value="1" name="value[show_media]"> اظهار المركز الاعلامي
                        </label>
                        <label>
                            <input type="radio" class="flat" <?php echo ($data['value']->show_media == '0') ? 'checked' : ''; ?> value="0" name="value[show_media]"> اخفاء المركز الاعلامي
                        </label>
                    </div>
                    <label class="control-label" for="category_text">عنوان المركز الاعلامي : </label>
                    <div class="has-feedback">
                        <input type="text" id="category_text" class="form-control" name="value[media_text]" placeholder="عنوان المركز الاعلامي" value="<?php echo $data['value']->media_text; ?>">
                    </div>
                </div>
                <div class="form-group col-xs-12 ">
                    <label class="control-label">حالة الفيديو :</label>
                    <div class="radio">
                        <label>
                            <input type="radio" class="flat" <?php echo ($data['value']->show_video == 1) ? 'checked' : ''; ?> value="1" name="value[show_video]"> اظهار الفيديو
                        </label>
                        <label>
                            <input type="radio" class="flat" <?php echo ($data['value']->show_video == '0') ? 'checked' : ''; ?> value="0" name="value[show_video]"> اخفاء الفيديو
                        </label>
                    </div>
                    <label class="control-label" for="category_text">عنوان الفيديو : </label>
                    <div class="has-feedback">
                        <input type="text" id="category_text" class="form-control" name="value[videoTitle]" placeholder="عنوان الفيديو" value="<?php echo $data['value']->videoTitle; ?>">
                    </div>
                    <label class="control-label" for="category_text">وصف الفيديو : </label>
                    <div class="has-feedback">
                        <input type="text" id="category_text" class="form-control" name="value[videoDescription]" placeholder="وصف الفيديو" value="<?php echo $data['value']->videoDescription; ?>">
                    </div>
                    <label class="control-label" for="category_text">رابط الفيديو : </label>
                    <div class="has-feedback">
                        <input type="text" id="category_text" class="form-control" name="value[videoURL]" placeholder="رابط الفيديو" value="<?php echo $data['value']->videoURL; ?>">
                    </div>
                    <label class="control-label" for="category_text">رابط المزيد : </label>
                    <div class="has-feedback">
                        <input type="text" id="category_text" class="form-control" name="value[videoMore]" placeholder="رابط المزيد" value="<?php echo $data['value']->videoMore; ?>">
                    </div>
                </div>
                <div class="form-group col-xs-12 ">
                    <label class="control-label">حالة القسم السفلي :</label>
                    <div class="radio">
                        <label>
                            <input type="radio" class="flat" <?php echo ($data['value']->show_bottom == 1) ? 'checked' : ''; ?> value="1" name="value[show_bottom]"> اظهار القسم السفلي
                        </label>
                        <label>
                            <input type="radio" class="flat" <?php echo ($data['value']->show_bottom == '0') ? 'checked' : ''; ?> value="0" name="value[show_bottom]"> اخفاء القسم السفلي
                        </label>
                    </div>
                </div>
                <div class="form-group col-xs-12 ">
                    <label class="control-label">حالة الفوتر :</label>
                    <div class="radio">
                        <label>
                            <input type="radio" class="flat" <?php echo ($data['value']->show_footer == 1) ? 'checked' : ''; ?> value="1" name="value[show_footer]"> اظهار الفوتر
                        </label>
                        <label>
                            <input type="radio" class="flat" <?php echo ($data['value']->show_footer == '0') ? 'checked' : ''; ?> value="0" name="value[show_footer]"> اخفاء الفوتر
                        </label>
                    </div>
                </div>
                <div class="form-group col-md-12">
                    <label class="control-label">رسالة الشكر : </label>
                    <div class="row">
                        <textarea name="value[thankyou]" class="form-control ckeditor"><?php echo ($data['value']->thankyou); ?></textarea>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label" for="settingcopyright">الحقوق : </label>
                    <div class="has-feedback">
                        <input type="text" id="settingcopyright" class="form-control" name="value[copyright]" placeholder="الحقوق" value="<?php echo $data['value']->copyright; ?>">
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

<?php
// loading plugin

$data['footer'] = '<script src="' . ADMINURL . '/template/default/vendors/ckeditor/ckeditor.js"></script>
                   <script src="' . ADMINURL . '/template/default/vendors/jquery.tagsinput/src/jquery.tagsinput.js"></script>
                <script>
                //filemanagesr for ck editor
                    CKEDITOR.replace("ckeditor", {
                        filebrowserBrowseUrl: "' . ADMINURL . '/helpers/filemanager/dialog.php?type=2&editor=ckeditor&fldr=" ,
                        filebrowserUploadUrl: "' . ADMINURL . '/helpers/filemanager/dialog.php?type=2&editor=ckeditor&fldr=",
                        filebrowserImageBrowseUrl: "' . ADMINURL . '/helpers/filemanager/dialog.php?type=1&editor=ckeditor&fldr="
                    });
                </script>' . "\n";
require ADMINROOT . '/views/inc/footer.php';
