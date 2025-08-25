<div class="col-md-3 left_col">
    <div class="left_col scroll-view">
        <div class="navbar nav_title">
            <a target="_blank" href="<?php echo URLROOT; ?>" class="site_title"> <i class="glyphicon glyphicon-grain"></i> <span><?php echo SITENAME; ?></span></a>
        </div>
        <div class="clearfix"></div>
        <!-- menu profile quick info -->
        <div class="profile clearfix">
            <div class="profile_pic">
                <img src="<?php echo empty($_SESSION['user']->image) ? MEDIAURL . '/userdefault.jpg' : MEDIAURL . '/' . $_SESSION['user']->image; ?>" class="img-circle profile_img">
            </div>
            <div class="profile_info">
                <span>مرحبا ,</span>
                <h2><?php echo $_SESSION['user']->name; ?></h2>
            </div>
            <div class="clearfix"></div>
        </div>
        <!-- /menu profile quick info -->
        <br />
        <!-- sidebar menu -->
        <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
            <div class="menu_section">
                <h3>عام</h3>
                <ul class="nav side-menu">
                    <li><a><i class="fa fa-home"></i> الرئيسية <span class="fa fa-chevron-down"></span></a>
                        <ul class="nav child_menu">
                            <li><a href="<?php echo ADMINURL; ?>/dashboard/index">لوحة التحكم</a></li>
                            <li><a href="<?php echo ADMINURL; ?>/users/show/<?php echo $_SESSION['user']->user_id; ?>">الملف الشخصي</a></li>
                        </ul>
                    </li>
                    <li><a><i class="fa fa-th-large"></i> النظام <span class="fa fa-chevron-down"></span></a>
                        <ul class="nav child_menu">
                            <li><a href="<?php echo ADMINURL; ?>/groups">المجموعات والصلاحيات</a></li>
                            <li><a href="<?php echo ADMINURL; ?>/users">المستخدمين</a></li>
                        </ul>
                    </li>
             
                    <li><a><i class="glyphicon glyphicon-gift"></i> التبرعات <span class="fa fa-chevron-down"></span></a>
                        <ul class="nav child_menu">
                            <li><a href="<?php echo ADMINURL; ?>/orders">عمليات التبرع </a></li>
                            <!--<li><a href="<?php echo ADMINURL; ?>/donations">سجل التبرعات</a></li>-->
                            <li><a href="<?php echo ADMINURL; ?>/donors">قائمة المتبرعين </a></li>
                        </ul>
                    </li>

                    <li><a><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512" width="16">
                                <path fill="#FFF" d="M60 120l228 71.2L516 120 288 48.8 60 120zM278.5 1.5c6.2-1.9 12.9-1.9 19.1 0l256 80C566.9 85.6 576 98 576 112v16 0 21.2L292.8 237.7c-3.1 1-6.4 1-9.5 0L0 149.2V128 112C0 98 9.1 85.6 22.5 81.5l256-80zm23.9 266.8L576 182.8v46.5l-52.8 16.5c-8.4 2.6-13.1 11.6-10.5 20s11.6 13.1 20 10.5L576 262.8V400c0 14-9.1 26.4-22.5 30.5l-256 80c-6.2 1.9-12.9 1.9-19.1 0l-256-80C9.1 426.4 0 414 0 400V262.8l43.2 13.5c8.4 2.6 17.4-2.1 20-10.5s-2.1-17.4-10.5-20L0 229.2V182.8l273.7 85.5c9.3 2.9 19.3 2.9 28.6 0zm-185.5-2.6c-8.4-2.6-17.4 2.1-20 10.5s2.1 17.4 10.5 20l64 20c8.4 2.6 17.4-2.1 20-10.5s-2.1-17.4-10.5-20l-64-20zm352 30.5c8.4-2.6 13.1-11.6 10.5-20s-11.6-13.1-20-10.5l-64 20c-8.4 2.6-13.1 11.6-10.5 20s11.6 13.1 20 10.5l64-20zm-224 9.5c-8.4-2.6-17.4 2.1-20 10.5s2.1 17.4 10.5 20l38.5 12c9.3 2.9 19.3 2.9 28.6 0l38.5-12c8.4-2.6 13.1-11.6 10.5-20s-11.6-13.1-20-10.5l-38.5 12c-3.1 1-6.4 1-9.5 0l-38.5-1z" />
                            </svg> حج وعمرة البدل  <span class="fa fa-chevron-down"></span></a>
                        <ul class="nav child_menu">
                            <li><a href="<?php echo ADMINURL; ?>/albadal">مشروعات البدل </a></li>
                            <li><a href="<?php echo ADMINURL; ?>/rites"> مناسك الحج والعمره </a></li>
                            <li><a href="<?php echo ADMINURL; ?>/badalorders">سجل العمليات  <span class="number"><?= badalOrderCount() ?></span> </a></li>
                            <li><a href="<?php echo ADMINURL; ?>/substitutes">المتطوعين </a></li>
                            <li><a href="<?php echo ADMINURL; ?>/badaloffers">  العروض <span class="number"><?= badalOfferCount() ?></span> </a></li>
                            <li><a href="<?php echo ADMINURL; ?>/badalrequests"> طلبات المتقدمين  </a></li>
                            <li><a href="<?php echo ADMINURL; ?>/badalreviews">  التقييمات  </a></li>
                            <li><a href="<?php echo ADMINURL; ?>/settings/edit/15">اعدادات البدل </a></li>
                        </ul>
                    </li>

                    <li><a><i class="fa fa-gears"></i> الإعدادات <span class="fa fa-chevron-down"></span></a>
                        <ul class="nav child_menu">
                            <li><a href="<?php echo ADMINURL; ?>/paymentmethods">وسائل الدفع </a></li>
                            <li><a href="<?php echo ADMINURL; ?>/settings">اعدادات النظام </a></li>
                        </ul>
                    </li>
                    <li><a><i class="fa fa-android"></i> التطبيق <span class="fa fa-chevron-down"></span></a>
                        <ul class="nav child_menu">
                            <li><a href="<?php echo ADMINURL; ?>/settings/edit/11">اعدادات التطبيق</a></li>
                            <!--<li><a href="<?php echo ADMINURL; ?>/notifications">رسائل التنبيهات</a></li>-->
                            <li>
                                <form action="<?= ADMINURL ?>/orders" method="POST">
                                    <input type="hidden" name="search[submit]">
                                    <button type="submit" name="search[app]" value="kafara" class="btn-dark b-0" href="<?php echo ADMINURL; ?>/notifications">عمليات التبرع</button>
                                </form>
                            </li>
                        </ul>
                    </li>
                    <li><a><i class="fa fa-bar-chart-o"></i> التقارير <span class="fa fa-chevron-down"></span></a>
                        <ul class="nav child_menu">
                            <li><a href="<?php echo ADMINURL; ?>/reports">عرض واستخراج التقارير </a></li>
                            <li><a href="<?php echo ADMINURL; ?>/logs">سجل عمليات الادارة </a></li>
                            <!--<li><a href="#">3تقارير </a></li> -->
                        </ul>
                    </li>
                   
                    
                    
                   
                </ul>
            </div>
        </div>
        <!-- /sidebar menu -->
        <!-- /menu footer buttons -->
        <div class="sidebar-footer hidden-small">
            <a data-toggle="tooltip" data-placement="top" title="Settings" href="<?php echo ADMINURL; ?>/settings">
                <span class="glyphicon glyphicon-cog" aria-hidden="true"></span>
            </a>
            <a data-toggle="tooltip" data-placement="top" title="FullScreen" class="fullscreen">
                <span class="glyphicon glyphicon-fullscreen" aria-hidden="true"></span>
            </a>
            <a data-toggle="tooltip" data-placement="top" title="Lock">
                <span class="glyphicon glyphicon-eye-close" aria-hidden="true"></span>
            </a>
            <a data-toggle="tooltip" data-placement="top" title="Logout" href="<?php echo ADMINURL; ?>/users/logout">
                <span class="glyphicon glyphicon-off" aria-hidden="true"></span>
            </a>
        </div>
        <!-- /menu footer buttons -->
    </div>
