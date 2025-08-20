<?php require APPROOT . '/app/views/inc/header.php'; ?>
<div class="text-center py-5 mb-0 undermenu  bg-success text-light h3 bg-battern">
    <h3 class="py-4 mt-4"> شكراً لك </h3>
</div>
<div class="bg-light">
    <div class="container text-right py-5">
        <div class="row justify-content-md-center">
            <div class="col-lg-6 py-5 text-center">
                <img src="<?php echo MEDIAURL ?>/logo.png" alt="" class="img-fluid p-5">
                <?php flash('msg'); ?>
                <?php
                pr($data['settings']['site']->thankyou);
                ?>
                <a class="mt-5 btn px-5 btn-primary" href="<?php echo URLROOT; ?>"><i class=" icofont-home"></i> العودة الي الرئيسية</a>
            </div>
        </div>
    </div>
</div>
<?php require APPROOT . '/app/views/inc/footer.php'; ?>