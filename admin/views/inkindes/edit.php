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
    <?php flash('inkind_msg');?>
    <div class="page-title">
        <div class="title_right">
            <h3><?php echo $data['page_title']; ?> <small>التعديل علي التبرع </small></h3>
        </div>
        <div class="title_left">
            <a href="<?php echo ADMINURL; ?>/inkindes" class="btn btn-success pull-left">عودة <i class="fa fa-reply"></i></a>
        </div>
    </div>

    <div class="clearfix"></div>

    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
        <form action="<?php echo ADMINURL . '/inkindes/edit/' . $data['inkind_id']; ?>" method="post" enctype="multipart/form-data" accept-charset="utf-8" >

        <div class="col-lg-8 col-sm-12 col-xs-12">
                <div class="form-group  <?php echo (empty($data['district_error'])) ?: 'has-error'; ?>">
                    <label class="control-label" for="pageTitle">الحي : </label>
                    <div class="has-feedback">
                        <input type="text" class="form-control" name="district" placeholder="عنوان الحي" value="<?php echo $data['district']; ?>">
                        <span class="fa fa-edit form-control-feedback" aria-hidden="true"></span>
                        <span class="help-block"><?php echo $data['district_error']; ?></span>
                    </div>
                </div>
                <div class="form-group  <?php echo (empty($data['full_name_error'])) ?: 'has-error'; ?>">
                    <label class="control-label" for="pageTitle">الاسم بالكامل : </label>
                    <div class="has-feedback">
                        <input type="text" class="form-control" name="full_name" placeholder="الاسم بالكامل" value="<?php echo $data['full_name']; ?>">
                        <span class="fa fa-edit form-control-feedback" aria-hidden="true"></span>
                        <span class="help-block"><?php echo $data['full_name_error']; ?></span>
                    </div>
                </div>

                <div class="form-group ">
                    <label class="control-label" for="pageTitle">الهاتف : </label>
                    <div class="has-feedback">
                        <input type="text" class="form-control" name="phone" placeholder="الهاتف" value="<?php echo $data['phone']; ?>">
                        <span class="fa fa-edit form-control-feedback" aria-hidden="true"></span>
                    </div>
                </div>
                <div class="form-group ">
                    <label class="control-label" for="pageTitle">البريد الالكتروني : </label>
                    <div class="has-feedback">
                        <input type="text" class="form-control" name="email" placeholder="البريد الالكتروني" value="<?php echo $data['email']; ?>">
                        <span class="fa fa-edit form-control-feedback" aria-hidden="true"></span>
                    </div>
                </div>
                
                <div class="form-group ">
                    <label class="control-label" for="pageTitle">الشارع : </label>
                    <div class="has-feedback">
                        <input type="text" class="form-control" name="street" placeholder="الشارع" value="<?php echo $data['street']; ?>">
                        <span class="fa fa-edit form-control-feedback" aria-hidden="true"></span>
                    </div>
                </div>
                <div class="form-group  <?php echo (empty($data['message_error'])) ?: 'has-error'; ?>">
                    <label class="control-label">نص التبرع  : </label>
                        <textarea rows="5" name="message" class="form-control"><?php echo ($data['message']); ?></textarea>
                        <span class="help-block"><?php echo $data['message_error']; ?></span>
                </div>
            </div>
            <div class="col-lg-4 col-sm-12 col-xs-12 options">
                <h4>الاعدادات</h4>
                <div class="accordion">
                    <div class="card">
                        <div class="card-header" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne" >
                                <span> الاعدادات   </span>
                        </div>
                        <div id="collapseOne" class="collapse card-body in" aria-labelledby="headingOne" >
                            <div class="form-group col-xs-12 <?php echo (!empty($data['status_error'])) ? 'has-error' : ''; ?>">
                                <label class="control-label">الحالة  :</label>
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
$data['footer'] = '';

require ADMINROOT . '/views/inc/footer.php';
