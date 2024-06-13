<?php
$scriptList = array("js/jquery3.3.js");
include('header.php');
?>


<body>
    <div class="paypal-confirmation" style=" text-align: center">
        <h1>Thank you</h1>
        <p style="display: inline">Thank you for your purchase </p><p id='name' style="display: inline"><?php if (isset($_SESSION['order-email'])){$name = $_SESSION['order-name']; echo"$name";}?></p><br><br>

        <p style="display: inline">You will receive a confirmation email at </p> <p style="display: inline" id="email_p"><?php if (isset($_SESSION['order-email'])){$email = $_SESSION['order-email']; echo"$email";}?></p>
        <p>Please check your spam folder.</p>

    </div>


    <div>
        <p>Time elapsed: <?php $time = $_SESSION['time']; echo "$time";?></p>
    </div>

    <div id = "contact-section" style="margin-top: 100px">
        <h4>If you would like to get in contact, please fill out this contact form</h4>
        <p>Any feedback about the website, ordering process, or ways we can improve is appreciated.</p>
        <p>If you would like to update your delivery details, contact quickly.</p>


        <?php include_once ('contactForm.php') ?>
    </div>
</body>

<style>
    #contactSection{
        margin-top: 0;
    }
</style>


<?php

if (!isset($_SESSION['order-email'])){
echo '
<script>
    var name = window.sessionStorage.getItem("payerName")
    document.getElementById("name").innerText = name

    var email = window.sessionStorage.getItem("email")
    document.getElementById("email_p").innerText = email


</script>



';
}?>





















<?php


echo "<script>window.sessionStorage.removeItem('cart');</script>";

include('footer.php');
?>







