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
    //Determinamos Cuantos Registros Vamos A Mostrar Por Página (Pag1: 1-10, Pag2: 11-20, Pag3: 21-30)
    public function offset(){
        return $this->registros_por_pagina * ($this->pagina_actual - 1);
    }
    //Obtenemos El Total De Las Páginas (10 / 2 = 5 Páginas)
    public function totalPaginas(){
        //La Función Cielo Redondea Hacia Arriba
        return ceil($this->total_registros / $this->registros_por_pagina);
    }
    //Obtenemos El Valor De La Página Anterior (3(Página Actual) - 1 = Pagina Anterior = 2)
    public function paginaAnterior(){
        $anterior = $this->pagina_actual - 1;
        //Si Anterior Es Mayor A 0 Lo Retornamos, Si No, Retornamos False
        return ($anterior > 0) ? $anterior : false;
    }
    //Obtenemos El Valor De La Página Siguiente (3(Pagina Actual) + 1 = Página Siguiente = 4)
    public function paginaSiguiente(){
        $siguiente = $this->pagina_actual + 1;
        return ($siguiente <= $this->totalPaginas()) ? $siguiente : false;
    }
    //Con Esta Función Mostramos El Enlace Para Retroceder En La Paginación (Solo Si Se Puede Retroceder)
    public function enlaceAnterior(){
        $html = '';
        if($this->paginaAnterior()){
            $html .= "<a class=\"paginacion__enlace paginacion__enlace--texto\" href=\"?page={$this->paginaAnterior()}\">&laquo; Anterior</a>";
        }
        return $html;
    }
    //Con Esta Función Mostramos El Enlace Para Avanzar En La Paginación (Solo Si Se Puede Avanzarr)
    public function enlaceSiguiente(){
        $html = '';
        if($this->paginaSiguiente()){
            $html .= "<a class=\"paginacion__enlace paginacion__enlace--texto\" href=\"?page={$this->paginaSiguiente()}\">Siguiente &raquo;</a>";
        }
        return $html;
    }
    //
    public function numerosPagina(){
        $html = '';
        for($i = 1; $i<= $this->totalPaginas(); $i++){
            if($i === $this->pagina_actual){
                $html .= "<span class=\"paginacion__enlace paginacion__enlace--actual\">{$i}</span>";
            }else{
                $html .= "<a class=\"paginacion__enlace paginacion__enlace--numero\" href=\"?page={$i} \">{$i}</a>";
            }
        }
        return $html;
    }

    //Esta Función Mostramos Los Enlaces Creados Anteriormente Ya Que Es La Que Vamos A Mandar A La Vista
    public function paginacion(){
        $html = '';
        if($this->total_registros > 1){
            $html .= '<div class="paginacion">';
            $html .= $this->enlaceAnterior();
            $html .= $this->numerosPagina();
            $html .= $this->enlaceSiguiente();
            $html .= '</div>';
        }
        return $html;
    }
}