<?php
require_once 'clases/Respuesta.php';
require_once 'clases/MultiplesTablasClass.php';

$_respuesta = new Respuesta();
$_multiplesTablas = new MultiplesTablasClass();

// Si el método de solicitud es GET devuelve los datos de las tres tablas
if ($_SERVER['REQUEST_METHOD'] == "GET") {
    $listaTablas = $_multiplesTablas->getRegistrosTresTablas();
    header("Content-Type: application/json");
    echo json_encode($listaTablas);
    http_response_code(200);
    
} else{
    // Si el método de solicitud no es GET devuelve un error 405
    header("Content-Type: application/json");
    $datosArray = $_respuesta->error_405();
    echo json_encode($datosArray);
}
