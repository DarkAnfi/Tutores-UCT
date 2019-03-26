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
					die(new Response("Error",Error::getInstance(0)));
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
			die(new Response("Error",Error::getInstance(0)));
		}
	} else {
		die(new Response("Error",Error::getInstance(2)));
	}
}

function session_select_by_course($c)
{
	if (isset($_SESSION["login"])) {
		$list = Session::select_by_course($c);
		die(new Response("List(Session)",$list));
	} else {
		die(new Response("Error",Error::getInstance(2)));
	}
}

function enrolled_select_by_course_session_active($c,$s,$a)
{
	if (isset($_SESSION["login"])) {
		if ($session = Session::select_by_id($s)) {
			$list = Enrolled::select_by_course_date_active($c,$session->date,$a);
			die(new Response("List(Enrolled)",$list));
		} else {
			die(new Response("Error",Error::getInstance(0)));
		}
	} else {
		die(new Response("Error",Error::getInstance(2)));
	}
}

function extra_select_by_course_session_active($c,$s,$a)
{
	if (isset($_SESSION["login"])) {
		if ($session = Session::select_by_id($s)) {
			$list = Extra::select_by_course_date_active($c,$session->date,$a);
			die(new Response("List(Extra)",$list));
		} else {
			die(new Response("Error",Error::getInstance(0)));
		}
	} else {
		die(new Response("Error",Error::getInstance(2)));
	}
}

function attendance_select_by_session($s)
{
	if (isset($_SESSION["login"])) {
		$list = Attendance::select_by_session($s);
		die(new Response("List(Attendance)",$list));
	} else {
		die(new Response("Error",Error::getInstance(2)));
	}
}

function student_select_by_rut($r)
{
	if (isset($_SESSION["login"])) {
		if ($student = Student::select_by_rut($r)) {
			die(new Response("Student",$student));
		} else {
			die(new Response("Error",Error::getInstance(0)));
		}
	} else {
		die(new Response("Error",Error::getInstance(2)));
	}
}

function attendance_insert_list($l,$s)
{
	if (isset($_SESSION["login"])) {
		$list = split(",", $l);
		foreach ($list as $reg) {
			list($student,$present) = split("-",$reg);
			if ($attendance = Attendance::select_by_student_session($student,$s)) {
				Attendance::update($attendance->id,$attendance->student,$attendance->session,$present);
			} else {
				Attendance::insert($student,$s,$present);
			}
			if ($session = Session::select_by_id($s)) {
				$no_enrolled = false;
				if ($enrolled = Enrolled::select_by_student_course($student,$session->course)) {
					if ($enrolled->active == "0") {
						$no_enrolled = true;
					}
				} else {
					$no_enrolled = true;
				}
				if ($no_enrolled) {
					if ($extra = Extra::select_by_student_course($student,$session->course)) {
						Extra::update($extra->id,$extra->student,$extra->course,$extra->date,"1");
					} else {
						Extra::insert($student,$session->course,$session->date,"1");
					}
				}
				$date = false;
				if ($extra = Extra::select_by_student_course($student,$session->course)) {
					if ($enrolled) {
						if (DateTime::createFromFormat('Y-m-d', $enrolled->date) < DateTime::createFromFormat('Y-m-d', $extra->date)) {
							$date = $enrolled->date;
						} else {
							$date = $extra->date;
						}
					} else {
						$date = $extra->date;
					}
				} else {
					if ($enrolled) {
						$date = $enrolled->date;
					}
				}
				if ($date) {
					if (DateTime::createFromFormat('Y-m-d', $date) < DateTime::createFromFormat('Y-m-d', $session->date)) {
						$list2 = Session::select_by_course_date_between($session->course,$date,$session->date);
					} else {
						$list2 = Session::select_by_course_date_between($session->course,$session->date,$date);
					}
					foreach ($list2->content as $session2) {
						if (!($attendance = Attendance::select_by_student_session($student,$session2->id))) {
							Attendance::insert($student,$session2->id,"0");
						}
					}
				}
				if ($extra = Extra::select_by_student_course($student,$session->course)) {
					if (DateTime::createFromFormat('Y-m-d', $extra->date) > DateTime::createFromFormat('Y-m-d', $session->date)) {
						Extra::update($extra->id,$extra->student,$extra->course,$session->date,$extra->active);
					} else {
						Extra::update($extra->id,$student,$session->course,$extra->date,$extra->active);
					}
				}
			}
		}
		die(new Response("bool","true"));
	} else {
		die(new Response("Error",Error::getInstance(2)));
	}
}

function extra_remove_active_from_course($s,$c)
{
	if (isset($_SESSION["login"])) {
		if ($extra = Extra::select_by_student_course($s,$c)) {
			$bool = Extra::update($extra->id,$extra->student,$extra->course,$extra->date,"0");
			die(new Response("bool",$bool));
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