</div>
<!-- top navigation -->
<div class="top_nav">
    <div class="nav_menu">
        <nav>
            <div class="nav toggle">
                <a id="menu_toggle"><i class="fa fa-bars"></i></a>
            </div>
            <ul class="nav navbar-nav navbar-right">
                <li class="">
                    <a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                        <img src="<?php echo empty($_SESSION['user']->image) ? MEDIAURL . '/userdefault.jpg' : MEDIAURL . '/' . $_SESSION['user']->image; ?>"><?php echo $_SESSION['user']->name; ?>
                        <span class=" fa fa-angle-down"></span>
                    </a>
                    <ul class="dropdown-menu dropdown-usermenu pull-right">
                        <li><a href="<?php echo ADMINURL . '/users/show/' . $_SESSION['user']->user_id; ?>"><i class="fa fa-user pull-left"></i> الملف الشخصي</a></li>
                        <li><a href="<?php echo ADMINURL; ?>/settings"><i class="fa fa-gear pull-left"></i> الأعدادات</a></li>
                        <li><a target="_blank" href="http://ahmedx.com/easycms"><i class="fa fa-life-bouy pull-left"></i> المساعدة</a></li>
                        <li><a href="<?php echo ADMINURL; ?>/users/logout"><i class="fa fa-sign-out pull-left"></i> تسجيل خروج</a></li>
                    </ul>
                </li>

            </ul>
        </nav>
    </div>
</div>
<!-- /top navigation -->