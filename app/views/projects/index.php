<?php require APPROOT . '/app/views/inc/header.php'; ?>
</div>
<div class="container">
    <div class="msg"><?php flash('msg'); ?></div>
    <!-- Categories -->
    <section id="categories">
        <div class="row m-3 justify-content-center ">
            <div class="col">
                <?php
                    pr($_POST);
                ?>
            </div>
        </div>

    </section>
    <!-- end Categories -->
    <?php require APPROOT . '/app/views/inc/footer.php'; ?>