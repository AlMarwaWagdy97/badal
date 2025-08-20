// loader
$(function () {
  setTimeout(function () {
    $(".preloader").addClass("compleate");
  }, 1000);
});
//marquee
!(function (l, e, m) {
  var n = "SimpleMarquee";
  function t(e, t) {
    (this.element = e),
      (this._name = n),
      (this._defaults = l.fn.SimpleMarquee.defaults),
      (this.settings = l.extend({}, this._defaults, t)),
      (this.marqueeSpawned = []),
      (this.marqueeHovered = !1),
      (this.documentHasFocus = !1),
      (this.counter = 0),
      (this.timeLeft = 0),
      (this.currentPos = 0),
      (this.distanceLeft = 0),
      (this.totalDistance = 0),
      (this.contentWidth = 0),
      (this.endPoint = 0),
      (this.duration = 0),
      (this.hovered = !1),
      (this.padding = 0),
      this.init();
  }
  function h(e) {
    (this.el = e),
      (this.counter = 0),
      (this.name = ""),
      (this.timeTop = 0),
      (this.currentPos = 0),
      (this.distanceTop = 0),
      (this.totalDistance = 0),
      (this.contentWidth = 0),
      (this.endPoint = 0),
      (this.duration = 0),
      (this.hovered = !1),
      (this.padding = 0);
  }
  l.extend(t.prototype, {
    init: function () {
      this.buildCache(), this.bindEvents();
      var e = this.settings;
      0 != l(e.marquee_class).width()
        ? void 0 !== l(e.marquee_class)
          ? void 0 !== l(e.container_class)
            ? 0 == e.sibling_class || void 0 !== l(e.sibling_class)
              ? (e.autostart && (this.documentHasFocus = !0),
                this.createMarquee())
              : console.error("FATAL: sibling class container class not valid")
            : console.error("FATAL: marquee container class not valid")
          : console.error("FATAL: marquee class not valid")
        : console.error(
          "FATAL: marquee css or children css not correct. Width is either set to 0 or the element is collapsing. Make sure overflow is set on the marquee, and the children are postitioned relatively"
        );
    },
    destroy: function () {
      this.unbindEvents(), this.$element.removeData();
    },
    buildCache: function () {
      this.$element = l(this.element);
    },
    bindEvents: function () {
      var t = this;
      l(e).on("focus", function () {
        for (var e in ((t.documentHasFocus = !0), t.marqueeSpawned))
          t.marqueeManager(t.marqueeSpawned[e]);
      }),
        l(e).on("blur", function () {
          for (var e in ((t.documentHasFocus = !1), t.marqueeSpawned))
            t.marqueeSpawned[e].el.clearQueue().stop(),
              (t.marqueeSpawned[e].hovered = !0);
        });
    },
    unbindEvents: function () {
      l(e).off("blur focus");
    },
    getPosition: function (e) {
      var t = this.settings;
      return (
        (this.currentPos = parseInt(l(e).css(t.direction))), this.currentPos
      );
    },
    createMarquee: function () {
      var t = this,
        e = t.settings,
        n = l(e.marquee_class).html(),
        a = l(e.container_class).width(),
        i = l(e.marquee_class).width(),
        s = 0;
      0 != e.sibling_class && (s = l(e.sibling_class).width());
      var r = Math.ceil(a / i);
      l(e.marquee_class).remove(), r <= 2 ? (r = 3) : r++;
      var o = -((i + e.padding) * r - a),
        u = a - o;
      0 !== e.velocity && (e.duration = u / e.velocity);
      for (var c = 0; c < r; c++) {
        var d = !1,
          d =
            1 == e.hover
              ? l('<div class="marquee-' + (c + 1) + '">' + n + "</div>")
                .mouseenter(function () {
                  if (1 == t.documentHasFocus && 0 == t.marqueeHovered)
                    for (var e in ((t.marqueeHovered = !0), t.marqueeSpawned))
                      t.marqueeSpawned[e].el.clearQueue().stop(),
                        (t.marqueeSpawned[e].hovered = !0);
                })
                .mouseleave(function () {
                  if (1 == t.documentHasFocus && 1 == t.marqueeHovered) {
                    for (var e in t.marqueeSpawned)
                      t.marqueeManager(t.marqueeSpawned[e]);
                    t.marqueeHovered = !1;
                  }
                })
              : l('<div class="marquee-' + (c + 1) + '">' + n + "</div>");
        (t.marqueeSpawned[c] = new h(d)),
          l(e.container_class).append(d),
          (t.marqueeSpawned[c].currentPos = s + i * c + e.padding * c),
          (t.marqueeSpawned[c].name = ".marquee-" + (c + 1)),
          (t.marqueeSpawned[c].totalDistance = u),
          (t.marqueeSpawned[c].containerWidth = a),
          (t.marqueeSpawned[c].contentWidth = i),
          (t.marqueeSpawned[c].endPoint = o),
          (t.marqueeSpawned[c].duration = e.duration),
          (t.marqueeSpawned[c].padding = e.padding),
          t.marqueeSpawned[c].el.css(
            e.direction,
            t.marqueeSpawned[c].currentPos + e.padding + "px"
          ),
          1 == t.documentHasFocus && t.marqueeManager(t.marqueeSpawned[c]);
      }
      m.hasFocus() ? (t.documentHasFocus = !0) : (t.documentHasFocus = !1);
    },
    marqueeManager: function (e) {
      var t = this,
        n = e.name,
        a = t.settings;
      0 == e.hovered
        ? 0 < e.counter
          ? ((e.timeLeft = e.duration),
            e.el.css(a.direction, e.containerWidth + "px"),
            (e.currentPos = e.containerWidth),
            (e.distanceLeft =
              e.totalDistance - (e.containerWidth - t.getPosition(n))))
          : (e.timeLeft =
            ((e.totalDistance - (e.containerWidth - t.getPosition(n))) /
              e.totalDistance) *
            e.duration)
        : ((e.hovered = !1),
          (e.currentPos = parseInt(e.el.css(a.direction))),
          (e.distanceLeft =
            e.totalDistance - (e.containerWidth - t.getPosition(n))),
          (e.timeLeft =
            ((e.totalDistance - (e.containerWidth - e.currentPos)) /
              e.totalDistance) *
            e.duration)),
        t.marqueeAnim(e);
    },
    marqueeAnim: function (e) {
      var t = this,
        n = t.settings;
      e.counter++,
        e.el
          .clearQueue()
          .animate(
            { [n.direction]: e.endPoint + "px" },
            e.timeLeft,
            "linear",
            function () {
              t.marqueeManager(e);
            }
          );
    },
    callback: function () {
      var e = this.settings.onComplete;
      "function" == typeof e && e.call(this.element);
    },
  }),
    (l.fn.SimpleMarquee = function (e) {
      return (
        this.each(function () {
          l.data(this, "plugin_" + n) ||
            l.data(this, "plugin_" + n, new t(this, e));
        }),
        this
      );
    }),
    (l.fn.SimpleMarquee.defaults = {
      autostart: !0,
      property: "value",
      onComplete: null,
      duration: 2e4,
      padding: 10,
      marquee_class: ".marquee",
      container_class: ".news-ticker",
      sibling_class: 0,
      hover: !0,
      velocity: 0,
      direction: "left",
    });
})(jQuery, window, document);

