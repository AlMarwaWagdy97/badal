<?php require APPROOT . '/app/views/inc/header.php'; ?>
<div class="text-center py-5 mb-0 undermenu  bg-success text-light h3 bg-battern">
    <h3 class="py-4 mt-4"> <?= $data['pageTitle']; ?> </h3>
</div>
<div class="bg-light">
    <div class="container text-right py-5">
        <div class="row justify-content-md-center">
            <div class="col-lg-6 py-5 text-center">
                <img src="<?= MEDIAURL ?>/logo.png" alt="" class="img-fluid p-5">
                <?php flash('msg'); ?>
                <div class="col-lg-12 col-sm-12 py-2">
                    <h2 class="p-3">للحصول علي ساعات التطوع</h2>
                    <h3 class="mb-4">قم بعمل مشاركة </h3>
                    <div class="row justify-content-center mb-5">
                        <a class="nav-link" target="_blank" id="instagram" href="https://www.instagram.com/?url=<?= URLROOT . "/volunteering/sharing/" . $data['id']; ?>" >
                            <i style="color: rgb(253 105 0);" class="icofont-4x icofont-instagram"></i>
                        </a>
                        <a class="nav-link" id="twitter" target="_blank" href="https://twitter.com/intent/tweet?url=<?= URLROOT . "/volunteering/sharing/" . $data['id']; ?>">
                            <i style="color: #208fee" class="icofont-4x icofont-twitter"></i>
                        </a>
                        <a class="nav-link" target="_blank" id="facebook" href="https://www.facebook.com/sharer/sharer.php?u=<?= URLROOT . "/volunteering/sharing/" . $data['id']; ?>">
                            <i style="color: rgb(60, 90, 153);" class="icofont-4x icofont-facebook "></i>
                        </a>
                        <a class="nav-link" target="_blank" id="whatsapp" href="https://api.whatsapp.com/send?text=<?= URLROOT . "/volunteering/sharing/" . $data['id']; ?>">
                            <i class="icofont-4x icofont-whatsapp text-success"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php
    $data['settings']['site']->footer_code .= '
<script>
    $("#twitter").on("click", function(){
        $.get( "' . URLROOT . '/volunteering/share/' . $data['id'] . '/twitter" );
    });
    $("#facebook").on("click", function(){
        $.get( "' . URLROOT . '/volunteering/share/' . $data['id'] . '/facebook" );
    });
    $("#whatsapp").on("click", function(){
        $.get( "' . URLROOT . '/volunteering/share/' . $data['id'] . '/whatsapp" );
    });
    $("#instagram").on("click", function(){
        $.get( "' . URLROOT . '/volunteering/share/' . $data['id'] . '/instagram" );
    });
</script>' . "\n\t";
    require APPROOT . '/app/views/inc/footer.php'; ?>