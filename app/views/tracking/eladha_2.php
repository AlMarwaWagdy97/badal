<?php
$data['settings']['site']->header_code .= '<link rel="stylesheet" href="' .  URLROOT  . '/templates/namaa/css/tracking.css?v=0.0.2" />';
require APPROOT . '/app/views/inc/header.php'; ?>

<section dir="ltr" class="eladha-tracking">
    <div class="container">
        
        <div class="eladha">
            <div class="row">
                <div class="col-md-4 col-6 eladha-logo">
                    <div class="logo">
                        <img src="<?= URLROOT . '/media/files/eladha/' . @$data['eladha']->logo ?>" alt="" class="w-100 pt-1" />
                    </div>
                </div>
                <div class="col-md-8 col-6 eladha-title" dir="rtl">
                    <div class="title">
                        <h3> <?= @$data['eladha']->title ?> </h3>
                    </div>
                </div>
            </div>
        </div>
        <div class="tracking">

            <?php if (isset($data['eladha']->tracking)) {   ?>
                <?php foreach (@$data['eladha']->tracking->name as $key => $track) {  ?>
                    <div class="row">
                        <div class="col-md-4 col-sm-4 col-4">
                            <div class="box-icon">
                                <img src="<?= URLROOT . '/media/files/eladha/' . $data['eladha']->tracking->logo[$key] ?>" alt="">
                                <p> <?= @$data['eladha']->tracking->name[$key] ?> </p>
                            </div>
                        </div>
                        
                        <div class="col-md-7 col-sm-7 col-8">
                            <div class="box-prog">

                                <?php if (@$data['eladha']->tracking->start[$key] == 1 && @$data['eladha']->tracking->end[$key] == 1) { ?>
                                    <div class="progress">
                                        <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%"> </div>
                                    </div>
                                    <div class="progress-icon">
                                        <img src="<?= URLROOT ?>/templates/namaa/images/tracking/completed.png" alt="اكتمل" class="w-50">
                                    </div>
                                <?php } else if (@$data['eladha']->tracking->start[$key] == 1) { ?>
                                    <div class="progress">
                                        <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 80%"> </div>
                                    </div>
                                    <div class="progress-icon">
                                        <img src="<?= URLROOT ?>/templates/namaa/images/tracking/reload.png" alt="في التجهيز" class="w-50">
                                    </div>
                                <?php } else { ?>
                                    <div class="progress">
                                        <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 0%"> </div>
                                    </div>
                                    <div class="progress-icon">
                                        <img src="<?= URLROOT ?>/templates/namaa/images/tracking/notcomplete.png" alt="في الانتظار" class="w-50">
                                    </div>
                                <?php }  ?>
                            </div>

                            <?php if (@$data['eladha']->tracking->video[$key] != null) { ?>
                                <div class="col-md-12">
                                    <div class="box-play">
                                        <a href="<?= URLROOT . '/tracking/video/' . @base64_encode($key) . '/2' ?>" target="_blank">
                                            <img src="<?= URLROOT ?>/templates/namaa/images/tracking/video.png" alt="فديو" width="20">
                                            مشاهده الفيديو
                                        </a>
                                    </div>
                                </div>
                            <?php }  ?>

                        </div>

                    </div>
                <?php }  ?>
            <?php } ?>

        </div>
    </div>


    <div class="mb-5">
    </div>

</section>


<?php
require APPROOT . '/app/views/inc/footer.php';
?>