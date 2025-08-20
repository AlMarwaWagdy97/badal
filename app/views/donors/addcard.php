<?php require APPROOT . '/app/views/inc/header.php'; ?>
<!-- Categories -->
<style>
  


</style>

<section id="donors" class="undermenu bg-light">
    <div class="container bg-white">
        <?php flash('msg'); ?>
        <div class="row mt-3">
            <div class="col-md-3">
                <?php require APPROOT . '/app/views/inc/donor-sidenavbar.php'; ?>
            </div>
            <div class="col-md-9">
                <div class="card mt-3 mb-3 card-info border-0 text-end" dir="rtl">
                    <div class="card-body">
                        <h5 class="text-right mb-3"> بطاقات الدفع </h5>
                        <form action="<?= URLROOT . '/donors/addcard'; ?>" method="post" enctype="multipart/form-data" accept-charset="utf-8">
                            <div class="card payment-card p-3">
                                <div class="row mt-3">
                                    <div class="col-md-6 col-lg-6">
                                        <div class="form-group mb-3">
                                            <label class="form-label" for="cardNumber">رقم البطاقة</label>
                                            <div class="card-number">
                                                <input type="text" name="number" value="<?= $data['number']??'';  ?>"  class="form-control only-number-with-paste  <?php if (!empty($data['number_error'])) echo 'is-invalid'; ?>" id="cardNumber" maxlength="16" autocomplete="cc-number" maxlength="19" placeholder="xxxx xxxx xxxx xxxx" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');">
                                            </div>
                                        </div>
                                        <div class="d-flex justify-content-between">
                                            <div class="form-group mb-3 expiry-dates me-2" id="expiration-date" role="group" aria-label="تاريخ الانتهاء">
                                                <label class="form-label">تاريخ الانتهاء</label>
                                                <div class="card-dates d-flex">
                                                    <input type="text" name="expired_month" value="<?= $data['expired_month']??''; ?>"  class="form-control only-number card-exp  <?php if (!empty($data['expired_month_error'])) echo 'is-invalid'; ?>" id="expMonth" placeholder="MM" maxlength="2" inputmode="numeric" pattern="[0-9]*" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');">
                                                    <input type="text" name="expired_year" value="<?= $data['expired_year']??''; ?>"  class="form-control only-number card-exp  <?php if (!empty($data['expired_year_error'])) echo 'is-invalid'; ?>" id="expYear" placeholder="YY" maxlength="2" inputmode="numeric" pattern="[0-9]*" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');">
                                                </div>
                                            </div>
                                            <div class="form-group mb-3 cvv">
                                                <label class="form-label" for="cvv">رمز الأمان - CVV</label>
                                                <input type="text" name="cvv" value="<?= $data['cvv']??''; ?>"  class="form-control only-number card-exp valid  <?php if (!empty($data['cvv_error'])) echo 'is-invalid'; ?>" id="cvv" placeholder="CVV" maxlength="3" inputmode="numeric" pattern="[0-9]*" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');">
                                            </div>
                                        </div>

                                        <div class="form-group mb-3">
                                            <label class="form-label" for="member">الاسم المسجل على البطاقة</label>
                                            <input type="text" name="name" value="<?=  $data['name']??'';  ?>"  class="form-control card-holder-name english-only error  <?php if (!empty($data['name_error'])) echo 'is-invalid'; ?>" data-space="false" id="member"  maxlength="50">
                                            <!-- <input type="checkbox" class="mt-4" id="default" name="default" checked value="1"> -->
                                            <!-- <label for="default"> تعين كبطاقه افتراضية</label> -->
                                        </div>
                                    </div>

                                    <div class="col-md-6 col-lg-6 card-image">
                                        <img src="<?php echo URLROOT; ?>/public/templates/namaa/images/payment-cards.png" class="w-100">
                                    </div>
                                </div>
                            </div>
                            <div class="submit mt-4 float-right">
                                <button type="submit" class="btn submit-button rounded-pill px-md-5"> حفظ </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- end Categories -->
<?php require APPROOT . '/app/views/inc/footer.php'; ?>