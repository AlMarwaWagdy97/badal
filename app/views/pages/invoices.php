<!DOCTYPE html>
<html lang="ar">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta http-equiv="X-UA-Compatible" content="ie=edge" />
  <title> جمعية نماء الأهلية </title>
  <meta name="keywords" content />
  <meta name="title" content />
  <meta name="description" content />
  <meta name="author" content="holol" />

  <!-- Open Graph / Facebook -->
  <meta property="og:type" content="website" />
  <meta property="og:url" content />
  <meta property="og:title" content />
  <meta property="og:description" content=" " />
  <meta property="og:image" content />
  <!-- Twitter -->
  <meta property="twitter:card" content="summary_large_image" />
  <meta property="twitter:url" content />
  <meta property="twitter:title" content />
  <meta property="twitter:description" content=" " />
  <meta property="twitter:image" content />

  <!-- App Icons -->
  <link rel="shortcut icon" href="<?php echo URLROOT; ?>/templates/namaa/invoices/images/favicon.ico" />
  <!-- bootstrap -->
  <link rel="stylesheet" href="<?php echo URLROOT; ?>/templates/namaa/invoices/css/bootstrap.min.css" />
  <!-- Fonts -->
  <link rel="stylesheet" href="<?php echo URLROOT; ?>/templates/namaa/invoices/fonts/icofont/icofont.min.css" />

  <!-- Custom styles -->
  <link rel="stylesheet" href="<?php echo URLROOT; ?>/templates/namaa/invoices/css/style.css" />
</head>

