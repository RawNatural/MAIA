/**
 * Clear cart upon logout
 */
var GetCartContents = (function() {
    "use strict";
    var pub = {};


    pub.setup = function() {
        alert("logout");
    }
    return pub;

}());

$(document).ready(Logout.setup);