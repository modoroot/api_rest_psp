<?php

// Incluir el archivo de conexión
require_once '../api_rest/clases/conexion/Conexion.php';

// Obtener el valor del parámetro token_id enviado por AJAX
$id_access_token = $_POST['id_access_token'];

// Crear una instancia de la clase Conexion para conectarse a la base de datos
$con = new Conexion();

// Construir la consulta SQL para eliminar el registro
$sql = "DELETE FROM access_tokens WHERE id_access_token = $id_access_token";

// Ejecutar la consulta y obtener el número de filas afectadas
$num_filas_afectadas = $con->nonQuery($sql);

// Si se eliminó el registro correctamente, enviar una respuesta exitosa
if ($num_filas_afectadas > 0) {
    header('Content-Type: application/json');
    echo json_encode(array('success' => true));
} else {
    header('Content-Type: application/json');
    // Si no se pudo eliminar el registro, enviar una respuesta de error
    echo json_encode(array('success' => false, 'message' => 'Error al eliminar el registro'));
}

?>
