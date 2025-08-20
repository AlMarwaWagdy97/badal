<?php require APPROOT . '/app/views/inc/header.php'; ?>
<!-- Categories -->
<section id="donors" class="undermenu bg-light">
    <div class="container bg-white">
        <?php flash('msg'); ?>
        <div class=" text-right">
            <div class="card-body">
                <h4 class="card-title">
                    <a class="btn-danger btn float-left" href="<?php root('donors/logout') ?>">تسجيل الخروج</a>
                    <a class="btn-primary btn float-left mx-2" href="<?php root('donors') ?>"> <i class="icofont-list"></i> سجل التبرعات
                    <a class="btn-primary btn float-left mx-2" href="<?php root('donors/account') ?>"> <i class="icofont-chart-line"></i>  الحساب الشخصي</a>

                </h4></a>
                <img src="<?php echo URLROOT; ?>/templates/default/images/namaa-icon.png" alt="Smiley face" class="ml-2">الملف الشخصي
                <p class="card-text">
                <form action="<?php echo URLROOT . '/donors/update/'; ?>" method="post" enctype="multipart/form-data" accept-charset="utf-8">
                    <div class="col-xs-12 form-group">
                        <label class="control-label" for="pageTitle">اسم المتبرع : </label>
                        <div class="has-feedback">
                            <input type="text" id="pageTitle" class="form-control" name="full_name" placeholder="اسم المتبرع" value="<?php echo $data['donor']->full_name; ?>">
                            <span class="fa fa-edit form-control-feedback" aria-hidden="true"></span>
                        </div>
                    </div>
                    <div class="col-xs-12 form-group ">
                        <label class="control-label" for="email">البريد الالكتروني : </label>
                        <div class="has-feedback">
                            <input type="email" id="email" class="form-control" name="email" placeholder="بريد المتبرع" value="<?php echo $data['donor']->email; ?>">
                            <span class="fa fa-envelope form-control-feedback" aria-hidden="true"></span>
                        </div>
                    </div>
                    <div class="col-xs-12 form-group ">
                        <label class="control-label" for="mobile">رقم الجوال : </label>
                        <div class="has-feedback">
                            <input type="text" id="mobile" disabled readonly class="form-control" name="mobile" placeholder="رقم الجوال" value="<?php echo $data['donor']->mobile; ?>">
                            <span class="fa fa-phone form-control-feedback" aria-hidden="true"></span>
                        </div>
                    </div>


                    <div class="col-md-9 col-sm-9 col-xs-12 col-md-offset-3">
                        <button type="submit" name="save" class="btn btn-success">تعديل <i class="fa fa-save"> </i></button>
                    </div>

                </form>

                </p>
            </div>
        </div>
    </div>
</section>
<!-- end Categories -->
<?php require APPROOT . '/app/views/inc/footer.php'; ?>