<body dir="rtl">

  <style>
    .img-div {
      background-image: url("asset/images/checkout/0.jpg");
      /* Replace 'pallon.jpg' with your image path */
      background-size: cover;
      padding: 20px;
    }

    .dashed-border {
      border: 2px dashed;
      border-radius: 10px;
    }

    hr {
      height: 5px;
      opacity: 1;
    }

    .usernameFlied {
      background: transparent;
    }

    .green {
      position: relative;
      width: 80%;
    }

    .green input {
      width: 100%;
    }

    .user-info .UserName {
      margin-top: 1rem !important;
    }

    @media (max-width: 991.98px) {
      .UserName input {
        width: 100%;
        background-color: rgba(110, 165, 112, 0.5);
      }

      .ValueOfDontaion input {
        width: 100%;
        background-color: rgba(43, 152, 212, 0.5);
      }

      .user-info .UserName {
        margin-top: 0.3rem !important;
      }
    }

    @media (min-width: 992px) {
      .UserName input {
        width: 75%;
        background-color: rgba(110, 165, 112, 0.5);
      }

      .ValueOfDontaion input {
        width: 75%;
        background-color: rgba(43, 152, 212, 0.5);
      }
    }

    .DateOfDonation input {
      background-color: rgba(235, 150, 81, 0.5);
    }

    .Number input {
      background-color: rgba(108, 117, 125, 0.5);
    }

    .x {
      height: 5px;
    }

    .projectDonation {
      background-color: rgba(108, 117, 125, 0.3);
    }

    .copyrght {
      padding: 10px;
    }

    .y {
      height: 5px !important;
      border: none;
      background: linear-gradient(to left,
          var(--primary-color) 25%,
          var(--secound-color) 25%);
      background-size: 100% 100%;
      background-repeat: no-repeat;
    }

    .info {
      padding: 10px;
    }

    .print-button {
      font-family: 'cairo', sans-serif;
      padding: 5px 15px;
    }
  </style>
  <!--checkout-->
  <div class="checkout">
    <div class="container">
      <div class="row img-div justify-content-center align-content-center" style="background-image: url(<?php echo URLROOT; ?>/templates/namaa/invoices/images/background.jpg);">

        <div class="check row  dashed-border border-primary p-md-5 ps-0 " dir="rtl">
          <div class="col-12 logo d-flex justify-content-center align-items-center ">
            <h3 class="text-dark mx-3 mx-md-0">إيصال استلام </h3>
            <a href="<?php echo URLROOT; ?>" class="ms-4 mx-md-auto">
              <img src="<?php echo URLROOT; ?>/templates/namaa/invoices/images/logo.png" class="ms-4 mx-md-auto" alt="namaa-icon" />
            </a>
          </div>

          <hr class="bg-primary mt-2" />

          <div class=" donation-info col-12 row justify-content-center align-content-center mt-2 ">

            <div class="user-info col-lg-6 col-12 col-md-6 col-sm-6 row justify-content-center align-content-center text-center ">
              <div class="col-12 UserName row justify-content-center align-content-center justify-content-center align-items-center">
                <label for="" class="col-lg-3 col-12 text-dark fs-5">اسم طالب الخدمة</label>
                <input type="text" value="<?= $data['order']->donor_name ?>" class="col-md-9  col-12 usernameFlied" disabled />
              </div>
              <div class="col-12 ValueOfDontaion row  justify-content-center align-items-center">
                <label for="" class=" col-lg-3 col-12 text-dark fs-5 "> إجمالي قيمة الطلب </label>
                <input type="text" value="<?= $data['order']->total ?>" class="col-md-9 col-12 usernameFlied " disabled style="width: 60%" />
                <img src="<?php echo MEDIAURL . '/rayal.png'; ?>" class="col-md-1" style="width: 50px; height: 20px;">
              </div>
              <div class="DateOfDonation col-12 rowjustify-content-center align-items-center">
                <label for="" class="col-lg-3 col-12 text-dark fs-5"> تاريخ الطلب </label>
                <input type="text" value="<?php echo date('d-m-y', $data['order']->create_date) ?>" class="col-lg-5 col-12 usernameFlied ms-lg-0 mb-3 mb-md-0" />
                <input type="text" value="<?php echo date('H:i:s', $data['order']->create_date) ?>" class="col-lg-3 col-12 usernameFlied me-lg-3" disabled />
              </div>
              <div class="Number col-12 row my-3 justify-content-center align-items-center">
                <label for="" class="col-lg-3 col-12 text-dark fs-5 ">رقم العملية </label>
                <input type="text" value="#<?= $data['order']->order_identifier ?>" class="col-lg-9 col-12 usernameFlied" disabled />
              </div>

            </div>
            <div class="col-lg-6 col-12 col-md-6 col-sm-6  mb-3 mb-md-0 mx-auto  text-center justify-content-center projectDonation">
              <div class="row">
                <div class="col-6">
                  <h2 class="mt-5 text-dark"> اسم المشروع </h2>
                </div>
                <div class="col-6">
                  <h2 class="mt-5 text-dark"> قيمه المبلغ </h2>
                </div>
              </div>
              <hr class="x text-dark">
              <?php if ($data['donations'] != null) {
                foreach ($data['donations'] as $donation) {
              ?>
                  <div class="row">
                    <div class="col-6">
                      <p class="text-dark"> <?= $donation->project ?> </p>
                    </div>
                    <div class="col-6">
                      <p class="text-dark"> <?= $donation->total ?> </p>
                    </div>
                  </div>
              <?php
                }
              }
              ?>
            </div>
          </div>
        </div>


        <div class="copyright col-12 row mt-5 justify-content-between">
          <h6 class="col-6 text-start text-dark" dir="rtl">هذا الإیصال إلكتروني لا یحتاج إلى ختم أو توقیع</h6>
          <h6 class="col-6 text-end text-dark"><span> &copy;</span>
            جميع الحقوق محفوظة لجمعية نماء الأهلية </h6>
        </div>
        <hr class="y mt-2">
        <div class=" info col-12 justify-content-center">
          <p class="mx-auto text-center fs-5" dir="rtl">
            الإدراة العامة : جدة - حي الروضة - شارع الأمير محمد بن عبدالعزيز(التحلية سابقا)- هاتف 0126617222 -0126617111
            <br>ص.ب 14488 - جدة 21434 - يمكنك التعرف على مشاريعنا من خلال موقعنا <a href="<?php echo URLROOT; ?>"> namaa.sa </a>
          </p>
        </div>

      </div>
    </div>
  </div>
  <div class="text-center">
    <button onclick="window.print();" target="_blank" class="mb-3 btn btn-primary print-button hidePrint noPrint"><img src="<?php echo URLROOT; ?>/templates/namaa/invoices/images/download.svg" alt="print">
      &nbsp;طباعة الايصال</button>
  </div>
  </div>
  <!--checkout-->




  <!-- JS assets -->
</body>

</html>