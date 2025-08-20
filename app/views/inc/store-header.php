<?php
// if (!$_SERVER['HTTPS']) {
//     header("Location: https://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);
// }
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
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

    <meta name="keywords" content="<?php echo $this->meta->keywords; ?>">
    <meta name="title" content="<?php echo $this->meta->title; ?>">
    <meta name="description" content="<?php echo $this->meta->description; ?>">
    <meta name="author" content="Ahmed Elmahdy">
    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="<?php echo "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]" ?>">
    <meta property="og:title" content="<?php echo $this->meta->title; ?>">
    <meta property="og:description" content="<?php echo $this->meta->description; ?>">
    <meta property="og:image" content="<?php echo $this->meta->image; ?>">

    <!-- Twitter -->
    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:url" content="<?php echo "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]" ?>">
    <meta property="twitter:title" content="<?php echo $this->meta->title; ?>">
    <meta property="twitter:description" content="<?php echo $this->meta->description; ?>">
    <meta property="twitter:image" content="<?php echo $this->meta->image; ?>">

    <?php echo $this->meta->headerCode; ?>
    <link rel="shortcut icon" href="<?php echo URLROOT; ?>/templates/default/images/favicon.ico" type="image/x-icon">
    <link rel="icon" href="<?php echo URLROOT; ?>/templates/default/images/favicon.ico" type="image/x-icon">
    <title><?php echo ($data['pageTitle']) ?? SITENAME; ?></title>
    <!--- Bootstrap 4  --->
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/templates/default/css/bootstrap.min.css">
    <!--- Icofont file --->
    <link rel="stylesheet" type="text/css" href="<?php echo URLROOT; ?>/templates/default/css/icofont.min.css">

    <!-- Owl Stylesheets -->
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/templates/default/vendors/owlcarousel/assets/owl.carousel.min.css">
    <!--- Google fonts -->
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/templates/default/css/animate.css">
    <link href="https://fonts.googleapis.com/css?family=Cairo&display=swap" rel="stylesheet">

    <!--- CSS style --->
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/templates/default/css/style.css">
    <?php echo isset($data['site_settings']->header_code) ? $data['site_settings']->header_code : ''; ?>    
    <style>
        .bg-primary,
        div.scrollmenu,
        .btn-primary,
        a.activate,
        .footer-bottom {
            background: <?php echo isset($data['theme_settings']->primary_color) ?  '#' . $data['theme_settings']->primary_color : ''; ?> !important;
        }
    </style>
</head>

<body style="background:<?php echo $this->meta->background; ?>;">
    <div class="preloader text-center">
        <div class="text-center">
            <img src="<?php echo URLROOT; ?>/templates/default/images/icon.gif" alt="">
        </div>
    </div>
    <div class="container">
        <section class="row py-2" id="top-bar">
            <div class="col-6 col-md-8">
                <a href="<?php echo isset($_SESSION['store']) ? URLROOT . '/store/' . $_SESSION['store']['alias'] : URLROOT; ?>" class="logo float-right">
                    <img src="<?php echo empty($data['site_settings']->logo) ? '/' : MEDIAURL . '/' . $data['site_settings']->logo; ?>" height="60" alt="Namaa logo" class="img-fluid">
                </a>
            </div>
            <div class="col-5 col-md-4 pt-3">
                <div class="user float-left">
                    <div class="nav">
                        <li class="nav-item">
                            <a title="الاقسام" class="nav-link p-2 text-dark border-left border-default" href="<?php echo URLROOT . '/store/categories/' . $_SESSION['store']['alias'] ; ?>">
                            <span class="">الاقسام</span>  
                            </a>
                        </li>
                        <li class="nav-item">
                            <a title="Profile" class="nav-link p-2 text-dark border-left border-default" href="<?php echo URLROOT . "/donors/login"; ?>"><i class="icofont-user"></i>
                            <span class="d-none d-md-inline">سجل التبرعات </span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link p-2 text-dark" href="<?php echo URLROOT . "/carts"; ?>">
                                <span class="cart-num d-md-block d-lg-none"><?php echo isset($_SESSION['cart']) ? $_SESSION['cart']['totalQty'] : ''; ?></span>
                                <i class="icofont-cart cart-icon "></i>
                                <span class="d-none d-md-inline">السلة (<span class="cart-total"><?php echo isset($_SESSION['cart']) ? $_SESSION['cart']['totalQty'] : 0; ?></span>) منتج</span>
                            </a>
                        </li>
                    </div>
                </div>
            </div>
            <!-- nav -->
        </section>
        <!--- carousel  Start --->