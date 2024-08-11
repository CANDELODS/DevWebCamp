<?php

namespace Controllers;

use Classes\Paginacion;
use Model\Categoria;
use Model\Dia;
use Model\Evento;
use Model\Hora;
use Model\Ponente;
use MVC\Router;

class EventosController {
    public static function index(Router $router){
        //PAGINACIÓN
        //Obtenemos La Página Actual De La URL
        $pagina_actual = $_GET['page'];
        //Verificamos Que Sea Un Entero
        $pagina_actual = filter_var($pagina_actual, FILTER_VALIDATE_INT);
        if(!$pagina_actual || $pagina_actual < 1){ //Si Es Un Número Negativo
            header('Location: /admin/eventos?page=1');
        }
        $registros_por_pagina = 10;
        $total_registros = Evento::total();
        $paginacion = new Paginacion($pagina_actual, $registros_por_pagina, $total_registros);
        //Ejemplo, Si Tengo 5 Páginas Y Esa Cantidad Es Menor A 100(Suponiendo Que Manipularon La URL) Entoces:
        if($paginacion->totalPaginas() < $pagina_actual){
            header('Location: /admin/eventos?page=1');
        }   
        $eventos = Evento::paginar($registros_por_pagina, $paginacion->offset());
        //FIN PAGINACIÓN

        //Este ForEach Tiene Como Fin Cruzar Información De La BD Si Necesidad De Crar Un Join Desde
        //El Active Record, Este Itera Cada Evento Y Crea Una LLave La Cual Compara Con Las Que
        //Que Hay En El Modelo De Esa Llave Creada Por Medio De La Función Find De Active Record
        //Con Esto Ya Podemos Acceder A Las Propiedades De Cada Llave Y Mostrarlas, Ver (Views->Admin->Eventos->Index.php)
        foreach($eventos as $evento){
            //Se Crea Una LLave De Categoría Dentro Del Objeto De Eventos Y La Buscamos Por Su Id(En La Tabla De Categoria)
            $evento->categoria = Categoria::find($evento->categoria_id);
            $evento->dia = Dia::find($evento->dia_id);
            $evento->hora = Hora::find($evento->hora_id);
            $evento->ponente = Ponente::find(($evento->ponente_id));
        }
        
        $router->render('admin/eventos/index',[
            'titulo' => 'Conferencias Y WorkShops',
            'eventos' => $eventos,
            'paginacion' => $paginacion->paginacion()
        ]);
    }

    public static function crear(Router $router){
        $alertas = [];

        $categorias = Categoria::all('ASC');
        $dias = Dia::all('ASC');
        $horas = Hora::all('ASC');
        $evento = new Evento;

        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $evento->sincronizar($_POST);
            $alertas = $evento->validar();

            if(empty($alertas)){
                $resultado = $evento->guardar();
                if($resultado){
                    header('Location: /admin/eventos');
                }
            }
        }

        $router->render('admin/eventos/crear',[
            'titulo' => 'Registrar Evento',
            'alertas' => $alertas,
            'categorias' => $categorias,
            'dias' => $dias,
            'horas' => $horas,
            'evento' => $evento
        ]);
    }

    public static function editar(Router $router){
        $alertas = [];

        $id = $_GET['id'];
        $id = filter_var($id, FILTER_VALIDATE_INT);
        if(!$id){
            header('Location: /admin/eventos');
        }
        $categorias = Categoria::all('ASC');
        $dias = Dia::all('ASC');
        $horas = Hora::all('ASC');
        $evento = Evento::find($id);
        if(!$evento){
            header('Location: /admin/eventos');
        }

        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $evento->sincronizar($_POST);
            $alertas = $evento->validar();

            if(empty($alertas)){
                $resultado = $evento->guardar();
                if($resultado){
                    header('Location: /admin/eventos');
                }
            }
        }

        $router->render('admin/eventos/editar',[
            'titulo' => 'Editar Evento',
            'alertas' => $alertas,
            'categorias' => $categorias,
            'dias' => $dias,
            'horas' => $horas,
            'evento' => $evento
        ]);
    }

}