$(function () {
  let options = {
    autostart: true,
    property: 'value',
    onComplete: null,
    duration: 20000,
    padding: 10,
    marquee_class: '.marquee',
    container_class: '.news-ticker',
    sibling_class: 0,
    hover: true,
    velocity: 0.1,
    direction: 'right'
  }
  $('.news-ticker').SimpleMarquee(options);
});
//
//document lood
$(function () {
  // main menu
  // ------------------------------------------------------- //
  // Multi Level dropdowns
  // ------------------------------------------------------ //
  $("ul.dropdown-menu [data-toggle='dropdown']").on("click", function (event) {
    event.preventDefault();
    event.stopPropagation();
    $(this).siblings().toggleClass("show");
    if (!$(this).next().hasClass("show")) {
      $(this)
        .parents(".dropdown-menu")
        .first()
        .find(".show")
        .removeClass("show");
    }
    $(this)
      .parents("li.nav-item.dropdown.show")
      .on("hidden.bs.dropdown", function (e) {
        $(".dropdown-submenu .show").removeClass("show");
      });
  });

  //end menu
  // owl main slider
  $("#slider .owl-carousel").owlCarousel({
    items: 1,
    rtl: true,
    nav: true,
    loop: true,
    dots: false,
    navText: [
      "<i class='icofont-thin-right'></i>",
      "<i class='icofont-thin-left'></i>",
    ],
    autoplay: true,
    autoplayTimeout: 5000,
    autoplayHoverPause: true,
  });
  //acivate input mask
  $(":input").inputmask();
  //projects slider
  $("#projects .owl-carousel").owlCarousel({
    margin: 20,
    nav: true,
    // loop: true,
    rtl: true,
    dots: true,
    responsiveClass: true,
    autoplay: false,
    // autoplayTimeout: 5000,
    autoplayHoverPause: true,
    responsive: {
      0: {
        items: 1,
        dots: true,
        nav: true,
      },
      700: {
        items: 2,
        dots: true,
        nav: true,
      },
      1000: {
        items: 3,
        dots: true,
        nav: true,
      },
    },
  });

  //category slider
  $("#categories .owl-carousel").owlCarousel({
    items: 1,
    rtl: true,
    nav: true,
    loop: true,
    dots: true,
    margin: 0,
    responsive: {
      0: {
        items: 1,
        dots: true,
        nav: false,
      },
      700: {
        items: 2,
        nav: false,
        dots: true,
      },
      1000: {
        items: 4,
        nav: true,
        dots: true,
      },
    },
    autoplay: true,
    autoplayTimeout: 5000,
    autoplayHoverPause: true,
  });

  // popper tooltip
  $('[data-toggle="tooltip"]').tooltip();
}); //end document lood

