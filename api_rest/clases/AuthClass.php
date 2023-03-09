<?php
// Importa los archivos de conexión y Respuesta
require_once 'conexion/Conexion.php';
require_once 'Respuesta.php';

/**
 * Clase AuthClass para la autenticación de usuarios
 */
class AuthClass extends Conexion {   
    /**
     * Método para el inicio de sesión de usuarios
     */
    public function login($json){
        // Crea una instancia de la clase Respuesta
        $_respuesta = new Respuesta();

        // Decodifica el JSON recibido y lo almacena en un array asociativo
        $datos = json_decode($json, true);

        // Verifique si se ingresó información válida
        if (!isset($datos['username']) || !isset($datos['password'])) {
             // Devuelve una respuesta con código de error 400
            return $_respuesta->error_400();
        } else {
            // Almacena los datos recibidos en el array asociativo $datos
            $username = $datos['username'];
            $password = $datos['password'];

            // Encripta la contraseña antes de buscar los datos del usuario
            $password = parent::encriptar($password);
            // Obtiene los datos del usuario a través de su nombre de usuario
            $datos = $this->obtenerDatosUsuario($username);

            if ($datos) { // Si se encuentran datos del usuario
                if ($password == $datos[0]['password']) { // Verificar si el usuario ingresó la contraseña correcta
                    // Si es admin
                    if ($datos[0]['id_privilegio'] == 1 || $datos[0]['id_privilegio'] == 64) {
                        $verificar = $this->insertarToken($datos[0]['id_usuario']); // Insertar el token generado
                        if($verificar){ // Si se inserta correctamente
                            $result = $_respuesta->response;
                            $result["result"] = array(
                                "token" => $verificar
                            );
                            // Devuelve una respuesta con el token generado
                            return $result; 
                        } else{
                            // Devuelve una respuesta con código 500
                            return $_respuesta->error_500("Error interno del servidor, por favor intenta de nuevo"); 
                        }
                    } else {
                         // El usuario no tiene suficientes privilegios
                        return $_respuesta->error_200("El usuario no tiene privilegios");
                    }
                } else {
                    // La contraseña es incorrecta
                    return $_respuesta->error_200("Contraseña inválida"); 
                }
            } else {
                // El usuario no existe
                return $_respuesta->error_200("El usuario $username no existe"); 
            }
        }
    }

    // Obtiene los datos del usuario a través de su nombre de usuario
    private function obtenerDatosUsuario($nombreUsuario) {
        $query = "SELECT * FROM usuario WHERE username = '$nombreUsuario'";
        $datos = parent::obtenerDatos($query);

        if (isset($datos[0]['id_usuario'])) {
            return $datos;
        } else {
            return 0;
        }
    }
    /**
     * Inserta un token único en la base de datos para un usuario específico 
     * y retorna el token generado si funciona correctamente
     */
    private function insertarToken($id_usuario) {
        $query = "SELECT * FROM usuario WHERE id_usuario = '$id_usuario'";
        $datos = parent::obtenerDatos($query);
        $val = true;
        // Genera un token único
        $token = bin2hex(openssl_random_pseudo_bytes(16, $val)); 
        $date = date("Y-m-d");
        $id_privilegio = $datos[0]['id_privilegio'];
        $query = "INSERT INTO tokens VALUES (NULL,'$token', '$date', '$id_privilegio', '$id_usuario')";
        // Inserta el token generado en la base de datos
        $verifica = parent::nonQueryId($query); 
        // Si se inserta correctamente
        if ($verifica) {
            // Devuelve el token generado
           return $token;
        }
        else {
            return 0;
        }
    }
}
