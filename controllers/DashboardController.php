<?php

namespace Controllers;

use Model\Evento;
use Model\Registro;
use Model\Usuario;
use MVC\Router;

class DashboardController {
    public static function index(Router $router){

        //Obtener Ultimos Registros
        $registros = Registro::get(5);
        foreach($registros as $registro){
            $registro->usuario = Usuario::find($registro->usuario_id);
        }

        //Calcular Los Ingresos
         $virtuales = Registro::total('paquete_id', 2);
         $presenciales = Registro::total('paquete_id', 1);
        
        $ingresos = ($virtuales * 46.41) + ($presenciales * 189.54);

        //Obtener Eventos Con Mas Y Menos Lugares Disponibles
        $menosDisponibles = Evento::ordenarLimite('disponibles', 'ASC', 5);
        $masDisponibles = Evento::ordenarLimite('disponibles', 'DESC', 5);

        
        $router->render('admin/dashboard/index',[
            'titulo' => 'Panel De Administración',
            'registros' => $registros,
            'ingresos' => $ingresos,
            'menosDisponibles' => $menosDisponibles,
            'masDisponibles' => $masDisponibles
        ]);
    }

}