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
    <?php flash('order_msg'); ?>
    <div class="page-title">
        <div class="title_right">
            <h3><?php echo $data['page_title']; ?> <small>عرض محتوي التقرير </small></h3>
        </div>
        <div class="title_left">
            <a href="<?php echo ADMINURL; ?>/reports" class="btn btn-success pull-left">عودة <i class="fa fa-reply"></i></a>
            <button id="btnExport" class="btn btn-success pull-left"> استخراج كا اكسل </button>
        </div>
    </div>
    <div class="clearfix"></div>
    <div class="row">
        <div class="table-responsive">
            <table class="table table-striped jambo_table bulk_action">
                <thead>
                    <tr class="headings">
                        <th>اسم المشروع</th>
                        <th>المتجر</th>
                        <th>معرف الطلب </th>
                        <th> اسم طالب الخدمة </th>
                        <th> رقم الجوال </th>
                        <th> البريد الالكتروني </th>
                        <th>القيمة</th>
                        <th>الاجمالي</th>
                        <th>وسيلة الدفع</th>
                        <th>تأكيد الدفع</th>
                        <th>رد بايفورت</th>
                        <th>merchant_reference</th>
                        <th>اهداء</th>
                        <th>الحالة</th>
                        <th>حالة الطلب</th>
                        <th>تاريخ الطلب </th>
                        <th>آخر تحديث </th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($data['orders'] as $order) : ?>
                        <tr class="even pointer">
                            <td><?php echo $order->projects; ?></td>
                            <td><?php echo $order->store; ?></td>
                            <td><?php echo $order->order_identifier; ?></td>
                            <td><?php echo $order->donor; ?></td>
                            <td><?php echo $order->mobile; ?></td>
                            <td><?php echo $order->email; ?></td>
                            <td><?php echo $order->quantity; ?></td>
                            <td><?php echo $order->total; ?></td>
                            <td><?php echo $order->payment_method; ?></td>
                            <td><?php if (!empty($order->banktransferproof)) { ?>
                            <a class="btn btn-success" target="blank" href="<?php echo URLROOT . "/media/files/banktransfer/".$order->banktransferproof; ?>">تحميل</a><?php } ?></td>
                            <?php
                            if (!empty($order->meta)) {
                                $meta = json_decode($order->meta);
                                echo '<td>' . $meta->response_message . '</td>';
                                echo '<td>' . $meta->merchant_reference . '</td>';
                            } else {
                                echo "<td></td><td></td>";
                            }
                            ?>
                            <td><?php echo ($order->gift) ? "نعم" : "لا"; ?></td>
                            <td><?php echo $order->status_name; ?></td>
                            <td><?php echo ($order->status) ? "مؤكد" : "غير مؤكد";; ?></td>
                            <td class="ltr"><?php echo date('Y/ m/ d | H:i a', $order->create_date); ?></td>
                            <td class="ltr"><?php echo date('Y/ m/ d | H:i a', $order->modified_date); ?></td>

                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php
// loading plugin
$data['footer'] = '';
require ADMINROOT . '/views/inc/footer.php';
?>
<script>
    $("#btnExport").click(function(e) {
        window.open('data:application/vnd.ms-excel,' + encodeURIComponent($('.table-responsive').html()));

    });
</script>