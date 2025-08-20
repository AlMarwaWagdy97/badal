<?php require APPROOT . '/app/views/inc/header.php'; ?>
<?php flash('msg'); ?>
<div class="container-md px-0 undermenu text-right">
    <div class="row no-gutters border rounded">
        <div class="col-12">
            <img src="<?php echo (empty($data['article']->image)) ? MEDIAURL . '/default.jpg' : MEDIAURL . '/' . $data['article']->image; ?>" class="img-fluid" alt="<?php echo $data['article']->name; ?>">
        </div>
        <div class="col-12">
            <div class="card-body">
                <p class="float-left pt-2"><span class="card-text"><i class="icofont-ui-calendar"></i> <?php echo date('Dd M Y', $data['article']->create_date); ?></span></p>
                <h1 class="card-title h2"><i class="icofont-newspaper text-secondary"></i> <?php echo $data['article']->name; ?></h1>
                <div class="p-2"><?php echo $data['article']->content ?></div>
            </div>

        </div>
    </div>
    <!--- Products Start --->
</div>
</div>
<?php require APPROOT . '/app/views/inc/footer.php'; ?>