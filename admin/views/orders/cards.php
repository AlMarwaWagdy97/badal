<?php
/*
 * Copyright (C) 2018 Easy CMS Framework Ahmed Elmahdy
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License
 * @license    https://opensource.org/licenses/GPL-3.0
 *
 * @package    Easy CMS MVC framework
 * @author     Ahmed Elmahdy
 * @link       https://ahmedx.com
 *
 * For more information about the author , see <http://www.ahmedx.com/>.
 */

// loading plugin style
$data['header'] = '<!-- Select2 -->
<link rel="stylesheet" href="' . ADMINURL . '/template/default/vendors/select2/dist/css/select2.min.css">';
header("Content-Type: text/html; charset=utf-8");
require ADMINROOT . '/views/inc/header.php';
?>
<!-- page content -->
<div class="right_col" role="main">
    <div class="clearfix"></div>
    <?php flash('order_msg'); ?>
    <div class="page-title">
        <div class="title_right">
            <h3><?php echo $data['page_title']; ?> </h3>
        </div>
        <div class="title_left">
            <a href="<?php echo ADMINURL; ?>/orders" class="btn btn-success pull-left">عودة <i class="fa fa-reply"></i></a>
        </div>
    </div>
    <div class="clearfix"></div>
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
        <ul class="text-capitalize">
            <?php
            ($data['order']) ? $gifts = json_decode($data['order']->gift_data) : $gifts = [];
            foreach ($gifts as $key => $value) {
                if ($key == 'enable') continue;
                if ($key == 'card') {
                    echo '<li class="h5">' . $key . " : <a target='blank' href='" . MEDIAURL . '' . $value . "'><img width='500' src= '" . MEDIAURL . '/' . $value . "'></a></li>\n";
                } else {
                    echo '<li class="h5">' . $key . " : " . $value . "</li>\n";
                }
            }
            ?>
        </ul>
        </div>
    </div>
</div>

<?php
// loading plugin

require ADMINROOT . '/views/inc/footer.php';
