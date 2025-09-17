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
    <?php flash('badalreview_msg'); ?>
    <div class="page-title">
        <div class="title_right">
            <h3><?php echo $data['title']; ?> <small>عرض كافة <?php echo $data['title']; ?> </small></h3>
        </div>
        <div class="title_left">
            <a href="<?php echo ADMINURL; ?>/substitutes" class="btn btn-success pull-left">عودة <i class="fa fa-reply"></i></a>
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
                                <th>
                                    <input type="checkbox" id="check-all" class="flat">
                                </th>
                                <th class="column-title">رقم  </th>
                                <th class="column-title">العمليه </th>
                                <!-- <th class="column-title">تقيم من خلال  </th> -->
                                <!-- <th class="column-title"> رقم  </th> -->
                                <th class="column-title"> النسبة </th>
                                <th class="column-title"> وصف </th>
                                <th class="column-title">تاريخ الطلب </th>
                                <th class="column-title no-link last" width="140"><span class="nobr">اجراءات</span></th>
                                <th class="bulk-actions" colspan="9">
                                    <span> تنفيذ علي الكل :</span>
                                    <input type="submit" name="delete" value="حذف" onclick="return confirm('Are you sure?') ? true : false" class="btn btn-danger btn-xs" />
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($data['badalreviews'] as $badalreview) : ?>
                                <tr class="even pointer">
                                    <td class="a-center ">
                                        <input type="checkbox" class="records flat" name="record[]" value="<?php echo $badalreview->review_id; ?>">
                                    </td>
                                    <td><?php echo $badalreview->review_id; ?></td>
                                    <td><?php  echo '<a href="' . ADMINURL . '/badalorders/show/' . $badalreview->badal_id . '" >'. $badalreview->badal_id .'</a>';?></td>
                                    <!-- <td><?php echo $badalreview->type == "donor"? "طالب الخدمة" : "مقدمي الخدمة"; ?></td> -->
                                    <!-- <td><?php echo $badalreview->type_id; ?></td> -->
                                    <td> <span class="stars-container stars-<?= ($badalreview->rate / 5) * 100 ?>">★★★★★</span> </td>
                                    <td><?php echo $badalreview->description; ?></td>
                                    <td class="ltr"><?php echo date('Y/ m/ d | H:i a', $badalreview->create_date); ?></td>
                                    <td class="form-group">
                                        <a href="<?php echo ADMINURL . '/BadalReviews/show/' . $badalreview->review_id; ?>" class="btn btn-xs btn-primary"> عرض </a>
                                        <a href="<?php echo ADMINURL . '/SubstituteRates/delete/' . $badalreview->review_id; ?>" class="btn btn-xs btn-danger" data-placement="top" data-toggle="tooltip" data-original-title="حذف" onclick="return confirm('Are you sure?') ? true : false"><i class="fa fa-trash-o"></i></a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>

                            <tr class="tab-selected">
                                <th></th>
                                <th class="column-title" colspan="4"> العدد الكلي : <?php echo count($data['badalreviews']); ?> </th>
                                <th class="column-title" colspan="3"> عرض
                                </th>
                                <th class="column-title" colspan=""> </th>
                                <th class="column-title no-link last"></th>
                            </tr>
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