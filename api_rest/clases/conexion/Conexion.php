<?php

/**
 * Clase que conecta con la base de datos y devuelve los datos
 * @author amna
 * @version 1.0
 */
class Conexion
{
    // Atributos de la clase
    private $server;
    private $user;
    private $password;
    private $database;
    private $port;
    private $conexion;

    /**
     * Conexion constructor. Obtiene los datos de la conexión a la base de datos desde el archivo config
     */
    public function __construct()
    {
        $listaDatos = $this->datosConexion();
        // Recorremos el array para obtener los datos de la conexión
        // y los guardamos en las variables
        foreach ($listaDatos as $key => $value) {
            $this->server = $value["server"];
            $this->user = $value["user"];
            $this->password = $value["password"];
            $this->database = $value["database"];
            $this->port = $value["port"];
        }
        // Creamos la conexión a la base de datos
        $this->conexion = new mysqli($this->server, $this->user, $this->password, $this->database, $this->port);
        // Comprobamos si hay algún error en la conexión
        if ($this->conexion->connect_errno) {
            echo "Fallo al conectar a MySQL: (" . $this->conexion->connect_errno . ") " . $this->conexion->connect_error;
            die();
        }
    }

    /**
     * Obtiene los datos de la conexión a la base de datos desde el archivo config
     */
    private function datosConexion()
    {
        $direccion = dirname(__FILE__);
        $jsondata = file_get_contents($direccion . "/" . "config");
        return json_decode($jsondata, true);
    }

    /**
     * Convierte los datos a UTF-8 para que no haya problemas con los acentos y caracteres especiales
     * @param $array
     */
    private function convertirUTF8($array)
    {
        array_walk_recursive($array, function (&$item, $key) {
            if (!mb_detect_encoding($item, 'utf-8', true)) {
                $item = utf8_encode($item);
            }
        });
        return $array;
    }

    /**
     * Obtiene los datos de la base de datos y los devuelve en un array asociativo
     * @param $sqlstr
     */
    public function obtenerDatos($sqlstr)
    {
        $resultado = $this->conexion->query($sqlstr);
        $datosArray = array();
        foreach ($resultado as $key) {
            $datosArray[] = $key;
        }
        return $this->convertirUTF8($datosArray);
    }

    /**
     * Obtiene los datos de la base de datos y los devuelve en un array asociativo
     * y devuelve el número de filas afectadas
     * @param $sqlstr
     */
    public function nonQuery($sqlstr)
    {
        $resultado = $this->conexion->query($sqlstr);
        return $this->conexion->affected_rows;
    }

    /**
     * Obtiene los datos de la base de datos y los devuelve en un array asociativo
     * y devuelve el id del registro insertado
     * @param $sqlstr
     */
    public function nonQueryId($sqlstr)
    {
        $resultado = $this->conexion->query($sqlstr);
        $filasAfectadas = $this->conexion->affected_rows;
        if ($filasAfectadas >= 1) {
            return $this->conexion->insert_id;
        }else{
            return 0;
        }
    }
    protected function encriptar($pass){
        return sha1($pass);
    }
}