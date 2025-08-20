<?php
require APPROOT . '/app/views/inc/header.php';
if ($data['settings']['site']->show_banner) :
    require APPROOT . '/app/views/inc/slider.php';
endif;
flash('msg');
?>
<section id="projects">
    <div class="container-md">
        <div class="projects-header text-center text-primary">
            <?php if (!empty($data['settings']['site']->project_text)) : ?>
                <h1 class="py-3"><?= $data['settings']['site']->project_text; ?></h1>
                <div class="slide-top"><i class="icofont-rounded-double-left h2"></i></div>
            <?php endif; ?>
        </div>
        <?php if ($data['settings']['site']->enableTages) : ?>
            <div class="col-12 mb-4 mt-2 bg-primary rounded shadow-sm p-2 tags">
                <div class="scrollmenu text-right text-nowrap">
                    <?php
                    foreach ($data['tags'] as $tag) {
                        echo '<a class="btn btn-primary py-0 px-2 ml-1 text-light" href="' . URLROOT . '/tags/show/' . $tag->tag_id . '-">' . $tag->name . '</a>';
                    }
                    ?>
                </div>
            </div>
        <?php endif; ?>
    </div>
    <?php
    if ($data['settings']['site']->show_projects) :
        $key = 1;
        foreach ($data['categories'] as $category) :
            if ($category->featured && $key < 20) : ?>
                <div class="projects<?= $key++ ?> pt-2 wow bounceInUp" style="background:<?= $category->section_bg; ?>">
                    <div class="container-md projects">
                        <div class="projects-title">
                            <h1 class="project-heading btn m-0 bg-primary">
                                <a class="text-light" href="<?= URLROOT . '/projectCategories/show/' . $category->category_id; ?>">
                                    <i class=""></i><?= $category->name ?>
                                </a>
                            </h1>
                        </div>
                        <div class="owl-carousel">
                            <?php foreach ($data['projects'] as $index => $project) : ?>
                                <?php if ($category->category_id == $project->category_id) : ?>
                                    <div class="project mb-3">
                                        <div class="project-img">
                                            <?php if ($project->finished) echo '<span class="closed">مغلق</span>'; ?>
                                            <a class="" href="<?= URLROOT . '/projects/show/' . $project->project_id . '-' . $project->alias; ?>" title="">
                                                <img class="" src="<?= (empty($project->secondary_image)) ? MEDIAURL . '/default.jpg' : MEDIAURL . '/' . $project->secondary_image; ?>">
                                            </a>

                                            <ul class="project-social p-0 nav flex-column" data-toggle="collapse" data-target="#toggelShare<?= $project->project_id ?>">
                                                <a class="nav-link active bg-primary">
                                                    <i class="icofont-share"></i>
                                                </a>
                                                <span class="collapse toggelShare" id="toggelShare<?= $project->project_id ?>">
                                                <?php   foreach(sortSetting($data['settings']['social']->sort) as $key => $share){ 
                                                    $whatsmessage = str_replace('[[name]]', $project->name , $data['settings']['social']->whatsapp_content);
                                                    $whatsmessage = str_replace('[[link]]', URLROOT . '/projects/show/' . $project->project_id, $whatsmessage);
                                                    if($key == "whatsapp") { ?>
                                                        <a target="blank" class="nav-link" href="https://wa.me/?text=<?= $whatsmessage; ?>" style="color: #<?= @$data['settings']['social']->color->products ?> ">
                                                            <i class="icofont-whatsapp "></i>
                                                        </a>
                                                    <?php } if($key == "facebook") { ?>
                                                        <a target="blank" class="nav-link" href="https://www.facebook.com/sharer/sharer.php?u=<?= URLROOT . '/projects/show/' . $project->project_id; ?>" style="color: #<?= @$data['settings']['social']->color->products ?> ">
                                                            <i class="icofont-facebook "></i>
                                                        </a>
                                                    <?php } if($key == "twitter") { ?>
                                                        <a target="blank" class="nav-link" href="https://twitter.com/intent/tweet?url=<?= URLROOT . '/projects/show/' . $project->project_id; ?>&text=<?= $project->name; ?>" style="color: #<?= @$data['settings']['social']->color->products ?> ">
                                                            <i class="icofont-twitter"></i>
                                                        </a>
                                                    <?php } if($key == "email") { ?>
                                                        <a target="blank" class="nav-link" href="mailto:?&subject=&cc=&bcc=&body=<?= URLROOT . '/projects/show/' . $project->project_id; ?>%0A<?= $project->name; ?>" style="color: #<?= @$data['settings']['social']->color->products ?> ">
                                                            <i class="icofont-email"></i>
                                                        </a>
                                                    <?php } ?> 
                                                <?php } ?> 
                                                    
                                                </span>
                                            </ul>
                                            <a class="project-title" href="<?= URLROOT . '/projects/show/' . $project->project_id . '-' . $project->alias; ?>" title="<?= $project->name; ?>">
                                                <h5><?= $project->name; ?></h5>
                                            </a>
                                        </div>
                                        <div class="project-details">
                                            <div class="target p-3">
                                                <small class=" pt-1 float-right"> <span> المستهدف:
                                                        <?= $project->target_price; ?>
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
                                                            </svg>';
                                                        }
                                                        ($project->target_price) ?: $project->target_price = 1;
                                                        ?>
                                                    </span>
                                                </small>
                                                <div class="progress mt-3" style="height: 15px; direction:ltr">
                                                    <div data-toggle="tooltip" data-placement="top" title="<?= ceil($target * 100 / $project->target_price) . "%"; ?>" class="bg-dark progress-bar-striped" role="progressbar" style="width: <?= ceil($target * 100 / $project->target_price) . "%"; ?>;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
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
                                                        echo '<label  data-toggle="tooltip" data-placement="top" title="" class="col text-dark border-0 active open-donation" > قم بكتابة المبلغ المراد التبرع به 
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
                                                <input class="col text-right quantity <?= ($donation_type->type == 'open') ? 'd-open' : '' ?>" placeholder="<?= ($donation_type->type == 'open') ? 'المبلغ' : 'الكمية' ?>" type="number" name="quantity" min="1" required="">
                                                <input type="hidden" name="project_id" value="<?= $project->project_id; ?>">
                                            </div>
                                            <div class="btn-actions d-flex p-2 bg-primary">
                                                <input placeholder="القيمة" type="text" readonly required="" name="amount" class="col-6 btn amt">
                                                <!--<a href="<?= URLROOT . '/projects/show/' . $project->project_id . '-' . $project->alias; ?>#donate" class="col-4 btn"> تبرع الآن <i class="icofont-heartx text-primary"></i></a>-->
                                                 <?php if($project->project_id == "2428" ){ ?>
                                                    <a href="<?= URLROOT . '/projects/show/' . $project->project_id . '-' . $project->alias; ?>#donate" class="col-4 btn"> وكلنا الآن  <i class="icofont-heartx text-primary"></i></a>
                                                <?php } else { ?>
                                                    <a href="<?= URLROOT . '/projects/show/' . $project->project_id . '-' . $project->alias; ?>#donate" class="col-4 btn"> تبرع الآن <i class="icofont-heartx text-primary"></i></a>
                                                <?php } ?>
                                                <!-- <button class="btn cart-go px-4 pt-0" name="index" type="submit">تبرع الآن <i class="icofont-heart text-primary"></i></button> -->
                                                <button class="btn cart-add" name="index" type="submit">
                                                    <i class="icofont-cart text-primary"></i>
                                                </button>
                                                <input type="hidden" name="url" value="<?= URLROOT; ?>/carts/ajaxAdd">
                                            </div>
                                        </div>
                                    </div>
                                    <!-- item -->
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </div>
                    
                        <?php if (!empty($category->ads_banner)) : ?>
                            <div class="text-center">
                                <div class="col-md-12">
                                    <!-- start share ------------------- -->
                                    <ul class="project-social p-0 banar-box  nav flex-column" data-toggle="collapse" data-target="#toggelShare1<?= $category->category_id ?>">
                                        <a class="nav-link active bg-primary">
                                            <i class="icofont-share"></i>
                                        </a>
                                        <span class="collapse toggelShare" id="toggelShare1<?= $category->category_id ?>">
                                            <?php   foreach(sortSetting($data['settings']['social']->sort) as $key => $share){ ?>
                                                <?php  if($key == "whatsapp") { ?>
                                                    <a target="blank" class="nav-link" href="https://wa.me/?text=<?= $category->ads_url; ?>"  style="color: #<?= @$data['settings']['social']->color->ads ?> ">
                                                        <i class="icofont-whatsapp "></i>
                                                    </a>
                                                <?php } if($key == "facebook") { ?>
                                                    <a target="blank" class="nav-link" href="https://www.facebook.com/sharer/sharer.php?u=<?= $category->ads_url; ?>"  style="color: #<?= @$data['settings']['social']->color->ads ?> ">
                                                        <i class="icofont-facebook "></i>
                                                    </a>
                                                <?php } if($key == "twitter") { ?>
                                                    <a target="blank" class="nav-link" href="https://twitter.com/intent/tweet?url=<?= $category->ads_url; ?>"  style="color: #<?= @$data['settings']['social']->color->ads ?> ">
                                                        <i class="icofont-twitter"></i>
                                                    </a>
                                                <?php } if($key == "email") { ?>
                                                    <a target="blank" class="nav-link" href="mailto:?&subject=&cc=&bcc=&body=<?= $category->ads_url; ?>"  style="color: #<?= @$data['settings']['social']->color->ads ?> ">
                                                        <i class="icofont-email"></i>
                                                    </a>
                                                <?php } ?> 
                                            <?php } ?> 
                                        </span>
                                    </ul>
                                    <!-- end share ------------------- -->

                                    <a class="" href="<?= $category->ads_url; ?>">
                                        <img class="img-fluid w-100" src="<?= MEDIAURL . '/' . $category->ads_banner; ?>" alt="" srcset="">
                                    </a>
                                </div>
                            </div>
                        <?php endif;
                        if (!empty($category->ads2_banner)) : ?>
                            <div class="text-center pt-2">
                                <div class="col-md-12">
                                    <!-- start share ------------------- -->
                                    <ul class="project-social p-0 banar-box  nav flex-column" data-toggle="collapse" data-target="#toggelShare2<?= $category->category_id ?>">
                                        <a class="nav-link active bg-primary">
                                            <i class="icofont-share"></i>
                                        </a>
                                        <span class="collapse toggelShare" id="toggelShare2<?= $category->category_id ?>">
                                        <?php   foreach(sortSetting($data['settings']['social']->sort) as $key => $share){ ?>
                                            <?php  if($key == "whatsapp") { ?>
                                                <a target="blank" class="nav-link" href="https://wa.me/?text=<?= $category->ads2_url; ?>" style="color: #<?= @$data['settings']['social']->color->ads ?> ">
                                                    <i class="icofont-whatsapp "></i>
                                                </a>
                                            <?php } if($key == "facebook") { ?>
                                                <a target="blank" class="nav-link" href="https://www.facebook.com/sharer/sharer.php?u=<?= $category->ads2_url; ?>" style="color: #<?= @$data['settings']['social']->color->ads ?> ">
                                                    <i class="icofont-facebook "></i>
                                                </a>
                                            <?php } if($key == "twitter") { ?>
                                                <a target="blank" class="nav-link" href="https://twitter.com/intent/tweet?url=<?= $category->ads2_url; ?>" style="color: #<?= @$data['settings']['social']->color->ads ?> ">
                                                    <i class="icofont-twitter"></i>
                                                </a>
                                            <?php } if($key == "email") { ?>
                                                <a target="blank" class="nav-link" href="mailto:?&subject=&cc=&bcc=&body=<?= $category->ads2_url; ?>" style="color: #<?= @$data['settings']['social']->color->ads ?> ">
                                                    <i class="icofont-email"></i>
                                                </a>
                                            <?php } ?> 
                                        <?php } ?> 
                                           
                                        </span>
                                    </ul>
                                    <!-- end share ------------------- -->
                                    <a class="" href="<?= $category->ads2_url; ?>">
                                        <img class="img-fluid w-100" src="<?= MEDIAURL . '/' . $category->ads2_banner; ?>" alt="" srcset="">
                                    </a>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- end projects row -->
    <?php endif;
        endforeach;
    endif; ?>
