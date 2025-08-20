<?php require APPROOT . '/app/views/inc/header.php'; ?>
<?php flash('msg'); ?>
<div class="container undermenu">
    <div class="row no-gutters text-center">
        <div class="col-md-4">
            <img src="<?php echo (empty($data['tag']->image)) ? MEDIAURL . '/default.jpg' : MEDIAURL . '/' . $data['tag']->image; ?>" class="rounded-circle p-4 img-fluid" alt="<?php echo $data['tag']->name; ?>">
        </div>
        <div class="col-md-8">
            <div class="card-body">
                <h1 class="card-title text-primary h3"><?php echo $data['tag']->name; ?></h1>
                <p class="card-text"><?php echo $data['tag']->description; ?></p>
            </div>

        </div>
    </div>
</div>
<!--- Products Start --->
<section id="projects">
    <div class="container py-5">
        <div class="col">
            <h3 class="text-center">
                <img src="<?php echo URLROOT; ?>/templates/default/images/namaa-icon.png" alt="namaa-icon" class="ml-1">
                <?php echo $data['tag']->name; ?>
            </h3>
        </div>

        <div class="row p-0 m-0">
            <?php
            echo (count($data['projects']) < 1) ? '<p class="text-center col-12 pb-5 my-5">لا يوجد منتجات تابعة لهذا القسم</p>' : '';
            foreach ($data['projects'] as $project) :
            ?>
                <div class="col-12 col-xl-4 col-md-6 my-2 px-1">
                    <div class="project bg-light">
                        <div class="project-img">
                            <?php if ($project->finished) echo '<span class="closed">مغلق</span>'; ?>
                            <a class="" href="<?php echo URLROOT . '/projects/show/' . $project->project_id . '-' . $project->alias; ?>" title="">
                                <img class="img-fluid" src="<?php echo (empty($project->secondary_image)) ? MEDIAURL . '/default.jpg' : MEDIAURL . '/' . $project->secondary_image; ?>">
                            </a>
                            <ul class="project-social ml-1 p-0 nav flex-column" data-toggle="collapse" data-target="#toggelShare<?php echo $project->project_id ?>">
                                <a class="nav-link active">
                                    <i class="icofont-share"></i>
                                </a>
                                <span class="collapse toggelShare" id="toggelShare<?php echo $project->project_id ?>">
                                    <?php foreach (sortSetting($data['settings']['social']->sort) as $key => $share) { ?>
                                        <?php if ($key == "whatsapp") { ?>
                                            <a target="blank" class="nav-link" href="https://wa.me/?text=<?= URLROOT . '/projects/show/' . $project->project_id; ?>" style="color: #<?= @$data['settings']['social']->color->products ?> ">
                                                <i class="icofont-whatsapp "></i>
                                            </a>
                                        <?php }
                                        if ($key == "facebook") { ?>
                                            <a target="blank" class="nav-link" href="https://www.facebook.com/sharer/sharer.php?u=<?= URLROOT . '/projects/show/' . $project->project_id; ?>" style="color: #<?= @$data['settings']['social']->color->products ?> ">
                                                <i class="icofont-facebook "></i>
                                            </a>
                                        <?php }
                                        if ($key == "twitter") { ?>
                                            <a target="blank" class="nav-link" href="https://twitter.com/intent/tweet?url=<?= URLROOT . '/projects/show/' . $project->project_id; ?>&text=<?= $project->name; ?>" style="color: #<?= @$data['settings']['social']->color->products ?> ">
                                                <i class="icofont-twitter"></i>
                                            </a>
                                        <?php }
                                        if ($key == "email") { ?>
                                            <a target="blank" class="nav-link" href="mailto:?&subject=&cc=&bcc=&body=<?= URLROOT . '/projects/show/' . $project->project_id; ?>%0A<?= $project->name; ?>" style="color: #<?= @$data['settings']['social']->color->products ?> ">
                                                <i class="icofont-email"></i>
                                            </a>
                                        <?php } ?>
                                    <?php } ?>

                                </span>
                            </ul>
                            <a class="project-title" href="<?php echo URLROOT . '/projects/show/' . $project->project_id . '-' . $project->alias; ?>" title="<?php echo $project->name; ?>">
                                <h5><?php echo $project->name; ?></h5>
                            </a>
                        </div>
                        <div class="project-details">
                            <div class="target p-3">
                                <small class=" pt-1 float-right"> <span> المستهدف:
                                        <?php echo $project->target_price; ?>
                                        <?php if (empty($project->target_unit)) {
                                            echo '<svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                                             viewBox="0 0 1024 900" style="enable-background:new 0 0 1024 900;width:15px" xml:space="preserve">
                                        <style type="text/css">
                                            .st0{fill:#444444;}
                                        </style>
                                        <path class="st0" d="M596.8,735.6L596.8,735.6c-12.6,28-20.6,57.9-23.7,88.4L835,768.3c12.6-28,20.6-57.9,23.7-88.4L596.8,735.6z"/>
                                        <path class="st0" d="M835,601.6c12.6-28,20.6-57.9,23.7-88.4l-204,43.4v-83.4L835,434.8c12.6-28,20.6-57.9,23.7-88.4l-204,43.3V89.9
                                            c-31.2,17.5-58.9,40.8-81.6,68.5v248.8l-81.6,17.3V49.1c-31.2,17.5-58.9,40.8-81.6,68.5v324.2l-182.5,38.8
                                            c-12.6,28-20.6,57.9-23.7,88.5L410,525.2v105l-221,47c-12.6,28-20.6,57.9-23.7,88.4l231.3-49.2c18.5-3.9,34.9-14.8,45.5-30.4
                                            l42.4-62.9l0,0c4.6-6.7,7-14.7,7-22.8v-92.5l81.6-17.3v166.8L835,601.6L835,601.6z"/>
                                        </svg>';
                                        } else {
                                            echo  $project->target_unit;
                                        }  ?> </span>
                                </small>
                                <small class="m-0 pb-2"> <span class=" mx-1">تم جمع
                                        <?php
                                        if (!empty($project->target_unit) && !empty($project->unit_price)) { // check if user set unit and unit price
                                            echo  $target = ceil(($project->total / $project->unit_price) + $project->fake_target);
                                            echo  " $project->target_unit ";
                                        } else {
                                            echo  $target = (int) $project->total + (int) $project->fake_target;
                                            echo '<svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                                                    viewBox="0 0 1024 900" style="enable-background:new 0 0 1024 900;width:15px" xml:space="preserve">
                                            <style type="text/css">
                                                .st0{fill:#444444;}
                                            </style>
                                            <path class="st0" d="M596.8,735.6L596.8,735.6c-12.6,28-20.6,57.9-23.7,88.4L835,768.3c12.6-28,20.6-57.9,23.7-88.4L596.8,735.6z"/>
                                            <path class="st0" d="M835,601.6c12.6-28,20.6-57.9,23.7-88.4l-204,43.4v-83.4L835,434.8c12.6-28,20.6-57.9,23.7-88.4l-204,43.3V89.9
                                                c-31.2,17.5-58.9,40.8-81.6,68.5v248.8l-81.6,17.3V49.1c-31.2,17.5-58.9,40.8-81.6,68.5v324.2l-182.5,38.8
                                                c-12.6,28-20.6,57.9-23.7,88.5L410,525.2v105l-221,47c-12.6,28-20.6,57.9-23.7,88.4l231.3-49.2c18.5-3.9,34.9-14.8,45.5-30.4
                                                l42.4-62.9l0,0c4.6-6.7,7-14.7,7-22.8v-92.5l81.6-17.3v166.8L835,601.6L835,601.6z"/>
                                            </svg>';
                                        }
                                        ($project->target_price) ?: $project->target_price = 1;
                                        ?>
                                    </span> </small>
                                <div class="progress" style="height: 15px; direction:ltr">
                                    <div data-toggle="tooltip" data-placement="top" title="<?php echo ceil($target * 100 / $project->target_price) . "%"; ?>" class="bg-success progress-bar-striped" role="progressbar" style="width: <?php echo ceil($target * 100 / $project->target_price) . "%"; ?>;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                            </div>
                            <div class="p-2 btn-group-toggle d-flex options" data-toggle="buttons">
                                <?php
                                ($project->target_price) ?: $project->target_price = 1;
                                $donation_type = json_decode($project->donation_type);
                                switch ($donation_type->type) {
                                    case 'share':
                                        foreach ($donation_type->value as $value) {
                                            echo '<label  data-toggle="tooltip" data-placement="top" title="' . $value->name . '" class="col btn" >
                                                <input type="radio" value ="' . $value->name . '" name="donation_type" required class="d-value" id="' . $value->value . '"> ' . $value->value . '
                                            </label>';
                                        }
                                        break;
                                    case 'open':
                                        echo '<label  data-toggle="tooltip" data-placement="top" title="" class="col text-dark border-0 active" > قم بكتابة المبلغ المراد التبرع به 
                                    <input id="1" type="hidden" name="donation_type" value="مفتوح"></label>';
                                        break;
                                    case 'unit':
                                        foreach ($donation_type->value as $value) {
                                            echo '<label  data-toggle="tooltip" data-placement="top" title="' . $value->name . '" class="col btn" >
                                                <input type="radio" value ="' . $value->name . '" name="donation_type" required class="d-value" id="' . $value->value . '"> ' . $value->value . '
                                            </label>';
                                        }
                                        echo '<label data-toggle="tooltip" data-placement="top" title=" قم بأضافة قيمة اخرى" class="col btn unit">
                                        <input type="radio" value ="other unit" name="donation_type" required class="d-value unit" id="1"> مبلغ آخر
                                        </label>';
                                        break;
                                    case 'fixed':
                                        echo '<label  data-toggle="tooltip" data-placement="top" title="' . $project->name . '" class="col btn" >
                                            <input type="radio" value ="قيمة ثابته" name="donation_type" required class="d-value" id="' . $donation_type->value . '"> ' . $donation_type->value . '
                                        </label>';
                                        break;
                                }
                                ?>
                                <input class="col text-right quantity <?php echo ($donation_type->type == 'open') ? 'd-open' : '' ?>" placeholder="<?php echo ($donation_type->type == 'open') ? 'المبلغ' : 'الكمية' ?>" type="number" name="quantity" min="1" required="">
                                <input type="hidden" name="project_id" value="<?php echo $project->project_id; ?>">
                            </div>
                            <div class="btn-actions d-flex p-2">
                                <input placeholder="القيمة" type="text" readonly required="" name="amount" class="col-6 btn amt">
                                <a href="<?php echo URLROOT . '/projects/show/' . $project->project_id . '-' . $project->alias; ?>#donate" class="col-4 btn"> تبرع الآن <i class="icofont-heartx text-primary"></i></a>
                                <button class="btn cart-add" name="index" type="submit">
                                    <i class="icofont-cart text-primary"></i>
                                </button>
                                <input type="hidden" name="url" value="<?php echo URLROOT; ?>/carts/ajaxAdd">
                            </div>
                        </div>
                    </div>
                </div>
                <!-- item -->
            <?php endforeach; ?>

        </div>
        <div class="row ">
            <nav class="col-md-6 col-12 offset-md-3 mt-5">
                <ul class="pagination nav nav-bar ">
                    <?php echo $data['pagination']; ?>
                </ul>
            </nav>
        </div>

        <div class="row ">
            <?php echo ($data['tag']->back_home) ? '<div class="col-md-6 mx-auto mt-2"><a class="w-100 btn btn-lg btn-secondary icofont-home" href="' . URLROOT . '"> العودة الي الرئيسية</a></div>' : ''; ?>
        </div>
    </div>
</section>
<!-- alertModal -->
<div class="modal fade" id="alertModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <img src="<?php echo MEDIAURL . '/' . $data['settings']['site']->logo; ?>" width="100px" class="" alt="التبرع">
            <div class="modal-body pt-0">
            </div>
            <div class="p-2 border-top">
                <a href="<?php root('carts') ?>" class="btn btn-primary">عرض السلة</a>
                <button type="button" class="btn btn-danger float-left" data-dismiss="modal">اغلاق</button>
            </div>
        </div>
    </div>
</div>
<!-- end products -->
</div>
<?php require APPROOT . '/app/views/inc/footer.php'; ?>