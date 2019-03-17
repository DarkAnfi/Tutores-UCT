<?php
class Course
{
	function __construct($i,$c,$n,$t,$ty,$y,$s)
	{
		$this->id = $i;
		$this->code = $c;
		$this->name = $n;
		$this->tutor = $t;
		$this->type = $ty;
		$this->year = $y;
		$this->semester = $s;
	}

	function __toString()
	{
		return "{\"id\":".$this->id.",\"code\":\"".$this->code."\",\"name\":\"".$this->name."\",\"tutor\":".$this->tutor.",\"type\":".$this->type.",\"year\":".$this->year.",\"semester\":".$this->semester."}";
	}

	function insert($c,$n,$t,$ty,$y,$s)
	{
		$query = function($link,$args){
			$bool = false;
			$sql = "INSERT INTO course VALUES(NULL,?,?,?,?,?,?)";
			if ($stmt = mysqli_prepare($link,$sql)) {
				if (mysqli_stmt_bind_param($stmt,"ssssss",$args[0],$args[1],$args[2],$args[3],$args[4],$args[5])) {
					if (mysqli_stmt_execute($stmt)) {
						$bool = true;
					}
				}
				mysqli_stmt_close($stmt);
			}
			return $bool;
		};
		return execute_query($query,array($c,$n,$t,$ty,$y,$s));
	}

	function select_by_id($i)
	{
		$query = function($link,$args){
			$course = false;
			$sql = "SELECT * FROM course WHERE id=?";
			if ($stmt = mysqli_prepare($link,$sql)) {
				if (mysqli_stmt_bind_param($stmt,"s",$args[0])) {
					if (mysqli_stmt_execute($stmt)) {
						if (mysqli_stmt_bind_result($stmt,$i,$c,$n,$t,$ty,$y,$s)) {
							if (mysqli_stmt_fetch($stmt)) {
								if ($t = Tutor::select_by_id($t)) {
									if ($ty = Type::select_by_id($ty)) {
										$course = new Course($i,$c,$n,$t,$ty,$y,$s);
									}
								}
							}
						}
					}
				}
				mysqli_stmt_close($stmt);
			}
			return $course;
		};
		return execute_query($query,array($i));
	}

	function select_by_tutor_type_year_semester($t,$ty,$y,$s)
	{
		$query = function($link,$args){
			$list = array();
			$sql = "SELECT * FROM course WHERE tutor=? AND type=? AND year=? AND semester=?";
			if ($stmt = mysqli_prepare($link,$sql)) {
				if (mysqli_stmt_bind_param($stmt,"ssss",$args[0],$args[1],$args[2],$args[3])) {
					if (mysqli_stmt_execute($stmt)) {
						if (mysqli_stmt_bind_result($stmt,$i,$c,$n,$t,$ty,$y,$s)) {
							while (mysqli_stmt_fetch($stmt)) {
								array_push($list, new Course($i,$c,$n,$t,$ty,$y,$s));
							}
						}
					}
				}
				mysqli_stmt_close($stmt);
			}
			return $list;
		};
		return new jsonList(execute_query($query,array($t,$ty,$y,$s)));
	}

	function update($i,$c,$n,$t,$ty,$y,$s)
	{
		$query = function($link,$args){
			$bool = false;
			$sql = "UPDATE course SET code=?,name=?,tutor=?,type=?,year=?,semester=? WHERE id=?";
			if ($stmt = mysqli_prepare($link,$sql)) {
				if (mysqli_stmt_bind_param($stmt,"sssssss",$args[0],$args[1],$args[2],$args[3],$args[4],$args[5],$args[6])) {
					if (mysqli_stmt_execute($stmt)) {
						$bool = true;
					}
				}
				mysqli_stmt_close($stmt);
			}
			return $bool;
		};
		return execute_query($query,array($c,$n,$t,$ty,$y,$s,$i));
	}

	function delete($i)
	{
		$query = function($link,$args){
			$bool = false;
			$sql = "DELETE FROM course WHERE id=?";
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

