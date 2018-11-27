
<?php 
/*
	$hojas=array(
		"BIOLOGÍA"	=> "o6hzm9c",	
		"CIENCIAS.SOCIALES"	=> "ob20sma",	
		"LENGUAJE"	=>	"ola3m2i",	
		"MATEMÁTICAS"	=>	"of96ibs",
		"QUÍMICA"	=>	"og73my8",
		"PRUEBAS"	=>	"oi6ls2b"		
	);


	$datos_hojas=array();
	foreach ($hojas as $asignatura => $hoja) {

		$url="https://spreadsheets.google.com/feeds/list/1x0QAkvZUqf344vzYZJ__pu8BH8CouA6ET0phg1AYZe8/".$hoja."/public/values?alt=json-in-script&guid=0&callback=sernatur";

		$cadena=file_get_contents($url);   //TOMA LOS DATOS DE LA URL PÚBLICA
		$cadena=substr($cadena, 25);	//QUITA ""// API callback sernatur(" del string quedando {});	
		$cadena=substr($cadena, 0, -2); //QUITA ");" del final del string
		$cadena=json_decode($cadena, false); // Cuando es TRUE, los object devueltos serán convertidos a array asociativos.
		$cadena=$cadena->feed->entry; // Mostrar solo lo correspondiente al método  [entry] 
		//print_r($cadena);   //DESCOMENTADO PARA VER LA VARIABLE $cadena
		$datos=$cadena;

		$datos_hojas[$asignatura]=$datos;
	}
	
	var_dump($datos_hojas);
*/

define('DRIVE', 'https://spreadsheets.google.com/feeds/list');
define('DOCUMENT', '/1x0QAkvZUqf344vzYZJ__pu8BH8CouA6ET0phg1AYZe8');
define('BIOLOGÍA', '/o6hzm9c');
define('CIENCIAS.SOCIALES', '/ob20sma');
define('LENGUAJE', '/ola3m2i');
define('MATEMÁTICAS', '/of96ibs');
define('QUÍMICA', '/og73my8');
define('HEADER', '/public/values?alt=json');

