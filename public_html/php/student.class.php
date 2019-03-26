<?php 

class Student
{
	
	function __construct($r,$d,$n,$cc,$cn,$c,$p,$e)
	{
		$this->rut = $r;
		$this->dv = $d;
		$this->name = $n;
		$this->career_code = $cc;
		$this->career_name = $cn;
		$this->cohort = $c;
		$this->phone = $p;
		$this->email = $e;
	}

	function __toString()
	{
		return "{\"rut\":".$this->rut.",\"dv\":\"".$this->dv."\",\"name\":\"".$this->name."\",\"career_code\":".$this->career_code.",\"career_name\":\"".$this->career_name."\",\"cohort\":".$this->cohort.",\"phone\":".$this->phone.",\"email\":\"".$this->email."\"}";
	}

	function insert($r,$d,$n,$cc,$cn,$c,$p,$e)
	{
		$query = function($link,$args){
			$bool = false;
			$sql = "INSERT INTO student VALUES(?,?,?,?,?,?,?,?)";
			if ($stmt = mysqli_prepare($link,$sql)) {
				if (mysqli_stmt_bind_param($stmt,"ssssssss",$args[0],$args[1],$args[2],$args[3],$args[4],$args[5],$args[6],$args[7])) {
					if (mysqli_stmt_execute($stmt)) {
						$bool = true;
					}
				}
				mysqli_stmt_close($stmt);
			}
			return $bool;
		};
		return execute_query($query,array($r,$d,$n,$cc,$cn,$c,$p,$e));
	}

	function reinsert($r,$d,$n,$cc,$cn,$c,$p,$e)
	{
		$query = function($link,$args){
			$bool = false;
			$sql = "INSERT INTO student VALUES(?,?,?,?,?,?,?,?) ON DUPLICATE KEY UPDATE name=VALUES(name),career_code=VALUES(career_code),career_name=VALUES(career_name),cohort=VALUES(cohort),phone=VALUES(phone),email=VALUES(email)";
			if ($stmt = mysqli_prepare($link,$sql)) {
				if (mysqli_stmt_bind_param($stmt,"ssssssss",$args[0],$args[1],$args[2],$args[3],$args[4],$args[5],$args[6],$args[7])) {
					if (mysqli_stmt_execute($stmt)) {
						$bool = true;
					}
				}
				mysqli_stmt_close($stmt);
			}
			return $bool;
		};
		return execute_query($query,array($r,$d,$n,$cc,$cn,$c,$p,$e));
	}

	function select_by_rut($r)
	{
		$query = function($link,$args){
			$student = false;
			$sql = "SELECT * FROM student WHERE rut = ?";
			if ($stmt = mysqli_prepare($link,$sql)) {
				if (mysqli_stmt_bind_param($stmt,"s",$args[0])) {
					if (mysqli_stmt_execute($stmt)) {
						if (mysqli_stmt_bind_result($stmt,$r,$d,$n,$cc,$cn,$c,$p,$e)) {
							if (mysqli_stmt_fetch($stmt)) {
								$student = new Student($r,$d,$n,$cc,$cn,$c,$p,$e);
							}
						}
					}
				}
				mysqli_stmt_close($stmt);
			}
			return $student;
		};
		return execute_query($query,array($r));
	}

	function update($r,$d,$n,$cc,$cn,$c,$p,$e)
	{
		$query = function($link,$args){
			$bool = false;
			$sql = "UPDATE student SET dv=?,name=?,career_code=?,career_name=?,cohort=?,phone=?,email=? WHERE rut=?";
			if ($stmt = mysqli_prepare($link,$sql)) {
				if (mysqli_stmt_bind_param($stmt,"ssssssss",$args[0],$args[1],$args[2],$args[3],$args[4],$args[5],$args[6],$args[7])) {
					if (mysqli_stmt_execute($stmt)) {
						$bool = true;
					}
				}
				mysqli_stmt_close($stmt);
			}
			return $bool;
		};
		return execute_query($query,array($d,$n,$cc,$cn,$c,$p,$e,$r));
	}

	function delete($r)
	{
		$query = function($link,$args){
			$bool = false;
			$sql = "DELETE FROM student WHERE rut=?";
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
		return execute_query($query,array($r));
	}
}

?>
