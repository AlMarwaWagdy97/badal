<?php require APPROOT . '/app/views/inc/header.php'; ?>
<!-- Categories -->
<section id="donors" class="undermenu bg-light">
    <div class="container bg-white">
        <?php flash('msg'); ?>
        <div class="row mt-3">
            <div class="col-md-3">
                <?php require APPROOT . '/app/views/inc/donor-sidenavbar.php'; ?>
            </div>
            <div class="col-md-9">
                <div class="card mt-3 mb-3 card-info border-0 ">
                    <div class="card-body">
                        <h5 class="text-right mb-3"> تبرعاتك </h5>
                        <div class="row">
                            <div class="col-md-6 col-lg-6">
                                <div class="item-count wow fadeInLeft" data-wow-duration="1s" data-wow-delay="1.5s" style="visibility: visible; animation-duration: 1s; animation-delay: 1.5s; animation-name: fadeInLeft;">
                                    <h2 class="number"><?php echo $data['donor']->count ?? 0 ?> عملية</h2><span class="desc"> عدد عمليات التبرع</span>
                                    <div class="icon"><i class="icofont-hand-power"></i></div>
                                    <hr>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <h2 class="number"><?php echo $data['donor']->confirm_count ?? 0 ?> </h2><span class="desc"> التبرع المؤكدة</span>
                                        </div>
                                        <div class="col-md-6">
                                            <h2 class="number"><?php echo $data['donor']->pending_count ?? 0 ?> </h2><span class="desc">   التبرع المعلقة</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6 col-lg-6">
                                <div class="item-count wow fadeInLeft" data-wow-duration="1s" data-wow-delay="1.5s" style="visibility: visible; animation-duration: 1s; animation-delay: 1.5s; animation-name: fadeInLeft;">
                                    <h2 class="number"><?php echo $data['donor']->total ?? 0 ?>   <img src="<?php echo MEDIAURL . '/rayal.png'; ?>" width="20px"> </h2><span class="desc"> إجمالي مبلغ التبرع</span>
                                    <div class="icon"><i class="icofont-money"></i></div>
                                    <hr>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <h2 class="number"><?php echo $data['donor']->confirm_total ?? 0 ?></h2><span class="desc"> التبرع المؤكدة</span>
                                        </div>
                                        <div class="col-md-6">
                                            <h2 class="number"><?php echo $data['donor']->pending_total ?? 0 ?></h2><span class="desc">   التبرع المعلقة</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</section>
<!-- end Categories -->



<?php
    // Data to be pushed to the data layer
    $dataLayer = [
        'event' => 'user',
        'logged_in' => 'true',
        'email' => $data['donor']->email,
        'userId' => $data['donor']->donor_id,
        'created_at' => date("Y-m-d H:i:s"),
        'name' =>  $data['donor']->full_name,
    ];
?>

<script>
    if (window.dataLayer) {
        dataLayer.push(<?php echo json_encode($dataLayer); ?>);
        console.log(dataLayer);
    }
</script>

<?php require APPROOT . '/app/views/inc/footer.php'; ?>