<?php

namespace Controllers;

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
        
        $router->render('admin/dashboard/index',[
            'titulo' => 'Panel De Administración',
            'registros' => $registros
        ]);
    }

}