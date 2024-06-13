<?php

echo "<h1>HELLO</h1>";
$details = json_decode(file_get_contents("php://input"));

echo "<h1>$details</h1>";

echo "<script>window.location.href='orderConfirmation.php';</script>";
?>