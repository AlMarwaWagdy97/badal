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
<style>
    .x_title {
        font-weight: bold;
    }

    .box-badal {
        border: 2px solid #E6E9ED;
        margin: 5px 5px 5px 5px;
    }
</style>
<div class="right_col" role="main">
    <div class="clearfix"></div>
    <?php flash('setting_msg'); ?>
    <div class="setting-title">
        <div class="title_right">
            <h3><small>التعديل علي </small><?= $data['title']; ?> </h3>
        </div>
        <div class="title_left">
            <a href="<?= ADMINURL; ?>/settings" class="btn btn-success pull-left">عودة <i class="fa fa-reply"></i></a>
        </div>
    </div>
    <div class="clearfix"></div>
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <form action="<?= ADMINURL . '/settings/edit/' . $data['setting_id']; ?>" method="post" enctype="multipart/form-data" accept-charset="utf-8">
                <div class="form-group">
                    <label class="control-label" for="settingTitle">عنوان الاعداد : </label>
                    <div class="has-feedback">
                        <input type="text" id="settingTitle" class="form-control" name="title" placeholder="عنوان الاعداد" value="<?= $data['title']; ?>">
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label" for="settingTitle">رابط البوابة : </label>
                    <div class="has-feedback">
                        <input type="text" id="" class="form-control" name="value[gateurl]" placeholder="رابط البوابة" value="<?= @$data['value']->gateurl; ?>">
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label" for="settingTitle"> رمز وصول: </label>
                    <div class="has-feedback">
                        <input type="text" id="" class="form-control" name="value[accessToken]" placeholder="Access Token" value="<?= @$data['value']->accessToken; ?>">
                    </div>
                </div>

                <!-- 
                <div class="form-group">
                    <label class="control-label" for="settingTitle"> اسم ال template </label>
                    <div class="has-feedback">
                        <input type="text" id="" class="form-control" name="value[template_name]" placeholder="Template  Name" value="<?= @$data['value']->template_name; ?>">
                    </div>
                </div> -->

                <!-- <div class="form-group">
                    <label class="control-label" for="settingTitle"> اسم استقبال الطلب template </label>
                    <div class="has-feedback">
                        <input type="text" id="" class="form-control" name="value[template_name_receive_order]" placeholder="Template  Name" value="<?= @$data['value']->template_name_receive_order; ?>">
                    </div>
                </div>

                <div class="form-group">
                <label class="control-label" for="settingTitle"> اسم تأكيد الطلب template </label>
                    <div class="has-feedback">
                        <input type="text" id="" class="form-control" name="value[template_name_confirm_order]" placeholder="Template  Name" value="<?= @$data['value']->template_name_confirm_order; ?>">
                    </div>
                </div> -->

                <!-- <div class="form-group">
                    <label class="control-label" for="settingTitle"> اسم المرسل: </label>
                    <div class="has-feedback">
                        <input type="text" id="" class="form-control" name="value[broadcast_name]" placeholder="broadcast name" value="<?= @$data['value']->broadcast_name; ?>">
                    </div>
                </div> -->

                <!-- Estqbal order  ----------------------------------------------------------------------------------- -->
                <div class="x_panel tile ">
                    <h4 class="x_title"> استقبال الطلب </h4>
                    <div class="form-group">
                        <label class="control-label" for="settingTitle"> اسم استقبال الطلب template </label>
                        <div class="has-feedback">
                            <input type="text" id="" class="form-control" name="value[template_name_receive_order]" placeholder="Template  Name" value="<?= @$data['value']->template_name_receive_order; ?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label" for="settingTitle"> اسم المرسل لاستقبال الطلب: </label>
                        <div class="has-feedback">
                            <input type="text" id="" class="form-control" name="value[broadcast_name_receive_order]" placeholder="broadcast name" value="<?= @$data['value']->broadcast_name_receive_order; ?>">
                        </div>
                    </div>
                </div>

                <!-- taqed order  ----------------------------------------------------------------------------------- -->
                <div class="x_panel tile ">
                    <h4 class="x_title"> تأكيد الطلب </h4>
                    <div class="form-group">
                        <label class="control-label" for="settingTitle"> اسم تأكيد الطلب template </label>
                        <div class="has-feedback">
                            <input type="text" id="" class="form-control" name="value[template_name_confirm_order]" placeholder="Template  Name" value="<?= @$data['value']->template_name_confirm_order; ?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label" for="settingTitle"> اسم المرسل لتأكيد الطلب: </label>
                        <div class="has-feedback">
                            <input type="text" id="" class="form-control" name="value[broadcast_name_confirm_order]" placeholder="broadcast name" value="<?= @$data['value']->broadcast_name_confirm_order; ?>">
                        </div>
                    </div>
                </div>

                <!-- taqed order Gift order ----------------------------------------------------------------------------------- -->
                <div class="x_panel tile ">
                    <h4 class="x_title">  تاكيد الطلب للاهداء الخيري </h4>
                    <div class="form-group">
                        <label class="control-label" for="settingTitle"> اسم للاهداء الخيري  template </label>
                        <div class="has-feedback">
                            <input type="text" id="" class="form-control" name="value[template_name_gift_confirm]" placeholder="Template  Name" value="<?= @$data['value']->template_name_gift_confirm; ?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label" for="settingTitle"> اسم المرسل للاهداء الخيري : </label>
                        <div class="has-feedback">
                            <input type="text" id="" class="form-control" name="value[broadcast_name_gift_confirm]" placeholder="broadcast name" value="<?= @$data['value']->broadcast_name_gift_confirm; ?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label" for="settingTitle">رابط للاهداء</label>
                        <div class="has-feedback">
                            <input type="text" id="" class="form-control" name="value[template_url_gift_confirm]" placeholder="رابط للاهداء" value="<?= @$data['value']->template_url_gift_confirm; ?>">
                        </div>
                    </div>
                </div>

                <!-- deceaseds----------------------------------------------------------------------------------- -->
                <div class="x_panel tile ">
                    <h4 class="x_title"> رسالة بالواتس لتاكيد حمله المتوفي </h4>
                    <div class="form-group">
                        <label class="control-label" for="settingTitle"> اسم template </label>
                        <div class="has-feedback">
                            <input type="text" id="" class="form-control" name="value[template_name_deceased]" placeholder="Template  Name" value="<?= @$data['value']->template_name_deceased; ?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label" for="settingTitle"> اسم المرسل: </label>
                        <div class="has-feedback">
                            <input type="text" id="" class="form-control" name="value[broadcast_name_deceased]" placeholder="broadcast name" value="<?= @$data['value']->broadcast_name_deceased; ?>">
                        </div>
                    </div>
                </div>




                <div class="col-lg-12 col-sm-12 col-xs-12 options">
                    <div class="accordion">
                        <div class="card">
                            <div class="x_panel tile ">
                                <!-- New Offer ------------------------------------------------------------------------------- -->
                                <div class="select-request">
                                    <div class="card-header" data-toggle="collapse" data-target="#collapseNewOffer" aria-expanded="true" aria-controls="collapseNewOffer">
                                        <span> رسايل البدل </span>
                                    </div>
                                    <div id="collapseNewOffer" class="collapse card-body" aria-labelledby="headingOne">
                                        <div class="row badal">
                                            <!-- New order ( Badal ) ----------------------------------------------------------------------------------- -->
                                            <div class="box-badal col-md-5">
                                                <h4 class="x_title"> رسالة بريدية لطلب بدل جديد ( ترسل لمقدمي الخدمة ) </h4>
                                                <div class="form-group">
                                                    <label class="control-label" for="settingTitle"> اسم template </label>
                                                    <div class="has-feedback">
                                                        <input type="text" id="" class="form-control" name="value[template_name_arrive_order]" placeholder="Template  Name" value="<?= @$data['value']->template_name_arrive_order; ?>">
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="control-label" for="settingTitle"> اسم المرسل: </label>
                                                    <div class="has-feedback">
                                                        <input type="text" id="" class="form-control" name="value[broadcast_name_arrive_order]" placeholder="broadcast name" value="<?= @$data['value']->broadcast_name_arrive_order; ?>">
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- start Order ------------------------------------------------------------------------------- -->
                                            <div class="box-badal col-md-5">
                                                <h4 class="x_title"> رسالة بداء طلب البدل ( ترسل للطالب الخدمة ) </h4>
                                                <div class="form-group">
                                                    <label class="control-label" for="settingTitle"> اسم template </label>
                                                    <div class="has-feedback">
                                                        <input type="text" id="" class="form-control" name="value[template_name_start_order]" placeholder="Template  Name" value="<?= @$data['value']->template_name_start_order; ?>">
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="control-label" for="settingTitle"> اسم المرسل : </label>
                                                    <div class="has-feedback">
                                                        <input type="text" id="" class="form-control" name="value[broadcast_name_start_order]" placeholder="broadcast name" value="<?= @$data['value']->broadcast_name_start_order; ?>">
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- completed Order ------------------------------------------------------------------------------- -->
                                            <div class="box-badal col-md-5">
                                                <h4 class="x_title"> رسالة انتهاء الطلب ( ترسل للطالب الخدمة ) </h4>
                                                <div class="form-group">
                                                    <label class="control-label" for="settingTitle"> اسم template </label>
                                                    <div class="has-feedback">
                                                        <input type="text" id="" class="form-control" name="value[template_name_complete_order]" placeholder="Template  Name" value="<?= @$data['value']->template_name_complete_order; ?>">
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="control-label" for="settingTitle"> اسم المرسل : </label>
                                                    <div class="has-feedback">
                                                        <input type="text" id="" class="form-control" name="value[broadcast_name_complete_order]" placeholder="broadcast name" value="<?= @$data['value']->broadcast_name_complete_order; ?>">
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- New request ( Badal ) ----------------------------------------------------------------------------------- -->
                                            <div class="box-badal col-md-5">
                                                <h4 class="x_title"> رساله المتقدمين لتنفيذ طلب البدل (ترسل للطالب الخدمة) </h4>
                                                <div class="form-group">
                                                    <label class="control-label" for="settingTitle"> اسم template </label>
                                                    <div class="has-feedback">
                                                        <input type="text" id="" class="form-control" name="value[template_name_new_request]" placeholder="Template  Name" value="<?= @$data['value']->template_name_new_request; ?>">
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="control-label" for="settingTitle"> اسم المرسل : </label>
                                                    <div class="has-feedback">
                                                        <input type="text" id="" class="form-control" name="value[broadcast_name_new_request]" placeholder="broadcast name" value="<?= @$data['value']->broadcast_name_new_request; ?>">
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- select request ( Badal ) ----------------------------------------------------------------------------------- -->
                                            <div class="box-badal col-md-5">
                                                <h4 class="x_title"> رساله الاختيار المتقدم لتنفيذ الطلب (ترسل للمتقدم) </h4>
                                                <div class="form-group">
                                                    <label class="control-label" for="settingTitle"> اسم template </label>
                                                    <div class="has-feedback">
                                                        <input type="text" id="" class="form-control" name="value[template_name_select_request]" placeholder="Template  Name" value="<?= @$data['value']->template_name_select_request; ?>">
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="control-label" for="settingTitle"> اسم المرسل : </label>
                                                    <div class="has-feedback">
                                                        <input type="text" id="" class="form-control" name="value[broadcast_name_select_request]" placeholder="broadcast name" value="<?= @$data['value']->broadcast_name_select_request; ?>">
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Notify subsitute for Orders ----------------------------------------------------------------------------------- -->
                                            <div class="box-badal col-md-5">
                                                <h4 class="x_title"> رساله المتقدمين لتنبيه الطلب اليوم   (ترسل للمقدمي الخدمة) </h4>
                                                <div class="form-group">
                                                    <label class="control-label" for="settingTitle"> اسم template </label>
                                                    <div class="has-feedback">
                                                        <input type="text" id="" class="form-control" name="value[template_name_notify_order]" placeholder="Template  Name" value="<?= @$data['value']->template_name_notify_order; ?>">
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="control-label" for="settingTitle"> اسم المرسل : </label>
                                                    <div class="has-feedback">
                                                        <input type="text" id="" class="form-control" name="value[broadcast_name_notify_order]" placeholder="broadcast name" value="<?= @$data['value']->broadcast_name_notify_order; ?>">
                                                    </div>
                                                </div>
                                            </div>


                                            <!-- Cancel request ( Badal ) ----------------------------------------------------------------------------------- -->
                                            <div class="box-badal col-md-5">
                                                <h4 class="x_title"> رساله لالغاء باقي المتقدمين (ترسل للمتقدمين) </h4>
                                                <div class="form-group">
                                                    <label class="control-label" for="settingTitle"> اسم template </label>
                                                    <div class="has-feedback">
                                                        <input type="text" id="" class="form-control" name="value[template_name_cancel_request]" placeholder="Template  Name" value="<?= @$data['value']->template_name_cancel_request; ?>">
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="control-label" for="settingTitle"> اسم المرسل : </label>
                                                    <div class="has-feedback">
                                                        <input type="text" id="" class="form-control" name="value[broadcast_name_cancel_request]" placeholder="broadcast name" value="<?= @$data['value']->broadcast_name_cancel_request; ?>">
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Cancel order for late ----------------------------------------------------------------------------------- -->
                                            <div class="box-badal col-md-5">
                                                <h4 class="x_title"> رساله لالغاء طلب المتقدم لتاخره في بداء المناسك ( ترسل للمتقدم ) </h4>
                                                <div class="form-group">
                                                    <label class="control-label" for="settingTitle"> اسم template </label>
                                                    <div class="has-feedback">
                                                        <input type="text" id="" class="form-control" name="value[template_name_late_request]" placeholder="Template  Name" value="<?= @$data['value']->template_name_late_request; ?>">
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="control-label" for="settingTitle"> اسم المرسل : </label>
                                                    <div class="has-feedback">
                                                        <input type="text" id="" class="form-control" name="value[broadcast_name_late_request]" placeholder="broadcast name" value="<?= @$data['value']->broadcast_name_late_request; ?>">
                                                    </div>
                                                </div>
                                            </div>

                                            
                                            <!-- completed Order ------------------------------------------------------------------------------- -->
                                            <div class="box-badal col-md-5">
                                                <h4 class="x_title"> رسالة اكتمال المناسك  ( ترسل للطالب الخدمة والمقدمي الخدمة ) </h4>
                                                <div class="form-group">
                                                    <label class="control-label" for="settingTitle"> اسم template </label>
                                                    <div class="has-feedback">
                                                        <input type="text" id="" class="form-control" name="value[template_name_complete_rites]" placeholder="Template  Name" value="<?= @$data['value']->template_name_complete_rites; ?>">
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="control-label" for="settingTitle"> اسم المرسل : </label>
                                                    <div class="has-feedback">
                                                        <input type="text" id="" class="form-control" name="value[broadcast_name_complete_rites]" placeholder="broadcast name" value="<?= @$data['value']->broadcast_name_complete_rites; ?>">
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- new offer  ----------------------------------------------------------------------------------- -->
                                         <div class="box-badal col-md-5">
                                            <h4 class="x_title">رساله لعرض جديد ( ترسل للطالب الخدمة ) </h4>
                                            <div class="form-group">
                                                <label class="control-label" for="settingTitle"> عرض  template </label>
                                                <div class="has-feedback">
                                                    <input type="text" id="" class="form-control" name="value[template_name_new_offer]" placeholder="Template  Name" value="<?= @$data['value']->template_name_new_offer; ?>">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label" for="settingTitle"> اسم المرسل  : </label>
                                                <div class="has-feedback">
                                                    <input type="text" id="" class="form-control" name="value[broadcast_name_new_offer]" placeholder="broadcast name" value="<?= @$data['value']->broadcast_name_new_offer; ?>">
                                                </div>
                                            </div>
                                        </div> 

                                            <!-- new review  ----------------------------------------------------------------------------------- -->
                                          <div class="box-badal col-md-5">
                                            <h4 class="x_title">رساله لتقيم ( ترسل للطالب الخدمة ) </h4>
                                            <div class="form-group">
                                                <label class="control-label" for="settingTitle"> عرض  template </label>
                                                <div class="has-feedback">
                                                    <input type="text" id="" class="form-control" name="value[template_name_review]" placeholder="Template  Name" value="<?= @$data['value']->template_name_review; ?>">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label" for="settingTitle"> اسم المرسل  : </label>
                                                <div class="has-feedback">
                                                    <input type="text" id="" class="form-control" name="value[broadcast_name_review]" placeholder="broadcast name" value="<?= @$data['value']->broadcast_name_review; ?>">
                                                </div>
                                            </div>
                                        </div> 
                                        </div>
                                    </div>
                                    <br>
                                </div>
                            </div>
                        </div>
                    </div>



                    <div class="parameter">
                        <div class="form-group">
                            <label class="control-label" for="settingTitle"> المتغيرات </label>
                            <div id="parameter_section">
                                <?php if (isset($data['value']->var_names)) { ?>
                                    <?php foreach ($data['value']->var_names as $key => $var_name) { ?>
                                        <div class="variables">
                                            <div class="row">
                                                <div class="col-sm-4">
                                                    <label for="inputPassword3" class="col-sm-4 col-form-label">اسم المتغير </label>
                                                    <input type="text" class="form-control" name="value[var_names][]" value="<?= @$data['value']->var_names[$key]  ?>">
                                                </div>
                                                <div class="col-sm-4">
                                                    <label for="inputPassword3" class="col-sm-4 col-form-label">قيمه المتغير </label>
                                                    <input type="text" class="form-control" name="value[var_value][]" value="<?= @$data['value']->var_value[$key]  ?>">
                                                </div>
                                                <div class="col-sm-1 mt-3" style="margin-top: 22px;">
                                                    <button class="btn btn-danger btn-sm delete_var form-control"><i class="fa fa-trash"></i></button>
                                                </div>
                                            </div>
                                        </div>
                                    <?php } ?>
                                <?php } ?>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <button type="button" id="add_parameter" class="btn btn-success">اضافه متغير</button>
                    </div>

                    <div class="form-group col-xs-12 ">
                        <label class="control-label">تفعيل البوابة :</label>
                        <div class="radio">
                            <label>
                                <input type="radio" class="flat" name="value[whatsappenabled]" <?= (@$data['value']->whatsappenabled == 1) ? 'checked' : ''; ?> value="1"> مفعلة
                            </label>
                            <label>
                                <input type="radio" class="flat" name="value[whatsappenabled]" <?= (@$data['value']->whatsappenabled == '0') ? 'checked' : ''; ?> value="0"> معلقة
                            </label>
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


<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
<script>
    $(document).ready(function() {
        var index = 1;
        $('#add_parameter').on('click', function() {
            $('#parameter_section').append(
                `
                    <div class="variables" >
                        <div class="row">
                            <div class="col-sm-4">
                                <label for="inputPassword3" class="col-sm-4 col-form-label">اسم المتغير </label>
                                <input type="text" class="form-control" name="value[var_names][]">
                            </div>
                            <div class="col-sm-4">
                                <label for="inputPassword3" class="col-sm-4 col-form-label">قيمه المتغير  </label>
                                <input type="text" class="form-control" name="value[var_value][]">
                            </div>
                            <div class="col-sm-1 mt-3" style="margin-top: 22px;">
                                <button class="btn btn-danger btn-sm delete_var form-control"><i class="fa fa-trash"></i></button>
                            </div>
                        </div>
                    </div>
                `
            )

            index++;
        });


        $('#parameter_section').on('click', '.delete_var', function(e) {
            $(this).parent().parent().remove();
        })
    });
</script>

<?php


// loading plugin
$data['footer'] = '<script src="' . ADMINURL . '/template/default/vendors/jquery.tagsinput/src/jquery.tagsinput.js"></script>' . "\n";

require ADMINROOT . '/views/inc/footer.php';
