<?php 
require_once('includes/config.php');
require_once('includes/access.php');
require_once('includes/todo.php');
if($_GET['logout'] == 'true') {logout();}
$cmd = get_cmd($_POST);
$cmd2 = get_cmd($_POST, 'cmd2');
?><!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 TRANSITIONAL//EN">
<html>
<head>
        <meta http-equiv="Content-type" value="text/html; charset=utf-8">
		<title>todo.txt</title>

       <meta name="viewport" content="initial-scale=1.0,maximum-scale=1,user-scalable=0" />
        <?php if($iphoneWebApp == 'yes'){ ?>
        <meta name="apple-mobile-web-app-capable" content="yes" />
        <?php } ?>
       <link rel="apple-touch-icon" href="todotxt_logo.png"/>

		<link media="screen" href="stylesheet.css" rel="stylesheet" type="text/css">
		<link media="handheld" href="handheld.css" rel="stylesheet" type="text/css">

        <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.min.js"></script>
        <script type="text/javascript" src="todo.js">
        </script>

</head>

<body>
<div id="container">

    <div id="top">

        <h1><a href="<?php echo $todoUrl; ?>">todo.txt</a></h1>
                    
        <form id="todo" name="todo" action="<?php echo $todoUrl; ?>" method="POST">
        <input autocapitalize="off" autocorrect="off" 
               type="text" id="cmd" name="cmd" 
               value="<?php if(isset($cmd)){echo $cmd." ";} ?>" /><br />
        <input type="hidden" id="cmd2" name="cmd2"
               value="<?php echo get_cmd2($cmd,$cmd2); ?>" />
        <input type="submit" id="sub" value="Submit" />
        </form>
    </div>

    <div id="output">
        <?php 
            // run todo.sh and print list
            run_todo($cmd);

            // rerun the previous list command if current command is not a list
            if(isset($cmd2) && !ls_check($cmd)){
                run_todo($cmd2);
            }   
        ?>
    </div>

    <div id="footer">
        <a href="<?php echo $todoUrl; ?>?logout=true">Logout</a>
    </div>

</div>
</body>
</html>
