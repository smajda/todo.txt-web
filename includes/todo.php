<?php

// process $_GET
function get_cmd($_GET, $id='cmd') {
    if($cmd=$_GET[$id]) {
        $cmd=rawurldecode($cmd);
        $cmd=stripslashes($cmd);
    }
    return $cmd;
}

// checks if a command is an ls command or not
function ls_check($cmd) {
    // array of actions you do *not* want to follow
    // with a rerun of previous ls
    // (mostly this means the 'ls' commands, hence the name)
    $lsCmds=array(
        '',
        'ls','list',
        'lsa','listall',
        'lf','listfile',
        'listpri','lsp',
        'lsprj','listproj'
    );

    // split previous command into array, so we can...
    $cmd=split(' ', $cmd);

    // see if the action is in the list of actions
    // that don't get a rerun of previous command
    if(in_array($cmd[0], $lsCmds)) {
        return true;
    } else {
        return false;
    }
}

// sets cmd2 input to most recent ls
function get_cmd2($cmd='',$cmd2='') {
    if(ls_check($cmd)) {
        return $cmd;
    } else {
        return $cmd2;
    }
}

// runs todo.sh command and prints list
function run_todo($cmd) {
    global $todoCmd;

    if(!empty($cmd)) { 
       echo '<div id="results-note">Result of: ';
       echo  "<code>".$cmd."</code></div>\n"; 
    } 

    $cmd = escapeshellcmd($todoCmd.' '.$cmd);
    exec($cmd, $results);

    $output  = "<ul>\n";
    foreach($results as $task) {
        // make numbers into links for js
        $task = preg_replace(
                    '/(^[0-9]+)/', // numbers at start of task
                    '<a class="todo-number" href="javascript:void(0);">$1</a>',
                    $task
            );
        // make projects and contexts into links for js
        $task = preg_replace(
                    '/((@|\+)[\S]+)/', // numbers at start of task
                    '<a class="todo-tag" href="javascript:void(0);">$1</a>',
                    $task
            );
        // linkify external links
        $task = preg_replace(
                    '@(https?://([-\w\.]+)+(:\d+)?(/([\w/_\.]*(\S+)?)?)?[^.\ ,:)])@',
                    '<a target="blank" class="todo-extlink" href="$1">$1</a>', 
                    $task
            );
        $output .= "\t\t<li>".$task."</li>\n";
    }
    $output .= "\t</ul>\n";

    echo $output;
}


function logout() {
    global $todoUrl, $user;
    // delete cookie
    setcookie($user,"todotxt-web", time()-3600);
    session_unset();
    echo "You have logged out. <a href=\"".$todoUrl."\">Login</a>.";
    exit();
}

?>
