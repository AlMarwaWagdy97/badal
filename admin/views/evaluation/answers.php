<?php
/*
 * Copyright (C) 2024 Easy CMS Framework Ahmed Elmahdy
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

<div class="right_col" role="main">
    <div class="clearfix"></div>
    <?php flash('evaluation_msg'); ?>
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
                            <tr class="form-group-sm">
                                <th width="50px"><input type="submit" name="search[submit]" value="بحث" class="btn btn-sm btn-primary search-query" /></th>
                                <th width="100px">
                                    <select class="form-control" name="search[type]">
                                        <option value=""></option>
                                        <option value="employee">موظف </option>
                                        <option value="student"> طالب </option>
                                    </select>
                                </th>
                                <th class=""><input type="search" class="form-control" placeholder="بحث بالأسم" name="search[name]" value=""></th>
                                <th class=""><input type="search" class="form-control" placeholder="بحث بالهاتف" name="search[mobile]" value=""></th>
                                <th class=""><input type="search" class="form-control" placeholder="بحث بالبريد" name="search[email]" value=""></th>
                                <th class=""><input type="search" class="form-control" placeholder="بحث بالنقاط" name="search[points]" value=""></th>
                                <th width="100px">
                                    <select class="form-control" name="search[points_text]">
                                        <option value=""></option>
                                        <option value="حالة مالية ممتازة">حالة مالية ممتازة </option>
                                        <option value="حالة مستقرة"> حالة مستقرة </option>
                                        <option value="يحتاج إلى مساندة"> يحتاج إلى مساندة</option>
                                        <option value="حالة تحت خط الفقر وتحتاج إلى دعم فوري"> حالة تحت خط الفقر وتحتاج إلى دعم فوري </option>
                                    </select>
                                </th>
                                <th class="column-title">
                                    تاريخ التسجيل 
                                    <div class="col-12">
                                        <input type="date" placeholder=" من" name="search[date_from]" value="<?php if (returnIsset(cleanSearchVar('date_from'))) echo date('Y-m-d', returnIsset(cleanSearchVar('date_from'))); ?>" class="">
                                        <input type="date" placeholder=" الي" name="search[date_to]" value="<?php if (returnIsset(cleanSearchVar('date_to'))) echo date('Y-m-d', (int) returnIsset(cleanSearchVar('date_to')) - 86400); ?>" class="">
                                    </div>
                                </th>
                                <th class="" colspan="2"></th>
                                <th width="100px">
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
                                <th class="column-title"> نوع </th>
                                <th class="column-title"> اسم </th>
                                <th class="column-title"> الهاتف </th>
                                <th class="column-title"> البريد </th>
                                <th class="column-title"> النقاط </th>
                                <th class="column-title"> التقييم </th>
                                <th class="column-title"> الاجابات </th>
                                <th class="column-title">تاريخ الانشاء </th>
                                <th class="column-title">آخر تحديث </th>
                                <th class="column-title no-link last"><span class="nobr">اجراءات</span>
                                </th>
                                <th class="bulk-actions" colspan="14">
                                    <span> تنفيذ علي الكل :</span>
                                    <input type="submit" name="publish" value="مقروءة" class="btn btn-success btn-xs" />
                                    <input type="submit" name="unpublish" value="غير مقروءة" class="btn btn-warning btn-xs" />
                                    <input type="submit" name="delete" value="حذف" onclick="return confirm('Are you sure?') ? true : false" class="btn btn-danger btn-xs" />
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ((object) $data['evaluationAnswers'] as $evaluationAnswer) : ?>
                                <tr class="even pointer <?= $evaluationAnswer->status ? '' : ' selected '; ?>">
                                    <td class="a-center">
                                        <input type="checkbox" class="records flat" name="record[]" value="<?= $evaluationAnswer->evaluation_answers_id; ?>">
                                    </td>
                                    <td class=""><?= $evaluationAnswer->type == "employee" ? ' موظف': 'طالب' ; ?></td>
                                    <td class=""><?= $evaluationAnswer->name; ?></td>
                                    <td class=""><?= $evaluationAnswer->mobile; ?></td>
                                
                                    <td class=""><?= $evaluationAnswer->email; ?></td>
                                    <td class=""><?= $evaluationAnswer->points; ?></td>
                                    <td class=""><?= $evaluationAnswer->points_text; ?></td>
                                    <td class="">
                                        <a href="<?= ADMINURL ?>/EvaluationsAnswers/show/<?= $evaluationAnswer->evaluation_answers_id ?>" class="btn btn-sm btn-primary">الاجابات </a>
                                    </td>

                                    <td class="ltr"><?= date('Y/ m/ d | H:i a', $evaluationAnswer->create_date); ?></td>
                                    <td class="ltr"><?= date('Y/ m/ d | H:i a', $evaluationAnswer->modified_date); ?></td>
                                    <td class="form-group">
                                        <?php
                                        if (!$evaluationAnswer->status) {
                                            echo '<a href="' . ADMINURL . '/EvaluationsAnswers/publish/' . $evaluationAnswer->evaluation_answers_id . '" class="btn btn-xs btn-warning" type="button" data-toggle="tooltip" data-original-title="غير مقروء"><i class="fa  fa-envelope-o"></i></a>';
                                        } elseif ($evaluationAnswer->status == 1) {
                                            echo '<a href="' . ADMINURL . '/EvaluationsAnswers/unpublish/' . $evaluationAnswer->evaluation_answers_id . '" class="btn btn-xs btn-success" type="button" data-toggle="tooltip" data-original-title="مقروء"><i class="fa fa-envelope"></i></a>';
                                        }
                                        ?>
                                        <a href="<?php echo ADMINURL . '/EvaluationsAnswers/delete/' . $evaluationAnswer->evaluation_answers_id; ?>" class="btn btn-xs btn-danger" data-placement="top" data-toggle="tooltip" data-original-title="حذف" onclick="return confirm('Are you sure?') ? true : false"><i class="fa fa-trash-o"></i></a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>

                            <tr class="tab-selected">
                                <th></th>
                                <th class="column-title" colspan="2"> العدد الكلي : <?php echo $data['recordsCount']; ?> </th>
                                <th class="column-title" colspan="5"> </th>
                                <th class="column-title"> عرض
                                    <select name="perpage" onchange="if (this.value)
                                                window.location.href = '<?php echo ADMINURL . '/EvaluationsAnswers/index/' . $data['current']; ?>' + '/' + this.value">
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
                    pagination($data['recordsCount'], $data['current'], $data['perpage'], 4, ADMINURL . '/EvaluationsAnswers');
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
