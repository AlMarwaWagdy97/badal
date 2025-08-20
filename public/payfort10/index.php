<?php
require_once ('apple_pay_conf.php');
?>
<!DOCTYPE html>
<html lang="en-GB">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>ApplePay Test</title>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js?version = 14.0"></script>
<style>
#applePay {  
	width: 150px;  
	height: 50px;  
	display: none;   
	border-radius: 5px;    
	margin-left: auto;
	margin-right: auto;
	margin-top: 20px;
	background-image: -webkit-named-image(apple-pay-logo-white); 
	background-position: 50% 50%;
	background-color: black;
	background-size: 60%; 
	background-repeat: no-repeat;  
}
</style>
</head>
<body>
<div>
        <input type="number" id="amount" name="amount">
        <button type="button" id="applePay"></button>

    


<p style="display:none" id="got_notactive">ApplePay is possible on this browser, but not currently activated.</p>
<p style="display:none" id="notgot">ApplePay is not available on this browser</p>
<p style="display:none" id="success">Test transaction completed, thanks. <a href="<?=$_SERVER["SCRIPT_URL"]?>">reset</a></p>
 <p style="display:none" id="failed">Transaction failed</p>
</div>
<script type="text/javascript">

var debug = <?=DEBUG?>;

if (window.ApplePaySession) {
   var merchantIdentifier = '<?=PRODUCTION_MERCHANTIDENTIFIER?>';
   var promise = ApplePaySession.canMakePaymentsWithActiveCard(merchantIdentifier);
   promise.then(function (canMakePayments) {
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

	 var totalAmount 	= $('#amount').val();
	 $('#success').html('Test transaction completed with SR '+totalAmount+', thanks.');
	 var shippingOption = "";
	 
	 var subTotalDescr	= "Test Goodies";


	 var paymentRequest = {
	   currencyCode: '<?=PRODUCTION_CURRENCYCODE?>',
	   countryCode: '<?=PRODUCTION_COUNTRYCODE?>',
	   total: {
		  label: '<?=PRODUCTION_DISPLAYNAME?>',
		  amount: totalAmount
	   },
	   supportedNetworks: ['amex', 'masterCard', 'visa' ],
	   merchantCapabilities: [ 'supports3DS', 'supportsEMV', 'supportsCredit', 'supportsDebit' ]
	};
	
	var session = new ApplePaySession(1, paymentRequest);
	
	// Merchant Validation
	session.onvalidatemerchant = function (event) {
		logit(event);
		var promise = performValidation(event.validationURL);
		promise.then(function (merchantSession) {
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
			xhr.open('GET', 'apple_pay_comm.php?u=' + valURL);
			xhr.send();
		});
	}

	session.onshippingcontactselected = function(event) {
		logit('starting session.onshippingcontactselected');
		logit('NB: At this stage, apple only reveals the Country, Locality and 4 characters of the PostCode to protect the privacy of what is only a *prospective* customer at this point. This is enough for you to determine shipping costs, but not the full address of the customer.');
		logit(event);
		

		var status = ApplePaySession.STATUS_SUCCESS;
		var newTotal = { type: 'final', label: '<?=PRODUCTION_DISPLAYNAME?>', amount: totalAmount };
		var newLineItems =[{type: 'final',label: subTotalDescr, amount: totalAmount }];
		
		session.completeShippingContactSelection(status);
		
		
	}
	
	session.onshippingmethodselected = function(event) {
		logit('starting session.onshippingmethodselected');
		logit(event);
		

		var status = ApplePaySession.STATUS_SUCCESS;
		var newTotal = { type: 'final', label: '<?=PRODUCTION_DISPLAYNAME?>', amount: totalAmount };
		var newLineItems =[{type: 'final',label: subTotalDescr, amount: totalAmount }];
		
		session.completeShippingMethodSelection(status, newTotal, newLineItems );
		
		
	}
	
	session.onpaymentmethodselected = function(event) {
		logit('starting session.onpaymentmethodselected');
		logit(event);
		
		var newTotal = { type: 'final', label: '<?=PRODUCTION_DISPLAYNAME?>', amount: totalAmount };
		var newLineItems =[{type: 'final',label: subTotalDescr, amount: totalAmount }];
		
		session.completePaymentMethodSelection( newTotal, newLineItems );
		
		
	}
	
	session.onpaymentauthorized = function (event) {

		logit('starting session.onpaymentauthorized');
		logit('NB: This is the first stage when you get the *full shipping address* of the customer, in the event.payment.shippingContact object');
		logit(event);

		var promise = sendPaymentToken(event.payment.token);
		promise.then(function (success) {	
			var status;
			if (success){
				status = ApplePaySession.STATUS_SUCCESS;
				document.getElementById("applePay").style.display = "none";
				session.completePayment(status);
			
				
				document.getElementById("success").style.display = "block";
				
				
			} else {
				status = ApplePaySession.STATUS_FAILURE;
				session.completePayment(status);
				document.getElementById("failed").style.display = "block";
			}
			
			document.innerHtml( "result of sendPaymentToken() function =  " + success );
		});
		
	}

	function sendPaymentToken(paymentToken) {
	    
		return new Promise(function(resolve, reject) {
			logit('starting function sendPaymentToken()');
			logit(paymentToken);

            $.ajax({
                               type:'POST',
                               url:'<?= URLROOT ?>/public/payfort10/payfort.php',
                               data:{apple_data:paymentToken.paymentData.data, apple_signature:paymentToken.paymentData.signature, apple_transactionId:paymentToken.paymentData.header.transactionId,
                                   apple_ephemeralPublicKey:paymentToken.paymentData.header.ephemeralPublicKey,apple_publicKeyHash:paymentToken.paymentData.header.publicKeyHash,
                                   apple_displayName:paymentToken.paymentMethod.displayName,apple_network:paymentToken.paymentMethod.network,apple_type:paymentToken.paymentMethod.type,amount:totalAmount
                               },
                               dataType: "JSON",
                               success:function(data){
                                  var parsed_json=JSON.parse(data);
                                  var status=parsed_json.status;
                                  if(status==14){
                                    resolve(true);
                                  }
                                  else{
                                      resolve(false);
                                  }
                                  
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
	
function logit( data ){
	
	if( debug == true ){
		console.log(data);
	}	

};
</script>
</body>
</html>