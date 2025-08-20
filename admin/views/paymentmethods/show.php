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
    <?php flash('paymentmethod_msg');?>
    <div class="page-title">
        <div class="title_right">
            <h3><?php echo $data['page_title']; ?> <small>عرض محتوي الصفحة </small></h3>
        </div>
        <div class="title_left">
            <a href="<?php echo ADMINURL; ?>/paymentmethods" class="btn btn-success pull-left">عودة <i class="fa fa-reply"></i></a>
        </div>
    </div>

    <div class="clearfix"></div>

    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="form-group">
                <h3 class="prod_title">
                    <?php echo $data['paymentmethod']->title; ?>
                </h3>
            </div>
            <div class="well col-md-6">
                <img class="img-responsive img-rounded" src="<?php echo empty($data['paymentmethod']->image) ? MEDIAURL . '/default.jpg' : MEDIAURL . '/' . $data['paymentmethod']->image; ?>" />

            </div>
            <?php if ($data['paymentmethod']->payment_id == 2): ?>
                <div class="form-group col-md-12">
                    <label class="control-label">الفروع   : </label>
                    <table class="table table-striped jambo_table text-center">
                        <thead>
                            <tr class="headings  text-center">
                                <th class="">اسم الفرع  </th>
                                <th class="">العنوان </th>
                                <th class="">رابط العنوان علي خرائط جوجل </th>
                            </tr>
                        </thead>
                        <tbody id="items">
                        <?php
                            $meta = json_decode($data['paymentmethod']->meta, true);
                            if (!empty($meta)) {
                                $x = 1;
                                foreach ($meta as $branch) {
                                    echo '<tr class="">
                                            <td class="form-group">' . $branch['branchname'] . '</td>
                                            <td class="form-group">' . $branch['address'] . '</td>
                                            <td class="form-group">' . $branch['url'] . '</td>
                                        </tr>';
                                    $x++;
                                }
                            }
                        ?>
                        </tbody>
                    </table>
                </div>
            <?php endif;?>
            <?php if ($data['paymentmethod']->payment_id  == 1): ?>
                <div class="form-group col-md-12">
                    <label class="control-label">الحسابات البنكية   : </label>
                    <table class="table table-striped jambo_table text-center">
                        <thead>
                            <tr class="headings  text-center">
                                <th class="">اسم البنك  </th>
                                <th class="">نوع الحساب </th>
                                <th class="">IBAN </th>
                                <th class="">رابط البنك </th>
                            </tr>
                        </thead>
                        <tbody id="items">
                        <?php
                        $meta = json_decode($data['paymentmethod']->meta, true);
                        if (!empty($meta)) {
                            $x = 1;
                            foreach ($meta as $bank) {
                                echo '<tr class="">
                                        <td>' . $bank['bankname'] . '</td>
                                        <td>' . $bank['account_type'] . '</td>
                                        <td>' . $bank['iban'] . '</td>
                                        <td>' . $bank['url'] . '</td>
                                    </tr>';
                                    $x++;
                                }
                            }
                        ?>
                        </tbody>
                    </table>
                </div>
            <?php endif;?>
            <div class="form-group col-md-6">
                <p><?php echo $data['paymentmethod']->content; ?></p>
            </div>
            <div class="form-group col-sm-12">
                <a class="btn btn-info" href="<?php echo ADMINURL . '/paymentmethods/edit/' . $data['paymentmethod']->payment_id; ?>" >تعديل</a>
            </div>


        </div>
    </div>
</div>

<?php
// loading plugin
$data['footer'] = '';

require ADMINROOT . '/views/inc/footer.php';
