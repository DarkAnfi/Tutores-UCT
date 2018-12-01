<?php

include_once 'conf.php';

include_once 'response.class.php';
include_once 'error.class.php';
include_once 'user.class.php';
include_once 'list.class.php';
include_once 'tutoria.class.php';
include_once 'session.class.php';
include_once 'inscrito.class.php';
include_once 'asistencia.class.php';
include_once 'estudiante.class.php';

session_start();
//include_once 'error_handler.php';
include_once "actions.php";

switch ($_POST["type"]) {
	case "session_get":
		session_get();
		break;
	case "login":
		login($_POST["user"],$_POST["pass"]);
		break;
	case "logout":
		logout();
		break;
	case "tutoria_read":
		tutoria_read();
		break;
	case "tutoria_update":
		tutoria_update();
		break;
	case 'tutoria_read_id':
		tutoria_read_id($_POST["id"]);
		break;
	case 'sessions_read_id':
		sessions_read_id($_POST["id"]);
		break;
	case 'asistencia_read_sesion':
		asistencia_read_sesion($_POST["id"]);
		break;
	case 'session_add_id':
		session_add_id($_POST["id"],$_POST["date"]);
		break;
	case 'session_update':
		session_update($_POST["id"],$_POST["lugar"],$_POST["contenidos"],$_POST["estudiantes"],$_POST["observaciones"]);
		break;
	default:
		default_action();
		break;
}

die(new Response("Error",Error::getInstance(0)));

?>

