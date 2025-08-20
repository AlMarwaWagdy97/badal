<?php require APPROOT . '/app/views/inc/store-header.php'; ?>
<?php flash('msg'); ?>
<div class="container page">
    <?php require APPROOT . '/app/views/inc/employee-card.php'; ?>
    <div class="card mt-2">
        <div class="row no-gutters">
            <div class="col-md-9">
                <div class="card-body">
                    <h2 class="card-title pr-3 text-primary">قسم : <?php echo $data['category']->name; ?> </h2>
                    <p class="card-text"><?php echo $data['category']->description; ?></p>
                </div>
            </div>
            <div class="col-md-3" style="background: #868e96;">
                <img src="<?php echo (empty($data['category']->image)) ? MEDIAURL . '/default.jpg' : MEDIAURL . '/' . $data['category']->image; ?>" class="card-img-top h-100" alt="...">
            </div>
        </div>
    </div>
    <!--- subcategories --->
    <div class="row justify-content-center">
        <?php if (count($data['subcategories']) > 0) : ?>
            <div class="col-12">
                <h4 class="text-secondary text-center p-3"><img src="<?php echo URLROOT; ?>/templates/default/images/namaa-icon.png" alt="namaa-icon" class="ml-1"> الاقسام الفرعية</h4>
            </div>
            <?php foreach ($data['subcategories'] as $subcategories) { ?>
                <div class="col-lg-3  p-1">
                    <div class="card">
                        <a href="<?php echo URLROOT . '/store/category/' . $subcategories->category_id . '/' . $data['store']->alias ;?>">
                            <img class="card-img-top" src="<?php echo (empty($subcategories->image)) ? MEDIAURL . '/default.jpg' : MEDIAURL . '/' . $subcategories->image; ?>" alt="<?php echo $subcategories->name; ?>">
                            <div class="card-body">
                                <h6 class="card-title"><?php echo $subcategories->name; ?></h6>
                            </div>
                        </a>
                    </div>
                </div>
            <?php  } ?>
        <?php endif; ?>
    </div><!--- end subcategories --->
    <!--- Products Start --->
    <section id="products">
        <div class="row mt-4 ">
        </div>
        <div class="row">
            <?php
            echo (count($data['projects']) < 1) ? '<p class="text-center col-12 pb-5 my-5">لا يوجد منتجات تابعة لهذه الفئة</p>' : '';
            foreach ($data['projects'] as $project) :
            ?>
                <div class="product col-12 col-xl-4 col-md-6 mt-3 wow zoomIn">
                    <form class="card" method="post" action="<?php echo URLROOT . '/carts/add/'; ?>">
                        <a href="<?php echo URLROOT . '/store/project/' . $project->project_id . '/' . $data['store']->store_id . '-' . $project->alias; ?>" class="">
                            <img class="card-img-top" src="<?php echo (empty($project->secondary_image)) ? MEDIAURL . '/default.jpg' : MEDIAURL . '/' . $project->secondary_image; ?>" alt="<?php echo $project->name; ?>">
                        </a>
                        <div class="body-card m-2">
                            <p class="card-text"><?php echo mb_substr(strip_tags($project->description), 0, 85); ?></p>
                        </div>
                        <div class="p-2 amount-select">
                            <?php
                            ($project->target_price) ?: $project->target_price = 1;
                            if ($project->enable_cart) :
                                $donation_type = json_decode($project->donation_type);
                            ?>
                                <div class="my-2 btn-group-toggle" data-toggle="buttons">
                                    <?php
                                    switch ($donation_type->type) {
                                        case 'share':
                                            foreach ($donation_type->value as $value) {
                                                echo '<label class="btn btn-secondary btn-sm m-1">
                                                        <input type="radio" value ="' . $value->name . '" name="donation_type" required class="d-value" id="' . $value->value . '"> ' . $value->value . '
                                                    </label>';
                                            }
                                            break;
                                        case 'open':
                                            echo '<label class="active">قم بكتابة المبلغ المراد التبرع به
                                                    <input type="hidden" name="donation_type" value="مفتوح"></label>';
                                            break;
                                        case 'unit':
                                            foreach ($donation_type->value as $value) {
                                                echo '<label class="btn btn-secondary btn-sm m-1">
                                                        <input type="radio" value ="' . $value->name . '" name="donation_type" required class="d-value" id="' . $value->value . '"> ' . $value->value . '
                                                    </label>';
                                            }
                                            break;
                                        case 'fixed':
                                            echo '<label class="btn btn-secondary btn-sm m-1">
                                                    <input type="radio" value ="قيمة ثابته" name="donation_type" required class="d-value" id="' . $donation_type->value . '"> ' . $donation_type->value . 
                                                    ' <img src="' . MEDIAURL . '/rayal.png" width="25px">'. ' 
                                                </label>';
                                            break;
                                    }
                                    ?>
                                    <input placeholder="القيمة" min="1" type="number" class="amt col-4 rounded-lg" <?php echo ($donation_type->type == 'fixed' || $donation_type->type == 'share') ? 'readonly' : ''; ?> required name="amount">
                                    <input type="hidden" name="project_id" value="<?php echo $project->project_id; ?>">
                                    <input type="hidden" name="store_id" value="<?php echo $data['store']->store_id; ?>">
                                </div>
                            <?php endif; ?>
                            <div class="p-2">
                                <small class="m-0 pb-2">
                                    تم جمع
                                    <span class=" mx-1">
                                        <?php
                                        if (!empty($project->target_unit) && !empty($project->unit_price)) { // check if user set unit and unit price
                                            echo $target = ceil(($project->total / $project->unit_price) + $project->fake_target);
                                            echo " $project->target_unit ";
                                        } else {
                                            echo $target = (int) $project->total + $project->fake_target;
                                            echo ' <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                                                            viewBox="0 0 1024 900" style="enable-background:new 0 0 1024 900;width:15px" xml:space="preserve">
                                                       <style type="text/css">
                                                           .st0{fill:#444444;}
                                                       </style>
                                                       <path class="st0" d="M596.8,735.6L596.8,735.6c-12.6,28-20.6,57.9-23.7,88.4L835,768.3c12.6-28,20.6-57.9,23.7-88.4L596.8,735.6z"/>
                                                       <path class="st0" d="M835,601.6c12.6-28,20.6-57.9,23.7-88.4l-204,43.4v-83.4L835,434.8c12.6-28,20.6-57.9,23.7-88.4l-204,43.3V89.9
                                                           c-31.2,17.5-58.9,40.8-81.6,68.5v248.8l-81.6,17.3V49.1c-31.2,17.5-58.9,40.8-81.6,68.5v324.2l-182.5,38.8
                                                           c-12.6,28-20.6,57.9-23.7,88.5L410,525.2v105l-221,47c-12.6,28-20.6,57.9-23.7,88.4l231.3-49.2c18.5-3.9,34.9-14.8,45.5-30.4
                                                           l42.4-62.9l0,0c4.6-6.7,7-14.7,7-22.8v-92.5l81.6-17.3v166.8L835,601.6L835,601.6z"/>
                                                       </svg> ';
                                        }
                                        ($project->target_price) ?: $project->target_price = 1;
                                        ?>
                                    </span>
                                </small>
                                <small class=" pt-1 float-left"><span>المستهدف : </span>
                                    <span><?php echo $project->target_price; ?></span>
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
                                                       </svg>';;
                                    } else {
                                        echo $project->target_unit;
                                    } ?>
                                </small>
                                <div class="progress my-1">
                                    <h6 class="p-1 progress-bar progress-bar-striped bg-success" role="progressbar" style="width:<?php echo ceil($target * 100 / $project->target_price) . "%"; ?>" aria-valuenow="80" aria-valuemin="0" aria-valuemax="100">
                                        <?php echo ceil($target * 100 / $project->target_price); ?> %
                                    </h6>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer cart-footer bg-primary mt-1">
                            <div class="<?php echo $project->enable_cart ?: 'text-center'; ?> ">
                                <a href="<?php echo URLROOT . '/store/project/' . $project->project_id . '/' . $data['store']->store_id . '-' . $project->alias; ?>" class="card-text">
                                    <i class="icofont-files-stack"></i> التفاصيل
                                </a>
                                <?php if ($project->enable_cart) : ?>
                                    <button class="cart-add" name="projectCategories" value="<?php echo $project->category_id; ?>" type="submit"><i class="icofont-cart-alt"></i> أضف إلى السلة  </button>
                                    <input type="number" name="quantity" min="1" value="1" required id="quantity" class="col-2 py-0 px-0 float-left">
                                    <input type="hidden" name="url" value="<?php echo URLROOT . '/carts/ajaxAdd'; ?>">
                                <?php endif; ?>
                            </div>
                        </div>
                    </form>
                </div> <!-- end product -->
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
            <?php echo ($data['category']->back_home) ? '<div class="col-md-6 mx-auto mt-2"><a class="w-100 btn btn-lg btn-secondary icofont-home" href="' . URLROOT . '/store/' . $data['store']->alias . '"> العودة الي الرئيسية</a></div>' : ''; ?>
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
<?php require APPROOT . '/app/views/inc/store-footer.php'; ?>
<script>
    //submitting amount value 
    // if user select from units or fixed or share donation
    $('.d-value').change(function() {
        var amount = $(this).attr('id');
        // alert(amount);
        // $(this).parent().next().chiled().val(this.value)
        $(this).parent().parent().children('.amt').val(amount);
    });
</script>