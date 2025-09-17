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
    <?php flash('badalrequest_msg'); ?>
    <div class="page-title">
        <div class="title_right">
            <h3><?php echo $data['title']; ?> <small>عرض كافة <?php echo $data['title']; ?> </small></h3>
        </div>
        <div class="title_left">
        </div>
    </div>
    <div class="clearfix"></div>
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <form action="" method="post">
                <div class="table-responsive">
                    <table class="table table-striped jambo_table bulk_action">
                        <thead>
                            <tr class="headings">
                                <!-- <th>
                                    <input type="checkbox" id="check-all" class="flat">
                                </th> -->
                                <th class="column-title">رقم العرض </th>
                                <th class="column-title">العمليه </th>
                                <th class="column-title">المقدمي الخدمة </th>
                                <th class="column-title">بداء من </th>
                                <th class="column-title">تم اختياره؟ </th>
                                <th class="column-title">تاريخ الطلب </th>
                                <th class="column-title">آخر تحديث </th>
                                <!-- <th class="column-title no-link last" width="140"><span class="nobr">اجراءات</span></th> -->
                                <!-- <th class="bulk-actions" colspan="9">
                                    <span> تنفيذ علي الكل :</span>
                                    <input type="submit" name="delete" value="حذف" onclick="return confirm('Are you sure?') ? true : false" class="btn btn-danger btn-xs" />
                                </th> -->
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($data['badalrequests'] as $badalrequest) : ?>
                                <tr class="even pointer">
                                    <!-- <td class="a-center ">
                                        <input type="checkbox" class="records flat" name="record[]" value="<?php echo $badalrequest->request_id; ?>">
                                    </td> -->
                                    <td><?php echo $badalrequest->request_id; ?></td>
                                    <td><?php  echo '<a href="' . ADMINURL . '/badalorders/show/' . $badalrequest->badal_id . '" >'. $badalrequest->badal_id .'</a>';?></td>
                                    <td><?php echo $badalrequest->substitute_name; ?></td>
                                    <td class="ltr"><?php echo $badalrequest->start_at ? date('Y/ m/ d | H:i a', $badalrequest->start_at) : ""; ?></td>
                                    <td class="ltr"><?php echo $badalrequest->is_selected ?'<a class="btn btn-xs btn-success" type="button" data-toggle="tooltip" data-original-title="اختار"><i class="fa fa-check"></i></a>' : '<a class="btn btn-xs btn-warning" type="button" data-toggle="tooltip" data-original-title="ملغي"><i class="fa fa-ban"></i></a>'; ?></td>
                                    <td class="ltr"><?php echo date('Y/ m/ d | H:i a', $badalrequest->create_date); ?></td>
                                    <td class="ltr"><?php echo date('Y/ m/ d | H:i a', $badalrequest->modified_date); ?></td>
                                    <!-- <td class="form-group">
                                        <a href="<?php echo ADMINURL . '/badalRequests/delete/' . $badalrequest->request_id; ?>" class="btn btn-xs btn-danger" data-placement="top" data-toggle="tooltip" data-original-title="حذف" onclick="return confirm('Are you sure?') ? true : false"><i class="fa fa-trash-o"></i></a>
                                    </td> -->
                                </tr>
                            <?php endforeach; ?>

                            
                        </tbody>
                    </table>
                </div>
                
            </form>
        </div>
    </div>
</div>
<?php
// loading  plugin

$data['footer'] = '<script src="' . ADMINURL . '/template/default/vendors/select2/dist/js/select2.full.min.js"></script>
<script src="' . ADMINURL . '/template/default/vendors/jquery.tagsinput/src/jquery.tagsinput.js"></script>
<script> $(".select2").select2({dir: "rtl"});</script>';

require ADMINROOT . '/views/inc/footer.php';
?>