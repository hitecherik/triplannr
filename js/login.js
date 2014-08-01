var main = function(){
    $('input').attr('spellcheck', 'false');
    $('input').attr('autocomplete', 'off');
	$('.user_form').on('submit', function(e) {
        e.preventDefault();
		if($("html").attr("id") == 'login_page') {
			loginPerson();
		} else if($("html").attr("id") == 'signup_page') {
			signupPerson();
		}
	});
}



var loginPerson = function() {
	var ajax, data, username = document.getElementById('username').value, password = document.getElementById('password').value;
    if (window.XMLHttpRequest) {
        // new support
        ajax = new XMLHttpRequest();
    } else {
        // old support
        ajax = new ActiveXObject("Microsoft.XMLHTTP");
    }
    // create request
    ajax.open("POST", "login-person.php", true);
    ajax.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    ajax.send('type=login&username=' + username + '&password=' + CryptoJS.SHA3(password));
    // ajax process data
    ajax.onreadystatechange = function() {
        if (ajax.readyState == 4 && ajax.status == 200) {
            data = ajax.responseText;
            if(data == 'success') {
                window.location = "../index.php";
            } else {
                alert('Error: please try again.');
            }
            // data gets outputed here
        }
    }
    return false;
}

var clearSpaces = function(str) {
    while(str.substring(0, 1) == ' ') {
        str = str.substring(1);
    }
    while(str.substring(str.length - 1) == ' ') {
        str = str.substring(0, str.length - 1);
    }
    while(str.match('  ')) {
        str = str.replace('  ', ' ');
    }
    return str;
}

var signupPerson = function() {
	var ajax, data, username = document.getElementById('username').value, password = document.getElementById('password').value, name = clearSpaces(document.getElementById('firstname').value + ' ' + document.getElementById('surname').value), passwordRtn = checkPassword(password);
    if (!passwordRtn && username.replace(' ', '').length && username.length > 4) {
        if (window.XMLHttpRequest) {
            // new support
            ajax = new XMLHttpRequest();
        } else {
            // old support
            ajax = new ActiveXObject("Microsoft.XMLHTTP");
        }
        // create request
        ajax.open("POST", "login-person.php", true);
        ajax.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        ajax.send('type=insert&username=' + username + '&name=' + name + '&password=' + CryptoJS.SHA3(password));
        // ajax process data
        ajax.onreadystatechange = function() {
            if (ajax.readyState == 4 && ajax.status == 200) {
                data = ajax.responseText;
                if(data == 'success') {
                    window.location = "../index.php";
                } else if (data.substring(0, 9) == 'Duplicate') {
                    alert('User with the username ' + username + ' already exists');
                } else {
                    alert('This username and password combination');
                }
                // data gets outputed here
            }
        }
    } else {
        switch (passwordRtn) {
            case '1':
                alert('Your password must contain at least one digit, one lowercase letter and one uppercase letter');
                break;
            case '2':
                alert('Your password needs to be at least 6 characters long');
                break;
            case '3':
                alert('Your password is too easy to guess');
                break;
        }
    }
    return false;
}

function checkPassword(password) {
    var commonPasswords = ["123456","password","12345678","qwerty","abc123","123456789","111111","1234567","iloveyou","adobe123","123123","Admin","1234567890","letmein","photoshop","1234","monkey","shadow","sunshine","12345","password1","princess","azerty","trustno1","000000"], error = '1';
    
    // checks for existance of password or required length of password
    if (password.length < 6) {
        error = '2';
    }
    
    // checks if the password is a common password
    if (commonPasswords.indexOf(password) != -1) {
        error = '3';
    }
    
    // checks if the password has at least one digit, one lowercase letter and one uppercase letter
    if (password.match(/\d/) && password.match(/[A-Z]/) && password.match(/[a-z]/) && !password.match(/,/) && error == '1') {
        return false;
    }
    
    return error;
}

/*
    Errors:
        1: Not contain required characters
        2: not long enough
        3: Common Password
*/

$(document).ready(main);