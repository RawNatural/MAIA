
<?php

if (session_id() === "") {
    session_start();
}
?>

<?php

include("htaccess/validationFunctions.php");

?>


<!DOCTYPE html>
<html lang="en">
<main>
    <style>
        .loader {
            border: 16px solid #f3f3f3; /* Light grey */
            border-top: 16px solid #3498db; /* Blue */
            border-radius: 50%;
            width: 120px;
            height: 120px;
            animation: spin 2s linear infinite;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
    </style>

    <div class="loader"></div>
    <div class="payment-processing-message"><h2>Payment Processing - please do not close the window</h2></div>
    
    <script src="https://js.stripe.com/v3/"></script>
    <script src="js/jquery3.3.js"></script>

    <?php
    //print_r($_POST);
    $token = $_POST['stripeToken'];
    $_SESSION['stripeToken'] = $token;
    //echo "<p>this is the $token";
    
    $formNames = array('First_name','Last_name', 'Email', 'Phone','Address', 'City', 'Region/State', 'Postal_code', 'cardType', 'card_num', 'exp_month', 'exp_year', 'cvc');
    $errorcounter = 0;
    foreach($formNames as $formName) {
        $_SESSION[$formName] = $_POST[$formName];
        if (isEmpty($_POST[$formName])){
            $errorcounter++;
            echo "<p>Empty Error: $formName </p>";
            $errorString .= "$formName is empty. <br>";
        }
        }

    $numberForms = array('Postal_code', 'card_num', 'exp_month', 'exp_year', 'cvc');
    foreach ($numberForms as $numberForm) {
        if (!isDigits($_POST[$numberForm])){
            echo "<p>Digit Error: $numberForm</p>";
            $errorString .= "Digit Error: $numberForm<br>";
            $errorcounter++;
        }
    }

    if (!isEmail($_POST['Email'])){
        echo "<p>Error: Not a valid email</p> <br>";
        $errorString .= "Error: Not a valid email <br>";
        $errorcounter++;
    }


    if (!checkCardNumber($_POST['cardType'], $_POST['card_num'])){
        echo"<p>Error: Card Number invalid";
        $errorString .= "Error: Card Number invalid <br>";
        $errorcounter++;
    }
    if (!checkCardVerification($_POST['cardType'], $_POST['cvc'])){
        echo"<p>Error: Card Verification number invalid";
        $errorString .= "Error: Card Verification number invalid <br>";
        $errorcounter++;
    }
    if (!checkCardDate($_POST['exp_month'], $_POST['exp_year'])){
        echo"<p>Error: Card Date must be in the future";
        $errorString .= "Error: Card Date must be in the future <br>";
        $errorcounter++;
    }

    if (!$errorcounter == 0){
        $_SESSION['orderError'] = "<h4>No. of Errors: $errorcounter</h4> \n $errorString";
        header("Location: checkout.php");
        echo"No. of Errors: $errorcounter";
    }else{
        unset($_SESSION['orderError']); $errorString = "";
        print_r("here1");
        include('getCartContents.php');
        //include('submit.php');

        }
        //echo '<script> alert(sessionStorage.getItem("cart")); </script>';
    ?>
    <div id="itemTable">

    </div>
</main>
</html>