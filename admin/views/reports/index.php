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

// loading  plugin style
$data['header'] = '<link rel="stylesheet" href="' . ADMINURL . '/template/default/vendors/select2/dist/css/select2.min.css">';

require ADMINROOT . '/views/inc/header.php';
?>

<!-- page content -->

<div class="right_col" role="main">
    <div class="clearfix"></div>
    <?php flash('report_msg'); ?>
    <div class="page-title">
        <div class="title_right">
            <h3><?php echo $data['title']; ?> <small> استخراج <?php echo $data['title']; ?> </small></h3>
        </div>
        <div class="title_left">
        </div>
    </div>
    <div class="clearfix"></div>
    <div class="options">
        <div class="accordion">
            <div class="card">
                <div class="card-header" data-toggle="collapse" data-target="#collapseZero" aria-expanded="true" aria-controls="collapseZero">
                    <span> تقارير التبرعات </span>
                </div>
                <div id="collapseZero" class="collapse in card-body" aria-labelledby="headingZero">
                    <form action="<?php echo ADMINURL ?>/reports/show/orders" method="post" class="row">
                        <div class="form-group col-lg-6 col-xs-12">معرف التبرع
                            <input class="form-control" type="search" placeholder="بحث بالمعرف" name="search[order_identifier]">
                        </div>
                        <div class="form-group col-lg-6 col-xs-12">اسم المتبرع
                            <input class="form-control" type="search" placeholder="بحث بالمتبرع" name="search[full_name]">
                        </div>
                        <div class="form-group col-lg-6 col-xs-12">الجوال <input class="form-control" type="search" placeholder="بحث بالجوال" name="search[mobile]"></div>
                        <div class="form-group col-lg-6 col-xs-12">المشروع
                            <div class="dropdown ">
                                <a href="#" data-toggle="dropdown" class="dropdown-toggle btn-default form-control"> المشروع <b class="caret"></b></a>
                                <ul class="dropdown-menu">
                                    <?php foreach ($data['projects'] as $key => $project) {
                                        echo '<li><label class="btn-default"><input class="flat" name="search[projects][]"';
                                        echo ' type="checkbox" value="' . $project->project_id . '" > ' . $project->name . ' </label></li>';
                                    } ?>
                                </ul>
                            </div>
                        </div>
                        <div class="form-group col-lg-6 col-xs-12">وسيلة التبرع <br>
                            <div class="dropdown ">
                                <a href="#" data-toggle="dropdown" class="dropdown-toggle btn-default form-control"> وسيلة التبرع <b class="caret"></b></a>
                                <ul class="dropdown-menu">
                                    <?php foreach ($data['paymentMethods'] as $pm) {
                                        echo '<li><label class="btn-default"><input class="flat" name="search[payment_method][]"';
                                        echo ' type="checkbox" value="' . $pm->payment_id . '" > ' . $pm->title . ' </label></li>';
                                    } ?>
                                </ul>
                            </div>
                        </div>
                        <div class="form-group col-lg-6 col-xs-12">الحالات المخصصة
                            <div class="dropdown ">
                                <a href="#" data-toggle="dropdown" class="dropdown-toggle  btn-default form-control"> الحالة <b class="caret"></b></a>
                                <ul class="dropdown-menu">
                                    <?php foreach ($data['statuses'] as $status) {
                                        echo '<li><label class="btn-default"><input class="flat" name="search[status_id][]" type="checkbox"';
                                        echo ' value="' . $status->status_id . '"> ' . $status->name . ' </label></li>';
                                    } ?>
                                </ul>
                            </div>
                        </div>
                        <div class="form-group col-lg-6 col-xs-12">القيمة <br>
                            <input class="" type="search" placeholder="من" name="search[total_from]">
                            <input class="" type="search" placeholder="الي" name="search[total_to]">
                        </div>
                        <div class="form-group col-lg-6 col-xs-12">تاريخ التبرع <br>
                            <input type="date" placeholder=" من" name="search[date_from]" class="">
                            <input type="date" placeholder=" الي" name="search[date_to]" class="">
                        </div>
                        <div class="form-group col-lg-6 col-xs-12 no-link last"><span class="nobr">بحث بالحالة</span><br>
                            <select class=" form-control" name="search[status]">
                                <option value=""></option>
                                <option value="1">مؤكد </option>
                                <option value="5"> غير مؤكد </option>
                                <option value="3"> في الانتظار </option>
                                <option value="4">ملغاه </option>
                            </select>
                        </div>
                        <div class="form-group col-lg-6 col-xs-12">عدد النتائج <br>
                            <input class="form-control" type="number" placeholder="عدد النتائج" name="search[limit]">
                        </div>  
                        <div class="col-xs-12">
                            <button type="submit" name="orders" class="btn btn-success">عرض <i class="fa fa-eye"> </i></button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="card">
                <div class="card-header" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                    <span> تقارير المتبرعين </span>
                </div>
                <div id="collapseOne" class="collapse card-body" aria-labelledby="headingOne">
                    <form action="<?php echo ADMINURL ?>/reports/show/donors" method="post" class="row">
                        <div class="form-group col-xs-12 ">
                            <label for="donor" class="">اسم المتبرع </label>
                            <input class="form-control" type="text" name="donor" placeholder="المتبرع">
                        </div>
                        <div class="form-group col-xs-12 ">
                            <label for="mobile" class="">رقم الجوال </label>
                            <input class="form-control" type="text" name="mobile" placeholder="رقم الجوال">
                        </div>
                        <div class="form-group col-xs-12 ">
                            <label for="email" class=""> البريد الالكتروني </label>
                            <input class="form-control" type="text" name="email" placeholder=" البريد الالكتروني ">
                        </div>
                        <div class="form-group col-lg-6 col-xs-12">
                            <label for="status">حالة المتبرع</label>
                            <select id="status" class="form-control " name="status">
                                <option value="">اختار حالة المتبرع</option>
                                <option value="1">مفعل</option>
                                <option value="0">غير مفعل</option>
                                <option value="2">محذوف</option>
                            </select>
                        </div>
                        <div class="form-group col-lg-6 col-xs-12">
                            <label for="mobile_confirmed">تفعيل الجوال</label>
                            <select id="mobile_confirmed" class="form-control " name="mobile_confirmed">
                                <option value="">اختار حالة التفعيل</option>
                                <option value="1">مفعل</option>
                                <option value="0"> غير</option>
                            </select>
                        </div>
                        <div class="form-group col-lg-6 col-xs-12 ">
                            <label for="amount" class="">تاريخ التسجيل </label>
                            <div class="form-inline">
                                من : <input class="form-control " type="date" name="date_from" placeholder="من">
                                الي: <input class="form-control " type="date" name="date_to" placeholder="الي">
                            </div>
                        </div>
                        <div class="col-xs-12">
                            <button type="submit" name="donors" class="btn btn-success">عرض <i class="fa fa-eye"> </i></button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="card">
                <div class="card-header" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
                    <span> تقارير بيانات التواصل </span>
                </div>
                <div id="collapseTwo" class="collapse card-body" aria-labelledby="headingTwo">
                    <form action="<?php echo ADMINURL ?>/reports/show/contacts" method="post" class="row">
                        <div class="form-group col-xs-12 ">
                            <label for="subject" class="">العنوان </label>
                            <input class="form-control" type="text" name="subject" placeholder="العنوان">
                        </div>
                        <div class="form-group col-xs-12 ">
                            <label for="message" class="">الرسالة </label>
                            <input class="form-control" type="text" name="message" placeholder="الرسالة">
                        </div>
                        <div class="form-group col-xs-12 ">
                            <label for="full_name" class="">الاسم </label>
                            <input class="form-control" type="text" name="full_name" placeholder="الاسم">
                        </div>
                        <div class="form-group col-xs-12 ">
                            <label for="phone" class="">رقم الهاتف </label>
                            <input class="form-control" type="text" name="phone" placeholder="رقم الهاتف">
                        </div>
                        <div class="form-group col-xs-12 ">
                            <label for="email" class=""> البريد الالكتروني </label>
                            <input class="form-control" type="text" name="email" placeholder=" البريد الالكتروني ">
                        </div>
                        <div class="form-group col-lg-6 col-xs-12">
                            <label for="type"> الغرض</label>
                            <select id="type" class="form-control " name="type">
                                <option value="">اختار الغرض من التواصل</option>
                                <option value="شكوي">شكوي</option>
                                <option value="طلب">طلب </option>
                                <option value="اقتراح">اقتراح</option>
                                <option value="استفسار">استفسار</option>
                            </select>
                        </div>
                        <div class="form-group col-lg-6 col-xs-12">
                            <label for="status">حالة القراءة</label>
                            <select id="status" class="form-control " name="status">
                                <option value="">اختار حالة القراءة</option>
                                <option value="1">مقروءة</option>
                                <option value="0">غير مقروءة</option>
                                <option value="2">محذوف</option>
                            </select>
                        </div>
                        <div class="form-group col-lg-6 col-xs-12 ">
                            <label for="amount" class="">تاريخ التسجيل </label>
                            <div class="form-inline">
                                من : <input class="form-control " type="date" name="date_from" placeholder="من">
                                الي: <input class="form-control " type="date" name="date_to" placeholder="الي">
                            </div>
                        </div>
                        <div class="col-xs-12">
                            <button type="submit" name="contacts" class="btn btn-success">عرض <i class="fa fa-eye"> </i></button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <br><br>
    </div>
</div>
<?php
// loading  plugin
$data['footer'] = '<script src="' . ADMINURL . '/template/default/vendors/select2/dist/js/select2.full.min.js"></script>
<script src="' . ADMINURL . '/template/default/vendors/jquery.tagsinput/src/jquery.tagsinput.js"></script>
<script> $(".select2").select2({dir: "rtl"});</script>';

require ADMINROOT . '/views/inc/footer.php';
