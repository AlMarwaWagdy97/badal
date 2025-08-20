<?php
 if (!$_SERVER['HTTPS']) {
 header("Location: https://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);
 }
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
    <meta property="og:image" content="<?php echo MEDIAURL . '/';
                                        echo isset($data['settings']['site']->image) ? $data['settings']['site']->image : $data['settings']['site']->logo; ?>">

    <!-- Twitter -->
    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:url" content="<?php echo "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]" ?>">
    <meta property="twitter:title" content="<?php echo $data['settings']['site']->title; ?>">
    <meta property="twitter:description" content="<?php echo $data['settings']['seo']->meta_description; ?>">
    <meta property="twitter:image" content="<?php echo MEDIAURL . '/' ;
                                        echo isset($data['settings']['site']->image) ? $data['settings']['site']->image : $data['settings']['site']->logo; ?>">

    <?php echo $data['settings']['site']->header_code; ?>
    <link rel="shortcut icon" href="<?php echo URLROOT; ?>/templates/namaa/images/favicon.ico" type="image/x-icon">
    <link rel="icon" href="<?php echo URLROOT; ?>/templates/namaa/images/favicon.ico" type="image/x-icon">
    <title><?php echo ($data['pageTitle']) ?? SITENAME; ?></title>
    <!-- main styles with bootstrap -->
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/templates/namaa/css/main.min.css" />
    <!-- icofont iconss -->
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/templates/namaa/css/icofont.min.css" />
</head>

<body>
    <div class="preloader text-center">
        <div class="text-center">
            <img src="<?php echo URLROOT; ?>/templates/namaa/images/icon.gif" alt="">
        </div>
    </div>
    <section id="top-bar" class="bg-dark pb-5">
        <div class="container text-light pt-3 mb-lg-3 mb-2">
            <div class="row align-items-center">
                <div class="col-lg-4 col-6 ">
                    <h6 class="text-right welcome-text"><?php echo $data['settings']['site']->welcomeText; ?></h6>
                </div>
                <div class="col-lg-8 col-6">
                    <div class="row justify-content-end text-right">
                        <div class="col-2 col-md-1 mt-2 p-0 text-center">
                            <a class="d-block text-light" href="tel:<?php echo isset($_SESSION['store']->email) ? $_SESSION['store']->email : $data['settings']['contact']->email; ?>">
                                <i class="icofont-envelope p-2 bg-light text-dark rounded-circle icofont-lg"></i>
                            </a>
                        </div>
                        <div class="col-3 p-0 d-none d-lg-inline">
                            <span class="pr-1">أرسل لنا بريدًا إلكترونيًا:</span>
                            <?php
                            if (isset($_SESSION['store']->email)) {
                                echo '<a class="d-block text-light" href="mailto:' . $_SESSION['store']->email . '"> ' . $_SESSION['store']->email . '</a>';
                            } else {
                                echo '<a class="d-block text-light" href="mailto:' . $data['settings']['contact']->email . '"> ' . $data['settings']['contact']->email . ' </a>';
                            }
                            ?>
                        </div>
                        <div class="col-2 col-md-1 mt-2 p-0 text-center mx-2">
                            <?php
                            if (isset($_SESSION['store']->mobile)) {
                                echo '<a class="d-block text-light" href="tel:' . $_SESSION['store']->mobile . '"><i class="icofont-phone p-2 bg-light text-dark rounded-circle icofont-lg"></i></a>';
                            } else {
                                echo '<a class="d-block text-light" href="tel:' . $data['settings']['contact']->mobile . '"><i class="icofont-phone p-2 bg-light text-dark rounded-circle icofont-lg"></i></a>';
                            }
                            ?>
                        </div>
                        <div class="col-3 p-0 d-none d-lg-inline">
                            <span class="pr-1">أتصل بنا:</span>
                            <?php
                            if (isset($_SESSION['store']->mobile)) {
                                echo '<a class="d-block text-light" href="tel:' . $_SESSION['store']->mobile . '">' . $_SESSION['store']->mobile . '</a>';
                            } else {
                                echo '<a class="d-block text-light" href="tel:' . $data['settings']['contact']->mobile . '">' . $data['settings']['contact']->mobile . '</a>';
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- top-bar end -->
    <?php
    $mainMenu = [];
    foreach ($data['menu'] as $menu) {
        if ($menu->level == 1) {
            $mainMenu[$menu->menu_id] = $menu;
            foreach ($data['menu'] as $submenu) { // load level 2
                if ($submenu->parent_id == $menu->menu_id) {
                    $mainMenu[$menu->menu_id]->hasChiled = true; // adding flag for parent
                    $mainMenu[$submenu->menu_id] = $submenu;
                    foreach ($data['menu'] as $subsub) { // load level 3
                        if ($subsub->parent_id == $submenu->menu_id) {
                            $mainMenu[$submenu->menu_id]->hasChiled = true; // adding flag for parent
                            $mainMenu[$subsub->menu_id] = $subsub;
                        }
                    }
                }
            }
        }
    }
    ?>
    <!-- main menu end -->
    <section id="menu-bar">
        <div class="container-lg bg-white rounded py-0 d-flex">
            <nav class="navbar navbar-expand-lg navbar-light py-2">
                <button type="button" data-toggle="collapse" data-target="#navbarContent" aria-controls="navbars" aria-expanded="false" aria-label="Toggle navigation" class="navbar-toggler p-1">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <a href="<?php echo URLROOT; ?>" class="navbar-brand font-weight-bold ml-auto pr-0">
                    <img class="" src="<?php echo empty($data['settings']['site']->logo) ? URLROOT . '/templates/namaa/images/logo.png' : MEDIAURL . '/' . $data['settings']['site']->logo; ?>" 
                    alt="<?php echo SITENAME; ?>" height="66" />
                </a>
                <div id="navbarContent" class="collapse navbar-collapse">
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a href="<?php echo URLROOT; ?>" class="nav-link active"><i class="icofont-home icofont-lg"></i> <span class="d-sm-inline d-lg-none">الرئيسية</span></a>
                        </li>
                        <?php
                        foreach ($mainMenu as $menu) {
                            if (is_object($menu)) {
                                if ($menu->level == 1) {
                                    if (isset($menu->hasChiled)) {
                                        echo '<li class="nav-item dropdown">
                                                 <a id="dropdownMenu1" href="' . $menu->url . '" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="nav-link dropdown-toggle">' . $menu->name . '</a>';
                                        echo '<ul aria-labelledby="dropdownMenu1" class="dropdown-menu">';
                                        foreach ($mainMenu as $sub) {
                                            if (is_object($menu)) {
                                                if ($sub->parent_id == $menu->menu_id) {
                                                    if (isset($sub->hasChiled)) {
                                                        echo '<li class="nav-item dropdown-submenu">
                                                             <a id="dropdownMenu2" href="' . $sub->url . '" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="nav-link dropdown-toggle">' . $sub->name . '</a>
                                                             <ul aria-labelledby="dropdownMenu2" class="dropdown-menu">';
                                                        foreach ($mainMenu as $subsub) {
                                                            if ($subsub->parent_id == $sub->menu_id) {
                                                                echo '<li class="nav-item "><a href="' . $subsub->url . '" class="nav-link">' . $subsub->name . '</a></li>';
                                                            }
                                                        }
                                                        echo '   </ul>
                                                          </li>';
                                                    } else {
                                                        echo '<li class="nav-item "><a href="' . $sub->url . '" class="nav-link">' . $sub->name . '</a></li>';
                                                    }
                                                }
                                            }
                                        }
                                        echo '</ul>
                                        </li>';
                                    } else {
                                        echo '<li class="nav-item "><a href="' . $menu->url . '" class="nav-link">' . $menu->name . '</a></li>';
                                    }
                                }
                            }
                        }
                        ?>
                    </ul>
                </div>
            </nav>
            <div class="d-flex system-icons align-items-start">
                <a href="<?php echo URLROOT; ?>/search"><i class="icofont-search-2 text-success"></i></a>
                <a data-toggle="tooltip" data-placement="top" title="سجل التبرعات" href="<?php echo URLROOT . "/donors/login"; ?>"><i class="icofont-ui-user text-primary"></i></a>
                <a class="cart-total" data-toggle="tooltip" data-placement="right" title="<?php echo isset($_SESSION['cart']) ? $_SESSION['cart']['totalQty'] : 0; ?> منتج" href="<?php echo URLROOT . "/carts"; ?>">
                    <i class="icofont-shopping-cart text-warning"></i>
                </a>
            </div>
        </div>
    </section>