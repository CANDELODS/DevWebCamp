<?php

namespace Model;

class EventosRegistro extends ActiveRecord{
    public static $tabla = 'eventos_registros';
    public static $columnasDB = ['id', 'evento_id', 'registro_id'];

    public $id, $evento_id, $registro_id;

    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? null;
        $this->evento_id = $args['evento_id'] ?? '';
        $this->registro_id = $args['registro_id'] ?? '';
    }
}