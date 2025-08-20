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
    <?php flash('projectcategory_msg'); ?>
    <div class="page-title">
        <div class="title_right">
            <h3><?= $data['page_title']; ?> <small>التعديل علي الصفحة </small></h3>
        </div>
        <div class="title_left">
            <a href="<?= ADMINURL; ?>/projectcategories" class="btn btn-success pull-left">عودة <i class="fa fa-reply"></i></a>
        </div>
    </div>

    <div class="clearfix"></div>

    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <form action="<?= ADMINURL . '/projectcategories/edit/' . $data['category_id']; ?>" method="post" enctype="multipart/form-data" accept-charset="utf-8">
                <div class="col-lg-8 col-sm-12 col-xs-12">
                    <div class="form-group  <?= (empty($data['name_error'])) ?: 'has-error'; ?>">
                        <label class="control-label" for="pageTitle">عنوان القسم : </label>
                        <div class="has-feedback">
                            <input type="text" class="form-control" name="name" placeholder="عنوان القسم" value="<?= $data['name']; ?>">
                            <span class="fa fa-edit form-control-feedback" aria-hidden="true"></span>
                            <span class="help-block"><?= $data['name_error']; ?></span>
                        </div>
                    </div>
                    <div class="form-group <?= (!empty($data['parent_id_error'])) ? 'has-error' : ''; ?>">
                        <label class="control-label">الاقسام</label>
                        <div class="has-feedback">
                            <select name="parent_id" class="form-control">
                                <option value="0,0">قسم رئيسي </option>
                                <?php foreach ($data['categories'] as $category) : if ($category->category_id == $data['category_id']) continue; ?>
                                    <option value="<?= $category->category_id . ',' . $category->level; ?>" <?= ($category->category_id == $data['parent_id']) ? " selected " : ''; ?>>
                                        <?= str_repeat('ـــ ', $category->level - 1) . $category->name; ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                            <span class="fa fa-folder form-control-feedback" aria-hidden="true"></span>
                        </div>
                        <span class="help-block"><?= $data['parent_id_error']; ?></span>
                    </div>
                    <div class="form-group <?= (empty($data['image_error'])) ?: 'has-error'; ?>">
                        <label class="control-label" for="imageUpload">صورة القسم : </label>
                        <div class="has-feedback input-group">
                            <span class="input-group-btn">
                                <span class="btn btn-dark" onclick="$(this).parent().find('input[type=file]').click();">اختار الملف</span>
                                <input name="image" value="<?= ($data['image']); ?>" onchange="$(this).parent().parent().find('.form-control').html($(this).val().split(/[\\|/]/).pop());" style="display: none;" type="file">
                            </span>
                            <span class="form-control"><small><?= empty($data['image']) ? 'قم بأختيار صورة مناسبة' : $data['image']; ?></small></span>
                        </div>
                        <div class="help-block"><?= $data['image_error']; ?></div>
                    </div>
                    <div class="form-group">
                        <label class="control-label">وصف القسم : </label>
                        <textarea rows="5" name="description" class="form-control"><?= ($data['description']); ?></textarea>
                    </div>
                    <div class="form-group col-xs-12 <?= (!empty($data['status_error'])) ? 'has-error' : ''; ?>">
                        <label class="control-label">حالة النشر :</label>
                        <div class="radio">
                            <label>
                                <input type="radio" class="flat" <?= ($data['status'] == 1) ? 'checked' : ''; ?> value="1" name="status"> منشور
                            </label>
                            <label>
                                <input type="radio" class="flat" <?= ($data['status'] == '0') ? 'checked' : ''; ?> value="0" name="status"> غير منشور
                            </label>
                            <span class="help-block"><?= $data['status_error']; ?></span>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-sm-12 col-xs-12 options">
                    <h4>الاعدادات</h4>
                    <div class="accordion">
                        <div class="card">
                            <div class="card-header" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                <span> اعدادات النشر </span>
                            </div>
                            <div id="collapseOne" class="collapse card-body" aria-labelledby="headingOne">
                                <div class="form-group">
                                    <label>الترتيب : </label>
                                    <input type="number" class="form-control" name="arrangement" value="<?= $data['arrangement']; ?>" placeholder="الترتيب">
                                </div>
                                <div class="form-group">
                                    <label>تطبيق الكفارات : </label>
                                    <select class="form-control" name="kafara" id="kafara">
                                        <option value="web" <?= ('web' == $data['kafara']) ? " selected " : ''; ?>>في الويب فقط</option>
                                        <!-- <option value="both" <?= ('both' == $data['kafara']) ? " selected " : ''; ?>> في الويب والتطبيق</option> -->
                                        <option value="app" <?= ('app' == $data['kafara']) ? " selected " : ''; ?>>في التطبيق فقط</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label class="control-label">نشر كا مميز :</label>
                                    <div class="radio">
                                        <label>
                                            <input type="radio" class="flat" <?= ($data['featured'] == 1) ? 'checked' : ''; ?> value="1" name="featured"> نعم
                                        </label>
                                        <label>
                                            <input type="radio" class="flat" <?= ($data['featured'] == '0') ? 'checked' : ''; ?> value="0" name="featured"> لا
                                        </label>
                                        <span class="help-block"></span>
                                    </div>
                                </div>
                                <div class="form-grou">
                                    <label class="control-label">اظهار زر العودة الي الرئيسية :</label>
                                    <div class="radio">
                                        <label>
                                            <input type="radio" class="flat" <?= ($data['back_home'] == 1) ? 'checked' : ''; ?> value="1" name="back_home"> نعم
                                        </label>
                                        <label>
                                            <input type="radio" class="flat" <?= ($data['back_home'] == '0') ? 'checked' : ''; ?> value="0" name="back_home"> لا
                                        </label>
                                        <span class="help-block"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-header" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
                                <span> اعدادات ال SEO </span>
                            </div>
                            <div id="collapseTwo" class="collapse card-body" aria-labelledby="headingTwo">

                                <div class="form-group">
                                    <label class="control-label">الوصف : </label>
                                    <div class="text-warning ">وصف مختصر لمحرك البحث</div>
                                    <div class=" form-group">
                                        <textarea name="meta_description" class="form-control description" id="description" placeholder="ادرج وصف مختصر عن القسم"><?= $data['meta_description']; ?></textarea>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="control-label" for="tags_1">الكلمات الدلالية :</label>
                                    <div class="text-warning ">افصل بين كل كلمة بعلامة (,)</div>
                                    <div class=" form-group">
                                        <input type="text" name="meta_keywords" value="<?= $data['meta_keywords']; ?>" id="tags_1" class="form-control" />
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-header" data-toggle="collapse" data-target="#collapseThree" aria-expanded="true" aria-controls="collapseThree">
                                <span>اعدادات المظهر</span>
                            </div>
                            <div id="collapseThree" class="collapse card-body <?= (empty($data['background_image_error'])) ?: 'in'; ?>" aria-labelledby="headingThree">
                                <div class="form-group <?= (empty($data['background_image_error'])) ?: 'has-error'; ?>">
                                    <label class="control-label">صورة الخلفية : </label>
                                    <div class="has-feedback input-group">
                                        <span class="input-group-btn">
                                            <span class="btn btn-dark" onclick="$(this).parent().find('input[type=file]').click();">اختار الملف</span>
                                            <input name="background_image" value="<?= ($data['background_image']); ?>" onchange="$(this).parent().parent().find('.form-control').html($(this).val().split(/[\\|/]/).pop());" style="display: none;" type="file">
                                        </span>
                                        <span class="form-control"><small><?= empty($data['background_image']) ? 'قم بأختيار صورة مناسبة' : $data['background_image']; ?></small></span>
                                    </div>
                                    <div class="help-block"><?= $data['background_image_error']; ?></div>
                                </div>
                                <div class="form-group">
                                    <label>لون الخلفية : </label>
                                    <input type="text" class="colorpicker form-control" name="background_color" value="<?= $data['background_color']; ?>" data-wcp-format="rgba">
                                </div>
                                <div class="form-group <?= (empty($data['ads_banner_error'])) ?: 'has-error'; ?>">
                                    <label class="control-label">صورة البنر الفاصل في الصفحة الرئيسية : </label>
                                    <label class="float-right">
                                        <input type="checkbox" name="ads_banner_remove" id="ads_banner_remove" class="flat">حذف البنر
                                    </label>
                                    <div class="has-feedback input-group">
                                        <span class="input-group-btn">
                                            <span class="btn btn-dark" onclick="$(this).parent().find('input[type=file]').click();">اختار الملف</span>
                                            <input name="ads_banner" value="<?= ($data['ads_banner']); ?>" onchange="$(this).parent().parent().find('.form-control').html($(this).val().split(/[\\|/]/).pop());" style="display: none;" type="file">
                                        </span>

                                        <span class="form-control"><small><?= empty($data['ads_banner']) ? 'قم بأختيار صورة مناسبة' : $data['ads_banner']; ?></small></span>
                                    </div>
                                    <div class="help-block"><?= $data['ads_banner_error']; ?></div>
                                </div>
                                <div class="form-group">
                                    <label>الرابط الخاص بالبنر : </label>
                                    <input type="text" class="form-control" name="ads_url" value="<?= $data['ads_url']; ?>">
                                </div>


                                <div class="form-group <?= (empty($data['ads2_banner_error'])) ?: 'has-error'; ?>">
                                    <label class="control-label">صورة البنر2 الفاصل في الصفحة الرئيسية : </label>
                                    <label class="float-right">
                                        <input type="checkbox" name="ads2_banner_remove" id="ads2_banner_remove" class="flat">حذف البنر
                                    </label>
                                    <div class="has-feedback input-group">
                                        <span class="input-group-btn">
                                            <span class="btn btn-dark" onclick="$(this).parent().find('input[type=file]').click();">اختار الملف</span>
                                            <input name="ads2_banner" value="<?= ($data['ads2_banner']); ?>" onchange="$(this).parent().parent().find('.form-control').html($(this).val().split(/[\\|/]/).pop());" style="display: none;" type="file">
                                        </span>

                                        <span class="form-control"><small><?= empty($data['ads2_banner']) ? 'قم بأختيار صورة مناسبة' : $data['ads2_banner']; ?></small></span>
                                    </div>
                                    <div class="help-block"><?= $data['ads2_banner_error']; ?></div>
                                </div>
                                <div class="form-group">
                                    <label>2الرابط الخاص بالبنر : </label>
                                    <input type="text" class="form-control" name="ads2_url" value="<?= $data['ads2_url']; ?>">
                                </div>


                                <div class="form-group">
                                    <label>لون خلفية القسم بالصفحة الرئيسية : </label>
                                    <input type="text" class="colorpicker form-control" name="section_bg" value="<?= $data['section_bg']; ?>" data-wcp-format="rgba">
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
$data['footer'] = '<script src="' . ADMINURL . '/template/default/vendors/jquery.tagsinput/src/jquery.tagsinput.js"></script>';

require ADMINROOT . '/views/inc/footer.php';
