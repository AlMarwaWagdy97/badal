<?php require APPROOT . '/app/views/inc/header.php'; ?>
<div class="text-center py-5 mb-0 undermenu  bg-success text-light h3 bg-battern">
    <h3 class="py-4 mt-4"> الخطوة الثانية </h3>
</div>
<div class="bg-light">
    <div class="container text-right py-5">
        <div class="row justify-content-md-center">
            <div class="col-lg-6 py-5 text-center">
                <img src="<?= URLROOT . '/media/files/puzzels/' . $data['puzzel']->image ?>" alt="" class="img-fluid p-5">
                <h4 class="h5 text-success">مبروك <?= $data['full_name'] ?> لقد قمت بأستكمال الصورة في <?= $data['time'] ?> ثانية </h4>
                <h2 class="p-3">للدخول في السحب</h2>
                <h3 class="mb-4">قم بعمل مشاركة للمسابقة</h3>
                <div class="row justify-content-center mb-5" id="shares">
                    <a class="nav-link" target="_blank" href="https://twitter.com/intent/tweet?url=<?= URLROOT . '/puzzels/show/' . $data['puzzel']->puzzel_id ?>&text=لقد قمت بأستكمال الصورة في <?= $data['time'] ?> ثانية ">
                        <i style="color: #208fee;" class="icofont-4x icofont-twitter"></i>
                    </a>
                    <a target="_blank" href="https://www.facebook.com/sharer/sharer.php?u=<?= URLROOT . '/puzzels/show/' . $data['puzzel']->puzzel_id ?>">
                        <i style="color: rgb(60, 90, 153);" class="icofont-4x icofont-facebook "></i>
                    </a>
                    <a target="_blank" href="https://api.whatsapp.com/send?text=<?= URLROOT . '/puzzels/show/' . $data['puzzel']->puzzel_id ?>">
                        <i class="icofont-4x icofont-whatsapp text-success"></i>
                    </a>
                </div>
                <a class="mt-5 btn px-5 btn-primary" href="<?= URLROOT; ?>"><i class=" icofont-home"></i> العودة الي الرئيسية</a>
            </div>
        </div>
    </div>
</div>
<?php
$data['settings']['site']->footer_code .= '
<script>
    $("#shares").on("click", function(){
        $.get( "' . URLROOT . '/puzzels/update/' . $data['player'] . '" );
    });
</script>' . "\n\t";
require APPROOT . '/app/views/inc/footer.php'; ?>