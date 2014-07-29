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
    ajax.open("POST", "checkNames.php", true);
    ajax.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    ajax.send('place=' + str);
    // ajax process data
    ajax.onreadystatechange = function() {
        if (ajax.readyState == 4 && ajax.status == 200) {
            data = ajax.responseText;
            alert(data);
            // data gets outputed here
        }
    }
}