<?php require APPROOT . '/app/views/inc/header.php'; ?>
<div class="container">
    <!-- Categories -->
    <section id="categories">
        <div class="row m-3 justify-content-center ">
            <h2 class="text-center col-12"> <img src="<?php echo URLROOT; ?>/templates/default/images/namaa-icon.png" alt="Smiley face" class="ml-2">الحسابات البنكية</h2>
            <div class="col-12 card">
                <label class="control-label h4 pt-2">الحسابات البنكية : </label>
                <table class="table table-striped jambo_table text-center table-responsive d-lg-table">
                    <thead>
                        <tr class="headings  text-center">
                            <th class="">اسم البنك </th>
                            <th class="">رقم الحساب </th>
                            <th class="">IBAN </th>
                            <th class="">رابط البنك </th>
                        </tr>
                    </thead>
                    <tbody id="items">
                        <?php
                        $meta = json_decode($data['payment_method']->meta, true);
                        if (!empty($meta)) {
                            $x = 1;
                            foreach ($meta as $bank) {
                                echo '<tr class="">
                                        <td>' . $bank['bankname'] . '</td>
                                        <td>' . $bank['account_type'] . '</td>
                                        <td>' . $bank['iban'] . '</td>
                                        <td><a href="' . $bank['url'] . '" rel="no-fllow" target="_blank" >ذهاب</a></td>
                                    </tr>';
                                $x++;
                            }
                        }
                        ?>
                    </tbody>
                </table>
                <?php if ($data['hash']) : flash('msg') ?>
                    <h1 class="h3 text-center">ارفاق صورة التحويل</h1>
                    <form action="<?php echo URLROOT . '/projects/banktransfer/' . $data['hash']->hash; ?>" method="post" enctype="multipart/form-data" accept-charset="utf-8">
                        <div class="form-group <?php echo (!empty($data['payment_key_error'])) ? 'has-error' : ''; ?>">
                            <label class="control-label" for="payment_key"> اختار البنك المحول اليه : </label>
                            <div class="has-feedback ">
                                <select class="form-control" name="payment_key" id="payment_key">
                                    <option value=""></option>
                                    <?php
                                    foreach ($meta as $bank) {
                                        echo '<option value="' . $bank['payment_key'] . '">' . $bank['bankname'] . '</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="text-danger"><?php echo $data['payment_key_error']; ?></div>
                        </div>
                        <div class="form-group <?php echo (!empty($data['image_error'])) ? 'has-error' : ''; ?>">
                            <label class="control-label" for="imageUpload">صورة الصفحة : </label>
                            <div class="has-feedback input-group">
                                <span class="input-group-btn">
                                    <span class="btn btn-dark" onclick="$(this).parent().find('input[type=file]').click();">اختار الملف</span>
                                    <input name="image" value="<?php echo ($data['image']); ?>" onchange="$(this).parent().parent().find('.form-control').html($(this).val().split(/[\\|/]/).pop());" style="display: none;" type="file">
                                </span>
                                <span class="form-control"><small><?php echo empty($data['image']) ? ' قم بأختيار صورة مناسبةاو ملف PDF' : $data['image']; ?></small></span>
                            </div>
                            <div class="text-danger"><?php echo $data['image_error']; ?></div>
                        </div>
                        <div class="text-center m-5">
                            <button type="submit" name="submit" class="btn btn-success">أضف <i class="fa fa-save"> </i></button>
                        </div>
                    </form>
                <?php endif; ?>
            </div>
        </div>
    </section>
    <!-- end Categories -->
</div>
    <?php require APPROOT . '/app/views/inc/footer.php'; ?>