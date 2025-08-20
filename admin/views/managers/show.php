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

// loading plugin style
$data['header'] = '';
header("Content-Type: text/html; charset=utf-8");

require ADMINROOT . '/views/inc/header.php';
?>

<!-- page content -->

<div class="right_col" role="main">
    <div class="clearfix"></div>
    <?php flash('manager_msg'); ?>
    <div class="page-title">
        <div class="title_right">
            <h3><?php echo $data['page_title']; ?> <small>عرض تفاصيل المجموعة </small></h3>
        </div>
        <div class="title_left">
            <a href="<?php echo ADMINURL; ?>/managers" class="btn btn-success pull-left">عودة <i class="fa fa-reply"></i></a>
        </div>
    </div>

    <div class="clearfix"></div>

    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12 page-header">
            <div class="form-group col-md-12 col-sm-12 col-xs-12">
                <label class="control-label">اسم المجموعة  : </label>
                <div class="bg-white">
                    <?php echo ($data['manager']->name); ?>
                </div>
            </div>
            <div class="form-group col-md-12 col-sm-12 col-xs-12">
                <label class="control-label">وصف المجموعة  : </label>
                <div class="bg-white">
                    <?php echo ($data['manager']->email); ?>
                </div>
            </div>
            <div class="form-group col-xs-12">
                <label class="control-label">الحالة  :</label>
                <div class="radio">
                    <label> 
                        <?php
                        switch ($data['manager']->status) {
                            case 2:echo '<span class="btn btn-danger">محذوف</span>';
                                break;
                            case 1:echo '<span class="btn btn-success">مفعل</span>';
                                break;
                            case 0:echo '<span class="btn btn-warning">معطل</span>';
                                break;
                            default:
                                break;
                        }
                        ?>
                </div>
                </label>
            </div>
            <h2 class="page-header col-lg-12">الصلاحيات</h2>
            <hr class="clear" />
            
            <div class="form-group prevlages">
                    <ul class="to_do">
                        <?php foreach ($data['storesList'] as $store) : ?>
                            <li class="col-lg-3 col-md-4 col-sm-6">
                                <p><input type="checkbox" class="flat" <?php echo in_array($store->store_id, json_decode($data['manager']->stores))? 'checked': ""; ?> value="<?php echo $store->store_id; ?>" name="stores[]"> <?php echo $store->name; ?> </p>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>

        </div>
        
            <div class="form-group">
                <a class="btn btn-info" href="<?php echo ADMINURL . '/managers/edit/' . $data['manager']->manager_id; ?>" >تعديل</a>
            </div>
    </div>
</div>

<?php
// loading plugin
$data['footer'] = '';


require ADMINROOT . '/views/inc/footer.php';
