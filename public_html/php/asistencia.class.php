<?php
class Asistencia
{
	function __construct($i,$e,$p,$s)
	{
		$this->id = $i;
		$this->estudiante = $e;
		$this->presente = $p;
		$this->sesion = $s;
	}

	function __toString()
	{
		return "{\"id\":".$this->id.",\"estudiante\":".$this->estudiante.",\"presente\":".$this->presente.",\"sesion\":".$this->sesion."}";
	}

	function insert($e,$p,$s)
	{
		$query = function($link,$args){
			$bool = false;
			$sql = "INSERT INTO asistencia VALUES(NULL,?,?,?)";
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
		return execute_query($query,array($e,$p,$s));
	}

	function select_by_id($i)
	{
		$query = function($link,$args){
			$asistencia = false;
			$sql = "SELECT * FROM asistencia WHERE id = ?";
			if ($stmt = mysqli_prepare($link,$sql)) {
				if (mysqli_stmt_bind_param($stmt,"s",$args[0])) {
					if (mysqli_stmt_execute($stmt)) {
						if (mysqli_stmt_bind_result($stmt,$i,$e,$p,$s)) {
							if (mysqli_stmt_fetch($stmt)) {
								if ($e = Estudiante::select_by_rut($e)) {
									if ($s = Session::select_by_id($s)) {
										$asistencia = new Asistencia($i,$e,$p,$s);
									}
								}
							}
						}
					}
				}
				mysqli_stmt_close($stmt);
			}
			return $asistencia;
		};
		return execute_query($query,array($i));
	}

	function select_by_estudiante($e)
	{
		$query = function($link,$args){
			$list = array();
			$sql = "SELECT * FROM asistencia WHERE estudiante = ?";
			if ($stmt = mysqli_prepare($link,$sql)) {
				if (mysqli_stmt_bind_param($stmt,"s",$args[0])) {
					if (mysqli_stmt_execute($stmt)) {
						if (mysqli_stmt_bind_result($stmt,$i,$e,$p,$s)) {
							while (mysqli_stmt_fetch($stmt)) {
								if ($e = Estudiante::select_by_rut($e)) {
									if ($s = Session::select_by_id($s)) {
										array_push($list, new Asistencia($i,$e,$p,$s));
									}
								}
							}
						}
					}
				}
				mysqli_stmt_close($stmt);
			}
			return $list;
		};
		return new jsonList(execute_query($query,array($e)));
	}

	function select_by_estudiante_sesion($e,$s)
	{
		$query = function($link,$args){
			$asistencia = false;
			$sql = "SELECT * FROM asistencia WHERE estudiante=? AND sesion=?";
			if ($stmt = mysqli_prepare($link,$sql)) {
				if (mysqli_stmt_bind_param($stmt,"ss",$args[0],$args[1])) {
					if (mysqli_stmt_execute($stmt)) {
						if (mysqli_stmt_bind_result($stmt,$i,$e,$p,$s)) {
							if (mysqli_stmt_fetch($stmt)) {
								if ($e = Estudiante::select_by_rut($e)) {
									if ($s = Session::select_by_id($s)) {
										$asistencia = new Asistencia($i,$e,$p,$s);
									}
								}
							}
						}
					}
				}
				mysqli_stmt_close($stmt);
			}
			return $asistencia;
		};
		return execute_query($query,array($e,$s));
	}

	function select_by_sesion($s)
	{
		$query = function($link,$args){
			$list = array();
			$sql = "SELECT * FROM asistencia WHERE sesion = ?";
			if ($stmt = mysqli_prepare($link,$sql)) {
				if (mysqli_stmt_bind_param($stmt,"s",$args[0])) {
					if (mysqli_stmt_execute($stmt)) {
						if (mysqli_stmt_bind_result($stmt,$i,$e,$p,$s)) {
							while (mysqli_stmt_fetch($stmt)) {
								if ($e = Estudiante::select_by_rut($e)) {
									if ($s = Session::select_by_id($s)) {
										array_push($list, new Asistencia($i,$e,$p,$s));
									}
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

	function update($i,$e,$p,$s)
	{
		$query = function($link,$args){
			$bool = false;
			$sql = "UPDATE asistencia SET estudiante=?,presente=?,sesion=? WHERE id=?";
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
		return execute_query($query,array($e,$p,$s,$i));
	}

	function delete($i)
	{
		$query = function($link,$args){
			$bool = false;
			$sql = "DELETE FROM asistencia WHERE id=?";
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

