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
$substitute = (object) $data['substitute'];
?>

<!-- page content -->

<div class="right_col" role="main">
    <div class="clearfix"></div>
    <?php flash('substitute_msg'); ?>
    <div class="page-title">
        <div class="title_right">
            <h3><?php echo $data['page_title']; ?> <small>عرض متطوع </small></h3>
        </div>
        <div class="title_left">
            <a href="<?php echo ADMINURL; ?>/substitutes" class="btn btn-success pull-left">عودة <i class="fa fa-reply"></i></a>
        </div>
    </div>

    <div class="clearfix"></div>

    <div class="row">
        <div class="col-xs-12 col-xs-12">
            <div class="form-group">
                <h3 class="prod_title">
                    <?php echo $substitute->full_name; ?>
                </h3>
            </div>
            <div class="form-group col-xs-6 col-md-6">
                <label class="control-label">الهوية : </label>
                <?php echo $substitute->identity; ?>
                <br>
                <a href="<?php echo URLROOT . "/media/files/substitutes/" . $substitute->image; ?>" target="blank">
                    <img src="<?php echo URLROOT . "/media/files/thumbs/" . $substitute->image; ?>">
                </a>
            </div>
            <div class="form-group col-xs-6 col-md-6">
                <label class="control-label">الجنسية : </label>
                <?php echo $substitute->nationality; ?>
            </div>
            <div class="form-group col-xs-6 col-md-6">
                <label class="control-label">الجنس : </label>
                <?php echo $substitute->gender; ?>
            </div>
            <div class="form-group col-xs-6 col-md-6">
                <label class="control-label">البريد الالكتروني : </label>
                <?php echo $substitute->email; ?>
            </div>
            <div class="form-group col-xs-6 col-md-6">
                <label class="control-label">الهاتف : </label>
                <?php echo $substitute->phone; ?>
            </div>
            <div class="form-group col-xs-6 col-md-6">
                <label class="control-label">اللغة : </label>
                <ul>
                    <?php
                    if ($substitute->languages) {
                        foreach (explode(",", $substitute->languages) as $lang) {
                            echo '<li>' . $lang . '</li>';
                        }
                    }
                    ?>
                </ul>

            </div>
            <div class="form-group col-xs-6 col-md-6">
                <label class="control-label">النسبة : </label>
                <p><?php echo $substitute->proportion  ?></p>
            </div>
            <div class="form-group col-xs-6 col-md-6">
                <label class="control-label">الحالة : </label>
                <p><?php echo $substitute->status ? 'مقروءة' : 'غير مقروءة'; ?></p>
            </div>
            <div class="form-group col-xs-6 col-md-6">
                <label class="control-label">اخر تحديث : </label>
                <p><?php echo $substitute->modified_date ? date('d/ M/ Y', $substitute->modified_date) : 'لا'; ?></p>
            </div>
            <div class="form-group col-xs-6 col-md-6">
                <label class="control-label">وقت الإنشاء : </label>
                <p><?php echo $substitute->create_date ? date('d/ M/ Y', $substitute->create_date) : 'لا'; ?></p>
            </div>

            <hr>

            <div class="form-group col-xs-12 col-md-12">
                <label class="control-label"> العروض: </label>
                <div class="table-responsive" style="min-height: auto">
                    <table class="table table-striped jambo_table bulk_action">
                        <thead>
                            <tr class="headings">
                                <th class="column-title">رقم العرض </th>
                                <th class="column-title">المشروع </th>
                                <th class="column-title">المتطوع </th>
                                <th class="column-title">القيمه </th>
                                <th class="column-title">بداء من </th>
                                <th class="column-title">تاريخ التبرع </th>
                                <th class="column-title">آخر تحديث </th>
                                <th class="column-title">آخر تحديث </th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($data['offers'] as $offer) : ?>
                                <tr class="even pointer">
                                    <td><?php echo $offer->offer_id; ?></td>
                                    <td><?php echo $offer->project; ?></td>
                                    <td><?php echo $offer->substitute_name; ?></td>
                                    <td><?php echo $offer->amount; ?></td>
                                    <td class="ltr"><?php echo $offer->start_at ? date('Y/ m/ d | H:i a', $offer->start_at) : ""; ?></td>
                                    <td class="ltr"><?php echo date('Y/ m/ d | H:i a', $offer->create_date); ?></td>
                                    <td class="ltr"><?php echo date('Y/ m/ d | H:i a', $offer->modified_date); ?></td>
                                    <td class="form-group">
                                        <?php
                                        if (!$offer->status) {
                                            echo '<i class="fa fa-ban btn btn-xs btn-warning"></i></a>';
                                        } elseif ($offer->status == 1) {
                                            echo '<i class="fa fa-check btn btn-xs btn-success"></i></a>';
                                        }
                                        ?>
                                        <a href="<?php echo ADMINURL . '/badalOffers/show/' . $offer->offer_id; ?>" class="btn btn-xs btn-primary" data-placement="top" data-toggle="tooltip" data-original-title="عرض"><i class="fa fa-edit"></i></a>
                                        <a href="<?php echo ADMINURL . '/badalOffers/delete/' . $offer->offer_id; ?>" class="btn btn-xs btn-danger" data-placement="top" data-toggle="tooltip" data-original-title="حذف" onclick="return confirm('Are you sure?') ? true : false"><i class="fa fa-trash-o"></i></a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <hr>

            <div class="form-group col-xs-12 col-md-12">
                <label class="control-label"> العروض: </label>
                <div class="table-responsive" style="min-height: auto">
                    <table class="table table-striped jambo_table bulk_action">
                        <thead>
                            <tr class="headings">
                                <th class="column-title">رقم </th>
                                <th class="column-title">العمليه </th>
                                <th class="column-title"> النسبة </th>
                                <th class="column-title"> وصف </th>
                                <th class="column-title">تاريخ التبرع </th>
                                <th class="column-title no-link last" width="140"><span class="nobr">اجراءات</span></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($data['reviews'] as $review) : ?>
                                <tr class="even pointer">
                                
                                    <td><?php echo $review->review_id; ?></td>
                                    <td><?php echo '<a href="' . ADMINURL . '/badalorders/show/' . $review->badal_id . '" >' . $review->badal_id . '</a>'; ?></td>
                                    <!-- <td><?php echo $review->type == "donor" ? "متبرع" : "متطوع"; ?></td> -->
                                    <!-- <td><?php echo $review->type_id; ?></td> -->
                                    <td><?php echo $review->description; ?></td>
                                    <td><?php echo @$data['reviews'][$review->rate]; ?></td>
                                    <td class="ltr"><?php echo date('Y/ m/ d | H:i a', $review->create_date); ?></td>
                                    <td class="form-group">
                                        <a href="<?php echo ADMINURL . '/BadalReviews/show/' . $review->review_id; ?>" class="btn btn-xs btn-primary"> عرض </a>
                                        <a href="<?php echo ADMINURL . '/SubstituteRates/delete/' . $review->review_id; ?>" class="btn btn-xs btn-danger" data-placement="top" data-toggle="tooltip" data-original-title="حذف" onclick="return confirm('Are you sure?') ? true : false"><i class="fa fa-trash-o"></i></a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="form-group col-xs-12">
            <a class="btn btn-info" href="<?php echo ADMINURL . '/substitutes/edit/' . $substitute->substitute_id; ?>">تعديل</a>
        </div>



    </div>
</div>

<?php
// loading plugin
$data['footer'] = '';

require ADMINROOT . '/views/inc/footer.php';
