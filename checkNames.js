function checkPlaceName(str) {
    // ajax connect
    var ajax, data;
    if (window.XMLHttpRequest) {
        // new support
        ajax = new XMLHttpRequest();
    } else {
        // old support
        ajax = new ActiveXObject("Microsoft.XMLHTTP");
    }
    // create request
    ajax.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    ajax.open("POST", "URL", true);
    ajax.send(str);
    // ajax process data
    ajax.onreadystatechange = function() {
        if (ajax.readyState == 4 && ajax.status == 200) {
            data = ajax.responseText;

            // data gets outputed here
        }
    }
}