// quick donation
$(".quick-donation .slide-icon").on("click", function () {
  $(this).parent(".quick-donation").toggleClass("show");
});

//wow animate
new WOW().init();

// add item to cart front page
$(".project .cart-add").on("click", function (event) {
  // Stop form from submitting normally
  event.preventDefault();
  // Get some values from the form:
  var $form = $(this).parent().parent().parent(),
    quantity = $form.find("input[name='quantity']").val(),
    donation_type = $form
      .find(".active")
      .find("input[name='donation_type']")
      .val(),
    amount = $form.find("input[name='amount']").val(),
    project_id = $form.find("input[name='project_id']").val(),
    store_id = $form.find("input[name='store_id']").val(),
    url = $form.find("input[name='url']").val(),
    formValidation = true;
    
    dataLayer.push({ ecommerce: null });
    dataLayer.push({
      event: "add_to_cart",
      ecommerce: {
          add_to_cart: [
              {
                  item_id: project_id,
                  item_name: donation_type,
                  currency: "SAR",
                  price: amount,
                  quantity: 1,
              },
          ]
      }
  });

  // validate cart requirments
  if ($.trim(quantity).length < 1 || quantity == 0) {
    // validat quantity
    // $(this).parent().parent().append(
    //   '<div class="alert alert-danger text-danger "> يجب ان تكون الكمية اكبر من صفر </div>'
    // );
    formValidation = false;
  }
  if ($.trim(amount).length < 1 || amount == 0) {
    // validat amount
    $(this)
      .parent()
      .parent()
      .append(
        '<div class="alert alert-danger text-danger text-center alert-dismissible" data-dismiss="alert"> يجب ان تكون قيمة التبرع اكبر من صفر </div>'
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
        $(".cart-total").attr("data-original-title", data.total + "منتج");
        $(".tooltip-inner").html(data.total + "منتج");
        $(".cart-total").tooltip("show");
      } else {
        // adding failed
        $("#alertModal").modal("show");
        $("#alertModal .modal-body").html(data.msg);
      }
    });
  }
});

