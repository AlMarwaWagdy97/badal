document.addEventListener("DOMContentLoaded", () => {
  if (window.ApplePaySession) {
    if (ApplePaySession.canMakePayments) {
      showApplePayButton();
    }
  }
});

function showApplePayButton() {
  HTMLCollection.prototype[Symbol.iterator] = Array.prototype[Symbol.iterator];
  const buttons = document.getElementsByClassName("apple-pay-button");
  for (let button of buttons) {
    button.className += " visible";
  }
}

/**
 * Apple Pay Logic
 * Our entry point for Apple Pay interactions.
 * Triggered when the Apple Pay button is pressed
 */
function applePayButtonClicked() {
  const paymentRequest = {
    countryCode: "US",
    currencyCode: "USD",
    shippingMethods: [
      {
        label: "Free Shipping",
        amount: "0.00",
        identifier: "free",
        detail: "Delivers in five business days",
      },
      {
        label: "Express Shipping",
        amount: "5.00",
        identifier: "express",
        detail: "Delivers in two business days",
      },
    ],

    lineItems: [
      {
        label: "Shipping",
        amount: "0.00",
      },
    ],

    total: {
      label: "Apple Pay Example",
      amount: "8.99",
    },

    supportedNetworks: ["amex", "discover", "masterCard", "visa"],
    merchantCapabilities: ["supports3DS"],

    requiredShippingContactFields: ["postalAddress", "email"],
  };

  const session = new ApplePaySession(1, paymentRequest);

  /**
   * Merchant Validation
   * We call our merchant session endpoint, passing the URL to use
   */
  session.onvalidatemerchant = (event) => {
    console.log("Validate merchant");
    const validationURL = event.validationURL;
    getApplePaySession(event.validationURL).then(function (response) {
      console.log(response);
      session.completeMerchantValidation(response);
    });
  };

  /**
   * Shipping Method Selection
   * If the user changes their chosen shipping method we need to recalculate
   * the total price. We can use the shipping method identifier to determine
   * which method was selected.
   */
  session.onshippingmethodselected = (event) => {
    const shippingCost =
      event.shippingMethod.identifier === "free" ? "0.00" : "5.00";
    const totalCost =
      event.shippingMethod.identifier === "free" ? "8.99" : "13.99";

    const lineItems = [
      {
        label: "Shipping",
        amount: shippingCost,
      },
    ];

    const total = {
      label: "Apple Pay Example",
      amount: totalCost,
    };

    session.completeShippingMethodSelection(
      ApplePaySession.STATUS_SUCCESS,
      total,
      lineItems
    );
  };

  /**
   * Payment Authorization
   * Here you receive the encrypted payment data. You would then send it
   * on to your payment provider for processing, and return an appropriate
   * status in session.completePayment()
   */
  session.onpaymentauthorized = (event) => {
    // Send payment for processing...
    const payment = event.payment;

    sendToLitle(payment);
    // ...return a status and redirect to a confirmation page
    session.completePayment(ApplePaySession.STATUS_SUCCESS);
  };

  // All our handlers are setup - start the Apple Pay payment
  session.begin();
}

/** support file */

function getApplePaySession(url) {
  return new Promise(function (resolve, reject) {
    var xhr = new XMLHttpRequest();
    xhr.open("POST", "/getApplePaySession");
    xhr.onload = function () {
      if (this.status >= 200 && this.status < 300) {
        resolve(JSON.parse(xhr.response));
      } else {
        reject({
          status: this.status,
          statusText: xhr.statusText,
        });
      }
    };
    xhr.onerror = function () {
      reject({
        status: this.status,
        statusText: xhr.statusText,
      });
    };
    xhr.setRequestHeader("Content-Type", "application/json");
    xhr.send(JSON.stringify({ url: url }));
  });
}

/** eprotictsupport file */

function setLitleResponseFields(response) {
  var regId = response.paypageRegistrationId;
  console.log("regId: " + regId);
  alert("regId: " + regId);

  sendToIP(regId);
}
function submitAfterLitle(response) {
  console.log("setLiteResponseFields response " + response);
  setLitleResponseFields(response);
}
function timeoutOnLitle() {
  alert(
    "We are experiencing technical difficulties. Please try again later or call 555-555-1212 (timeout)"
  );
}
function onErrorAfterLitle(response) {
  setLitleResponseFields(response);
  if (response.response == "871") {
    alert("Invalid card number. Check and retry. (Not Mod10)");
  } else if (response.response == "872") {
    alert("Invalid card number. Check and retry. (Too short)");
  } else if (response.response == "873") {
    alert("Invalid card number. Check and retry. (Too long)");
  } else if (response.response == "874") {
    alert("Invalid card number. Check and retry. (Not a number)");
  } else if (response.response == "875") {
    alert(
      "We are experiencing technical difficulties. Please try again later or call 555-555-1212"
    );
  } else if (response.response == "876") {
    alert("Invalid card number. Check and retry. (Failure from Server)");
  } else if (response.response == "881") {
    alert("Invalid card validation code. Check and retry. (Not a number)");
  } else if (response.response == "882") {
    alert("Invalid card validation code. Check and retry. (Too short)");
  } else if (response.response == "883") {
    alert("Invalid card validation code. Check and retry. (Too long)");
  } else if (response.response == "889") {
    alert(
      "We are experiencing technical difficulties. Please try again later or call 555-555-1212"
    );
  }
  return false;
}

function sendToLitle(payment) {
  console.log("sendToLitle hit");
  console.log(applePay);
  var litleRequest = {
    paypageId: "<REPLACE_ME>",
    reportGroup: "reportGroup",
    orderId: "orderId",
    id: "id",
    applepay: payment.token.paymentData,
    url: "https://request-prelive.np-securepaypage-litle.com",
  };
  console.log(litleRequest);
  var formFields = {
    paypageRegistrationId: document.createElement("input"),
  };
  console.log(formFields);
  var response = new LitlePayPage().sendToLitle(
    litleRequest,
    formFields,
    submitAfterLitle,
    onErrorAfterLitle,
    timeoutOnLitle,
    15000
  );
  return false;
}

function sendToIP(registrationId) {
  return new Promise(function (resolve, reject) {
    var xhr = new XMLHttpRequest();
    xhr.open("POST", "/makeVantivIPCall");
    xhr.onload = function () {
      if (this.status >= 200 && this.status < 300) {
        alert(xhr.response);
        window.location.href = "/success";
      } else {
        reject({
          status: this.status,
          statusText: xhr.statusText,
        });
      }
    };
    xhr.onerror = function () {
      reject({
        status: this.status,
        statusText: xhr.statusText,
      });
    };
    xhr.setRequestHeader("Content-Type", "application/json");
    xhr.send(
      JSON.stringify({ registrationId: registrationId, amount: "8.99" })
    );
  });
}
