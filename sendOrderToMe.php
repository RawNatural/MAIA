<?php
/**
 * //the user
 *
 */
if(isset($_SESSION['authenticatedUser'])){
    $user = $_SESSION['authenticatedUser'];}
else { $user = "Name: $name";}

// the message
$msg = "New Order!\nFrom $user \n Paid: $priceSum \n Cart Items: \n <html><body> $items </body></html>";

// use wordwrap() if lines are longer than 70 characters
$msg = wordwrap($msg,70);

// Always set content-type when sending HTML email
$headers = "MIME-Version: 1.0" . "\r\n";
$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";


//More Headers: From Email
//$headers = 'From: <maia.scarf@outlook.com>' . "\r\n";

// send email
mail("rawirinathan1@gmail.com","MAIA order confirmation",$msg, $headers);

?>

