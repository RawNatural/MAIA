/**
 *
 */

/* global Cookie */

/**
 * Module pattern for Checkout functions
 */
var Checkout = (function () {
    "use strict";

    var pub;

    // Public interface
    pub = {};

    function clearCart(){
        window.sessionStorage.removeItem("cart");
        window.location.reload();
    }

    /**
     * Create an HTML table representing the current cart
     *
     * @param itemList an array of items to display
     * @return {string} HTML representing itemList as a table
     */
    function makeItemHTML(itemList) {
        let clearCartElement = $("#clearCart");
        clearCartElement.html('<button onclick="window.sessionStorage.removeItem(\'cart\'); window.location.reload();">Clear cart</button>')
        var html, totalPrice;
        html = "<table>";
        html += "<tr><th>Item</th><th>Price (AUD)</th></tr>";
        totalPrice = 0;
        itemList.forEach(function (item) {
            html += "<tr><td>" + item.title + "</td><td class='money'>$" + item.price + "</td></tr>";
            totalPrice += parseFloat(item.price);
        });
        // Fix rounding errors
        totalPrice = Math.round(totalPrice * 100) / 100;
        html += "<tr><th>Total Price:</th><td class='money'>$" + totalPrice + "</td></tr>";
        window.sessionStorage.setItem("price", totalPrice);
        html += "</table>";
        return html;
    }

    /**
     * Setup function for the Checkout
     *
     * Fetches the current cart from the cookie, and displays it.
     * If there is no current cart, display a message to say so.
     */
    pub.setup = function () {
        //Unset previous order details
        window.sessionStorage.removeItem('payerName')
        window.sessionStorage.removeItem('email')

        var itemList, cartElement;
        itemList = window.sessionStorage.getItem("cart");
        cartElement = $("#cart");
        if (itemList) {
            itemList = JSON.parse(itemList);
            cartElement.html(makeItemHTML(itemList));
            document.getElementById('payBtn').removeAttribute('disabled');
        } else {
            cartElement.html("<p>There are no items in your cart</p>");
            $("#checkoutForm").css({display : "none"});
        }
    };

    // Expose public interface
    return pub;
}());

// The usual ready event handling to call Checkout.setup
$(document).ready(Checkout.setup);