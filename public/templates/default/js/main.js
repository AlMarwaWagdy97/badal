// loader
$(window).on("load", function () {
  setTimeout(function () {
    $(".preloader").addClass("compleate");
  }, 200);
});
// owl carousel
$(document).ready(function () {
  $(".owl-carousel").owlCarousel({
    margin: 10,
    loop: true,
    responsiveClass: true,
    autoplay: true,
    responsive: {
      0: {
        items: 1,
        nav: true,
      },
      500: {
        items: 2,
        nav: true,
      },
      1000: {
        items: 3,
        nav: true,
      },
    },
  });
  new WOW().init();
});

//form mask and validation and mobile confirmation
var data = false;
// prevent form submition
$("#pay").submit(false);
//if mobile activation is required
if ($(".activate").length > 0) {
  // activating mobile
  // Attach a submit handler to the form
  $("#pay .activate").click(function (event) {
    //check mobile num compleation
    if ($("#mobile").inputmask("isComplete")) {
      //show modal
      $("#addcode").modal("show");
      // Stop form from submitting normally
      event.preventDefault();
      // Get some values from elements on the page
      var $form = $("#pay"),
        term = $form.find("input[name='mobile']").val(),
        url = $form.attr("action") + "/../getmobilecode";

      $.post(url, { name: term, time: url }).done(function (data) {
        $(".msg").html(data);
      });
    } else {
      $("#addcode").modal("hide");
      $(".msg").html(
        '<div class="alert alert-danger text-danger"> من فضلك ادخل رقم الجوال بطريقة صحيحة </div>'
      );
    }
  });

  // check activation code
  $("#active-code").submit(function (event) {
    // Stop form from submitting normally
    event.preventDefault();
    // Get some values from elements on the page:
    var $form = $(this),
      term = $form.find("input[name='code']").val(),
      url = $form.attr("action") + "/validatemobile";
    //prosess with the request
    $.post(url, { code: term, url: url }).done(function (data) {
      var data = JSON.parse(data);
      if (data.status == "success") {
        // activation success
        $(".msg").html(data.msg);
        $("#addcode").modal("hide");
        $("#mobile").prop("readonly", true);
        $("#mobile-confirmed").val("yes");
        $(".activate").hide();
        if (
          $("#mobile").inputmask("isComplete") &&
          $("#full-name").inputmask("isComplete")
        ) {
          $("#pay").unbind("submit");
        }
      } else {
        // activation failed
        $(".msg").html(data.msg);
      }
    });
  });
} else {
  data = true;
}

//
$("#pay").unbind("submit");
// input masking and form validation
$("#pay").submit(function (event) {
  var msg = "";
  var amount = $(".amount").val();

  //check if form complete
  if (
    $("#mobile").inputmask("isComplete") &&
    $("#full-name").inputmask("isComplete") &&
    data
  ) {
    $("#pay").unbind("submit");
  } else {
    event.preventDefault(); // stop form from submitting
    //validate full name
    if (!$("#full-name").inputmask("isComplete")) {
      msg +=
        '<div class="alert alert-danger text-danger"> من فضلك تأكد من ادخال الاسم بطريقة صحيحة </div>';
    }
    //validate mobile num
    if (!$("#mobile").inputmask("isComplete")) {
      msg +=
        '<div class="alert alert-danger text-danger"> من فضلك تأكد من ادخال رقم الجوال بطريقة صحيحة </div>';
    }
    if ($(".activate").length > 0) {
      if (!data) {
        msg +=
          '<div class="alert alert-danger text-danger"> من فضلك قم بتفعيل الجوال اولا </div>';
      }
    }
  }
  if (amount < 1) {
    event.preventDefault(); // stop form from submitting
    msg +=
      '<div class="alert alert-danger text-danger"> من فضلك تأكد من اختيار مبلغ التبرع </div>';
  }
  $(".msg").html(msg);
});

