<?php

function execute_query($callback,$args)
{
	$link = mysqli_connect(HOST,USER,PASS,MYDB);
	mysqli_query($link, "SET NAMES 'utf8'");
	if(!$link) {
		die(new Response("Error",new Error(6,mysqli_connect_error())));
	}
	$out = $callback($link,$args);
	mysqli_close($link);
	return $out;
}

?>