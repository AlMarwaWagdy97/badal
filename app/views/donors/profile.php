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
                <div class="card mt-3 mb-3 card-info border-0 text-right" dir="rtl">
                    <div class="card-body h-100">
                        <h5 class="text-right mb-3"> تعديل الملف الشخصي </h5>
                        <div class="card  edit-mobile m-3 p-3">
                            <form action="<?php echo URLROOT . '/donors/updateprofile/'; ?>" method="post" enctype="multipart/form-data" accept-charset="utf-8">
                                <div class="col-xs-12 form-group">
                                    <label class="control-label" for="pageTitle">اسم المتبرع : </label>
                                    <div class="has-feedback">
                                        <input type="text" id="pageTitle" class="form-control" name="full_name" placeholder="اسم المتبرع" value="<?php echo $data['donor']->full_name; ?>" required>
                                        <span class="fa fa-edit form-control-feedback" aria-hidden="true"></span>
                                    </div>
                                </div>
                                <div class="col-xs-12 form-group ">
                                    <label class="control-label" for="email">البريد الالكتروني : </label>
                                    <div class="has-feedback">
                                        <input type="email" id="email" class="form-control" name="email" placeholder="بريد المتبرع" value="<?php echo $data['donor']->email; ?>" required>
                                        <span class="fa fa-envelope form-control-feedback" aria-hidden="true"></span>
                                    </div>
                                </div>
                                <div class="col-xs-12 form-group ">
                                    <label class="control-label" for="email"> رقم الهوية : </label>
                                    <div class="has-feedback">
                                        <input type="text" id="identity" class="form-control" name="identity" placeholder="رقم الهوية" maxlength="10" value="<?php echo $data['donor']->identity; ?>" required>
                                        <span class="fa fa-envelope form-control-feedback" aria-hidden="true"></span>
                                    </div>
                                </div>
                                <div class="col-md-9 col-sm-9 col-xs-12 col-md-offset-3">
                                    <button type="submit" name="save" class="btn btn-success">تعديل <i class="fa fa-save"> </i></button>
                                </div>

                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</section>
<!-- end Categories -->
<?php
require APPROOT . '/app/views/inc/footer.php';
?>