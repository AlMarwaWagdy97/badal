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
    <?php flash('puzzel_msg'); ?>
    <div class="page-title">
        <div class="title_right">
            <h3><?php echo $data['page_title']; ?> <small>اضافة مستفيد جديد </small></h3>
        </div>
        <div class="title_left">
            <a href="<?php echo ADMINURL; ?>/puzzels" class="btn btn-success pull-left">عودة <i class="fa fa-reply"></i></a>
        </div>
    </div>

    <div class="clearfix"></div>

    <div class="row">

        <form action="<?php echo ADMINURL . '/puzzels/add'; ?>" method="post" enctype="multipart/form-data" accept-charset="utf-8">
            <div class="col-lg-8 col-sm-12 col-xs-12">
                <div class="form-group  <?php echo (empty($data['name_error'])) ?: 'has-error'; ?>">
                    <label class="control-label" for="pageTitle">الاسم : </label>
                    <div class="has-feedback">
                        <input type="text" class="form-control" name="name" placeholder="الاسم " value="<?php echo $data['name']; ?>">
                        <span class="fa fa-edit form-control-feedback" aria-hidden="true"></span>
                        <span class="help-block"><?php echo $data['name_error']; ?></span>
                    </div>
                </div>
                <div class="form-group <?php echo (!empty($data['image_error'])) ? 'has-error' : ''; ?>">
                    <label class="control-label" for="imageUpload">صورة اللغز : </label>
                    <div class="has-feedback input-group">
                        <span class="input-group-btn">
                            <span class="btn btn-dark" onclick="$(this).parent().find('input[type=file]').click();">اختار الملف</span>
                            <input name="image" value="<?php echo ($data['image']); ?>" onchange="$(this).parent().parent().find('.form-control').html($(this).val().split(/[\\|/]/).pop());" style="display: none;" type="file">
                        </span>
                        <span class="form-control"><small><?php echo empty($data['image']) ? 'قم بأختيار صورة مناسبة' : $data['image']; ?></small></span>
                    </div>
                    <div class="help-block"><?php echo $data['image_error']; ?></div>
                </div>

                <div class="form-group <?php echo (!empty($data['image2_error'])) ? 'has-error' : ''; ?>">
                    <label class="control-label" for="image2Upload">صورة الفورم : </label>
                    <div class="has-feedback input-group">
                        <span class="input-group-btn">
                            <span class="btn btn-dark" onclick="$(this).parent().find('input[type=file]').click();">اختار الملف</span>
                            <input name="image2" value="<?php echo ($data['image2']); ?>" onchange="$(this).parent().parent().find('.form-control').html($(this).val().split(/[\\|/]/).pop());" style="display: none;" type="file">
                        </span>
                        <span class="form-control"><small><?php echo empty($data['image2']) ? 'قم بأختيار صورة مناسبة' : $data['image2']; ?></small></span>
                    </div>
                    <div class="help-block"><?php echo $data['image2_error']; ?></div>
                </div>

                <div class="row">
                    <div class="form-group col-sm-6 <?php echo (empty($data['width_error'])) ?: 'has-error'; ?>">
                        <label class="control-label" for="pageTitle">عرض الصورة : </label>
                        <div class="has-feedback">
                            <input type="text" class="form-control" name="width" placeholder="عرض الصورة " value="<?php echo $data['width']; ?>">
                            <span class="fa fa-edit form-control-feedback" aria-hidden="true"></span>
                            <span class="help-block"><?php echo $data['width_error']; ?></span>
                        </div>
                    </div>
                    <div class="form-group col-sm-6 <?php echo (empty($data['height_error'])) ?: 'has-error'; ?>">
                        <label class="control-label" for="pageTitle">ارتفاع الصورة : </label>
                        <div class="has-feedback">
                            <input type="text" class="form-control" name="height" placeholder="ارتفاع الصورة " value="<?php echo $data['height']; ?>">
                            <span class="fa fa-edit form-control-feedback" aria-hidden="true"></span>
                            <span class="help-block"><?php echo $data['height_error']; ?></span>
                        </div>
                    </div>
                    <div class="form-group col-sm-6 <?php echo (empty($data['piecesx_error'])) ?: 'has-error'; ?>">
                        <label class="control-label" for="pageTitle">عدد القطع بالعرض : </label>
                        <div class="has-feedback">
                            <input type="text" class="form-control" name="piecesx" placeholder="عدد القطع بالعرض " value="<?php echo $data['piecesx']; ?>">
                            <span class="fa fa-edit form-control-feedback" aria-hidden="true"></span>
                            <span class="help-block"><?php echo $data['piecesx_error']; ?></span>
                        </div>
                    </div>
                    <div class="form-group col-sm-6 <?php echo (empty($data['piecesy_error'])) ?: 'has-error'; ?>">
                        <label class="control-label" for="pageTitle">عدد القطع بالطول : </label>
                        <div class="has-feedback">
                            <input type="text" class="form-control" name="piecesy" placeholder="عدد القطع بالطول " value="<?php echo $data['piecesy']; ?>">
                            <span class="fa fa-edit form-control-feedback" aria-hidden="true"></span>
                            <span class="help-block"><?php echo $data['piecesy_error']; ?></span>
                        </div>
                    </div>
                    <div class="form-group col-sm-6 <?php echo (empty($data['timeout_error'])) ?: 'has-error'; ?>">
                        <label class="control-label" for="pageTitle">الوقت المطلوب : </label>
                        <div class="has-feedback">
                            <input type="text" class="form-control" name="timeout" placeholder="الوقت المطلوب " value="<?php echo $data['timeout']; ?>">
                            <span class="fa fa-edit form-control-feedback" aria-hidden="true"></span>
                            <span class="help-block"><?php echo $data['timeout_error']; ?></span>
                        </div>
                    </div>
                    <div class="form-group col-sm-6">
                        <label class="control-label" for="pageTitle">رابط التحويل عند انتهاء الوقت  : </label>
                        <div class="has-feedback">
                            <input type="text" class="form-control" name="timeout_url" placeholder="رابط التحويل عند انتهاء الوقت " value="<?php echo $data['timeout_url']; ?>">
                            <span class="fa fa-edit form-control-feedback" aria-hidden="true"></span>
                            <span class="help-block">يترك فارغ  لأعادة تحميل نفس الصفحة</span>
                        </div>
                    </div>

                </div>
                <div class="form-group  <?php echo (empty($data['description_error'])) ?: 'has-error'; ?>">
                    <label class="control-label">الوصف : </label>
                    <textarea rows="5" name="description" class="form-control"><?php echo ($data['description']); ?></textarea>
                </div>
            </div>
            <div class="col-lg-4 col-sm-12 col-xs-12 options">
                <h4>الاعدادات</h4>
                <div class="accordion">
                    <div class="card">
                        <div class="card-header" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                            <span> الاعدادات </span>
                        </div>
                        <div id="collapseOne" class="collapse card-body in" aria-labelledby="headingOne">
                            <div class="form-group col-xs-12 <?php echo (!empty($data['status_error'])) ? 'has-error' : ''; ?>">
                                <label class="control-label">الحالة :</label>
                                <div class="radio">
                                    <label>
                                        <input type="radio" class="flat" <?php echo ($data['status'] == 1) ? 'checked' : ''; ?> value="1" name="status"> مقروء
                                    </label>
                                    <label>
                                        <input type="radio" class="flat" <?php echo ($data['status'] == '0') ? 'checked' : ''; ?> value="0" name="status"> غير مقروء
                                    </label>
                                    <span class="help-block"><?php echo $data['status_error']; ?></span>
                                </div>
                            </div>
                        </div>
                        <div id="collapseOne" class="collapse card-body in" aria-labelledby="headingOne">
                            <div class="form-group col-xs-12 <?php echo (!empty($data['rotate_error'])) ? 'has-error' : ''; ?>">
                                <label class="control-label">الحالة :</label>
                                <div class="radio">
                                    <label>
                                        <input type="radio" class="flat" <?php echo ($data['rotate'] == 1) ? 'checked' : ''; ?> value="1" name="rotate"> دوران
                                    </label>
                                    <label>
                                        <input type="radio" class="flat" <?php echo ($data['rotate'] != 1) ? 'checked' : ''; ?> value="0" name="rotate"> بدون دوران
                                    </label>
                                    <span class="help-block"><?php echo $data['rotate_error']; ?></span>
                                </div>
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
