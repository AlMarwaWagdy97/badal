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
            <h3><?php echo $data['page_title']; ?> <small>عرض كافة <?php echo $data['page_title']; ?> </small></h3>
        </div>
        <div class="title_left">
            <a href="<?php echo ADMINURL; ?>/EvaluationsAnswers" class="btn btn-success pull-left">عودة <i class="fa fa-reply"></i></a>
        </div>
    </div>

    <div class="clearfix"></div>

    <div class="container">
        <div class="row">

            <!-- type -->
            <div class="col-12 col-md-6">
                <div class="form-group">
                    <label class="control-label" for="pageTitle"> النوع: </label>
                    <div class="has-feedback">
                        <input type="text" class="form-control" name="type" placeholder="الاسم بالكامل" value="<?= $data['evaluationAnswer']->type == "employee" ? "موظف" : "طالب"; ?>" disabled>
                    </div>
                </div>
            </div>
            <!-- name -->
            <div class="col-12 col-md-6  m-5">
                <div class="form-group">
                    <label class="control-label" for="pageTitle">الاسم بالكامل : </label>
                    <div class="has-feedback">
                        <input type="text" class="form-control" name="name" placeholder="الاسم بالكامل" value="<?= $data['evaluationAnswer']->name; ?>" disabled>
                    </div>
                </div>
            </div>
            <!-- mobile -->
            <div class="col-12 col-md-6">
                <div class="form-group">
                    <label class="control-label pt-3" for="pageTitle">رقم الجوال : </label>
                    <div class="has-feedback">
                        <input type="text" class="form-control" name="mobile" placeholder="0500000000" id="mobile" data-inputmask="'mask': '9999999999'" value="<?= $data['evaluationAnswer']->mobile; ?>" disabled>
                    </div>
                </div>
            </div>
            <!-- email -->
            <div class="col-12 col-md-6 mt-3">
                <div class="form-group">
                    <label class="control-label" for="pageTitle">البريد الالكتروني : </label>
                    <div class="has-feedback">
                        <input type="text" class="form-control" name="email" placeholder=" البريد الالكتروني" value="<?= $data['evaluationAnswer']->email; ?>" disabled>
                    </div>
                </div>
            </div>

            <!-- points -->
            <div class="col-12 col-md-6">
                <div class="form-group">
                    <label class="control-label" for="pageTitle"> التقييم : </label>
                    <div class="has-feedback">
                        <input type="text" class="form-control" value="<?= $data['evaluationAnswer']->points_text; ?>" disabled>
                    </div>
                </div>
            </div>

            <!-- points -->
            <div class="col-12 col-md-6">
                <div class="form-group">
                    <label class="control-label" for="pageTitle"> النقاط : </label>
                    <div class="has-feedback">
                        <input type="text" class="form-control" value="<?= $data['evaluationAnswer']->points; ?>" disabled>
                    </div>
                </div>
            </div>


            <div class="form-group m-4 p-4">
                <br>
                <div class="col-12 col-md-6">
                <hr>

                    <?php foreach ($data['questions'] as $key => $question) { ?>
                        <div class="row mt-5">
                            <br>
                            <p class="control-label fw-bold py-5" for="pageTitle"> <strong> <?= $question ?> </strong> </p>
                            <div class="col-lg-12">
                                <?php foreach ($data['answers'][$key] as $val => $answer) {   ?>
                                    <div class="col-lg-12">
                                        <input type="radio" name="client_answer[<?= $key ?>]" value="<?= $val ?>" <?= $data['answerQuestions'][$key] ==  $val ?  'checked' : '' ?> disabled>
                                        <label><?= $answer ?> ( نقاط <?= ($val) ?> )</label>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </div>

        </div>
    </div>
</div>

<?php
// loading  plugin
$data['footer'] = "";

require ADMINROOT . '/views/inc/footer.php';
