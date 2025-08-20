<?php require APPROOT . '/app/views/inc/header.php'; ?>

<div class="container bg-light text-right py-2">
    <?php flash('msg'); ?>


    <?php if (! empty(flash('msg'))  == NULL) { ?>
        <div class="row justify-content-md-center">
            <div class="col-lg-6 col-sm-12 py-5">
                <div class="text-center py-2">
                    <h2 class="text-secondary"> <?php echo $data['page_title'] ?></h2>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body text-center text-secondary">
                                <h4>عزيزي  <?= $data['name'] ?> </h4>
                                <br>

                                <h6 class="mt-3">
                                نود إبلاغك بأن وضعك المالي  <?= $data['points_text'] ?>
                                </h6>
                                <br>

                                <p class="my-3">
                                  . لا تتردد في التواصل معنا لطلب الاستشارة، فنحن هنا لدعمك.
                                </p>
                                <br>

                                <p class="my-3">
                                    مع التحية،
                                    جمعية نماء الاهلية
                                </p>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php } ?>
</div>

<?php
$data['settings']['site']->footer_code .= '<script src="https://www.google.com/recaptcha/api.js" async defer></script>';
require APPROOT . '/app/views/inc/footer.php';
?>