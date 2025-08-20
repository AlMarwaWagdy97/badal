<?php require APPROOT . '/app/views/inc/header.php';
// update these with the real location of your two .pem files. keep them above/outside your webroot folder
define('PRODUCTION_CERTIFICATE_KEY', APPROOT . '/helpers/certificate/namaa1.key.pem');
define('PRODUCTION_CERTIFICATE_PATH',  APPROOT . '/helpers/certificate/namaa1.crt.pem');
// This is the password you were asked to create in terminal when you extracted ApplePay.key.pem
define('PRODUCTION_CERTIFICATE_KEY_PASS', '1234Five');

define('PRODUCTION_MERCHANTIDENTIFIER', openssl_x509_parse(file_get_contents(PRODUCTION_CERTIFICATE_PATH))['subject']['UID']); //if you have a recent version of PHP, you can leave this line as-is. http://uk.php.net/openssl_x509_parse will parse your certificate and retrieve the relevant line of text from it e.g. merchant.com.name, merchant.com.mydomain or merchant.com.mydomain.shop
// if the above line isn't working for you for some reason, comment it out and uncomment the next line instead, entering in your merchant identifier you created in your apple developer account
// define('PRODUCTION_MERCHANTIDENTIFIER', 'merchant.com.name');
define('PRODUCTION_DOMAINNAME', $_SERVER["HTTP_HOST"]);
//you can leave this line as-is too, it will take the domain from the server you run it on e.g. shop.mydomain.com or mydomain.com
// if the line above isn't working for you, replace it with the one below, updating it for your own domain name
// define('PRODUCTION_DOMAINNAME', 'mydomain.com');
define('PRODUCTION_CURRENCYCODE', 'SAR');    // https://en.wikipedia.org/wiki/ISO_4217
define('PRODUCTION_COUNTRYCODE', 'SA');        // https://en.wikipedia.org/wiki/ISO_3166-1_alpha-2
define('PRODUCTION_DISPLAYNAME', 'Namaa');
define('DEBUG', 'false');

