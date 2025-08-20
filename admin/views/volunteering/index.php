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
    <?php flash('volunteering_msg'); ?>
    <div class="page-title">
        <div class="title_right">
            <h3><?= $data['title']; ?> <small>عرض كافة <?= $data['title']; ?> </small></h3>
        </div>
        <div class="title_left">
            <a href="<?= ADMINURL; ?>/settings/edit/13#volunteer" class="btn btn-primary pull-left">الاعدادات <i class="fa fa-plus"></i></a>
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
                                <th width="50px"><input type="submit" name="search[submit]" value="بحث" class="btn btn-sm btn-primary search-query" /></th>
                                <th class=""><input type="search" class="form-control" placeholder="بحث بالمتطوع" name="search[full_name]" value=""></th>
                                <th class=""><input type="search" class="form-control" placeholder="بحث بالحملة" name="search[volunteerpages.title]" value=""></th>
                                <th colspan="1"><input type="search" class="form-control" placeholder="بحث بالهوية" name="search[identity]" value=""></th>
                                <th class=""><input type="search" class="form-control" placeholder="بحث بالهاتف" name="search[phone]" value=""></th>
                                <th class=""><input type="search" class="form-control" placeholder="بحث بالبريد" name="search[email]" value=""></th>
                                <th class="" colspan="8"></th>
                                <th width="150px">
                                    <select class="form-control" name="search[status]">
                                        <option value=""></option>
                                        <option value="1">مقروء </option>
                                        <option value="0"> غير مقروء </option>
                                    </select>
                                </th>
                            </tr>
                            <tr class="headings">
                                <th>
                                    <input type="checkbox" id="check-all" class="flat">
                                </th>
                                <th class="column-title">اسم المتطوع </th>
                                <th class="column-title">الحملة </th>
                                <th class="column-title">الهوية </th>
                                <th class="column-title">الهاتف </th>
                                <th class="column-title">البريد </th>
                                <th class="column-title"> حالة تأكيد الجوال </th>
                                <th class="column-title"><button class="btn btn-primary"><i class="fa fa-facebook"></i></button> </th>
                                <th class="column-title"> <button class="btn btn-info"><i class="fa fa-twitter"></i></button> </th>
                                <th class="column-title"> <button class="btn btn-success"><i class="fa fa-whatsapp"></i></button> </th>
                                <th class="column-title"> <button class="btn btn-danger"><i class="fa fa-instagram"></i></button> </th>
                                <th class="column-title"> مرات المشاركة </th>
                                <th class="column-title">تاريخ الانشاء </th>
                                <th class="column-title">آخر تحديث </th>
                                <th class="column-title no-link last"><span class="nobr">اجراءات</span>
                                </th>
                                <th class="bulk-actions" colspan="11">
                                    <span> تنفيذ علي الكل :</span>
                                    <input type="submit" name="delete" value="حذف" onclick="return confirm('Are you sure?') ? true : false" class="btn btn-danger btn-xs" />
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ((object) $data['volunteering'] as $volunteer) : ?>
                                <tr class="even pointer ">
                                    <td class="a-center">
                                        <input type="checkbox" class="records flat" name="record[]" value="<?= $volunteer->volunteering_id; ?>">
                                    </td>
                                    <td class=""><?= $volunteer->full_name; ?></td>
                                    <td class=""><?= $volunteer->title; ?></td>
                                    <td class=""><?= $volunteer->identity; ?></td>
                                    <td class=""><?= $volunteer->phone; ?></td>
                                    <td class=""><?= $volunteer->email; ?></td>
                                    <td class="text-center"><?= ($volunteer->status) ? '<i class="fa fa-check text-success"></i>' : '<i class="fa fa-ban text-danger"></i>'; ?></td>
                                    <td class="text-center"><?= ($volunteer->facebook) ? '<i class="fa fa-check text-success"></i>' : '<i class="fa fa-ban text-danger"></i>'; ?></td>
                                    <td class="text-center"><?= ($volunteer->twitter) ? '<i class="fa fa-check text-success"></i>' : '<i class="fa fa-ban text-danger"></i>'; ?></td>
                                    <td class="text-center"><?= ($volunteer->whatsapp) ? '<i class="fa fa-check text-success"></i>' : '<i class="fa fa-ban text-danger"></i>'; ?></td>
                                    <td class="text-center"><?= ($volunteer->instagram) ? '<i class="fa fa-check text-success"></i>' : '<i class="fa fa-ban text-danger"></i>'; ?></td>

                                    <td class=""><?= $volunteer->shared_count; ?></td>
                                    <td class="ltr"><?= date('Y/ m/ d | H:i a', $volunteer->create_date); ?></td>
                                    <td class="ltr"><?= date('Y/ m/ d | H:i a', $volunteer->modified_date); ?></td>
                                    <td class="form-group">
                                        <a href="<?= ADMINURL . '/volunteerings/delete/' . $volunteer->volunteering_id; ?>" class="btn btn-xs btn-danger" data-placement="top" data-toggle="tooltip" data-original-title="حذف" onclick="return confirm('Are you sure?') ? true : false"><i class="fa fa-trash-o"></i></a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>

                            <tr class="tab-selected">
                                <th></th>
                                <th class="column-title" colspan="2"> العدد الكلي : <?= $data['recordsCount']; ?> </th>
                                <th class="column-title" colspan="5"> </th>
                                <th class="column-title"> عرض
                                    <select name="perpage" onchange="if (this.value)
                                                window.location.href = '<?= ADMINURL . '/volunteerings/index/' . $data['current']; ?>' + '/' + this.value">
                                        <option value="10" <?= ($data['perpage'] == 10) ? 'selected' : null; ?>>10 </option>
                                        <option value="50" <?= ($data['perpage'] == 50) ? 'selected' : null; ?>>50 </option>
                                        <option value="100" <?= ($data['perpage'] == 100) ? 'selected' : null; ?>>100 </option>
                                        <option value="200" <?= ($data['perpage'] == 200) ? 'selected' : null; ?>>200 </option>
                                        <option value="500" <?= ($data['perpage'] == 500) ? 'selected' : null; ?>>500 </option>
                                        <option value="1000" <?= ($data['perpage'] == 1000) ? 'selected' : null; ?>>1000 </option>
                                    </select>
                                </th>
                                <th class="column-title no-link last" colspan="7"></th>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <ul class="pagination text-center">
                    <?php
                    pagination($data['recordsCount'], $data['current'], $data['perpage'], 4, ADMINURL . '/volunteerings');
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
