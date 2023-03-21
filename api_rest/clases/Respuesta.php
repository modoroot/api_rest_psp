<?php

/**
 * Clase que contiene los métodos para devolver las respuestas de la API REST
 * @author amna
 * @version 1.0
 */
class Respuesta
{
    /**
     * @var array Respuesta por defecto en caso de éxito
     */
    public $response = [
        "status" => "ok",
        "result" => array()
    ];

    /**
     * @return array Método no permitido
     */
    public function error_405()
    {
        $this->response['status'] = "error";
        $this->response['result'] = array(
            "error_id" => "405",
            "error_msg" => "Método no permitido"
        );
        return $this->response;
    }

    /**
     * @return array Datos incorrectos
     */
    public function error_200($string = "Datos incorrectos")
    {
        $this->response['status'] = "error";
        $this->response['result'] = array(
            "error_id" => "200",
            "error_msg" => $string
        );
        return $this->response;
    }

    /**
     *
     * @return array Solicitud incorrecta
     */
    public function error_400($string)
    {
        $this->response['status'] = "error";
        $this->response['result'] = array(
            "error_id" => "400",
            "error_msg" => $string
        );
        return $this->response;
    }

    /**
     *
     * @return array Error interno del servidor
     */
    public function error_500($string = "Error interno del servidor")
    {
        $this->response['status'] = "error";
        $this->response['result'] = array(
            "error_id" => "500",
            "error_msg" => $string
        );
        return $this->response;
    }

    /**
     * @return array No autorizado
     */
    public function error_401($string = "No autorizado")
    {
        $this->response['status'] = "error";
        $this->response['result'] = array(
            "error_id" => "401",
            "error_msg" => $string
        );
        return $this->response;
    }
    
}