</section>
<!-- projects end -->
<?php if ($data['settings']['site']->show_categories) : ?>
    <section id="categories" class="wow bounceInUp">
        <div class="categories">
            <div class="container-md text-center">
                <div class="projects-header text-center text-primary">
                    <?php if (!empty($data['settings']['site']->category_text)) : ?>
                        <h1 class="py-1 h2">
                            <img src="<?= URLROOT; ?>/templates/namaa/images/namaa-icon.png" alt="namaa-icon" class="">
                            <a href="<?= URLROOT . '/projectCategories' ?>"><?= $data['settings']['site']->category_text; ?></a>
                        </h1>
                    <?php endif; ?>
                </div>
                <div class="owl-carousel ">
                    <?php foreach ($data['categories'] as $category) : ?>
                        <?php if ($category->level == 1) : ?>
                            <div class="project-category">
                                <div class="category-container my-3">
                                    <img class="rounded-circle p-4" src="<?= (empty($category->image)) ? MEDIAURL . '/default.jpg' : MEDIAURL . '/' . $category->image; ?>" alt="<?= $category->name; ?>">
                                    <a href="<?= URLROOT . '/projectCategories/show/' . $category->category_id; ?>" class="category-title">
                                        <h1 class="h6 my-2"><?= $category->name; ?></h1>
                                    </a>
                                    <p class="content text-secondary p-1 "><?= mb_substr(strip_tags($category->description), 0, 80); ?></p>
                                    <a class="btn btn-outline-secondary btn-sm mb-3 category-btn" href="<?= URLROOT . '/projectCategories/show/' . $category->category_id; ?>">التفاصيل</a>
                                </div>
                            </div>
                    <?php endif;
                    endforeach; ?>
                </div>
            </div>
        </div>
    </section>
    <!-- categories end -->
