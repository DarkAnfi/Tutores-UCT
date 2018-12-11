<?php 

class Estudiante
{
	
	function __construct($r,$d,$n,$cc,$nc,$c,$f,$e)
	{
		$this->rut = $r;
		$this->dv = $d;
		$this->nombre = $n;
		$this->cod_carrera = $cc;
		$this->nom_carrera = $nc;
		$this->cohorte = $c;
		$this->fono = $f;
		$this->email = $e;
	}

	function __toString()
	{
		return "{\"rut\":".$this->rut.",\"dv\":".$this->dv.",\"nombre\":\"".$this->nombre."\",\"cod_carrera\":".$this->cod_carrera.",\"nom_carrera\":\"".$this->nom_carrera."\",\"cohorte\":".$this->cohorte.",\"fono\":".$this->fono.",\"email\":\"".$this->email."\"}";
	}

	function insert($r,$d,$n,$cc,$nc,$c,$f,$e)
	{
		$query = function($link,$args){
			$bool = false;
			$sql = "INSERT INTO estudiante VALUES(?,?,?,?,?,?,?,?)";
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
		return execute_query($query,array($r,$d,$n,$cc,$nc,$c,$f,$e));
	}

	function reinsert($r,$d,$n,$cc,$nc,$c,$f,$e)
	{
		$query = function($link,$args){
			$bool = false;
			$sql = "INSERT INTO estudiante VALUES(?,?,?,?,?,?,?,?) ON DUPLICATE KEY UPDATE nombre=VALUES(nombre),cod_carrera=VALUES(cod_carrera),nom_carrera=VALUES(nom_carrera),cohorte=VALUES(cohorte),fono=VALUES(fono),email=VALUES(email)";
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
		return execute_query($query,array($r,$d,$n,$cc,$nc,$c,$f,$e));
	}

	function select_by_rut($r)
	{
		$query = function($link,$args){
			$estudiante = false;
			$sql = "SELECT * FROM estudiante WHERE rut = ?";
			if ($stmt = mysqli_prepare($link,$sql)) {
				if (mysqli_stmt_bind_param($stmt,"s",$args[0])) {
					if (mysqli_stmt_execute($stmt)) {
						if (mysqli_stmt_bind_result($stmt,$r,$d,$n,$cc,$nc,$c,$f,$e)) {
							if (mysqli_stmt_fetch($stmt)) {
								$estudiante = new Estudiante($r,$d,$n,$cc,$nc,$c,$f,$e);
							}
						}
					}
				}
				mysqli_stmt_close($stmt);
			}
			return $estudiante;
		};
		return execute_query($query,array($r));
	}

	function update($r,$d,$n,$cc,$nc,$c,$f,$e)
	{
		$query = function($link,$args){
			$bool = false;
			$sql = "UPDATE estudiante SET dv=?,nombre=?,cod_carrera=?,nom_carrera=?,cohorte=?,fono=?,email=? WHERE rut=?";
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
		return execute_query($query,array($d,$n,$cc,$nc,$c,$f,$e,$r));
	}

	function delete($r)
	{
		$query = function($link,$args){
			$bool = false;
			$sql = "DELETE FROM estudiante WHERE rut=?";
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
