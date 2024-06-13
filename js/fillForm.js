/**
 *
 * Created by: Nathan Rawiri
 */


/**
 * Module pattern
 */
var FillForm = (function(){
    "use strict";
    var pub = {};

    /**
     * A function to quickly fill the form
     */
    pub.fillForm = function(){
        $("#Name").val("A Name");
        $("#Email").val("Bill@microsoft.com");
        $("#Address1").val("An Address");
        $("#Address2").val("More Address");
        $("#City").val("A City");
        $("#Postcode").val("1234");
        $("#cardType").val("amex");
        $("#card-num").val("311111111111111");
        $("#cardValidation").val("1234");
        $("#cardYear").val("2021");
    };

    return pub;
}());