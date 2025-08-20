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
    <?php flash('donation_msg'); ?>
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
                <div class="row">
                    <div class="col-xs-6 form-group"><span class="title"> رقم الطلب :</span><input type="search" class="form-control" placeholder="رقم الطلب" name="search[order]" value=""></div>
                    <div class="col-xs-6 form-group"><span class="title"> الاجمالي :</span><input type="search" class="form-control" placeholder="بحث الاجمالي" name="search[total]" value=""></div>
                    <div class="col-xs-6 form-group"><span class="title">بالنوع :</span><input type="search" class="form-control" placeholder="بحث بالنوع" name="search[donation_type]" value=""></div>
                    <div class="col-xs-3 form-group"><span class="title">القيمة من :</span><input type="search" class="form-control" placeholder="بحث بالقيمة" name="search[amount_from]" value=""></div>
                    <div class="col-xs-3 form-group"><span class="title">القيمة الي :</span><input type="search" class="form-control" placeholder="بحث بالقيمة" name="search[amount_to]" value=""></div>
                    <div class="col-xs-3 form-group"><span class="title"> التاريخ من :</span><input type="date" class="form-control" placeholder="التاريخ من" name="search[date_from]" value=""></div>
                    <div class="col-xs-3 form-group"><span class="title"> التاريخ الي :</span><input type="date" class="form-control" placeholder=" الي" name="search[date_to]" value=""></div>                  
                    <div class="col-xs-6 form-group"><span class="title">بحث بالمشروع :</span>
                        <select class="form-control select2" name="search[projects][]" multiple="multiple" style="width: 100%;">
                            <?php foreach ($data['projects'] as $project) {
                                echo '<option value="' . $project->project_id . '" >' . $project->name . '</option>';
                            } ?>
                        </select>
                    </div>
                    <div class="col-xs-12 form-group"><input type="submit" name="search[submit]" value="بحث" class="btn btn-sm btn-primary search-query" /></div>
                </div>
                <div class="table-responsive">
                    <table class="table table-striped jambo_table bulk_action">
                        <thead>
                            <tr class="headings">
                                <th>
                                    <input type="checkbox" id="check-all" class="flat">
                                </th>
                                <th class="column-title">رقم الطلب </th>
                                <th class="column-title">القيمة </th>
                                <th class="column-title">العدد </th>
                                <th class="column-title">الاجمالي </th>
                                <th class="column-title">النوع </th>
                                <th class="column-title">المشروع </th>
                                <th class="column-title">تاريخ التبرع </th>
                                <th class="column-title">آخر تحديث </th>
                                <th class="column-title no-link last" width="140"><span class="nobr">اجراءات</span></th>
                                <th class="bulk-actions" colspan="9">
                                    <span> تنفيذ علي الكل :</span>
                                    <input type="submit" name="delete" value="حذف" onclick="return confirm('Are you sure?') ? true : false" class="btn btn-danger btn-xs" />
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($data['donations'] as $donation) : ?>
                                <tr class="even pointer">
                                    <td class="a-center ">
                                        <input type="checkbox" class="records flat" name="record[]" value="<?php echo $donation->donation_id; ?>">
                                    </td>
                                    <td><a href="<?php echo ADMINURL . '/orders/show/' . $donation->order_id; ?>"><?php echo $donation->order; ?></a></td>
                                    <td><?php echo $donation->amount; ?></td>
                                    <td><?php echo $donation->quantity; ?></td>
                                    <td><?php echo $donation->total; ?></td>
                                    <td><?php echo $donation->donation_type; ?></td>
                                    <td><?php echo $donation->project; ?></td>
                                    <td class="ltr"><?php echo date('Y/ m/ d | H:i a', $donation->create_date); ?></td>
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
                                <th class="column-title" colspan="4"> العدد الكلي : <?php echo $data['recordsCount']; ?> </th>
                                <th class="column-title" colspan="3"> عرض
                                    <select name="perpage" onchange="if (this.value)
                                                window.location.href = '<?php echo ADMINURL . '/donations/index/' . $data['current']; ?>' + '/' + this.value">
                                        <option value="10" <?php echo ($data['perpage'] == 10) ? 'selected' : null; ?>>10 </option>
                                        <option value="50" <?php echo ($data['perpage'] == 50) ? 'selected' : null; ?>>50 </option>
                                        <option value="100" <?php echo ($data['perpage'] == 100) ? 'selected' : null; ?>>100 </option>
                                        <option value="200" <?php echo ($data['perpage'] == 200) ? 'selected' : null; ?>>200 </option>
                                        <option value="500" <?php echo ($data['perpage'] == 500) ? 'selected' : null; ?>>500 </option>
                                        <option value="1000" <?php echo ($data['perpage'] == 1000) ? 'selected' : null; ?>>1000 </option>
                                    </select>
                                </th>
                                <th class="column-title" colspan=""> </th>
                                <th class="column-title no-link last"></th>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <ul class="pagination text-center">
                    <?php
                    pagination($data['recordsCount'], $data['current'], $data['perpage'], 4, ADMINURL . '/donations');
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
<script> $(".select2").select2({dir: "rtl"});</script>';

require ADMINROOT . '/views/inc/footer.php';
?>