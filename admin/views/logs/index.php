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
    <?php flash('log_msg'); ?>
    <div class="page-title">
        <div class="title_right">
            <h3><?php echo $data['title']; ?> <small>عرض كافة <?php echo $data['title']; ?> </small></h3>
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
                                <th class=""><input type="search" class="form-control" placeholder="بحث بالمستخدم" name="search[user_name]" value=""></th>
                                <th class=""><input type="search" class="form-control" placeholder="بحث بالفعل" name="search[action]" value=""></th>
                                <th width="40%"><input type="search" class="form-control" placeholder="بحث بالسجل" name="search[records]" value=""></th>
                                <th class=""><input type="search" class="form-control" placeholder="بحث الموديول" name="search[model]" value=""></th>
                                <th class=""> </th>
                                <th width="150px"><input type="submit" name="search[submit]" value="بحث" class="btn btn-sm btn-primary search-query" /></th>
                            </tr>
                            <tr class="headings">
                                <th class="column-title">المستخدم </th>
                                <th class="column-title">الفعل </th>
                                <th class="column-title">السجل </th>
                                <th class="column-title">لموديول </th>
                                <th class="column-title">URL </th>
                                <th class="column-title">تاريخ الانشاء </th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($data['logs'] as $log) : ?>
                                <tr class="even pointer">
                                    <td class=""><?php echo $log->user_name; ?></td>
                                    <td class=""><?php echo $log->action; ?></td>
                                    <td class=""><?php echo $log->records; ?></td>
                                    <td class=""><?php echo $log->model; ?></td>
                                    <td class=""><?php echo $log->url; ?></td>
                                    <td class="ltr"><?php echo date('Y/ m/ d | H:i a', $log->create_date); ?></td>
                                </tr>
                            <?php endforeach; ?>
                            <tr class="tab-selected">
                                <th class="column-title"> العدد الكلي : <?php echo $data['recordsCount']; ?> </th>
                                <th class="column-title" colspan="2"> </th>
                                <th class="column-title"> عرض
                                    <select name="perpage" onchange="if (this.value)
                                                window.location.href = '<?php echo ADMINURL . '/logs/index/' . $data['current']; ?>' + '/' + this.value">
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
                    pagination($data['recordsCount'], $data['current'], $data['perpage'], 4, ADMINURL . '/logs');
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
