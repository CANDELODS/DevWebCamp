<?php

namespace Controllers;

use MVC\Router;
use Model\Registro;
use Classes\Paginacion;
use Model\Paquete;
use Model\Usuario;

class RegistradosController
{
    public static function index(Router $router)
    {
        //Proteger Ruta
        if (!isAdmin()) {
            header('Location: /login');
        }
        //PAGINACIÓN
        //Obtenemos La Página Actual De La URL
        $pagina_actual = $_GET['page'];
        //Verificamos Que Sea Un Entero
        $pagina_actual = filter_var($pagina_actual, FILTER_VALIDATE_INT);
        if (!$pagina_actual || $pagina_actual < 1) { //Si Es Un Número Negativo
            header('Location: /admin/registrados?page=1');
        }
        $registros_por_pagina = 10;
        $total_registros = Registro::total();
        $paginacion = new Paginacion($pagina_actual, $registros_por_pagina, $total_registros);
        //Ejemplo, Si Tengo 5 Páginas Y Esa Cantidad Es Menor A 100(Suponiendo Que Manipularon La URL) Entoces:
        if ($paginacion->totalPaginas() < $pagina_actual) {
            header('Location: /admin/registrados?page=1');
        }

        $registros = Registro::paginar($registros_por_pagina, $paginacion->offset());
        //FIN PAGINACIÓN
        
        //Cruzar Información Para Mostrarla En La Vista Correctamente
        foreach($registros as $registro){
            $registro->usuario = Usuario::find($registro->usuario_id);
            $registro->paquete = Paquete::find($registro->paquete_id);
        }

        $router->render('admin/registrados/index', [
            'titulo' => 'Usuarios Registrados',
            'registros' => $registros,
            'paginacion' => $paginacion->paginacion()
        ]);
    }
}
