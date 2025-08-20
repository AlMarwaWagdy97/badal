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

// loading  plugin style
(object) $data['header'] = '<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.css">';
require ADMINROOT . '/views/inc/header.php';
?>
<!-- page content -->
<div class="right_col" role="main">
    <div class="clearfix"></div>
    <?php flash('page_msg'); ?>
    <div class="page-title">
        <div class="title_right">
            <h3><?php echo $data['title']; ?> <small>عرض <?php echo $data['title']; ?> </small></h3>
        </div>
        <div class="title_left">
        </div>
    </div>

    <div class="clearfix"></div>

    <div class="row">

        <div class="wiget animated flipInY col-lg-3 col-md-6 col-xs-12 ">
            <div class="tile-stats bg-blue">
                <div class="icon"><i class="glyphicon glyphicon-gift white"></i>
                </div>
                <div class="count"><?php echo $data['orderCount']; ?></div>
                <h3 class=" white">تبرع جديد</h3>
                <p class="tiles text-right"><a class="white" href="<?php echo ADMINURL; ?>/orders">عرض المزيد</a></p>
            </div>
        </div>

        <div class="wiget animated flipInY col-lg-3 col-md-6 col-xs-12 ">
            <div class="tile-stats bg-blue-sky">
                <div class="icon"><i class="glyphicon glyphicon-user white"></i>
                </div>
                <div class="count"><?php echo $data['donorCount']; ?></div>
                <h3 class=" white">متبرع</h3>
                <p class="tiles text-right"><a class="white" href="<?php echo ADMINURL; ?>/donors">عرض المزيد</a></p>
            </div>
        </div>
        <div class="wiget animated flipInY col-lg-3 col-md-6 col-xs-12 ">
            <div class="tile-stats bg-purple">
                <div class="icon"><i class="glyphicon glyphicon-envelope white"></i>
                </div>
                <div class="count"><?php echo $data['contactsCount']; ?></div>
                <h3 class=" white">رسالة جديدة</h3>
                <p class="tiles text-right"><a class="white" href="<?php echo ADMINURL; ?>/contacts">عرض المزيد</a></p>
            </div>
        </div>


        <div class="wiget animated flipInY col-lg-3 col-md-6 col-xs-12 ">
            <div class="tile-stats bg-green">
                <div class="icon"><i class="glyphicon glyphicon-grain white"></i>
                </div>
                <div class="count"><?php echo $data['projectsCount']; ?></div>
                <h3 class=" white">مشروع خيري</h3>
                <p class="tiles text-right"><a class="white" href="<?php echo ADMINURL; ?>/projects">عرض المزيد</a></p>
            </div>
        </div>
    </div>
    <br><br>
    <div class="row">
        <div class="col-lg-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2 class="text-center">التبرعات <small>عدد التبرعات خلال الشهر الحالي</small></h2>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content2">
                    <div id="myfirstchart" style="height: 450px;"></div>
                </div>
            </div>

        </div>
        <?php
        $date = '';
        $total = 0;
        $quantity = 0;
        $count  = 1;
        $donations = [];
        foreach ((object)$data['orders'] as $donation) {
            if ($date == $donation->create_date) {
                $total += $donation->total;
                $quantity += $donation->quantity;
                $count++;
            } else {
                $count = 1;
                $total = $donation->total;
                $quantity = $donation->quantity;
                $date = $donation->create_date;
            }
            $donations[$date] = ['date' => $date, 'quantity' => $quantity, 'total' => $total, 'count' => $count];
        }
        ?>
    </div>
</div>
<?php
// loading  plugin
$data['footer'] = '<script src="//cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
                   <script src="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.min.js"></script>';
require ADMINROOT . '/views/inc/footer.php';
?>
<script>
    new Morris.Line({
        // ID of the element in which to draw the chart.
        element: 'myfirstchart',
        // Chart data records -- each entry in this array corresponds to a point on
        // the chart.
        data: [
            <?php
            foreach ($donations as $donation) {
                echo "{
                day: '" . $donation['date'] . "',
                total: " . $donation['total'] . ",
                count: " . $donation['count'] . ",
                },";
            }
            ?>
        ],
        // The name of the data record attribute that contains x-values.
        xLabels: 'day',
        xkey: ['day'],
        // A list of names of data record attributes that contain y-values.
        ykeys: ['total', 'count'],
        // Labels for the ykeys -- will be displayed when you hover over the
        // chart.
        labels: ['القيمة الاجمالية بالريال', ' عدد التبرعات '],
        lineColors: ['#9B59B6', '#3498DB']
    });
</script>