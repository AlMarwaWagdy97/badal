<?php require APPROOT . '/app/views/inc/header.php'; ?>
<div class="text-center py-5 mb-0 undermenu  bg-success text-light h3 bg-battern">
    <h3 class="py-4 mt-4"> <?= $data['volunteerpage']->title; ?> </h3>
</div>
<div class="bg-light">
    <div class="container text-right py-2">
        <?php flash('msg'); ?>
        <div class="row justify-content-md-center">
            <div class="col-lg-12 py-3">
                <?php if (@exist($data['volunteerpage']->image)) echo '<img src="' . MEDIAURL . '/' . $data['volunteerpage']->image . '" class="img-fluid">'; ?>
            </div>
            <div class="col-lg-12 py-3">
                <?php if (@exist($data['volunteerpage']->content)) echo $data['volunteerpage']->content; ?>
            </div>
 
        </div>
    </div>
</div>
<?php
$data['settings']['site']->footer_code .= '<script src="https://www.google.com/recaptcha/api.js" async defer></script>';
require APPROOT . '/app/views/inc/footer.php';
?>