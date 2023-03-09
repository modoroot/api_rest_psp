<?php
require_once 'conexion/Conexion.php';
require_once 'Respuesta.php';
class UsuariosClass extends Conexion
{
    private $tabla = "usuario";
    private $id_usuario = "";
    private $nombre = "";
    private $username = "";
    private $password = "";
    private $email = "";
    private $id_privilegio = "";
    private $token = "";
    /**
     * Lista los usuarios de la base de datos y los devuelve en un array asociativo paginado de 2 en 2
     * @param int $pagina
     * @return array
     */
    public function listaUsuarios($pagina = 1)
    {
        $inicio = 0;
        $cantidad = 2;
        if ($pagina > 1) {
            $inicio = ($cantidad * ($pagina - 1)) + 1;
            $cantidad = $cantidad * $pagina;
        }
        $query = "SELECT * FROM " . $this->tabla . " LIMIT $inicio, $cantidad";
        $datos = parent::obtenerDatos($query);
        return ($datos);
    }
    /**
     * Obtiene los datos de un usuario a través de su id de usuario y los devuelve en un array asociativo
     */
    public function obtenerUsuario($id_usuario)
    {
        $query = "SELECT * FROM " . $this->tabla . " WHERE id_usuario = $id_usuario";
        $datos = parent::obtenerDatos($query);
        return ($datos);
    }
    /**
     * Se añade un nuevo usuario a la base de datos a través de un JSON recibido por POST
     */
    public function post($json)
    {
        $_respuesta = new Respuesta();
        $datos = json_decode($json, true);

        if (!isset($datos['token'])) {
            return $_respuesta->error_401();
        } else {
            $this->token = $datos['token'];
            $arrayToken = $this->buscarToken();
            if ($arrayToken) {
                if (!isset($datos['username']) || !isset($datos['password'])) {
                    return $_respuesta->error_400();
                } else {
                    //Verificar si se ha introducido un nombre
                    if (isset($datos['nombre'])) {
                        $this->nombre = $datos['nombre'];
                    }
                    $this->username = $datos['username'];
                    //encriptamos la contraseña con sha1
                    $this->password = sha1($datos['password']);
                    //Verificar si se ha introducido un email
                    if (isset($datos['email'])) {
                        $this->email = $datos['email'];
                    }
                    if (isset($datos['id_privilegio'])) {
                        $this->id_privilegio = $datos['id_privilegio'];
                    }

                    $verificar = $this->insertarUsuario();
                    if ($verificar) {
                        $respuesta = $_respuesta->response;
                        $respuesta["result"] = array(
                            "id_usuario" => $verificar
                        );
                        return $respuesta;
                    } else {
                        return $_respuesta->error_500();
                    }
                }
            } else {
                return $_respuesta->error_401("El token es inválido/incorrecto");
            }
        }
    }
    /**
     * Inserta un usuario en la base de datos
     */
    private function insertarUsuario()
    {
        $query = "INSERT INTO " . $this->tabla . " (nombre, username, password, email, id_privilegio) VALUES
        ('" . $this->nombre . "', '" . $this->username . "', '" . $this->password . "', '"
            . $this->email . "', '" . $this->id_privilegio . "')";
        $verificar = parent::nonQueryId($query);
        if ($verificar) {
            return $verificar;
        } else {
            return 0;
        }
    }
    /**
     * Actualiza un usuario en la base de datos por su id de usuario y el token de acceso a la API REST
     */
    public function put($json)
    {
        $_respuesta = new Respuesta();
        $datos = json_decode($json, true);

        if (!isset($datos['token'])) {
            return $_respuesta->error_401();
        } else {
            $this->token = $datos['token'];
            $arrayToken = $this->buscarToken();
            if ($arrayToken) {
                if (!isset($datos['id_usuario'])) {
                    return $_respuesta->error_400();
                } else {
                    $this->id_usuario = $datos['id_usuario'];
                    //Verificar si se ha introducido un nombre
                    if (isset($datos['nombre'])) {
                        $this->nombre = $datos['nombre'];
                    }
                    if (isset($datos['username'])) {
                        $this->username = $datos['username'];
                    }
                    if (isset($datos['password'])) {
                        //encriptamos la contraseña con sha1
                        $this->password = sha1($datos['password']);
                    }
                    //Verificar si se ha introducido un email
                    if (isset($datos['email'])) {
                        $this->email = $datos['email'];
                    }
                    if (isset($datos['id_privilegio'])) {
                        $this->id_privilegio = $datos['id_privilegio'];
                    }
                    $verificar = $this->actualizarUsuario();
                    if ($verificar) {
                        $respuesta = $_respuesta->response;
                        $respuesta["result"] = array(
                            "id_usuario" => $this->id_usuario
                        );
                        return $respuesta;
                    } else {
                        return $_respuesta->error_500();
                    }
                }
            } else {
                return $_respuesta->error_401("El token es inválido/incorrecto");
            }
        }
    }
    /**
     * Actualiza un usuario en la base de datos por su id de usuario y el token de acceso a la API REST
     */
    private function actualizarUsuario()
    {
        $query = "UPDATE " . $this->tabla . " SET nombre = '" . $this->nombre . "', username = '"
            . $this->username . "', password = '" . $this->password . "', email = '" . $this->email
            . "', id_privilegio = '" . $this->id_privilegio . "' WHERE id_usuario = '" . $this->id_usuario . "'";
        $verificar = parent::nonQuery($query);
        if ($verificar >= 1) {
            return $verificar;
        } else {
            return 0;
        }
    }
    /**
     * Elimina un usuario de la base de datos por su id de usuario y el token de acceso a la API REST
     */
    public function delete($json)
    {
        $_respuesta = new Respuesta();
        $datos = json_decode($json, true);

        if (!isset($datos['token'])) {
            return $_respuesta->error_401();
        } else {
            $this->token = $datos['token'];
            $arrayToken = $this->buscarToken();
            if ($arrayToken) {
                if (!isset($datos['id_usuario'])) {
                    return $_respuesta->error_400();
                } else {
                    $this->id_usuario = $datos['id_usuario'];
                    $verificar = $this->eliminarUsuario();
                    if ($verificar) {
                        $respuesta = $_respuesta->response;
                        $respuesta["result"] = array(
                            "id_usuario" => $this->id_usuario
                        );
                        return $respuesta;
                    } else {
                        return $_respuesta->error_500();
                    }
                }
            } else {
                //El token no es válido
                return $_respuesta->error_401("El token es inválido/incorrecto");
            }
        }
    }
    /**
     * Elimina un usuario de la base de datos por su id y devuelve el id del usuario eliminado o 0 si no se ha podido eliminar
     */
    private function eliminarUsuario()
    {
        $query = "DELETE FROM " . $this->tabla . " WHERE id_usuario = '" . $this->id_usuario . "'";
        $verificar = parent::nonQuery($query);
        if ($verificar >= 1) {
            return $verificar;
        } else {
            return 0;
        }
    }
    /**
     * Busca el token en la base de datos para verificar si es válido o no
     */
    private function buscarToken()
    {
        $query = "SELECT * FROM tokens WHERE token = '" . $this->token . "' AND id_privilegio IN (1, 64)";
        $verificar = parent::obtenerDatos($query);
        if ($verificar) {
            return $verificar;
        } else {
            return 0;
        }
    }
    
}
