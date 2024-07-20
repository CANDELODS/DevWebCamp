<?php

namespace Classes;

class Paginacion{
    public $pagina_actual;
    public $registros_por_pagina;
    public $total_registros;

    public function __construct($pagina_actual = 1, $registros_por_pagina = 10, $total_registros = 0)
    {
        $this->pagina_actual = (int) $pagina_actual;
        $this->registros_por_pagina = (int) $registros_por_pagina;
        $this->total_registros = (int) $total_registros;
    }

    public function offset(){
        return $this->registros_por_pagina * ($this->pagina_actual - 1);
    }

    public function totalPaginas(){
        //La Función Cielo Redondea Hacia Arriba
        return ceil($this->total_registros / $this->registros_por_pagina);
    }

    public function paginaAnterior(){
        $anterior = $this->pagina_actual - 1;
        //Si Anterior Es Mayor A 0 Lo Retornamos, Si No, Retornamos False
        return ($anterior > 0) ? $anterior : false;
    }

    public function paginaSiguiente(){
        $siguiente = $this->pagina_actual + 1;
        return ($siguiente <= $this->totalPaginas()) ? $siguiente : false;
    }
}