<?php require APPROOT . '/app/views/inc/header.php'; ?>
<?php flash('msg'); ?>
<div class="text-center py-5  bg-success text-light bg-battern">
    <h1 class="card-title h3"><?php echo $data['pageTitle']; ?></h1>
</div>
<div class="container-md text-right">
    <div class="row no-gutters border rounded">
        <div class="col-12 text-center">
            <img src="<?php echo (empty($data['article']->image)) ? MEDIAURL . '/default.jpg' : MEDIAURL . '/' . $data['article']->image; ?>" class="img-fluid" alt="<?php echo $data['article']->name; ?>">
        </div>
        <div class="col-12">
            <div class="card-body">
                <p class="card-text py-3"><?php echo $data['article']->content; ?></p>
            </div>
        </div>
    </div>
    <!--- Products Start --->
</div>
</div>
<?php require APPROOT . '/app/views/inc/footer.php'; ?>