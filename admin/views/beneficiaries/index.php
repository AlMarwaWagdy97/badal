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
    <?php flash('beneficiary_msg'); ?>
    <div class="page-title">
        <div class="title_right">
            <h3><?php echo $data['title']; ?> <small>عرض كافة <?php echo $data['title']; ?> </small></h3>
        </div>
        <div class="title_left">
            <a href="<?php echo ADMINURL; ?>/beneficiaries/add" class="btn btn-success pull-left">انشاء جديد <i class="fa fa-plus"></i></a>
            <a href="<?php echo ADMINURL; ?>/settings/edit/10#beneficiary" class="btn btn-primary pull-left">الاعدادات <i class="fa fa-plus"></i></a>
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
                                <th><input type="search" class="form-control" placeholder="بحث بالمستفيد" name="search[full_name]" value="<?php @print($_SESSION['search']['full_name']); ?>"></th>
                                <th colspan="2"><input type="search" class="form-control" placeholder="بحث بالهوية" name="search[identity]" value="<?php @print($_SESSION['search']['identity']); ?>"></th>
                                <th><input type="search" class="form-control" placeholder="بحث بالهاتف" name="search[phone]" value="<?php @print($_SESSION['search']['phone']); ?>"></th>
                                <th><input type="search" class="form-control" placeholder="بحث بعدد الاسرة" name="search[family]" value="<?php @print($_SESSION['search']['family']); ?>"></th>
                                <th></th>
                                <th><input type="search" class="form-control" placeholder="بحث بالجنس" name="search[gender]" value="<?php @print($_SESSION['search']['gender']); ?>"></th>
                                <th><input type="search" class="form-control" placeholder="بحث بالجنسية" name="search[nationality]" value="<?php @print($_SESSION['search']['nationality']); ?>"></th>
                                <th><input type="search" class="form-control" placeholder="بحث بالحي" name="search[district]" value="<?php @print($_SESSION['search']['district']); ?>"></th>
                                <th><input type="search" class="form-control" placeholder="بحث بالمدينة" name="search[city]" value="<?php @print($_SESSION['search']['city']); ?>"></th>
                                <th>
                                    <select class="form-control" name="search[status]">
                                        <option value=""></option>
                                        <option <?php if(@$_SESSION['search']['status'] == 1) echo 'selected'; ?> value="1">مقروء </option>
                                        <option <?php if(@$_SESSION['search']['status'] == 0) echo 'selected'; ?> value="0"> غير مقروء </option>
                                    </select>
                                </th>
                                <th>
                                    <input type="submit" name="search[submit]" value="بحث" class="btn btn-sm btn-primary search-query" />
                                    <a href="<?php echo ADMINURL; ?>/beneficiaries/" role="button" class="btn btn-sm btn-danger">مسح</a>
                                </th>
                                <th width="130px"><button type="submit" name="exportAll" id="exportAll" class="btn btn-sm btn-success">استخرج</button></th>

                            </tr>
                            <tr class="headings">
                                <th>
                                    <input type="checkbox" id="check-all" class="flat">
                                </th>
                                <th class="column-title">اسم المستفيد </th>
                                <th class="column-title">الهوية </th>
                                <th class="column-title">صورة الهوية </th>
                                <th class="column-title">الهاتف </th>
                                <th class="column-title">عدد الافراد </th>
                                <th class="column-title">الدخل </th>
                                <th class="column-title"> الجنس </th>
                                <th class="column-title"> الجنسية </th>
                                <th class="column-title">الحي </th>
                                <th class="column-title">المدينة </th>
                                <th class="column-title">تاريخ الانشاء </th>
                                <th class="column-title">آخر تحديث </th>
                                <th class="column-title no-link last"><span class="nobr">اجراءات</span>
                                </th>
                                <th class="bulk-actions" colspan="13">
                                    <span> تنفيذ علي الكل :</span>
                                    <input type="submit" name="publish" value="مقروءة" class="btn btn-success btn-xs" />
                                    <input type="submit" name="unpublish" value="غير مقروءة" class="btn btn-warning btn-xs" />
                                    <input type="submit" name="delete" value="حذف" onclick="return confirm('Are you sure?') ? true : false" class="btn btn-danger btn-xs" />
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ((object) $data['beneficiaries'] as $beneficiary) : ?>
                                <tr class="even pointer <?php echo $beneficiary->status ? '' : ' selected '; ?>">
                                    <td class="a-center">
                                        <input type="checkbox" class="records flat" name="record[]" value="<?php echo $beneficiary->beneficiary_id; ?>">
                                    </td>
                                    <td class=""><?php echo $beneficiary->full_name; ?></td>
                                    <td class=""><?php echo $beneficiary->identity; ?></td>
                                    <td class="text-center">
                                        <a href="<?php echo URLROOT . "/media/files/beneficiaries/" . $beneficiary->image; ?>" target="blank">
                                            <img src="<?php echo URLROOT . "/media/files/thumbs/" . $beneficiary->image; ?>" height="30px">
                                        </a>
                                    </td>
                                    <td class=""><?php echo $beneficiary->phone; ?></td>
                                    <td class=""><?php echo $beneficiary->family; ?></td>
                                    <td class=""><?php echo $beneficiary->income; ?></td>
                                    <td class=""><?php echo $beneficiary->gender; ?></td>
                                    <td class=""><?php echo $beneficiary->nationality; ?></td>
                                    <td class=""><?php echo $beneficiary->district; ?></td>
                                    <td class=""><?php echo $beneficiary->city; ?></td>
                                    <td class="ltr"><?php echo date('Y/ m/ d | H:i a', $beneficiary->create_date); ?></td>
                                    <td class="ltr"><?php echo date('Y/ m/ d | H:i a', $beneficiary->modified_date); ?></td>
                                    <td class="form-group">
                                        <?php
                                        if (!$beneficiary->status) {
                                            echo '<a href="' . ADMINURL . '/beneficiaries/publish/' . $beneficiary->beneficiary_id . '" class="btn btn-xs btn-warning" type="button" data-toggle="tooltip" data-original-title="غير مقروء"><i class="fa  fa-envelope-o"></i></a>';
                                        } elseif ($beneficiary->status == 1) {
                                            echo '<a href="' . ADMINURL . '/beneficiaries/unpublish/' . $beneficiary->beneficiary_id . '" class="btn btn-xs btn-success" type="button" data-toggle="tooltip" data-original-title="مقروء"><i class="fa fa-envelope"></i></a>';
                                        }
                                        ?>
                                        <a href="<?php echo ADMINURL . '/beneficiaries/show/' . $beneficiary->beneficiary_id; ?>" class="btn btn-xs btn-success" data-placement="top" data-toggle="tooltip" data-original-title="عرض"><i class="fa fa-eye"></i></a>
                                        <a href="<?php echo ADMINURL . '/beneficiaries/edit/' . $beneficiary->beneficiary_id; ?>" class="btn btn-xs btn-primary" data-placement="top" data-toggle="tooltip" data-original-title="تعديل"><i class="fa fa-edit"></i></a>
                                        <a href="<?php echo ADMINURL . '/beneficiaries/delete/' . $beneficiary->beneficiary_id; ?>" class="btn btn-xs btn-danger" data-placement="top" data-toggle="tooltip" data-original-title="حذف" onclick="return confirm('Are you sure?') ? true : false"><i class="fa fa-trash-o"></i></a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>

                            <tr class="tab-selected">
                                <th></th>
                                <th class="column-title" colspan="2"> العدد الكلي : <?php echo $data['recordsCount']; ?> </th>
                                <th class="column-title" colspan="5"> </th>
                                <th class="column-title"> عرض
                                    <select name="perpage" onchange="if (this.value)
                                                window.location.href = '<?php echo ADMINURL . '/beneficiaries/index/' . $data['current']; ?>' + '/' + this.value">
                                        <option value="10" <?php echo ($data['perpage'] == 10) ? 'selected' : null; ?>>10 </option>
                                        <option value="50" <?php echo ($data['perpage'] == 50) ? 'selected' : null; ?>>50 </option>
                                        <option value="100" <?php echo ($data['perpage'] == 100) ? 'selected' : null; ?>>100 </option>
                                        <option value="200" <?php echo ($data['perpage'] == 200) ? 'selected' : null; ?>>200 </option>
                                        <option value="500" <?php echo ($data['perpage'] == 500) ? 'selected' : null; ?>>500 </option>
                                        <option value="1000" <?php echo ($data['perpage'] == 1000) ? 'selected' : null; ?>>1000 </option>
                                    </select>
                                </th>
                                <th class="column-title no-link last" colspan="5"></th>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <ul class="pagination text-center">
                    <?php
                    pagination($data['recordsCount'], $data['current'], $data['perpage'], 4, ADMINURL . '/beneficiaries');
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
