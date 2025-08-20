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
    <?php flash('donor_msg');?>
    <div class="page-title">
        <div class="title_right">
            <h3><?php echo $data['page_title']; ?> <small>عرض تفاصيل المتبرع </small></h3>
        </div>
        <div class="title_left">
            <a href="<?php echo ADMINURL; ?>/donors" class="btn btn-success pull-left">عودة <i class="fa fa-reply"></i></a>
        </div>
    </div>
    <div class="col-lg-12 col-sm-12 col-xs-12 profile_details">
        <div class="col-lg-12 col-sm-12 col-xs-12 well profile_view">
            <div class="col-sm-12">
                <div class="col-xs-4">
                    <h2 class=" x_title"><?php echo $data['donor']->full_name; ?></h2>
                    <p class="h5"><i class="fa fa-envelope"></i> <strong>البريد الالكتروني : </strong><?php echo $data['donor']->email; ?></p>
                    <p class="h5"><i class="fa fa-mobile"></i> <strong>الجوال : </strong><?php echo $data['donor']->mobile; ?></p>
                    <p class="h5"><i class="fa fa-credit-card"></i> <strong>رقم الهوية : </strong><?php echo $data['donor']->identity; ?></p>
                    <p class="h5"><i class="fa fa-toggle-on"> </i> <strong>حالة المتبرع : </strong>
                        <?php
                        if ($data['donor']->status == 1) {
                            echo '<span class="btn btn-sm btn-success">نشط</span>';
                        } elseif ($data['donor']->status == 0) {
                            echo '<span class="btn btn-sm btn-warning">محظور</span>';
                        } else {
                            echo '<span class="btn btn-sm btn-danger">محذوف</span>';
                        }
                        ?>
                    </p>
                    <p class="h5"><i class="fa fa-calendar"></i> <strong>مسجل منذ : </strong><?php echo date('Y/ m/ d | H:i a', $data['donor']->create_date); ?></p>
                    <p class="h5"><i class="fa fa-calendar"></i> <strong>اخر تعديل : </strong><?php echo date('Y/ m/ d | H:i a', $data['donor']->modified_date); ?></p>
                    <br><br>
                    <div class="br">
                        <h2 class="h_title">مراسلة العضو</h2>
                        <form action="donor/sendsms" method="post">
                            <div class="form-group">
                                <label for="my-textarea">SMS</label>
                                <textarea id="sms" class="form-control" name="sms" rows="3"></textarea>
                            </div>
                            <input type="submit" value="send" class="btn btn-success">
                        </form>
                        <br><br>
                        <form action="donor/sendemail" method="post">
                        <div class="form-group">
                            <label for="my-textarea">Email</label>
                            <textarea id="email" class="form-control" name="email" rows="6"></textarea>
                        </div>
                        <input type="submit" value="send" class="btn btn-success">
                        </form>
                    </div>
                </div>
                <div class="col-xs-8">
                <h2 class=" x_title">سجل التبرعات</h2>
                <div class="table-responsive">
                    <table class="table table-striped jambo_table bulk_action">
                        <thead>
                            <tr class="headings">
                                <th class="column-title">معرف التبرع </th>
                                <th class="column-title">القيمة </th>
                                <th class="column-title">المشروع </th>
                                <th class="column-title">تاريخ التبرع </th>
                                <th class="column-title">آخر تحديث </th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($data['donations'] as $donation): ?>
                                <tr class="even pointer">
                                    <td><?php echo $donation->donation_identifier; ?></td>
                                    <td><?php echo $donation->amount; ?></td>
                                    <td><?php echo $donation->project; ?></td>
                                    <td class="ltr"><?php echo date('Y/ m/ d | H:i a', $donation->create_date); ?></td>
                                    <td class="ltr"><?php echo date('Y/ m/ d | H:i a', $donation->modified_date); ?></td>
                                </tr>
                            <?php endforeach;?>

                        </tbody>
                    </table>
                </div>
                </div>
            </div>
            <div class="col-lg-12 bottom text-right">
                <span class="col-lg-12">
                <a  href="<?php echo ADMINURL . '/donors/edit/' . $data['donor_id']; ?>" class="btn btn-primary">
                    <i class="fa fa-edit"></i> تعديل
                </a>
                </span>
            </div>
        </div>
    </div>

</div>

<?php
// loading plugin
$data['footer'] = '';

require ADMINROOT . '/views/inc/footer.php';
