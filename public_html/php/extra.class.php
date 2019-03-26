<?php
class Extra
{
	function __construct($i,$s,$c,$d,$a)
	{
		$this->id = $i;
		$this->student = $s;
		$this->course = $c;
		$this->date = $d;
		$this->active = $a;
	}

	function __toString()
	{
		return "{\"id\":".$this->id.",\"student\":".$this->student.",\"course\":".$this->course.",\"date\":\"".$this->date."\",\"active\":".$this->active."}";
	}

	function insert($s,$c,$d,$a)
	{
		$query = function($link,$args){
			$bool = false;
			$sql = "INSERT INTO extra VALUES(NULL,?,?,?,?)";
			if ($stmt = mysqli_prepare($link,$sql)) {
				if (mysqli_stmt_bind_param($stmt,"ssss",$args[0],$args[1],$args[2],$args[3])) {
					if (mysqli_stmt_execute($stmt)) {
						$bool = true;
					}
				}
				mysqli_stmt_close($stmt);
			}
			return $bool;
		};
		return execute_query($query,array($s,$c,$d,$a));
	}

	function select_by_course_date_active($c,$d,$a)
	{
		$query = function($link,$args){
			$list = array();
			$sql = "SELECT * FROM extra WHERE course=? AND date<=? AND active=?";
			if ($stmt = mysqli_prepare($link,$sql)) {
				if (mysqli_stmt_bind_param($stmt,"sss",$args[0],$args[1],$args[2])) {
					if (mysqli_stmt_execute($stmt)) {
						if (mysqli_stmt_bind_result($stmt,$i,$s,$c,$d,$a)) {
							while (mysqli_stmt_fetch($stmt)) {
								if ($s = Student::select_by_rut($s)) {
									array_push($list, new Extra($i,$s,$c,$d,$a));
								}
							}
						}
					}
				}
				mysqli_stmt_close($stmt);
			}
			return $list;
		};
		return new jsonList(execute_query($query,array($c,$d,$a)));
	}

	function select_by_student_course($s,$c)
	{
		$query = function($link,$args){
			$extra = false;
			$sql = "SELECT * FROM extra WHERE student = ? AND course = ?";
			if ($stmt = mysqli_prepare($link,$sql)) {
				if (mysqli_stmt_bind_param($stmt,"ss",$args[0],$args[1])) {
					if (mysqli_stmt_execute($stmt)) {
						if (mysqli_stmt_bind_result($stmt,$i,$s,$c,$d,$a)) {
							if (mysqli_stmt_fetch($stmt)) {
								$extra = new Enrolled($i,$s,$c,$d,$a);
							}
						}
					}
				}
				mysqli_stmt_close($stmt);
			}
			return $extra;
		};
		return execute_query($query,array($s,$c));
	}

	function update($i,$s,$c,$d,$a)
	{
		$query = function($link,$args){
			$bool = false;
			$sql = "UPDATE extra SET student=?,course=?,date=?,active=? WHERE id=?";
			if ($stmt = mysqli_prepare($link,$sql)) {
				if (mysqli_stmt_bind_param($stmt,"sssss",$args[0],$args[1],$args[2],$args[3],$args[4])) {
					if (mysqli_stmt_execute($stmt)) {
						$bool = true;
					}
				}
				mysqli_stmt_close($stmt);
			}
			return $bool;
		};
		return execute_query($query,array($s,$c,$d,$a,$i));
	}

	function delete($i)
	{
		$query = function($link,$args){
			$bool = false;
			$sql = "DELETE FROM extra WHERE id=?";
			if ($stmt = mysqli_prepare($link,$sql)) {
				if (mysqli_stmt_bind_param($stmt,"s",$args[0])) {
					if (mysqli_stmt_execute($stmt)) {
						$bool = true;
					}
				}
				mysqli_stmt_close($stmt);
			}
			return $bool;
		};
		return execute_query($query,array($i));
	}
}
?>

