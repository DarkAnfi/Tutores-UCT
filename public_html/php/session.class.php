<?php
class Session
{
	function __construct($i,$c,$d,$s,$e)
	{
		$this->id = $i;
		$this->course = $c;
		$this->date = $d;
		$this->start = $s;
		$this->end = $e;
	}

	function __toString()
	{
		return "{\"id\":".$this->id.",\"course\":".$this->course.",\"date\":\"".$this->date."\",\"start\":\"".$this->start."\",\"end\":\"".$this->end."\"}";
	}

	function insert($c,$d,$s,$e)
	{
		$query = function($link,$args){
			$bool = false;
			$sql = "INSERT INTO session VALUES(NULL,?,?,?,?)";
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
		return execute_query($query,array($c,$d,$s,$e));
	}

	function select_by_id($i)
	{
		$query = function($link,$args){
			$session = false;
			$sql = "SELECT * FROM session WHERE id=?";
			if ($stmt = mysqli_prepare($link,$sql)) {
				if (mysqli_stmt_bind_param($stmt,"s",$args[0])) {
					if (mysqli_stmt_execute($stmt)) {
						if (mysqli_stmt_bind_result($stmt,$i,$c,$d,$s,$e)) {
							if (mysqli_stmt_fetch($stmt)) {
								$session = new Session($i,$c,$d,$s,$e);
							}
						}
					}
				}
				mysqli_stmt_close($stmt);
			}
			return $session;
		};
		return execute_query($query,array($i));
	}

	function select_by_course($c)
	{
		$query = function($link,$args){
			$list = array();
			$sql = "SELECT * FROM session WHERE course = ? ORDER BY date ASC";
			if ($stmt = mysqli_prepare($link,$sql)) {
				if (mysqli_stmt_bind_param($stmt,"s",$args[0])) {
					if (mysqli_stmt_execute($stmt)) {
						if (mysqli_stmt_bind_result($stmt,$i,$c,$d,$s,$e)) {
							while (mysqli_stmt_fetch($stmt)) {
								array_push($list, new Session($i,$c,$d,$s,$e));
							}
						}
					}
				}
				mysqli_stmt_close($stmt);
			}
			return $list;
		};
		return new jsonList(execute_query($query,array($c)));
	}

	function select_by_course_date_between($c,$d1,$d2)
	{
		$query = function($link,$args){
			$list = array();
			$sql = "SELECT * FROM session WHERE course = ? AND (date BETWEEN ? AND ?) ORDER BY date ASC";
			if ($stmt = mysqli_prepare($link,$sql)) {
				if (mysqli_stmt_bind_param($stmt,"sss",$args[0],$args[1],$args[2])) {
					if (mysqli_stmt_execute($stmt)) {
						if (mysqli_stmt_bind_result($stmt,$i,$c,$d,$s,$e)) {
							while (mysqli_stmt_fetch($stmt)) {
								array_push($list, new Session($i,$c,$d,$s,$e));
							}
						}
					}
				}
				mysqli_stmt_close($stmt);
			}
			return $list;
		};
		return new jsonList(execute_query($query,array($c,$d1,$d2)));
	}

	function update($i,$c,$d,$s,$e)
	{
		$query = function($link,$args){
			$bool = false;
			$sql = "UPDATE session SET course=?,date=?,start=?,end=? WHERE id=?";
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
		return execute_query($query,array($c,$d,$s,$e,$i));
	}

	function delete($i)
	{
		$query = function($link,$args){
			$bool = false;
			$sql = "DELETE FROM session WHERE id=?";
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

