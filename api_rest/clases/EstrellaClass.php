<?php
require_once 'conexion/Conexion.php';
require_once 'Respuesta.php';

class EstrellaClass extends Conexion
{
    private $tabla = "estrella";
    private $id_estrella = "";
    private $nombre = "";
    private $gravedad = "";
    private $radio = "";
    private $masa = "";
    private $velocidad_escape = "";
    private $id_galaxia = "";
    private $token_id = "";
    private $email = "";

    public function listaElementos()
    {
        $query = "SELECT * FROM " . $this->tabla . " ";
        $datos = parent::obtenerDatos($query);
        return ($datos);
    }
    /**
     * Lista los registros de la base de datos y los devuelve en un array asociativo paginado de 3 en 3
     * @param int $pagina
     * @return array
     */
    public function listaPorPagina($pagina = 1)
    {
        $inicio = 0;
        $cantidad = 3;
        if ($pagina > 1) {
            $inicio = ($cantidad * ($pagina - 1)) + 1;
            $cantidad = $cantidad * $pagina;
        }
        $query = "SELECT * FROM " . $this->tabla . " LIMIT $inicio, $cantidad";
        $datos = parent::obtenerDatos($query);
        return ($datos);
    }

    /**
     * Obtiene los datos de un registro a través de su id y los devuelve en un array asociativo
     */
    public function obtenerUno($id_estrella)
    {
        $query = "SELECT * FROM " . $this->tabla . " WHERE id_estrella = $id_estrella";
        $datos = parent::obtenerDatos($query);
        return ($datos);
    }

    /**
     * Se añade un nuevo registro a la base de datos a través de un JSON recibido por POST
     */
    public function post($json)
    {
        $_respuesta = new Respuesta();
        $datos = json_decode($json, true);
        if (!isset($datos['token_id']) || !isset($datos['email'])) {
            return $_respuesta->error_400("No se ha enviado el token o el email");
        } else {
            $this->token_id = $datos['token_id'];
            $this->email = $datos['email'];
            $arrayToken = $this->buscarTokenEmail();
            if ($arrayToken) {
                if (!isset($datos['nombre'])) {
                    return $_respuesta->error_400("El nombre es obligatorio");
                } else {
                    $this->nombre = $datos['nombre'];
                    $this->gravedad = $datos['gravedad'];
                    $this->radio = $datos['radio'];
                    $this->masa = $datos['masa'];
                    $this->velocidad_escape = $datos['velocidad_escape'];
                    $this->id_galaxia = $datos['id_galaxia'];
                    $verificar = $this->insertar();
                    if ($verificar) {
                        $respuesta = $_respuesta->response;
                        $respuesta["result"] = array("id_estrella" => $verificar);
                        return $respuesta;
                    } else {
                        return $_respuesta->error_500();
                    }
                }
            } else {
                return $_respuesta->error_401("El token o el email no son correctos");
            }
        }
    }

    /**
     * Inserta un usuario en la base de datos
     */
    private function insertar()
    {
        $query = "INSERT INTO " . $this->tabla . " (nombre, gravedad, radio, masa, velocidad_escape, id_galaxia) VALUES ('"
            . $this->nombre . "', '" . $this->gravedad . "', '" . $this->radio . "', '" . $this->masa . "', '"
            . $this->velocidad_escape . "', '" . $this->id_galaxia . "')";
        $verificar = parent::nonQueryId($query);
        if ($verificar) {
            return $verificar;
        } else {
            return 0;
        }
    }

