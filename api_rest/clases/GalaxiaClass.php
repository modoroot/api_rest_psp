<?php
require_once 'conexion/Conexion.php';
require_once 'Respuesta.php';

class GalaxiaClass extends Conexion
{
    private $tabla = "galaxia";
    private $id_galaxia = "";
    private $nombre = "";
    private $id_estrella = "";


    public function listaElementos()
    {
        $query = "SELECT * FROM " . $this->tabla ." ";
        $datos = parent::obtenerDatos($query);
        return ($datos);
    }
    /**
     * Lista los usuarios de la base de datos y los devuelve en un array asociativo paginado de 3 en 3
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
     * Obtiene los datos de un usuario a través de su id de usuario y los devuelve en un array asociativo
     */
    public function obtenerUno($id_galaxia)
    {
        $query = "SELECT * FROM " . $this->tabla . " WHERE id_galaxia = $id_galaxia";
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
        if (!isset($datos['nombre'])) {
            return $_respuesta->error_400();
        } else {
            $this->id_galaxia = $datos['id_galaxia'];
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
     * Actualiza un usuario en la base de datos por su id de usuario y el id_satelite
     * de acceso a la API REST
     */
    public function put($json){
        $_respuesta = new Respuesta();
        $datos = json_decode($json, true);
        if (!isset($datos['id_galaxia'])) {
            return $_respuesta->error_400();
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
                $respuesta["result"] = array("id_estrella" => $this->id_estrella);
                return $respuesta;
            } else {
                return $_respuesta->error_500("Error al actualizar");
            }
        }
    }

    /**
     * Actualiza un usuario en la base de datos por su id de usuario y el id_satelite
     * de acceso a la API REST
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
     * Elimina un usuario de la base de datos por su id de usuario y el id_satelite
     * de acceso a la API REST
     */
    public function delete($json)
    {
        $_respuesta = new Respuesta();
        $datos = json_decode($json, true);
        if (!isset($datos['id_galaxia'])) {
            return $_respuesta->error_400();
        } else {
            $this->id_estrella = $datos['id_galaxia'];
            $verificar = $this->eliminar();
            if ($verificar) {
                $respuesta = $_respuesta->response;
                $respuesta["result"] = array("id_galaxia" => $this->id_estrella);
                return $respuesta;
            } else {
                return $_respuesta->error_500();
            }
        }
    }

    /**
     * Elimina un planeta de la base de datos por su id y devuelve el ID del planeta eliminado o 0 si no se ha podido eliminar
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

}
