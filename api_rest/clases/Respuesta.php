<?php

/**
 * Clase que contiene los métodos para devolver las respuestas de la API REST
 * @author amna
 * @version 1.0
 */
class Respuesta
{
    /**
     * $response Array que contiene la respuesta de la API REST
     */
    public $response = [
        "status" => "ok",
        "result" => array()
    ];

    /**
     * @return array Devuelve la respuesta de la API REST
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
     * @return array Devuelve la respuesta de la API REST
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
     * @return array Devuelve la respuesta de la API REST
     */
    public function error_400()
    {
        $this->response['status'] = "error";
        $this->response['result'] = array(
            "error_id" => "400",
            "error_msg" => "Solicitud incorrecta"
        );
        return $this->response;
    }

    /**
     *
     * @return array Devuelve la respuesta de la API REST
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
     * @return array Devuelve la respuesta de la API REST
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