?>
    <div class="container">
        <!-- Categories -->
        <section id="categories">
            <div class="row m-3 justify-content-center ">
                <h2 class="text-center col-12"> <img src="<?php echo URLROOT; ?>/templates/default/images/namaa-icon.png" alt="Smiley face" class="ml-2">ApplePay</h2>
                <div class="col-12 card">
                    <div class="text-center mt-5 pt-5">
                        <input hidden type="number" id="amount" name="amount" value="<?= $data['order']->total ?>">
                    مبلغ التبرع : <?= $data['order']->total ?>
                        <button type="button" id="applePay"></button>
                        <p style="display:none" id="got_notactive">ApplePay is possible on this browser, but not currently activated.</p>
                        <p style="display:none" id="notgot">ApplePay is not available on this browser</p>
                        <p style="display:none" id="success">Transaction completed, thanks. <a href="<?= $_SERVER["SCRIPT_URL"] ?>">reset</a></p>
                        <p style="display:none" id="failed">Transaction failed</p>
                    </div>
                </div>
            </div>
        </section>
        <!-- end Categories -->
    </div>
    <script>
        /**applepay js */
        var debug = true;
        if (window.ApplePaySession) {
            var merchantIdentifier = '<?= PRODUCTION_MERCHANTIDENTIFIER ?>';
            var promise = ApplePaySession.canMakePaymentsWithActiveCard(merchantIdentifier);
            promise.then(function(canMakePayments) {
                if (canMakePayments) {
                    document.getElementById("applePay").style.display = "block";
                    logit('hi, I can do ApplePay');
                } else {
                    document.getElementById("got_notactive").style.display = "block";
                    logit('ApplePay is possible on this browser, but not currently activated.');
                }
            });
        } else {
            logit('ApplePay is not available on this browser');
            document.getElementById("notgot").style.display = "block";
        }
        document.getElementById("applePay").onclick = function(evt) {
            var totalAmount = $('#amount').val();
            $('#success').html('Transaction completed with SR ' + totalAmount + ', thanks.');

            dataLayer.push({
                event: "purchase",
                ecommerce: {
                    currency: "SAR",
                    value: totalAmount,
                    paymentMethod: 'ApplePay',
                }
            });

            var shippingOption = "";
            var subTotalDescr = "Test Goodies";
            var paymentRequest = {
                currencyCode: '<?= PRODUCTION_CURRENCYCODE ?>',
                countryCode: '<?= PRODUCTION_COUNTRYCODE ?>',
                total: {
                    label: '<?= PRODUCTION_DISPLAYNAME ?>',
                    amount: totalAmount
                },
                supportedNetworks: ['masterCard', 'visa', 'mada'],
                merchantCapabilities: ['supports3DS']
            };
            var session = new ApplePaySession(1, paymentRequest);
            // Merchant Validation
            session.onvalidatemerchant = function(event) {
                logit(event);
                var promise = performValidation(event.validationURL);
                promise.then(function(merchantSession) {
                    session.completeMerchantValidation(merchantSession);
                });
            }

            function performValidation(valURL) {
                return new Promise(function(resolve, reject) {
                    var xhr = new XMLHttpRequest();
                    xhr.onload = function() {
                        var data = JSON.parse(this.responseText);
                        logit(data);
                        resolve(data);
                    };
                    xhr.onerror = reject;
                    xhr.open('GET', '<?= URLROOT ?>/public/payfort10/apple_pay_comm.php?u=' + valURL);
                    xhr.send();
                });
            }
            session.onshippingcontactselected = function(event) {
                logit('starting session.onshippingcontactselected');
                logit('NB: At this stage, apple only reveals the Country, Locality and 4 characters of the PostCode to protect the privacy of what is only a *prospective* customer at this point. This is enough for you to determine shipping costs, but not the full address of the customer.');
                logit(event);
                var status = ApplePaySession.STATUS_SUCCESS;
                var newTotal = {
                    type: 'final',
                    label: '<?= PRODUCTION_DISPLAYNAME ?>',
                    amount: totalAmount
                };
                var newLineItems = [{
                    type: 'final',
                    label: subTotalDescr,
                    amount: totalAmount
                }];
                session.completeShippingContactSelection(status);
            }
            session.onshippingmethodselected = function(event) {
                logit('starting session.onshippingmethodselected');
                logit(event);
                var status = ApplePaySession.STATUS_SUCCESS;
                var newTotal = {
                    type: 'final',
                    label: '<?= PRODUCTION_DISPLAYNAME ?>',
                    amount: totalAmount
                };
                var newLineItems = [{
                    type: 'final',
                    label: subTotalDescr,
                    amount: totalAmount
                }];
                session.completeShippingMethodSelection(status, newTotal, newLineItems);
            }
            session.onpaymentmethodselected = function(event) {
                logit('starting session.onpaymentmethodselected');
                logit(event);
                var newTotal = {
                    type: 'final',
                    label: '<?= PRODUCTION_DISPLAYNAME ?>',
                    amount: totalAmount
                };
                var newLineItems = [{
                    type: 'final',
                    label: subTotalDescr,
                    amount: totalAmount
                }];
                session.completePaymentMethodSelection(newTotal, newLineItems);
            }
            session.onpaymentauthorized = function(event) {
                logit('starting session.onpaymentauthorized');
                logit('NB: This is the first stage when you get the *full shipping address* of the customer, in the event.payment.shippingContact object');
                logit(event);
                var promise = sendPaymentToken(event.payment.token);
                promise.then(function(success) {
                    var status;
                    console.log(success)
                    if (success) {
                        status = ApplePaySession.STATUS_SUCCESS;
                        document.getElementById("applePay").style.display = "none";
                        session.completePayment(status);
                        document.getElementById("success").style.display = "block";
                    } else {
                        status = ApplePaySession.STATUS_FAILURE;
                        session.completePayment(status);
                        document.getElementById("failed").style.display = "block";
                    }
                });
            }

            function sendPaymentToken(paymentToken) {
                return new Promise(function(resolve, reject) {
                    logit('starting function sendPaymentToken()');
                    logit(paymentToken);


                    $.ajax({
                        type: 'POST',
                        url: '<?= URLROOT ?>/applepay/payfort',
                        data: {
                            order_id: <?= $data['order']->order_id ?>,
                            apple_data: paymentToken.paymentData.data,
                            apple_signature: paymentToken.paymentData.signature,
                            apple_transactionId: paymentToken.paymentData.header.transactionId,
                            apple_ephemeralPublicKey: paymentToken.paymentData.header.ephemeralPublicKey,
                            apple_publicKeyHash: paymentToken.paymentData.header.publicKeyHash,
                            apple_displayName: paymentToken.paymentMethod.displayName,
                            apple_network: paymentToken.paymentMethod.network,
                            apple_type: paymentToken.paymentMethod.type,
                            amount: totalAmount
                        },
                        dataType: "JSON",
                        success: function(data) {
                            var parsed_json = JSON.parse(data);
                            console.log("PayFort response status:", parsed_json.status);

                            var status = parsed_json.status;
                            if (status == 14) {
                                resolve(true);
                            } else {
                                resolve(false);
                            }

                        },
                        error: function (xhr) {
                            console.error("AJAX failed", xhr);
                            resolve(false);
                        }
                    });


                    logit("this is where you would pass the payment token to your third-party payment provider to use the token to charge the card. Only if your provider tells you the payment was successful should you return a resolve(true) here. Otherwise reject;");
                    logit("defaulting to resolve(true) here, just to show what a successfully completed transaction flow looks like");

                });
            }
            session.oncancel = function(event) {
                logit('starting session.cancel');
                logit(event);
            }
            session.begin();
        };

        function logit(data) {
            if (debug == true) {
                console.log(data);
            }
        };
        /**end of applepay */
    </script>


    <script>
        <?php if (isset($data['order']) && is_object($data['order']) && isset($data['order']->total) && $data['order']->total > 0 && isset($data['order']->order_id)) : ?>
            window.dataLayer = window.dataLayer || [];
            dataLayer.push({
                event: "purchase",
                transaction_id: "<?php echo htmlspecialchars($data['order']->order_id, ENT_QUOTES, 'UTF-8'); ?>",
                value: <?php echo floatval($data['order']->total); ?>,
                currency: "SAR"
            });
            console.log('DataLayer Purchase Event Pushed:', dataLayer);
        <?php endif; ?>
    </script>


    <script>
        <?php if (isset($data['order']) && is_object($data['order']) && isset($data['order']->total) && $data['order']->total > 0 && isset($data['order']->order_id)) : ?>
            ttq.track('Purchase', {
                value: <?php echo floatval($data['order']->total); ?>,
                currency: "SAR",
                contents: [{
                    content_id: "<?php echo htmlspecialchars($data['order']->order_id, ENT_QUOTES, 'UTF-8'); ?>",
                    quantity: <?php echo floatval($data['order']->quantity); ?>
                }],
                content_type: 'product'
            });
        <?php endif; ?>
    </script>


<?php require APPROOT . '/app/views/inc/footer.php'; ?>