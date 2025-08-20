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
            <a href="<?php echo ADMINURL; ?>/stores" class="btn btn-success pull-left">عودة <i class="fa fa-reply"></i></a>
        </div>
    </div>
    <div class="clearfix"></div>
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <form action="" method="post">
                <div class="table-responsive">
                    <table class="table table-striped jambo_table bulk_action">
                        <thead>
                            <tr class="headings">
                                <th>
                                    <input type="checkbox" id="check-all" class="flat">
                                </th>
                                <th class="column-title">اسم المشروع </th>
                                <th class="column-title">رقم المشروع </th>
                                <th class="column-title">وصف المشروع </th>
                                <th class="column-title">الحالة </th>
                                <th class="column-title">تاريخ الانشاء </th>
                                <th class="bulk-actions" colspan="10">
                                    <span> تنفيذ علي الكل :</span>
                                    <input type="submit" name="publish" value="نشر" class="btn btn-success btn-xs" />
                                    <input type="submit" name="unpublish" value="تعطيل" class="btn btn-primary btn-xs" />
                                    <input type="submit" name="delete" value="حذف" class="btn btn-danger btn-xs" />
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
                                    <td><?php echo mb_substr(strip_tags($project->description), 0, 70); ?></td>
                                    <td>
                                        <?php
                                        if (!$project->status) {
                                            echo '<button class="btn btn-xs btn-warning" type="button" data-toggle="tooltip" data-original-title="غير منشور">غير منشور</button>';
                                        } elseif ($project->status == 1) {
                                            echo '<button class="btn btn-xs btn-success" type="button" data-toggle="tooltip" data-original-title="منشور">منشور</button>';
                                        }
                                        ?>
                                    </td>
                                    <td class="ltr"><?php echo date('Y/ m/ d | H:i a', $project->create_date); ?></td>
                                </tr>
                            <?php endforeach; ?>
                            <tr>
                                <td class="text-center" colspan="6"><?php echo count($data['projects']); ?></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
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
        $.post('<?php echo ADMINURL; ?>/projects/arrangement', {
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