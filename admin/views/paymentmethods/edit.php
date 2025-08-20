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
    <?php flash('paymentmethod_msg'); ?>
    <div class="page-title">
        <div class="title_right">
            <h3><?php echo $data['page_title']; ?> <small>التعديل علي وسيلة الدفع </small></h3>
        </div>
        <div class="title_left">
            <a href="<?php echo ADMINURL; ?>/paymentmethods" class="btn btn-success pull-left">عودة <i class="fa fa-reply"></i></a>
        </div>
    </div>

    <div class="clearfix"></div>

    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">

            <form action="<?php echo ADMINURL . '/paymentmethods/edit/' . $data['payment_id']; ?>" method="post" enctype="multipart/form-data" accept-charset="utf-8">
                <div class="form-group">
                    <label class="control-label" for="pageTitle">عنوان وسيلة الدفع : </label>
                    <div class="has-feedback">
                        <input type="text" id="pageTitle" class="form-control" name="title" placeholder="عنوان وسيلة الدفع" value="<?php echo $data['title']; ?>">
                        <span class="fa fa-edit form-control-feedback" aria-hidden="true"></span>
                        <span class="help-block"></span>
                    </div>
                </div>
                
                <?php if ($data['payment_id'] != 1) : ?>
                <div class="form-group">
                    <label class="control-label" for="payment_key">كود وسيلة الدفع : </label>
                    <div class="has-feedback">
                        <input type="text" id="payment_key" class="form-control" name="payment_key" placeholder="كود وسيلة الدفع" value="<?php echo $data['payment_key']; ?>">
                    </div>
                </div>                
                <?php endif; ?>
                <div class="form-group <?php echo (!empty($data['image_error'])) ? 'has-error' : ''; ?>">
                    <label class="control-label" for="imageUpload">ايقونة وسيلة الدفع : </label>
                    <div class="has-feedback input-group">
                        <span class="input-group-btn">
                            <span class="btn btn-dark" onclick="$(this).parent().find('input[type=file]').click();">اختار الملف</span>
                            <input name="image" value="<?php echo ($data['image']); ?>" onchange="$(this).parent().parent().find('.form-control').html($(this).val().split(/[\\|/]/).pop());" style="display: none;" type="file">
                        </span>
                        <span class="form-control"><small><?php echo empty($data['image']) ? 'قم بأختيار صورة مناسبة' : $data['image']; ?></small></span>
                    </div>
                    <div class="help-block"><?php echo $data['image_error']; ?></div>
                </div>
                <?php if ($data['payment_id'] == 1) : ?>
                    <div class="form-group col-md-12">
                        <label class="control-label">الحسابات البنكية : </label>
                        <table class="table table-striped jambo_table text-center">
                            <thead>
                                <tr class="headings  text-center">
                                    <th class="">اسم البنك </th>
                                    <th class="">نوع الحساب </th>
                                    <th class="">IBAN </th>
                                    <th class="">Payment key </th>
                                    <th class="">رابط البنك </th>
                                    <th class="" colspan="2"> الصوره </th>
                                    <th></th>
                                </tr>
                            </thead>
                            
                            <tbody id="items">
                                <?php
                                if (!empty($data['meta'])) {
                                    $x = 1;
                                    foreach ($data['meta'] as $bank) {
                                        echo '<tr class="">
                                        <input type="hidden" name="meta[bank' . $x . '][image]" value="'.@$bank['image'].'">
                                        <td class="form-group"><input class="form-control" value = "' . $bank['bankname'] . '" type="text" name="meta[bank' . $x . '][bankname]"></td>
                                        <td class="form-group"><input class="form-control" value = "' . $bank['account_type'] . '"  type="text" name="meta[bank' . $x . '][account_type]"></td>
                                        <td class="form-group"><input class="form-control" value = "' . $bank['iban'] . '"  type="text" name="meta[bank' . $x . '][iban]"></td>
                                        <td class="form-group"><input class="form-control" value = "' . $bank['payment_key'] . '"  type="text" name="meta[bank' . $x . '][payment_key]"></td>
                                        <td class="form-group"><input class="form-control" value = "' . $bank['url'] . '"  type="text" name="meta[bank' . $x . '][url]"></td>
                                        <td class="form-group"><input class="form-control" type="file" name="bank' . $x . '"></td>
                                        <td class="form-group"><a href="'.   MEDIAURL . '/' . @$bank['image'].'" target="_blank"><img src="'.   MEDIAURL . '/' . @$bank['image'].'" width="50"></a></td>
                                        <td><a href="#" class="remove_field"><i class="fa fa-times"></a></td>
                                    </tr>';
                                        $x++;
                                    }
                                }
                                ?>
                            </tbody>
                        </table>
                        <button type="button" class="add_field_button btn btn-dark">اضافة حساب جديد</button>
                    </div>
                <?php endif; ?>
                <?php if ($data['payment_id'] == 2) : ?>
                    <div class="form-group col-md-12">
                        <label class="control-label">الفروع : </label>
                        <table class="table table-striped jambo_table text-center">
                            <thead>
                                <tr class="headings  text-center">
                                    <th class="">اسم الفرع </th>
                                    <th class="">العنوان </th>
                                    <th class="">رابط العنوان علي خرائط جوجل </th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody id="items">
                                <?php
                                if (!empty($data['meta'])) {
                                    $x = 1;
                                    foreach ($data['meta'] as $branch) {
                                        echo '<tr class="">
                                            <td class="form-group"><input class="form-control" value = "' . $branch['branchname'] . '" type="text" name="meta[branch' . $x . '][branchname]"></td>
                                            <td class="form-group"><input class="form-control" value = "' . $branch['address'] . '"  type="text" name="meta[branch' . $x . '][address]"></td>
                                            <td class="form-group"><input class="form-control" value = "' . $branch['url'] . '"  type="text" name="meta[branch' . $x . '][url]"></td>
                                            <td><a href="#" class="remove_field"><i class="fa fa-times"></a></td>
                                        </tr>';
                                        $x++;
                                    }
                                }
                                ?>
                            </tbody>
                        </table>
                        <button type="button" class="add_field2 btn btn-dark">اضافة حساب جديد</button>
                    </div>
                <?php endif; ?>
                <div class="form-group col-md-12">
                    <label class="control-label">المحتوي : </label>
                    <div class="row">
                        <textarea name="content" id="ckeditor" class="ckeditor form-control"><?php echo ($data['content']); ?></textarea>
                    </div>
                </div>
                <div class="form-group col-xs-12">
                    <label class="control-label">اتاحة وسيلة الدفع داخل سلة الشراء :</label>
                    <div class="radio">
                        <label>
                            <input type="radio" class="flat" <?php echo ($data['cart_show'] == 1) ? 'checked' : ''; ?> value="1" name="cart_show"> منشور
                        </label>
                        <label>
                            <input type="radio" class="flat" <?php echo ($data['cart_show'] == '0') ? 'checked' : ''; ?> value="0" name="cart_show"> غير منشور
                        </label>
                    </div>
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
                </script>
                ';

require ADMINROOT . '/views/inc/footer.php';
