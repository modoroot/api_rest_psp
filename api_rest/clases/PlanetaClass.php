<?php
require_once 'conexion/Conexion.php';
require_once 'Respuesta.php';

class PlanetaClass extends Conexion
{
    private $tabla = "planeta";
    private $id_planeta = "";
    private $nombre = "";
    private $gravedad = "";
    private $radio = "";
    private $masa = "";
    private $velocidad_escape = "";
    private $id_satelite = "";


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
    public function obtenerUno($id_planeta)
    {
        $query = "SELECT * FROM " . $this->tabla . " WHERE id_planeta = $id_planeta";
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
            $this->nombre = $datos['nombre'];
            $this->gravedad = $datos['gravedad'];
            $this->radio = $datos['radio'];
            $this->masa = $datos['masa'];
            $this->velocidad_escape = $datos['velocidad_escape'];
            $this->id_satelite = $datos['id_satelite'];
            $verificar = $this->insertar();
            if ($verificar) {
                $respuesta = $_respuesta->response;
                $respuesta["result"] = array("id_planeta" => $verificar);
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
        $query = "INSERT INTO " . $this->tabla . " (nombre, gravedad, radio, masa, velocidad_escape, id_satelite) VALUES ('"
            . $this->nombre . "', '" . $this->gravedad . "', '" . $this->radio . "', '" . $this->masa . "', '"
            . $this->velocidad_escape . "', '" . $this->id_satelite . "')";
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
        if (!isset($datos['id_planeta'])) {
            return $_respuesta->error_400();
        } else {
            $this->id_planeta = $datos['id_planeta'];
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
            if (isset($datos['id_satelite'])) {
                $this->id_satelite = $datos['id_satelite'];
            }
            $verificar = $this->actualizar();
            if ($verificar) {
                $respuesta = $_respuesta->response;
                $respuesta["result"] = array("id_planeta" => $this->id_planeta);
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
        $query = "UPDATE " . $this->tabla . " SET nombre = '" . $this->nombre . "', gravedad = '" . $this->gravedad
            . "', radio = '" . $this->radio . "', masa = '" . $this->masa . "', velocidad_escape = '"
            . $this->velocidad_escape . "', id_satelite = '" . $this->id_satelite . "' WHERE id_planeta = " . $this->id_planeta;
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
        if (!isset($datos['id_planeta'])) {
            return $_respuesta->error_400();
        } else {
            $this->id_planeta = $datos['id_planeta'];
            $verificar = $this->eliminar();
            if ($verificar) {
                $respuesta = $_respuesta->response;
                $respuesta["result"] = array("id_planeta" => $this->id_planeta);
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
        $query = "DELETE FROM " . $this->tabla . " WHERE id_planeta = '" . $this->id_planeta . "'";
        $verificar = parent::nonQuery($query);
        if ($verificar >= 1) {
            return $verificar;
        } else {
            return 0;
        }
    }



}
