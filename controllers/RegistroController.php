<?php

namespace Controllers;

use Model\Paquete;
use Model\Registro;
use Model\Usuario;
use MVC\Router;

class RegistroController
{
    public static function crear(Router $router)
    {
        if (!isAuth()) {
            header('Location: /');
        }
        //Verificar Si El Usuario Ya Tiene Un Plan
        $registro = Registro::where('usuario_id', $_SESSION['id']);

        if (isset($registro) && $registro->paquete_id === "3") {
            header('Location: /boleto?id=' . urlencode($registro->token));
        }
        $router->render('registro/crear', [
            'titulo' => 'Finalizar Registro'
        ]);
    }

    public static function gratis(Router $router)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!isAuth()) {
                header('Location: /login');
            }
            //Verificar Si El Usuario Ya Tiene Un Plan
            $registro = Registro::where('usuario_id', $_SESSION['id']);

            if (isset($registro) && $registro->paquete_id === "3") {
                header('Location: /boleto?id=' . urlencode($registro->token));
            }        //Verificar Si El Usuario Ya Tiene Un Plan
            $registro = Registro::where('usuario_id', $_SESSION['id']);

            if (isset($registro) && $registro->paquete_id === "3") {
                header('Location: /boleto?id=' . urlencode($registro->token));
            }
            //Cortamos Los Primero Caracteres, Ya Que No Necesitamos Un Token Tan Largo
            $token = substr(md5(uniqid(rand(), true)), 0, 8);
            //Crear Registro
            $datos = ['paquete_id' => 3, 'pago_id' => '', 'token' => $token, 'usuario_id' => $_SESSION['id']];

            $registro = new Registro($datos);
            $resultado = $registro->guardar();
            if ($resultado) {
                //UrlEncode Evita Caracteres Especiales
                header('Location: /boleto?id=' . urlencode($registro->token));
            }
        }
    }

    public static function boleto(Router $router)
    {
        //Validar URL
        $id = $_GET['id'];
        if (!$id || !strlen($id) === 8) {
            header('Location: /');
        }
        //Buscar El Registro En La BD
        $registro = Registro::where('token', $id);
        if (!$registro) {
            header('Location: /');
        }
        //Llenar Las Tablas De Referencia
        //Creamos La LLave Usuario La Cual Tendrá La Información Del Modelo De Usuario
        $registro->usuario = Usuario::find($registro->usuario_id);
        $registro->paquete = Paquete::find($registro->paquete_id);

        $router->render('registro/boleto', [
            'titulo' => 'Asistencia A DevWebCamp',
            'registro' => $registro
        ]);
    }
}