//submitting amount value
// if user change the quantity
$("#quantity").change(function () {
  if ($(".amount").val() > 0) {
    var total = $(".amount").val() * $("#quantity").val();
    $("#total").val(total);
  }
});
// if user write custom open donation
$(".amount").change(function () {
  if ($(".amount").val() > 0) {
    var total = $(".amount").val() * $("#quantity").val();
    $("#total").val(total);
  }
});
// if user select from units or fixed or share donation
$(".donation-value").change(function () {
  var dType = $(this).parent().text();
  $(".donation_type_name").val($.trim(dType)); // add donation type to hidden feild
  $(".amount").val(this.value);
  var total = this.value * $("#quantity").val();
  $("#total").val(total);
});

// project add to cart

// check activation code
$("#addToCart").click(function (event) {
  // Stop form from submitting normally
  event.preventDefault();
  //clear privios messages
  $(".quantity_error, .donation_type_error, .amount_error").html(" ");
  // Get some values from the form:
  var $form = $(this).parent().parent(),
    quantity = $form.find("input[name='quantity']").val(),
    donation_type = $form.find("input[class='donation_type_name']").val(),
    amount = $form.find("input[name='amount']").val(),
    project_id = $form.find("input[name='project_id']").val(),
    store_id = $form.find("input[name='store_id']").val(),
    url = $(this).attr("href"),
    formValidation = true;
  // validate cart requirments
  if ($.trim(quantity).length < 1 || quantity == 0) {
    // validat quantity
    $(".quantity_error").html(
      '<div class="alert alert-danger text-danger"> يجب ان تكون الكمية اكبر من صفر </div>'
    );
    formValidation = false;
  }
  if ($.trim(donation_type).length < 1 || donation_type == 0) {
    // validat donation_type
    $(".donation_type_error").html(
      '<div class="alert alert-danger text-danger"> يجب اختيار نوع التبرع </div>'
    );
    formValidation = false;
  }
  if ($.trim(amount).length < 1 || amount == 0) {
    // validat amount
    $(".amount_error").html(
      '<div class="alert alert-danger text-danger"> يجب ان تكون قيمة التبرع اكبر من صفر </div>'
    );
    formValidation = false;
  }
  if (formValidation == true) {
    //prosess with the request
    $.post(url, {
      donation_type: donation_type,
      amount: amount,
      project_id: project_id,
      store_id: store_id,
      quantity: quantity,
    }).done(function (data) {
      var data = JSON.parse(data);
      if (data.status == "success") {
        // adding success
        $("#alertModal").modal("show");
        $("#alertModal .modal-body").html(data.msg);
        $(".cart-num, .cart-total").html(data.total);
      } else {
        // adding failed
        $("#alertModal").modal("show");
        $("#alertModal .modal-body").html(data.msg);
      }
    });
  }
});


// check activation code
$(".product .card .cart-add").click(function (event) {
  // Stop form from submitting normally
  event.preventDefault();
  // Get some values from the form:
  var $form = $(this).parent().parent().parent(),
    quantity = $form.find("input[name='quantity']").val(),
    donation_type = $form.find(".active").find("input[name='donation_type']").val(),
    amount = $form.find("input[name='amount']").val(),
    project_id = $form.find("input[name='project_id']").val(),
    store_id = $form.find("input[name='store_id']").val(),
    url =  $form.find("input[name='url']").val(),
    formValidation = true;
  // validate cart requirments
  if ($.trim(quantity).length < 1 || quantity == 0) {
    // validat quantity
    alert(' يجب ان تكون الكمية اكبر من صفر ');
    formValidation = false;
  }
  if ($.trim(amount).length < 1 || amount == 0) {
    // validat amount
    alert('يجب ان تكون قيمة التبرع اكبر من صفر');
    formValidation = false;
  }
  if (formValidation == true) {
    //prosess with the request
    $.post(url, {
      donation_type: donation_type,
      amount: amount,
      project_id: project_id,
      store_id: store_id,
      quantity: quantity,
    }).done(function (data) {
      var data = JSON.parse(data);
      if (data.status == "success") {
        // adding success
        $("#alertModal").modal("show");
        $("#alertModal .modal-body").html(data.msg);
        $(".cart-num, .cart-total").html(data.total);
      } else {
        // adding failed
        $("#alertModal").modal("show");
        $("#alertModal .modal-body").html(data.msg);
      }
    });
  }
});