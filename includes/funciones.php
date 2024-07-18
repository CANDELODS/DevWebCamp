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
function isAuth() : void {
    if(!isset($_SESSION['login'])) {
        header('Location: /');
    }
}

//Iniciar La Superglobal De Session
function iniciarSesion() : void{
    if(!isset($_SESSION)) {
        session_start(); //Iniciamos La Super Global Session
    }
}

function paginaActual($path) : bool{
    //Buscamos Si La Ruta Actual Tiene Lo Que Buscamos
    return str_contains($_SERVER['PATH_INFO'], $path) ? true : false;
}