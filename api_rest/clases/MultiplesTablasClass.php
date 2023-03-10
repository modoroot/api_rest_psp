<?php
require_once 'conexion/Conexion.php';
require_once 'Respuesta.php';
/**
 * Clase para obtener datos de 3 tablas relacionadas
 */
class MultiplesTablasClass extends Conexion{
    private $tablaUno = "estrella";
    private $tablaDos = "galaxia";
    private $tablaTres = "planeta";
    /**
     * Obtiene los datos de la tabla uno y los devuelve en un array asociativo
     */
    private function getListaRegistrosTablaUno() {
        $query = "SELECT * FROM $this->tablaUno";
        $datos = parent::obtenerDatos($query);
        return ($datos);
    }
    /**
     * Obtiene los datos de la tabla dos y los devuelve en un array asociativo
     */
    private function getListaRegistrosTablaDos() {
        $query = "SELECT * FROM $this->tablaDos";
        $datos = parent::obtenerDatos($query);
        return ($datos);
    }
    /**
     * Obtiene los datos de la tabla tres y los devuelve en un array asociativo
     */
    private function getListaRegistrosTablaTres() {
        $query = "SELECT * FROM $this->tablaTres";
        $datos = parent::obtenerDatos($query);
        return ($datos);
    }

/**
 * Obtiene los datos de 3 tablas relacionadas y devuelve un objeto array con los datos
 */
public function getRegistrosTresTablas() {
    //Instancia de la clase Respuesta
    $respuesta = new Respuesta();
    
    //Registros de la tabla uno
    $datosTablaUno = $this->getListaRegistrosTablaUno();
    
    //Registros de la tabla dos
    $datosTablaDos = $this->getListaRegistrosTablaDos();
    
    //Registros de la tabla tres
    $datosTablaTres = $this->getListaRegistrosTablaTres();
    
    //Almacena los datos de las tres tablas en un array
    $datos = array(
        "tablaUno" => $datosTablaUno,
        "tablaDos" => $datosTablaDos,
        "tablaTres" => $datosTablaTres
        );
    
    //Devuelve los datos en un array
    return $datos;
    }

}