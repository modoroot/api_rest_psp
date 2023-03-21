<?php

require_once 'conexion/Conexion.php';
require_once 'Respuesta.php';

class GalaxiaClass extends Conexion
{
    private $tabla = "galaxia";
    private $id_galaxia = "";
    private $nombre = "";
    private $id_estrella = "";
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
     * Obtiene los datos de un registro a partir de su id y los devuelve en un array asociativo
     */
    public function obtenerUno($id_galaxia)
    {
        $query = "SELECT * FROM " . $this->tabla . " WHERE id_galaxia = $id_galaxia";
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
            return $_respuesta->error_400("Debe enviar el token y el email");
        } else {
            $this->token_id = $datos['token_id'];
            $this->email = $datos['email'];
            $arrayToken = $this->buscarTokenEmail();
            if($arrayToken){
                if (!isset($datos['nombre'])) {
                    return $_respuesta->error_400("Debe tener al menos un nombre");
                } else {
                    $this->nombre = $datos['nombre'];
                    $this->id_estrella = $datos['id_estrella'];
                    $verificar = $this->insertar();
                    if ($verificar) {
                        $respuesta = $_respuesta->response;
                        $respuesta["result"] = array("id_galaxia" => $verificar);
                        return $respuesta;
                    } else {
                        return $_respuesta->error_500();
                    }
                }
            }else{
                return $_respuesta->error_401("No autorizado");
            }
        }
    }

    /**
     * Inserta un usuario en la base de datos
     */
    private function insertar()
    {
        $query = "INSERT INTO " . $this->tabla . " (nombre, id_estrella) VALUES ('" . $this->nombre . "', '" . $this->id_estrella . "') ";
        $verificar = parent::nonQueryId($query);
        if ($verificar) {
            return $verificar;
        } else {
            return 0;
        }
    }

    /**
     * Actualiza un registro en la base de datos por su id 
     * a partir de un JSON recibido por PUT
     */
    public function put($json)
    {
        $_respuesta = new Respuesta();
        $datos = json_decode($json, true);
        if(!isset($datos['token_id']) || !isset($datos['email'])){
            return $_respuesta->error_400("Falta email o token");
        }else{
            $this->token_id = $datos['token_id'];
            $this->email = $datos['email'];
            $arrayToken = $this->buscarTokenEmail();
            if($arrayToken){
                if (!isset($datos['id_galaxia'])) {
                    return $_respuesta->error_400("Falta id_galaxia");
                } else {
                    $this->id_galaxia = $datos['id_galaxia'];
                    if (isset($datos['nombre'])) {
                        $this->nombre = $datos['nombre'];
                    }
                    if (isset($datos['id_estrella'])) {
                        $this->id_estrella = $datos['id_estrella'];
                    }
                    $verificar = $this->actualizar();
                    if ($verificar) {
                        $respuesta = $_respuesta->response;
                        $respuesta["result"] = array("id_galaxia" => $this->id_galaxia);
                        return $respuesta;
                    } else {
                        return $_respuesta->error_500("Error al actualizar");
                    }
                }
            }else{
                return $_respuesta->error_401("No autorizado");
            }
        }

        
    }

    /**
     * Actualiza un registro de la base de datos por su id_galaxia a partir de la API Rest
     */
    private function actualizar()
    {
        $query = "UPDATE " . $this->tabla . " SET nombre = '" . $this->nombre . "', id_estrella = '"
            . $this->id_estrella . "' WHERE id_galaxia = '" . $this->id_galaxia . "'";
        $verificar = parent::nonQuery($query);

        if ($verificar >= 1) {
            return $verificar;
        } else {
            return 0;
        }
    }

    /**
     * Elimina un registro de la base de datos por su id_galaxia a partir
     * de la API Rest
     */
    public function delete($json)
    {
        $_respuesta = new Respuesta();
        $datos = json_decode($json, true);
        if(!isset($datos['token_id']) || !isset($datos['email'])){
            return $_respuesta->error_400("Falta email o token");
        }else{
            $this->token_id = $datos['token_id'];
            $this->email = $datos['email'];
            $arrayToken = $this->buscarTokenEmail();
            if($arrayToken){
                if (!isset($datos['id_galaxia'])) {
                    return $_respuesta->error_400("Falta id_galaxia");
                } else {
                    $this->id_galaxia = $datos['id_galaxia'];
                    $verificar = $this->eliminar();
                    if ($verificar) {
                        $respuesta = $_respuesta->response;
                        $respuesta["result"] = array("id_galaxia" => $this->id_galaxia);
                        return $respuesta;
                    } else {
                        return $_respuesta->error_500();
                    }
                }
            }else{
                return $_respuesta->error_401("No autorizado");
            }
        }
    }

    /**
     * Elimina un registro de la base de datos por su id y devuelve el ID eliminado o 0 si no se ha podido eliminar
     */
    private function eliminar()
    {
        $query = "DELETE FROM " . $this->tabla . " WHERE id_galaxia = '" . $this->id_galaxia . "'";
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
