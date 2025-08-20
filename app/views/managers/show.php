<?php
require APPROOT . '/app/views/inc/store-header.php';
require APPROOT . '/app/views/inc/employee-card.php';
?>

<!--- Product Start --->
<section id="products">
    <div class="product mt-3 wow zoomIn">
        <div class="msg"><?php flash('msg'); ?></div>
        <div class="card pb-5">
            <?php
            $galery = array_filter(explode(',', $data['project']->image), 'strlen');
            if (count($galery) > 0) :
            ?>
                <div id="project-slider" class="carousel slide wow zoomIn" data-ride="carousel">
                    <ol class="carousel-indicators">
                        <?php for ($i = 0; $i < count($galery); $i++) : ?>
                            <li data-target="#project-slider" data-slide-to="<?php echo $i; ?>" class="<?php echo ($i == 0) ? 'active' : ''; ?>"></li>
                        <?php endfor; ?>
                    </ol>
                    <div class="carousel-inner">
                        <?php foreach ($galery as $key => $img) : ?>
                            <div class="carousel-item <?php echo ($key == 0) ? 'active' : ''; ?>">
                                <img class="d-block w-100" src="<?php echo MEDIAURL . '/' . str_replace('&#34;', '', trim(trim($img, ']'), '[')); ?>" alt="">
                            </div>
                        <?php endforeach; ?>
                    </div>
                    <a class="carousel-control-prev" href="#project-slider" role="button" data-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="sr-only">Previous</span>
                    </a>
                    <a class="carousel-control-next" href="#project-slider" role="button" data-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="sr-only">Next</span>
                    </a>
                </div>
            <?php endif; ?>
            <div class="text-white bg-primary">
                <div class="row m-0">
                    <div class="col-12">
                        <div class="p-2">
                            <p class="m-0 pb-2">
                                تم جمع
                                <span class="h4 mx-1">
                                    <?php
                                    if (!empty($data['project']->target_unit) && !empty($data['project']->unit_price)) { // check if user set unit and unit price
                                        echo $target = ceil(($data['collected_traget'] / $data['project']->unit_price) + $data['project']->fake_target);
                                        echo  " " . $data['project']->target_unit;
                                    } else {
                                        echo $target = $data['collected_traget'] + $data['project']->fake_target;
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
                                    ($data['project']->target_price) ?: $data['project']->target_price = 1;
                                    ?>
                                </span>
                            </p>
                            <div class="progress">
                                <h6 class="p-1 progress-bar progress-bar-striped bg-success" role="progressbar" style="width:<?php echo ceil($target * 100 / $data['project']->target_price) . "%"; ?>" aria-valuenow="80" aria-valuemin="0" aria-valuemax="100">
                                    <?php echo ceil($target * 100 / $data['project']->target_price); ?> %
                                </h6>
                            </div>
                            <h5 class="h3 pt-1 text-left"><span>المستهدف : </span>
                                <span><?php echo $data['project']->target_price; ?></span>
                                <?php if (empty($data['project']->target_unit)) {
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
                                    echo  $data['project']->target_unit;
                                }  ?>
                            </h5>
                        </div>
                    </div>
                </div>
            </div>
            <div class="body-card m-2">
                <h1 class="font-weight-bold text-center h2"><?php echo $data['project']->name; ?></h1>
                <p class="card-text"><?php echo $data['project']->description; ?></p>
            </div>
            <?php if (!$data['project']->finished) : ?>
                <div class="card-footer bg-primary mt-1">
                    <div class="text-center  ">
                        <h4 class="text-white">ملئ معلومات الطلب </h4>
                    </div>
                </div>
                <div class="pay-form p-5">
                    <div class="msg"><?php flash('msg'); ?></div>
                    <form method="post" action="<?php root('projects'); ?>/redirect" id="pay">
                        <div class="form-group row">
                            <label for="full-name" class="col-sm-2 col-form-label">الاسم بالكامل</label>
                            <div class="col-sm-10">
                                <input type="hidden" name="mobile_confirmed" value="no" id="mobile-confirmed">
                                <input type="hidden" name="store_id" value="<?php echo (int) $data['store_id']; ?>">
                                <input type="hidden" name="project_id" value="<?php echo $data['project']->project_id; ?>" id="project_id">
                                <input type="text" class="form-control" name="full_name" id="full-name" data-inputmask-regex="^[\u0621-\u064Aa-zA-Z\-_\s]+$" placeholder="الاسم بالكامل">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="mobile" class="col-sm-2 col-form-label">رقم الجوال</label>
                            <div class="input-group col-sm-10 mobile-validate">
                                <input dir="ltr" class="form-control" name="mobile" type="text" placeholder="0500000000" id="mobile" data-inputmask="'mask': '9999999999'">
                                <?php if ($data['project']->mobile_confirmation == 1) : ?>
                                    <div class="">
                                        <a class="input-group-text activate" data-toggle="modal" data-target="#addcode-x">ارسال </a>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="form-group row mt-4">
                            <label for="full-name" class="col-sm-2 col-form-label"> البريد الالكتروني </label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="email" placeholder="هام لاستقبال رسائل التأكيد ">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="" class="col-sm-2 col-form-label">خيارات التبرع </label>
                            <?php
                            $donation_type = json_decode($data['project']->donation_type);
                            ?>
                            <div class="input-group col-sm-8">
                                <div class=" btn-group-toggle" data-toggle="buttons">
                                    <?php
                                    switch ($donation_type->type) {
                                        case 'share':
                                            foreach ($donation_type->value as $value) {
                                                echo '<label class="btn btn-secondary  m-1">
                                                        <input type="radio" value ="' . $value->value . '" name="donation_type" required class="donation-value"> ' . $value->name . '
                                                        <input type="hidden" name="donation_type" value="" class="donation_type_name">
                                                    </label>';
                                            }
                                            break;
                                        case 'open':
                                            echo 'قم بكتابة المبلغ المراد التبرع به 
                                            <input type="hidden" name="donation_type" value="مفتوح" class="donation_type_name">
                                            ';
                                            break;
                                        case 'unit':
                                            foreach ($donation_type->value as $value) {
                                                echo '<label class="btn btn-secondary  m-1">
                                                        <input type="radio" value ="' . $value->value . '" name="donation_type" class="donation-value"> ' . $value->name . '
                                                        <input type="hidden" name="donation_type" value="" class="donation_type_name">
                                                        </label>';
                                            }
                                            break;
                                        case 'fixed':
                                            echo '<label class="btn btn-secondary  m-1">
                                                    <input type="radio" value ="' . $donation_type->value . '" name="donation_type" class="donation-value"> ' . $donation_type->value . 
                                                    ' <img src="' . MEDIAURL . '/rayal.png" width="25px">'.' 
                                                        <input type="hidden" name="donation_type" value="قيمة ثابته" class="donation_type_name">
                                                </label>';
                                            break;
                                    }
                                    ?>
                                    <span class="donation_type_error"></span>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="" class="col-sm-2 col-form-label">القيمة : </label>
                            <div class="input-group col-sm-2">
                                <input placeholder="القيمة" min="1" type="number" class="form-control amount" <?php echo ($donation_type->type == 'fixed' || $donation_type->type == 'share') ? 'readonly' : ''; ?> required name="amount">
                            </div>
                            <span class="amout_error"></span>
                        </div>
                        <div class="form-group row <?php echo ($donation_type->type == 'open') ? "d-none" : ""; ?>">
                            <label for="" class="col-sm-2 col-form-label"> الكمية: </label>
                            <div class="input-group col-sm-2">
                                <input type="number" name="quantity" min="1" value="1" required id="quantity" class="form-control d-inline">
                            </div>
                            <span class="quantity_error"></span>
                        </div>
                        <div class="form-group row">
                            <label for="" class="col-sm-2 col-form-label">القيمة الاجمالية: </label>
                            <div class="input-group col-sm-2">
                                <input type="number" readonly name="total" id="total" class="form-control d-inline">
                            </div>
                            <span class="total_error"></span>
                        </div>
                        <?php if ($data['project']->gift) : ?>
                            <div class="gift-options form-group row">
                                <label for="" class="col-7 col-sm-2 col-form-label"> الاهداء الخيري </label>
                                <div class="input-group col-5 col-sm-10">
                                    <div class=" btn-group-toggle" data-toggle="buttons">
                                        <label class="btn btn-primary  mt-2  mx-1">
                                            <input type="radio" value="1" name="gift[enable]" class="gift"> اهداء هذا التبرع
                                        </label>
                                        <label class="btn btn-danger  mt-2  mx-1">
                                            <input type="radio" value="0" checked name="gift[enable]" class="gift"> الغاء
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="gift-values form-group row">
                                <label for="" class="col-sm-2 col-form-label"> اسم المهدي الية </label>
                                <div class="input-group col-sm-10">
                                    <input type="text" class="form-control" name="gift[giver_name]" id="giver_name" data-inputmask-regex="^[\u0621-\u064Aa-zA-Z\-_\s]+$" value="">
                                </div>
                            </div>
                            <div class="gift-values form-group row">
                                <label for="" class="col-sm-2 col-form-label"> رقم المهدي الية </label>
                                <div class="input-group col-sm-10">
                                    <input type="text" class="form-control ltr" name="gift[giver_number]" id="giver_number" data-inputmask="'mask': '0599999999'" placeholder="رقم المهدي اليه">
                                </div>
                            </div>
                            <div class="gift-values form-group row">
                                <label for="" class="col-sm-2 col-form-label"> فئات الاهداء </label>
                                <div class="input-group col-sm-10">
                                    <select name="gift[giver_group]" id="giver_group" class="custom-select">
                                        <option value="">اختار فئة الإهداء</option>
                                        <?php
                                        foreach ($data['settings']['gift'] as $key => $value) {
                                            echo  '<option id="' . str_replace('_name', '', $key) . '" value="' . $value->name . '">' . $value->name . '</option>';
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="gift-values form-group row">
                                <label for="" class="col-7 col-sm-2 col-form-label"> كارت الاهداء </label>
                                <div class="input-group col-5 col-sm-10">
                                    <div class=" btn-group-toggle" data-toggle="buttons">
                                        <?php
                                        foreach ($data['settings']['gift'] as $key => $value) {
                                            $values = explode(',', $value->image);
                                            foreach ($values as $val) {
                                                $val = str_replace('&#34;', '', trim(trim($val, ']'), '['));
                                                echo '<label class="btn btn-light group-img d-none" id="' . $key . '">
                                                    <input type="radio" value="' . $val . '" name="gift[card]" >
                                                    <img alt="lightbox" width="100" src="' . MEDIAURL . "/" . $val . '" class="h-100 img-thumbnail">
                                                  </label>';
                                            }
                                        }
                                        ?>
                                    </div>
                                </div>
                            </div>
                        <?php endif; ?>
                        <div class="form-group row">
                            <label for="" class="col-sm-2 col-form-label">وسيلة الدفع </label>
                            <div class="input-group col-sm-8 ">
                                <div class=" btn-group-toggle" data-toggle="buttons">
                                    <?php
                                    foreach ($data['payment_methods'] as $payment_method) {
                                        echo '<label class="btn btn-primary  mt-2  mx-1">
                                                <input type="radio" value ="' . $payment_method->payment_id . '" name="payment_method" required class="payment_method"> ' . $payment_method->title . '
                                            </label>';
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>

                        <div class="form-group text-center">
                            <button class="btn btn-primary btn-lg m-2 px-5" name="pay" type="submit">دفع <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                                                            viewBox="0 0 1024 900" style="enable-background:new 0 0 1024 900;width:15px" xml:space="preserve">
                                                       <style type="text/css">
                                                           .st0{fill:#444444;}
                                                       </style>
                                                       <path class="st0" d="M596.8,735.6L596.8,735.6c-12.6,28-20.6,57.9-23.7,88.4L835,768.3c12.6-28,20.6-57.9,23.7-88.4L596.8,735.6z"/>
                                                       <path class="st0" d="M835,601.6c12.6-28,20.6-57.9,23.7-88.4l-204,43.4v-83.4L835,434.8c12.6-28,20.6-57.9,23.7-88.4l-204,43.3V89.9
                                                           c-31.2,17.5-58.9,40.8-81.6,68.5v248.8l-81.6,17.3V49.1c-31.2,17.5-58.9,40.8-81.6,68.5v324.2l-182.5,38.8
                                                           c-12.6,28-20.6,57.9-23.7,88.5L410,525.2v105l-221,47c-12.6,28-20.6,57.9-23.7,88.4l231.3-49.2c18.5-3.9,34.9-14.8,45.5-30.4
                                                           l42.4-62.9l0,0c4.6-6.7,7-14.7,7-22.8v-92.5l81.6-17.3v166.8L835,601.6L835,601.6z"/>
                                                       </svg> </button>
                            <?php if ($data['project']->enable_cart) : ?>
                                <a href="<?php echo URLROOT . '/carts/ajaxAdd'; ?>" id="addToCart" class="btn btn-lg p-2 btn-success">  أضف إلى السلة <i class="icofont-cart-alt"></i> </a>
                            <?php endif; ?>
                        </div>
                    </form>
                </div>
                <h3 class="my-4 text-center h5"><i class="icofont-stylish-right"></i> تصدق بالنشر ولك الأجر فالدال على الخير كفاعله<i class="icofont-stylish-left"></i></h3>
                <!-- code activation modal -->
                <div id="addcode" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="addcode-title" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button class="close m-0 p-0" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                                <h5 class="modal-title mx-auto" id="addcode-title">كود التفعيل</h5>
                            </div>
                            <div class="modal-body">
                                <form method="post" action="<?php root('projects'); ?>" id="active-code">
                                    <div class="msg"></div>
                                    <input class="form-control" name="code" type="text" placeholder="code" aria-label="code">
                                    <input class="btn btn-success mt-2" name="verify" type="submit" value="تفعيل">
                                    <input class="btn btn-danger mt-2 float-left" name="verify" type="submit" data-dismiss="modal" value="غلق">
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            <?php else : echo '<p class="text-center border p-2 text-success"> تم اغلاق التبرع لهذا المشروع </p>';
            endif; ?>
            <div class="divider mx-auto p-1">
                <!-- Go to www.addthis.com/dashboard to customize your tools -->
                <div class="addthis_inline_share_toolbox"></div>
            </div>
            <!-- more projects -->
            <section id="categories">
                <div class="row mt-2 px-2">
                    <div class="col-12 wow zoomIn owl-carousel">
                        <?php foreach ($data['moreprojects'] as $moreprojects) : ?>
                            <div class="project">
                                <a class="">
                                    <img class="card-img-top rounded" src="<?php echo (empty($moreprojects->secondary_image)) ? MEDIAURL . '/default.jpg' : MEDIAURL . '/' . $moreprojects->secondary_image; ?>" alt="<?php echo $moreprojects->name; ?>">
                                    <div class="content p-1">
                                        <h3 class="project-title mt-2"><?php echo $moreprojects->name; ?></h3>
                                        <div class="text-center mt-2">
                                            <a href="<?php echo URLROOT . '/store/project/' . $moreprojects->project_id . '/' . $data['store']->store_id . '-' . $moreprojects->name; ?>" class="btn btn-section mb-4"> <i class="icofont-paper"></i> التفاصيل</a>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </section>
            <!-- end more projects -->

            <div class="row text-center mx-1 mt-4 ">
                <?php echo ($data['store']->whatsapp) ? '<div class="col-md-6 mx-auto mt-2"><a class="w-100 btn btn-lg btn-success icofont-whatsapp" href="https://wa.me/' . $data['store']->whatsapp . ' "> ' . $data['store']->whatsapp . ' </a></div>' : ''; ?>
                <?php echo ($data['store']->mobile) ? '<div class="col-md-6 mx-auto mt-2"><a class="w-100 btn btn-lg btn-primary icofont-phone" href="tel:' . $data['store']->mobile . '"> ' . $data['store']->mobile . '</a></div>' : ''; ?>
            </div>
            <div class="row ">
                <?php echo ($data['project']->back_home) ? '<div class="col-md-6 mx-auto mt-2"><a class="w-100 btn btn-lg btn-secondary icofont-home" href="' . URLROOT . '/store/' . $data['store']->alias . '"> العودة الي الرئيسية</a></div>' : ''; ?>
            </div>
        </div>
    </div>
</section>
<!-- alertModal -->
<div class="modal fade" id="alertModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
            </div>
            <div class="p-2 border-top">
                <a href="<?php root('carts') ?>" class="btn btn-primary">عرض السلة</a>
                <button type="button" class="btn btn-danger float-left" data-dismiss="modal">اغلاق</button>
            </div>

        </div>
    </div>
</div>
<!-- card image popup Modal -->
<div class="modal fade" id="popup">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-body">
            </div>
        </div>
    </div>
</div>
<!-- End product -->
<?php
$footer = ' <script src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-508116077910fef8"></script>' . "\n\t";
require APPROOT . '/app/views/inc/store-footer.php'; ?>