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
    <?php flash('confirmed_msg'); ?>
    <div class="page-title">
        <div class="title_right">
            <h3><?php echo $data['page_title']; ?> <small> عرض حمله المتوفي </small></h3>
        </div>
        <div class="title_left">
            <a href="<?php echo ADMINURL; ?>/deceaseds" class="btn btn-success pull-left">عودة <i class="fa fa-reply"></i></a>
        </div>
    </div>
    <div class="clearfix">
    </div>

    <div class="box" style="height: 100%;">
        <div class="box-body">
            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="col-lg-8 col-md-12 col-sm-12 col-xs-12">
                        <p for=""><span style="color: black;">الاسم : </span><?php echo $data['deceased']->name; ?></p>
                        <p for=""><span style="color: black;">رقم الجوال : </span><?php echo $data['deceased']->mobile; ?></p>
                        <p for=""><span style="color: black;">البريد الاكتروني : </span><?php echo $data['deceased']->email; ?></p>
                        <p for=""><span style="color: black;">المبلغ المتوقع : </span><?php echo $data['deceased']->target_price; ?></p>
                        <p for=""><span style="color: black;">اسم المتوفي : </span><?php echo $data['deceased']->deceased_name; ?></p>
                        <p for=""><span style="color: black;">صله القرابة : </span><?php echo $data['deceased']->relative_relation; ?></p>
                        <p for=""><span style="color: black;">الوصف : </span><?php echo $data['deceased']->description; ?></p>
                    </div>
                    <div class="col-lg-3 col-md-6 col-sm-12 col-xs-12">
                        <p for=""><span style="color: black;">صورة المتوفي : </span></p> <a href="<?php echo  URLROOT . "/media/files/deceased/" . $data['deceased']->deceased_image; ?>" target="_blank"> <img src="<?php echo  URLROOT . "/media/files/deceased/" . $data['deceased']->deceased_image; ?>" width="250px" alt=""> </a>
                    </div>
                    <!-- <div class="col-lg-3 col-md-6 col-sm-12 col-xs-12">
                        <p for=""><span style="color: black;">صوره الهوية : </span></p> <a href="<?php echo  URLROOT . "/media/files/deceased/" . $data['deceased']->image; ?>" target="_blank"> <img src="<?php echo  URLROOT . "/media/files/deceased/" . $data['deceased']->image; ?>" width="250px" alt=""> </a>
                    </div> -->
                </div>
                <hr>
            </div>
        </div>
    </div>

    <hr>
    <?php if ($data['deceased']->confirmed == 0) { ?>
        <a href="<?php echo ADMINURL ?>/deceaseds/edit/<?php echo $data['deceased']->deceased_id ?>" class="btn btn-success" style="margin-top: 1px;" type="button" data-toggle="tooltip" data-original-title="تأكيد">تأكيد</a>
    <?php } else { ?>

        <div class="projects">
            <h5>المشروع</h5>
            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="table-responsive table-custome">
                        <table class="table table-striped jambo_table bulk_action">
                            <thead>
                                <tr class="headings">
                                    <th class="column-title">اسم المشروع </th>
                                    <th class="column-title">رقم المشروع </th>
                                    <th class="column-title">القسم </th>
                                    <th class="column-title">المبلغ المستهدف </th>
                                    <th class="column-title"> الصوره الرئيسيه </th>
                                    <th class="column-title">الصوره الخارجيه </th>
                                    <th class="column-title"> الوصف </th>
                                    <th class="column-title">الظهور </th>
                                    <th class="column-title">الزيارات </th>
                                    <th class="column-title">الترتيب </th>
                                    <th class="column-title"> عرض </th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="even pointer">
                                    <td><a href="<?php echo URLROOT . '/projects/show/' . $data['project']->project_id; ?>" target="_blank"> <?php echo $data['project']->name; ?> <a /></td>
                                    <td><?php echo $data['project']->project_number; ?></td>
                                    <td><?php echo $data['project']->category; ?></td>
                                    <td><?php echo $data['project']->target_price; ?></td>
                                    <td>
                                        <?php if (!empty($data['project']->image)) :
                                            $galery = explode(',', $data['project']->image);
                                            foreach ($galery as $img) {
                                                $img = MEDIAURL . '/' . str_replace('&#34;', '', trim(trim($img, ']'), '['));
                                                echo
                                                ' <a href="' . $img . '" target="_blank">    <img src="' . $img . '" width="50" /></a> ';
                                            }
                                        endif; ?>

                                    </td>
                                    <td><a href="<?php echo empty($data['project']->secondary_image) ? MEDIAURL . '/default.jpg' : MEDIAURL . '/' . $data['project']->secondary_image; ?>" target="_blank"> <img class="img-responsive img-rounded" src="<?php echo empty($data['project']->secondary_image) ?: MEDIAURL . '/' . $data['project']->secondary_image; ?>" width="50" /></a></td>
                                    <td><?php echo ($data['project']->description) ?></td>
                                    <td><?php echo ($data['project']->hidden) ? 'مخفي' : 'ظاهر'; ?></td>
                                    <td><?php echo $data['project']->hits; ?></td>
                                    <td><?php echo $data['project']->arrangement; ?></td>
                                    <td width="200">
                                        <a href="<?php echo URLROOT . '/projects/show/' . $data['project']->project_id; ?>" class="btn btn-xs btn-success" data-placement="top" data-toggle="tooltip" data-original-title="الرابط" target="_blank"> <i class="fa fa-external-link"></i> </a>
                                        <?php
                                        if (!$data['project']->status) {
                                            echo '<a href="' . ADMINURL . '/projects/publish/' . $data['project']->project_id . '" class="btn btn-xs btn-warning" type="button" data-toggle="tooltip" data-original-title="غير منشور"><i class="fa fa-ban"></i></a>';
                                        } elseif ($data['project']->status == 1) {
                                            echo '<a href="' . ADMINURL . '/projects/unpublish/' . $data['project']->project_id . '" class="btn btn-xs btn-success" type="button" data-toggle="tooltip" data-original-title="منشور"><i class="fa fa-check"></i></a>';
                                        }
                                        ?>
                                        <?php
                                        if ($data['project']->featured == 1) {
                                            echo '<a href="' . ADMINURL . '/projects/unfeatured/' . $data['project']->project_id . '" class="btn btn-xs btn-warning" type="button" data-toggle="tooltip" data-original-title="مميز"><i class="fa fa-star"></i></a>';
                                        } elseif ($data['project']->featured == 0) {
                                            echo '<a href="' . ADMINURL . '/projects/featured/' . $data['project']->project_id . '" class="btn btn-xs btn-default" type="button" data-toggle="tooltip" data-original-title="غير مميز"><i class="fa fa-star"></i></a>';
                                        }
                                        ?>
                                        <a href="<?php echo ADMINURL . '/projects/show/' . $data['project']->project_id; ?>" class="btn btn-xs btn-success" style="margin-top:2px" data-placement="top" data-toggle="tooltip" data-original-title="عرض" target="_blank"><i class="fa fa-eye"></i></a>
                                        <a href="<?php echo ADMINURL . '/projects/edit/' . $data['project']->project_id; ?>" class="btn btn-xs btn-primary" style="margin-top:2px" data-placement="top" data-toggle="tooltip" data-original-title="تعديل" target="_blank"><i class="fa fa-edit"></i></a>

                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="orders">
            <h5>التبرعات</h5>
            <div class="table-responsive table-custome">
                <table class="table table-striped jambo_table bulk_action">
                    <thead class="fixme">
                        <tr class="headings">
                            <th class="column-title"> رقم التبرع </th>
                            <th class="column-title"> القيمه </th>
                            <th class="column-title">اسم المتبرع </th>
                            <th class="column-title"> اسم المستخدم </th>
                            <th class="column-title"> الجوال </th>
                            <th class="column-title"> المشروع </th>
                            <th class="column-title"> وسيله التبرع </th>
                            <th class="column-title">المصدر </th>
                            <th class="column-title">تاريخ التبرع </th>
                            <th class="column-title"> العمليات </th>
                            <th class="column-title"> </th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($data['orders'] as $order) : ?>
                            <tr class="even pointer">
                                <td><?php echo $order->order_identifier ?? ''; ?></td>
                                <td><?php echo $order->total ?? ''; ?></td>
                                <td><?php echo $order->donor_name ?? ''; ?></td>
                                <td><?php echo '<a class="text-warning" href="' . ADMINURL . '/donors/show/' . $order->donor_id . '">' . $order->donor . '</a>'; ?></td>
                                <td class="ltr"><?php echo @$order->mobile ?? '' ?? ""; ?></td>
                                <td><?php echo $order->projects ?? ''; ?></td>
                                <td><?php echo $order->payment_method ?? ''; ?></td>
                                <td><?= $order->app ?> </td>
                                <td class="ltr"><?php echo date('Y/ m/ d | H:i a', $order->create_date); ?></td>
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
                                    <a href="<?php echo ADMINURL . '/orders/show/' . $order->order_id; ?>" class="btn btn-xs btn-success" data-placement="top" data-toggle="tooltip" data-original-title="عرض"><i class="fa fa-eye"></i></a>
                                    <a href="<?php echo ADMINURL . '/orders/edit/' . $order->order_id; ?>" class="btn btn-xs btn-primary" data-placement="top" data-toggle="tooltip" data-original-title="تعديل"><i class="fa fa-edit"></i></a>
                                    <a href="<?php echo ADMINURL . '/orders/delete/' . $order->order_id; ?>" class="btn btn-xs btn-danger" data-placement="top" data-toggle="tooltip" data-original-title="حذف" onclick="return confirm('Are you sure?') ? true : false"><i class="fa fa-trash-o"></i></a>
                                </td>
                            </tr>

                        <?php endforeach; ?>
                        <tr class="even pointer">
                            <td colspan="5">عدد التبرعات : <?php echo $data['totalorders']->count ?></td>
                            <td colspan="6">المجموع الكلي: <?php echo $data['totalorders']->total ?> ريال</td>
                        </tr>

                    </tbody>
                </table>
            </div>
        </div>
        <br>
    <?php }  ?>





</div>

<?php


require ADMINROOT . '/views/inc/footer.php';
