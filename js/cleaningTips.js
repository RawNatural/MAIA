var cleaningTips = (function () {

    var pub = {};
    var showHideCheck = false;
    function showHideTips () {
        if (!showHideCheck) {
            let p = document.createElement('p');
            p.innerHTML = '1. It’s best to rinse your immediately after use.<br>' +
                '2. To reduce the risk of bacteria build-up inside, use the long, thin brush included FREE to clean them.<br>' +
                '3. <strong>Always let your bamboo straws dry fully.</strong> It\'s best to dry them laid flat. (not vertical because water can build up at the end)<br>' +
                '4. Every month or so, soak the straw in some boiling water and a spoonful of vinegar for an extra deep clean. They dry very quickly - then store your straws in a well-ventilated place. Avoid airtight containers or jars as this will cause potential moisture buildup inside the straws.<br>' +
                '5. They can be reused many times but once they’ve seen done their time, bamboo straws can simply be placed in your composter or returned to the earth to break down naturally.<br>' +
                '6. If properly cleaned and cared for, Bamboo Drinking Straws can last several years.';
            this.append(p);

            showHideCheck = true;
        }else{
            this.innerHTML = '<h4>Cleaning Tips</h4>';
            showHideCheck = false;
        }
    }
    pub.setup = function() {
        $('#cleaningTips').click(showHideTips);
    };

    return pub;

}());

$(document).ready(cleaningTips.setup);