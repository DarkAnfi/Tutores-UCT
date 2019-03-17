<?php
session_start();
include_once 'conf.php';
include_once 'mysql_connector.php';
include_once 'response.class.php';
include_once 'error.class.php';
include_once 'list.class.php';

include_once 'login.class.php';
include_once 'data.class.php';
include_once 'access.class.php';
include_once 'service.class.php';
include_once 'tutor.class.php';
include_once 'course.class.php';

include_once "crud.php";
include_once 'error_handler.php';
include_once "actions.php";

switch ($_POST["type"]) {
	case 'session':
		session();
		break;
	case 'login':
		login($_POST["email"],$_POST["password"]);
		break;
	case 'logout':
		logout();
		break;
	case 'data_select_by_id':
		data_select_by_id($_POST["id"]);
		break;
	case 'data_update':
		data_update($_POST["id"],$_POST["name"],$_POST["lastname"],$_POST["phone"]);
		break;
	case 'service_select_by_level_by_user':
		service_select_by_level_by_user($_POST["id"]);
		break;
	case 'course_select_by_tutor_by_user_type':
		course_select_by_tutor_by_user_type($_POST["id"],$_POST["course_type"],YEAR,SEMESTER);
		break;
	case 'course_select_by_id':
		course_select_by_id($_POST["id"]);
		break;
	default:
		default_action();
		break;
}

die(new Response("Error",Error::getInstance(0)));

?>