<?php

function debuguear($variable) : string {
    echo "<pre>";
    var_dump($variable);
    echo "</pre>";
    exit;
}
function s($html) : string {
    $s = htmlspecialchars($html);
    return $s;
}
// Función que revisa que el usuario este autenticado
function isAuth() : bool {
    if(!isset($_SESSION)){
        session_start();
    }
    return isset($_SESSION['nombre']) && !empty($_SESSION);
}

function isAdmin() : bool {
    if(!isset($_SESSION)){
        session_start();
    }
    return isset($_SESSION['admin']) && !empty($_SESSION['admin']);
}

//Iniciar La Superglobal De Session
function iniciarSesion() : void{
    if(!isset($_SESSION)) {
        session_start(); //Iniciamos La Super Global Session
    }
}

function paginaActual($path) : bool{
    //Buscamos Si La Ruta Actual Tiene Lo Que Buscamos
    return str_contains($_SERVER['PATH_INFO'] ?? '/', $path) ? true : false;
}

function aos_animacion(){
    $efectos = ['fade-up', 'fade-down', 'fade-right', 'fade-left', 'flip-left', 'flip-right', 'zoom-in',
                    'zoom-in-up', 'zoom-in-down', 'zoom-out'];
    $efecto = array_rand($efectos, 1); //Nos Retorna Una Posición Aleatoria De Un Arreglo
    echo ' data-aos="' .  $efectos[$efecto] . '" ';
}