<?php

if (session_id() === "") {
    session_start();
}
?>

<?php
$time_pre = microtime(true);



?>


<?php

if (!$priceSum) {
    echo "<h4>Order Already Submitted</h4>";
    echo "<script>window.location.href='shop.php';</script>";
    exit;
}


//print_r('hi g this is submit.php ');
//check whether stripe token is not empty
if(!empty($_SESSION['stripeToken'])){
    //print_r("theres a token");
    //get token, card and user info from the form
    $token  = $_SESSION['stripeToken'];
    $first_name = $_SESSION['First_name'];
    $lirst_name = $_SESSION['Last_name'];
    $email = $_SESSION['Email'];
    $card_num = $_SESSION['card_num'];
    $card_cvc = $_SESSION['cvc'];
    $card_exp_month = $_SESSION['exp_month'];
    $card_exp_year = $_SESSION['exp_year'];

    //include Stripe PHP library
    require_once("stripe-php/init.php");
    //set api key
    $stripeKeys = array(
      "secret_key"      =>                                      "sk_test_51K3FIuE3QizePBpfyEYIPLUGt4kqRbUevD9RIEd90UEt3kfEfEFtkaaaHxviH9bUD6dcdjiMs2FlyWLZYUm8cvvP00sUxEkJaN",
      "publishable_key" =>                                      "pk_test_51K3FIuE3QizePBpf0DwNYsjqAhY6Y2NvKLarC75WS3mzNU4rkpoFnMhzyEaFfCcAk31NIEFap3xBDCDX4rP9nU0P00dXSf5sb7"
    );

    \Stripe\Stripe::setApiKey($stripeKeys['secret_key']);


   $stripe = new \Stripe\StripeClient(
        $stripeKeys['secret_key']
    );


    $priceDollars = intval($priceSum);
    $priceCents = $priceSum - $priceDollars;
    $priceCents = round($priceCents, 2);
    $priceCents = substr((string)$priceCents, 2);
    //print_r("$priceDollars and $priceCents");
    $priceDollars=(string)$priceDollars;
    $priceCents=(string)$priceCents;
    $price = $priceDollars.$priceCents;
    $price = (int)$price;



$charge = \Stripe\Charge::create([
  'amount' => $price,
  'currency' => 'aud',
  'description' => 'Maia charge',
  'source' => $token,
]);

echo "<script>window.location.href='orderConfirmation.php';</script>";



    //check payment status
    //include("webhook.php");






    //$itemName = "CHANGE THIS TO BE AN ITEM LIST";
    $itemName = $items;
    $itemNumber = 1234;



    //check whether the charge is successful
    if($charge['amount_refunded'] == 0 && empty($charge
['failure_code']) && $charge['paid'] == 1 && $charge['captured'] == 1){

        echo"<h2>Transaction successful</h2>";
        $statusMsg = "<h2>Transaction Successful.</h2>
        <h3>Amount Paid = ".'$'."$priceSum AUD</h3>";




        //THIS TAKES AGES
        //include("sendOrderToMe.php");

        //order details
        $amount = $charge['amount'];
        $balance_transaction = $charge['balance_transaction'];
        $currency = $charge['currency'];
        $status = $charge['status'];
        $date = date("Y-m-d H:i:s");

        /*
        //include database config file
        include_once("htaccess/databaseconnect.php");

        //insert tansaction data into the database
        $sql =
"INSERT INTO orders(name,email, item_name,item_number,item_price,item_price_currency,paid_amount,
paid_amount_currency,txn_id,payment_status,created,modified) VALUES
('".$name."','".$email."','".$itemName."','".$itemNumber."',".$price."','".$currency."',
".$amount.",'".$currency."','".$balance_transaction."'
,'".$status."','".$date."','".$date."')";

        $insert = $conn->query($sql);
        $last_insert_id = $conn->insert_id;

        //if order inserted successfully
        if($last_insert_id){

            echo"<h4>Order ID: {$last_insert_id}</h4>";
        }else{
            $statusMsg .= "<h4>Error inserting into database</h4>";
        }
        */

        //Prevent repeat attempts
        unset($priceSum);

        $_SESSION['order-email'] = $email;
        $_SESSION['order-name'] = $first_name;
        echo "<script>window.location.href='orderConfirmation.php';</script>";

    }else{
        $statusMsg = "Transaction has failed";
        echo "<script>window.location.href='issue-with-order.php';</script>";
    }
}else{
    $statusMsg = "Form submission error.......";
    echo "<script>window.location.href='issue-with-order.php';</script>";
}



$time_post = microtime(true);
$exec_time = $time_post - $time_pre;
$_SESSION['time'] = $exec_time;


$_SESSION['statusMsg'] = $statusMsg;




?>