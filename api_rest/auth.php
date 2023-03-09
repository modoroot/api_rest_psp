<?php
// Incluye la clase AuthClass y Respuesta
require_once 'clases/AuthClass.php';
require_once 'clases/Respuesta.php';

// Crea una instancia de la clase AuthClass
$_auth = new AuthClass();

// Crea una instancia de la clase Respuesta
$_respuesta = new Respuesta();

// Si el método de la petición es POST
if ($_SERVER['REQUEST_METHOD'] == "POST") { 

    // Recibe los datos enviados por el cliente 
    $postBody = file_get_contents("php://input");
    // Envía los datos al método login de la clase AuthClass
    $datosArray = $_auth->login($postBody);
    // Configuración del tipo de contenido como JSON para la respuesta
    header("Content-Type: application/json");

    // Comprueba si el array de datos contiene el índice error_id
    if (isset($datosArray["result"]["error_id"])) {
        // Si existe, se obtiene el código de error y se devuelve al cliente
        $responseCode = $datosArray["result"]["error_id"];
        // Se envía el código de error al cliente
        http_response_code($responseCode);
    } 
    else {
        // Si no existe, se devuelve el código 200 (OK)
        http_response_code(200);  
    }

    // Codificación de los datos de respuesta a JSON y devolución al cliente
    echo json_encode($datosArray);

} 
else {
    // Configuración del tipo de contenido como JSON para la respuesta
    header("Content-Type: application/json");

    // Se devuelve el código 405 (Método no permitido)
    $datosArray = $_respuesta->error_405();
    // Se envía el código de error al cliente
    echo json_encode($datosArray);
}
