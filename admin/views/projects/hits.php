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
                                    #
                                </th>
                                <th class="column-title">رقم المشروع </th>
                                <th class="column-title">اسم المشروع </th>
                                <th class="column-title">الزيارات </th>
                              
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($data['projects'] as $key => $project) : ?>
                                <tr class="even pointer">
                                    <td class="a-center ">
                                        <?php echo ($key + 1) ?>
                                    </td>
                                    <td><?php echo $project->project_id; ?></td>
                                    <td><?php echo $project->name; ?></td>
                                    <td><?php echo $project->hits; ?></td>
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