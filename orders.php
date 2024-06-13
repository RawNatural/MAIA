<main>
    <?php
    if (session_id() === "") {
    session_start();
    }

    if (!isset($_SESSION['authenticatedUser'])) {
        header('Location: index.php');
        exit;
    }
    ?>


<?php
$role = $_SESSION['role'];

$scriptList = array('js/jquery3.3.js');
include('header.php'); include("checkLogin.php");

$orders = simplexml_load_file('htaccess/orders.xml');

$usersOrders = 0;

$sessionUser = $_SESSION['authenticatedUser'];
echo "<p>$sessionUser </p> <br>";

foreach ($orders->order as $order) {
    $user = $order->delivery->user;
    if ($role === 'root') {
            echo "<h4>Order</h4>";
            
            $user = $order->delivery->user;
            echo "<p>User: $user</p>";
            $name = $order->delivery->name;
            echo "<p>Name: $name</p>";
            $email = $order->delivery->email;
            echo "<p>Email: $email</p>";
            $address = $order->delivery->address;
            echo "<p>Address: $address</p>";
            $city = $order->delivery->city;
            echo "<p>City: $city";
            $postcode = $order->delivery->postcode;
            echo "<p>Postcode: $postcode</p>";
            
            
            echo "<h4>Items</h4>";

            $items = $order->items->item;
            
            echo "<h4>$items</h4>";
            foreach ($items as $item) {
                $title = $item->title;
                echo "<p>Title: $title</p>";
                $price = $item->price;
                echo "<p>Price: $price</p>";
            }
            
        

    }
    else if ($sessionUser == $user) {
        echo "<h4>Personal Details</h4>";
        $name = $order->delivery->name;
        echo "<p>Name: $name</p>";
        $email = $order->delivery->email;
        echo "<p>Email: $email</p>";
        $address = $order->delivery->address;
        echo "<p>Address: $address</p>";
        $city = $order->delivery->city;
        echo "<p>City: $city";
        $postcode = $order->delivery->postcode;
        echo "<p>Postcode: $postcode</p>";


        echo "<h4>Items</h4>";
        $items = $order->items->item;
        foreach ($items as $item) {
            $title = $item->title;
            echo "<p>Title: $title</p>";
            $price = $item->price;
            echo "<p>Price: $price</p>";
        }
        $usersOrders++;
    }

}
if ($usersOrders === 0){
    echo "You have not made any orders.";
}





echo "</main>";


include('footer.php');
?>