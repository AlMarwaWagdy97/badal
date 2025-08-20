<?php

$data['header'] = '';
header("Content-Type: text/html; charset=utf-8");

require ADMINROOT . '/views/inc/header.php';
?>

<!-- setting content -->
<div class="right_col" role="main">
    <div class="clearfix"></div>
    <?php flash('badalreview_msg'); ?>
    <div class="setting-title">
        <div class="title_right">
            <h3><small>االرد علي </small><?php echo $data['title']; ?> </h3>
        </div>
        <div class="title_left">
            <a href="<?php echo ADMINURL; ?>/badalorders" class="btn btn-success pull-left">عودة <i class="fa fa-reply"></i></a>
        </div>
    </div>
    <div class="clearfix"></div>
    <div class="row">
        <div class="form-group col-md-3 col-sm-12">
            <label class="control-label">التقيم : </label>
            <p> <?= str_repeat('&#9733;', $data['review']->rate); ?> </p>
        </div>
        <div class="form-group col-md-3 col-sm-12">
            <label class="control-label">وصف : </label>
            <p> <?= $data['review']->description ?> </p>
        </div>
        <?php if ($data['review']->email_reply == null ||  $data['review']->sms_reply == null) { ?>
            <div class="col-lg-12 col-sm-12 col-xs-12 options">

                <div class="accordion">
                    <div class="card">
                        <div class="x_panel tile ">
                            <form action="<?php echo ADMINURL . '/BadalReviews/edit/' . $data['review_id']; ?>" method="post" enctype="multipart/form-data" accept-charset="utf-8">
                            <input type="hidden" name="badal_id" value="<?= $data['review']->badal_id ?>">
                                <div class="new-order-container">
                                    <div class="card-header" data-toggle="collapse" data-target="#collapseOrder" aria-expanded="true" aria-controls="collapseOrder">
                                        <span> الرد علي تقيم الطلب</span>
                                    </div>
                                    <div id="collapseOrder" class="card-body collapse in" aria-labelledby="headingOne" aria-expanded="true">
                                        <?php if ($data['review']->email_reply == null) { ?>
                                            <div class="email-container">
                                                <h3> البريد الاكتروني</h3>

                                                <div class="form-group <?php echo (!empty($data['email_subject_error'])) ? 'has-error' : ''; ?>">
                                                    <label class="control-label" for="confirm_subject">عنوان الرسالة : </label>
                                                    <div class="has-feedback">
                                                        <input type="text" class="form-control" name="email_subject" placeholder="عنوان الرسالة">
                                                    </div>
                                                    <span class="help-block"><?php echo @$data['email_subject_error']; ?></span>
                                                </div>

                                                <div class="form-group <?php echo (!empty($data['email_msg_error'])) ? 'has-error' : ''; ?>">
                                                    <label class="control-label">المحتوي : </label>
                                                    <div class="row">
                                                        <textarea id="confirm_msg" name="email_msg" rows="6" class="form-control"></textarea>
                                                    </div>
                                                    <span class="help-block"><?php echo @$data['email_msg_error']; ?></span>
                                                </div>
                                            </div>
                                        <?php } ?>

                                        <?php if ($data['review']->sms_reply == null) { ?>
                                            <div class="sms">
                                                <h3> رساله ال SMS</h3>
                                                <div class="form-group <?php echo (!empty($data['sms_msg_error'])) ? 'has-error' : ''; ?>">
                                                    <label class="control-label">المحتوي : </label>
                                                    <div class="row">
                                                        <textarea id="confirm_sms_msg" name="sms_msg" rows="6" class="form-control"></textarea>
                                                    </div>
                                                    <span class="help-block"><?php echo @$data['sms_msg_error']; ?></span>
                                                </div>
                                            </div>
                                        <?php } ?>

                                        <div class="col-xs-12 col-md-offset-3">
                                            <button type="submit" name="save" class="btn btn-success">ارسال </button>
                                        </div>
                                    </div>
                                </div>
                                <br>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        <?php }
        else{ ?>
                <div class="form-group col-md-12 col-sm-12">
                    <label class="control-label">الرد علي البريد الاكتروني : </label>
                    <p> <?= $data['review']->email_reply ?> </p>
                </div>
                <div class="form-group col-md-12 col-sm-12">
                <label class="control-label">الرد علي  sms : </label>
                    <p> <?= $data['review']->sms_reply ?> </p>
                </div>

        <?php  } ?>

    </div>
</div>

<?php
require ADMINROOT . '/views/inc/footer.php';
?>