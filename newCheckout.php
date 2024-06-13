
<!DOCTYPE html>

<html lang="en">
<head>
    <title>Checkout</title>
    <link rel="stylesheet" href="checkout.css">
    <script src="js/jquery3.3.js"></script>
    <script src="js/Checkout.js"></script>
    <script src="js/StripeJava.js"></script>
    <!-- Stripe JavaScript library -->
    <script type="text/javascript" src="https://js.stripe.com/v2/"></script>


    <style>
        .text-field {
            position: relative;
        }
        .text-field label {
            position: absolute;
            top: 1.5em;
            visibility: hidden;
            left: 0;
            color: #999;
            pointer-events: none;
            transition: top 0.2s ease-out;
        }
        .text-field input:not(:placeholder-shown) + label, select:not(:placeholder-shown) + label {
            top: 7px;
            left: 8px;
            visibility: visible;
        }

        .text-field input, select {
            border-radius: 5px;
            border: 1px transparent solid;
            background-clip: padding-box;
            margin: 6px;
        }
        .beside .text-field {
            width: 48%;
        }


    </style>
</head>


<body>
<div class="split">
    <div class="left-side">
        <div class="checkout-header">
            <h1>maia</h1>
        </div>
        <div class="checkout-main">


            <form id="paymentFrm" action="validateCheckout.php" method="post" novalidate>

                <div id="errors"></div>

                <fieldset id="deliveryFieldset">
                    <!-- First section of form is delivery address etc. -->
                    <legend>Delivery Details</legend>
                    <?php
                    $formNames = array('First_name','Last_name', 'Email', 'Phone','Address', 'City', 'Region/State', 'Postal_code');
                    foreach ($formNames as $formName){

                        $replace = str_replace('_', ' ', $formName);

                        //adding beside ones
                        if($formName == "First_name" || $formName == "Region/State"){echo"<div class ='beside' style='display: flex; justify-content: space-between'>";}

                        //Repeats repeated input/label typing
                        echo "<div class='text-field'>
                    <input type='text' name='$formName' id='$formName' placeholder='$replace'"; if (isset($_SESSION[$formName])) {
                            $name = $_SESSION[$formName];
                        }
                        $box = $formName; //include('fillBox.php');
                        echo"><label for=$formName>$replace</label>
                                </div>";

                        //for beside ones again
                        if ($formName == "Last_name" || $formName == "Postal_code"){echo"</div>";}
                    }?>

                    <div class="text-field">
                        <?php include('html_shortcuts/country_select.php');?>

                    </div>
                    <div class="text-field">

                    </div>


                </fieldset>

                <fieldset id="paymentFieldset">
                    <legend>Payment Details</legend>



                    <div class="text-field">
                        <select name="cardType" id="cardType">
                            <option value="visa">Visa</option>
                            <option value="mcard">Master Card</option>
                            <option value="amex">American Express</option>
                        </select>
                        <label for="cardType">Card type</label>
                    </div>
                    <div class="text-field">
                        <input type="text" placeholder="Card number" class="card-number" name="card_num" id="card_num"value="4242424242424242" autocomplete="off" maxlength="16" required <?php
                        $box = 'cardNumber'; //include('fillBox.php'); ?>
                        >
                        <label for="card_num">Card number</label>
                    </div>
                    <div class="text-field">
                        <input type="text" class="card-name" name="card_name" id="card_name" placeholder="Name on card">
                        <label for="card_name">Name on card</label>
                    </div>
                    <div class="same-line" style="display: flex; justify-content: space-between; align-items: center">
                        <div class="text-field" style="width: 25%;">
                            <select name="exp_month" id="exp_month" class="card-expiry-month">
                                <option value="" disabled selected hidden>MM</option>
                                <option value="1">01</option>
                                <option value="2">02</option>
                                <option value="3">03</option>
                                <option value="4">04</option>
                                <option value="5">05</option>
                                <option value="6">06</option>
                                <option value="7">07</option>
                                <option value="8">08</option>
                                <option value="9">09</option>
                                <option value="10">10</option>
                                <option value="11">11</option>
                                <option value="12" selected>12</option>
                            </select>
                            <label for="exp_month">Expiry month</label>
                        </div>
                        \

                        <div class="text-field" style="width: 25%; position: relative; right: 3%">
                            <select name="exp_year" id="exp_year" class="card-expiry-year">
                                <option value="" disabled selected hidden>YY</option>
                                <option value="2023" selected>23</option>
                                <option value="2024">24</option>
                                <option value="2025">25</option>
                                <option value="2026">26</option>
                                <option value="2027">27</option>
                                <option value="2028">28</option>
                            </select>
                            <label for="exp_year">Expiry year</label>
                        </div>
                        <div class="text-field" style="width: 40%">
                            <input type="text" class="short" placeholder="Security code" maxlength="4" name="cvc" value="123" id="cardValidation" autocomplete="off" required <?php
                            $box = 'cardValidation'; //include('fillBox.php'); ?>
                            >
                            <label for="cardValidation">Security code</label>
                        </div>
                    </div>
                </fieldset>
                <input id="payBtn" class='lightGreenButton'type="submit" value="Place Order">
            </form>
        </div>
    </div>

    <div class="right-side">
        <section id="clearCart" style="height: 1000px"></section>
    </div>