    /**
     * Actualiza un registro en la base de datos a través de un JSON recibido por PUT
     */
    public function put($json)
    {
        $_respuesta = new Respuesta();
        $datos = json_decode($json, true);

        if (!isset($datos['token_id']) || !isset($datos['email'])) {
            return $_respuesta->error_400("No se ha enviado el token o el email");
        } else {
            $this->token_id = $datos['token_id'];
            $this->email = $datos['email'];
            $arrayToken = $this->buscarTokenEmail();
            if ($arrayToken) {
                if (!isset($datos['id_estrella'])) {
                    return $_respuesta->error_400("El id_estrella es obligatorio");
                } else {
                    $this->id_estrella = $datos['id_estrella'];
                    if (isset($datos['nombre'])) {
                        $this->nombre = $datos['nombre'];
                    }
                    if (isset($datos['gravedad'])) {
                        $this->gravedad = $datos['gravedad'];
                    }
                    if (isset($datos['radio'])) {
                        $this->radio = $datos['radio'];
                    }
                    if (isset($datos['masa'])) {
                        $this->masa = $datos['masa'];
                    }
                    if (isset($datos['velocidad_escape'])) {
                        $this->velocidad_escape = $datos['velocidad_escape'];
                    }
                    if (isset($datos['id_galaxia'])) {
                        $this->id_galaxia = $datos['id_galaxia'];
                    }
                    $verificar = $this->actualizar();
                    if ($verificar) {
                        $respuesta = $_respuesta->response;
                        $respuesta["result"] = array("id_estrella" => $this->id_estrella);
                        return $respuesta;
                    } else {
                        return $_respuesta->error_500("Error al actualizar");
                    }
                }
            } else {
                return $_respuesta->error_401("El token o el email no son correctos");
            }
        }
    }

    /**
     * Actualiza un usuario en la base de datos por su id de usuario y el id_satelite
     * de acceso a la API REST
     */
    private function actualizar()
    {
        $query = "UPDATE " . $this->tabla . " SET nombre = '" . $this->nombre . "', gravedad = '" . $this->gravedad
            . "', radio = '" . $this->radio . "', masa = '" . $this->masa . "', velocidad_escape = '" . $this->velocidad_escape
            . "', id_galaxia = '" . $this->id_galaxia . "' WHERE id_estrella = " . $this->id_estrella;
        $verificar = parent::nonQuery($query);

        if ($verificar >= 1) {
            return $verificar;
        } else {
            return 0;
        }
    }

    /**
     * Elimina un registro de la base de datos a través de un JSON recibido por DELETE
     */
    public function delete($json)
    {
        $_respuesta = new Respuesta();
        $datos = json_decode($json, true);
        if (!isset($datos['token_id']) || !isset($datos['email'])) {
            return $_respuesta->error_400("No se ha enviado el token o el email");
        } else {
            $this->token_id = $datos['token_id'];
            $this->email = $datos['email'];
            $arrayToken = $this->buscarTokenEmail();
            if ($arrayToken) {
                if (!isset($datos['id_estrella'])) {
                    return $_respuesta->error_400("El id_estrella es obligatorio");
                } else {
                    $this->id_estrella = $datos['id_estrella'];
                    $verificar = $this->eliminar();
                    if ($verificar) {
                        $respuesta = $_respuesta->response;
                        $respuesta["result"] = array("id_estrella" => $this->id_estrella);
                        return $respuesta;
                    } else {
                        return $_respuesta->error_500();
                    }
                }
            } else {
                return $_respuesta->error_401("El token o el email no son correctos");
            }
        }
    }

    /**
     * Elimina un planeta de la base de datos por su id y devuelve el ID del planeta eliminado o 0 si no se ha podido eliminar
     */
    private function eliminar()
    {
        $query = "DELETE FROM " . $this->tabla . " WHERE id_estrella = '" . $this->id_estrella . "'";
        $verificar = parent::nonQuery($query);
        if ($verificar >= 1) {
            return $verificar;
        } else {
            return 0;
        }
    }

    /**
     * Busca un access_token en la base de datos por su id y devuelve el token o 0 si no se ha encontrado
     */
    private function buscarTokenEmail()
    {
        $query = "SELECT token_id, email FROM access_tokens WHERE token_id = '$this->token_id' AND email = '$this->email'";
        $verificar = parent::obtenerDatos($query);
        if ($verificar) {
            return $verificar;
        } else {
            return 0;
        }
    }
}
