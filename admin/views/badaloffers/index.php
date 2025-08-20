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
    <?php flash('badaloffer_msg'); ?>
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
                    <div class="col-xs-6 form-group"><span class="title">بحث بالمتطوع :</span>
                        <select class="form-control" name="search[substitute_id]" style="width: 100%;">
                            <option value=""></option>
                            <?php foreach ($data['substitutes'] as $substitute) {
                                echo '<option value="' . $substitute->substitute_id . '" >' . $substitute->full_name . '</option>';
                            } ?>
                        </select>
                    </div>
                    <div class="col-xs-6 form-group"><span class="title">بحث بالمشروع :</span>
                        <select class="form-control select2" name="search[projects][]" multiple="multiple" style="width: 100%;">
                            <?php foreach ($data['projects'] as $project) {
                                echo '<option value="' . $project->project_id . '" >' . $project->name . '</option>';
                            } ?>
                        </select>
                    </div>
                    <div class="col-md-12">
                    </div>
                    <div class="col-md-3 col-xs-3 form-group"><span class="title">القيمة من :</span><input type="search" class="form-control" placeholder="بحث بالقيمة" name="search[amount_from]" value=""></div>
                    <div class="col-md-3 col-xs-3 form-group"><span class="title">القيمة الي :</span><input type="search" class="form-control" placeholder="بحث بالقيمة" name="search[amount_to]" value=""></div>
                    <div class="col-md-3 col-xs-3 form-group"><span class="title"> التاريخ من :</span><input type="date" class="form-control" placeholder="التاريخ من" name="search[date_from]" value=""></div>
                    <div class="col-md-3 col-xs-3 form-group"><span class="title"> التاريخ الي :</span><input type="date" class="form-control" placeholder=" الي" name="search[date_to]" value=""></div>                  
               
                    <div class="col-xs-3 form-group"><span class="title">بحث بالحالة :</span>
                        <select class="form-control" name="search[status]" style="width: 100%;">
                        <option value=""></option>
                        <option value="pendding">غير مؤكد</option>
                        <option value="1">مؤكد</option>
                        <option value="4">ملغاه</option>
                           
                        </select>
                    </div>
                    <div class="col-xs-3 form-group"><input type="submit" name="search[submit]" value="بحث" class="btn btn-sm btn-primary search-query" style="margin-top: 7%;" /></div>
               
                </div>
                <div class="table-responsive">
                    <table class="table table-striped jambo_table bulk_action">
                        <thead>
                            <tr class="headings">
                                <th>
                                    <input type="checkbox" id="check-all" class="flat">
                                </th>
                                <th class="column-title">رقم العرض </th>
                                <th class="column-title">المشروع </th>
                                <th class="column-title">المتطوع </th>
                                <th class="column-title">القيمه </th>
                                <th class="column-title">بداء من </th>
                                <th class="column-title">تاريخ التبرع </th>
                                <th class="column-title">آخر تحديث </th>
                                <th class="column-title no-link last" width="140"><span class="nobr">اجراءات</span></th>
                                <th class="bulk-actions" colspan="9">
                                    <span> تنفيذ علي الكل :</span>
                                    <input type="submit" name="publish" value="تأكد" class="btn btn-success btn-xs" />
                                    <input type="submit" name="unpublish" value="تعليق" class="btn btn-warning btn-xs" />
                                    <input type="submit" name="canceled" value="الغاء" class="btn btn-default btn-xs" />
                                    <input type="submit" name="delete" value="حذف" onclick="return confirm('Are you sure?') ? true : false" class="btn btn-danger btn-xs" />
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($data['badaloffers'] as $badaloffer) : ?>
                                <tr class="even pointer">
                                    <td class="a-center ">
                                        <input type="checkbox" class="records flat" name="record[]" value="<?php echo $badaloffer->offer_id; ?>">
                                    </td>
                                    <td><?php echo $badaloffer->offer_id; ?></td>
                                    <td><?php echo $badaloffer->project; ?></td>
                                    <td><?php echo $badaloffer->substitute_name; ?></td>
                                    <td><?php echo $badaloffer->amount; ?></td>
                                    <td class="ltr"><?php echo $badaloffer->start_at ? date('Y/ m/ d | H:i a', $badaloffer->start_at) : ""; ?></td>
                                    <td class="ltr"><?php echo date('Y/ m/ d | H:i a', $badaloffer->create_date); ?></td>
                                    <td class="ltr"><?php echo date('Y/ m/ d | H:i a', $badaloffer->modified_date); ?></td>
                                    <td class="form-group">
                                    <?php
                                        if (!$badaloffer->status) {
                                            echo '<a class="btn btn-xs btn-warning" type="button" data-toggle="tooltip" data-original-title="غير منشور"><i class="fa fa-ban"></i></a>';
                                        } elseif ($badaloffer->status == 1) {
                                            echo '<a class="btn btn-xs btn-success" type="button" data-toggle="tooltip" data-original-title="منشور"><i class="fa fa-check"></i></a>';
                                        }elseif ($badaloffer->status == 4) {
                                            echo '<a class="btn btn-xs btn-default" type="button" data-toggle="tooltip" data-original-title="منشور"><i class="fa fa-close"></i></a>';
                                        }
                                        ?>
                                        <a href="<?php echo ADMINURL . '/badaloffers/show/' . $badaloffer->offer_id; ?>" class="btn btn-xs btn-primary" data-placement="top" data-toggle="tooltip" data-original-title="عرض" ><i class="fa fa-edit"></i></a>
                                        <a href="<?php echo ADMINURL . '/badaloffers/delete/' . $badaloffer->offer_id; ?>" class="btn btn-xs btn-danger" data-placement="top" data-toggle="tooltip" data-original-title="حذف" onclick="return confirm('Are you sure?') ? true : false"><i class="fa fa-trash-o"></i></a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>

                            <tr class="tab-selected">
                                <th></th>
                                <th class="column-title" colspan="4"> العدد الكلي : <?php echo $data['recordsCount']; ?> </th>
                                <th class="column-title" colspan="3"> عرض
                                    <select name="perpage" onchange="if (this.value)
                                                window.location.href = '<?php echo ADMINURL . '/badaloffers/index/' . $data['current']; ?>' + '/' + this.value">
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
                    pagination($data['recordsCount'], $data['current'], $data['perpage'], 4, ADMINURL . '/badaloffers');
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