$r = array();
$regs = json_decode(file_get_contents(DRIVE.DOCUMENT.constant("MATEMÁTICAS").HEADER),true)['feed']['entry'];
$i = 0;
echo "<table>";
foreach ($regs as $reg) {
	if ( $reg['gsx$id']['$t'] != '') {
		$a = array();
		$a['id'] = $reg['gsx$id']['$t'];
		$a['nombreasignatura']=$reg['gsx$nombreasignatura']['$t'];
		$a['cantidaddeinscritos']=$reg['gsx$cantidaddeinscritos']['$t'];
		$a['diasemana']=$reg['gsx$díasemana']['$t'];
		$a['horainicio']=$reg['gsx$horainicio']['$t'];
		$a['horatermino']=$reg['gsx$horatérmino']['$t'];
		$a['tutorresponsable']=$reg['gsx$tutorresponsable']['$t'];
		$a['lugar']=$reg['gsx$lugar']['$t'];
		$a['publicadoenlaweb']=$reg['gsx$publicadoenlaweb']['$t'];
		$a['tutoriacerrada']=$reg['gsx$tutoriacerrada']['$t'];
		$a['fechadecierre']=$reg['gsx$fechadecierre']['$t'];
		$a['tiposervicio']=$reg['gsx$tiposervicio']['$t'];
		$a['profesionalresponsable']=$reg['gsx$profesionalresponsable']['$t'];
		$a['carreradelaasignatura']=$reg['gsx$carreradelaasignatura']['$t'];
		$a['semestre']=$reg['gsx$semestre']['$t'];
		$a['area']=$reg['gsx$área']['$t'];
		$a['codigoasignatura']=$reg['gsx$códigoasignatura']['$t'];
		$a['fechainicioacompanamiento']=$reg['gsx$fechainicioacompañamiento']['$t'];
		$a['fechafinacompanamiento']=$reg['gsx$fechafinacompañamiento']['$t'];
		$a['fechaplanificada']=$reg['gsx$fechaplanificada']['$t'];
		$a['comentario']=$reg['gsx$comentario']['$t'];
		$a['programacion']=$reg['gsx$programacion']['$t'];
		array_push($r, $a);
		echo "<tr>";
		echo "<td>".$i."</td>";
		$rgb = "#0f0";
		if ($a['id'] == "") {$rgb = "#f00";} echo "<td style=\"background-color:$rgb\">".$a['id']."</td>"; $rgb = "#0f0";
		if ($a['nombreasignatura'] == "") {$rgb = "#f00";} echo "<td style=\"background-color:$rgb\">".$a['nombreasignatura']."</td>"; $rgb = "#0f0";
		if ($a['cantidaddeinscritos'] == "") {$rgb = "#f00";} echo "<td style=\"background-color:$rgb\">".$a['cantidaddeinscritos']."</td>"; $rgb = "#0f0";
		if ($a['diasemana'] == "") {$rgb = "#f00";} echo "<td style=\"background-color:$rgb\">".$a['diasemana']."</td>"; $rgb = "#0f0";
		if ($a['horainicio'] == "") {$rgb = "#f00";} echo "<td style=\"background-color:$rgb\">".$a['horainicio']."</td>"; $rgb = "#0f0";
		if ($a['horatermino'] == "") {$rgb = "#f00";} echo "<td style=\"background-color:$rgb\">".$a['horatermino']."</td>"; $rgb = "#0f0";
		if ($a['tutorresponsable'] == "") {$rgb = "#f00";} echo "<td style=\"background-color:$rgb\">".$a['tutorresponsable']."</td>"; $rgb = "#0f0";
		if ($a['lugar'] == "") {$rgb = "#f00";} echo "<td style=\"background-color:$rgb\">".$a['lugar']."</td>"; $rgb = "#0f0";
		if ($a['publicadoenlaweb'] == "") {$rgb = "#f00";} echo "<td style=\"background-color:$rgb\">".$a['publicadoenlaweb']."</td>"; $rgb = "#0f0";
		if ($a['tutoriacerrada'] == "") {$rgb = "#f00";} echo "<td style=\"background-color:$rgb\">".$a['tutoriacerrada']."</td>"; $rgb = "#0f0";
		if ($a['fechadecierre'] == "") {$rgb = "#f00";} echo "<td style=\"background-color:$rgb\">".$a['fechadecierre']."</td>"; $rgb = "#0f0";
		if ($a['tiposervicio'] == "") {$rgb = "#f00";} echo "<td style=\"background-color:$rgb\">".$a['tiposervicio']."</td>"; $rgb = "#0f0";
		if ($a['profesionalresponsable'] == "") {$rgb = "#f00";} echo "<td style=\"background-color:$rgb\">".$a['profesionalresponsable']."</td>"; $rgb = "#0f0";
		if ($a['carreradelaasignatura'] == "") {$rgb = "#f00";} echo "<td style=\"background-color:$rgb\">".$a['carreradelaasignatura']."</td>"; $rgb = "#0f0";
		if ($a['semestre'] == "") {$rgb = "#f00";} echo "<td style=\"background-color:$rgb\">".$a['semestre']."</td>"; $rgb = "#0f0";
		if ($a['area'] == "") {$rgb = "#f00";} echo "<td style=\"background-color:$rgb\">".$a['area']."</td>"; $rgb = "#0f0";
		if ($a['codigoasignatura'] == "") {$rgb = "#f00";} echo "<td style=\"background-color:$rgb\">".$a['codigoasignatura']."</td>"; $rgb = "#0f0";
		if ($a['fechainicioacompanamiento'] == "") {$rgb = "#f00";} echo "<td style=\"background-color:$rgb\">".$a['fechainicioacompanamiento']."</td>"; $rgb = "#0f0";
		if ($a['fechafinacompanamiento'] == "") {$rgb = "#f00";} echo "<td style=\"background-color:$rgb\">".$a['fechafinacompanamiento']."</td>"; $rgb = "#0f0";
		if ($a['fechaplanificada'] == "") {$rgb = "#f00";} echo "<td style=\"background-color:$rgb\">".$a['fechaplanificada']."</td>"; $rgb = "#0f0";
		if ($a['comentario'] == "") {$rgb = "#f00";} echo "<td style=\"background-color:$rgb\">".$a['comentario']."</td>"; $rgb = "#0f0";
		if ($a['programacion'] == "") {$rgb = "#f00";} echo "<td style=\"background-color:$rgb\">".$a['programacion']."</td>"; $rgb = "#0f0";
		echo "</tr>";
		$i++;
	}
}
echo "</table>";
?>