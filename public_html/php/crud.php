<?php

function crud_get_date_format($_d)
{
    if ($_d != "") {
        $search = array("ene","abr","ago","dic","de Enero","de Febrero","de Marzo","de Abril","de Mayo","de Junio","de Julio",
            "de Agosto","de Septiembre","de Octubre","de Noviembre","de Diciembre");
        $replace = array("jan","apr","aug","dec","jan","feb","mar","apr","may","jun","jul","aug","sep","oct","nov","dec");
        $_d = str_replace($search, $replace, $_d);
        if ($format = date_create_from_format("j M Y",$_d)) {
            $_d = date_format($format,"Y-m-d");
        } elseif ($format = date_create_from_format("j/m/Y",$_d)) {
            $_d = date_format($format,"Y-m-d");
        } elseif ($format = date_create_from_format("j-m-Y",$_d)) {
            $_d = date_format($format,"Y-m-d");
        } else {
            $_d = null;
        }
    } else {
        $_d = null;
    }
    return $_d;
}

function crud_update_tutoria()
{
    $a = array();
    $regs = json_decode(file_get_contents(DRIVE.DOCUMENT.constant("MATEMÁTICAS").HEADER),true)['feed']['entry'];
    foreach ($regs as $reg) {
        if ( $reg['gsx$id']['$t'] != '') {
            if ($tutor = crud_get_user_name(array($reg['gsx$tutorresponsable']['$t']))) {
                if ($prof = crud_get_user_name(array($reg['gsx$profesionalresponsable']['$t']))) {
                    $r = array();
                    array_push($r,$reg['gsx$id']['$t']);
                    array_push($r,$reg['gsx$nombreasignatura']['$t']);
                    array_push($r,$reg['gsx$cantidaddeinscritos']['$t']);
                    array_push($r,$reg['gsx$díasemana']['$t']);
                    array_push($r,$reg['gsx$horainicio']['$t'].":00");
                    array_push($r,$reg['gsx$horatérmino']['$t'].":00");
                    array_push($r,$tutor);
                    array_push($r,$reg['gsx$lugar']['$t']);
                    if ($reg['gsx$publicadoenlaweb']['$t'] == "0") {
                        $publicado = 0;
                    } else {
                        $publicado = 1;
                    }
                    if ($reg['gsx$tutoriacerrada']['$t'] == "") {
                        $cerrado = 0;
                    } else {
                        $cerrado = 1;
                    }
                    array_push($r,$publicado);
                    array_push($r,$cerrado);
                    array_push($r,crud_get_date_format($reg['gsx$fechadecierre']['$t']));
                    array_push($r,$reg['gsx$tiposervicio']['$t']);
                    array_push($r,$prof);
                    array_push($r,$reg['gsx$carreradelaasignatura']['$t']);
                    array_push($r,$reg['gsx$semestre']['$t']);
                    array_push($r,$reg['gsx$área']['$t']);
                    array_push($r,$reg['gsx$códigoasignatura']['$t']);
                    array_push($r,crud_get_date_format($reg['gsx$fechainicioacompañamiento']['$t']));
                    array_push($r,crud_get_date_format($reg['gsx$fechafinacompañamiento']['$t']));
                    array_push($r,crud_get_date_format($reg['gsx$fechaplanificada']['$t']));
                    array_push($r,$reg['gsx$comentario']['$t']);
                    array_push($r,$reg['gsx$programacion']['$t']);
                    array_push($a, $r);
                }
            }
        }
    }
    $query = function ($link,$args) {
        $sql = "INSERT INTO tutoria 
                    (id, nombre, inscritos, dia, hora_inicio, hora_termino, tutor, lugar, publicado, cerrado, fecha_cierre, servicio,
                     profesional, carrera, semestre, area, codigo, fecha_inicio, fecha_termino, fecha_planificado, comentario, 
                     programacion)
                VALUES
                    (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
                ON DUPLICATE KEY UPDATE
                    nombre=VALUES(nombre),
                    inscritos=VALUES(inscritos),
                    dia=VALUES(dia),
                    hora_inicio=VALUES(hora_inicio),
                    hora_termino=VALUES(hora_termino),
                    tutor=VALUES(tutor),
                    lugar=VALUES(lugar),
                    publicado=VALUES(publicado),
                    cerrado=VALUES(cerrado),
                    fecha_cierre=VALUES(fecha_cierre),
                    servicio=VALUES(servicio),
                    profesional=VALUES(profesional),
                    carrera=VALUES(carrera),
                    semestre=VALUES(semestre),
                    area=VALUES(area),
                    codigo=VALUES(codigo),
                    fecha_inicio=VALUES(fecha_inicio),
                    fecha_termino=VALUES(fecha_termino),
                    fecha_planificado=VALUES(fecha_planificado),
                    comentario=VALUES(comentario),
                    programacion=VALUES(programacion)";
        foreach ($args as $r) {
            if ($stmt = mysqli_prepare($link,$sql)) {
                mysqli_stmt_bind_param($stmt,"ssssssssssssssssssssss",$r[0],$r[1],$r[2],$r[3],$r[4],$r[5],$r[6],$r[7],$r[8],
                    $r[9],$r[10],$r[11],$r[12],$r[13],$r[14],$r[15],$r[16],$r[17],$r[18],$r[19],$r[20],$r[21]);
                mysqli_stmt_execute($stmt);
                mysqli_stmt_close($stmt);
                
            }
        }
    };
    execute_query($query,$a);
}

?>