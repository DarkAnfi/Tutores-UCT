<?php

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
	} elseif ($user = User::select_by_user_pass($u,$p)) {
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
		die(new Response("bool","true"));
	} else {
		die(new Response("Error",Error::getInstance(2)));
	}
}

function tutoria_read()
{
	if (isset($_SESSION["user"])) {
		$user = User::fromJSON($_SESSION["user"]);
		$list = Tutoria::select_by_tutor($user->user);
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
		$tutoria = Tutoria::select_by_id($i);
		$user = User::fromJSON($_SESSION["user"]);
		if ($user->user == $tutoria->tutor->user or $user->level >= 4 or $user->user == $tutoria->profesional->user) {
			die(new Response("Tutoria",$tutoria));
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
		$tutoria = Tutoria::select_by_id($i);
		$user = User::fromJSON($_SESSION["user"]);
		if ($user->user == $tutoria->tutor->user or $user->level >= 4 or $user->user == $tutoria->profesional->user) {
			$list = Session::select_by_tutoria($tutoria->id);
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
		$tutoria = Tutoria::select_by_id($i);
		$user = User::fromJSON($_SESSION["user"]);
		if ($user->user == $tutoria->tutor->user or $user->level >= 4 or $user->user == $tutoria->profesional->user) {
			$list = Inscrito::select_by_tutoria($tutoria->id);
			die(new Response("List(Inscrito)",$list));
		} else {
			die(new Response("Error",Error::getInstance(4)));
		}
	} else {
		die(new Response("Error",Error::getInstance(2)));
	}
}

function session_add_id($t,$f)
{
	if(isset($_SESSION["user"])) {
		$tutoria = Tutoria::select_by_id($t);
		$user = User::fromJSON($_SESSION["user"]);
		if ($user->user == $tutoria->tutor->user or $user->level >= 4 or $user->user == $tutoria->profesional->user) {
			$bool = false;
			if (Session::insert($f,'','','',$tutoria->id)) {
				if ($sesion = Session::select_by_fecha_tutoria($f,$tutoria->id)) {
					if ($list = Inscrito::select_by_tutoria($sesion->tutoria->id)) {
						for ($i=0; $i < count($list->content); $i++) { 
							$inscrito = $list->content[$i];
							if (!($bool = Asistencia::insert($inscrito->estudiante->rut,'0',$sesion->id))) {
								break;
							}
						}
					}
				}
			}
			if ($bool) {
				die(new Response("bool","true"));
			} else {
				die(new Response("bool","false"));
			}
			
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
		if ($sesion = Session::select_by_id($i)) {
			$tutoria = $sesion->tutoria;
			$user = User::fromJSON($_SESSION["user"]);
			if ($user->user == $tutoria->tutor->user or $user->level >= 4 or $user->user == $tutoria->profesional->user) {
				$list = Asistencia::select_by_sesion($sesion->id);
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

function session_update($i,$l,$c,$e,$o)
{
	if (isset($_SESSION["user"])) {
		if ($sesion =Session::select_by_id($i)) {
			$tutoria = $sesion->tutoria;
			$user = User::fromJSON($_SESSION["user"]);
			if ($user->user == $tutoria->tutor->user or $user->level >= 4 or $user->user == $tutoria->profesional->user) {
				$bool = false;
				if ($bool = Session::update($sesion->id,$sesion->fecha,$l,$c,$o,$sesion->tutoria->id)) {
					if ($e != "") {
						$list = split(",", $e);
						for ($i=0; $i < count($list); $i++) {
							$asistencia = split("-",$list[$i]);
							$presente = $asistencia[1];
							if ($asistencia = Asistencia::select_by_id($asistencia[0])) {
								if ($presente=="true") {
									if (!($bool = Asistencia::update($asistencia->id,$asistencia->estudiante->rut,'1',$asistencia->sesion->id))) {
										break;
									}
								} else {
									if (!($bool = Asistencia::update($asistencia->id,$asistencia->estudiante->rut,'0',$asistencia->sesion->id))) {
										break;
									}
								}
							}
						}
					}
				}
				if ($bool) {
					die(new Response("bool","true"));
				} else {
					die(new Response("bool","false"));
				}
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

function estudiante_read_rut($r)
{
	if (isset($_SESSION["user"])) {
		if ($estudiante = Estudiante::select_by_rut($r)) {
			die(new Response("Estudiante",$estudiante));
		} else {
			die(new Response("Error",Error::getInstance(0)));
		}
	} else {
		die(new Response("Error",Error::getInstance(2)));
	}
}

function asistencia_add_sesion($r,$s)
{
	if (isset($_SESSION["user"])) {
		if ($sesion = Session::select_by_id($s)) {
			$tutoria = $sesion->tutoria;
			$user = User::fromJSON($_SESSION["user"]);
			if ($user->user == $tutoria->tutor->user or $user->level >= 4 or $user->user == $tutoria->profesional->user) {
				$bool = false;
				if ($estudiante = Estudiante::select_by_rut($r)) {
					if (!(Asistencia::select_by_estudiante_sesion($estudiante->rut,$sesion->id))) {
						if (!(Inscrito::select_by_estudiante_tutoria($estudiante->rut,$sesion->tutoria->id))) {
							Inscrito::insert($estudiante->rut,$sesion->tutoria->id);
						}
						$bool = Asistencia::insert($estudiante->rut,'1',$sesion->id);
					}
				}
				if ($bool) {
					die(new Response("bool","true"));
				} else {
					die(new Response("bool","false"));
				}
				
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

