<?php require APPROOT . '/app/views/inc/header.php'; ?>

<div>
    <div class="container">
        <section id="categories">
            <div class="row m-3 justify-content-center ">
                <h2 class="text-center col-12"> <img src="<?php echo URLROOT; ?>/templates/default/images/namaa-icon.png" alt="Smiley face" class="ml-2">ApplePay</h2>
        
                <div class="container">
                    <button onclick="pay()" class="btn w-100 btn-success"> الدفع </button>
                </div>
        
                <form id="paymentForm" method="post" action="https://checkout.payfort.com/FortAPI/paymentPage">
        
        
                    <input type="hidden" name="signature" id="signature">
                    <INPUT type="hidden" NAME="command" value="PURCHASE">
        
                    <INPUT type="hidden" NAME="merchant_identifier" value="BiZjlLxK">
                    <INPUT type="hidden" NAME="access_code" value="PFEiLpPP5luIGAsOyoFy">
                        
        
                    <INPUT type="hidden" NAME="amount" value="<?= $data['order']->total * 100 ?>">
        
                    <INPUT type="hidden" NAME="merchant_reference" value="<?= $data['order']->order_identifier ?>">
                    <INPUT type="hidden" NAME="currency" value="SAR">
                    <INPUT type="hidden" NAME="language" value="ar">
                    <INPUT type="hidden" NAME="customer_email" value="<?= $data['order']->order_identifier ?>@fvc-sa.com">
        
                    <input type="hidden" id="order_description" name="order_description" value="Test order">
                    <INPUT type="hidden" NAME="return_url" value="<?= URLROOT ?>/projects/PurchaseResponse">
        
                </form>
            </div>
        </section>
    </div>
</div>



    <script src="https://cdnjs.cloudflare.com/ajax/libs/crypto-js/4.1.1/crypto-js.min.js"></script>
    <script>
        function pay() {
            CalculateSignature();
            document.getElementById("paymentForm").submit();

        }

        function CalculateSignature() {
            const requestShaPhrase = "egvierrbvjb"; //document.getElementById("SHARequestPhrase").value;  // Set your request SHA phrase here.
            let signatureString = requestShaPhrase;

            // Get form data
            const formData = new FormData(document.getElementById("paymentForm"));

            // Convert formData to object for easy sorting
            const formDataObject = {};
            formData.forEach((value, key) => {
                formDataObject[key] = value;
            });

            // Sort formDataObject by keys
            const sortedFormDataObject = Object.fromEntries(
                Object.entries(formDataObject).sort(([keyA], [keyB]) => keyA.localeCompare(keyB))
            );

            // Construct sorted signatureString
            for (const [key, value] of Object.entries(sortedFormDataObject)) {
                if (key !== 'signature') {
                    signatureString += key + '=' + value;
                }
            }

            signatureString += requestShaPhrase;

            // Calculate SHA256 signature
            const calculatedSignature = CryptoJS.SHA256(signatureString).toString();

            // Set signature value in the form
            document.getElementById("signature").value = calculatedSignature;

            // Submit the form
            document.getElementById("paymentForm").submit();
        }

    </script>
    
<?php require APPROOT . '/app/views/inc/footer.php'; ?>