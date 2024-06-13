/**
 * Photo Change details on Environment Friend site
 * Created by: Nathan Rawiri, 08/10/20
 *
 */

/**
 * Module pattern for Photo Change functions
 */
var PhotoChange = (function () {
    "use strict";
    var pub = {};

    /** Makes selected photo the priority viewing photo
     */
    function makePriority() {
        //console.log(this);
        var mainImg = this.parentNode.getElementsByTagName('img')[0];
        mainImg.src = this.src;
        }

    /** Setup function
     * Gets image elements within product divs,
     * adds cursor pointer and onclick to makePriority function
     */
    pub.setup = function () {

        /**for each product, set all the images to make main photo on click. And highlight with curser pointer
        */
        $(".product").find("img").click(makePriority).css("cursor", "pointer");


    };
    return pub;
    }());

$(document).ready(PhotoChange.setup);