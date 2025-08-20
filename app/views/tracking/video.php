<?php
require APPROOT . '/app/views/inc/header.php'; ?>

<section dir="ltr" class="eladha-tracking">
    <div class="eladha">
        <div class="container mb-3">
            <video width="100%" height="100%" controls autoplay="true">
                <source src="<?= URLROOT . '/media/files/eladha/' . @$data['url'] ?>" type="video/mp4">
            </video>
        </div>
    </div>
</section>


<?php
require APPROOT . '/app/views/inc/footer.php';
?>