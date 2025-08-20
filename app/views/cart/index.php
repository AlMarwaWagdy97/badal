<?php
require APPROOT . '/app/views/inc/header.php';
?>
<div class="text-center py-5 mb-0 undermenu  bg-success text-light h3 bg-battern">
    <h3 class="py-4 mt-4"> سلة التبرع </h3>
</div>
<div class="container mt-5 py-5">
    <?php flash('msg'); ?>
    <div class=" text-right">
        <table class="table table-striped table-bordered table-sm rounded" id="cart">
            <thead class="btn-primary">
                <tr class="text-center">
                    <th class="w-50"> المشروع</th>
                    <th>القيمة</th>
                    <th>الكمية</th>
                    <th>النوع </th>
                    <th>حذف</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $total = 0;
                if (isset($_SESSION['cart'])) {
                    foreach ($_SESSION['cart']['items'] as $key => $value) {
                        echo "<tr>
                                    <td><a href='" . URLROOT . "/projects/show/ " . $value['project_id'] . "' >" . $value['name'] . "</a></td>
                                    <td>" . $value['amount'] . "</td>
                                    <td class='px-2'><form class='form-row' action='" . URLROOT . "/carts/setQuantity' method='post'>
                                        <input class='form-control form-control-sm col-lg-2 col-12 text-right' type='number' value='" . $value['quantity'] . "' name='quantity' >
                                        <button class='btn btn-sm  btn-dark mx-1' name='index' type='submit' value='" . $key . "'>تعديل </button></form>
                                    </td>
                                    <td>" . $value['donation_type'] . "</td>
                                    <td><a class='btn btn-danger btn-sm p-1' href='" . URLROOT . "/carts/remove/$key'>حذف</a></td>
                                </tr>";
                        $total += ($value['amount'] * $value['quantity']);
                    }
                } else {
                    echo '<div class="alert alert-primary text-center" role="alert"> لا يوجد منتجات في السلة  </div>';
                }
                ?>
            </tbody>
            <tfoot class="thead-light btn-sm">
                <tr>
                    <th>الاجمالي</th>
                    <th><?php echo $total; ?></th>
                    <th colspan="1"><?php if (isset($_SESSION['cart']['totalQty'])) echo $_SESSION['cart']['totalQty']; ?> </th>
                    <th></th>
                    <th><a class='btn btn-danger btn-sm' href="<?php echo URLROOT . '/carts/removeAll'; ?>">افراغ </a></th>
                </tr>
            </tfoot>
        </table>
        <!-- end of card table -->
    </div>
    <!-- payment methods -->
    <div class="pt-3">
        <div class="msg"></div>
        <form method="post" action="<?php root('projects'); ?>/cartRedirect" id="pay">
            <div class="">
                <div class="form-group row mt-4">
                    <label for="full-name" class="col-lg-3 col-form-label">الاسم بالكامل</label>
                    <div class="col-lg-8">
                        <input type="hidden" name="mobile_confirmed" value="no" id="mobile-confirmed">
                        <input type="hidden" name="total" value="<?php echo $total; ?>" id="total">
                        <input type="text" class="form-control" name="full_name" id="full-name" data-inputmask-regex="^[\u0621-\u064Aa-zA-Z\-_\s]+$" placeholder="الاسم بالكامل">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="mobile" class="col-lg-3 col-form-label">رقم الجوال</label>
                    <div class="input-group col-lg-8 mobile-validate">
                        <input dir="ltr" class="form-control" name="mobile" type="text" placeholder="0500000000" id="mobile" data-inputmask="'mask': '9999999999'">
                        <?php if ($data['settings']['site']->mobile_validation) { ?>
                            <div class="">
                                <a class="input-group-text activate" data-toggle="modal" data-target="#addcode-x">ارسال </a>
                            </div>
                        <?php } ?>
                    </div>
                </div>
                <div class="form-group row mt-4">
                    <label for="full-name" class="col-lg-3 col-form-label"> البريد الالكتروني </label>
                    <div class="col-lg-8">
                        <input type="text" class="form-control" name="email" placeholder="هام لاستقبال رسائل التأكيد">
                    </div>
                </div>

                <div class="form-group row my-4">
                    <label class="col-lg-3 col-form-label"> وسيلة الدفع</label>
                    <div class="mr-3 btn-group-toggle" data-toggle="buttons">
                        <?php
                        foreach ($data['payment_methods'] as $payment_method) {
                            if ($payment_method->payment_id == 10) {
                                $user_agent = $_SERVER['HTTP_USER_AGENT'];
                                if(stripos( $user_agent, 'Safari') !== false &&  !(stripos( $user_agent, 'Chrome') !== false) ){
                                    echo '<label class="btn btn-primary btn-sm mt-2 px-4 mx-1">
                                    <input type="radio" value ="' . $payment_method->payment_id . '" name="payment_method" required class="payment_method"> ' . $payment_method->title . '
                                  </label>';
                                }
                            }
                            else{
                                echo '<label class="btn btn-primary btn-sm mt-2 px-4 mx-1">
                                <input type="radio" value ="' . $payment_method->payment_id . '" name="payment_method" required class="payment_method"> ' . $payment_method->title . '
                              </label>';
                            }
                            
                        }
                        ?>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="" class="col-lg-3 col-form-label">كود التحقق </label>
                    <div class="input-group col-sm-8 ">
                        <div class="g-recaptcha" data-sitekey="6LcVHY8bAAAAAMlrDHrlL1G-22ySTHpAFRYDZlQy"></div>
                    </div>
                </div>
            </div>


            <div class="form-group text-center mt-5">
                <button class="btn btn-primary m-2 px-5" name="pay" type="submit">استمرار </button>
            </div>
        </form>
        <!-- code activation modal -->
        <div id="addcode" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="addcode-title" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button class="close m-0 p-0" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <h5 class="modal-title mx-auto" id="addcode-title">كود التفعيل</h5>
                    </div>
                    <div class="modal-body">
                        <form method="post" action="<?php root('projects'); ?>" id="active-code">
                            <div class="msg"></div>
                            <input class="form-control" name="code" type="text" placeholder="code" aria-label="code">
                            <input class="btn btn-success mt-2" name="verify" type="submit" value="تفعيل">
                            <input class="btn btn-danger mt-2 float-left" name="verify" type="submit" data-dismiss="modal" value="غلق">
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- end payment methods -->
    <div class="text-center mt-5">
        <a class="btn btn-success px-5 btn-lg" href="<?php echo URLROOT; ?>">العودة الي الرئيسية</a>
    </div>
</div>
<?php
$data['settings']['site']->footer_code .= '<script src="https://www.google.com/recaptcha/api.js" async defer></script>' . "\n\t";
require APPROOT . '/app/views/inc/footer.php'; ?>