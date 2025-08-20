<?php require APPROOT . '/app/views/inc/header.php'; ?>
<div class="undermenu">
    <!-- Categories -->
    <section id="news" class="container text-center">
        <div class="row m-3 justify-content-center ">
            <div class="col">
                <h2 class="text-center"> <img src="<?php echo URLROOT; ?>/templates/default/images/ehssan-icon.png" alt="Smiley face" class="ml-2"><?php echo $data['pageTitle']; ?></h2>
            </div>
        </div>
        <div class="row">
            <?php
            echo (count($data['news']) < 1) ? '<p class="text-center col-12 pb-5 my-5">لا يوجد مقالات تابعة لهذا القسم</p>' : '';
            foreach ($data['news'] as $article) :
            ?>
                <div class="project-article col-lg-4 p-1">
                    <div class="article-container border">
                        <img class="rounded p-1 img-fluid" src="<?php echo (empty($article->image)) ? MEDIAURL . '/default.jpg' : MEDIAURL . '/' . $article->image; ?>" alt="<?php echo $article->name; ?>">
                        <a href="<?php echo URLROOT . '/news/show/' . $article->article_id . '-' . $article->name; ?>" class="article-title">
                            <h1 class="h6 my-2"><?php echo $article->name; ?></h1>
                        </a>
                        <p class="content text-secondary p-1 "><?php echo mb_substr(strip_tags($article->description), 0, 80); ?></p>
                        <a class="btn btn-outline-secondary btn-sm my-3 article-btn" href="<?php echo URLROOT . '/news/show/' . $article->article_id . '-' . $article->name; ?>">التفاصيل</a>
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