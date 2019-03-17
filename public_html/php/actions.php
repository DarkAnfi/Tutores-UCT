<?php

function session()
{
	if (isset($_SESSION["login"])) {
		$login = $_SESSION["login"];
		die(new Response("Login",$login));
	} else {
		die(new Response("Error",Error::getInstance(2)));
	}
}

function login($e,$p)
{
	if (isset($_SESSION["login"])) {
		$login = $_SESSION["login"];
		die(new Response("Login",$login));
	} elseif ($login = Login::select_by_email_password($e,$p)) {
		$_SESSION["login"] = $login."";
		die(new Response("Login",$login));
	} else {
		die(new Response("Error",Error::getInstance(3)));
	}
}

function logout()
{
	if (isset($_SESSION["login"])) {
		session_unset();
		die(new Response("bool","true"));
	} else {
		die(new Response("Error",Error::getInstance(2)));
	}
}

function data_select_by_id()
{
	if (isset($_SESSION["login"])) {
		$login = Login::fromJSON($_SESSION["login"]);
		if ($data = Data::select_by_id($login->id)) {
			die(new Response("Data",$data));
		} else {
			die(new Response("Error",Error::getInstance(0)));
		}
	} else {
		die(new Response("Error",Error::getInstance(2)));
	}
}

function data_update($i,$n,$l,$p)
{
	if (isset($_SESSION["login"])) {
		$login = Login::fromJSON($_SESSION["login"]);
		if ($login->id == $i) {
			$bool = Data::update($i,$n,$l,$p);
			die(new Response("bool",$bool));
		} else {
			die(new Response("Error",Error::getInstance(4)));
		}
	} else {
		die(new Response("Error",Error::getInstance(2)));
	}
}

function service_select_by_level_by_user($i)
{
	if (isset($_SESSION["login"])) {
		$login = Login::fromJSON($_SESSION["login"]);
		if ($login->id == $i) {
			if ($access = Access::select_by_id($login->id)) {
				$list = Service::select_by_level($access->level);
				die(new Response("List(Service)",$list));
			} else {
				die(new Response("Error",Error::getInstance(4)));
			}
		} else {
			die(new Response("Error",Error::getInstance(4)));
		}
	} else {
		die(new Response("Error",Error::getInstance(2)));
	}
}

function course_select_by_tutor_by_user_type($i,$t,$y,$s)
{
	if (isset($_SESSION["login"])) {
		$login = Login::fromJSON($_SESSION["login"]);
		if ($access = Access::select_by_id($login->id)) {
			if ($login->id == $i or $access->level >= 2) {
				if ($tutor = Tutor::select_by_data($i)) {
					$list = Course::select_by_tutor_type_year_semester($tutor->id,$t,$y,$s);
					die(new Response("List(Course)",$list));	
				} else {
					die(new Response("Error",Error::getInstance(3)));
				}
			} else {
				die(new Response("Error",Error::getInstance(4)));
			}
		} else {
			die(new Response("Error",Error::getInstance(4)));
		}
	} else {
		die(new Response("Error",Error::getInstance(2)));
	}
}

function course_select_by_id($i)
{
	if (isset($_SESSION["login"])) {
		if ($course = Course::select_by_id($i)) {
			die(new Response("Course",$course));	
		} else {
			die(new Response("Error",Error::getInstance(3)));
		}
	} else {
		die(new Response("Error",Error::getInstance(2)));
	}
}

function default_action()
{
	die(new Response("Error",Error::getInstance(5)));
}

?>

