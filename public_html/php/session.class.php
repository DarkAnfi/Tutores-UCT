<?php 

class Session
{
	
	function __construct($id,$fecha,$lugar,$contenidos,$observaciones,$tutoria)
	{
		$this->id = $id;
		$this->fecha = $fecha;
		$this->lugar = $lugar;
		$this->contenidos = $contenidos;
		$this->observaciones = $observaciones;
		$this->tutoria = $tutoria;
	}

	function __toString()
	{
		return "{\"id\":\"".$this->id."\",\"fecha\":\"".$this->fecha."\",\"lugar\":\"".$this->lugar."\",\"contenidos\":\"".$this->contenidos."\",\"observaciones\":\"".$this->observaciones."\",\"tutoria\":".$this->tutoria."}";
	}
}

 ?>