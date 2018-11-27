<?php 

class Estudiante
{
	
	function __construct($rut,$dv,$nombre,$cod_carrera,$nom_carrera,$cohorte,$fono,$email)
	{
		$this->rut = $rut;
		$this->dv = $dv;
		$this->nombre = $nombre;
		$this->cod_carrera = $cod_carrera;
		$this->nom_carrera = $nom_carrera;
		$this->cohorte = $cohorte;
		$this->fono = $fono;
		$this->email = $email;
	}

	function __toString()
	{
		return "{\"rut\":".$this->rut.",\"dv\":".$this->dv.",\"nombre\":\"".$this->nombre."\",\"cod_carrera\":".$this->cod_carrera.",\"nom_carrera\":\"".$this->nom_carrera."\",\"cohorte\":".$this->cohorte.",\"fono\":".$this->fono.",\"email\":\"".$this->email."\"}";
	}
}

 ?>