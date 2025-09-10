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
    <?php flash('order_msg'); ?>
    <div class="page-title">
        <div class="title_right">
            <h3><?= $data['title']; ?> <small>عرض كافة <?= $data['title']; ?> </small></h3>
        </div>
        <div class="title_left">
        </div>
    </div>
    <div class="clearfix"></div>
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <form action="" method="post">
                <div class="clearfix">
                </div>
                <div class="table-responsive">
                    <table class="table table-striped jambo_table bulk_action">
                        <thead class="fixme">
                            <tr class="headings orders">
                                <th>
                                    <input type="checkbox" id="check-all" class="flat">
                                </th>
                                <th class="column-title">معرف التبرع <input type="search" placeholder="بحث بالمعرف" name="search[order_identifier]" value="<?php printIsset(cleanSearchVar('order_identifier')); ?>" class="w100"></th>
                                <th class="column-title">القيمة <br>
                                    <input type="search" placeholder="من" name="search[total_from]" value="<?php printIsset(cleanSearchVar('total_from')); ?>" class="w50">
                                    <input type="search" placeholder="الي" name="search[total_to]" value="<?php printIsset(cleanSearchVar('total_to')); ?>" class="w50">
                                </th>
                                <th class="column-title">تبرع بأسم <input type="search" placeholder="بحث بالمتبرع" name="search[donor_name]" value="<?php printIsset(cleanSearchVar('donor_name')); ?>" class="w100"></th>
                                <th class="column-title">اسم المستخدم <input type="search" placeholder="بحث بالمستخدم" name="search[full_name]" value="<?php printIsset(cleanSearchVar('full_name')); ?>" class="w100"></th>
                                <th class="column-title">الجوال <input type="search" placeholder="بحث بالجوال" name="search[mobile]" value="<?php printIsset(cleanSearchVar('mobile')); ?>" class="w100"></th>
                                <th class="column-title" width="200px">المشروع
                                    <select class="select2" multiple name="search[projects][]" style="width:200px !important">
                                        <?php
                                        foreach ($data['projects'] as $key => $project) {
                                            echo '<option ';
                                            if (isset($_SESSION['search']['pjs'])) echo in_array($project->project_id, $_SESSION['search']['pjs']) ? 'selected' : null;
                                            echo ' value="' . $project->project_id . '" > ' . $project->name . ' </option>';
                                        } ?>
                                    </select>
                                </th>
                                <th class="column-title">وسيلة التبرع <br>
                                    <div class="dropdown check-list">
                                        <a href="#" data-toggle="dropdown" class="dropdown-toggle btn-default"> وسيلة التبرع <b class="caret"></b></a>
                                        <ul class="dropdown-menu">
                                            <?php foreach ($data['paymentMethodsList'] as $pm) {
                                                echo '<li><label class="btn-default"><input class="flat" name="search[payment_method][]"';
                                                if (isset($_SESSION['search']['payment_method'])) echo in_array($pm->payment_id, $_SESSION['search']['payment_method']) ? 'checked' : null;
                                                echo ' type="checkbox" value="' . $pm->payment_id . '" > ' . $pm->title . ' </label></li>';
                                            } ?>
                                        </ul>
                                    </div>
                                </th>
                                <th class="column-title stores"> المعرض <br>
                                    <div class="dropdown check-list">
                                        <a href="#" data-toggle="dropdown" class="dropdown-toggle btn-default"> المعرض <b class="caret"></b></a>
                                        <ul class="dropdown-menu">
                                            <label class="dark" onclick="checkallstores(this)">
                                                <input type="checkbox" class="iCheck-helper flat" name="" value=""> اختار الكل
                                            </label>
                                            <?php foreach ($data['stores'] as $store) {
                                                echo '<li><label class="btn-default"><input class="flat storecheck" name="search[store_id][]"';
                                                if (isset($_SESSION['search']['store_id'])) echo in_array($store->store_id, $_SESSION['search']['store_id']) ? 'checked' : null;
                                                echo ' type="checkbox" value="' . $store->store_id . '" > ' . $store->name . ' </label></li>';
                                            } ?>
                                        </ul>
                                    </div>
                                </th>
                                <th class="column-title" width="175px">
                                    <span class="nobr">حمله متوفي</span><br>
                                    <select class="" name="search[deceased_id]">
                                        <option value="">حمله متوفي</option>
                                        <option value="1">نعم </option>
                                        <option value="2"> لا </option>
                                    </select>
                                </th>
                                <th class="column-title">بيانات الإهداء
                                    <select class="" name="search[gift]">
                                        <option value="">اختار</option>
                                        <option value="1">مهدي</option>
                                        <option value="2">غير مهدي</option>
                                    </select>
                                </th>
                                <th class="column-title"> الأيصال</th>

                                <th class="column-title">تأكيد التحويل
                                    <select class="" name="search[banktransferproof]">
                                        <option value="">اختار</option>
                                        <option value="1">مرفق</option>
                                        <option value="2">غير مرفق</option>
                                    </select>
                                </th>
                                <th class="column-title">
                                    المصدر <br>
                                    <select name="search[app]">
                                        <option value="">الكل</option>
                                        <option value="kafara">تطبيق الكفارات </option>
                                        <option value="web"> الويب </option>
                                        <option value="badal"> البدل </option>
                                    </select>
                                </th>
                                <th class="column-title">تفاصيل Payfort </th>
                                <th class="column-title">تاريخ التبرع <br>
                                    <input type="date" placeholder=" من" name="search[date_from]" value="<?php if (returnIsset(cleanSearchVar('date_from'))) echo date('Y-m-d', returnIsset(cleanSearchVar('date_from'))); ?>" class="">
                                    <input type="date" placeholder=" الي" name="search[date_to]" value="<?php if (returnIsset(cleanSearchVar('date_to'))) echo date('Y-m-d', (int) returnIsset(cleanSearchVar('date_to')) - 86400); ?>" class="">
                                </th>
                                <th class="column-title">الحالة
                                    <div class="dropdown check-list">
                                        <a href="#" data-toggle="dropdown" class="dropdown-toggle  btn-default"> الحالة <b class="caret"></b></a>
                                        <ul class="dropdown-menu">
                                            <?php foreach ($data['statuses'] as $status) {
                                                echo '<li><label class="btn-default"><input class="flat" name="search[status_id][]" type="checkbox"';
                                                if (isset($_SESSION['search']['status_id'])) echo in_array($status->status_id, $_SESSION['search']['status_id']) ? 'checked' : null;
                                                echo ' value="' . $status->status_id . '"> ' . $status->name . ' </label></li>';
                                            } ?>
                                        </ul>
                                    </div>
                                </th>
                                <th class="column-title no-link last"><span class="nobr">اجراءات</span><br>
                                    <select name="search[status]">
                                        <option value=""></option>
                                        <option value="1">مؤكد </option>
                                        <option value="5"> غير مؤكد </option>
                                        <option value="3"> في الانتظار </option>
                                        <option value="4">ملغاه </option>
                                    </select>
                                </th>
                                <th class="column-title w50">
                                    <input type="submit" name="search[submit]" value="بحـث" class="btn btn-sm btn-primary search-query" />
                                    <input type="submit" name="search[clearSearch]" value="مسح" class="btn btn-sm btn-warning search-query" />
                                    <input type="submit" name="exportAll" value="استخراج" class="btn btn-sm btn-success search-query " />
                                </th>
                                <th class="bulk-actions" colspan="17">
                                    <span> تنفيذ علي الكل :</span>
                                    <input type="submit" name="publish" value="تأكيد" class="btn btn-success btn-xs" />
                                    <input type="submit" name="unpublish" value="تعليق" class="btn btn-warning btn-xs" />
                                    <input type="submit" name="canceled" value="الغاء" class="btn btn-default  btn-xs" />
                                    <input type="submit" name="waiting" value="في الانتظار" class="btn btn-info btn-xs" />
                                    <input type="submit" name="delete" value="حذف" onclick="return confirm('Are you sure?') ? true : false" class="btn btn-danger btn-xs" />
                                    <span class="control-label">ارسال :</span>
                                    <input type="submit" name="send" value="SMS" class="btn btn-success btn-sm" />
                                    <input type="submit" name="send" value="Email" class="btn btn-success btn-sm" />
                                    <input type="submit" name="export" value="Excel" class="btn btn-success btn-xs" />
                                    <!--<input type="submit" name="gift" value="ارسال الإهداء" class="btn btn-red btn-xs" />-->
                                    <input type="submit" name="proof" value="طلب تأكيد التحويل" class="btn btn-info btn-xs" />
                                    <div class="btn-group d-inline">
                                        <span class="control-label">الوسوم : </span>
                                        <button style="padding:2px 20px;margin: 0 10px " class="btn btn-info dropdown-toggle btn-xs" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">اختار</button>
                                        <div class="dropdown-menu">
                                            <?php
                                            foreach ($data['statuses'] as $status) {
                                                echo ' <button type="submit" name="status_id"  value="' . $status->status_id . '"class="btn bg-primary btn-xs btn-block dropdown-item ">' . $status->name . '</button> ';
                                            }
                                            ?>
                                            <input type="submit" name="clear" value=" حذف الوسم" onclick="return confirm('Are you sure?') ? true : false" class="btn bg-warning btn-xs btn-block dropdown-item" />
                                        </div>
                                    </div>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($data['orders'] as $order) : ?>
                                <tr class="even pointer">
                                    <td class="a-center ">
                                        <input type="checkbox" class="records flat" name="record[]" value="<?= $order->order_id; ?>">
                                    </td>
                                    <td><?= $order->order_identifier; ?></td>
                                    <td><?= $order->total; ?></td>
                                    <td><?= $order->donor_name; ?></td>
                                    <td><?= '<a class="text-warning" href="' . ADMINURL . '/donors/show/' . $order->donor_id . '">' . $order->donor . '</a>'; ?></td>
                                    <td class="ltr"><?= $order->mobile; ?></td>
                                    <td><?= $order->projects; ?></td>
                                    <td><?= $order->payment_method; ?></td>
                                    <td><?= $order->store; ?></td>
                                    <td>
                                        <?= ($order->deceased_id) ? '<a href="' . ADMINURL . '/deceaseds/show/' . $order->deceased_id . '"><i class="fa fa-check btn btn-primary"></i><a/>' : ''; ?>
                                    </td>
                                    <td>
                                        <?php if ($order->gift) { ?>
                                            <a href="<?= ADMINURL . '/ShowCards/show/' .  $order->order_id; ?>" class="btn btn-info btn-sm" target="_blank">تفاصيل</a>
                                        <?php } ?>
                                    </td>
                                    <td>
                                        <?php 
                                            if($order->status == 1){ ?>
                                            <a href="<?= URLROOT . '/invoices/show/' .  orderIdentifier($order->order_id); ?>" class="btn btn-info btn-sm" target="_blank">عرض</a>
                                            <?php } ?>
                                    </td>
                                    <td><?php if (!empty($order->banktransferproof)) : ?>
                                            <a class="btn btn-success btn-sm" href="<?= URLROOT . "/media/files/banktransfer/" . $order->banktransferproof; ?>" target="blank">تحميل</a>
                                        <?php endif; ?>
                                    </td>
                                    <td><?= $order->app ?> </td>
                                    <td>
                                        <?php if ($order->meta) {
                                            $metas = json_decode($order->meta) ?? $metas = [];
                                            // var_dump($metas->response_code);
                                        ?>
                                            <button type="button" class="btn <?= ($metas->response_code == '00047') ? 'btn-warning' : 'btn-info';  ?>  btn-sm" data-toggle="modal" data-target="#meta<?= $order->order_id; ?>">تفاصيل</button>
                                            <div class="modal fade" id="meta<?= $order->order_id; ?>" role="dialog">
                                                <div class="modal-dialog">
                                                    <!-- Modal content-->
                                                    <div class="modal-content">
                                                        <div class="modal-body text-right" dir="ltr">
                                                            <ul class="text-capitalize">
                                                                <?php
                                                                foreach ($metas as $key => $value) {
                                                                    echo '<li class="h5">' . $key . " : " . $value . "</li>\n";
                                                                }
                                                                ?>
                                                            </ul>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php } ?>
                                    </td>
                                    <td class="ltr"><?= date('Y/ m/ d | H:i a', $order->create_date); ?></td>
                                    <td><?= $order->status_name; ?></td>
                                    <td class="form-group w200" colspan="4">
                                        <?php
                                        if (!$order->status) {
                                            echo '<a class="btn btn-xs btn-warning" type="button" data-toggle="tooltip" data-original-title="غير مؤكد"><i class="fa fa-ban"></i></a>';
                                        } elseif ($order->status == 1) {
                                            echo '<a class="btn btn-xs btn-success" type="button" data-toggle="tooltip" data-original-title="مؤكد"><i class="fa fa-check"></i></a>';
                                        } elseif ($order->status == 3) {
                                            echo '<a class="btn btn-xs btn-info" type="button" data-toggle="tooltip" data-original-title="في الانتظار"><i class="fa fa-clock-o"></i></a>';
                                        } elseif ($order->status == 4) {
                                            echo '<a class="btn btn-xs btn-default" type="button" data-toggle="tooltip" data-original-title="ملغاه"><i class="fa fa-close"></i></a>';
                                        }
                                        ?>
                                        <a href="<?= ADMINURL . '/orders/show/' . $order->order_id; ?>" class="btn btn-xs btn-success" data-placement="top" data-toggle="tooltip" data-original-title="عرض"><i class="fa fa-eye"></i></a>
                                        <a href="<?= ADMINURL . '/orders/edit/' . $order->order_id; ?>" class="btn btn-xs btn-primary" data-placement="top" data-toggle="tooltip" data-original-title="تعديل"><i class="fa fa-edit"></i></a>
                                        <a href="<?= ADMINURL . '/orders/delete/' . $order->order_id; ?>" class="btn btn-xs btn-danger" data-placement="top" data-toggle="tooltip" data-original-title="حذف" onclick="return confirm('Are you sure?') ? true : false"><i class="fa fa-trash-o"></i></a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                            <tr class="tab-selected">
                                <th></th>
                                <th class="column-title" colspan="4"> العدد الكلي : <?= $data['recordsCount']; ?> </th>
                                <th class="column-title" colspan="6"> عرض
                                    <select name="perpage" onchange="if (this.value)
                                                window.location.href = '<?= ADMINURL . '/orders/index/' . $data['current']; ?>' + '/' + this.value">
                                        <option value="10" <?= ($data['perpage'] == 10) ? 'selected' : null; ?>>10 </option>
                                        <option value="50" <?= ($data['perpage'] == 50) ? 'selected' : null; ?>>50 </option>
                                        <option value="100" <?= ($data['perpage'] == 100) ? 'selected' : null; ?>>100 </option>
                                        <option value="200" <?= ($data['perpage'] == 200) ? 'selected' : null; ?>>200 </option>
                                        <option value="500" <?= ($data['perpage'] == 500) ? 'selected' : null; ?>>500 </option>
                                        <option value="1000" <?= ($data['perpage'] == 1000) ? 'selected' : null; ?>>1000 </option>
                                    </select>
                                </th>
                                <th class="column-title" colspan="4"> </th>
                                <th class="column-title no-link last"></th>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <ul class="pagination text-center">
                    <?php
                    pagination($data['recordsCount'], $data['current'], $data['perpage'], 4, ADMINURL . '/orders');
                    ?>
                </ul>
            </form>
        </div>
    </div>
</div>
<?php
// loading  plugin

$data['footer'] = '<script src="' . ADMINURL . '/template/default/vendors/select2/dist/js/select2.full.min.js"></script>
<script src="' . ADMINURL . '/template/default/vendors/jquery.tagsinput/src/jquery.tagsinput.js"></script>
<script> $(".select2").select2({dir: "rtl"});
</script>';

require ADMINROOT . '/views/inc/footer.php';
?>
<script>
    var fixmeTop = $('.fixme').offset().top;
    $(window).scroll(function() {
        var currentScroll = $(window).scrollTop();
        if (currentScroll >= fixmeTop) {
            $('.fixme').css({
                position: 'fixed',
                top: '0',
                zIndex: '10'
            });
        } else {
            $('.fixme').css({
                position: 'static'
            });
        }
    });
</script>