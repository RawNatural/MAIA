/**
 * Ajax for validating code
 *
 * Created by: Nathan Rawiri, 16/09/2020
 */

/**
 * Module pattern for GetCartContents function
 */
var GetCartContents = (function() {
    "use strict";
    var pub = {};


    /**
     * Setup Function
     *
     */
    pub.setup = function() {

        var cartData = window.sessionStorage.getItem("cart");

        $.ajax({

            type: "POST",
            url: 'processCartContents.php', cache: false,
            data: cartData,
            datatype: 'JSON',
            contentType: "application/json; charset=utf-8",
            success: function (data) {
                $("#itemTable").html(data);
                //window.localStorage.clear();
                //window.sessionStorage.clear();
            },
            error: function(xhr, status, error) {
                alert("Ajax Failed");
                console.log(xhr.responseText);
                console.log(error);
                console.log(status);
            }
            

        });
    }
    return pub;

}());

$(document).ready(GetCartContents.setup);