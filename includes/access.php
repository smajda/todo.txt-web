<?php
/* Simple Authentication
 *
 * based on... 
 * http://www.phpnerds.com/article/using-cookies-in-php/2
 * and http://www.legend.ws/blog/tips-tricks/php-authentication-login-script/
 *
 * */

function displayform($error) {
global $todoUrl;
echo <<<HTML
<html>
    <head>
        <meta http-equiv="Content-type" value="text/html; charset=utf-8">
        <title>todo.txt login</title>
        <meta name="viewport" content="initial-scale=1.0,maximum-scale=1,user-scalable=0" />
		<link media="screen" href="stylesheet.css" rel="stylesheet" type="text/css">
		<link media="handheld" href="handheld.css" rel="stylesheet" type="text/css">

    </head>
    <body>

    <div id="container">
    <div id="top">
        <h1><a href="$todoUrl">todo.txt</a></h1>
    </div>

HTML;

    if($error) 
        echo "<span class=\"auth-message\">Wrong credentials.</span>";
    if(isset($_GET['logout'])) 
        echo "<span class=\"auth-message\">You have logged out.</span>";

echo <<<HTML
    <div id="login-box"> 

        <form name="login" id="login" action="${todoUrl}" method="post">
                <label>username:</label><br />
                <input autocapitalize="off" autocorrect="off" 
                       class="wide" type='text' name='input_user' /><br />
                <label>password:</label><br />
                <input class="wide" type='password' name='input_password' /><br />
                <input type="checkbox" name="rememberme" id="rememberme" value="1">
                <label>remember me?</label><br />
                <input class="wide" type='Submit' value='Login&raquo;' name='loginbutton'>
        </form>
    </div>

    <div id="footer">
    </div>

    </div>
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
            header("Location:".$todoURL);

        } else {
            displayform(1);
        }

    } else {
        displayform(0);
    }
}

?>
