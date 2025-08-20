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

                <br>
                <!-- Confirm Order ------------------------------------------------------------------------------- -->
                <div class="col-lg-12 col-sm-12 col-xs-12 options">
                    <div class="accordion">
                        <div class="card">
                            <!-- Confirm Order ------------------------------------------------------------------------------- -->
                            <div class="x_panel tile ">
                                <!-- New Order ------------------------------------------------------------------------------- -->
                                <div class="new-order-container">
                                    <div class="card-header" data-toggle="collapse" data-target="#collapseConfirmOrder" aria-expanded="true" aria-controls="collapseConfirmOrder">
                                        <span> تاكيد الطلب جديد ( ترسل للمتبرع ) </span>
                                    </div>
                                    <div id="collapseConfirmOrder" class="collapse card-body" aria-labelledby="headingOne">
                                        <div class="email-container">
                                            <h3> البريد الاكتروني</h3>
                                            <div class="form-group">
                                                <label class="control-label">تفعيل الارسال :</label>
                                                <div class="radio">
                                                    <label>
                                                        <input type="radio" class="flat" <?php echo (@$data['value']->confirm_enabled == 1) ? 'checked' : ''; ?> value="1" name="value[confirm_enabled]"> مفعلة
                                                    </label>
                                                    <label>
                                                        <input type="radio" class="flat" <?php echo (@$data['value']->confirm_enabled == '0') ? 'checked' : ''; ?> value="0" name="value[confirm_enabled]"> معلقة
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label" for="confirm_subject">عنوان الرسالة : </label>
                                                <div class="has-feedback">
                                                    <input type="text" id="confirm_subject" class="form-control" name="value[confirm_subject]" placeholder="عنوان الرسالة" value="<?php echo @$data['value']->confirm_subject; ?>">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <br>
                                                <button type="button" class="btn btn-primary" onclick="$('#confirm_msg').val($('#confirm_msg').val() +'[[name]]') ;return false;" value="">ارفاق الاسم </button>
                                                <button type="button" class="btn btn-primary" onclick="$('#confirm_msg').val($('#confirm_msg').val() +'[[identifier]]') ;return false;" value="">ارفاق رقم الطلب </button>
                                                <button type="button" class="btn btn-primary" onclick="$('#confirm_msg').val($('#confirm_msg').val() +'[[total]]') ;return false;" value="">ارفاق المبلغ </button>
                                                <button type="button" class="btn btn-primary" onclick="$('#confirm_msg').val($('#confirm_msg').val() +'[[project]]') ;return false;" value="">ارفاق اسم المشروع </button>
                                                <small class="red ">سيتم استبدال المتغير الخاص بالقيمة </small>
                                            </div>
                                            <div class="form-group col-md-12">
                                                <label class="control-label">المحتوي : </label>
                                                <div class="row">
                                                    <textarea id="confirm_msg" name="value[confirm_msg]" rows="6" class="form-control"><?php echo (@$data['value']->confirm_msg); ?></textarea>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="sms">
                                            <h3> رساله ال SMS</h3>
                                            <div class="form-group">
                                                <label class="control-label">تفعيل الارسال :</label>
                                                <div class="radio">
                                                    <label>
                                                        <input type="radio" class="flat" <?php echo (@$data['value']->confirm_sms == 1) ? 'checked' : ''; ?> value="1" name="value[confirm_sms]"> مفعلة
                                                    </label>
                                                    <label>
                                                        <input type="radio" class="flat" <?php echo (@$data['value']->confirm_sms == '0') ? 'checked' : ''; ?> value="0" name="value[confirm_sms]"> معلقة
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <br>
                                                <button type="button" class="btn btn-primary" onclick="$('#confirm_sms_msg').val($('#confirm_sms_msg').val() +'[[name]]') ;return false;" value="">ارفاق الاسم </button>
                                                <button type="button" class="btn btn-primary" onclick="$('#confirm_sms_msg').val($('#confirm_sms_msg').val() +'[[identifier]]') ;return false;" value="">ارفاق رقم الطلب </button>
                                                <button type="button" class="btn btn-primary" onclick="$('#confirm_sms_msg').val($('#confirm_sms_msg').val() +'[[total]]') ;return false;" value="">ارفاق المبلغ </button>
                                                <button type="button" class="btn btn-primary" onclick="$('#confirm_sms_msg').val($('#confirm_sms_msg').val() +'[[project]]') ;return false;" value="">ارفاق اسم المشروع </button>
                                                <small class="red ">سيتم استبدال المتغير الخاص بالقيمة </small>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label">المحتوي : </label>
                                                <div class="row">
                                                    <textarea id="confirm_sms_msg" name="value[confirm_sms_msg]" rows="6" class="form-control"><?php echo (@$data['value']->confirm_sms_msg); ?></textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <br>

                                <!-- New Order ------------------------------------------------------------------------------- -->
                                <div class="col-lg-12 col-sm-12 col-xs-12 options">

                                    <div class="accordion">
                                        <div class="card">

                                            <!-- Order ------------------------------------------------------------------------------- -->
                                            <div class="x_panel tile ">
                                                <!-- New Order ------------------------------------------------------------------------------- -->
                                                <div class="new-order-container">
                                                    <div class="card-header" data-toggle="collapse" data-target="#collapseOrder" aria-expanded="true" aria-controls="collapseOrder">
                                                        <span> طلب جديد ( ترسل للمتطوعين ) </span>
                                                    </div>
                                                    <div id="collapseOrder" class="collapse card-body" aria-labelledby="headingOne">
                                                        <div class="email-container">
                                                            <h3> البريد الاكتروني</h3>
                                                            <div class="form-group">
                                                                <label class="control-label">تفعيل الارسال :</label>
                                                                <div class="radio">
                                                                    <label>
                                                                        <input type="radio" class="flat" <?php echo (@$data['value']->newOrder_enabled == 1) ? 'checked' : ''; ?> value="1" name="value[newOrder_enabled]"> مفعلة
                                                                    </label>
                                                                    <label>
                                                                        <input type="radio" class="flat" <?php echo (@$data['value']->newOrder_enabled == '0') ? 'checked' : ''; ?> value="0" name="value[newOrder_enabled]"> معلقة
                                                                    </label>
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="control-label" for="confirm_subject">عنوان الرسالة : </label>
                                                                <div class="has-feedback">
                                                                    <input type="text" id="confirm_subject" class="form-control" name="value[newOrder_subject]" placeholder="عنوان الرسالة" value="<?php echo @$data['value']->newOrder_subject; ?>">
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <br>
                                                                <button type="button" class="btn btn-primary" onclick="$('#new_msg').val($('#new_msg').val() +'[[name]]') ;return false;" value="">ارفاق الاسم </button>
                                                                <button type="button" class="btn btn-primary" onclick="$('#new_msg').val($('#new_msg').val() +'[[identifier]]') ;return false;" value="">ارفاق رقم الطلب </button>
                                                                <button type="button" class="btn btn-primary" onclick="$('#new_msg').val($('#new_msg').val() +'[[total]]') ;return false;" value="">ارفاق المبلغ </button>
                                                                <button type="button" class="btn btn-primary" onclick="$('#new_msg').val($('#new_msg').val() +'[[project]]') ;return false;" value="">ارفاق اسم المشروع </button>
                                                                <small class="red ">سيتم استبدال المتغير الخاص بالقيمة </small>
                                                            </div>
                                                            <div class="form-group col-md-12">
                                                                <label class="control-label">المحتوي : </label>
                                                                <div class="row">
                                                                    <textarea id="new_msg" name="value[newOrder_msg]" rows="6" class="form-control"><?php echo (@$data['value']->newOrder_msg); ?></textarea>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="sms">
                                                            <h3> رساله ال SMS</h3>
                                                            <div class="form-group">
                                                                <label class="control-label">تفعيل الارسال :</label>
                                                                <div class="radio">
                                                                    <label>
                                                                        <input type="radio" class="flat" <?php echo (@$data['value']->newOrder_sms == 1) ? 'checked' : ''; ?> value="1" name="value[newOrder_sms]"> مفعلة
                                                                    </label>
                                                                    <label>
                                                                        <input type="radio" class="flat" <?php echo (@$data['value']->newOrder_sms == '0') ? 'checked' : ''; ?> value="0" name="value[newOrder_sms]"> معلقة
                                                                    </label>
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <br>
                                                                <button type="button" class="btn btn-primary" onclick="$('#new_sms_msg').val($('#new_sms_msg').val() +'[[name]]') ;return false;" value="">ارفاق الاسم </button>
                                                                <button type="button" class="btn btn-primary" onclick="$('#new_sms_msg').val($('#new_sms_msg').val() +'[[identifier]]') ;return false;" value="">ارفاق رقم الطلب </button>
                                                                <button type="button" class="btn btn-primary" onclick="$('#new_sms_msg').val($('#new_sms_msg').val() +'[[total]]') ;return false;" value="">ارفاق المبلغ </button>
                                                                <button type="button" class="btn btn-primary" onclick="$('#new_sms_msg').val($('#new_sms_msg').val() +'[[project]]') ;return false;" value="">ارفاق اسم المشروع </button>
                                                                <small class="red ">سيتم استبدال المتغير الخاص بالقيمة </small>
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="control-label">المحتوي : </label>
                                                                <div class="row">
                                                                    <textarea id="new_sms_msg" name="value[newOrder_sms_msg]" rows="6" class="form-control"><?php echo (@$data['value']->newOrder_sms_msg); ?></textarea>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <br>

                                                <!-- start Order ------------------------------------------------------------------------------- -->
                                                <div class="new-order-container">
                                                    <div class="card-header" data-toggle="collapse" data-target="#collapseStarteOrder" aria-expanded="true" aria-controls="collapseStarteOrder">
                                                        <span> رسالة بداء طلب ( ترسل للمتبرع ) </span>
                                                    </div>
                                                    <div id="collapseStarteOrder" class="collapse card-body" aria-labelledby="headingOne">
                                                        <div class="email-container">
                                                            <h3> البريد الاكتروني</h3>
                                                            <div class="form-group">
                                                                <label class="control-label">تفعيل الارسال :</label>
                                                                <div class="radio">
                                                                    <label>
                                                                        <input type="radio" class="flat" <?php echo (@$data['value']->start_order_enabled == 1) ? 'checked' : ''; ?> value="1" name="value[start_order_enabled]"> مفعلة
                                                                    </label>
                                                                    <label>
                                                                        <input type="radio" class="flat" <?php echo (@$data['value']->start_order_enabled == '0') ? 'checked' : ''; ?> value="0" name="value[start_order_enabled]"> معلقة
                                                                    </label>
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="control-label" for="confirm_subject">عنوان الرسالة : </label>
                                                                <div class="has-feedback">
                                                                    <input type="text" id="confirm_subject" class="form-control" name="value[start_order_subject]" placeholder="عنوان الرسالة" value="<?php echo @$data['value']->start_order_subject; ?>">
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <br>
                                                                <button type="button" class="btn btn-primary" onclick="$('#start_order_msg').val($('#start_order_msg').val() +'[[name]]') ;return false;" value="">ارفاق الاسم </button>
                                                                <button type="button" class="btn btn-primary" onclick="$('#start_order_msg').val($('#start_order_msg').val() +'[[identifier]]') ;return false;" value="">ارفاق رقم الطلب </button>
                                                                <button type="button" class="btn btn-primary" onclick="$('#start_order_msg').val($('#start_order_msg').val() +'[[total]]') ;return false;" value="">ارفاق المبلغ </button>
                                                                <button type="button" class="btn btn-primary" onclick="$('#start_order_msg').val($('#start_order_msg').val() +'[[project]]') ;return false;" value="">ارفاق اسم المشروع </button>
                                                                <small class="red ">سيتم استبدال المتغير الخاص بالقيمة </small>
                                                            </div>
                                                            <div class="form-group col-md-12">
                                                                <label class="control-label">المحتوي : </label>
                                                                <div class="row">
                                                                    <textarea id="start_order_msg" name="value[start_order_msg]" rows="6" class="form-control"><?php echo (@$data['value']->start_order_msg); ?></textarea>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="sms">
                                                            <h3> رساله ال SMS</h3>
                                                            <div class="form-group">
                                                                <label class="control-label">تفعيل الارسال :</label>
                                                                <div class="radio">
                                                                    <label>
                                                                        <input type="radio" class="flat" <?php echo (@$data['value']->start_order_sms == 1) ? 'checked' : ''; ?> value="1" name="value[start_order_sms]"> مفعلة
                                                                    </label>
                                                                    <label>
                                                                        <input type="radio" class="flat" <?php echo (@$data['value']->start_order_sms == '0') ? 'checked' : ''; ?> value="0" name="value[start_order_sms]"> معلقة
                                                                    </label>
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <br>
                                                                <button type="button" class="btn btn-primary" onclick="$('#start_order_sms_msg').val($('start_order_sms_msg').val() +'[[identifier]]') ;return false;" value="">ارفاق رقم الطلب </button>
                                                                <button type="button" class="btn btn-primary" onclick="$('#start_order_sms_msg').val($('start_order_sms_msg').val() +'[[total]]') ;return false;" value="">ارفاق المبلغ </button>
                                                                <button type="button" class="btn btn-primary" onclick="$('#start_order_sms_msg').val($('start_order_sms_msg').val() +'[[project]]') ;return false;" value="">ارفاق اسم المشروع </button>
                                                                <button type="button" class="btn btn-primary" onclick="$('#start_order_sms_msg').val($('start_order_sms_msg').val() +'[[name]]') ;return false;" value="">ارفاق الاسم </button>
                                                                <small class="red ">سيتم استبدال المتغير الخاص بالقيمة </small>
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="control-label">المحتوي : </label>
                                                                <div class="row">
                                                                    <textarea id="start_order_sms_msg" name="value[start_order_sms_msg]" rows="6" class="form-control"><?php echo (@$data['value']->start_order_sms_msg); ?></textarea>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <br>

                                                <!-- completed Order ------------------------------------------------------------------------------- -->
                                                <div class="new-order-container">
                                                    <div class="card-header" data-toggle="collapse" data-target="#collapseCompleteOrder" aria-expanded="true" aria-controls="collapseCompleteOrder">
                                                        <span> رسالة اكتمال الطلب ( ترسل للمتبرع ) </span>
                                                    </div>
                                                    <div id="collapseCompleteOrder" class="collapse card-body" aria-labelledby="headingOne">
                                                        <div class="email-container">
                                                            <h3> البريد الاكتروني</h3>
                                                            <div class="form-group">
                                                                <label class="control-label">تفعيل الارسال :</label>
                                                                <div class="radio">
                                                                    <label>
                                                                        <input type="radio" class="flat" <?php echo (@$data['value']->complete_order_enabled == 1) ? 'checked' : ''; ?> value="1" name="value[complete_order_enabled]"> مفعلة
                                                                    </label>
                                                                    <label>
                                                                        <input type="radio" class="flat" <?php echo (@$data['value']->complete_order_enabled == '0') ? 'checked' : ''; ?> value="0" name="value[complete_order_enabled]"> معلقة
                                                                    </label>
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="control-label" for="confirm_subject">عنوان الرسالة : </label>
                                                                <div class="has-feedback">
                                                                    <input type="text" id="confirm_subject" class="form-control" name="value[complete_order_subject]" placeholder="عنوان الرسالة" value="<?php echo @$data['value']->complete_order_subject; ?>">
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <br>
                                                                <button type="button" class="btn btn-primary" onclick="$('#complete_order_msg').val($('#complete_order_msg').val() +'[[name]]') ;return false;" value="">ارفاق الاسم </button>
                                                                <button type="button" class="btn btn-primary" onclick="$('#complete_order_msg').val($('#complete_order_msg').val() +'[[identifier]]') ;return false;" value="">ارفاق رقم الطلب </button>
                                                                <button type="button" class="btn btn-primary" onclick="$('#complete_order_msg').val($('#complete_order_msg').val() +'[[total]]') ;return false;" value="">ارفاق المبلغ </button>
                                                                <button type="button" class="btn btn-primary" onclick="$('#complete_order_msg').val($('#complete_order_msg').val() +'[[project]]') ;return false;" value="">ارفاق اسم المشروع </button>
                                                                <small class="red ">سيتم استبدال المتغير الخاص بالقيمة </small>
                                                            </div>
                                                            <div class="form-group col-md-12">
                                                                <label class="control-label">المحتوي : </label>
                                                                <div class="row">
                                                                    <textarea id="complete_order_msg" name="value[complete_order_msg]" rows="6" class="form-control"><?php echo (@$data['value']->complete_order_msg); ?></textarea>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="sms">
                                                            <h3> رساله ال SMS</h3>
                                                            <div class="form-group">
                                                                <label class="control-label">تفعيل الارسال :</label>
                                                                <div class="radio">
                                                                    <label>
                                                                        <input type="radio" class="flat" <?php echo (@$data['value']->complete_order_sms == 1) ? 'checked' : ''; ?> value="1" name="value[complete_order_sms]"> مفعلة
                                                                    </label>
                                                                    <label>
                                                                        <input type="radio" class="flat" <?php echo (@$data['value']->complete_order_sms == '0') ? 'checked' : ''; ?> value="0" name="value[complete_order_sms]"> معلقة
                                                                    </label>
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <br>
                                                                <button type="button" class="btn btn-primary" onclick="$('#complete_order_sms_msg').val($('complete_order_sms_msg').val() +'[[identifier]]') ;return false;" value="">ارفاق رقم الطلب </button>
                                                                <button type="button" class="btn btn-primary" onclick="$('#complete_order_sms_msg').val($('complete_order_sms_msg').val() +'[[total]]') ;return false;" value="">ارفاق المبلغ </button>
                                                                <button type="button" class="btn btn-primary" onclick="$('#complete_order_sms_msg').val($('complete_order_sms_msg').val() +'[[project]]') ;return false;" value="">ارفاق اسم المشروع </button>
                                                                <button type="button" class="btn btn-primary" onclick="$('#complete_order_sms_msg').val($('complete_order_sms_msg').val() +'[[name]]') ;return false;" value="">ارفاق الاسم </button>
                                                                <small class="red ">سيتم استبدال المتغير الخاص بالقيمة </small>
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="control-label">المحتوي : </label>
                                                                <div class="row">
                                                                    <textarea id="complete_order_sms_msg" name="value[complete_order_sms_msg]" rows="6" class="form-control"><?php echo (@$data['value']->complete_order_sms_msg); ?></textarea>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <br>


                                                <!-- message to notify order today  ------------------------------------------------------------------------------- -->
                                                <div class="new-order-container">
                                                    <div class="card-header" data-toggle="collapse" data-target="#collapseNotifyOrder" aria-expanded="true" aria-controls="collapseNotifyOrder">
                                                        <span> رسالة لتنبيه الطلب ( ترسل للمتطوع ) </span>
                                                    </div>
                                                    <div id="collapseNotifyOrder" class="collapse card-body" aria-labelledby="headingOne">
                                                        <div class="email-container">
                                                            <h3> البريد الاكتروني</h3>
                                                            <div class="form-group">
                                                                <label class="control-label">تفعيل الارسال :</label>
                                                                <div class="radio">
                                                                    <label>
                                                                        <input type="radio" class="flat" <?php echo (@$data['value']->notify_order_enabled == 1) ? 'checked' : ''; ?> value="1" name="value[notify_order_enabled]"> مفعلة
                                                                    </label>
                                                                    <label>
                                                                        <input type="radio" class="flat" <?php echo (@$data['value']->notify_order_enabled == '0') ? 'checked' : ''; ?> value="0" name="value[notify_order_enabled]"> معلقة
                                                                    </label>
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="control-label" for="confirm_subject">عنوان الرسالة : </label>
                                                                <div class="has-feedback">
                                                                    <input type="text" id="confirm_subject" class="form-control" name="value[notify_order_subject]" placeholder="عنوان الرسالة" value="<?php echo @$data['value']->notify_order_subject; ?>">
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <br>
                                                                <button type="button" class="btn btn-primary" onclick="$('#notify_order_msg').val($('#notify_order_msg').val() +'[[name]]') ;return false;" value="">ارفاق الاسم </button>
                                                                <button type="button" class="btn btn-primary" onclick="$('#notify_order_msg').val($('#notify_order_msg').val() +'[[identifier]]') ;return false;" value="">ارفاق رقم الطلب </button>
                                                                <button type="button" class="btn btn-primary" onclick="$('#notify_order_msg').val($('#notify_order_msg').val() +'[[total]]') ;return false;" value="">ارفاق المبلغ </button>
                                                                <button type="button" class="btn btn-primary" onclick="$('#notify_order_msg').val($('#notify_order_msg').val() +'[[project]]') ;return false;" value="">ارفاق اسم المشروع </button>
                                                                <button type="button" class="btn btn-primary" onclick="$('#notify_order_msg').val($('#notify_order_msg').val() +'[[substitute_start]]') ;return false;" value="">ارفاق موعد بداء للمتطوع </button>
                                                                <small class="red ">سيتم استبدال المتغير الخاص بالقيمة </small>
                                                            </div>
                                                            <div class="form-group col-md-12">
                                                                <label class="control-label">المحتوي : </label>
                                                                <div class="row">
                                                                    <textarea id="notify_order_msg" name="value[notify_order_msg]" rows="6" class="form-control"><?php echo (@$data['value']->notify_order_msg); ?></textarea>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="sms">
                                                            <h3> رساله ال SMS</h3>
                                                            <div class="form-group">
                                                                <label class="control-label">تفعيل الارسال :</label>
                                                                <div class="radio">
                                                                    <label>
                                                                        <input type="radio" class="flat" <?php echo (@$data['value']->notify_order_sms == 1) ? 'checked' : ''; ?> value="1" name="value[notify_order_sms]"> مفعلة
                                                                    </label>
                                                                    <label>
                                                                        <input type="radio" class="flat" <?php echo (@$data['value']->notify_order_sms == '0') ? 'checked' : ''; ?> value="0" name="value[notify_order_sms]"> معلقة
                                                                    </label>
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <br>
                                                                <button type="button" class="btn btn-primary" onclick="$('#notify_order_sms_msg').val($('notify_order_sms_msg').val() +'[[identifier]]') ;return false;" value="">ارفاق رقم الطلب </button>
                                                                <button type="button" class="btn btn-primary" onclick="$('#notify_order_sms_msg').val($('notify_order_sms_msg').val() +'[[total]]') ;return false;" value="">ارفاق المبلغ </button>
                                                                <button type="button" class="btn btn-primary" onclick="$('#notify_order_sms_msg').val($('notify_order_sms_msg').val() +'[[project]]') ;return false;" value="">ارفاق اسم المشروع </button>
                                                                <button type="button" class="btn btn-primary" onclick="$('#notify_order_sms_msg').val($('notify_order_sms_msg').val() +'[[name]]') ;return false;" value="">ارفاق الاسم </button>
                                                                <button type="button" class="btn btn-primary" onclick="$('#notify_order_sms_msg').val($('#notify_order_sms_msg').val() +'[[substitute_start]]') ;return false;" value="">ارفاق موعد بداء للمتطوع </button>
                                                                <small class="red ">سيتم استبدال المتغير الخاص بالقيمة </small>
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="control-label">المحتوي : </label>
                                                                <div class="row">
                                                                    <textarea id="notify_order_sms_msg" name="value[notify_order_sms_msg]" rows="6" class="form-control"><?php echo (@$data['value']->notify_order_sms_msg); ?></textarea>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <br>

                                            <!-- Request ------------------------------------------------------------------------------- -->
                                            <div class="x_panel tile ">
                                                <!-- New Request ------------------------------------------------------------------------------- -->
                                                <div class="new-request-container">
                                                    <div class="card-header" data-toggle="collapse" data-target="#collapseNewRequest" aria-expanded="true" aria-controls="collapseNewRequest">
                                                        <span> رساله المتقدمين لتنفيذ طلب البدل (ترسل للمتبرع) </span>
                                                    </div>
                                                    <div id="collapseNewRequest" class="collapse card-body" aria-labelledby="headingOne">
                                                        <div class="email-container">
                                                            <h3> البريد الاكتروني</h3>
                                                            <div class="form-group">
                                                                <label class="control-label">تفعيل الارسال :</label>
                                                                <div class="radio">
                                                                    <label>
                                                                        <input type="radio" class="flat" <?php echo (@$data['value']->newRequest_enabled == 1) ? 'checked' : ''; ?> value="1" name="value[newRequest_enabled]"> مفعلة
                                                                    </label>
                                                                    <label>
                                                                        <input type="radio" class="flat" <?php echo (@$data['value']->newRequest_enabled == '0') ? 'checked' : ''; ?> value="0" name="value[newRequest_enabled]"> معلقة
                                                                    </label>
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="control-label" for="inform_subject">عنوان الرسالة : </label>
                                                                <div class="has-feedback">
                                                                    <input type="text" id="inform_subject" class="form-control" name="value[newRequest_subject]" placeholder="عنوان الرسالة" value="<?php echo @$data['value']->newRequest_subject; ?>">
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <br>
                                                                <button type="button" class="btn btn-primary" onclick="$('#inform_msg').val($('#inform_msg').val() +'[[name]]') ;return false;" value="">ارفاق الاسم المتبرع </button>
                                                                <button type="button" class="btn btn-primary" onclick="$('#inform_msg').val($('#inform_msg').val() +'[[identifier]]') ;return false;" value="">ارفاق رقم الطلب </button>
                                                                <button type="button" class="btn btn-primary" onclick="$('#inform_msg').val($('#inform_msg').val() +'[[total]]') ;return false;" value="">ارفاق المبلغ </button>
                                                                <button type="button" class="btn btn-primary" onclick="$('#inform_msg').val($('#inform_msg').val() +'[[project]]') ;return false;" value="">ارفاق اسم المشروع </button>
                                                                <button type="button" class="btn btn-primary" onclick="$('#inform_msg').val($('#inform_msg').val() +'[[substuites_name]]') ;return false;" value="">ارفاق الاسم المتطوع </button>
                                                                <button type="button" class="btn btn-primary" onclick="$('#inform_msg').val($('#inform_msg').val() +'[[substuites_start]]') ;return false;" value="">ارفاق موعد بداء للمتطوع </button>
                                                                <small class="red ">سيتم استبدال المتغير الخاص بالقيمة </small>
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="control-label">المحتوي : </label>
                                                                <div class="row">
                                                                    <textarea id="inform_msg" name="value[newRequest_msg]" rows="6" class="form-control"><?php echo (@$data['value']->newRequest_msg); ?></textarea>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="sms">
                                                            <h3> رساله ال SMS</h3>
                                                            <div class="form-group">
                                                                <label class="control-label">تفعيل الارسال :</label>
                                                                <div class="radio">
                                                                    <label>
                                                                        <input type="radio" class="flat" <?php echo (@$data['value']->newRequest_sms == 1) ? 'checked' : ''; ?> value="1" name="value[newRequest_sms]"> مفعلة
                                                                    </label>
                                                                    <label>
                                                                        <input type="radio" class="flat" <?php echo (@$data['value']->newRequest_sms == '0') ? 'checked' : ''; ?> value="0" name="value[newRequest_sms]"> معلقة
                                                                    </label>
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <br>
                                                                <button type="button" class="btn btn-primary" onclick="$('#newRequest_sms_msg').val($('#newRequest_sms_msg').val() +'[[name]]') ;return false;" value="">ارفاق الاسم </button>
                                                                <button type="button" class="btn btn-primary" onclick="$('#newRequest_sms_msg').val($('#newRequest_sms_msg').val() +'[[identifier]]') ;return false;" value="">ارفاق رقم الطلب </button>
                                                                <button type="button" class="btn btn-primary" onclick="$('#newRequest_sms_msg').val($('#newRequest_sms_msg').val() +'[[total]]') ;return false;" value="">ارفاق المبلغ </button>
                                                                <button type="button" class="btn btn-primary" onclick="$('#newRequest_sms_msg').val($('#newRequest_sms_msg').val() +'[[project]]') ;return false;" value="">ارفاق اسم المشروع </button>
                                                                <button type="button" class="btn btn-primary" onclick="$('#newRequest_sms_msg').val($('#newRequest_sms_msg').val() +'[[substitute_name]]') ;return false;" value="">ارفاق الاسم المتطوع </button>
                                                                <button type="button" class="btn btn-primary" onclick="$('#newRequest_sms_msg').val($('#newRequest_sms_msg').val() +'[[substitute_start]]') ;return false;" value="">ارفاق موعد بداء للمتطوع </button>
                                                                <small class="red ">سيتم استبدال المتغير الخاص بالقيمة </small>
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="control-label">المحتوي : </label>
                                                                <div class="row">
                                                                    <textarea id="newRequest_sms_msg" name="value[newRequest_sms_msg]" rows="6" class="form-control"><?php echo (@$data['value']->newRequest_sms_msg); ?></textarea>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <br>
                                                <!-- Select Request ------------------------------------------------------------------------------- -->
                                                <div class="select-request">
                                                    <div class="card-header" data-toggle="collapse" data-target="#collapseSelectRequest" aria-expanded="true" aria-controls="collapseSelectRequest">
                                                        <span> رساله الاختيار المتقدم لتنفيذ الطلب (ترسل للمتقدم) </span>
                                                    </div>
                                                    <div id="collapseSelectRequest" class="collapse card-body" aria-labelledby="headingOne">
                                                        <div class="email-container">
                                                            <h3> البريد الاكتروني</h3>
                                                            <div class="form-group">
                                                                <label class="control-label">تفعيل الارسال :</label>
                                                                <div class="radio">
                                                                    <label>
                                                                        <input type="radio" class="flat" <?php echo (@$data['value']->selectRequest_enabled == 1) ? 'checked' : ''; ?> value="1" name="value[selectRequest_enabled]"> مفعلة
                                                                    </label>
                                                                    <label>
                                                                        <input type="radio" class="flat" <?php echo (@$data['value']->selectRequest_enabled == '0') ? 'checked' : ''; ?> value="0" name="value[selectRequest_enabled]"> معلقة
                                                                    </label>
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="control-label" for="inform_subject">عنوان الرسالة : </label>
                                                                <div class="has-feedback">
                                                                    <input type="text" id="inform_subject" class="form-control" name="value[selectRequest_subject]" placeholder="عنوان الرسالة" value="<?php echo @$data['value']->selectRequest_subject; ?>">
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <br>
                                                                <button type="button" class="btn btn-primary" onclick="$('#SelectRequest_msg').val($('#SelectRequest_msg').val() +'[[name]]') ;return false;" value="">ارفاق الاسم </button>
                                                                <button type="button" class="btn btn-primary" onclick="$('#SelectRequest_msg').val($('#SelectRequest_msg').val() +'[[identifier]]') ;return false;" value="">ارفاق رقم الطلب </button>
                                                                <button type="button" class="btn btn-primary" onclick="$('#SelectRequest_msg').val($('#SelectRequest_msg').val() +'[[total]]') ;return false;" value="">ارفاق المبلغ </button>
                                                                <button type="button" class="btn btn-primary" onclick="$('#SelectRequest_msg').val($('#SelectRequest_msg').val() +'[[project]]') ;return false;" value="">ارفاق اسم المشروع </button>
                                                                <small class="red ">سيتم استبدال المتغير الخاص بالقيمة </small>
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="control-label">المحتوي : </label>
                                                                <div class="row">
                                                                    <textarea id="SelectRequest_msg" name="value[selectRequest_msg]" rows="6" class="form-control"><?php echo (@$data['value']->selectRequest_msg); ?></textarea>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="sms">
                                                            <h3> رساله ال SMS</h3>
                                                            <div class="form-group">
                                                                <label class="control-label">تفعيل الارسال :</label>
                                                                <div class="radio">
                                                                    <label>
                                                                        <input type="radio" class="flat" <?php echo (@$data['value']->selectRequest_sms == 1) ? 'checked' : ''; ?> value="1" name="value[selectRequest_sms]"> مفعلة
                                                                    </label>
                                                                    <label>
                                                                        <input type="radio" class="flat" <?php echo (@$data['value']->selectRequest_sms == '0') ? 'checked' : ''; ?> value="0" name="value[selectRequest_sms]"> معلقة
                                                                    </label>
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <br>
                                                                <button type="button" class="btn btn-primary" onclick="$('#SelectRequest_sms_msg').val($('#SelectRequest_sms_msg').val() +'[[name]]') ;return false;" value="">ارفاق الاسم </button>
                                                                <button type="button" class="btn btn-primary" onclick="$('#SelectRequest_sms_msg').val($('#SelectRequest_sms_msg').val() +'[[identifier]]') ;return false;" value="">ارفاق رقم الطلب </button>
                                                                <button type="button" class="btn btn-primary" onclick="$('#SelectRequest_sms_msg').val($('#SelectRequest_sms_msg').val() +'[[total]]') ;return false;" value="">ارفاق المبلغ </button>
                                                                <button type="button" class="btn btn-primary" onclick="$('#SelectRequest_sms_msg').val($('#SelectRequest_sms_msg').val() +'[[project]]') ;return false;" value="">ارفاق اسم المشروع </button>
                                                                <small class="red ">سيتم استبدال المتغير الخاص بالقيمة </small>
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="control-label">المحتوي : </label>
                                                                <div class="row">
                                                                    <textarea id="SelectRequest_sms_msg" name="value[selectRequest_sms_msg]" rows="6" class="form-control"><?php echo (@$data['value']->selectRequest_sms_msg); ?></textarea>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <br>

                                                <!-- cancel Request ------------------------------------------------------------------------------- -->
                                                <div class="select-request">
                                                    <div class="card-header" data-toggle="collapse" data-target="#collapseCancelRequest" aria-expanded="true" aria-controls="collapseCancelRequest">
                                                        <span> رساله لالغاء باقي المتقدمين (ترسل للمتقدمين) </span>
                                                    </div>
                                                    <div id="collapseCancelRequest" class="collapse card-body" aria-labelledby="headingOne">
                                                        <div class="email-container">
                                                            <h3> البريد الاكتروني</h3>
                                                            <div class="form-group">
                                                                <label class="control-label">تفعيل الارسال :</label>
                                                                <div class="radio">
                                                                    <label>
                                                                        <input type="radio" class="flat" <?php echo (@$data['value']->cancelRequest_enabled == 1) ? 'checked' : ''; ?> value="1" name="value[cancelRequest_enabled]"> مفعلة
                                                                    </label>
                                                                    <label>
                                                                        <input type="radio" class="flat" <?php echo (@$data['value']->cancelRequest_enabled == '0') ? 'checked' : ''; ?> value="0" name="value[cancelRequest_enabled]"> معلقة
                                                                    </label>
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="control-label" for="inform_subject">عنوان الرسالة : </label>
                                                                <div class="has-feedback">
                                                                    <input type="text" id="inform_subject" class="form-control" name="value[cancelRequest_subject]" placeholder="عنوان الرسالة" value="<?php echo @$data['value']->cancelRequest_subject; ?>">
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <br>
                                                                <button type="button" class="btn btn-primary" onclick="$('#CancelRequest_msg').val($('#CancelRequest_msg').val() +'[[name]]') ;return false;" value="">ارفاق الاسم </button>
                                                                <button type="button" class="btn btn-primary" onclick="$('#CancelRequest_msg').val($('#CancelRequest_msg').val() +'[[identifier]]') ;return false;" value="">ارفاق رقم الطلب </button>
                                                                <button type="button" class="btn btn-primary" onclick="$('#CancelRequest_msg').val($('#CancelRequest_msg').val() +'[[total]]') ;return false;" value="">ارفاق المبلغ </button>
                                                                <button type="button" class="btn btn-primary" onclick="$('#CancelRequest_msg').val($('#CancelRequest_msg').val() +'[[project]]') ;return false;" value="">ارفاق اسم المشروع </button>
                                                                <small class="red ">سيتم استبدال المتغير الخاص بالقيمة </small>
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="control-label">المحتوي : </label>
                                                                <div class="row">
                                                                    <textarea id="CancelRequest_msg" name="value[cancelRequest_msg]" rows="6" class="form-control"><?php echo (@$data['value']->cancelRequest_msg); ?></textarea>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="sms">
                                                            <h3> رساله ال SMS</h3>
                                                            <div class="form-group">
                                                                <label class="control-label">تفعيل الارسال :</label>
                                                                <div class="radio">
                                                                    <label>
                                                                        <input type="radio" class="flat" <?php echo (@$data['value']->cancelRequest_sms == 1) ? 'checked' : ''; ?> value="1" name="value[cancelRequest_sms]"> مفعلة
                                                                    </label>
                                                                    <label>
                                                                        <input type="radio" class="flat" <?php echo (@$data['value']->cancelRequest_sms == '0') ? 'checked' : ''; ?> value="0" name="value[cancelRequest_sms]"> معلقة
                                                                    </label>
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <br>
                                                                <button type="button" class="btn btn-primary" onclick="$('#CancelRequest_sms_msg').val($('#CancelRequest_sms_msg').val() +'[[name]]') ;return false;" value="">ارفاق الاسم </button>
                                                                <button type="button" class="btn btn-primary" onclick="$('#CancelRequest_sms_msg').val($('#CancelRequest_sms_msg').val() +'[[identifier]]') ;return false;" value="">ارفاق رقم الطلب </button>
                                                                <button type="button" class="btn btn-primary" onclick="$('#CancelRequest_sms_msg').val($('#CancelRequest_sms_msg').val() +'[[total]]') ;return false;" value="">ارفاق المبلغ </button>
                                                                <button type="button" class="btn btn-primary" onclick="$('#CancelRequest_sms_msg').val($('#CancelRequest_sms_msg').val() +'[[project]]') ;return false;" value="">ارفاق اسم المشروع </button>
                                                                <small class="red ">سيتم استبدال المتغير الخاص بالقيمة </small>
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="control-label">المحتوي : </label>
                                                                <div class="row">
                                                                    <textarea id="CancelRequest_sms_msg" name="value[cancelRequest_sms_msg]" rows="6" class="form-control"><?php echo (@$data['value']->cancelRequest_sms_msg); ?></textarea>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <br>

                                                <div class="select-request">
                                                    <div class="card-header" data-toggle="collapse" data-target="#collapseLateRequest" aria-expanded="true" aria-controls="collapseLateRequest">
                                                        <span> رساله لالغاء طلب المتقدم لتاخره في بداء المناسك ( ترسل للمتقدم ) </span>
                                                    </div>
                                                    <div id="collapseLateRequest" class="collapse card-body" aria-labelledby="headingOne">
                                                        <div class="email-container">
                                                            <h3> البريد الاكتروني</h3>
                                                            <div class="form-group">
                                                                <label class="control-label">تفعيل الارسال :</label>
                                                                <div class="radio">
                                                                    <label>
                                                                        <input type="radio" class="flat" <?php echo (@$data['value']->lateRequest_enabled == 1) ? 'checked' : ''; ?> value="1" name="value[lateRequest_enabled]"> مفعلة
                                                                    </label>
                                                                    <label>
                                                                        <input type="radio" class="flat" <?php echo (@$data['value']->lateRequest_enabled == '0') ? 'checked' : ''; ?> value="0" name="value[lateRequest_enabled]"> معلقة
                                                                    </label>
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="control-label" for="inform_subject">عنوان الرسالة : </label>
                                                                <div class="has-feedback">
                                                                    <input type="text" id="inform_subject" class="form-control" name="value[lateRequest_subject]" placeholder="عنوان الرسالة" value="<?php echo @$data['value']->lateRequest_subject; ?>">
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <br>
                                                                <button type="button" class="btn btn-primary" onclick="$('#lateRequest_msg').val($('#lateRequest_msg').val() +'[[name]]') ;return false;" value="">ارفاق الاسم </button>
                                                                <button type="button" class="btn btn-primary" onclick="$('#lateRequest_msg').val($('#lateRequest_msg').val() +'[[identifier]]') ;return false;" value="">ارفاق رقم الطلب </button>
                                                                <button type="button" class="btn btn-primary" onclick="$('#lateRequest_msg').val($('#lateRequest_msg').val() +'[[total]]') ;return false;" value="">ارفاق المبلغ </button>
                                                                <button type="button" class="btn btn-primary" onclick="$('#lateRequest_msg').val($('#lateRequest_msg').val() +'[[project]]') ;return false;" value="">ارفاق اسم المشروع </button>
                                                                <small class="red ">سيتم استبدال المتغير الخاص بالقيمة </small>
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="control-label">المحتوي : </label>
                                                                <div class="row">
                                                                    <textarea id="lateRequest_msg" name="value[lateRequest_msg]" rows="6" class="form-control"><?php echo (@$data['value']->lateRequest_msg); ?></textarea>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="sms">
                                                            <h3> رساله ال SMS</h3>
                                                            <div class="form-group">
                                                                <label class="control-label">تفعيل الارسال :</label>
                                                                <div class="radio">
                                                                    <label>
                                                                        <input type="radio" class="flat" <?php echo (@$data['value']->lateRequest_sms == 1) ? 'checked' : ''; ?> value="1" name="value[lateRequest_sms]"> مفعلة
                                                                    </label>
                                                                    <label>
                                                                        <input type="radio" class="flat" <?php echo (@$data['value']->lateRequest_sms == '0') ? 'checked' : ''; ?> value="0" name="value[lateRequest_sms]"> معلقة
                                                                    </label>
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <br>
                                                                <button type="button" class="btn btn-primary" onclick="$('#lateRequest_sms_msg').val($('#lateRequest_sms_msg').val() +'[[name]]') ;return false;" value="">ارفاق الاسم </button>
                                                                <button type="button" class="btn btn-primary" onclick="$('#lateRequest_sms_msg').val($('#lateRequest_sms_msg').val() +'[[identifier]]') ;return false;" value="">ارفاق رقم الطلب </button>
                                                                <button type="button" class="btn btn-primary" onclick="$('#lateRequest_sms_msg').val($('#lateRequest_sms_msg').val() +'[[total]]') ;return false;" value="">ارفاق المبلغ </button>
                                                                <button type="button" class="btn btn-primary" onclick="$('#lateRequest_sms_msg').val($('#lateRequest_sms_msg').val() +'[[project]]') ;return false;" value="">ارفاق اسم المشروع </button>
                                                                <small class="red ">سيتم استبدال المتغير الخاص بالقيمة </small>
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="control-label">المحتوي : </label>
                                                                <div class="row">
                                                                    <textarea id="lateRequest_sms_msg" name="value[lateRequest_sms_msg]" rows="6" class="form-control"><?php echo (@$data['value']->lateRequest_sms_msg); ?></textarea>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <br>

                                            </div>

                                            <!-- Offer ------------------------------------------------------------------------------- -->
                                            <!-- <div class="x_panel tile "> -->
                                            <!-- <div class="select-request">
                                    <div class="card-header" data-toggle="collapse" data-target="#collapseNewOffer" aria-expanded="true" aria-controls="collapseNewOffer">
                                        <span>رساله لعرض جديد ( ترسل للمتبرعين ) </span>
                                    </div>
                                    <div id="collapseNewOffer" class="collapse card-body" aria-labelledby="headingOne">
                                        <div class="email-container">
                                            <h3> البريد الاكتروني</h3>
                                            <div class="form-group">
                                                <label class="control-label">تفعيل الارسال :</label>
                                                <div class="radio">
                                                    <label>
                                                        <input type="radio" class="flat" <?php echo (@$data['value']->newOffer_enabled == 1) ? 'checked' : ''; ?> value="1" name="value[newOffer_enabled]"> مفعلة
                                                    </label>
                                                    <label>
                                                        <input type="radio" class="flat" <?php echo (@$data['value']->newOffer_enabled == '0') ? 'checked' : ''; ?> value="0" name="value[newOffer_enabled]"> معلقة
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label" for="inform_subject">عنوان الرسالة : </label>
                                                <div class="has-feedback">
                                                    <input type="text" id="inform_subject" class="form-control" name="value[newOffer_subject]" placeholder="عنوان الرسالة" value="<?php echo @$data['value']->newOffer_subject; ?>">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <br>
                                                <button type="button" class="btn btn-primary" onclick="$('#newOffer_msg').val($('#newOffer_msg').val() +'[[name]]') ;return false;" value="">ارفاق اسم للمتبرع  </button>
                                                <button type="button" class="btn btn-primary" onclick="$('#newOffer_msg').val($('#newOffer_msg').val() +'[[total]]') ;return false;" value="">ارفاق المبلغ </button>
                                                <button type="button" class="btn btn-primary" onclick="$('#newOffer_msg').val($('#newOffer_msg').val() +'[[project]]') ;return false;" value="">ارفاق اسم المشروع </button>
                                                <button type="button" class="btn btn-primary" onclick="$('#newOffer_msg').val($('#newOffer_msg').val() +'[[substuites_name]]') ;return false;" value="">ارفاق اسم للمتطوع  </button>
                                                <button type="button" class="btn btn-primary" onclick="$('#newOffer_msg').val($('#newOffer_msg').val() +'[[substuites_start]]') ;return false;" value="">ارفاق موعد البداء  </button>
                                                <small class="red ">سيتم استبدال المتغير الخاص بالقيمة </small>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label">المحتوي : </label>
                                                <div class="row">
                                                    <textarea id="newOffer_msg" name="value[newOffer_msg]" rows="6" class="form-control"><?php echo (@$data['value']->newOffer_msg); ?></textarea>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="sms">
                                            <h3> رساله ال SMS</h3>
                                            <div class="form-group">
                                                <label class="control-label">تفعيل الارسال :</label>
                                                <div class="radio">
                                                    <label>
                                                        <input type="radio" class="flat" <?php echo (@$data['value']->newOffer_sms == 1) ? 'checked' : ''; ?> value="1" name="value[newOffer_sms]"> مفعلة
                                                    </label>
                                                    <label>
                                                        <input type="radio" class="flat" <?php echo (@$data['value']->newOffer_sms == '0') ? 'checked' : ''; ?> value="0" name="value[newOffer_sms]"> معلقة
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <br>
                                                <button type="button" class="btn btn-primary" onclick="$('newOffer_sms_msg').val($('#newOffer_sms_msg').val() +'[[name]]') ;return false;" value="">ارفاق اسم للمتبرع  </button>
                                                <button type="button" class="btn btn-primary" onclick="$('newOffer_sms_msg').val($('#newOffer_sms_msg').val() +'[[total]]') ;return false;" value="">ارفاق المبلغ </button>
                                                <button type="button" class="btn btn-primary" onclick="$('newOffer_sms_msg').val($('#newOffer_sms_msg').val() +'[[project]]') ;return false;" value="">ارفاق اسم المشروع </button>
                                                <button type="button" class="btn btn-primary" onclick="$('newOffer_sms_msg').val($('#newOffer_sms_msg').val() +'[[substuites_name]]') ;return false;" value="">ارفاق اسم للمتطوع  </button>
                                                <button type="button" class="btn btn-primary" onclick="$('newOffer_sms_msg').val($('#newOffer_sms_msg').val() +'[[substuites_start]]') ;return false;" value="">ارفاق موعد البداء  </button>
                                                <small class="red ">سيتم استبدال المتغير الخاص بالقيمة </small>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label">المحتوي : </label>
                                                <div class="row">
                                                    <textarea id="newOffer_sms_msg" name="value[newOffer_sms_msg]" rows="6" class="form-control"><?php echo (@$data['value']->newOffer_sms_msg); ?></textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div> -->
                                            <!-- <br> -->
                                            <!-- select Offer ------------------------------------------------------------------------------- -->
                                            <!-- <div class="select-request">
                                    <div class="card-header" data-toggle="collapse" data-target="#collapseSelectOffer" aria-expanded="true" aria-controls="collapseSelectOffer">
                                        <span> select Offer  (للمتطوع)</span>
                                    </div>
                                    <div id="collapseSelectOffer" class="collapse card-body" aria-labelledby="headingOne">
                                        <div class="email-container">
                                            <h3> البريد الاكتروني</h3>
                                            <div class="form-group">
                                                <label class="control-label">تفعيل الارسال :</label>
                                                <div class="radio">
                                                    <label>
                                                        <input type="radio" class="flat" <?php echo (@$data['value']->selectOffer_enabled == 1) ? 'checked' : ''; ?> value="1" name="value[selectOffer_enabled]"> مفعلة
                                                    </label>
                                                    <label>
                                                        <input type="radio" class="flat" <?php echo (@$data['value']->selectOffer_enabled == '0') ? 'checked' : ''; ?> value="0" name="value[selectOffer_enabled]"> معلقة
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label" for="inform_subject">عنوان الرسالة : </label>
                                                <div class="has-feedback">
                                                    <input type="text" id="inform_subject" class="form-control" name="value[selectOffer_subject]" placeholder="عنوان الرسالة" value="<?php echo @$data['value']->selectOffer_subject; ?>">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <br>
                                                <button type="button" class="btn btn-primary" onclick="$('#SelectOffer_msg').val($('#SelectOffer_msg').val() +'[[name]]') ;return false;" value="">ارفاق الاسم </button>
                                                <button type="button" class="btn btn-primary" onclick="$('#SelectOffer_msg').val($('#SelectOffer_msg').val() +'[[identifier]]') ;return false;" value="">ارفاق رقم الطلب </button>
                                                <button type="button" class="btn btn-primary" onclick="$('#SelectOffer_msg').val($('#SelectOffer_msg').val() +'[[total]]') ;return false;" value="">ارفاق المبلغ </button>
                                                <button type="button" class="btn btn-primary" onclick="$('#SelectOffer_msg').val($('#SelectOffer_msg').val() +'[[project]]') ;return false;" value="">ارفاق اسم المشروع </button>
                                                <small class="red ">سيتم استبدال المتغير الخاص بالقيمة </small>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label">المحتوي : </label>
                                                <div class="row">
                                                    <textarea id="SelectOffer_msg" name="value[selectOffer_msg]" rows="6" class="form-control"><?php echo (@$data['value']->selectOffer_msg); ?></textarea>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="sms">
                                            <h3> رساله ال SMS</h3>
                                            <div class="form-group">
                                                <label class="control-label">تفعيل الارسال :</label>
                                                <div class="radio">
                                                    <label>
                                                        <input type="radio" class="flat" <?php echo (@$data['value']->selectOffer_sms == 1) ? 'checked' : ''; ?> value="1" name="value[selectOffer_sms]"> مفعلة
                                                    </label>
                                                    <label>
                                                        <input type="radio" class="flat" <?php echo (@$data['value']->selectOffer_sms == '0') ? 'checked' : ''; ?> value="0" name="value[selectOffer_sms]"> معلقة
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <br>
                                                <button type="button" class="btn btn-primary" onclick="$('#selectOffer_sms_msg').val($('#selectOffer_sms_msg').val() +'[[name]]') ;return false;" value="">ارفاق الاسم </button>
                                                <button type="button" class="btn btn-primary" onclick="$('#selectOffer_sms_msg').val($('#selectOffer_sms_msg').val() +'[[identifier]]') ;return false;" value="">ارفاق رقم الطلب </button>
                                                <button type="button" class="btn btn-primary" onclick="$('#selectOffer_sms_msg').val($('#selectOffer_sms_msg').val() +'[[total]]') ;return false;" value="">ارفاق المبلغ </button>
                                                <button type="button" class="btn btn-primary" onclick="$('#selectOffer_sms_msg').val($('#selectOffer_sms_msg').val() +'[[project]]') ;return false;" value="">ارفاق اسم المشروع </button>
                                                <small class="red ">سيتم استبدال المتغير الخاص بالقيمة </small>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label">المحتوي : </label>
                                                <div class="row">
                                                    <textarea id="selectOffer_sms_msg" name="value[selectOffer_sms_msg]" rows="6" class="form-control"><?php echo (@$data['value']->selectOffer_sms_msg); ?></textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div> -->
                                            <!-- </div> -->

                                            <!-- review ------------------------------------------------------------------------------- -->
                                            <!-- <div class="x_panel tile ">
                                <div class="select-request">
                                    <div class="card-header" data-toggle="collapse" data-target="#collapseReviewr" aria-expanded="true" aria-controls="collapseReviewr">
                                        <span>رساله لتقيم المتقدم ( ترسل للمتقدم ) </span>
                                    </div>
                                    <div id="collapseReviewr" class="collapse card-body" aria-labelledby="headingOne">
                                        <div class="email-container">
                                            <h3> البريد الاكتروني</h3>
                                            <div class="form-group">
                                                <label class="control-label">تفعيل الارسال :</label>
                                                <div class="radio">
                                                    <label>
                                                        <input type="radio" class="flat" <?php echo (@$data['value']->review_enabled == 1) ? 'checked' : ''; ?> value="1" name="value[review_enabled]"> مفعلة
                                                    </label>
                                                    <label>
                                                        <input type="radio" class="flat" <?php echo (@$data['value']->review_enabled == '0') ? 'checked' : ''; ?> value="0" name="value[review_enabled]"> معلقة
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label" for="inform_subject">عنوان الرسالة : </label>
                                                <div class="has-feedback">
                                                    <input type="text" id="inform_subject" class="form-control" name="value[review_subject]" placeholder="عنوان الرسالة" value="<?php echo @$data['value']->review_subject; ?>">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <br>
                                                <button type="button" class="btn btn-primary" onclick="$('#review_msg').val($('#review_msg').val() +'[[name]]') ;return false;" value="">ارفاق اسم المتطوع  </button>
                                                <button type="button" class="btn btn-primary" onclick="$('#review_msg').val($('#review_msg').val() +'[[identifier]]') ;return false;" value="">ارفاق رقم الطلب </button>
                                                <button type="button" class="btn btn-primary" onclick="$('#review_msg').val($('#review_msg').val() +'[[total]]') ;return false;" value="">ارفاق المبلغ </button>
                                                <button type="button" class="btn btn-primary" onclick="$('#review_msg').val($('#review_msg').val() +'[[project]]') ;return false;" value="">ارفاق اسم المشروع </button>
                                                <button type="button" class="btn btn-primary" onclick="$('#review_msg').val($('#review_msg').val() +'[[rate]]') ;return false;" value=""> التقيم </button>
                                                <small class="red ">سيتم استبدال المتغير الخاص بالقيمة </small>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label">المحتوي : </label>
                                                <div class="row">
                                                    <textarea id="review_msg" name="value[review_msg]" rows="6" class="form-control"><?php echo (@$data['value']->review_msg); ?></textarea>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="sms">
                                            <h3> رساله ال SMS</h3>
                                            <div class="form-group">
                                                <label class="control-label">تفعيل الارسال :</label>
                                                <div class="radio">
                                                    <label>
                                                        <input type="radio" class="flat" <?php echo (@$data['value']->review_sms == 1) ? 'checked' : ''; ?> value="1" name="value[review_sms]"> مفعلة
                                                    </label>
                                                    <label>
                                                        <input type="radio" class="flat" <?php echo (@$data['value']->review_sms == '0') ? 'checked' : ''; ?> value="0" name="value[review_sms]"> معلقة
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <br>
                                                <button type="button" class="btn btn-primary" onclick="$('#review_sms_msg').val($('#review_sms_msg').val() +'[[name]]') ;return false;" value="">ارفاق اسم المتطوع  </button>
                                                <button type="button" class="btn btn-primary" onclick="$('#review_sms_msg').val($('#review_sms_msg').val() +'[[identifier]]') ;return false;" value="">ارفاق رقم الطلب </button>
                                                <button type="button" class="btn btn-primary" onclick="$('#review_sms_msg').val($('#review_sms_msg').val() +'[[total]]') ;return false;" value="">ارفاق المبلغ </button>
                                                <button type="button" class="btn btn-primary" onclick="$('#review_sms_msg').val($('#review_sms_msg').val() +'[[project]]') ;return false;" value="">ارفاق اسم المشروع </button>
                                                <button type="button" class="btn btn-primary" onclick="$('#review_sms_msg').val($('#review_sms_msg').val() +'[[rate]]') ;return false;" value=""> التقيم </button>
                                                <small class="red ">سيتم استبدال المتغير الخاص بالقيمة </small>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label">المحتوي : </label>
                                                <div class="row">
                                                    <textarea id="review_sms_msg" name="value[review_sms_msg]" rows="6" class="form-control"><?php echo (@$data['value']->review_sms_msg); ?></textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <br>
                            </div> -->

                                        </div>
                                    </div>

                                    <br>

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
            <br><br>
        </div>
    </div>
</div>

<?php
// loading plugin
$data['footer'] = '' . "\n";
require ADMINROOT . '/views/inc/footer.php';
