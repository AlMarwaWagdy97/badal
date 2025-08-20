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
    <?php flash('deceased_msg'); ?>
    <div class="page-title">
        <div class="title_right">
            <h3><?php echo $data['title']; ?> <small>عرض كافة <?php echo $data['title']; ?> </small></h3>
        </div>
     
        <div class="title_left">
            <a href="<?php echo URLROOT; ?>/deceaseds" class="btn btn-success pull-left">طلب الخدمة  <i class="fa fa-plus"></i></a>
            <a href="<?php echo ADMINURL; ?>/settings/edit/14" class="btn btn-primary pull-left">الاعدادات <i class="fa fa-plus"></i></a>
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
                                <th class=""><input type="search" placeholder="بحث بالأسم " class="form-control" name="search[name]" value="<?= @printIsset($_SESSION['search']['name']) ?>"></th>
                                <th class=""><input type="search" placeholder="بحث برقم الجوال" class="form-control" name="search[mobile]" value="<?= @printIsset($_SESSION['search']['mobile']) ?>"></th>
                                <th class=""><input type="search" placeholder="بحث بالايميل" class="form-control" name="search[email]" value="<?= @printIsset($_SESSION['search']['email']) ?>"></th>
                                <th class=""><input type="number" placeholder="بحث بالمبلغ المتوقع" class="form-control" name="search[target_price]" value="<?= @printIsset($_SESSION['search']['target_price']) ?>"></th>
                                <th class=""><input type="title" placeholder="بحث باسم المتوفي" class="form-control" name="search[deceased_name]" value="<?= @printIsset($_SESSION['search']['deceased_name']) ?>"></th>
                                <th width="145px">
                                    <select class="form-control" name="search[status]">
                                        <option value="">الحالة</option>
                                        <option value="1" <?php echo $_SESSION['search']['status']?? Null == 1 ? 'selected' : '' ?> >نشط </option>
                                        <option value="0" <?php echo @$_SESSION['search']['status'] == 0  && @$_SESSION['search']['status'] != NULL ? 'selected' : '' ?> >معلق</option>
                                    </select>
                                </th>
                                <th width="145px">
                                    <select class="form-control" name="search[confirmed]">
                                        <option value="">حاله التأكيد</option>
                                        <option value="1" <?php echo $_SESSION['search']['confirmed']?? Null == 1 ? 'selected' : '' ?>>مؤكد </option>
                                        <option value="0" <?php echo @$_SESSION['search']['confirmed'] == 0  && @$_SESSION['search']['confirmed'] != NULL ? 'selected' : '' ?>>معلق</option>
                                    </select>
                                </th>
                                <th class="">
                                    <!-- تاريخ التسجيل  -->
                                    <!-- <input type="date" placeholder=" من" name="search[date_from]" value="<?php #if (returnIsset(cleanSearchVar('date_from'))) echo date('Y-m-d', returnIsset(cleanSearchVar('date_from'))); ?>" class="form-control"> -->
                                </th>
                                <th class="">
                                    <!-- <input type="date" placeholder=" الي" name="search[date_to]" value="<?php #if (returnIsset(cleanSearchVar('date_to'))) echo date('Y-m-d', (int) returnIsset(cleanSearchVar('date_to')) - 86400); ?>" class="form-control"> -->
                                </th>
                                <th class="" colspan="2"></th>
                            </tr>
                            <tr class="headings">
                                <th>
                                    <input type="checkbox" id="check-all" class="flat">
                                </th>
                                <th class="column-title"> الاسم  </th>
                                <th class="column-title">رقم الجوال </th>
                                <th class="column-title"> المبلغ المتوقع </th>
                                <th class="column-title">  المشروع </th>
                                <th class="column-title"> اسم المتوفي </th>
                                <th class="column-title"> صله القرابة  </th>
                                <th class="column-title">  مؤكد  </th>
                                <th class="column-title">تاريخ التسجيل </th>
                                <th class="column-title">آخر تحديث </th>
                                <th class="column-title no-link last"><span class="nobr">اجراءات</span>
                                </th>
                                <th class="bulk-actions" colspan="10">
                                    <span> تنفيذ علي الكل :</span>
                                    <input type="submit" name="publish" value="Publish" class="btn btn-success btn-xs" />
                                    <input type="submit" name="unpublish" value="Unpublish" class="btn btn-warning btn-xs" />
                                    <input type="submit" name="delete" value="حذف" onclick="return confirm('Are you sure?') ? true : false" class="btn btn-danger btn-xs" />
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($data['deceaseds'] as $deceased) : ?>
                                <tr class="even pointer">
                                    <td class="a-center ">
                                        <input type="checkbox" class="records flat" name="record[]" value="<?php echo $deceased->deceased_id; ?>">
                                    </td>
                                    <td class=" "><?php echo $deceased->name; ?></td>
                                    <td class="ltr "><?php echo $deceased->mobile; ?></i></td>
                                    <td class=" "><?php echo $deceased->target_price; ?></i></td>
                                    <td class=" "><?php echo $deceased->project; ?></i></td>
                                    <td class=" "><?php echo $deceased->deceased_name; ?></i></td>
                                    <td class=" "><?php echo $deceased->relative_relation; ?></i></td>
                                    <td class=" "><?php echo $deceased->confirmed != 0 ? '<i class="fa fa-check btn btn-xs btn-success"></i>': ' <i class="fa fa-close btn btn-xs btn-danger"></i>'; ?></i></td>
                                    <td class="ltr"><?php echo date('Y/ m/ d | H:i a', $deceased->create_date); ?></td>
                                    <td class="ltr"><?php echo date('Y/ m/ d | H:i a', $deceased->modified_date); ?></td>
                                    <td class="form-donor">
                                    <?php
                                        if ($deceased->status != 1) {
                                            echo '<a href="' . ADMINURL . '/deceaseds/publish/' . $deceased->deceased_id . '" class="btn btn-xs btn-warning " type="button" data-toggle="tooltip" data-original-title="غير منشور"><i class="fa fa-ban"></i></a>';
                                        } elseif ($deceased->status == 1) {
                                            echo '<a href="' . ADMINURL . '/deceaseds/unpublish/' . $deceased->deceased_id . '" class="btn btn-xs btn-success" type="button" data-toggle="tooltip" data-original-title="منشور"><i class="fa fa-check"></i></a>';
                                        }
                                        ?>
                                        
                                        <!-- Button trigger modal -->
                                        <!-- <button type="button" class="btn btn-xs btn-primary" data-toggle="modal" data-target="#exampleModalCenter_<?php echo $deceased->deceased_id ?>">
                                            <i class="fa fa-eye"></i>
                                        </button> -->
                                        <a href="<?php echo ADMINURL . '/deceaseds/show/' . $deceased->deceased_id; ?>" class="btn btn-xs btn-primary"  style="margin-top: 1px;" > <i class="fa fa-eye"></i></a>
                                   
                                        <a href="<?php echo ADMINURL . '/deceaseds/delete/' . $deceased->deceased_id; ?>" class="btn btn-xs btn-danger"  style="margin-top: 1px;" data-placement="top" data-toggle="tooltip" data-original-title="حذف" onclick="return confirm('Are you sure?') ? true : false"><i class="fa fa-trash-o"></i></a>
                                        

                                    </td>
                                </tr>
                                
                            <?php endforeach; ?>

                            <tr class="tab-selected">
                                <th class="column-title" colspan="5"> العدد الكلي : <?php echo $data['recordsCount']; ?> </th>
                                <th class="column-title"> عرض
                                    <select name="perpage" onchange="if (this.value)
                                                window.location.href = '<?php echo ADMINURL . '/deceaseds/index/' . $data['current']; ?>' + '/' + this.value">
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
                    pagination($data['recordsCount'], $data['current'], $data['perpage'], 4, ADMINURL . '/deceaseds');
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
