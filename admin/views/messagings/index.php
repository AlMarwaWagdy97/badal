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
$data['header'] = '<link rel="stylesheet" href="' . ADMINURL . '/template/default/vendors/select2/dist/css/select2.min.css">';

require ADMINROOT . '/views/inc/header.php';
?>

<!-- page content -->

<div class="right_col" role="main">
    <div class="clearfix"></div>
    <?php flash('messaging_msg'); ?>
    <div class="page-title">
        <div class="title_right">
            <h3><?php echo $data['title']; ?></h3>
        </div>
        <div class="title_left">
            <a href="<?php echo ADMINURL; ?>/orders" class="btn btn-success pull-left">عودة <i class="fa fa-reply"></i></a>
        </div>
    </div>
    <div class="clearfix"></div>
    <div class="options">
        <div class="accordion">
            <div class="card">
                <div class="card-header" data-toggle="" data-target="" aria-expanded="true" aria-controls="collapseZero">
                    <span> <i class="fa fa-envelope"> </i> ارسال رسالة </span>
                </div>
                <div id="collapseZero" class="collapse in card-body" aria-labelledby="headingZero">
                    <form action="<?php echo ADMINURL ?>/messagings/send" method="post" class="row">
                        <div class="form-group col-xs-12">
                            <label class="control-label">الي</label>
                            <select class="form-control select2" name="members[]" multiple="multiple" style="width: 100%;">
                                <?php foreach ($data['members'] as $member) {
                                    if ($data['type'] == 'SMS') {
                                        $mobile = str_replace('+', '', str_replace(' ', '', $member->mobile));
                                        echo '<option selected value="' . $member->order_id . '" >' . $mobile . '</option>';
                                    } else {
                                        if (empty($member->email)) continue;
                                        echo '<option selected value="' . $member->order_id . '" >' . $member->email . '</option>';
                                    }
                                } ?>
                            </select>
                        </div>
                        <?php if ($data['type'] == 'Email') : ?>
                            <div class="form-group col-xs-12 ">
                                <br>
                                <label for="donor" class="">عنوان الرسالة </label>
                                <input type="text" name="subject" id="subject" class="form-control" required>
                            </div>
                        <?php endif; ?>
                        <div class="form-group col-xs-12 ">
                            <br>
                            <button type="button" class="btn btn-primary" onclick="$('#message').val($('#message').val() +'[[name]]') ;return false;" value="">ارفاق الاسم </button>
                            <button type="button" class="btn btn-primary" onclick="$('#message').val($('#message').val() +'[[identifier]]') ;return false;" value="">ارفاق رقم الطلب </button>
                            <button type="button" class="btn btn-primary" onclick="$('#message').val($('#message').val() +'[[total]]') ;return false;" value="">ارفاق المبلغ </button>
                            <button type="button" class="btn btn-primary" onclick="$('#message').val($('#message').val() +'[[project]]') ;return false;" value="">ارفاق اسم المشروع </button>
                            <small class="red ">سيتم استبدال المتغير الخاص بالقيمة  </small>
                        </div>
                        <div class="form-group col-xs-12 ">
                            <br>
                            <label for="donor" class="">نص الرسالة </label>
                            <textarea name="message" id="message" class="form-control" rows="10"  required></textarea>
                        </div>
                        <div class="col-xs-12">
                            <button type="submit" name="<?php echo $data['type']; ?>" class="btn btn-success">ارسال</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <br><br>
    </div>
</div>
<?php
// loading  plugin
$data['footer'] = '<script src="' . ADMINURL . '/template/default/vendors/select2/dist/js/select2.full.min.js"></script>
<script src="' . ADMINURL . '/template/default/vendors/jquery.tagsinput/src/jquery.tagsinput.js"></script>
<script> $(".select2").select2({dir: "rtl"});</script>';

require ADMINROOT . '/views/inc/footer.php';
?>
<script>

</script>