</div>

</body>
</html>
<?php if (isset($_SESSION['orderError'])) {
    $orderError = $_SESSION['orderError'];
    echo "<article>$orderError</article>";
} ?>

<div id="smart-button-container">
    <div style="text-align: center;">
        <div id="paypal-button-container"></div>
    </div>
</div>
<script src="https://www.paypal.com/sdk/js?client-id=sb&enable-funding=venmo&currency=USD" data-sdk-integration-source="button-factory"></script>
<script>
    function initPayPalButton() {
        paypal.Buttons({
            style: {
                shape: 'rect',
                color: 'gold',
                layout: 'vertical',
                label: 'paypal',

            },

            createOrder: function(data, actions) {
                return actions.order.create({
                    purchase_units: [{"amount":{"currency_code":"USD","value":window.sessionStorage.getItem("price")}}]
                });
            },

            onApprove: function(data, actions) {
                return actions.order.capture().then(function(orderData) {

                    // Full available details
                    console.log('Capture result', orderData, JSON.stringify(orderData, null, 2));

                    // Show a success message within this page, e.g.
                    const element = document.getElementById('paypal-button-container');
                    element.innerHTML = '';
                    element.innerHTML = '<h3>Thank you for your payment!</h3>';

                    // Or go to another URL:  actions.redirect('thank_you.html');

                });
            },

            onError: function(err) {
                console.log(err);
            }
        }).render('#paypal-button-container');
    }
    initPayPalButton();
</script>




<div id="maiaFooter">
    <p>&copy;Maia 2022</p>
</div>

</body>
</html>




<?php

//OLD CHECKOUT BODY
?>


<body>


<section id="clearCart"></section>

<!-- MUST BE CALLED paymentFrm  checkout form. on submit, posts to validateCheckout -->
<form id="paymentFrm" action="validateCheckout.php" method="post" novalidate>
    <fieldset id ="cart"></fieldset>
    <div id="errors"></div>

    <fieldset id="deliveryFieldset">
        <!-- First section of form is delivery address etc. -->
        <legend>Delivery Details</legend>
        <?php
        $formNames = array('Name', 'Email', 'Address1', 'City',
            'Postcode');
        foreach ($formNames as $formName){
            if ($formName === 'Address1'){
                $displayName = 'Address Line 1';
            } else {
                $displayName = $formName;}

            echo "<p><label for=$formName>$displayName</label>
                    <input type='text' name='$formName' id='$formName'"; if (isset($_SESSION[$formName])) {
                $name = $_SESSION[$formName];
            }
            $box = $formName; //include('fillBox.php');

            echo"></p>";}?>


    </fieldset>
    <!--<fieldset>
        <h3>Unavailable option: Pay with bitcoin or litecoin. </h3>
        <p><strong>pay with bitcoin to bitcoin address:</strong></p>

        <p><strong>pay with litecoin to litecoin address:</strong></p>
    </fieldset>-->

    <!-- Next section has credit card details -->
    <fieldset id="paymentFieldset">
        <legend>Payment Details</legend>
        <p>
            <label for="cardType">Card type:</label>
            <select name="cardType" id="cardType">
                <option value="visa">Visa</option>
                <option value="mcard">Master Card</option>
                <option value="amex">American Express</option>
            </select>
        </p>
        <p>
            <label for="card_num">Card number:</label>
            <input type="text" class="card-number" name="card_num" id="card_num"value="4242424242424242" autocomplete="off" maxlength="16" required <?php
            $box = 'cardNumber'; //include('fillBox.php'); ?>
            >
        </p>
        <p>
            <label for="cardMonth">Expiry date:</label>
            <select name="exp_month" id="cardMonth" class="card-expiry-month">
                <option value="1">01</option>
                <option value="2">02</option>
                <option value="3">03</option>
                <option value="4">04</option>
                <option value="5">05</option>
                <option value="6">06</option>
                <option value="7">07</option>
                <option value="8">08</option>
                <option value="9">09</option>
                <option value="10">10</option>
                <option value="11">11</option>
                <option value="12" selected>12</option>
            </select>
            \ <select name="exp_year" id="cardYear" class="card-expiry-year">
                <option value="2022">2022</option>
                <option value="2023" selected>2023</option>
                <option value="2024">2024</option>
                <option value="2025">2025</option>
                <option value="2026">2026</option>
                <option value="2027">2027</option>
            </select>
        </p>
        <p>
            <label for="cardValidation">CVC:</label>
            <input type="text" class="short card-cvc" maxlength="4" name="cvc" value="123" id="cardValidation" autocomplete="off" required <?php
            $box = 'cardValidation'; //include('fillBox.php'); ?>
            >
        </p>
    </fieldset>
    <input id="payBtn" class='lightGreenButton'type="submit" value="Place Order">
</form>
<?php if (isset($_SESSION['orderError'])) {
    $orderError = $_SESSION['orderError'];
    echo "<article>$orderError</article>";
} ?>








<div id="maiaFooter">
    <p>&copy;Maia 2022</p>
</div>

</body>
















