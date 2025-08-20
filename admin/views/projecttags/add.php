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
            <h3><?php echo $data['page_title']; ?> <small>اضافة  وسم جديد </small></h3>
        </div>
        <div class="title_left">
            <a href="<?php echo ADMINURL; ?>/projecttags" class="btn btn-success pull-left">عودة <i class="fa fa-reply"></i></a>
        </div>
    </div>

    <div class="clearfix"></div>

    <div class="row">

        <form action="<?php echo ADMINURL . '/projecttags/add'; ?>" method="post" enctype="multipart/form-data" accept-charset="utf-8" >
            <div class="col-lg-8 col-sm-12 col-xs-12">
                <div class="form-group  <?php echo (empty($data['name_error'])) ?: 'has-error'; ?>">
                    <label class="control-label" for="pageTitle">عنوان الوسم : </label>
                    <div class="has-feedback">
                        <input type="text" class="form-control" name="name" placeholder="عنوان الوسم" value="<?php echo $data['name']; ?>">
                        <span class="fa fa-edit form-control-feedback" aria-hidden="true"></span>
                        <span class="help-block"><?php echo $data['name_error']; ?></span>
                    </div>
                </div>
                <div class="form-group <?php echo (empty($data['image_error'])) ?: 'has-error'; ?>">
                    <label class="control-label" for="imageUpload">صورة الوسم : </label>
                    <div class="has-feedback input-group">
                        <span class="input-group-btn">
                            <span class="btn btn-dark" onclick="$(this).parent().find('input[type=file]').click();">اختار الملف</span>
                            <input name="image" value="<?php echo ($data['image']); ?>" onchange="$(this).parent().parent().find('.form-control').html($(this).val().split(/[\\|/]/).pop());" style="display: none;" type="file">
                        </span>
                        <span class="form-control"><small><?php echo empty($data['image']) ? 'قم بأختيار صورة مناسبة' : $data['image']; ?></small></span>
                    </div>
                    <div class="help-block"><?php echo $data['image_error']; ?></div>
                </div>
                <div class="form-group">
                    <label class="control-label">وصف الوسم  : </label>
                        <textarea rows="5" name="description" class="form-control"><?php echo ($data['description']); ?></textarea>
                </div>
                <div class="form-group col-xs-12 <?php echo (!empty($data['status_error'])) ? 'has-error' : ''; ?>">
                    <label class="control-label">حالة النشر :</label>
                    <div class="radio">
                        <label>
                            <input type="radio" class="flat" <?php echo ($data['status'] == 1) ? 'checked' : ''; ?> value="1" name="status"> منشور
                        </label>
                        <label>
                            <input type="radio" class="flat" <?php echo ($data['status'] == '0') ? 'checked' : ''; ?> value="0" name="status"> غير منشور
                        </label>
                        <span class="help-block"><?php echo $data['status_error']; ?></span>
                    </div>
                </div>                
            </div>
            <div class="col-lg-4 col-sm-12 col-xs-12 options">
                <h4>الاعدادات</h4>
                <div class="accordion">
                    <div class="card">
                        <div class="card-header" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne" >
                                <span> اعدادات النشر   </span>
                        </div>
                        <div id="collapseOne" class="collapse card-body" aria-labelledby="headingOne" >                            
                            <div class="form-group">
                                <label>الترتيب : </label>
                                <input type="number" class="form-control" name="arrangement" value="<?php echo $data['arrangement']; ?>"  placeholder="الترتيب">
                            </div>
                            <div class="form-group">
                                <label class="control-label">نشر كا مميز :</label>
                                <div class="radio">
                                    <label>
                                        <input type="radio" class="flat" <?php echo ($data['featured'] == 1) ? 'checked' : ''; ?> value="1" name="featured"> نعم
                                    </label>
                                    <label>
                                        <input type="radio" class="flat" <?php echo ($data['featured'] == '0') ? 'checked' : ''; ?> value="0" name="featured"> لا
                                    </label>
                                    <span class="help-block"></span>
                                </div>
                            </div>
                            <div class="form-grou">
                                <label class="control-label">اظهار زر العودة الي الرئيسية :</label>
                                <div class="radio">
                                    <label>
                                        <input type="radio" class="flat" <?php echo ($data['back_home'] == 1) ? 'checked' : ''; ?> value="1" name="back_home"> نعم
                                    </label>
                                    <label>
                                        <input type="radio" class="flat" <?php echo ($data['back_home'] == '0') ? 'checked' : ''; ?> value="0" name="back_home"> لا
                                    </label>
                                    <span class="help-block"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo" >
                              <span>   اعدادات ال SEO  </span>
                        </div>
                        <div id="collapseTwo" class="collapse card-body" aria-labelledby="headingTwo" >

                            <div class="form-group">
                                <label class="control-label">الوصف : </label>
                                <div class="text-warning ">وصف مختصر لمحرك البحث</div>
                                <div class=" form-group">
                                    <textarea name="meta_description" class="form-control description" id="description" placeholder="ادرج وصف مختصر عن الوسم"><?php echo $data['meta_description']; ?></textarea>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="control-label" for="tags_1">الكلمات الدلالية    :</label>
                                <div class="text-warning ">افصل بين كل كلمة بعلامة (,)</div>
                                <div class=" form-group">
                                    <input type="text" name="meta_keywords" value="<?php echo $data['meta_keywords']; ?>" id="tags_1" class="form-control" />
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header" data-toggle="collapse" data-target="#collapseThree" aria-expanded="true" aria-controls="collapseThree" >
                            <span>اعدادات المظهر</span>
                        </div>
                        <div id="collapseThree" class="collapse card-body <?php echo (empty($data['background_image_error'])) ?: 'in'; ?>" aria-labelledby="headingThree" >
                            <div class="form-group <?php echo (empty($data['background_image_error'])) ?: 'has-error'; ?>">
                                <label class="control-label">صورة الخلفية : </label>
                                <div class="has-feedback input-group">
                                    <span class="input-group-btn">
                                        <span class="btn btn-dark" onclick="$(this).parent().find('input[type=file]').click();">اختار الملف</span>
                                        <input name="background_image" value="<?php echo ($data['background_image']); ?>" onchange="$(this).parent().parent().find('.form-control').html($(this).val().split(/[\\|/]/).pop());" style="display: none;" type="file">
                                    </span>
                                    <span class="form-control"><small><?php echo empty($data['background_image']) ? 'قم بأختيار صورة مناسبة' : $data['background_image']; ?></small></span>
                                </div>
                                <div class="help-block"><?php echo $data['background_image_error']; ?></div>
                            </div>
                            <div class="form-group">
                                <label>لون الخلفية : </label>
                                <input type="text" class="colorpicker form-control" name="background_color" value="<?php echo $data['background_color']; ?>"  data-wcp-format="rgba">
                            </div>



                        </div>
                    </div>

                </div>
                <br><br>



            </div>

            <div class="col-xs-12">
                    <button type="submit" name="submit" class="btn btn-success">أضف
                        <i class="fa fa-save"> </i></button>
                    <button type="reset" class="btn btn-danger">مسح
                        <i class="fa fa-trash "> </i></button>
                </div>

        </form>
    </div>
</div>
<?php
// loading plugin
$data['footer'] = '<script src="' . ADMINURL . '/template/default/vendors/ckeditor/ckeditor.js"></script>

                   <script src="' . ADMINURL . '/template/default/vendors/jquery.tagsinput/src/jquery.tagsinput.js"></script>';

require ADMINROOT . '/views/inc/footer.php';