<?php endif;
if ($data['settings']['site']->show_media) : ?>
    <section id="media" class=" wow bounceInUp bg-light">
        <div class="container-md py-5">
            <?php if (!empty($data['settings']['site']->media_text)) : ?>
                <div class="text-center mb-5 projects-header">
                    <h1 class="h3 text-primary">
                        <img src="<?= URLROOT; ?>/templates/namaa/images/namaa-icon.png" alt="namaa-icon" class="">
                        <a href="<?= URLROOT . '/articles' ?>"><?= $data['settings']['site']->media_text; ?></a>
                    </h1>
                </div>
            <?php endif; ?>
            <div class="row">
                <?php if (count($data['articles']) > 0) : ?>
                    <div class="col-lg-6 d-none d-lg-block main-news p-2">
                        <div class="main-news-img mx-1">
                            <img src="<?= (empty($data['articles'][0]->image)) ? MEDIAURL . '/default.jpg' : MEDIAURL . '/' . $data['articles'][0]->image; ?>" class="img-fluid" alt="">
                            <div class="main-news-content">
                                <h5 class="news-title text-white h3 "><?= $data['articles'][0]->name; ?></h5>
                                <br>
                                <a class="btn btn-primary mt-3 btn-sm px-3 main-news-url" href="<?= URLROOT . '/articles/show/' . $data['articles'][0]->article_id . '-' . $data['articles'][0]->name; ?>">المزيد</a>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
                <div class="col-lg-6 text-right pt-2">
                    <?php foreach ($data['articles'] as $article) : ?>
                        <div class="news bg-white row py-1 mb-1">
                            <a href="<?= URLROOT . '/articles/show/' . $article->article_id ; ?>" class="news-img col-3">
                                <img src="<?= (empty($article->image)) ? MEDIAURL . '/default.jpg' : MEDIAURL . '/' . $article->image; ?>" alt="<?= $article->name; ?>" class="img-thumbnail">
                            </a>
                            <div class="news-content col-9">
                                <h6 class="news-title text-primary h6"><?= $article->name; ?></h6>
                                <small class="news-headline text-secondary">
                                    <?= mb_substr(strip_tags($article->description), 0, 120); ?>
                                    <a class="px-3" href="<?= URLROOT . '/articles/show/' . $article->article_id ; ?>">المزيد</a>
                                </small>
                            </div>
                        </div>
                        <!-- item -->
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </section>
    <!-- media end -->
