<?php

namespace Controllers;

use Model\EventoHorario;

class APIEventos{

    public static function index(){
        //Pasamos La Categoria id Y El Día ID
        $dia_id = $_GET['dia_id'] ?? '';
        $categoria_id = $_GET['categoria_id'] ?? '';

        $dia_id = filter_var($dia_id, FILTER_VALIDATE_INT);
        $categoria_id = filter_var($categoria_id, FILTER_VALIDATE_INT);

        //Hacemos Los Campos Obligatorios
        if(!$dia_id || !$categoria_id){
            echo json_encode([]);
            return; //Con Esto Evitamos Error En La Consulta Que Hacemos Con El whereArray()
        }

        //Consultar BD
        //Pasamos Los Valores Del Where (Llave, valor)
        $eventos = EventoHorario::whereArray(['dia_id' => $dia_id, 'categoria_id' => $categoria_id]) ?? [];

        echo json_encode($eventos);
    }
}