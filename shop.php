<?php

function addProduct($title, $price, $image, $description)
{
    echo "<div class='maia-shop-grid-div'>
            <img class='maia-shop-img' onclick='window.location.href=\"products/maia.php\"' src='$image'>
            <div class='maia-shop-caption'>
                <h4 class='itemTitle'>$title</h4>
                <div class='priceDiv'>$<span class='price'>$price</span></div>
            
                <div class='buttons'>
                    <button class='buyButton addToCart' role='button'>Add To Cart</button>
                    <button value='Buy Now' class='buyButton buyNowButton' role='button' onclick='window.location.href=\"checkout.php\"'>Buy Now</button>
                </div>
            </div>
        </div>";
}
?>


<?php $scriptList = array('js/jquery3.3.js', 'js/ShowHide.js', 'js/Cart.js', 'js/Reviews.js', 'js/ProductPhotoChange.js', 'js/cleaningTips.js');
    include("header.php");?>

<main>
    <div class='maia-carousel'>
    <?php
        $title = "MAIA";
        $price = 20.99;
        $image = 'images/scarfOne.jpg';
        $description = null;
        addProduct($title, $price, $image, $description);

        $title = "MAIA";
        $price = 20.99;
        $image = 'images/scarfOne.jpg';
        $description = "Room for a description";
        addProduct($title, $price, $image, $description);
    ?>


        <div class="maia-shop-grid-div">
            <img class='maia-shop-img' src="images/scarfOne.jpg">
            <div class="maia-shop-caption">
                <h4 class="itemTitle">MAIA</h4>
                <div class="priceDiv">$<span class='price'>20.99</span></div>
                <div class="buttons">
                    <button class='buyButton' role='button'>Add To Cart</button>
                    <button value='Buy Now' class='buyButton buyNowButton' role='button' onclick='window.location.href="checkout.php"'>Buy Now</button>
                </div>
            </div>
        </div>

        <div class="maia-shop-grid-div">
            <img class='maia-shop-img' src="images/scarfOne.jpg">
            <div class="maia-shop-caption">
                <h4 class="itemTitle">MAIA</h4>
                <div class="priceDiv">$<span class='price'>20.99</span></div>
                <div class="buttons">
                    <button class='buyButton' role='button'>Add To Cart</button>
                    <button value='Buy Now' class='buyButton buyNowButton' role='button' onclick='window.location.href="checkout.php"'>Buy Now</button>
                </div>
            </div>
        </div>

        <div class="maia-shop-grid-div">
            <img class='maia-shop-img' src="images/scarfOne.jpg">
            <div class="maia-shop-caption">
                <h4 class="itemTitle">MAIA</h4>
                <div class="priceDiv">$<span class='price'>20.99</span></div>
                <div class="buttons">
                    <button class='buyButton' role='button'>Add To Cart</button>
                    <button value='Buy Now' class='buyButton buyNowButton' role='button' onclick='window.location.href="checkout.php"'>Buy Now</button>
                </div>
            </div>
        </div>

        <div class="maia-shop-grid-div">
            <img class='maia-shop-img' src="images/scarfOne.jpg">
            <div class="maia-shop-caption">
                <h4 class="itemTitle">MAIA</h4>
                <div class="priceDiv">$<span class='price'>20.99</span></div>
                <div class="buttons">
                    <button class='buyButton' role='button'>Add To Cart</button>
                    <button value='Buy Now' class='buyButton buyNowButton' role='button' onclick='window.location.href="checkout.php"'>Buy Now</button>
                </div>
            </div>
        </div>

        <div class="maia-shop-grid-div">
            <img class='maia-shop-img' src="images/scarfOne.jpg">
            <div class="maia-shop-caption">
                <h4 class="itemTitle">MAIA</h4>
                <div class="priceDiv">$<span class='price'>20.99</span></div>
                <div class="buttons">
                    <button class='buyButton' role='button'>Add To Cart</button>
                    <button value='Buy Now' class='buyButton buyNowButton' role='button' onclick='window.location.href="checkout.php"'>Buy Now</button>
                </div>
            </div>
        </div>
    </div>

    <?php
    /*
    $productName = "Scarf Top";
    $images = array("images/scarfOne.jpg");
    $price = 20.99;
    $description = "A scarf top, to wear any way you like. Enjoy the versatility and nice colour that these will add to your look";


    addProduct($productName, $images, $price, $description, ""); */?>

    <?php
    /*$productName = "Scarf Top";
    $images = array("images/scarfOne.jpg");
    $price = 20.99;
    $description = "A scarf top, to wear any way you like. Enjoy the versatility and nice colour that these will add to your look";

    addProduct($productName, $images, $price, $description, "");

*/
    /**
    $productName = "Bamboo_Utensils_Travel_Pack";
    $images = array("images/utensilsCamo.jpg","images/utensilsMain.jpg", "images/utensilsPurple.jpg", "images/utensilsCamo.jpg");
    $price = 12.99;
    $description = "<p><strong>Utensils on the go</strong></p><p>Store easily, and fold out to eat.</p><p>Strong, sturdy, and easy to wash.</p>";

    addProduct($productName, $images, $price, $description, "");
    ?>


    <?php
    $productName = "Bamboo_Drinking_Straws";
    $images = array("images/BambooStrawsMain.jpg", "images/BambooStrawsMain.jpg", "images/BambooStrawsAndBrush.jpg", "images/strawsEnds.jpeg");
    $price = 9.99;
    $description = "<p><strong>Get in now on the new trend!</strong></p>
        <p>Bamboo straws feel and look spectacular. Help <strong>get rid of the millions of plastic straws</strong> that are polluting our oceans and land.</p>
        <p>Our bamboo straws are <strong>durable</strong> and <strong>easy to store</strong>. Take them with you wherever you go so that you never need to use another plastic straw.</p>
        <p>Our straws are completely Eco-Friendly! They are <strong>100% Biodegradable</strong> and <strong>Compostable</strong>; their components will break down into smaller particles and nutrients when left in the environment.</p>
        <p>They can be <strong>reused</strong> many times and will <strong>last several months</strong> if cared for.</p>";
    $anythingElse = "<div id='cleaningTips'><h4>Cleaning Tips</h4></div>
<p>Length: 19.5cm. Inner diameter: 4-5mm. </p>";

    addProduct($productName, $images, $price, $description, $anythingElse);

    ?>



<?php
$productName= "Bamboo_Toothbrush";
$images = array("images/toothbrushMain.jpg", "images/toothbrushMain.jpg");
$price = 3.99;
$description = "<p>Brush your teeth with an environmentally friendly toothbrush.</p><p>With charcoal-infused brushes to help remove stains and leave your teeth whiter than ever</p>";

addProduct($productName, $images, $price, $description, "");
*/?>


</main>


        <footer>
            <?php include("footer.php"); ?>
        </footer>

    </body>
</html>