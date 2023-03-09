<?php
// Incluimos la clase Respuesta y UsuariosClass
require_once 'clases/Respuesta.php';
require_once 'clases/GalaxiaClass.php';

// Instanciamos las clases
$_respuesta = new Respuesta();
$_galaxias = new GalaxiaClass();

// Si el método de solicitud es GET
if ($_SERVER['REQUEST_METHOD'] == "GET") {
    // Si se especifica una página, obtenemos los usuarios para esa página
    if (isset($_GET['page'])) {
        $pagina = $_GET['page'];
        $listaGalaxias = $_galaxias->listaPorPagina($pagina);
        header("Content-Type: application/json");
        echo json_encode($listaGalaxias);
        http_response_code(200);
    }
    // Si se especifica un ID de usuario, obtenemos ese usuario
    else if (isset($_GET['id'])) {
        $id_galaxia = $_GET['id'];
        $datosGalaxia = $_galaxias->obtenerUno($id_galaxia);
        header("Content-Type: application/json");
        echo json_encode($datosGalaxia);
        http_response_code(200);
    }
    // Si no se especifica una página ni un ID de usuario,
    // obtenemos la lista completa de usuarios
    else {
        $listaGalaxias = $_galaxias->listaElementos();
        header("Content-Type: application/json");
        echo json_encode($listaGalaxias);
        http_response_code(200);
    }
} 
// Si el método de solicitud es POST
else if ($_SERVER['REQUEST_METHOD'] == "POST") {
    // Obtenemos los datos enviados por el cliente
    $postBody = file_get_contents("php://input");
    // Enviamos los datos al manejador
    $datosArray = $_galaxias->post($postBody);
    // Enviamos la respuesta al cliente
    header("Content-Type: application/json");
    if (isset($datosArray["result"]["error_id"])) {
        $responseCode = $datosArray["result"]["error_id"];
        http_response_code($responseCode);
    } else {
        http_response_code(200);
    }
    echo json_encode($datosArray);
} 
// Si el método de solicitud es PUT
else if ($_SERVER['REQUEST_METHOD'] == "PUT") {
    // Obtenemos los datos enviados por el cliente
    $postBody = file_get_contents("php://input");
    // Enviamos los datos al manejador
    $datosArray = $_galaxias->put($postBody);
    // Enviamos la respuesta al cliente
    header("Content-Type: application/json");
    if (isset($datosArray["result"]["error_id"])) {
        $responseCode = $datosArray["result"]["error_id"];
        http_response_code($responseCode);
    } else {
        http_response_code(200);
    }
    echo json_encode($datosArray);
} 
// Si el método de solicitud es DELETE
else if ($_SERVER['REQUEST_METHOD'] == "DELETE") {
    // Obtenemos los datos enviados por el cliente
    $postBody = file_get_contents("php://input");
    // Enviamos los datos al manejador
    $datosArray = $_galaxias->delete($postBody);
    // Enviamos la respuesta al cliente
    header("Content-Type: application/json");
    if (isset($datosArray["result"]["error_id"])) {
        $responseCode = $datosArray["result"]["error_id"];
        http_response_code($responseCode);
    } else {
        http_response_code(200);
    }
    echo json_encode($datosArray);
}
// Si el método de solicitud no está permitido, devolvemos una respuesta de error
else {
    header("Content-Type: application/json");
    $datosArray = $_respuesta->error_405();
    echo json_encode($datosArray);
}
