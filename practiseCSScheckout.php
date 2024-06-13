<!DOCTYPE html>

<html lang="en">
<head>
    <title>Checkout</title>
    <link rel="stylesheet" href="checkout.css">


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
                        $formNames = array('First name','Last name', 'Email', 'Phone','Address', 'City', 'Region/State', 'Postal code');
                        foreach ($formNames as $formName){

                            //adding beside ones
                            if($formName == "First name" || $formName == "Region/State"){echo"<div class ='beside' style='display: flex; justify-content: space-between'>";}

                            //Repeats repeated input/label typing
                            echo "<div class='text-field'>
                    <input type='text' name='$formName' id='$formName' placeholder='$formName'"; if (isset($_SESSION[$formName])) {
                                $name = $_SESSION[$formName];
                            }
                            $box = $formName; //include('fillBox.php');

                            echo"><label for=$formName>$formName</label>
                                </div>";

                            //for beside ones again
                            if ($formName == "Last name" || $formName == "Postal code"){echo"</div>";}
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
                            <option value="12">12</option>
                        </select>
                        <label for="exp_month">Expiry month</label>
                    </div>
                        \

                    <div class="text-field" style="width: 25%; position: relative; right: 3%">
                    <select name="exp_year" id="exp_year" class="card-expiry-year">
                        <option value="" disabled selected hidden>YY</option>
                            <option value="2023">23</option>
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

        <div class="right-side"></div>
    </div>

</body>
</html>