// add item to cart front page
$(".project .cart-go").on("click", function (event) {
  // Stop form from submitting normally
  event.preventDefault();
  // Get some values from the form:
  var $form = $(this).parent().parent().parent(),
    quantity = $form.find("input[name='quantity']").val(),
    donation_type = $form
      .find(".active")
      .find("input[name='donation_type']")
      .val(),
    amount = $form.find("input[name='amount']").val(),
    project_id = $form.find("input[name='project_id']").val(),
    store_id = $form.find("input[name='store_id']").val(),
    url = $form.find("input[name='url']").val(),
    formValidation = true;
  // validate cart requirments
  if ($.trim(quantity).length < 1 || quantity == 0) {
    // validat quantity
    // $(this).parent().parent().append(
    //   '<div class="alert alert-danger text-danger "> يجب ان تكون الكمية اكبر من صفر </div>'
    // );
    formValidation = false;
  }
  if ($.trim(amount).length < 1 || amount == 0) {
    // validat amount
    $(this)
      .parent()
      .parent()
      .append(
        '<div class="alert alert-danger text-danger text-center alert-dismissible" data-dismiss="alert"> يجب ان تكون قيمة التبرع اكبر من صفر </div>'
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
        window.location.href = "/carts";
      } else {
        // adding failed
        $("#alertModal").modal("show");
        $("#alertModal .modal-body").html(data.msg);
      }
    });
  }
});
// if user select from units or fixed or share donation add the amount
$(".d-value").on("change", function () {
  let amt = $(this).parent().parent().next().children(".amt");
  if ($(this).hasClass("unit")) {
    //if the user chose another unit option
    amt.attr("readonly", false);
    amt.css({ background: "#fff", color: "#333" });
    amt.removeClass("bg-primary");
    amt.attr("type", "number");
  } else {
    amt.attr("readonly", true);
    amt.addClass("bg-primary");
  }
  var amount = $(this).attr("id");
  $(this).parent().parent().children(".quantity").val(1);
  $(this).parent().parent().next().children(".amt").val(amount);
});

// if quantity changed incriese the amount
$(".d-open").on("change", function () {
  let quantity = $(this).val();
  let selection = $(this).parent().children(".active").children().attr("id");
  let amount = $(this).parent().next().children(".amt");
  amount.val(quantity * selection);
});
//other units

// enable gift options
$(".gift-values").addClass("d-none");
$(".gift").change(function () {
  var gift = $(this).val();
  if (gift === "1") {
    $(".gift-values").removeClass("d-none");
    $(".gift-values input,.gift-values select").prop("required", true);
    $("#giver_email").prop("required", false);
  } else {
    $(".gift-values").addClass("d-none");
    $(".gift-values input,.gift-values select").prop("required", false);
  }
});
$("#giver_group").change(function () {
  var group = $(this).children(":selected").attr("id");
  $(".gift-values .group-img").addClass("d-none");
  $(".gift-values #" + group).removeClass("d-none");
});
//loading gift card into lightbox
$(document).on("click", '[alt="lightbox"]', function (event) {
  event.preventDefault();
  let imgSrc = event.target.currentSrc; //getting sorce
  $("#popup .modal-body").html("<img width='100%' src ='" + imgSrc + "' />");
  $("#popup").modal("show");
});

