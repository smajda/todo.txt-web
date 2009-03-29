<?php
/* Simple Authentication
 * 
 * You could just use .htaccess/.htpasswd but
 * but  Mobile Safari won't save these passwords
 * so we'll use a simple login form with cookies.
 * 
 * modified from: 
 * http://www.legend.ws/blog/tips-tricks/php-authentication-login-script/
*/

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
    <form id="login" action="" method="post">
            <label>username:</label>
            <input type='text' name='input_user' /><br />
            <label>password:</label>
            <input type='password' name='input_password' /><br />
            <input type='Submit' value='Login&raquo;' name='loginbutton'>
    </form>

    </body>
</html>
HTML;
exit;
}


session_start();
    

if(!$_SESSION['authenticated']) {

    if (isset($_COOKIE[$user])) {
       $_SESSION['authenticated'] = 1;
    }  elseif($_POST['loginbutton']) {
        $inputuser = $_POST['input_user'];
        $inputpassword = $_POST['input_password'];

        if(!strcmp($inputuser ,$user) && !strcmp($inputpassword,$password)) {
            $expire=time()+60*60*24*30;
            setcookie($user,"todotxt-web",$expire);
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
