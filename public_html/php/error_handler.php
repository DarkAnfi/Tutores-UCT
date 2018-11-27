<?php 

set_error_handler(function($errno,$errstr){
    if (!(error_reporting() & $errno)) { return; }
    die(new Response("Error",new Error($errno,$errstr)));
    return true;
});

if (!isset($_POST["type"])) {
    die(new Response("Error",Error::getInstance(1)));
}

 ?>