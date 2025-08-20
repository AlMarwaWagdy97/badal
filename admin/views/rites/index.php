<?php

// loading  plugin style
$data['header'] = '<link rel="stylesheet" href="' . ADMINURL . '/template/default/vendors/select2/dist/css/select2.min.css">';

require ADMINROOT . '/views/inc/header.php';
?>

<!-- page content -->

<div class="right_col" role="main">
    <div class="clearfix"></div>
    <?php flash('rites_msg'); ?>
    <div class="page-title">
        <div class="title_right">
            <h3><?php echo $data['title']; ?> <small>عرض كافة <?php echo $data['title']; ?> </small></h3>
        </div>
        <div class="title_left">
            <a href="<?php echo ADMINURL; ?>/rites/add" class="btn btn-success pull-left">انشاء جديد <i class="fa fa-plus"></i></a>
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
                                <th width="50px" colspan="2"><input type="submit" name="search[submit]" value="بحث" class="btn btn-sm btn-primary search-query" /></th>
                                <th class=""><input type="search" class="form-control" placeholder="بحث بالاسم" name="search[title]" value=""></th>
                                <th width="200px">
                                    <select class="form-control select2" name="search[project_ids][]" multiple="multiple" style="width: 100%;">
                                        <option value="" disabled>المشاريع</option>
                                        <?php
                                        foreach ($data['projects'] as $project) {
                                            echo '<option value="' . $project->project_id . '" ';
                                            if (@is_array($_SESSION['search']['project_ids']) && in_array($project->project_id, $_SESSION['search']['project_ids'])) echo 'selected';
                                            echo ' > ' .  $project->name . ' </option>';
                                        }
                                        ?>
                                    </select>
                                </th>
                                <th width="150px">
                                    <select class="form-control" name="search[proof]">
                                        <option value=""></option>
                                        <option value="1">نعم </option>
                                        <option value="0"> لا </option>
                                    </select>
                                </th>
                                <th colspan="3">
                                </th>

                                <th width="150px">
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
                                <th class="column-title"> الصوره </th>
                                <th class="column-title"> الاسم </th>
                                <th class="column-title"> المشروع </th>
                                <th class="column-title"> هل يتطلب رقع فديو </th>
                                <th class="column-title"> الترتيب </th>
                                <th class="column-title"> وقت المستغرق </th>
                                <th class="column-title">تاريخ الانشاء </th>
                                <th class="column-title">آخر تحديث </th>
                                <th class="column-title no-link last"><span class="nobr">اجراءات</span>
                                </th>
                                <th class="bulk-actions" colspan="9">
                                    <span> تنفيذ علي الكل :</span>
                                    <input type="submit" name="publish" value="منشور" class="btn btn-success btn-xs" />
                                    <input type="submit" name="unpublish" value="غير منشور" class="btn btn-warning btn-xs" />
                                    <input type="submit" name="delete" value="حذف" onclick="return confirm('Are you sure?') ? true : false" class="btn btn-danger btn-xs" />
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ((object) $data['rites'] as $rite) : ?>
                                <tr class="even pointer <?php echo $rite->status ? '' : ' selected '; ?>">
                                    <td class="a-center">
                                        <input type="checkbox" class="records flat" name="record[]" value="<?php echo $rite->rite_id; ?>">
                                    </td>
                                    <td> <a href="<?= MEDIAURL . '/../files/rites/' . $rite->image ?>" target="_blank"><img src="<?= MEDIAURL . '/../files/rites/' . $rite->image ?>" alt="" width="50"></a></td>
                                    <td class=""><?php echo $rite->title; ?></td>
                                    <td class=""><?php echo $rite->project; ?></td>
                                    <td class=""><?php echo $rite->proof == 1 ? "نعم" : "لا"; ?></td>
                                    <td class=""><?php echo $rite->arrangement; ?></td>
                                    <td class=""><?php echo $rite->time_taken; ?></td>
                                    <td class="ltr"><?php echo date('Y/ m/ d | H:i a', $rite->create_date); ?></td>
                                    <td class="ltr"><?php echo date('Y/ m/ d | H:i a', $rite->modified_date); ?></td>
                                    <td class="form-group">
                                        <?php
                                        if (!$rite->status) {
                                            echo '<a href="' . ADMINURL . '/rites/publish/' . $rite->rite_id . '" class="btn btn-xs btn-warning" type="button" data-toggle="tooltip" data-original-title="غير منشور"><i class="fa fa-ban"></i></a>';
                                        } elseif ($rite->status == 1) {
                                            echo '<a href="' . ADMINURL . '/rites/unpublish/' . $rite->rite_id . '" class="btn btn-xs btn-success" type="button" data-toggle="tooltip" data-original-title="منشور"><i class="fa fa-check"></i></a>';
                                        }
                                        ?>
                                        <a href="<?php echo ADMINURL . '/rites/show/' . $rite->rite_id; ?>" class="btn btn-xs btn-success" data-placement="top" data-toggle="tooltip" data-original-title="عرض"><i class="fa fa-eye"></i></a>
                                        <a href="<?php echo ADMINURL . '/rites/edit/' . $rite->rite_id; ?>" class="btn btn-xs btn-primary" data-placement="top" data-toggle="tooltip" data-original-title="تعديل"><i class="fa fa-edit"></i></a>
                                        <a href="<?php echo ADMINURL . '/rites/delete/' . $rite->rite_id; ?>" class="btn btn-xs btn-danger" data-placement="top" data-toggle="tooltip" data-original-title="حذف" onclick="return confirm('Are you sure?') ? true : false"><i class="fa fa-trash-o"></i></a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>

                            <tr class="tab-selected">
                                <th></th>
                                <th class="column-title" colspan="2"> العدد الكلي : <?php echo $data['recordsCount']; ?> </th>
                                <th class="column-title" colspan="3"> </th>
                                <th class="column-title"> عرض
                                    <select name="perpage" onchange="if (this.value)
                                                window.location.href = '<?php echo ADMINURL . '/rites/index/' . $data['current']; ?>' + '/' + this.value">
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
                    pagination($data['recordsCount'], $data['current'], $data['perpage'], 4, ADMINURL . '/rites');
                    ?>
                </ul>


            </form>

        </div>
    </div>
</div>
<?php
// loading  plugin
// loading  plugin
$data['footer'] = '
                   <script src="' . ADMINURL . '/template/default/vendors/select2/dist/js/select2.full.min.js"></script>
                   <script> $(".select2").select2({dir: "rtl"});</script>';

require ADMINROOT . '/views/inc/footer.php';
