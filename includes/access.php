<?php
/* Simple Authentication
 *
 * based on... 
 * http://www.phpnerds.com/article/using-cookies-in-php/2
 * and http://www.legend.ws/blog/tips-tricks/php-authentication-login-script/
 *
 * */

function displayform($error) {
echo <<<HTML
<html>
    <head>
        <title>todotxt login</title>
        <meta name="viewport" content="width=480" />
		<link media="screen" href="stylesheet.css" rel="stylesheet" type="text/css">
		<link media="handheld" href="handset.css" rel="stylesheet" type="text/css">
        <style type="text/css">
        body {margin: 10px;}
        form#login input {
            margin-bottom: 7px;
        }
        </style>
    </head>
    <body>

HTML;

    if($error) echo "<p><b>Wrong credentials.</b></p>";

echo <<<HTML
    <form name="login" id="login" action="" method="post">
            <label>username:</label>
            <input type='text' name='input_user' /><br />
            <label>password:</label>
            <input type='password' name='input_password' /><br />
            <label>remember me?</label>
            <input type="checkbox" name="rememberme" value="1"><br />
            <input type='Submit' value='Login&raquo;' name='loginbutton'>
    </form>

    </body>
</html>
HTML;
exit;
}

session_start();
    
if(!$_SESSION['authenticated']) {

    if (isset($_COOKIE['todotxt-user']) && isset($_COOKIE['todotxt-pass'])) {

        if (($_COOKIE['todotxt-user'] == $user) && ($_COOKIE['todotxt-pass'] == md5($password))) {
            $_SESSION['authenticated'] = 1;
            header("Location:".$_SERVER[PHP_SELF]);
        } else {
            displayform(1);
        }

    }  elseif($_POST['loginbutton']) {

        if (($_POST['input_user'] == $user) && ($_POST['input_password'] == $password)) {

            if (isset($_POST['rememberme'])) {
                /* set cookie to last 1 month */
                $expire=time()+60*60*24*30;
                setcookie('todotxt-user', $_POST['input_user'], $expire);
                setcookie('todotxt-pass', md5($_POST['input_password']), $expire);
            } 
            $_SESSION['authenticated'] = 1;
            header("Location:".$_SERVER[PHP_SELF]);

        } else {
            displayform(1);
        }

    } else {
        displayform(0);
    }
}

?>
