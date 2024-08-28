<?php

namespace Controllers;

use Model\Dia;
use Model\Hora;
use MVC\Router;
use Model\Evento;
use Model\Ponente;
use Model\Categoria;

class PaginasController{

    public static function index(Router $router){
        $router->render('paginas/index',[
            'titulo' => 'Inicio'
        ]);
        }

        public static function evento(Router $router){
            $router->render('paginas/devwebcamp',[
                'titulo' => 'Sobre DevWebCamp'
            ]);
        }

        public static function paquetes(Router $router){
            $router->render('paginas/paquetes',[
                'titulo' => 'Paquetes DevWebCamp'
            ]);
        }

        public static function conferencias(Router $router){
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
            $router->render('paginas/conferencias',[
                'titulo' => 'Workshops & Conferencias',
                'eventos' => $eventos_formateados
            ]);
        }
    
}