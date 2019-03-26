<?php
class Attendance
{
	function __construct($i,$s,$se,$p)
	{
		$this->id = $i;
		$this->student = $s;
		$this->session = $se;
		$this->present = $p;
	}

	function __toString()
	{
		return "{\"id\":".$this->id.",\"student\":".$this->student.",\"session\":".$this->session.",\"present\":".$this->present."}";
	}

	function insert($s,$se,$p)
	{
		$query = function($link,$args){
			$bool = false;
			$sql = "INSERT INTO attendance VALUES(NULL,?,?,?)";
			if ($stmt = mysqli_prepare($link,$sql)) {
				if (mysqli_stmt_bind_param($stmt,"sss",$args[0],$args[1],$args[2])) {
					if (mysqli_stmt_execute($stmt)) {
						$bool = true;
					}
				}
				mysqli_stmt_close($stmt);
			}
			return $bool;
		};
		return execute_query($query,array($s,$se,$p));
	}

	function select_by_student_session($s,$se)
	{
		$query = function($link,$args){
			$attendance = false;
			$sql = "SELECT * FROM attendance WHERE student = ? AND session = ?";
			if ($stmt = mysqli_prepare($link,$sql)) {
				if (mysqli_stmt_bind_param($stmt,"ss",$args[0],$args[1])) {
					if (mysqli_stmt_execute($stmt)) {
						if (mysqli_stmt_bind_result($stmt,$i,$s,$se,$p)) {
							if (mysqli_stmt_fetch($stmt)) {
								$attendance = new Attendance($i,$s,$se,$p);
							}
						}
					}
				}
				mysqli_stmt_close($stmt);
			}
			return $attendance;
		};
		return execute_query($query,array($s,$se));
	}

	function select_by_session($s)
	{
		$query = function($link,$args){
			$list = array();
			$sql = "SELECT * FROM attendance WHERE session=?";
			if ($stmt = mysqli_prepare($link,$sql)) {
				if (mysqli_stmt_bind_param($stmt,"s",$args[0])) {
					if (mysqli_stmt_execute($stmt)) {
						if (mysqli_stmt_bind_result($stmt,$i,$s,$se,$p)) {
							while (mysqli_stmt_fetch($stmt)) {
								if ($s = Student::select_by_rut($s)) {
									array_push($list, new Attendance($i,$s,$se,$p));
								}
							}
						}
					}
				}
				mysqli_stmt_close($stmt);
			}
			return $list;
		};
		return new jsonList(execute_query($query,array($s)));
	}

	function update($i,$s,$se,$p)
	{
		$query = function($link,$args){
			$bool = false;
			$sql = "UPDATE attendance SET student=?,session=?,present=? WHERE id=?";
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
		return execute_query($query,array($s,$se,$p,$i));
	}

	function delete($i)
	{
		$query = function($link,$args){
			$bool = false;
			$sql = "DELETE FROM attendance WHERE id=?";
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

