<?php
class Tutor
{
	function __construct($i,$d,$p)
	{
		$this->id = $i;
		$this->data = $d;
		$this->professional = $p;
	}

	function __toString()
	{
		return "{\"id\":".$this->id.",\"data\":".$this->data.",\"professional\":".$this->professional."}";
	}

	function insert($d,$p)
	{
		$query = function($link,$args){
			$bool = false;
			$sql = "INSERT INTO tutor VALUES(NULL,?,?)";
			if ($stmt = mysqli_prepare($link,$sql)) {
				if (mysqli_stmt_bind_param($stmt,"ss",$args[0],$args[1])) {
					if (mysqli_stmt_execute($stmt)) {
						$bool = true;
					}
				}
				mysqli_stmt_close($stmt);
			}
			return $bool;
		};
		return execute_query($query,array($d,$p));
	}

	function select_by_id($i)
	{
		$query = function($link,$args){
			$tutor = false;
			$sql = "SELECT * FROM tutor WHERE id=?";
			if ($stmt = mysqli_prepare($link,$sql)) {
				if (mysqli_stmt_bind_param($stmt,"s",$args[0])) {
					if (mysqli_stmt_execute($stmt)) {
						if (mysqli_stmt_bind_result($stmt,$i,$d,$p)) {
							if (mysqli_stmt_fetch($stmt)) {
								if ($d = Data::select_by_id($d)) {
									if ($p = Professional::select_by_id($p)) {
										$tutor = new Tutor($i,$d,$p);
									}
								}
							}
						}
					}
				}
				mysqli_stmt_close($stmt);
			}
			return $tutor;
		};
		return execute_query($query,array($i));
	}

	function select_by_data($d)
	{
		$query = function($link,$args){
			$tutor = false;
			$sql = "SELECT * FROM tutor WHERE data=?";
			if ($stmt = mysqli_prepare($link,$sql)) {
				if (mysqli_stmt_bind_param($stmt,"s",$args[0])) {
					if (mysqli_stmt_execute($stmt)) {
						if (mysqli_stmt_bind_result($stmt,$i,$d,$p)) {
							if (mysqli_stmt_fetch($stmt)) {
								$tutor = new Tutor($i,$d,$p);
							}
						}
					}
				}
				mysqli_stmt_close($stmt);
			}
			return $tutor;
		};
		return execute_query($query,array($d));
	}

	function update($i,$d,$p)
	{
		$query = function($link,$args){
			$bool = false;
			$sql = "UPDATE tutor SET data=?,professional=? WHERE id=?";
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
		return execute_query($query,array($d,$p,$i));
	}

	function delete($i)
	{
		$query = function($link,$args){
			$bool = false;
			$sql = "DELETE FROM tutor WHERE id=?";
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

