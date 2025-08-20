<?php require APPROOT . '/app/views/inc/header.php'; ?>
<!-- Categories -->
<section id="donors" class="undermenu bg-light">
    <div class="container bg-white">
        <?php flash('msg'); ?>
        <div class="row mt-3">
            <div class="col-md-3">
                <?php require APPROOT . '/app/views/inc/donor-sidenavbar.php'; ?>
            </div>
            <div class="col-md-9">
                <div class="card mt-3 mb-3 card-info border-0 ">
                    <div class="card-body">
                        <h5 class="text-right mb-3"> بطاقات الدفع </h5>
                        <div class="row">

                        <a class="btn btn-primary rounded-pill px-md-5" href="/donors/addcard"><i class="icofont-plus me-2" aria-hidden="true"></i>إضافة بطاقة جديدة</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</section>
<!-- end Categories -->
<?php require APPROOT . '/app/views/inc/footer.php'; ?>