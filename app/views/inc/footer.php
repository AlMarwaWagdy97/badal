<?php if ($data['settings']['site']->show_footer) : ?>
    <footer id="footer" class="footer-area bg-battern text-light pt-5 wow bounceInUp">
        <div class="container">
            <div class="row subscribe-area p-2">
                <div class="col-lg-5 col-md-12">
                    <div class="subscribe-content">
                        <h2 class="h4">اشترك في قائمتنا الإخبارية</h2>
                        <p>اشترك ليصلك الجديد منا</p>
                    </div>
                </div>
                <div class="col-lg-7 col-md-12">
                    <div class="subscribe-form">
                        <form class="d-flex">
                            <input type="email" class="form-control form-control-lg email" placeholder="أدخل البريد الإلكتروني">
                            <button type="submit" class="btn btn-lg btn-success">أشـتـرك <i class=" icofont-simple-left"></i></button>
                        </form>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-4 col-md-6 col-sm-1">

                    <div class="logo mt-4 pl-5">
                        <h3 class="h5 border-success border-bottom"><span class="border-bottom pb-3 d-inline-block">عن جمعيتنا </span></h3>
                        <p><?php echo $data['settings']['site']->about; ?></p>
                        <div class="footer-logo-co" style="padding-top: 10px;">
                            <img class="img-fluid" src="<?php echo URLROOT; ?>/media/images/2024/footer.png" alt="">
                        </div>
                        <div class="footer-logo-co" style="margin: 21px;">
                            <img class="img-fluid" src="<?php echo URLROOT; ?>/templates/namaa/images/footer-w-image.jpg" alt="">
                        </div>
                    </div>

                </div>
                <div class="col-lg-4 col-md-6 col-sm-1 mt-4 pl-5">
                    <h3 class="h5 border-success border-bottom"><span class="border-bottom pb-3 d-inline-block">روابط سريعة </span></h3>
                    <ul class="nav d-flex flex-row">
                        <li class="col-6 mt-3"><a class=" text-light" href="<?php URLROOT; ?>/pages/show/32">قيمنا</a></li>
                        <li class="col-6 mt-3"><a class=" text-light" href="<?php URLROOT; ?>/projectCategories">أقسامنا</a></li>
                        <li class="col-6 mt-3"><a class=" text-light" href="<?php URLROOT; ?>/articles">المركز الإعلامي</a></li>
                        <li class="col-6 mt-3"><a class=" text-light" href="<?php URLROOT; ?>/projectCategories">مشاريعنا</a></li>
                        <li class="col-6 mt-3"><a class=" text-light" href="<?php URLROOT; ?>/projectCategories/show/4">الإطعام</a></li>
                        <!--<li class="col-6 mt-3"><a class=" text-light" href="<?php URLROOT; ?>/projectCategories/show/10">الأوقاف</a></li>-->
                        <li class="col-6 mt-3"><a class=" text-light" href="<?php URLROOT; ?>/projectCategories/show/9">الكفالات</a></li>
                        <li class="col-6 mt-3"><a class=" text-light" href="<?php URLROOT; ?>/pages/show/11">حسابتنا البنكية</a></li>
                    </ul>
                    <div class="h1 mt-3 text-center icofont-5x">
                        <i class="icofont-bank-transfer"></i>
                        <i class="icofont-visa"></i>
                        <i class="icofont-mastercard"></i>
                        <i class="icofont-apple-pay"></i>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-sm-1  mt-4 pl-5">
                    <h3 class="h5 border-success border-bottom"><span class="border-bottom pb-3 d-inline-block">معلومات الاتصال </span></h3>
                    <ul class="footer-contact-info nav">
                        <li class="nav-link"><?php echo $data['settings']['contact']->address; ?></li>
                        <?php
                        if (isset($_SESSION['store']->email)) {
                            echo '<li class="nav-link"><span>البريد الالكتروني :</span> <a href="mailto:' . $_SESSION['store']->email . '"> ' . $_SESSION['store']->email . '</a></li>';
                        } else {
                            echo '<li class="nav-link"><span>البريد الالكتروني :</span> <a href="mailto:' . $data['settings']['contact']->email . '"> ' . $data['settings']['contact']->email . ' </a></li>';
                        }
                        if (isset($_SESSION['store']->mobile)) {
                            echo '<li class="nav-link d-block"><span> الجوال :</span><a class="" href="tel:' . $_SESSION['store']->mobile . '"> ' . $_SESSION['store']->mobile . '</a></li>';
                        } else {
                            echo '<li class="nav-link"><span> الجوال :</span><a href="tel:' . $data['settings']['contact']->mobile . '"> ' . $data['settings']['contact']->mobile . '</a></li>';
                        }
                        ?>
                        <li class="nav-link"><span>الهاتف :</span> <a href="tel:<?php echo $data['settings']['contact']->phone; ?>"> <?php echo $data['settings']['contact']->phone; ?></a></li>
                        <li class="nav-link"><span>الفاكس :</span> <a href="tel:<?php echo $data['settings']['contact']->fax; ?>"> <?php echo $data['settings']['contact']->fax; ?></a></li>
                    </ul>
                    <ul class="social nav mt-3 text-center">
                        <!-- <li class="nav-item p-1"> -->
                            <?php echo empty($data['settings']['social']->facebook) ? '' : '<a class="nav-link" href="' . $data['settings']['social']->facebook . '"><i class="icofont-facebook text-light icofont-2x"></i></a>'; ?>
                        <!-- </li> -->
                        <!-- <li class="nav-item p-1"> -->
                            <?php echo empty($data['settings']['social']->twitter) ? '' : '<a class="nav-link" href="' . $data['settings']['social']->twitter . '"><i class="text-light icofont-2x icofont-twitter"></i></a>'; ?>
                        <!-- </li> -->
                        <!-- <li class="nav-item p-1"> -->
                            <?php echo empty($data['settings']['social']->youtube) ? '' : '<a class="nav-link" href="' . $data['settings']['social']->youtube . '"><i class="text-light icofont-2x icofont-youtube"></i></a>'; ?>
                        <!-- </li> -->
                        <!-- <li class="nav-item p-1"> -->
                            <?php echo empty($data['settings']['social']->instagram) ? '' : '<a class="nav-link" href="' . $data['settings']['social']->instagram . '"><i class="text-light icofont-2x icofont-instagram"></i></a>'; ?>
                        <!-- </li> -->
                        <!-- <li class="nav-item p-1"> -->
                            <?php echo empty($data['settings']['social']->linkedin) ? '' : '<a class="nav-link" href="' . $data['settings']['social']->linkedin     . '"><i class="text-light icofont-2x icofont-linkedin"></i></a>'; ?>
                        <!-- </li> -->
                        <!-- <li class="nav-item p-1"> -->
                        <?php echo empty($data['settings']['social']->tiktok) ? '' : '<a class="nav-link" href="' . $data['settings']['social']->tiktok     . '"><i class="text-light icofont-2x icofont-tiktok"></i></a>'; ?>
                        <!-- </li> -->
                    </ul>
                </div>
            </div>
            <div class="copyright border-success border-top">
                <p class="py-3 ">
                    جميع الحقوق محفوظة ل<?php echo $data['settings']['site']->copyright; ?>
                    <i class="icofont-copyright"></i>
                </p>
            </div>
        </div>
    </footer>
<?php endif; ?>
<!-- JS assets -->
<script src="<?php echo URLROOT; ?>/templates/namaa/js/jquery.min.js"></script>
<script src="<?php echo URLROOT; ?>/templates/namaa/js/bootstrap.bundle.min.js"></script>
<script src="<?php echo URLROOT; ?>/templates/namaa/js/owl.carousel.min.js"></script>
<script src="<?php echo URLROOT; ?>/templates/namaa/js/wow.min.js"></script>
<script src="<?php echo URLROOT; ?>/templates/namaa/js/jquery.inputmask.min.js"></script>
<script src="<?php echo URLROOT; ?>/templates/namaa/js/main.js?v=0.0.6"></script>
<?php echo $data['settings']['site']->footer_code; ?>
</body>

</html>