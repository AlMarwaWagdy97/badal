<?php require APPROOT . '/app/views/inc/header.php'; ?>
<div class="text-center py-5 mb-0 undermenu  bg-success text-light h3 bg-battern">
    <h3 class="py-4 mt-4"> <?= $data['pageTitle']; ?> </h3>
</div>
<div class="bg-light">
    <div class="container text-right py-5">
        <div class="row justify-content-md-center">
            <div class="col-lg-6 py-5 text-center">
                <img src="<?= MEDIAURL ?>/logo.png" alt="" class="img-fluid p-5">
                <?php flash('msg'); ?>
                <div class="col-lg-12 col-sm-12 py-5">
                    <form action="<?= URLROOT . '/volunteering/otp/' . $data['id']; ?>" method="post" enctype="multipart/form-data" accept-charset="utf-8" class="needs-validation">
                        <div class="form-group">
                            <input type="text" class="form-control <?php if (!empty($data['otp_error'])) echo 'is-invalid'; ?>" name="otp" placeholder="رقم التأكيد" value="<?= $data['otp']; ?>">
                            <span class="invalid-feedback"><?= $data['otp_error']; ?></span>
                        </div>
                        <div class="col-xs-12 text-center">
                            <button type="submit" name="submit" class="btn btn-primary px-5 py-2"> تأكيد
                                <i class="fa fa-save"> </i></button>
                        </div>
                        <br>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?php require APPROOT . '/app/views/inc/footer.php'; ?>