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
            <h3><?php echo $data['page_title']; ?> <small>عرض محتوي التبرع </small></h3>
        </div>
        <div class="title_left">
            <a href="<?php echo ADMINURL; ?>/orders" class="btn btn-success pull-left">عودة <i class="fa fa-reply"></i></a>
        </div>
    </div>

    <div class="clearfix"></div>

    <div class="row">
        <div class="col-md-12 col-sm-12">
            <div class="form-group">
                <h3 class="prod_title">
                    <?php echo $data['order']->order_identifier; ?>
                </h3>
            </div>
            <div class="form-groupcol-xs-12">
                <label class="control-label">قيمة التبرع : </label>
                <p><?php echo $data['order']->total; ?></p>
            </div>
            <div class="form-groupcol-xs-12">
                <label class="control-label">وسيلة التبرع : </label>
                <p class="ltr"><?php echo $data['order']->title; ?></p>
            </div>
            <div class="form-groupcol-xs-12">
                <label class="control-label">اثبات التحويل : </label>
                <p><a href="<?php echo URLROOT . "/media/files/banktransfer/" . $data['order']->banktransferproof; ?>" target="_blank" class="btn btn-default">عرض </a></p>
            </div>
            <div class="form-groupcol-xs-12">
                <label class="control-label">مهدي خيريا :</label>
                <p><?php echo $data['order']->gift ? 'نعم' : 'لا'; ?></p>
                <p class="btn-default">
                    <h3 class="control-label">بيانات الاهداء :</h3>
                    <?php if ($data['order']->gift) {
                        $gift_data = json_decode($data['order']->gift_data);
                        foreach ($gift_data as $key => $value) {
                            if ($key == 'enable') {
                                continue;
                            }

                            echo "<label>" . $key . " :</label> " . $value . "<br>\n";
                        }
                    } ?>
                </p>
            </div>
            <div class="form-groupcol-xs-12">
                <h3 class="control-label">بيانات الدفع من خلال بايفورت : </h3>
                <p class=" btn-default"><?php
                                        if (!empty($data['order']->meta)) {
                                            $meta = json_decode($data['order']->meta);
                                            foreach ($meta as $key => $value) {
                                                echo "<label>" . $key . " :</label> " . $value . "<br>\n";
                                            }
                                        }
                                        ?></p>
            </div>
            <div class="form-groupcol-xs-12">
                <label class="control-label">اسم المتبرع : </label>
                <p><?php echo $data['order']->donor_id; ?></p>
            </div>
            <div class="form-groupcol-xs-12">
                <label class="control-label">حالة التبرع : </label>
                <p><?php echo $data['order']->status ? 'مؤكد' : 'غير مؤكد'; ?></p>
            </div>
            <div class="form-groupcol-xs-12">
                <label class="control-label">اخر تحديث : </label>
                <p><?php echo $data['order']->modified_date ? date('d/ M/ Y', $data['order']->modified_date) : 'لا'; ?></p>
            </div>
            <div class="form-groupcol-xs-12">
                <label class="control-label">وقت الإنشاء : </label>
                <p><?php echo $data['order']->create_date ? date('d/ M/ Y', $data['order']->create_date) : 'لا'; ?></p>
            </div>
            <div class="form-group">
                <label class="control-label">المشروعات المتبرع لها </label>
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
                            <?php 
                            $totalAmount = 0;
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
            <div class="form-group col-xs-12">
                <a class="btn btn-info" href="<?php echo ADMINURL . '/orders/edit/' . $data['order']->order_id; ?>">تعديل</a>
            </div>


        </div>
    </div>
</div>

<?php
// loading plugin
$data['footer'] = '';

require ADMINROOT . '/views/inc/footer.php';
