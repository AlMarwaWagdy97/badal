<?php require APPROOT . '/app/views/inc/header.php';?>
<div class="undermenu">
    <!-- Categories -->
    <section id="categories" class="container text-center">
        <div class="row m-3 justify-content-center ">
            <div class="col">
                <h2 class="text-center"> <img src="<?php echo URLROOT; ?>/templates/default/images/namaa-icon.png" alt="Smiley face" class="ml-2">الوسوم</h2>
            </div>
        </div>
        <div class="row">
            <?php
            echo (count($data['tags']) < 1) ? '<p class="text-center col-12 pb-5 my-5">لا يوجد منتجات تابعة لهذا القسم</p>' : '';
            foreach ($data['tags'] as $tag) :
            ?>
                <div class="project-category col-lg-4">
                    <div class="category-container ">
                        <img class="rounded-circle p-4 img-fluid" src="<?php echo (empty($tag->image)) ? MEDIAURL . '/default.jpg' : MEDIAURL . '/' . $tag->image; ?>" alt="<?php echo $tag->name; ?>">
                        <a href="<?php echo URLROOT . '/tags/show/' . $tag->tag_id . '-' . $tag->name; ?>" class="category-title">
                            <h1 class="h6 my-2"><?php echo $tag->name; ?></h1>
                        </a>
                        <a class="btn btn-outline-secondary btn-sm mb-3 category-btn" href="<?php echo URLROOT . '/tags/show/' . $tag->tag_id . '-' . $tag->name; ?>">التفاصيل</a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
        <div class="row ">
            <nav class="col-md-6 col-12 offset-md-3 mt-5">
                <ul class="pagination nav nav-bar ">
                    <?php echo $data['pagination']; ?>
                </ul>
            </nav>
        </div>
        <div class="row mb-1">
            <div class="col-md-6 mx-auto my-4"><a class="w-100 btn btn-lg btn-secondary icofont-home" href="<?php echo URLROOT; ?>"> العودة الي الرئيسية</a></div>
        </div>
    </section>
    <!-- end Categories -->
</div>
<?php require APPROOT . '/app/views/inc/footer.php'; ?>