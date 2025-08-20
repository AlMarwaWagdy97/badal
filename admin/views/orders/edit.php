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
$data['header'] = '<!-- Select2 -->
<link rel="stylesheet" href="' . ADMINURL . '/template/default/vendors/select2/dist/css/select2.min.css">';
header("Content-Type: text/html; charset=utf-8");
require ADMINROOT . '/views/inc/header.php';
?>
<!-- page content -->
<div class="right_col" role="main">
    <div class="clearfix"></div>
    <?php flash('order_msg'); ?>
    <div class="page-title">
        <div class="title_right">
            <h3><?php echo $data['page_title']; ?> <small>التعديل علي التبرع </small></h3>
        </div>
        <div class="title_left">
            <a href="<?php echo ADMINURL; ?>/orders" class="btn btn-success pull-left">عودة <i class="fa fa-reply"></i></a>
        </div>
    </div>
    <div class="clearfix"></div>
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <form action="<?php echo ADMINURL . '/orders/edit/' . $data['order']->order_id; ?>" method="post" enctype="multipart/form-data" accept-charset="utf-8">
                <div class="col-sm-12 col-xs-12">
                    <div class="form-group">
                        <label class="control-label" for="pageTitle">معرف التبرع : </label>
                        <div class="has-feedback">
                            <input type="text" class="form-control" name="order_identifier" readonly value="<?php echo $data['order']->order_identifier; ?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label" for="total">قيمة التبرع : </label>
                        <div class="has-feedback">
                            <input type="number" class="form-control" name="total" required value="<?php echo $data['order']->total; ?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label" for="quantity"> الكمية : </label>
                        <div class="has-feedback">
                            <input type="number" class="form-control" name="quantity" required value="<?php echo $data['order']->quantity; ?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label" for="total"> الاجمالي : </label>
                        <div class="has-feedback">
                            <input type="number" class="form-control" name="total" required value="<?php echo $data['order']->total; ?>">
                        </div>
                    </div>
                    <div class="form-group <?php echo (!empty($data['payment_method_id_error'])) ? 'has-error' : ''; ?>">
                        <label class="control-label">وسيلة التبرع</label>
                        <div class="has-feedback">
                            <select name="payment_method_id" class="form-control">
                                <option value="">اختار وسيلة التبرع </option>
                                <?php foreach ($data['paymentMethodsList'] as $payment_method) : ?>
                                    <option value="<?php echo $payment_method->payment_id; ?>" <?php echo ($payment_method->payment_id == $data['order']->payment_method_id) ? " selected " : ''; ?>>
                                        <?php echo $payment_method->title; ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                            <span class="fa fa-folder form-control-feedback" aria-hidden="true"></span>
                        </div>
                        <span class="help-block"><?php echo $data['payment_method_id_error']; ?></span>
                    </div>
                    <?php #dd($data); 
                    ?>
                    <div class="form-group">
                        <label class="control-label">الوسوم</label>
                        <select class="form-control select2" name="status_id" style="width: 100%;">
                            <option value="0">اختار الوسوم المناسبة </option>
                            <?php foreach ($data['statusesList'] as $status) : ?>
                                <option value="<?php echo $status->status_id; ?>" <?php echo ($status->status_id ==  $data['order']->status_id) ? " selected " : 'no'; ?>>
                                    <?php echo $status->name; ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="">
                        <label class="control-label" for="imageUpload">اثبات التبرع : </label>
                        <div class="form-group <?php echo (empty($data['banktransferproof_error'])) ?: 'has-error'; ?>">
                            <label class="control-label" for="imageUpload"> اثبات التبرع : </label>
                            <div class="has-feedback input-group">
                                <span class="input-group-btn">
                                    <span class="btn btn-dark" onclick="$(this).parent().find('input[type=file]').click();">اختار الملف</span>
                                    <input name="banktransferproof" value="<?php echo ($data['order']->banktransferproof); ?>" onchange="$(this).parent().parent().find('.form-control').html($(this).val().split(/[\\|/]/).pop());" style="display: none;" type="file">
                                </span>
                                <span class="form-control"><small><?php echo empty($data['order']->banktransferproof) ? 'قم بأختيار صورة مناسبة' : $data['order']->banktransferproof; ?></small></span>
                            </div>
                            <div class="help-block"><?php echo $data['banktransferproof_error']; ?></div>
                        </div>
                    </div>
                    <div class="form-group col-xs-12 <?php echo (!empty($data['status_error'])) ? 'has-error' : ''; ?>">
                        <label class="control-label">حالة التبرع :</label>
                        <div class="radio">
                            <label>
                                <input type="radio" class="flat" <?php echo ($data['order']->status == 1) ? 'checked' : ''; ?> value="1" name="status"> مؤكد
                            </label>
                            <label>
                                <input type="radio" class="flat" <?php echo ($data['order']->status == 0) ? 'checked' : ''; ?> value="0" name="status"> غير مؤكد
                            </label>
                            <label>
                                <input type="radio" class="flat" <?php echo ($data['order']->status == 4) ? 'checked' : ''; ?> value="4" name="status"> ملغاه
                            </label>
                            <label>
                                <input type="radio" class="flat" <?php echo ($data['order']->status == 3) ? 'checked' : ''; ?> value="3" name="status"> في الانتظار
                            </label>
                            <span class="help-block"><?php echo $data['status_error']; ?></span>
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-12 ">
                            <label class="control-label">المشروعات المتبرع لها </label>
                            <!-- Button trigger modal -->
                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal">
                                اضافة مشروع جديد للتبرع
                            </button>

                        </div>
                        <br>
                        <div class="has-feedback">
                            <table class="table table-striped jambo_table bulk_action">
                                <thead>
                                    <tr class="headings">
                                        <th class="column-title">المشروع </th>
                                        <th class="column-title">القيمة </th>
                                        <th class="column-title">العدد </th>
                                        <th class="column-title">الاجمالي </th>
                                        <th class="column-title">النوع </th>
                                        <th class="column-title">آخر تحديث </th>
                                        <th class="column-title no-link last" width="140"><span class="nobr">اجراءات</span></th>

                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $totalAmount = 0;
                                    foreach ($data['donations'] as $donation) : 
                                        $totalAmount += $donation->total;
                                    ?>
                                        <tr class="even pointer">
                                            <td><?php echo $donation->project; ?></td>
                                            <td><?php echo $donation->amount; ?></td>
                                            <td><?php echo $donation->quantity; ?></td>
                                            <td><?php echo $donation->total; ?></td>
                                            <td><?php echo $donation->donation_type; ?></td>
                                            <td class="ltr"><?php echo date('Y/ m/ d | H:i a', $donation->modified_date); ?></td>
                                            <td class="form-group">
                                                <a href="<?php echo ADMINURL . '/donations/show/' . $donation->donation_id; ?>" class="btn btn-xs btn-success" data-placement="top" data-toggle="tooltip" data-original-title="عرض"><i class="fa fa-eye"></i></a>
                                                <a href="<?php echo ADMINURL . '/donations/edit/' . $donation->donation_id; ?>" class="btn btn-xs btn-primary" data-placement="top" data-toggle="tooltip" data-original-title="تعديل"><i class="fa fa-edit"></i></a>
                                                <a href="<?php echo ADMINURL . '/donations/delete/' . $donation->donation_id; ?>" class="btn btn-xs btn-danger" data-placement="top" data-toggle="tooltip" data-original-title="حذف" onclick="return confirm('Are you sure?') ? true : false"><i class="fa fa-trash-o"></i></a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>

                                    <tr class="tab-selected">
                                        <th></th>
                                        <th class="column-title" colspan="2"> العدد الكلي : <?php echo count($data['donations']); ?> </th>
                                        <th class="column-title" colspan="3"><?php echo $totalAmount; ?></th>
                                        <th class="column-title no-link last"></th>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="col-xs-12 col-md-offset-3">
                    <button type="submit" name="save" class="btn btn-success">تعديل
                        <i class="fa fa-save"> </i></button>
                    <button type="submit" name="submit" class="btn btn-success">تعديل وعودة
                        <i class="fa fa-save"> </i></button>
                    <button type="reset" class="btn btn-danger">مسح
                        <i class="fa fa-trash "> </i></button>
                </div>

            </form>

            <!-- Modal -->
            <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <form action="<?php echo ADMINURL . '/donations/add/' . $data['order']->order_id; ?>" method="post" enctype="multipart/form-data" accept-charset="utf-8">
                            <div class="modal-header text-center">
                                <button type="button" class="close btn-lg" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                <h4 class="modal-title" id="myModalLabel">مشروع جديد</h4>
                            </div>
                            <div class="modal-body">
                                <div class="form-group <?php echo (!empty($data['project_id_error'])) ? 'has-error' : ''; ?>">
                                    <label class="control-label">المشروع</label>
                                    <div class="has-feedback">
                                        <select name="project_id" required class="form-control">
                                            <option value="">اختار المشروع </option>
                                            <?php foreach ($data['projectList'] as $project) : ?>
                                                <option value="<?php echo $project->project_id; ?>" <?php echo ($project->project_id == $data['project_id']) ? " selected " : ''; ?>>
                                                    <?php echo $project->name; ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                        <span class="fa fa-folder form-control-feedback" aria-hidden="true"></span>
                                    </div>
                                    <span class="help-block"><?php echo $data['project_id_error']; ?></span>
                                </div>
                                <div class="form-group">
                                    <label class="control-label" for="amount">قيمة التبرع : </label>
                                    <div class="has-feedback">
                                        <input type="number" class="form-control" required name="amount"  value="">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label" for="quantity"> الكمية : </label>
                                    <div class="has-feedback">
                                        <input type="number" class="form-control" name="quantity" required value="1" min="1">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label" for="total"> الاجمالي : </label>
                                    <div class="has-feedback">
                                        <input type="number" class="form-control" name="total" required value="">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label" for="total"> النوع : </label>
                                    <div class="has-feedback">
                                        <input type="text" class="form-control" name="donation_type" value="">
                                    </div>
                                </div>
                                <div class="form-group ">
                                    <label class="control-label">حالة التبرع :</label>
                                    <div class="radio">
                                        <label>
                                            <input type="radio" class="flat" <?php echo ($data['order']->status == 1) ? 'checked' : ''; ?> value="1" name="status"> مؤكد
                                        </label>
                                        <label>
                                            <input type="radio" class="flat" <?php echo ($data['order']->status == 0) ? 'checked' : ''; ?> value="0" name="status"> غير مؤكد
                                        </label>
                                    </div>
                                </div>

                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">اغلاق</button>
                                <button type="submit" class="btn btn-primary">حفظ</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
// loading plugin
$data['footer'] = '<script src="' . ADMINURL . '/template/default/vendors/ckeditor/ckeditor.js"></script>
<script src="' . ADMINURL . '/template/default/vendors/select2/dist/js/select2.full.min.js"></script>
<script src="' . ADMINURL . '/template/default/vendors/jquery.tagsinput/src/jquery.tagsinput.js"></script>
<script>
$(".select2").select2({dir: "rtl"});
//filemanagesr for ck editor
 CKEDITOR.replace("ckeditor", {
     filebrowserBrowseUrl: "' . ADMINURL . '/helpers/filemanager/dialog.php?type=2&editor=ckeditor&fldr=" ,
     filebrowserUploadUrl: "' . ADMINURL . '/helpers/filemanager/dialog.php?type=2&editor=ckeditor&fldr=",
     filebrowserImageBrowseUrl: "' . ADMINURL . '/helpers/filemanager/dialog.php?type=1&editor=ckeditor&fldr="
 });
</script>';

require ADMINROOT . '/views/inc/footer.php';
