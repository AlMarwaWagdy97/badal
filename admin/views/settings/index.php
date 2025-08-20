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

<!-- setting content -->

<div class="right_col" role="main">
    <div class="clearfix"></div>
    <?php flash('setting_msg'); ?>
    <div class="setting-title">
        <div class="title_right">
            <h3><?php echo $data['title']; ?> <small>عرض كافة <?php echo $data['title']; ?> </small></h3>
        </div>
    </div>

    <div class="clearfix"></div>

    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">

            <form action="" method="post" >
                <div class="table-responsive">
                    <table class="table table-striped jambo_table bulk_action">
                        <thead>
                            <tr class="headings">
                                <th class="column-title">عنوان الاعداد </th>
                                <th class="column-title" width="170">تاريخ الانشاء </th>
                                <th class="column-title" width="170">آخر تحديث </th>
                                <th class="column-title" width="40">تعديل </th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($data['settings'] as $setting): ?>
                                <tr class="even pointer">
                                    <td class="h5"><i class="fa fa-lg fa-gear"></i> <?php echo $setting->title; ?></td>
                                    <td class="ltr"><?php echo date('Y/ m/ d | H:i a', $setting->create_date); ?></td>
                                    <td class="ltr"><?php echo date('Y/ m/ d | H:i a', $setting->modified_date); ?></td>
                                    <td class=" ">
                                        <a href="<?php echo ADMINURL; ?>/settings/edit/<?php echo $setting->setting_id; ?>" class="btn btn-primary"><i class=" fa fa-edit"></i> تعديل</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </form>

        </div>
    </div>
</div>
<?php
// loading  plugin
$data['footer'] = '';

require ADMINROOT . '/views/inc/footer.php';
