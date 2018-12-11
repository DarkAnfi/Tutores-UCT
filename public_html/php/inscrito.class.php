<?php 

class Inscrito
{
	
	function __construct($i,$e,$t)
	{
		$this->id = $i;
		$this->estudiante = $e;
		$this->tutoria = $t;
	}

	function __toString()
	{
		return "{\"id\":\"".$this->id."\",\"estudiante\":".$this->estudiante.",\"tutoria\":".$this->tutoria."}";
	}

	function insert($e,$t)
	{
		$query = function($link,$args){
			$bool = false;
			$sql = "INSERT INTO inscrito VALUES(NULL,?,?)";
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
		return execute_query($query,array($e,$t));
	}

	function select_by_id($i)
	{
		$query = function($link,$args){
			$inscrito = false;
			$sql = "SELECT * FROM inscrito WHERE id = ?";
			if ($stmt = mysqli_prepare($link,$sql)) {
				if (mysqli_stmt_bind_param($stmt,"s",$args[0])) {
					if (mysqli_stmt_execute($stmt)) {
						if (mysqli_stmt_bind_result($stmt,$i,$e,$t)) {
							if (mysqli_stmt_fetch($stmt)) {
								if ($e = Estudiante::select_by_rut($e)) {
									if ($t = Tutoria::select_by_id($t)) {
										$inscrito = new Inscrito($i,$e,$t);
									}
								}
							}
						}
					}
				}
				mysqli_stmt_close($stmt);
			}
			return $inscrito;
		};
		return execute_query($query,array($i));
	}

	function select_by_estudiante_tutoria($e,$t)
	{
		$query = function($link,$args){
			$inscrito = false;
			$sql = "SELECT * FROM inscrito WHERE estudiante = ? AND tutoria = ?";
			if ($stmt = mysqli_prepare($link,$sql)) {
				if (mysqli_stmt_bind_param($stmt,"ss",$args[0],$args[1])) {
					if (mysqli_stmt_execute($stmt)) {
						if (mysqli_stmt_bind_result($stmt,$i,$e,$t)) {
							if (mysqli_stmt_fetch($stmt)) {
								if ($e = Estudiante::select_by_rut($e)) {
									if ($t = Tutoria::select_by_id($t)) {
										$inscrito = new Inscrito($i,$e,$t);
									}
								}
							}
						}
					}
				}
				mysqli_stmt_close($stmt);
			}
			return $inscrito;
		};
		return execute_query($query,array($e,$t));
	}

	function select_by_estudiante($e)
	{
		$query = function($link,$args){
			$list = array();
			$sql = "SELECT * FROM inscrito WHERE estudiante = ?";
			if ($stmt = mysqli_prepare($link,$sql)) {
				if (mysqli_stmt_bind_param($stmt,"s",$args[0])) {
					if (mysqli_stmt_execute($stmt)) {
						if (mysqli_stmt_bind_result($stmt,$i,$e,$t)) {
							while (mysqli_stmt_fetch($stmt)) {
								if ($e = Estudiante::select_by_rut($e)) {
									if ($t = Tutoria::select_by_id($t)) {
										array_push($list, new Inscrito($i,$e,$t));
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

	function select_by_tutoria($t)
	{
		$query = function($link,$args){
			$list = array();
			$sql = "SELECT * FROM inscrito WHERE tutoria = ?";
			if ($stmt = mysqli_prepare($link,$sql)) {
				if (mysqli_stmt_bind_param($stmt,"s",$args[0])) {
					if (mysqli_stmt_execute($stmt)) {
						if (mysqli_stmt_bind_result($stmt,$i,$e,$t)) {
							while (mysqli_stmt_fetch($stmt)) {
								if ($e = Estudiante::select_by_rut($e)) {
									if ($t = Tutoria::select_by_id($t)) {
										array_push($list, new Inscrito($i,$e,$t));
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
		return new jsonList(execute_query($query,array($t)));
	}

	function update($i,$e,$t)
	{
		$query = function($link,$args){
			$bool = false;
			$sql = "UPDATE inscrito SET estudiante=?,tutoria=? WHERE id=?";
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
		return execute_query($query,array($e,$t,$i));
	}

	function delete($i)
	{
		$query = function($link,$args){
			$bool = false;
			$sql = "DELETE FROM inscrito WHERE id=?";
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