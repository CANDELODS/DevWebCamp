<?php

namespace Controllers;

use Model\Dia;
use Model\Hora;
use MVC\Router;
use Model\Evento;
use Model\Paquete;
use Model\Ponente;
use Model\Usuario;
use Model\Registro;
use Model\Categoria;
use Model\Regalo;

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

    public static function pagar(Router $router)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!isAuth()) {
                header('Location: /login');
            }
            //No Tenemos La Otra Comprobración Ya Que La Persona Puede Tener El Plan Gratis Y Quiere Cambiarlo
            //Validar Que Post No Venga Vacio
            if(empty($_POST)){
                echo json_encode([]);
                return;
            }
            //El Post Está LLeno, Entonces Creamos El Registro


            $token = substr(md5(uniqid(rand(), true)), 0, 8);
            //Crear Registro
            $datos = $_POST;
            $datos['token'] = $token;
            $datos['usuario_id'] = $_SESSION['id'];

            try {
                $registro = new Registro($datos);
                $resultado = $registro->guardar();
                echo json_encode($resultado); //Enviamos El Resultado A Views/Registro/Crear.php
            } catch (\Throwable $th) {
                echo json_encode([
                    'resultado' => 'error'
                ]);
            }
        }
    }

    public static function conferencias(Router $router)
    { 
        //VALIDACIONES
        if (!isAuth()) {
            header('Location: /login');
        }
        //Validar Que El Usuario Tenga El Plan Presencial
        $usuario_id = $_SESSION['id'];
        $registro = Registro::where('usuario_id', $usuario_id);
        if($registro->paquete_id !== "1"){
            header('Location: /');
        }
        $eventos = Evento::ordenar('hora_id', 'ASC');
            $eventos_formateados = [];
            foreach($eventos as $evento){
                //Se Crea Una LLave De Categoría Dentro Del Objeto De Eventos Y La Buscamos Por Su Id(En La Tabla De Categoria)
                $evento->categoria = Categoria::find($evento->categoria_id);
                $evento->dia = Dia::find($evento->dia_id);
                $evento->hora = Hora::find($evento->hora_id);
                $evento->ponente = Ponente::find(($evento->ponente_id));
                //Conferencias Viernes
                if($evento->dia_id === "1" AND $evento->categoria_id ==="1"){
                    //Creamos La LLave "conferencias_v = conferencias dia viernes" Para Llenarla Con Los Eventos
                    //Que Cumplan Con La Condición
                    $eventos_formateados['conferencias_v'][] = $evento;
                }
                //Conferencias Sábado
                if($evento->dia_id === "2" AND $evento->categoria_id ==="1"){
                    $eventos_formateados['conferencias_s'][] = $evento;
                }
                //Workshops Viernes
                if($evento->dia_id === "1" AND $evento->categoria_id ==="2"){
                    $eventos_formateados['workshops_v'][] = $evento;
                }
                //Workshops Sábado
                if($evento->dia_id === "2" AND $evento->categoria_id ==="2"){
                    $eventos_formateados['workshops_s'][] = $evento;
                }
            }

        $regalos = Regalo::all('ASC');
        $router->render('registro/conferencias', [
            'titulo' => 'Elige Workshops Y Conferencias',
            'eventos' => $eventos_formateados,
            'regalos' => $regalos
        ]);
    }
}
