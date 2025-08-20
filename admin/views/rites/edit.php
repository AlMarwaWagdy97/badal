<?php

// loading plugin style
$data['header'] = '<!-- Select2 -->
<link rel="stylesheet" href="' . ADMINURL . '/template/default/vendors/select2/dist/css/select2.min.css">';
header("Content-Type: text/html; charset=utf-8");

require ADMINROOT . '/views/inc/header.php';
?>
<!-- page content -->
<div class="right_col" role="main">
    <div class="clearfix"></div>
    <?php flash('rites_msg'); ?>
    <div class="page-title">
        <div class="title_right">
            <h3><?php echo $data['page_title']; ?> <small>تعديل مناسك الحج والعمره </small></h3>
        </div>
        <div class="title_left">
            <a href="<?php echo ADMINURL; ?>/rites" class="btn btn-success pull-left">عودة <i class="fa fa-reply"></i></a>
        </div>
    </div>
    <div class="clearfix"></div>
    <div class="row">
        <form action="<?php echo ADMINURL . '/rites/edit/'. $data['rite_id'];; ?>" method="post" enctype="multipart/form-data" accept-charset="utf-8">
            <div class="col-lg-8 col-sm-12 col-xs-12">
                <!-- title -------------------------------------------------------------------------------------------------------- -->
                <div class="form-group  <?php echo (empty($data['title_error'])) ?: 'has-error'; ?>">
                    <label class="control-label" for="pageTitle"> الاسم : </label>
                    <div class="has-feedback">
                        <input type="text" class="form-control name" name="title" placeholder="الاسم " value="<?php echo $data['title']; ?>">
                        <span class="fa fa-edit form-control-feedback" aria-hidden="true"></span>
                        <span class="help-block"><?php echo $data['title_error']; ?></span>
                    </div>
                </div>
           
                <!-- projects -------------------------------------------------------------------------------------------------------- -->
                <div class="form-group <?php echo (!empty($data['project_id_error'])) ? 'has-error' : ''; ?>">
                    <label class="control-label"> المشروع </label>
                    <div class="has-feedback">
                        <select class="form-control" name="project_id" style="width: 100%;">
                            <option value=""></option>
                            <?php foreach ($data['projects'] as $project) : ?>
                                <option value="<?php echo $project->project_id ?>" <?php echo $project->project_id == $data['project_id'] ? " selected " : ''; ?>>
                                    <?php echo  $project->name; ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <span class="fa fa-folder form-control-feedback" aria-hidden="true"></span>
                    </div>
                    <span class="help-block"><?php echo $data['project_id_error']; ?></span>
                </div>

                  <!-- image -------------------------------------------------------------------------------------------------------- -->
                  <div class="form-group <?= (empty($data['image_error'])) ?: 'has-error'; ?>">
                    <label class="control-label" for="imageUpload">الصوره   : </label>
                    <div class="has-feedback input-group">
                        <span class="input-group-btn">
                            <span class="btn btn-dark" onclick="$(this).parent().find('input[type=file]').click();">اختار الملف</span>
                            <input name="image" value="<?= ($data['image']); ?>"  onchange="$(this).parent().parent().find('.form-control').html($(this).val().split(/[\\|/]/).pop());" style="display: none;" type="file">
                        </span>
                        <span class="form-control"><small><?= empty($data['image']) ? 'قم بأختيار صورة مناسبة' : $data['image']; ?></small></span>
                    </div>
                    <div class="text-danger"><?= $data['image_error']; ?></div>
                    <a href="<?=  MEDIAURL . '/../files/rites/' . $data['image'] ?>" target="_blank"><img src="<?=   MEDIAURL . '/../files/rites/' . $data['image'] ?>" alt="" width="160"></a>
                </div>
             
            </div>

            <div class="col-lg-4 col-sm-12 col-xs-12 options">
                <h4>الاعدادات</h4>
                
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header" data-toggle="collapse" data-target="#collapseZero" aria-expanded="true" aria-controls="collapseZero">
                                <span> اعدادات المنتج </span>
                            </div>
                            <div id="collapseZero" class="collapse in card-body" aria-labelledby="headingZero">
                                <!-- arrangement -------------------------------------------------------------------------------------------------------- -->
                                <div class="form-group">
                                    <label>الترتيب : </label>
                                    <input type="number" class="form-control" name="arrangement" value="<?php echo $data['arrangement']; ?>" placeholder="الترتيب">
                                </div>
                                <!-- time_taken -------------------------------------------------------------------------------------------------------- -->
                                <div class="form-group">
                                    <label>وقت  (دقيقة) : </label>
                                    <input type="number" class="form-control" name="time_taken" value="<?php echo @$data['time_taken']; ?>" placeholder="الترتيب">
                                </div>
                                <!-- proof -------------------------------------------------------------------------------------------------------- -->
                                <div class="form-group <?php echo (!empty($data['proof_error'])) ? 'has-error' : ''; ?>">
                                    <div class="radio">
                                    <label class="control-label">هل يتطلب رفع الفيديو : </label>
                                        <label><input type="radio" class="proof" <?php echo ($data['proof'] == 1) ? 'checked' : ''; ?> value="1" name="proof"> نعم </label>
                                        <label><input type="radio" class="proof" <?php echo ($data['proof'] == 0) ? 'checked' : ''; ?> value="0" name="proof"> لا </label>
                                    </div>
                                    <span class="help-block"><?php echo $data['proof_error']; ?></span>
                                </div>

                                <!-- status -------------------------------------------------------------------------------------------------------- -->
                                <div class="form-group col-xs-12 <?php echo (!empty($data['status_error'])) ? 'has-error' : ''; ?>">
                                    <div class="radio">
                                        <label class="control-label">حالة النشر :</label>
                                        <label><input type="radio" class="status" <?php echo ($data['status'] == 1) ? 'checked' : ''; ?> value="1" name="status"> منشور </label>
                                        <label><input type="radio" class="status" <?php echo ($data['status'] == 0) ? 'checked' : ''; ?> value="0" name="status"> غير منشور </label>
                                        <span class="help-block"><?php echo $data['status_error']; ?></span>
                                    </div>
                                </div>


                            </div>
                        </div>
                    </div>
             
            </div>
            <div class="col-xs-12">
                <button type="submit" name="save" class="btn btn-success">تعديل
                        <i class="fa fa-save"> </i></button>
                    <button type="submit" name="submit" class="btn btn-success">تعديل وعودة
                        <i class="fa fa-save"> </i></button>
              
            </div>
        </form>
    </div>
</div>
<?php
// loading plugin
$data['footer'] = '';

require ADMINROOT . '/views/inc/footer.php';
