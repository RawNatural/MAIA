var Cart = (function() {
    "use strict";
    var pub = {};

    function addToCart() {
        var itemList, newItem;
        itemList = window.sessionStorage.getItem("cart");
        if (itemList) {
            itemList = JSON.parse(itemList);
        } else {
            itemList = [];
        }
        newItem = {};
        /* jshint -W040 */
        newItem.title = $(this).parent().parent().find(".itemTitle").html();

        newItem.price = $(this).parent().parent().find(".priceDiv").find(".price").html();
        /* jshint +W040 */
        itemList.push(newItem);
        window.sessionStorage.setItem("cart", JSON.stringify(itemList));
    }

    pub.setup = function() {
        $(".buyButton").click(addToCart);
    }

    return pub;
})();

$(document).ready(Cart.setup);
