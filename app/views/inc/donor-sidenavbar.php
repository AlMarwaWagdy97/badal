<div class="card mt-3 mb-3 card-user ">
    <div class="card-body">
        <div class="d-flex flex-column flex-lg-row align-items-center justify-content-around mb-md-3">
            <i class="icofont-ui-user profile-icon h1"></i>
            <div class="text-right w-100 pr-1">
                <span> <?php echo $data['donor']->full_name ?> </span>
            </div>
            <div class="text-left w-20 ">
                <a href="<?php root('donors/editprofile') ?>"><i class="icofont-edit"></i></a>
            </div>
        </div>
        <hr>
        <div class="d-flex align-items-center justify-content-between pt-2 pt-md-3 w-100">
            <i class="icofont-phone profile-icon " style="font-size: 20px;"></i>
            <div class="text-right w-100 pr-1">
                <span><?php echo $data['donor']->mobile ?></span>
            </div>
            <div class="text-left w-100 pr-1">
                <a href="<?php root('donors/editmobile') ?>"><i class="icofont-edit"></i></a>
            </div>
        </div>
        <!-- <hr> -->
        <!-- <div class="d-flex align-items-center justify-content-between pt-2 pt-md-3 w-100">
                        <div class="d-flex align-items-center">
                            <img src="https://georgeschofield.com/wp-content/uploads/2016/01/email-icon-23.png" alt="" width="25">
                            <div class="text-right w-100 pr-1">
                                <span><?php echo $data['donor']->email ?></span>
                            </div>
                        </div>
                        <div class="d-flex align-items-center m-1">
                            <a href="<?php root('donors/profile') ?>"><i class="icofont-edit"></i></a>
                        </div>
                    </div> -->
    </div>
</div>

<div class="card mt-3 mb-3 card-navbar ">
    <div class="card-body">
        <div class="d-flex flex-column align-items-stretch flex-shrink-0 bg-white">
            <div class="list-group list-group-flush border-bottom scrollarea text-end">
                <a class=" list-group-item list-group-item-action  py-3 lh-tight" href="<?php root('donors/account') ?> ">
                    <li class="float-right"> <i class="icofont-ui-user"> </i> الحساب الشخصي </li>
                </a>
                <a class=" list-group-item list-group-item-action  py-3 lh-tight" href="<?php root('donors/orders') ?> ">
                    <li class="float-right"> <i class="icofont-list"> </i> سجل التبرعات  </li>
                </a>
                <a class=" list-group-item list-group-item-action  py-3 lh-tight" href="<?php root('donors/cards') ?> ">
                    <li class="float-right"> <i class="icofont-credit-card"> </i> بطاقات الدفع </li>
                </a>
                <a class=" list-group-item list-group-item-action  py-3 lh-tight" href="<?php root('donors/closed') ?> ">
                    <li class="float-right"> <i class="icofont-delete-alt"></i>  حذف حسابي </li>
                </a>
                <a class=" list-group-item list-group-item-action  py-3 lh-tight" href="<?php root('donors/logout') ?> ">
                    <li class="float-right"> <i class="icofont-logout"> </i> تسجيل خروج </li>
                </a>
            </div>
        </div>
    </div>
</div>