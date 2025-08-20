<?php require APPROOT . '/app/views/inc/header.php'; ?>
<style>
    .btn-primary{
        background-color: #a3bc40 !important;
        border-color: #a3bc40;
    }
</style>
<section id="slider" class="wow bounceInUp container-md p-0">
    <div class="owl-carousel">
        <div class="banner">
            <img class="d-block w-100" src="<?=  URLROOT . "/media/files/deceased/" . @$data['settings']['deceased']->campaign_image ?>" alt="">
        </div>
    </div>
    <h1 class="project-name"> <?php if (@exist($data['settings']['deceased']->campaign_name)) echo $data['settings']['deceased']->campaign_name; ?></h1>

</section>


    <div class="container bg-light text-right py-2">
        <div class="row justify-content-md-center">
            <div class="col-md-12" style="margin-top: 50px;">
                <?php flash('msg'); ?>
            </div>     
            <div class="col-lg-12 py-3 ">
                <?php if (@exist($data['settings']['deceased']->campaign_description)) echo $data['settings']['deceased']->campaign_description; ?>
            </div>

                <div class="col-lg-6 col-sm-12 py-5">
                    <div class="text-center py-2">
                        <h4 class="text-secondary h5"> بيانات الطلب</h4>
                    </div>
                    <form action="<?= URLROOT . '/deceaseds/index'; ?>" method="post" enctype="multipart/form-data" accept-charset="utf-8" class="needs-validation">
                    <!-- image ---------------------------------------------------------------------------------------------->
                    
                    <!-- name ----------------------------------------------------------------------------------------------->
                        <div class="form-group">
                            <label class="control-label" for="pageTitle"> اسم مقدم الطلب  : </label>
                            <input type="text" class="form-control <?php if (!empty($data['name_error'])) echo 'is-invalid'; ?>" name="name" value="<?= $data['name']??''; ?>" placeholder="الاسم بالكامل" >
                            <span class="invalid-feedback"><?= $data['name_error']; ?></span>
                        </div>
                    <!-- mobile --------------------------------------------------------------------------------------------->
                        <div class="form-group">
                            <label class="control-label" for="pageTitle">رقم الجوال : </label>
                            <input type="tel" data-inputmask="'mask': '9999999999'"  class="form-control <?php if (!empty($data['mobile_error'])) echo 'is-invalid'; ?>" name="mobile" placeholder="رقم الجوال" value="<?= $data['mobile']??''; ?>" >
                            <span class="invalid-feedback"><?= $data['mobile_error']; ?></span>
                        </div>
                    <!-- email ---------------------------------------------------------------------------------------------->
                        <div class="form-group">
                            <label class="control-label" for="pageTitle">البريد الالكتروني : </label>
                            <input type="email" class="form-control <?php if (!empty($data['email_error'])) echo 'is-invalid'; ?>" name="email" placeholder=" البريد الالكتروني" value="<?= $data['email']??''; ?>" >
                            <span class="invalid-feedback"><?= $data['email_error']; ?></span>
                        </div>
                    <!-- deceased_name -------------------------------------------------------------------------------------->
                        <div class="form-group">
                            <label class="control-label" for="pageTitle">اسم المتوفي : </label>
                            <input type="text" class="form-control <?php if (!empty($data['deceased_name_error'])) echo 'is-invalid'; ?>" name="deceased_name" placeholder="  اسم المتوفي" value="<?= $data['deceased_name']??''; ?>" >
                            <span class="invalid-feedback"><?= $data['deceased_name_error']; ?></span>
                        </div>
                    <!-- relative_relation ---------------------------------------------------------------------------------->
                        <div class="form-group">
                            <label class="control-label" for="pageTitle">صله القرابة : </label>
                            <input type="text" class="form-control <?php if (!empty($data['relative_relation_error'])) echo 'is-invalid'; ?>" name="relative_relation" placeholder="  صله القرابة" value="<?= $data['relative_relation']??''; ?>" >
                            <span class="invalid-feedback"><?= $data['relative_relation_error']; ?></span>
                        </div>
                    <!-- Project -------------------------------------------------------------------------------------------->
                        <div class="form-group">
                            <label class="control-label" for="pageTitle">  المشروع الذي ترغب في جمع التبرع له صدقة عن المتوفي  : </label>
                            <select name="project_id" id="" class="form-control  <?php if (!empty($data['project_id_error'])) echo 'is-invalid'; ?>" >
                                <option value=""> اختار المشروع</option>
                                <?php
                                if (@exist($data['projects'])) 
                                    foreach($data['projects'] as $project){
                                        if( $project->project_id == $data['project_id']){
                                            echo ' <option value="'. $project->project_id .'" selected>'. $project->name .' </option>';
                                        }
                                        else{
                                            echo ' <option value="'. $project->project_id .'">'. $project->name .' </option>';
                                        }
                                    }
                                ?>
                            </select>
                            <span class="invalid-feedback"><?= $data['project_id_error']; ?></span>
                        </div>
            
                    <!-- target_price --------------------------------------------------------------------------------------->
                        <div class="form-group">
                            <label class="control-label" for="pageTitle"> المبلغ المستهدف جمعه صدقة عن المتوفي  : </label>
                            <input type="number" step="any"  class="form-control <?php if (!empty($data['target_price_error'])) echo 'is-invalid'; ?>" name="target_price" placeholder=" المبلغ المتوقع "  value="<?= $data['target_price']??''; ?>" >
                            <span class="invalid-feedback"><?= $data['target_price_error']; ?></span>
                        </div>
                
                
                    <!-- deceased_image ------------------------------------------------------------------------------------->
                        <div class="form-group <?= (!empty($data['deceased_image_error'])) ? 'is-invalid' : ''; ?>">
                            <label class="control-label" for="imageUpload"> ارفاق صورة للمتوفي - يتم اضافتها في رابط التبرع / اختياري : </label>
                            <div class="has-feedback input-group">
                                <span class="input-group-btn">
                                    <span class="btn btn-primary" onclick="$(this).parent().find('input[type=file]').click();">اختار الملف</span>
                                    <input name="deceased_image" value="" onchange="$(this).parent().parent().find('.form-control').html($(this).val().split(/[\\|/]/).pop());" style="display: none;" type="file">
                                </span>
                                <span class="form-control"><small><?= empty($data['deceased_image']) ? ' قم بأختيار صورة مناسبة' : $data['deceased_image']; ?></small></span>
                            </div>
                            <div class="text-danger"><?= @$data['deceased_image_error'] ??""; ?></div>
                        </div>
                    <!-- description ---------------------------------------------------------------------------------------->
                        <div class="form-group">
                            <label class="control-label" for="pageTitle">  اكتب ( كلمة / رسالة / دعاء ) للمتوفي لاضافته في رابط التبرع / اختياري  : </label>
                            <textarea name="description"  class="form-control <?php if (!empty($data['description_error'])) echo 'is-invalid'; ?>"id="" cols="30" rows="10"> <?= $data['description']??''; ?></textarea>
                            <span class="invalid-feedback"><?= $data['description_error']; ?></span>
                        </div>


                        <div class="form-group">
                            <div class="g-recaptcha" data-sitekey="6LcVHY8bAAAAAMlrDHrlL1G-22ySTHpAFRYDZlQy"></div>
                            <span class="text-danger"><?= $data['captcha_error']??''; ?></span>
                        </div>
                        <div class="col-xs-12 text-center">
                            <button type="submit" name="submit" class="btn btn-primary px-5 py-2"> ارسال الطلب
                                <i class="fa fa-save"> </i></button>
                        </div>
                        <br>
                    </form>
                </div>

        </div>
    </div>

<?php
    $data['settings']['site']->footer_code .= '<script src="https://www.google.com/recaptcha/api.js" async defer></script>';
    require APPROOT . '/app/views/inc/footer.php'; 
?>