<?php endif;
if ($data['settings']['site']->show_video) : ?>
    <section id="video" class="bg-battern wow bounceInUp py-5">
        <div class="container">
            <div class="row text-center">
                <div class="video-content col-12 col-lg-4 border rounded bg-dark bg-battern my-2">
                    <h4 class="h4 text-white my-5"><?= $data['settings']['site']->videoTitle; ?> </h4>
                    <p class="text-light"><?= $data['settings']['site']->videoDescription; ?></p>
                    <a href="<?= $data['settings']['site']->videoMore; ?>" class="btn btn-outline-primary m-3">المزيد</a>
                </div>
                <div class="col-lg-8 col-12 video-file my-2">
                    <div class="embed-responsive embed-responsive-16by9">
                        <iframe class="embed-responsive-item rounded" src="<?= str_replace('https://youtu.be/', 'https://www.youtube.com/embed?playlist=', $data['settings']['site']->videoURL); ?>&rel=0;&autoplay=1&mute=1&loop=1" frameborder="0" allowfullscreen></iframe>
                    </div>
                </div>

            </div>
        </div>
    </section>
    <!-- video end -->
<?php endif; ?>
<!-- alertModal -->
<div class="modal fade" id="alertModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <img src="<?= MEDIAURL . '/' . $data['settings']['site']->logo; ?>" width="100px" class="" alt="التبرع">
            <div class="modal-body pt-0">
            </div>
            <div class="p-2 border-top">
                <a href="<?php root('carts') ?>" class="btn btn-primary ml-2">عرض السلة</a>
                <button type="button" class="btn btn-danger float-left" data-dismiss="modal">اغلاق</button>
            </div>
        </div>
    </div>
</div>
<?php require APPROOT . '/app/views/inc/footer.php'; ?>