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
    <?php flash('contact_msg'); ?>
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
                        <th>اسم المتبرع </th>
                        <th>الهاتف</th>
                        <th>عنوان الرسالة</th>
                        <th>الغرض</th>
                        <th>المحتوي</th>
                        <th>البريد الالكتروني</th>
                        <th>الحالة </th>
                        <th>تاريخ التسجيل </th>
                        <th>آخر تحديث </th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($data['contact'] as $contact) : ?>
                        <tr class="even pointer">
                            <td><?php echo $contact->full_name; ?></td>
                            <td><?php echo $contact->phone; ?></td>
                            <td><?php echo $contact->subject; ?></td>
                            <td><?php echo $contact->type; ?></td>
                            <td><?php echo $contact->message; ?></td>
                            <td><?php echo $contact->email; ?></td>
                            <td><?php echo ($contact->status) ? "مقروء" : "غير مقروء"; ?></td>
                            <td class="ltr"><?php echo date('Y/ m/ d | H:i a', $contact->create_date); ?></td>
                            <td class="ltr"><?php echo date('Y/ m/ d | H:i a', $contact->modified_date); ?></td>
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