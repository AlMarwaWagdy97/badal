<?php header('Access-Control-Allow-Origin: *'); ?>
<?php
// if (!$_SERVER['HTTPS']) {
// header("Location: https://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);
// }
?>
<!DOCTYPE html>
<html lang="ar">
<!--
Copyright (C) 2020 Easy CMS Framework Ahmed Elmahdy

This program is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License
@license    https://opensource.org/licenses/GPL-3.0

@package    Easy CMS MVC framework
@author     Ahmed Elmahdy
@link       https://ahmedx.com

For more information about the author , see <http://www.ahmedx.com/>.
-->

<head>
    <!-- Primary Meta Tags -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="keywords" content="<?php echo $data['settings']['seo']->meta_keywords; ?>">
    <meta name="title" content="<?php echo $data['settings']['site']->title; ?>">
    <meta name="description" content="<?php echo $data['settings']['seo']->meta_description; ?>">
    <meta name="author" content="Ahmed Elmahdy">
    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="<?php echo "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]" ?>">
    <meta property="og:title" content="<?php echo $data['settings']['site']->title; ?>">
    <meta property="og:description" content="<?php echo $data['settings']['seo']->meta_description; ?>">
    <meta property="og:image" content="<?= URLROOT . '/media/files/puzzels/' . $data['puzzel']->image ?>">

    <!-- Twitter -->
    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:url" content="<?php echo "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]" ?>">
    <meta property="twitter:title" content="<?php echo $data['settings']['site']->title; ?>">
    <meta property="twitter:description" content="<?php echo $data['settings']['seo']->meta_description; ?>">
    <meta property="twitter:image" content="<?= URLROOT . '/media/files/puzzels/' . $data['puzzel']->image ?>">

    <?php echo $data['settings']['site']->header_code; ?>
    <link rel="shortcut icon" href="<?php echo URLROOT; ?>/templates/namaa/images/favicon.ico" type="image/x-icon">
    <link rel="icon" href="<?php echo URLROOT; ?>/templates/namaa/images/favicon.ico" type="image/x-icon">
    <title><?php echo ($data['pageTitle']) ?? SITENAME; ?></title>
    <!-- main styles with bootstrap -->
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/templates/namaa/css/main.min.css" />
    <!-- icofont iconss -->
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/templates/namaa/css/icofont.min.css" />
    <?php $primary = "#" . $data['settings']['theme']->primary_color; ?>

    <style>
        .hs-cta-wrapper {
            display: none !important;
            visibility: hidden !important;
        }

        canvas#myCanvas {
            margin-top: 30px;
        }

        .counter,
        #counter {
            text-align: center;
            z-index: 10;
        }

        .form {
            position: fixed;
            top: 10px;
            display: none;
        }

        .form form {
            background: #fff;
            padding: 3em 2em;
            border-radius: 10px;
            margin: 0 auto;
        }
    </style>

</head>

<body>
    <div class="preloader text-center">
        <div class="text-center">
            <img src="<?php echo URLROOT; ?>/templates/namaa/images/icon.gif" alt="">
        </div>
    </div>
    <div class="container-md px-0 undermenu text-right ">
        <div class="row">
            <h5 class="counter text-center col-12">الوقت المطلوب <?= $data['puzzel']->timeout; ?> ثانية </p>
                <h4 id="counter" class="col-12 p-0">0</h4>
        </div>
        <div class="row col-12 py-5 form">
            <form action="<?php echo URLROOT . '/puzzels/player/' . $data['puzzel']->puzzel_id; ?>" method="post" accept-charset="utf-8" class="col-lg-6 col-md-8 col-12">
                <div class="text-center p-3">
                    <p class="text-success"> اكتملت الصورة بنجاح </p>
                    <p><?= $data['puzzel']->description; ?></p>
                    <?php if ($data['puzzel']->image2) : ?>
                     <img src="<?= URLROOT . '/media/files/puzzels/' . $data['puzzel']->image2 ?>" width="100%" >
                    <?php endif; ?>
                </div>
                <div class="form-group row">
                    <input type="text" class="form-control col-4 pe-1" name="first_name" required placeholder="الاسم الأول">
                    <input type="text" class="form-control col-4 pe-1" name="second_name" required placeholder="الاسم الثاني">
                    <input type="text" class="form-control col-4 pe-1" name="last_name" required placeholder="الاسم الاخير">
                </div>
                <div class="form-group">
                    <input type="text" class="form-control " name="phone" required placeholder="رقم الجوال">
                </div>
                <div class="form-group">
                    <input type="text" class="form-control " name="email" required placeholder=" البريد الالكتروني">
                </div>
                <div class="form-group">
                    <input type="hidden" name="time" class="form-control timing">
                </div>
                <div class="col-xs-12 text-center">
                    <button type="submit" name="submit" class="btn btn-primary px-5 py-2"> الخطوة الثانية
                        <i class="fa fa-save"> </i></button>
                </div>
                <br>
            </form>
        </div>
    </div>
    <!-- JS assets -->
    <script src="<?php echo URLROOT; ?>/templates/namaa/js/jquery.min.js"></script>
    <script src="<?php echo URLROOT; ?>/templates/namaa/js/bootstrap.bundle.min.js"></script>
    <script src="<?php echo URLROOT; ?>/templates/namaa/js/main.js"></script>
    <script src="<?php echo URLROOT; ?>/templates/namaa/js/createjs.js"></script>
    <script src="<?php echo URLROOT; ?>/templates/namaa/js/zim.js"></script>
    <script>
        $('.hs-cta-wrapper').remove();
        // puzzel configuration
        let modal = $('.form'),
            image = "<?= $data['puzzel']->image; ?>",
            puzzel_id = "<?= $data['puzzel']->puzzel_id; ?>",
            hight = <?= $data['puzzel']->height + 100; ?>,
            width = <?= $data['puzzel']->width + 300; ?>,
            piecesx = <?= $data['puzzel']->piecesx; ?>,
            piecesy = <?= $data['puzzel']->piecesy; ?>,
            rotate = <?= ($data['puzzel']->rotate) ? 'true' : 'false'; ?>,
            timeout = <?= $data['puzzel']->timeout; ?>,
            timeoutURL = "<?= $data['puzzel']->timeout_url; ?>",
            audio = "<?= $data['puzzel']->audio; ?>",
            url = "<?= URLROOT . '/media/files/puzzels/' ?>";
    </script>
    <script src="<?php echo URLROOT; ?>/templates/namaa/js/puzzel.js"></script>
</body>

</html>