// --------------------------

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
  hideInstallment();
});
// if user write custom open donation
$(".amount").change(function () {
  if ($(".amount").val() > 0) {
    var total = $(".amount").val() * $("#quantity").val();
    $("#total").val(total);
  }
  hideInstallment();
});
// if user select from units or fixed or share donation
$(".donation-value").change(function () {
  var dType = $(this).parent().text();
  $(".donation_type_name").val($.trim(dType)); // add donation type to hidden feild
  $(".amount").val(this.value);
  var total = this.value * $("#quantity").val();
  $("#total").val(total);
  hideInstallment();
});
//hide installment if total amount less then 1000
hideInstallment();
function hideInstallment(){
  if($("#total").val() < 1000){
    $('#payment_4').hide();
  } else{
    $('#payment_4').show();
  }
}
// check activation code
$("#addToCart").on("click", function (event) {
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

// send activation code
$("#login").submit(function (event) {
  // Stop form from submitting normally
  event.preventDefault();
  var response = grecaptcha.getResponse();
  // validate mobile num
  if (!$("#mobile").inputmask("isComplete")) {
    $(".msg").html(
      '<div class="alert alert-danger text-danger"> من فضلك ادخل رقم الجوال بطريقة صحيحة </div>'
    );
  }
  else if (response.length == 0) {
    $(".msg").html(
      '<div class="alert alert-danger text-danger"> لا يمكنك ترك كود Captcha فارغًا </div>'
    );
  }
  else {
    var $form = $(this),
      term = $form.find("input[name='mobile']").val(),
      url = "../donors/checkExistDonor";
    // check if mobile is exist 
    $.post(url, {
      mobile: term,
    }).done(function (data) {
      if (data == "true") {
        $(".modal").modal("show");
        $(".msg").html("");
        //prosess with the request
        url = "../projects/getmobilecode";
        $.post(url, {
          name: term,
          time: url,
        }).done(function (data) {
          $(".msg").html(data);
        });
      }
      else {
        $(".msg").html(
          '<div class="alert alert-danger text-danger"> بيانات الدخول غير صحيحة   </div>'
        );
      }
    });

  }
});
// check activation code
$("#active-code").submit(function (event) {
  // Stop form from submitting normally
  event.preventDefault();
  // Get some values from elements on the page:
  var $form = $(this),
    term = $form.find("input[name='code']").val(),
    url = "../projects/validateMobile";
  var login = "login",
    mobile = $("#mobile").val();
  // prosess with the request
  $.post(url, {
    code: term,
    url: url,
    login: login,
    mobile: mobile,
  }).done(function (data) {
    var data = JSON.parse(data);
    if (data.status == "success") {
      // activation success
      $(".msg").html(data.msg);
      window.location.replace(data.redirect_url);
      // window.location.replace("../donors/");
    } else {
      // activation failed
      $(".msg").html(data.msg);
    }
  });
});

//news highlight
$(".news").mouseover(function () {
  let img = $(this).find("img").attr("src");
  let title = $(this).find("img").attr("alt");
  let url = $(this).find("a").attr("href");
  $(".main-news img").attr("src", img);
  $(".main-news .main-news-content .news-title").html(title);
  $(".main-news .main-news-url").attr("href", url);
});

// sticky menu
window.onscroll = function () {
  myFunction();
};

var header = document.getElementById("menu-bar");
var sticky = header.offsetTop;

function myFunction() {
  if (window.pageYOffset > sticky) {
    header.classList.add("sticky");
  } else {
    header.classList.remove("sticky");
  }
}



// send activation code for Register -----------------------------------------------------------
$("#register").submit(function (event) {
  // Stop form from submitting normally
  event.preventDefault();
  var response = grecaptcha.getResponse();
  if ($("#full_name").val() == "") {
    $(".msg").html(
      '<div class="alert alert-danger text-danger"> من فضلك ادخل الاسم بالكامل </div>'
    );
  }
  else if ($("#email").val() == "") {
    $(".msg").html(
      '<div class="alert alert-danger text-danger"> من فضلك ادخل البريد الإلكتروني </div>'
    );
  }
  // validate mobile num
  else if (!$("#mobile").inputmask("isComplete")) {
    $(".msg").html(
      '<div class="alert alert-danger text-danger"> من فضلك ادخل رقم الجوال بطريقة صحيحة </div>'
    );
  }
  else if (response.length == 0) {
    $(".msg").html(
      '<div class="alert alert-danger text-danger"> لا يمكنك ترك كود Captcha فارغًا </div>'
    );
  }
  else {
    var $form = $(this),
      term = $form.find("input[name='mobile']").val(),
      url = "../donors/checkExistDonor";
    // check if mobile is exist 
    $.post(url, {
      mobile: term,
    }).done(function (data) {
      if (data == "true") {
        $(".msg").html(
          '<div class="alert alert-danger text-danger"> البيانات المدخلة  مسجلة مسبقاً    </div>'
        );
      }
      else {
        $(".modal").modal("show");
        $(".msg").html("");
        //prosess with the request
        var url = "../projects/getmobilecode";
        $.post(url, {
          name: term,
          time: url,
        }).done(function (data) {
          $(".msg").html(data);
        });
      }
    });
  }
});

// check activation code
$("#active-code-register").submit(function (event) {
  // Stop form from submitting normally
  event.preventDefault();
  // Get some values from elements on the page:
  var $form = $(this),
    term = $form.find("input[name='code']").val(),
    full_name = $("#full_name").val(), email = $("#email").val(), mobile = $("#mobile").val(), identity = $("#identity").val();
  //prosess with the request
  url = $form.attr("action") + "/validatemobile";
  $.post(url,
    {
      code: term,
      url: url,
      full_name: full_name,
      email: email,
      mobile: mobile,
      identity: identity,
    }).done(function (data) {
      var data = JSON.parse(data);
      if (data.status == "success") {
        // activation success
        $(".msg").html(data.msg);
        window.location.replace("../donors");
      } else {
        // activation failed
        $(".msg").html(data.msg);
      }
    });
});



// send activation code for update mobile phone -----------------------------------------------------------
$("#editmobile").submit(function (event) {
  // Stop form from submitting normally
  event.preventDefault();
  var response = grecaptcha.getResponse();
  // validate mobile num
  if (!$("#mobile").inputmask("isComplete")) {
    $(".msg").html(
      '<div class="alert alert-danger text-danger"> من فضلك ادخل رقم الجوال بطريقة صحيحة </div>'
    );
  }
  else if (response.length == 0) {
    $(".msg").html(
      '<div class="alert alert-danger text-danger"> لا يمكنك ترك كود Captcha فارغًا </div>'
    );
  }
  else {
    var $form = $(this),
      term = $form.find("input[name='mobile']").val(),
      id = $form.find("input[name='donor_id']").val(),
      url = "../donors/checksamemobile";
    // check if mobile is exist 
    $.post(url, {
      mobile: term,
      donor_id: id,
    }).done(function (data) {
      if (data == "true") {
        $(".msg").html(
          '<div class="alert alert-danger text-danger"> يجب ادخال رقم جوال مختلف</div>'
        );
      }
      else {
        $(".modal").modal("show");
        $(".msg").html("");
        //prosess with the request
        var url = "../projects/getmobilecode";
        $.post(url, {
          name: term,
          time: url,
        }).done(function (data) {
          $(".msg").html(data);
        });
      }
    });
  }
});

// check activation code
$("#active-code-editmobile").submit(function (event) {
  // Stop form from submitting normally
  event.preventDefault();
  // Get some values from elements on the page:
  var $form = $(this),
    term = $form.find("input[name='code']").val(),
    url = "../donors/editmobilepost";
  var login = "login",
    mobile = $("#mobile").val();
  donor_id = $("#donor_id").val();
  // prosess with the request
  $.post(url, {
    code: term,
    url: url,
    login: login,
    mobile: mobile,
    donor_id: donor_id,
  }).done(function (data) {
    var data = JSON.parse(data);
    if (data.status == "success") {
      // activation success
      $(".msg").html(data.msg);
      window.location.replace("../donors/login");
    } else {
      // activation failed
      $(".msg").html(data.msg);
    }
  });
});


console.log("at the end it's still working");
