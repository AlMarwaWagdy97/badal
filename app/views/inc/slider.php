<section id="slider" class="wow bounceInUp">
  <div class="owl-carousel">
    <?php
    foreach ($data['slides'] as $slide) : ?>
      <div class="banner">

        <a href="<?php echo $slide->url; ?>">
          <img src="<?php echo MEDIAURL . '/' . $slide->image; ?>" alt="<?php echo $slide->name; ?>" class="img-fluid">
          <?php
          if (!empty($slide->name) && !empty($slide->description)) : ?>
            <div class="banner-text">
              <?php echo empty($slide->name) ? '' : '<h1 class ="">' . $slide->name . "</h1>\n"; ?>
              <?php echo empty($slide->description) ? null : '<span>' . $slide->description . '</span>'; ?>
            </div>
          <?php endif; ?>
        </a>
        <!-- start share ------------------- -->
        <ul class="project-social p-0 banar-social  nav flex-column" data-toggle="collapse" data-target="#toggelShare<?= $slide->slide_id ?>">
          <a class="nav-link active bg-primary">
            <i class="icofont-share"></i>
          </a>
          <span class="collapse toggelShare" id="toggelShare<?= $slide->slide_id ?>">
            <?php   foreach(sortSetting($data['settings']['social']->sort) as $key => $share){ ?>
                <?php  if($key == "whatsapp") { ?>
                    <a target="blank" class="nav-link" href="https://wa.me/?text=<?= $slide->url; ?>"  style="color: #<?= @$data['settings']['social']->color->slider ?> ">
                        <i class="icofont-whatsapp "></i>
                    </a>
                <?php } if($key == "facebook") { ?>
                    <a target="blank" class="nav-link" href="https://www.facebook.com/sharer/sharer.php?u=<?= $slide->url; ?>"  style="color: #<?= @$data['settings']['social']->color->slider ?> ">
                        <i class="icofont-facebook "></i>
                    </a>
                <?php } if($key == "twitter") { ?>
                    <a target="blank" class="nav-link" href="https://twitter.com/intent/tweet?url=<?= $slide->url; ?>"  style="color: #<?= @$data['settings']['social']->color->slider ?> ">
                        <i class="icofont-twitter"></i>
                    </a>
                <?php } if($key == "email") { ?>
                    <a target="blank" class="nav-link" href="mailto:?&subject=&cc=&bcc=&body=<?= $slide->url; ?>"  style="color: #<?= @$data['settings']['social']->color->slider ?> ">
                        <i class="icofont-email"></i>
                    </a>
                <?php } ?> 
            <?php } ?> 
          </span>


        </ul>
        <!-- end share ------------------- -->
      </div>
    <?php endforeach; ?>
  </div>
  <?php if ($data['settings']['site']->showQuickDonation) : ?>
    <div class="quick-donation">
      <div class="slide-icon">
        <div class="slide-arrow"><i class="icofont-curved-left icofont-lg"></i></div>
        <div class="slide-button fade show"><i class="icofont-clock-time icofont-lg d-block"></i><span>تبرع سريع</span></div>
      </div>
      <div class="tabber">
        <ul class="nav nav-tabs text-right" role="tablist">
          <li class="nav-item">
            <a class="nav-link active" data-toggle="tab" href="#tab1"> كفالات</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" data-toggle="tab" href="#tab2">صدقة</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" data-toggle="tab" href="#tab3">حالات</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" data-toggle="tab" href="#tab4">مشاريع</a>
          </li>
        </ul>
        <!-- Tab panes -->
        <div class="tab-content text-center">
          <div id="tab1" class="container tab-pane active"><br>
            <form>
              <div class="row">
                <div class="col px-0">
                  <select class=" form-control form-control-sm" name="projects">
                    <option value="كفالات أيتام">كفالات أيتام</option>
                    <option value="زكـاتـك نماء">زكـاتـك نماء</option>
                    <option value="سقيا الحرم">سقيا الحرم</option>
                  </select>
                </div>
                <div class="col-3 px-1">
                  <input type="text" class="form-control form-control-sm" placeholder="المبلغ">
                </div>
              </div>
              <div class="row mt-3 card-footer py-2">
                <div class="col"><button type="submit" class="btn btn-success btn-sm  text-light"><i class="icofont-cart"></i>اضف للسلة</button></div>
                <div class="col"><button type="submit" class="btn btn-primary btn-sm"><i class="icofont-cart"></i> تبرع الآن</button></div>
              </div>
            </form>
          </div>
          <div id="tab2" class="container tab-pane fade"><br>
            <form action="form-inline">
              <div class="form-group">
                <select class="custom-select form-control-sm" name="projects">
                  <option value="صدقة">صدقة</option>
                  <option value="2صدقة">2صدقة</option>
                  <option value="صدقة3">صدقة3</option>
                </select>
              </div>
              <div class="form-group">
                <input type="text" class="form-control form-control-sm" name="price" id="price" aria-describedby="helpId" placeholder="المبلغ">
              </div>
              <div class="row mt-3 card-footer py-2">
                <div class="col"><button type="submit" class="btn btn-success btn-sm  text-light"><i class="icofont-cart"></i>اضف للسلة</button></div>
                <div class="col"><button type="submit" class="btn btn-primary btn-sm"><i class="icofont-cart"></i> تبرع الآن</button></div>
              </div>
            </form>
          </div>
          <div id="tab3" class="container tab-pane fade"><br>
            <form>
              <div class="row">
                <div class="col pl-1">
                  <select class="custom-select form-control-sm" name="projects">
                    <option value="كفالات أيتام">كفالات أيتام</option>
                    <option value="زكـاتـك نماء">زكـاتـك نماء</option>
                    <option value="سقيا الحرم">سقيا الحرم</option>
                  </select>
                </div>
                <div class="col-3 px-0">
                  <input type="text" class="form-control form-control-sm" placeholder="المبلغ">
                </div>
              </div>
              <div class="row mt-3 card-footer py-2">
                <div class="col"><button type="submit" class="btn btn-success btn-sm  text-light"><i class="icofont-cart"></i>اضف للسلة</button></div>
                <div class="col"><button type="submit" class="btn btn-primary btn-sm"><i class="icofont-cart"></i> تبرع الآن</button></div>
              </div>
            </form>
          </div>
          <div id="tab4" class="container tab-pane fade text-dark"><br>
            <h3>Menu 2</h3>
            <p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam.</p>
            <div class="row mt-3 card-footer py-2">
              <div class="col"><button type="submit" class="btn btn-success btn-sm  text-light"><i class="icofont-cart"></i>اضف للسلة</button></div>
              <div class="col"><button type="submit" class="btn btn-primary btn-sm"><i class="icofont-cart"></i> تبرع الآن</button></div>
            </div>
          </div>
        </div>
      </div>
    </div>
  <?php endif; ?>
    <?php if(@$data['settings']['site']->show_news == 1){ ?>
  <div class="news-ticker text-right">
    <div class="marquee-sibling">
      آخر الأخبار
    </div>
    <div class="marquee">
      <ul class="marquee-content-items">
        <?php
        foreach ($data['newsTicker'] as $key => $news) {
          echo '<a class="mx-2" href="' . URLROOT . '/articles/' . $news->article_id . '">
                    <span>' . $news->description . '</span>
                </a>';
        }
        ?>
      </ul>
    </div>
    <?php } ?>
  </div>
</section>
<!-- slider end -->