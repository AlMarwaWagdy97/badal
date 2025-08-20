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
$data['header'] = '';

require ADMINROOT . '/views/inc/header.php';
?>

<!-- page content -->

<div class="right_col" role="main">
    <div class="clearfix"></div>
    <?php flash('donor_msg'); ?>
    <div class="page-title">
        <div class="title_right">
            <h3><?php echo $data['title']; ?> <small>عرض كافة <?php echo $data['title']; ?> </small></h3>
        </div>
        <div class="title_left">
            <a href="<?php echo ADMINURL; ?>/donors/add" class="btn btn-success pull-left">اضف جديد <i class="fa fa-plus"></i></a>
        </div>
    </div>

    <div class="clearfix"></div>

    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">

            <form action="" method="post">
                <div class="table-responsive">
                    <table class="table table-striped jambo_table bulk_action">
                        <thead>
                            <tr class=" form-group-sm">
                                <th colspan="1"><input type="submit" name="search[submit]" value="بحث" class="btn btn-sm btn-primary" /></th>
                                <th class=""><input type="search" placeholder="بحث بالأسم " class="form-control" name="search[full_name]" value="<?= @printIsset($_SESSION['search']['full_name']) ?>"></th>
                                <th class=""><input type="search" placeholder="بحث برقم الجوال" class="form-control" name="search[mobile]" value="<?= @printIsset($_SESSION['search']['mobile']) ?>"></th>
                                <th class="" colspan="1"></th>
                                <th class=""><input type="search" placeholder="بحث بالايميل" class="form-control" name="search[email]" value="<?= @printIsset($_SESSION['search']['email']) ?>"></th>
                                <th class="column-title">
                                    تاريخ التسجيل 
                                    <input type="date" placeholder=" من" name="search[date_from]" value="<?php if (returnIsset(cleanSearchVar('date_from'))) echo date('Y-m-d', returnIsset(cleanSearchVar('date_from'))); ?>" class="">
                                    <input type="date" placeholder=" الي" name="search[date_to]" value="<?php if (returnIsset(cleanSearchVar('date_to'))) echo date('Y-m-d', (int) returnIsset(cleanSearchVar('date_to')) - 86400); ?>" class="">
                                </th>
                                <th width="145px">
                                    <select class="form-control" name="search[status]">
                                        <option value="">الحالة</option>
                                        <option value="1">نشط </option>
                                        <option value="0">معلق</option>
                                    </select>
                                </th>
                                <th class="" colspan="2"><button type="submit" name="exportAll" id="exportAll" class="btn btn-sm btn-success">استخرج</button></th>
                            </tr>
                            <tr class="headings">
                                <th>
                                    <input type="checkbox" id="check-all" class="flat">
                                </th>
                                <th class="column-title">اسم المتبرع </th>
                                <th class="column-title">رقم الجوال </th>
                                <th class="column-title">رقم الهوية </th>
                                <th class="column-title">الجوال مؤكد </th>
                                <th class="column-title">البريد الالكتروني </th>
                                <th class="column-title">تاريخ التسجيل </th>
                                <th class="column-title">آخر تحديث </th>
                                <th class="column-title no-link last"><span class="nobr">اجراءات</span>
                                </th>
                                <th class="bulk-actions" colspan="9">
                                    <span> تنفيذ علي الكل :</span>
                                    <input type="submit" name="publish" value="Publish" class="btn btn-success btn-xs" />
                                    <input type="submit" name="unpublish" value="Unpublish" class="btn btn-warning btn-xs" />
                                    <input type="submit" name="delete" value="حذف" onclick="return confirm('Are you sure?') ? true : false" class="btn btn-danger btn-xs" />
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($data['donors'] as $donor) : ?>
                                <tr class="even pointer">
                                    <td class="a-center ">
                                        <input type="checkbox" class="records flat" name="record[]" value="<?php echo $donor->donor_id; ?>">
                                    </td>
                                    <td class=" "><?php echo $donor->full_name; ?></td>
                                    <td class="ltr "><?php echo $donor->mobile; ?></i></td>
                                    <td class="ltr "><?php echo $donor->identity; ?></i></td>
                                    <td class=" "><?php echo $donor->mobile_confirmed; ?></i></td>
                                    <td class=" "><?php echo $donor->email; ?></i></td>
                                    <td class="ltr"><?php echo date('Y/ m/ d | H:i a', $donor->create_date); ?></td>
                                    <td class="ltr"><?php echo date('Y/ m/ d | H:i a', $donor->modified_date); ?></td>
                                    <td class="form-donor">
                                        <?php
                                        if (!$donor->status) {
                                            echo '<a href="' . ADMINURL . '/donors/publish/' . $donor->donor_id . '" class="btn btn-xs btn-warning" type="button" data-toggle="tooltip" data-original-title="معطلة"><i class="fa fa-ban"></i></a>';
                                        } elseif ($donor->status == 1) {
                                            echo '<a href="' . ADMINURL . '/donors/unpublish/' . $donor->donor_id . '" class="btn btn-xs btn-success" type="button" data-toggle="tooltip" data-original-title="مفعلة"><i class="fa fa-check"></i></a>';
                                        }
                                        ?>
                                        <a href="<?php echo ADMINURL . '/donors/show/' . $donor->donor_id; ?>" class="btn btn-xs btn-success" data-placement="top" data-toggle="tooltip" data-original-title="عرض"><i class="fa fa-eye"></i></a>
                                        <a href="<?php echo ADMINURL . '/donors/edit/' . $donor->donor_id; ?>" class="btn btn-xs btn-primary" data-placement="top" data-toggle="tooltip" data-original-title="تعديل"><i class="fa fa-edit"></i></a>
                                        <a href="<?php echo ADMINURL . '/donors/delete/' . $donor->donor_id; ?>" class="btn btn-xs btn-danger" data-placement="top" data-toggle="tooltip" data-original-title="حذف" onclick="return confirm('Are you sure?') ? true : false"><i class="fa fa-trash-o"></i></a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>

                            <tr class="tab-selected">
                                <th class="column-title" colspan="5"> العدد الكلي : <?php echo $data['recordsCount']; ?> </th>
                                <th class="column-title"> عرض
                                    <select name="perpage" onchange="if (this.value)
                                                window.location.href = '<?php echo ADMINURL . '/donors/index/' . $data['current']; ?>' + '/' + this.value">
                                        <option value="10" <?php echo ($data['perpage'] == 10) ? 'selected' : null; ?>>10 </option>
                                        <option value="50" <?php echo ($data['perpage'] == 50) ? 'selected' : null; ?>>50 </option>
                                        <option value="100" <?php echo ($data['perpage'] == 100) ? 'selected' : null; ?>>100 </option>
                                        <option value="200" <?php echo ($data['perpage'] == 200) ? 'selected' : null; ?>>200 </option>
                                        <option value="500" <?php echo ($data['perpage'] == 500) ? 'selected' : null; ?>>500 </option>
                                        <option value="1000" <?php echo ($data['perpage'] == 1000) ? 'selected' : null; ?>>1000 </option>
                                    </select>
                                </th>
                                <th class="column-title" colspan="1"> </th>
                                <th class="column-title no-link last"></th>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <ul class="pagination text-center">
                    <?php
                    pagination($data['recordsCount'], $data['current'], $data['perpage'], 4, ADMINURL . '/donors');
                    ?>
                </ul>


            </form>

        </div>
    </div>
</div>
<?php
// loading  plugin
$data['footer'] = '';

require ADMINROOT . '/views/inc/footer.php';


