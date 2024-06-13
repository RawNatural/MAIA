<!-- Stripe JavaScript library -->
<script type="text/javascript" src="https://js.stripe.com/v2/"></script>

    <?php

if (session_id() === "") {
    session_start();
}
$_SESSION['lastPage'] = $_SERVER['PHP_SELF'];


//Unset order names, if this is their second order
    unset($_SESSION['order-name']);
    unset($_SESSION['order-email']);
?>

<!DOCTYPE html>

<html lang="en">

<head>
    <title>Maia</title>
    <meta charset="utf-8">
    <link rel="stylesheet" href="checkout.css">

    <script src='js/jquery3.3.js'></script>
    <script src='js/Checkout.js'></script>
    <script src='js/StripeJava.js'></script>


    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />

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
            <h1 style="text-align: center"><a href="index.php" style="text-decoration: none; color: inherit;">MAIA</a></h1>
            <div class="title_lines" style="margin-bottom: 5px;">Express checkout</div>
            <div id="paypalStuff">
            <div id="paypal-button-container"></div>
            <!-- Sample PayPal credentials (client-id) are included -->
            <script src="https://www.paypal.com/sdk/js?client-id=AcZ5OyXcJ6x1RoOuXv-DX-hQWF_xkw9sm-s8Wgfu9O7Q0zezstnktS2vGDoInD82rGI_zFgkV3v8A62y&currency=AUD&intent=capture" data-sdk-integration-source="integrationbuilder"></script>

            <script>
                const fundingSources = [
                    paypal.FUNDING.PAYPAL,
                    paypal.FUNDING.PAYLATER
                ]

                for (const fundingSource of fundingSources) {
                    const paypalButtonsComponent = paypal.Buttons({
                        fundingSource: fundingSource,

                        // optional styling for buttons
                        // https://developer.paypal.com/docs/checkout/standard/customize/buttons-style-guide/
                        style: {
                            shape: 'rect',
                            height: 40,
                        },

                        // set up the transaction
                        createOrder: (data, actions) => {
                            // pass in any options from the v2 orders create call:
                            // https://developer.paypal.com/api/orders/v2/#orders-create-request-body
                            const createOrderPayload = {
                                purchase_units: [
                                    {
                                        amount: {
                                                "currency_code":"AUD","value":window.sessionStorage.getItem("price"),
                                        },
                                    },
                                ],
                            }

                            return actions.order.create(createOrderPayload)
                        },

                        // finalize the transaction
                        onApprove: (data, actions) => {
                            const captureOrderHandler = (details) => {
                                const payerName = details.payer.name.given_name
                                console.log('Transaction completed!')
                                console.log(details);

                                const email = details.payer.email_address;

                                const address = details.payer.address;

                                window.sessionStorage.setItem("payerName",payerName)
                                window.sessionStorage.setItem("email",email)
                                window.location.href='orderConfirmation.php';

                            }

                            return actions.order.capture().then(captureOrderHandler)
                        },

                        // handle unrecoverable errors
                        onError: (err) => {
                            console.error(
                                'An error prevented the buyer from checking out with PayPal',
                            )
                        },
                    })

                    if (paypalButtonsComponent.isEligible()) {
                        paypalButtonsComponent
                            .render('#paypal-button-container')
                            .catch((err) => {
                                console.error('PayPal Buttons failed to render')
                            })
                    } else {
                        console.log('The funding source is ineligible')
                    }
                }
            </script>
            </div>
            <div class="title_lines" style="margin-top:10px;">Or</div>
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
                <input id="payBtn" type="submit" value="Place Order">
            </form>
        </div>

        <div id="maiaFooter" style="text-align: center">
            <p>&copy;Maia 2022</p>
        </div>
    </div>

    <div class="right-side">
        <section id="clearCart" style="height: 1000px"></section>
        <fieldset id ="cart"></fieldset>
        <div id="errors"></div>

    </div>
</div>

</body>
</html>
<?php if (isset($_SESSION['orderError'])) {
    $orderError = $_SESSION['orderError'];
    echo "<article>$orderError</article>";
} ?>






</body>
</html>