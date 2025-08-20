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
                        <h5 class="text-right mb-3"> بطاقات الدفع </h5>

                        <div class="row">
                            <div class="cards container">
                                <div class="card-list">
                                    <div class="row mb-5">
                                        <?php
                                        if ($data['cards']) {
                                            foreach ($data['cards'] as $key => $card) {
                                        ?>
                                                <div class="col-lg-5 col-md-12 col-sm-12 mb-5">
                                                    <div class="card-start">
                                                        <div class="card-hover">
                                                            <div class="card card-active">
                                                                <?php if (@$card->default == 1) { ?>
                                                                    <div class="card-verified" style="background-image: url('<?php echo URLROOT; ?>/public/templates/namaa/images/check.png')"></div>
                                                                <?php } ?>
                                                                <div class="card-info">
                                                                    <div class="col-md-6">
                                                                        <div class="icon icon-visa card-info__logo" style="background-image: url('<?php echo URLROOT; ?>/public/templates/namaa/images/visa.png')"></div>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <!-- <p class="card-info__balance">Visa</p> -->
                                                                        <img src="<?php echo URLROOT; ?>/public/templates/namaa/images/card-code.png" width="50%" class="mb-4">
                                                                    </div>
                                                                </div>
                                                                <div class="card-numbers" dir="ltr">
                                                                    <div class="dots">
                                                                        <div class="dot"></div>
                                                                        <div class="dot"></div>
                                                                        <div class="dot"></div>
                                                                        <div class="dot"></div>
                                                                    </div>
                                                                    <div class="dots">
                                                                        <div class="dot"></div>
                                                                        <div class="dot"></div>
                                                                        <div class="dot"></div>
                                                                        <div class="dot"></div>
                                                                    </div>
                                                                    <div class="dots">
                                                                        <div class="dot"></div>
                                                                        <div class="dot"></div>
                                                                        <div class="dot"></div>
                                                                        <div class="dot"></div>
                                                                    </div>
                                                                    <div><?= substr(openssl_decrypt_card(@$card->number), -4) ?></div>
                                                                </div>
                                                                <div class="card-date">
                                                                    <p><?= base64_decode(@$card->name) ?></p>
                                                                    <p><?= decrypt(@$card->expired_year) ?> / <?= decrypt(@$card->expired_month) ?></p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="card-action">
                                                        <form action="<?php echo URLROOT . '/donors/cardactions'; ?>" method="post">
                                                            <input type="hidden" name="card_id" value="<?= $card->card_id ?>">
                                                            <input type="hidden" name="is_default" value="<?= $card->default ?>">
                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                    <!-- <?php if (@$card->default == 0) { ?>
                                                                        <button type="submit" name="action" value="default" onclick="return confirm('Are you sure?') ? true : false" class="btn btn-sm btn-primary" > تعين كافتراضية</button>
                                                                        <?php } ?> -->
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <button type="submit" name="action" value="delete" onclick="return confirm('Are you sure?') ? true : false" class="btn btn-sm btn-danger" > حذف </button>
                                                                </div>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                        <?php
                                            }
                                        }
                                        ?>
                                    </div>
                                </div>


                            </div>

                        </div>

                        <div class="row">
                            <a class=" btn btn-primary rounded-pill px-md-5" href="<?= URLROOT ?>/donors/addcard"><i class="icofont-plus me-2" aria-hidden="true"></i>إضافة بطاقة جديدة</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</section>
<!-- end Categories -->
<?php require APPROOT . '/app/views/inc/footer.php'; ?>