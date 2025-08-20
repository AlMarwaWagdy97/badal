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
    <?php flash('player_msg'); ?>
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
                            <tr class=" form-group-sm">
                                <th width="70px"><input type="submit" name="search[submit]" value="بحث" class="btn btn-sm btn-primary search-query" /></th>
                                <th width="36px"></th>
                                <th class=""><input type="search" class="form-control" placeholder="بحث بالمرسل" name="search[full_name]" value="<?= @returnIsset($_SESSION['search']['full_name']) ?>"></th>
                                <th class=""><input type="search" class="form-control" placeholder="بحث بالبريد" name="search[email]" value="<?= @returnIsset($_SESSION['search']['email']) ?>"></th>
                                <th class=""><input type="search" class="form-control" placeholder="بحث بالهاتف" name="search[phone]" value="<?= @returnIsset($_SESSION['search']['phone']) ?>"></th>
                                <th class=""><input type="search" class="form-control" placeholder="بحث اللغز" name="search[puzzel]" value="<?= @returnIsset($_SESSION['search']['puzzel']) ?>"></th>
                                <th width="130px"><button type="submit" name="exportAll" id="exportAll" class="btn btn-sm btn-success">استخرج</button></th>
                                <th class="" colspan=""></th>
                                <th width="150px">
                                    <select class="form-control" name="search[status]">
                                        <option value=""></option>
                                        <option value="1">مكتمل </option>
                                        <option value="0"> غير مكتمل </option>
                                    </select>
                                </th>
                            </tr>
                            <tr class="headings">
                                <th>
                                    <input type="checkbox" id="check-all" class="flat">
                                </th>
                                <th class=""> </th>
                                <th class="column-title">اسم المرسل </th>
                                <th class="column-title">البريد الالكتروني </th>
                                <th class="column-title">الهاتف </th>
                                <th class="column-title">اللغز </th>
                                <th class="column-title">تاريخ الانشاء </th>
                                <th class="column-title">آخر تحديث </th>
                                <th class="column-title no-link last"><span class="nobr">اجراءات</span>
                                </th>
                                <th class="bulk-actions" colspan="9">
                                    <span> تنفيذ علي الكل :</span>
                                    <input type="submit" name="publish" value="مكتملة" class="btn btn-success btn-xs" />
                                    <input type="submit" name="unpublish" value="غير مكتملة" class="btn btn-warning btn-xs" />
                                    <input type="submit" name="delete" value="حذف" onclick="return confirm('Are you sure?') ? true : false" class="btn btn-danger btn-xs" />
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($data['players'] as $player) : ?>

                                <tr class="even pointer <?php echo $player->status ? '' : ' selected '; ?>">
                                    <td class="a-center">
                                        <input type="checkbox" class="records flat" name="record[]" value="<?php echo $player->player_id; ?>">
                                    </td>
                                    <td class=""></td>
                                    <td class=""><?php echo $player->full_name; ?></td>
                                    <td class=""><?php echo $player->email; ?></td>
                                    <td class=""><?php echo $player->phone; ?></td>
                                    <td class=""><?php echo $player->puzzel; ?></td>
                                    <td class="ltr"><?php echo date('Y/ m/ d | H:i a', $player->create_date); ?></td>
                                    <td class="ltr"><?php echo date('Y/ m/ d | H:i a', $player->modified_date); ?></td>
                                    <td class="form-group">
                                        <?php
                                        if (!$player->status) {
                                            echo '<a href="' . ADMINURL . '/players/publish/' . $player->player_id . '" class="btn btn-xs btn-warning" type="button" data-toggle="tooltip" data-original-title="غير مكتمل"><i class="fa  fa-ban"></i></a>';
                                        } elseif ($player->status == 1) {
                                            echo '<a href="' . ADMINURL . '/players/unpublish/' . $player->player_id . '" class="btn btn-xs btn-success" type="button" data-toggle="tooltip" data-original-title="مكتمل"><i class="fa fa-check"></i></a>';
                                        }
                                        ?>
                                        <a href="<?php echo ADMINURL . '/players/show/' . $player->player_id; ?>" class="btn btn-xs btn-success" data-placement="top" data-toggle="tooltip" data-original-title="عرض"><i class="fa fa-eye"></i></a>
                                        <a href="<?php echo ADMINURL . '/players/edit/' . $player->player_id; ?>" class="btn btn-xs btn-primary" data-placement="top" data-toggle="tooltip" data-original-title="تعديل"><i class="fa fa-edit"></i></a>
                                        <a href="<?php echo ADMINURL . '/players/delete/' . $player->player_id; ?>" class="btn btn-xs btn-danger" data-placement="top" data-toggle="tooltip" data-original-title="حذف" onclick="return confirm('Are you sure?') ? true : false"><i class="fa fa-trash-o"></i></a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>

                            <tr class="tab-selected">
                                <th></th>
                                <th></th>
                                <th class="column-title"> العدد الكلي : <?php echo $data['recordsCount']; ?> </th>
                                <th class="column-title" colspan="2"> </th>
                                <th class="column-title"> عرض
                                    <select name="perpage" onchange="if (this.value)
                                                window.location.href = '<?php echo ADMINURL . '/players/index/' . $data['current']; ?>' + '/' + this.value">
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
                    pagination($data['recordsCount'], $data['current'], $data['perpage'], 4, ADMINURL . '/players');
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
