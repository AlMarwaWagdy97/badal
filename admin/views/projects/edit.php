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
    <?php flash('project_msg'); ?>
    <div class="page-title">
        <div class="title_right">
            <h3><?php echo $data['page_title']; ?> <small>التعديل علي المشروع </small></h3>
        </div>
        <div class="title_left">
            <a href="<?php echo ADMINURL; ?>/projects" class="btn btn-success pull-left">عودة <i class="fa fa-reply"></i></a>
        </div>
    </div>

    <div class="clearfix"></div>

    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <form action="<?php echo ADMINURL . '/projects/edit/' . $data['project_id']; ?>" method="post" enctype="multipart/form-data" accept-charset="utf-8">
                <div class="col-lg-8 col-sm-12 col-xs-12">
                    <div class="form-group  <?php echo (empty($data['name_error'])) ?: 'has-error'; ?>">
                        <label class="control-label" for="pageTitle">عنوان المشروع : </label>
                        <div class="has-feedback">
                            <input type="text" class="form-control" name="name" placeholder="عنوان المشروع" value="<?php echo $data['name']; ?>">
                            <span class="fa fa-edit form-control-feedback" aria-hidden="true"></span>
                            <span class="help-block"><?php echo $data['name_error']; ?></span>
                        </div>
                    </div>
                    <div class="form-group  <?php echo (empty($data['project_number_error'])) ?: 'has-error'; ?>">
                        <label class="control-label" for="pageTitle">رقم المشروع : </label>
                        <div class="has-feedback">
                            <input type="text" class="form-control" name="project_number" placeholder="رقم المشروع" value="<?php echo $data['project_number']; ?>">
                            <span class="fa fa-edit form-control-feedback" aria-hidden="true"></span>
                            <span class="help-block"><?php echo $data['project_number_error']; ?></span>
                        </div>
                    </div>
                <div class="form-group">
                    <label class="control-label" for="pageTitle">رقم المستفيد : </label>
                    <div class="has-feedback">
                        <input type="text" class="form-control" name="beneficiary" placeholder="رقم المستفيد" value="<?php echo $data['beneficiary']; ?>">
                        <span class="fa fa-edit form-control-feedback" aria-hidden="true"></span>
                    </div>
                </div>
                    <div class="form-group <?php echo (!empty($data['category_id_error'])) ? 'has-error' : ''; ?>">
                        <label class="control-label">الاقسام</label>
                        <div class="has-feedback">
                            <select name="category_id" class="form-control">
                                <option value="">اختار قسم المشروع </option>
                                <?php foreach ($data['categories'] as $category) : ?>
                                    <option value="<?php echo $category->category_id; ?>" <?php echo ($category->category_id == $data['category_id']) ? " selected " : ''; ?>>
                                        <?php echo $category->name; ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                            <span class="fa fa-folder form-control-feedback" aria-hidden="true"></span>
                        </div>
                        <span class="help-block"><?php echo $data['category_id_error']; ?></span>
                    </div>
                    <div class="form-group">
                        <label class="control-label">الوسوم</label>
                        <select class="form-control select2" name="tags[]" multiple="multiple" data-placeholder="اختار الوسوم المناسبة" style="width: 100%;">
                            <?php foreach ($data['tagsList'] as $tag) : ?>
                                <option value="<?php echo $tag->tag_id; ?>" <?php echo in_array($tag->tag_id, $data['tags']) ? " selected " : 'no'; ?>>
                                    <?php echo $tag->name; ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="">
                        <a class="btn-danger btn-sm btn pull-left" onclick="$('#galery').val('');">حذف الصور &nbsp<i class="fa fa-close"></i></a>
                        <label class="control-label clearfix" for="imageUpload">صور المشروع :
                        </label>

                        <div class="glr-group row">
                            <a data-toggle="modal" href="javascript:;" data-target="#myModal" class="glr-btn col-xs-2" type="button">اختيار</a>
                            <input id="galery" readonly name="image" class="glr-control  col-xs-10" type="text" value="<?php echo $data['image']; ?>">
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
                    <div class="form-group <?php echo (empty($data['secondary_image_error'])) ?: 'has-error'; ?>">
                        <label class="control-label" for="imageUpload"> صورة المشروع الخارجية : </label>
                        <div class="has-feedback input-group">
                            <span class="input-group-btn">
                                <span class="btn btn-dark" onclick="$(this).parent().find('input[type=file]').click();">اختار الملف</span>
                                <input name="secondary_image" value="<?php echo ($data['secondary_image']); ?>" onchange="$(this).parent().parent().find('.form-control').html($(this).val().split(/[\\|/]/).pop());" style="display: none;" type="file">
                                <input type="hidden" name="s_image" value="<?php echo ($data['secondary_image']); ?>">
                            </span>
                            <span class="form-control"><small><?php echo empty($data['secondary_image']) ? 'قم بأختيار صورة مناسبة' : $data['secondary_image']; ?></small></span>
                        </div>
                        <div class="help-block"><?php echo $data['secondary_image_error']; ?></div>
                    </div>
                    <div class="form-group">
                        <label class="control-label">الإضافة الي السلة :</label>
                        <div class="radio">
                            <label><input type="radio" class="flat" <?php echo ($data['enable_cart'] == 1) ? 'checked' : ''; ?> value="1" name="enable_cart"> يقبل الاضافة للسلة </label>
                            <label><input type="radio" class="flat" <?php echo ($data['enable_cart'] == 0) ? 'checked' : ''; ?> value="0" name="enable_cart"> لا يقبل الاضافة للسلة </label>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label">الاهداء الخيري :</label>
                        <div class="radio">
                            <label><input type="radio" class="flat" <?php echo ($data['gift'] == 1) ? 'checked' : ''; ?> value="1" name="gift"> يقبل الاهداء الخيري </label>
                            <label><input type="radio" class="flat" <?php echo ($data['gift'] == 0) ? 'checked' : ''; ?> value="0" name="gift"> لا يقبل الاهداء الخيري </label>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label" for="pageTitle"> عنوان المشروع في كارت الاهداء : </label>
                        <div class="has-feedback">
                            <input type="text" class="form-control" name="gift_card_title" placeholder="عنوان المشروع في كارت الاهداء" value="<?php echo $data['gift_card_title']; ?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label"> تأكيد الجوال :</label>
                        <div class="radio">
                            <label><input type="radio" class="flat" <?php echo ($data['mobile_confirmation'] == 1) ? 'checked' : ''; ?> value="1" name="mobile_confirmation"> يجب تأكيد الجوال </label>
                            <label><input type="radio" class="flat" <?php echo ($data['mobile_confirmation'] == 0) ? 'checked' : ''; ?> value="0" name="mobile_confirmation"> تجاهل تأكيد الجوال </label>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label">وصف المشروع : </label>
                        <textarea rows="5" name="description" id="ckeditor" class="form-control ckeditor"><?php echo ($data['description']); ?></textarea>
                    </div>
                    <div class="form-group col-xs-12 <?php echo (!empty($data['status_error'])) ? 'has-error' : ''; ?>">
                        <label class="control-label">حالة النشر :</label>
                        <div class="radio">
                            <label>
                                <input type="radio" class="flat" <?php echo ($data['status'] == 1) ? 'checked' : ''; ?> value="1" name="status"> منشور
                            </label>
                            <label>
                                <input type="radio" class="flat" <?php echo ($data['status'] == 0) ? 'checked' : ''; ?> value="0" name="status"> غير منشور
                            </label>
                            <span class="help-block"><?php echo $data['status_error']; ?></span>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-sm-12 col-xs-12 options">
                    <h4>الاعدادات</h4>
                    <div class="accordion">
                        <div class="card">
                            <div class="card-header" data-toggle="collapse" data-target="#collapseZero" aria-expanded="true" aria-controls="collapseZero">
                                <span> اعدادات الدفع </span>
                            </div>
                            <div id="collapseZero" class="collapse in card-body" aria-labelledby="headingZero">
                                <div class="form-group <?php echo (!empty($data['donation_type_error'])) ? 'has-error' : ''; ?>">
                                    <label class="control-label">نوع التبرع</label>
                                    <div class="has-feedback">
                                        <select name="donation_type[type]" class="form-control type-change">
                                            <option value="">اختار نوع التبرع </option>
                                            <?php
                                            foreach ($data['donation_type_list'] as $donationtype => $value) {
                                                echo '<option value="' . $donationtype . '"';
                                                echo ($data['donation_type']['type'] != $donationtype) ?: ' selected ';
                                                echo ' >' . $value . '</option>';
                                            }
                                            ?>
                                        </select>
                                        <br>
                                        <div class="collapse <?php echo ($data['donation_type']['type'] == "share" || $data['donation_type']['type'] == "unit") ? 'in' : '' ?> multible-values">
                                            <table class="table jambo_table text-center ">
                                                <thead>
                                                    <tr class="headings text-center">
                                                        <th>الاسم</th>
                                                        <th colspan="2">القيمة </th>
                                                    </tr>
                                                </thead>
                                                <tbody id="items">
                                                    <?php
                                                    if ($data['donation_type']['type'] == "share" || $data['donation_type']['type'] == "unit") {
                                                        foreach ($data['donation_type']['value'] as $key => $value) {
                                                            echo '<tr class="">' .
                                                                '<td class="form-group"><input value="' . $value['name'] . '" class="form-control" required type="text" name="donation_type[value][' . $key . '][name]"></td>' .
                                                                '<td class="form-group"><input value="' . $value['value'] . '" class="form-control" required type="number" name="donation_type[value][' . $key . '][value]"></td>' .
                                                                '<td><a href="#" class="remove_field"><i class="fa fa-times"></a></td>' .
                                                                '</tr>';
                                                        }
                                                    }
                                                    ?>
                                                </tbody>
                                            </table>
                                            <button type="button" class="add_field_donation btn btn-dark">اضافة خيار جديد</button>
                                        </div>
                                        <div class="donation_type_data">
                                            <?php
                                            // var_dump($data['donation_type']); 
                                            if ($data['donation_type']['type'] == "fixed") {
                                                echo '<label class="control-label">القيم الثابتة</label>
                                        <input value="' . $data['donation_type']['value'] . '" required class="form-control" type="number" name="donation_type[value]">';
                                            }
                                            ?>
                                        </div>
                                        <span class="fa fa-folder form-control-feedback" aria-hidden="true"></span>
                                    </div>
                                    <span class="help-block"><?php echo $data['donation_type_error']; ?></span>
                                </div>
                                <br>
                                <div class="form-group">
                                    <label>المبلغ المستهدف : </label>
                                    <input type="number" class="form-control" name="target_price" value="<?php echo $data['target_price']; ?>" placeholder="المبلغ المستهدف جمعه">
                                </div>
                                <div class="form-group">
                                    <label>الوحدة : </label>
                                    <input type="text" class="form-control" name="target_unit" value="<?php echo $data['target_unit']; ?>" placeholder="الوحدة المستهدف جمعها">
                                </div>
                                <div class="form-group">
                                    <label>سعر الوحدة : </label>
                                    <input type="number" class="form-control" name="unit_price" value="<?php echo $data['unit_price']; ?>" placeholder="سعر الوحدة ">
                                </div>
                                <div class="form-group">
                                    <label>القيم المؤقته لما تم جمعه : </label>
                                    <input type="number" class="form-control" name="fake_target" value="<?php echo $data['fake_target']; ?>" placeholder="رقم مؤقت يظهر للمتبرع">
                                </div>
                                <div class="form-group <?php echo (!empty($data['payment_methods_error'])) ? 'has-error' : ''; ?>">
                                    <label class="control-label">وسائل الدفع المعتمدة للمشروع :</label>
                                    <div class="radio">
                                        <?php
                                        foreach ($data['paymentMethodsList'] as $method) {
                                            echo '<label><input type="checkbox"';
                                            echo !in_array($method->payment_id, $data['payment_methods']) ?: ' checked ';
                                            echo ' class="flat" value="' . $method->payment_id . '" name="payment_methods[]"> ' . $method->title . ' </label>';
                                        }
                                        ?>
                                    </div>
                                    <span class="help-block"><?php echo $data['payment_methods_error']; ?></span>
                                </div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-header" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                <span> اعدادات النشر </span>
                            </div>
                            <div id="collapseOne" class="collapse card-body" aria-labelledby="headingOne">
                                <div class="form-group">
                                    <label>الترتيب : </label>
                                    <input type="number" class="form-control" name="arrangement" value="<?php echo $data['arrangement']; ?>" placeholder="الترتيب">
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
                                    <label>تاريخ بدأ النشر : </label>
                                    <input type="date" class="form-control" name="start_date" value="<?php echo date("Y-m-d", $data['start_date']); ?>" placeholder="تاريخ بدأ النشر">
                                </div>
                                <div class="form-group">
                                    <label>تاريخ ايقاف النشر : </label>
                                    <input type="date" class="form-control date" name="end_date" value="<?php echo date("Y-m-d", $data['end_date']); ?>" placeholder="تاريخ ايقاف النشر">
                                </div>
                                <div class="form-group">
                                    <div class="radio">
                                        <label class="control-label">نشر كا مميز :</label>
                                        <label><input type="radio" class="flat" <?php echo ($data['featured'] == 1) ? 'checked' : ''; ?> value="1" name="featured"> نعم</label>
                                        <label><input type="radio" class="flat" <?php echo ($data['featured'] == 0) ? 'checked' : ''; ?> value="0" name="featured"> لا</label>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="radio">
                                        <label class="control-label">نشر كا مخفي :</label>
                                        <label><input type="radio" class="flat" <?php echo ($data['hidden'] == 1) ? 'checked' : ''; ?> value="1" name="hidden"> نعم</label>
                                        <label><input type="radio" class="flat" <?php echo ($data['hidden'] == 0) ? 'checked' : ''; ?> value="0" name="hidden"> لا</label>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="radio">
                                        <label class="control-label">اغلاق التبرع :</label>
                                        <label><input type="radio" class="flat" <?php echo ($data['finished'] == 1) ? 'checked' : ''; ?> value="1" name="finished"> اغلاق </label>
                                        <label><input type="radio" class="flat" <?php echo ($data['finished'] == 0) ? 'checked' : ''; ?> value="0" name="finished"> فتح </label>
                                    </div>
                                </div>
                                <div class="form-grou">
                                    <div class="radio">
                                        <label class="control-label">اظهار زر العودة الي الرئيسية :</label>
                                        <label><input type="radio" class="flat" <?php echo ($data['back_home'] == 1) ? 'checked' : ''; ?> value="1" name="back_home"> نعم</label>
                                        <label><input type="radio" class="flat" <?php echo ($data['back_home'] == 0) ? 'checked' : ''; ?> value="0" name="back_home"> لا</label>
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
                                    <label class="control-label">كود الهيدر : </label>
                                    <div class=" form-group">
                                        <textarea name="header_code" class="form-control" placeholder="ادرج كود javascript"><?php echo $data['header_code']; ?></textarea>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label">كود التتبع الاعلاني : </label>
                                    <div class=" form-group">
                                        <textarea name="advertising_code" class="form-control" placeholder="ادرج كودالتتبع الأعلاني"><?php echo $data['advertising_code']; ?></textarea>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label">الوصف : </label>
                                    <div class="text-warning ">وصف مختصر لمحرك البحث</div>
                                    <div class=" form-group">
                                        <textarea name="meta_description" class="form-control description" placeholder="ادرج وصف مختصر عن المشروع"><?php echo $data['meta_description']; ?></textarea>
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
                        <div class="card">
                            <div class="card-header" data-toggle="collapse" data-target="#collapsefour" aria-expanded="true" aria-controls="collapsefour">
                                <span>اعدادات التواصل</span>
                            </div>
                            <div id="collapsefour" class="collapse card-body" aria-labelledby="headingfour">
                                <div class="form-group">
                                    <label>رقم الهاتف : </label>
                                    <input type="text" class="form-control" name="mobile" value="<?php echo $data['mobile']; ?>">
                                </div>
                                <div class="form-group">
                                    <label>رقم WhatsApp : </label>
                                    <input type="text" class="form-control" name="whatsapp" value="<?php echo $data['whatsapp']; ?>">
                                </div>
                                <div class="form-group">
                                    <label class="control-label">رسالة الشكر التلقائية : </label>
                                    <div class="text-warning ">رسالة تظهر للمستخدم بعد اتمام عملية الدفع</div>
                                    <div class=" form-group">
                                        <textarea name="thanks_message" class="form-control description" placeholder="شكرا جزيلا لتبرعكم"><?php echo $data['thanks_message']; ?></textarea>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="control-label">الرسالة النصية القصيرة : </label>
                                    <div class="form-group col-xs-12 ">
                                        <button type="button" class="btn btn-primary" name="" onclick="$('#message').val($('#message').val() +'[[name]]') ;return false;" value="">ارفاق الاسم </button>
                                        <button type="button" class="btn btn-primary" name="" onclick="$('#message').val($('#message').val() +'[[identifier]]') ;return false;" value="">ارفاق رقم الطلب </button>
                                        <button type="button" class="btn btn-primary" name="" onclick="$('#message').val($('#message').val() +'[[total]]') ;return false;" value="">ارفاق المبلغ </button>
                                        <button type="button" class="btn btn-primary" name="" onclick="$('#message').val($('#message').val() +'[[project]]') ;return false;" value="">ارفاق المشروع </button>
                                    </div>
                                    <div class="text-warning ">رسالة ترسل للمستخدم عند تأكيد الطلب</div>
                                    <div class=" form-group">
                                        <textarea name="sms_msg" class="form-control description" id="message" placeholder="تم استلام تبرعكم بنجاح"><?php echo $data['sms_msg']; ?></textarea>
                                    </div>
                                </div>

                            </div>
                        </div>

                    </div>
                    <br><br>
                </div>
                <div class="col-md-9 col-sm-9 col-xs-12 col-md-offset-3">
                    <button type="submit" name="save" class="btn btn-success">تعديل
                        <i class="fa fa-edit"> </i></button>
                    <button type="submit" name="submit" class="btn btn-success">تعديل وعودة
                        <i class="fa fa-edit"> </i></button>
                    <button type="reset" class="btn btn-danger">مسح
                        <i class="fa fa-trash "> </i></button>
                    <button type="submit" name="save_new" class="btn btn-primary"> حفظ كا مشروع جديد
                        <i class="fa fa-save "> </i></button>
                </div>

            </form>
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
