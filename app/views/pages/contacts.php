<?php require APPROOT . '/app/views/inc/header.php'; ?>

<div class="container text-right">
    <div class="row mx-5">
        <h3 class="text-center py-4 col-12">
            <img src="<?php echo URLROOT; ?>/templates/default/images/namaa-icon.png" alt="namaa-icon" class="my-3"><br>
            خدمة العملاء
        </h3>
        <div class="p-3 bg-battern mb-5 col-12 card">

            <h4 class="text-">
                خدمة العملاء
            </h4>
            <?php echo empty($data['settings']['contact']->cphone) ? '' : '<p class="m-2"><i class="text-primary pl-3 btn-lg icofont-ui-dial-phone"></i><strong>رقم الهاتف </strong>: ' . $data['settings']['contact']->cphone . '</p>'; ?>
            <?php echo empty($data['settings']['contact']->ctphone) ? '' : '<p class="m-2"><i class="text-primary pl-3 btn-lg icofont-ui-reply"></i><strong>رقم التحويلة  </strong>: ' . $data['settings']['contact']->ctphone . '</p>'; ?>
            <?php echo empty($data['settings']['contact']->cmobile) ? '' : '<p class="m-2"><i class="text-primary pl-3 btn-lg icofont-ui-cell-phone"></i><strong>رقم الجوال </strong>: ' . $data['settings']['contact']->cmobile . '</p>'; ?>
            <?php echo empty($data['settings']['contact']->cfax) ? '' : '<p class="m-2"><i class="text-primary pl-3 btn-lg icofont-fax"></i><strong>رقم الفاكس </strong>: ' . $data['settings']['contact']->cfax . '</p>'; ?>
            <?php echo empty($data['settings']['contact']->caddress) ? '' : '<p class="m-2"><i class="text-primary pl-3 btn-lg icofont-location-pin"></i><strong>العنوان  </strong>: ' . $data['settings']['contact']->caddress . '</p>'; ?>

        </div>
        <div class="col-md-5 border-left">
            <h4 class="text-">
                بيانات الاتصال
            </h4>
            <?php echo empty($data['settings']['contact']->phone) ? '' : '<p class="m-4"><i class="text-primary pl-3 btn-lg icofont-ui-dial-phone"></i><strong>رقم الهاتف </strong>: ' . $data['settings']['contact']->phone . '</p>'; ?>
            <?php echo empty($data['settings']['contact']->phone2) ? '' : '<p class="m-4"><i class="text-primary pl-3 btn-lg icofont-ui-dial-phone"></i><strong>رقم الهاتف </strong>: ' . $data['settings']['contact']->phone2 . '</p>'; ?>
            <?php echo empty($data['settings']['contact']->mobile) ? '' : '<p class="m-4"><i class="text-primary pl-3 btn-lg icofont-ui-cell-phone"></i><strong>رقم الجوال </strong>: ' . $data['settings']['contact']->mobile . '</p>'; ?>
            <?php echo empty($data['settings']['contact']->mobile2) ? '' : '<p class="m-4"><i class="text-primary pl-3 btn-lg icofont-ui-cell-phone"></i><strong>رقم الجوال </strong>: ' . $data['settings']['contact']->mobile2 . '</p>'; ?>
            <?php echo empty($data['settings']['contact']->fax) ? '' : '<p class="m-4"><i class="text-primary pl-3 btn-lg icofont-fax"></i><strong>رقم الفاكس </strong>: ' . $data['settings']['contact']->fax . '</p>'; ?>
            <?php echo empty($data['settings']['contact']->address) ? '' : '<p class="m-4"><i class="text-primary pl-3 btn-lg icofont-location-pin"></i><strong>العنوان  </strong>: ' . $data['settings']['contact']->address . '</p>'; ?>
            <?php echo empty($data['settings']['contact']->map) ? '' : '<iframe class="rounded" width="100%" src="' . $data['settings']['contact']->map . '" height="300px" allowfullscreen="" aria-hidden="false" tabindex="0"></iframe>'; ?>

            <div class="navbar navbar-expand text-center ">
                <ul class="navbar-nav mt-3 mx-auto ">
                    <li class="nav-item p-1">
                        <?php echo empty($data['settings']['social']->facebook) ? '' : '<a class="nav-link btn btn-lg btn-primary" href="' . $data['settings']['social']->facebook . '"><i class="h3 icofont-facebook"></i></a>'; ?>
                    </li>
                    <li class="nav-item p-1">
                        <?php echo empty($data['settings']['social']->twitter) ? '' : '<a class="nav-link btn btn-lg btn-primary" href="' . $data['settings']['social']->twitter . '"><i class="h3 icofont-twitter"></i></a>'; ?>
                    </li>
                    <li class="nav-item p-1">
                        <?php echo empty($data['settings']['social']->youtube) ? '' : '<a class="nav-link btn btn-lg btn-primary" href="' . $data['settings']['social']->youtube . '"><i class="h3 icofont-youtube"></i></a>'; ?>
                    </li>
                    <li class="nav-item p-1">
                        <?php echo empty($data['settings']['social']->instagram) ? '' : '<a class="nav-link btn btn-lg btn-primary" href="' . $data['settings']['social']->instagram . '"><i class="h3 icofont-instagram"></i></a>'; ?>
                    </li>
                    <li class="nav-item p-1">
                        <?php echo empty($data['settings']['social']->linkedin) ? '' : '<a class="nav-link btn btn-lg btn-primary" href="' . $data['settings']['social']->linkedin     . '"><i class="h3 icofont-linkedin"></i></a>'; ?>
                    </li>
                </ul>
            </div>

        </div>
        <div class="col-md-7">
            <div class="">
                <?php flash('msg'); ?>
                <form action="<?php echo URLROOT . '/pages/contact'; ?>" method="post" enctype="multipart/form-data" id="contact_form" accept-charset="utf-8">
                    <div class="col-sm-12 col-xs-12">
                        <div class="form-group  <?php echo (empty($data['subject_error'])) ?: 'has-error'; ?>">
                            <label class="control-label" for="pageTitle">الموضوع : </label>
                            <div class="has-feedback">
                                <input type="text" class="form-control" name="subject" placeholder="عنوان الموضوع" value="<?php echo $data['subject']; ?>">
                                <span class="fa fa-edit form-control-feedback" aria-hidden="true"></span>
                                <span class="text-danger"><?php echo $data['subject_error']; ?></span>
                            </div>
                        </div>
                        <div class="form-group  <?php echo (empty($data['full_name_error'])) ?: 'has-error'; ?>">
                            <label class="control-label" for="pageTitle">الاسم بالكامل : </label>
                            <div class="has-feedback">
                                <input type="text" class="form-control" name="full_name" placeholder="الاسم بالكامل" value="<?php echo $data['full_name']; ?>">
                                <span class="fa fa-edit form-control-feedback" aria-hidden="true"></span>
                                <span class="text-danger"><?php echo $data['full_name_error']; ?></span>
                            </div>
                        </div>
                        <div class="form-group  <?php echo (empty($data['city_error'])) ?: 'has-error'; ?>">
                            <label class="control-label" for="pageTitle">المدينة : </label>
                            <div class="has-feedback">
                                <input type="text" class="form-control" name="city" placeholder="المدينة" value="<?php echo $data['city']; ?>">
                                <span class="fa fa-edit form-control-feedback" aria-hidden="true"></span>
                                <span class="text-danger"><?php echo $data['city_error']; ?></span>
                            </div>
                        </div>
                        <div class="form-group ">
                            <label class="control-label">الغرض </label>
                            <div class="has-feedback">
                                <select name="type" class="form-control">
                                    <option value="">اختار الغرض من الرسالة </option>
                                    <?php foreach ($data['types'] as $type) : ?>
                                        <option value="<?php echo $type; ?>" <?php echo ($type == $data['type']) ? " selected " : ''; ?>>
                                            <?php echo $type; ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                                <span class="fa fa-folder form-control-feedback" aria-hidden="true"></span>
                                <span class="text-danger"><?php echo $data['type_error']; ?></span>
                            </div>
                        </div>
                        <div class="form-group ">
                            <label class="control-label" for="pageTitle">الهاتف : </label>
                            <div class="has-feedback">
                                <input type="text" class="form-control ltr" name="phone" placeholder="الهاتف" value="<?php echo $data['phone']; ?>" data-inputmask="'mask': '0599999999'">
                                <span class="fa fa-edit form-control-feedback" aria-hidden="true"></span>
                                <span class="text-danger"><?php echo $data['phone_error']; ?></span>
                            </div>
                        </div>
                        <div class="form-group ">
                            <label class="control-label" for="pageTitle">البريد الالكتروني : </label>
                            <div class="has-feedback">
                                <input type="text" class="form-control" name="email" placeholder="البريد الالكتروني" value="<?php echo $data['email']; ?>">
                                <span class="fa fa-edit form-control-feedback" aria-hidden="true"></span>
                            </div>
                        </div>
                        <div class="form-group  <?php echo (empty($data['message_error'])) ?: 'has-error'; ?>">
                            <label class="control-label">نص الرسالة : </label>
                            <textarea rows="5" name="message" class="form-control"><?php echo ($data['message']); ?></textarea>
                            <span class="text-danger"><?php echo $data['message_error']; ?></span>
                        </div>
                        <div class="form-group">
                            <div class="g-recaptcha" data-sitekey="6LcVHY8bAAAAAMlrDHrlL1G-22ySTHpAFRYDZlQy"></div>
                            <span class="text-danger"><?php echo $data['captcha_error']; ?></span>
                        </div>
                    </div>
                    <div class="col-xs-12 text-center">
                        <button type="submit" name="submit" class="btn btn-primary">ارسال
                            <i class="fa fa-save"> </i></button>
                    </div>
                    <br>
                </form>
            </div>
        </div>
    </div>
</div>

<?php
$data['settings']['site']->footer_code .= '<script src="https://www.google.com/recaptcha/api.js" async defer></script>';
require APPROOT . '/app/views/inc/footer.php'; ?>