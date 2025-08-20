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
            <h3><?php echo $data['title']; ?> <small>عرض كافة <?php echo $data['title']; ?> </small></h3>
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

                            <tr class=" form-group-sm">
                                <th width="70px"> <input type="submit" name="search[submit]" value="بحث" class="btn btn-sm btn-primary search-query"/> </th>
                                <th>
                                    <select class="form-control" name="search[status]">
                                        <option value="">حاله الطلب</option>
                                        <option value="1"> تأكيد </option>
                                        <option value="5"> تعليق</option>
                                    </select>
                                </th>
                                <th class="" colspan="5"></th>
                                <th>
                                    <input type="submit" name="exportGifted" value="Export all" class="btn btn-success btn-xs" />
                                </th>
                            </tr>

                            <tr class="headings orders">
                                <th>
                                    <input type="checkbox" id="check-all" class="flat">
                                </th>
                                <th class="column-title">معرف التبرع </th>
                                <th class="column-title">اسم المهدي اليه </th>
                                <th class="column-title">رقم الجوال </th>
                                <th class="column-title">البريد الالكتروني</th>
                                <th class="column-title">الفئة</th>
                                <th class="column-title">كارت الاهداء</th>
                                <th class="column-title">تاريخ الاهداء</th>
                                <th class="bulk-actions" colspan="7">
                                    <input type="submit" name="export" value="Excel" class="btn btn-success btn-xs" />
                                </th>
                            </tr>

                        </thead>
                        <tbody>
                            <?php
                            foreach ($data['orders'] as $order) :
                                $order->gift_data = json_decode($order->gift_data);
                            ?>
                                <tr class="even pointer">
                                    <td class="a-center ">
                                        <input type="checkbox" class="records flat" name="record[]" value="<?php echo $order->order_id; ?>">
                                    </td>
                                    <td><?php echo $order->order_identifier; ?></td>
                                    <td><?php echo $order->gift_data->giver_name; ?></td>
                                    <td><?php echo $order->gift_data->giver_number; ?></td>
                                    <td><?php @printIsset($order->gift_data->giver_email); ?></td>
                                    <td><?php echo $order->gift_data->giver_group; ?></td>
                                    <td>
                                        <a href="<?php echo MEDIAFOLDER . $order->gift_data->card; ?>" target="_blank">
                                            <img src="<?php echo MEDIAFOLDER . $order->gift_data->card; ?>" width="60">
                                        </a>
                                    </td>
                                    <td class="ltr"><?php echo date('Y/ m/ d | H:i a', $order->create_date); ?></td>
                                </tr>
                            <?php endforeach; ?>
                            <tr class="tab-selected">
                                <th></th>
                                <th class="column-title" colspan="2"> العدد الكلي : <?php echo $data['recordsCount']; ?> </th>
                                <th class="column-title" colspan=""> عرض
                                    <select name="perpage" onchange="if (this.value)
                                                window.location.href = '<?php echo ADMINURL . '/gifted/index/' . $data['current']; ?>' + '/' + this.value">
                                        <option value="10" <?php echo ($data['perpage'] == 10) ? 'selected' : null; ?>>10 </option>
                                        <option value="50" <?php echo ($data['perpage'] == 50) ? 'selected' : null; ?>>50 </option>
                                        <option value="100" <?php echo ($data['perpage'] == 100) ? 'selected' : null; ?>>100 </option>
                                        <option value="200" <?php echo ($data['perpage'] == 200) ? 'selected' : null; ?>>200 </option>
                                        <option value="500" <?php echo ($data['perpage'] == 500) ? 'selected' : null; ?>>500 </option>
                                        <option value="1000" <?php echo ($data['perpage'] == 1000) ? 'selected' : null; ?>>1000 </option>
                                    </select>
                                </th>
                                <th class="column-title" colspan="3"> </th>
                                <th class="column-title no-link last"></th>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <ul class="pagination text-center">
                    <?php
                    pagination($data['recordsCount'], $data['current'], $data['perpage'], 4, ADMINURL . '/gifted');
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