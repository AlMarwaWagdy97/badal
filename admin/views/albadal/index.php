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
    <div class="msg"><?php flash('project_msg'); ?></div>
    <div class="page-title">
        <div class="title_right">
            <h3><?php echo $data['title']; ?> <small>عرض كافة <?php echo $data['title']; ?> </small></h3>
        </div>
        <div class="title_left">
            <a href="<?php echo ADMINURL; ?>/albadal/add" class="btn btn-success pull-left">انشاء جديد <i class="fa fa-plus"></i></a>
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
                                <th class=""><input type="search" class="form-control" placeholder="بحث بالاسم" name="search[name]" value=""></th>
                                <th class=""><input type="search" class="form-control" placeholder="بحث بالرقم" name="search[project_number]" value=""></th>
                                <th width="175px">
                                    <select class="form-control" name="search[category_id]">
                                        <option value=""></option>
                                        <?php
                                        foreach ($data['categories'] as $category) {
                                            echo '<option value="' . $category->category_id . '">' . $category->name . '</option>';
                                        }
                                        ?>
                                    </select>
                                </th>
                                <th width="175px">
                                    <select class="form-control" name="search[badal_type]">
                                        <option value=""></option>
                                        <option value="hajj">hajj </option>
                                        <option value="umrah"> umrah </option>
                                    </select>
                                </th>
                                <!-- <th width="175px">
                                    <select class="form-control" name="search[hidden]">
                                        <option value=""></option>
                                        <option value="1">مخفي </option>
                                        <option value="0"> ظاهر </option>
                                    </select>
                                </th> -->
                                <th class="" colspan="6"></th>
                                <th width="175px">
                                    <select class="form-control" name="search[status]">
                                        <option value=""></option>
                                        <option value="1">منشور </option>
                                        <option value="0"> غير منشور </option>
                                    </select>
                                </th>
                            </tr>
                            <tr class="headings">
                                <th>
                                    <input type="checkbox" id="check-all" class="flat">
                                </th>
                                <th class="column-title">اسم المشروع </th>
                                <th class="column-title">رقم المشروع </th>
                                <th class="column-title">القسم </th>
                                <th class="column-title">النوع </th>
                                <!-- <th class="column-title">الظهور </th> -->
                                <th class="column-title">السعر </th>
                                <th class="column-title">الحد الادني </th>
                                <th class="column-title">الزيارات </th>
                                <th class="column-title">الترتيب </th>
                                <th class="column-title">تاريخ الانشاء </th>
                                <th class="column-title">آخر تحديث </th>
                                <th class="column-title no-link last"><span class="nobr">اجراءات</span>
                                </th>
                                <th class="bulk-actions" colspan="10">
                                    <span> تنفيذ علي الكل :</span>
                                    <input type="submit" name="publish" value="نشر" class="btn btn-success btn-xs" />
                                    <input type="submit" name="unpublish" value="تعليق" class="btn btn-warning btn-xs" />
                                    <input type="submit" name="delete" value="حذف" onclick="return confirm('Are you sure?') ? true : false" class="btn btn-danger btn-xs" />
                                    <input type="submit" name="featured" value="مميز" class="btn btn-warning btn-xs" />
                                    <input type="submit" name="unfeatured" value="غير مميز" class="btn btn-default btn-xs" />
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($data['projects'] as $project) : ?>
                                <tr class="even pointer">
                                    <td class="a-center ">
                                        <input type="checkbox" class="records flat" name="record[]" value="<?php echo $project->project_id; ?>">
                                    </td>
                                    <td><?php echo $project->name; ?></td>
                                    <td><?php echo $project->project_number; ?></td>
                                    <td><?php echo $project->category; ?></td>
                                    <td><?php echo $project->badal_type; ?></td>
                                    <!-- <td><?php echo ($project->hidden) ? 'مخفي' : 'ظاهر'; ?></td> -->
                                    <td><?php echo json_decode($project->donation_type)->value; ?></td>
                                    <td><?php echo $project->min_price; ?></td>
                                    <td><?php echo $project->hits; ?></td>
                                    <td>
                                        <div class="input-group  form-group-sm">
                                            <span class="input-group-btn">
                                                <button value="<?php echo $project->project_id; ?>" class="btn btn-primary btn-sm go-class arrangement">رتب</button>
                                            </span>
                                            <input type="text" value="<?php echo $project->arrangement; ?>" class="form-control arrangementValue">
                                        </div>
                                    </td>
                                    <td class="ltr"><?php echo date('Y/ m/ d | H:i a', $project->create_date); ?></td>
                                    <td class="ltr"><?php echo date('Y/ m/ d | H:i a', $project->modified_date); ?></td>
                                    <td class="form-group">
                                        <?php
                                        if (!$project->status) {
                                            echo '<a href="' . ADMINURL . '/albadal/publish/' . $project->project_id . '" class="btn btn-xs btn-warning" type="button" data-toggle="tooltip" data-original-title="غير منشور"><i class="fa fa-ban"></i></a>';
                                        } elseif ($project->status == 1) {
                                            echo '<a href="' . ADMINURL . '/albadal/unpublish/' . $project->project_id . '" class="btn btn-xs btn-success" type="button" data-toggle="tooltip" data-original-title="منشور"><i class="fa fa-check"></i></a>';
                                        }
                                        ?>
                                        <?php
                                        if ($project->featured == 1) {
                                            echo '<a href="' . ADMINURL . '/albadal/unfeatured/' . $project->project_id . '" class="btn btn-xs btn-warning" type="button" data-toggle="tooltip" data-original-title="مميز"><i class="fa fa-star"></i></a>';
                                        } elseif ($project->featured == 0) {
                                            echo '<a href="' . ADMINURL . '/albadal/featured/' . $project->project_id . '" class="btn btn-xs btn-default" type="button" data-toggle="tooltip" data-original-title="غير مميز"><i class="fa fa-star"></i></a>';
                                        }
                                        ?>
                                        <a href="<?php echo ADMINURL . '/albadal/show/' . $project->project_id; ?>" class="btn btn-xs btn-success" data-placement="top" data-toggle="tooltip" data-original-title="عرض"><i class="fa fa-eye"></i></a>
                                        <a href="<?php echo ADMINURL . '/albadal/edit/' . $project->project_id; ?>" class="btn btn-xs btn-primary" data-placement="top" data-toggle="tooltip" data-original-title="تعديل"><i class="fa fa-edit"></i></a>
                                        <a href="<?php echo ADMINURL . '/albadal/delete/' . $project->project_id; ?>" class="btn btn-xs btn-danger" data-placement="top" data-toggle="tooltip" data-original-title="حذف" onclick="return confirm('Are you sure?') ? true : false"><i class="fa fa-trash-o"></i></a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>

                            <tr class="tab-selected">
                                <th></th>
                                <th class="column-title"> العدد الكلي : <?php echo $data['recordsCount']; ?> </th>
                                <th class="column-title" colspan="2"> </th>
                                <th class="column-title" colspan="5"> عرض
                                    <select name="perpage" onchange="if (this.value)
                                                window.location.href = '<?php echo ADMINURL . '/albadal/index/' . $data['current']; ?>' + '/' + this.value">
                                        <option value="10" <?php echo ($data['perpage'] == 10) ? 'selected' : null; ?>>10 </option>
                                        <option value="50" <?php echo ($data['perpage'] == 50) ? 'selected' : null; ?>>50 </option>
                                        <option value="100" <?php echo ($data['perpage'] == 100) ? 'selected' : null; ?>>100 </option>
                                        <option value="200" <?php echo ($data['perpage'] == 200) ? 'selected' : null; ?>>200 </option>
                                        <option value="500" <?php echo ($data['perpage'] == 500) ? 'selected' : null; ?>>500 </option>
                                        <option value="1000" <?php echo ($data['perpage'] == 1000) ? 'selected' : null; ?>>1000 </option>
                                    </select>
                                </th>
                                <th class="column-title"> </th>
                                <th class="column-title no-link last"></th>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <ul class="pagination text-center">
                    <?php
                    pagination($data['recordsCount'], $data['current'], $data['perpage'], 4, ADMINURL . '/albadal');
                    ?>
                </ul>


            </form>

        </div>
    </div>
</div>
<?php
// loading  plugin
$data['footer'] = "";
require ADMINROOT . '/views/inc/footer.php';
?>
<script>
    $('.arrangementValue').on('keypress', function(e) {
        return e.which !== 13;
    });
    $('.arrangement').click(function(event) {
        event.preventDefault();
        var project_id = $(this).val(),
            arrangement = $(this).parent().parent().children('.arrangementValue').val();
        $.post('<?php echo ADMINURL; ?>/albadal/arrangement', {
                project_id: project_id,
                arrangement: arrangement
            })
            .done(function(data) {
                var data = JSON.parse(data);
                if (data.status == 'success') { // arrange success
                    $('.msg').html(data.msg);
                    $('.arrangement ').val(data.arrangement);
                } else { // arrange failed
                    $('.msg').html(data);
                }
            });
    });
</script>