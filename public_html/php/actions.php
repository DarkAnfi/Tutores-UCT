<?php
require_once "crud.php";

function session_get()
{
	if (isset($_SESSION["user"])) {
		$user = $_SESSION["user"];
		die(new Response("User",$user));
	} else {
		die(new Response("Error",Error::getInstance(2)));
	}
}

function login($u,$p)
{
	if (isset($_SESSION["user"])) {
		$user = $_SESSION["user"];
		die(new Response("User",$user));
	} elseif ($user = crud_get_user(array($u,$p))) {
		$_SESSION["user"] = $user."";
		die(new Response("User",$user));
	} else {
		die(new Response("Error",Error::getInstance(3)));
	}
}

function logout()
{
	if (isset($_SESSION["user"])) {
		session_unset();
		die(new Response("bool",true));
	} else {
		die(new Response("Error",Error::getInstance(2)));
	}
}

function tutoria_read()
{
	if (isset($_SESSION["user"])) {
		$user = User::fromJSON($_SESSION["user"]);
		$list = crud_get_tutoria_tutor(array($user->user));
		die(new Response("List(Tutoria)",$list));
	} else {
		die(new Response("Error",Error::getInstance(2)));
	}
}

function tutoria_update()
{
	if (isset($_SESSION["user"])) {
		$user = User::fromJSON($_SESSION["user"]);
		if ($user->level >= 3) {
			crud_update_tutoria();
			die(new Response("bool",true));
		} else {
			die(new Response("Error",Error::getInstance(4)));
		}
	} else {
		die(new Response("Error",Error::getInstance(2)));
	}
}

function tutoria_read_id($i)
{
	if (isset($_SESSION["user"])) {
		$tuto = crud_get_tutoria_id(array($i));
		$user = User::fromJSON($_SESSION["user"]);
		if ($user->user == $tuto->tutor->user or $user->level >= 4 or $user->user == $tuto->profesional->user) {
			die(new Response("Tutoria",$tuto));
		} else {
			die(new Response("Error",Error::getInstance(4)));
		}
	} else {
		die(new Response("Error",Error::getInstance(2)));
	}
}

function sessions_read_id($i)
{
	if (isset($_SESSION["user"])) {
		$tuto = crud_get_tutoria_id(array($i));
		$user = User::fromJSON($_SESSION["user"]);
		if ($user->user == $tuto->tutor->user or $user->level >= 4 or $user->user == $tuto->profesional->user) {
			$list = crud_get_session_tutoria(array($tuto->id));
			die(new Response("List(Session)",$list));
		} else {
			die(new Response("Error",Error::getInstance(4)));
		}
	} else {
		die(new Response("Error",Error::getInstance(2)));
	}
}

function inscrito_read_id($i)
{
	if (isset($_SESSION["user"])) {
		$tuto = crud_get_tutoria_id(array($i));
		$user = User::fromJSON($_SESSION["user"]);
		if ($user->user == $tuto->tutor->user or $user->level >= 4 or $user->user == $tuto->profesional->user) {
			$list = crud_get_inscrito_tutoria(array($tuto->id));
			die(new Response("List(Inscrito)",$list));
		} else {
			die(new Response("Error",Error::getInstance(4)));
		}
	} else {
		die(new Response("Error",Error::getInstance(2)));
	}
}

function session_add_id($i,$d)
{
	if(isset($_SESSION["user"])) {
		$tuto = crud_get_tutoria_id(array($i));
		$user = User::fromJSON($_SESSION["user"]);
		if ($user->user == $tuto->tutor->user or $user->level >= 4 or $user->user == $tuto->profesional->user) {
			crud_add_session(array($d,$i));
			die(new Response("bool",true));
		} else {
			die(new Response("Error",Error::getInstance(4)));
		}
	} else {
		die(new Response("Error",Error::getInstance(2)));
	}
}

function asistencia_read_sesion($i)
{
	if (isset($_SESSION["user"])) {
		if ($sesion = crud_get_sesion_id(array($i))) {
			$tuto = $sesion->tutoria;
			$user = User::fromJSON($_SESSION["user"]);
			if ($user->user == $tuto->tutor->user or $user->level >= 4 or $user->user == $tuto->profesional->user) {
				$list = crud_get_asistencia_sesion(array($sesion->id));
				die(new Response("List(Asistencia)",$list));
			} else {
				die(new Response("Error",Error::getInstance(4)));
			}
		} else {
			die(new Response("Error",Error::getInstance(0)));
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

