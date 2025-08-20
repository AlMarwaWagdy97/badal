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
    <?php flash('projecttag_msg'); ?>
    <div class="page-title">
        <div class="title_right">
            <h3><?php echo $data['page_title']; ?> <small>التعديل علي المتجر </small></h3>
        </div>
        <div class="title_left">
            <a href="<?php echo ADMINURL; ?>/stores" class="btn btn-success pull-left">عودة <i class="fa fa-reply"></i></a>
        </div>
    </div>
    <div class="clearfix"></div>
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <form action="<?php echo ADMINURL . '/stores/edit/' . $data['store_id']; ?>" method="post" enctype="multipart/form-data" accept-charset="utf-8">
                <div class="col-lg-8 col-sm-12 col-xs-12">
                    <div class="form-group  <?php echo (empty($data['name_error'])) ?: 'has-error'; ?>">
                        <label class="control-label" for="pageTitle">اسم المتجر : </label>
                        <div class="has-feedback">
                            <input type="text" class="form-control name" name="name" placeholder="عنوان المتجر" value="<?php echo $data['name']; ?>">
                            <span class="fa fa-shopping-cart form-control-feedback" aria-hidden="true"></span>
                            <span class="help-block"><?php echo $data['name_error']; ?></span>
                        </div>
                    </div>
                    <div class="form-group  <?php echo (empty($data['alias_error'])) ?: 'has-error'; ?>">
                        <label class="control-label">رابط المتجر</label>
                        <div class="has-feedback">
                            <input type="text" class="form-control alias" name="alias" readonly="" required="" value="<?php echo $data['alias']; ?>" placeholder="The URL Alias that Displayed on the browser ">
                            <span class="help-block "><?php echo $data['alias_error']; ?></span>
                            <a class="edit btn btn-primary">تعديل</a>
                        </div>
                    </div>
                    <div class="col-md-6 col-xs-12 form-group  <?php echo (empty($data['user_error'])) ?: 'has-error'; ?>">
                        <label class="control-label" for="pageTitle">اسم المستخدم : </label>
                        <div class="has-feedback">
                            <input type="text" class="form-control user" name="user" placeholder="باللغة الانجليزية بدون مسافات" value="<?php echo $data['user']; ?>">
                            <span class="fa fa-user form-control-feedback" aria-hidden="true"></span>
                            <span class="help-block"><?php echo $data['user_error']; ?></span>
                        </div>
                    </div>
                    <div class="col-md-6 col-xs-12 form-group <?php echo (!empty($data['password_error'])) ? 'has-error' : ''; ?>">
                        <label class="control-label" for="password">كلمة المرور : </label>
                        <div class="has-feedback">
                            <input type="password" id="password" class="form-control" name="password" placeholder="كلمة المرور" value="<?php echo $data['password']; ?>">
                            <span class="fa fa-lock form-control-feedback" aria-hidden="true"></span>
                            <span class="help-block"><?php echo $data['password_error']; ?></span>
                        </div>
                    </div>
                    <div class="col-md-6 col-xs-12 form-group  <?php echo (empty($data['employee_name_error'])) ?: 'has-error'; ?>">
                        <label class="control-label" for="pageTitle">اسم الموظف المسئول : </label>
                        <div class="has-feedback">
                            <input type="text" class="form-control employee_name" name="employee_name" placeholder="اسم الموظف المسئول" value="<?php echo $data['employee_name']; ?>">
                            <span class="fa fa-user form-control-feedback" aria-hidden="true"></span>
                            <span class="help-block"><?php echo $data['employee_name_error']; ?></span>
                        </div>
                    </div>
                    <div class="col-md-6 col-xs-12 form-group  <?php echo (empty($data['employee_number_error'])) ?: 'has-error'; ?>">
                        <label class="control-label" for="pageTitle">رقم الموظف المسئول : </label>
                        <div class="has-feedback">
                            <input type="text" class="form-control employee_number" name="employee_number" placeholder="رقم الموظف المسئول" value="<?php echo $data['employee_number']; ?>">
                            <span class="fa fa-user form-control-feedback" aria-hidden="true"></span>
                            <span class="help-block"><?php echo $data['employee_number_error']; ?></span>
                        </div>
                    </div>
                    <div class="col-md-6 col-xs-12 form-group">
                        <label class="control-label" for="pageTitle">البريد الالكتروني : </label>
                        <div class="has-feedback">
                            <input type="email" class="form-control email" name="email" placeholder="البريد الالكتروني" value="<?php echo $data['email']; ?>">
                            <span class="fa fa-envelope form-control-feedback" aria-hidden="true"></span>
                        </div>
                    </div>
                    <div class="col-md-6 col-xs-12 form-group">
                        <label class="control-label" for="pageTitle">القسم : </label>
                        <div class="has-feedback">
                            <input type="text" class="form-control department" name="department" placeholder="department" value="<?php echo $data['department']; ?>">
                            <span class="fa fa-user form-control-feedback" aria-hidden="true"></span>
                        </div>
                    </div>
                    <div class="col-md-6 col-xs-12 form-group">
                        <label class="control-label" for="pageTitle">AX Store Number : </label>
                        <div class="has-feedback">
                            <input type="text" class="form-control ax_store_number" name="ax_store_number" placeholder="ax_store_number" value="<?php echo $data['ax_store_number']; ?>">
                            <span class="fa fa-user form-control-feedback" aria-hidden="true"></span>
                        </div>
                    </div>
                    <div class="col-md-6 col-xs-12 form-group">
                        <label class="control-label" for="pageTitle">الدور الوظيفي : </label>
                        <div class="has-feedback">
                            <input type="text" class="form-control job" name="job" placeholder="الدور الوظيفي" value="<?php echo $data['job']; ?>">
                            <span class="fa fa-user form-control-feedback" aria-hidden="true"></span>
                        </div>
                    </div>
                    <div class="col-md-6 col-xs-12 form-group">
                        <label class="control-label" for="pageTitle">رابط الموقع علي خرائط جوجل : </label>
                        <div class="has-feedback">
                            <input type="text" class="form-control location" name="location" placeholder="رابط الموقع علي خرائط جوجل" value="<?php echo $data['location']; ?>">
                            <span class="fa fa-globe form-control-feedback" aria-hidden="true"></span>
                        </div>
                    </div>
                    <div class="col-md-6 col-xs-12 form-group">
                        <label class="control-label" for="pageTitle">رقم الجوال : </label>
                        <div class="has-feedback">
                            <input type="text" class="form-control mobile" name="mobile" placeholder="رقم الجوال" value="<?php echo $data['mobile']; ?>">
                            <span class="fa fa-phone form-control-feedback" aria-hidden="true"></span>
                        </div>
                    </div>
                    <div class="col-md-6 col-xs-12 form-group">
                        <label class="control-label" for="pageTitle">رقم WhatsApp : </label>
                        <div class="has-feedback">
                            <input type="text" class="form-control whatsapp" name="whatsapp" placeholder="رقم WhatsApp" value="<?php echo $data['whatsapp']; ?>">
                            <span class="fa fa-whatsapp form-control-feedback" aria-hidden="true"></span>
                        </div>
                    </div>
                    <div class="form-group <?php echo (empty($data['employee_image_error'])) ?: 'has-error'; ?>">
                        <label class="control-label" for="imageUpload">صورة المستخدم : </label>
                        <div class="has-feedback input-group">
                            <span class="input-group-btn">
                                <span class="btn btn-dark" onclick="$(this).parent().find('input[type=file]').click();">اختار الملف</span>
                                <input name="employee_image" value="<?php echo ($data['employee_image']); ?>" onchange="$(this).parent().parent().find('.form-control').html($(this).val().split(/[\\|/]/).pop());" style="display: none;" type="file">
                            </span>
                            <span class="form-control"><small><?php echo empty($data['employee_image']) ? 'قم بأختيار صورة مناسبة' : $data['employee_image']; ?></small></span>
                        </div>
                        <div class="help-block"><?php echo $data['employee_image_error']; ?></div>
                    </div>
                    <div class="form-group">
                        <label class="control-label">وصف المتجر : </label>
                        <textarea rows="5" name="details" class="form-control"><?php echo ($data['details']); ?></textarea>
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
                            <div class="card-header" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
                                <span> اعدادات ال SEO </span>
                            </div>
                            <div id="collapseTwo" class="collapse card-body" aria-labelledby="headingTwo">
                                <div class="form-group">
                                    <label class="control-label">الوصف : </label>
                                    <div class="text-warning ">وصف مختصر لمحرك البحث</div>
                                    <div class=" form-group">
                                        <textarea name="meta_description" class="form-control description" id="description" placeholder="ادرج وصف مختصر عن المتجر"><?php echo $data['meta_description']; ?></textarea>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label" for="tags_1">الكلمات الدلالية :</label>
                                    <div class="text-warning ">افصل بين كل كلمة بعلامة (,)</div>
                                    <div class=" form-group">
                                        <input type="text" name="meta_keywords" value="<?php echo $data['meta_keywords']; ?>" id="tags_1" class="form-control" />
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-header" data-toggle="collapse" data-target="#collapseThree" aria-expanded="true" aria-controls="collapseThree">
                                <span>اعدادات المظهر</span>
                            </div>
                            <div id="collapseThree" class="collapse card-body <?php echo (empty($data['background_image_error'])) ?: 'in'; ?>" aria-labelledby="headingThree">
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
                                    <input type="text" class="colorpicker form-control" name="background_color" value="<?php echo $data['background_color']; ?>" data-wcp-format="rgba">
                                </div>
                            </div>
                        </div>
                    </div>
                    <br><br>
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
$data['footer'] =  "<script>
                    $('.edit').click(function() {
                        $('.alias').prop('readonly', false);
                    });
                    $('.alias').blur(function() {
                        $('.alias').prop('readonly', true);
                    });
                    $('.name').change(function() {
                        var tval = $('.name').val();
                        $('.alias').val(tval.replace(/([~!@#$%^&*()_+=`{}\[\]\|\\:;'<>,.\/? ])+/g, '_'));
                    });
                    </script>
                    " . '<script src="' . ADMINURL . '/template/default/vendors/jquery.tagsinput/src/jquery.tagsinput.js"></script>';

require ADMINROOT . '/views/inc/footer.php';
