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
    <?php flash('puzzel_msg'); ?>
    <div class="page-title">
        <div class="title_right">
            <h3><?php echo $data['title']; ?> <small>عرض كافة <?php echo $data['title']; ?> </small></h3>
        </div>
        <div class="title_left">
            <a href="<?php echo ADMINURL; ?>/puzzels/add" class="btn btn-success pull-left">انشاء جديد <i class="fa fa-plus"></i></a>
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
                                <th width="50px"></th>
                                <th width="70px"></th>
                                <th><input type="search" class="form-control" placeholder="بحث بالاسم" name="search[name]" value="<?php @print($_SESSION['search']['name']); ?>"></th>
                                <th colspan="2"><input type="search" class="form-control" placeholder="بحث بالوصف" name="search[description]" value="<?php @print($_SESSION['search']['description']); ?>"></th>
                                <th>
                                    <select class="form-control" name="search[status]">
                                        <option value=""></option>
                                        <option <?php if (@$_SESSION['search']['status'] == 1) echo 'selected'; ?> value="1">منشور </option>
                                        <option <?php if (@$_SESSION['search']['status'] == 0) echo 'selected'; ?> value="0"> غير منشور </option>
                                    </select>
                                </th>
                                <th>
                                    <input type="submit" name="search[submit]" value="بحث" class="btn btn-sm btn-primary search-query" />
                                    <a href="<?php echo ADMINURL; ?>/puzzels/" role="button" class="btn btn-sm btn-danger">مسح</a>
                                </th>
                            </tr>
                            <tr class="headings">
                                <th>
                                    <input type="checkbox" id="check-all" class="flat">
                                </th>
                                <th class="column-title">صورة </th>
                                <th class="column-title">العنوان </th>
                                <th class="column-title">الوصف </th>
                                <th class="column-title">تاريخ الانشاء </th>
                                <th class="column-title">آخر تحديث </th>
                                <th class="column-title no-link last"><span class="nobr">اجراءات</span></th>
                                <th class="bulk-actions" colspan="6">
                                    <span> تنفيذ علي الكل :</span>
                                    <input type="submit" name="publish" value="منشور" class="btn btn-success btn-xs" />
                                    <input type="submit" name="unpublish" value="غير منشور" class="btn btn-warning btn-xs" />
                                    <input type="submit" name="delete" value="حذف" onclick="return confirm('Are you sure?') ? true : false" class="btn btn-danger btn-xs" />
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ((object) $data['puzzels'] as $puzzel) : ?>
                                <tr class="even pointer <?php echo $puzzel->status ? '' : ' selected '; ?>">
                                    <td class="a-center">
                                        <input type="checkbox" class="records flat" name="record[]" value="<?php echo $puzzel->puzzel_id; ?>">
                                    </td>
                                    <td class="text-center">
                                        <a href="<?php echo URLROOT . "/media/files/puzzels/" . $puzzel->image; ?>" target="blank">
                                            <img src="<?php echo URLROOT . "/media/files/puzzels/" . $puzzel->image; ?>" height="30px">
                                        </a>
                                    </td>
                                    <td class=""><?php echo $puzzel->name; ?></td>
                                    <td class=""><?php echo $puzzel->description; ?></td>
                                    <td class="ltr"><?php echo date('Y/ m/ d | H:i a', $puzzel->create_date); ?></td>
                                    <td class="ltr"><?php echo date('Y/ m/ d | H:i a', $puzzel->modified_date); ?></td>
                                    <td class="form-group">
                                        <?php
                                        if (!$puzzel->status) {
                                            echo '<a href="' . ADMINURL . '/puzzels/publish/' . $puzzel->puzzel_id . '" class="btn btn-xs btn-warning" type="button" data-toggle="tooltip" data-original-title="غير منشور"><i class="fa  fa-ban"></i></a>';
                                        } elseif ($puzzel->status == 1) {
                                            echo '<a href="' . ADMINURL . '/puzzels/unpublish/' . $puzzel->puzzel_id . '" class="btn btn-xs btn-success" type="button" data-toggle="tooltip" data-original-title="منشور"><i class="fa fa-check"></i></a>';
                                        }
                                        ?>
                                        <a href="<?php echo ADMINURL . '/puzzels/show/' . $puzzel->puzzel_id; ?>" class="btn btn-xs btn-success" data-placement="top" data-toggle="tooltip" data-original-title="عرض"><i class="fa fa-eye"></i></a>
                                        <a href="<?php echo ADMINURL . '/puzzels/edit/' . $puzzel->puzzel_id; ?>" class="btn btn-xs btn-primary" data-placement="top" data-toggle="tooltip" data-original-title="تعديل"><i class="fa fa-edit"></i></a>
                                        <a href="<?php echo ADMINURL . '/puzzels/delete/' . $puzzel->puzzel_id; ?>" class="btn btn-xs btn-danger" data-placement="top" data-toggle="tooltip" data-original-title="حذف" onclick="return confirm('Are you sure?') ? true : false"><i class="fa fa-trash-o"></i></a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>

                            <tr class="tab-selected">
                                <th></th>
                                <th class="column-title" colspan="2"> العدد الكلي : <?php echo $data['recordsCount']; ?> </th>
                                <th class="column-title" colspan=""> </th>
                                <th class="column-title"> عرض
                                    <select name="perpage" onchange="if (this.value)
                                                window.location.href = '<?php echo ADMINURL . '/puzzels/index/' . $data['current']; ?>' + '/' + this.value">
                                        <option value="10" <?php echo ($data['perpage'] == 10) ? 'selected' : null; ?>>10 </option>
                                        <option value="50" <?php echo ($data['perpage'] == 50) ? 'selected' : null; ?>>50 </option>
                                        <option value="100" <?php echo ($data['perpage'] == 100) ? 'selected' : null; ?>>100 </option>
                                        <option value="200" <?php echo ($data['perpage'] == 200) ? 'selected' : null; ?>>200 </option>
                                        <option value="500" <?php echo ($data['perpage'] == 500) ? 'selected' : null; ?>>500 </option>
                                        <option value="1000" <?php echo ($data['perpage'] == 1000) ? 'selected' : null; ?>>1000 </option>
                                    </select>
                                </th>
                                <th class="column-title no-link last" colspan="3"></th>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <ul class="pagination text-center">
                    <?php
                    pagination($data['recordsCount'], $data['current'], $data['perpage'], 4, ADMINURL . '/puzzels');
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
