<?php 

    $amount = $_GET['amount'];
    
    success($amount);
    
    function success($amount){
        echo 'Test transaction completed with SR '.$amount.', thanks.';
    }

exit;
?>