<?php

namespace Controllers;

use Classes\Paginacion;
use MVC\Router;
use Model\Ponente;
use Intervention\Image\ImageManagerStatic as Image;

class PonentesController {
    public static function index(Router $router){
        //Proteger Ruta
        if(!isAdmin()){
            header('Location: /login');
        }
        //PAGINACIÓN
        //Obtenemos La Página Actual De La URL
        $pagina_actual = $_GET['page'];
        //Verificamos Que Sea Un Entero
        $pagina_actual = filter_var($pagina_actual, FILTER_VALIDATE_INT);
        if(!$pagina_actual || $pagina_actual < 1){ //Si Es Un Número Negativo
            header('Location: /admin/ponentes?page=1');
        }
        $registros_por_pagina = 10;
        $total_registros = Ponente::total();
        $paginacion = new Paginacion($pagina_actual, $registros_por_pagina, $total_registros);
        // debuguear($paginacion->paginaSiguiente());
        //FIN PAGINACIÓN
        $ponentes = Ponente::all();
        $router->render('admin/ponentes/index',[
            'titulo' => 'Ponentes / Conferencistas',
            'ponentes' => $ponentes
        ]);
    }
    
    public static function crear(Router $router){
        //Proteger Ruta
        if(!isAdmin()){
            header('Location: /login');
        }
        $alertas = [];
        $ponente = new Ponente;

        if($_SERVER['REQUEST_METHOD'] === 'POST'){
        //Proteger Ruta
        if(!isAdmin()){
            header('Location: /login');
        }
            //Leer Imagen $_File['image] : 'imagen' Viene Del Name Del Formulario En Su Campo De Imagen
            if(!empty($_FILES['imagen']['tmp_name'])){
                //Pasos Para Procesar Y Generar Versiones De Imagenes
                //Crear Carpeta Para Las Imagenes Y Revisar Si Existe O No
                $carpeta_imagenes = '../public/img/speakers';
                if(!is_dir($carpeta_imagenes)){
                    mkdir($carpeta_imagenes, 0755, true);
                }
                //Generar Versiones PNG O WebP (1ero Instanciar Intervetion Image)
                //La Imagen Será De 800 x 800, Formato png y Webp y Calidad 80
                $imagen_png = Image::make($_FILES['imagen']['tmp_name'])->fit(800,800)->encode('png', 80);
                $imagen_webp = Image::make($_FILES['imagen']['tmp_name'])->fit(800,800)->encode('webp', 80);
                //Creamos Nombre Aleatorio Para La Imagen
                $nombre_imagen = md5( uniqid( rand(), true));
                //Pasamos El Nombre De La Imagen Al Post Que Es Lo Que Enviaremos A La BD
                $_POST['imagen'] = $nombre_imagen;
                //EN ESTE MOMENTO TENEMOS LA IMAGEN EN MEMORIA PERO NO LA HEMOS GUARDADO
            }
            //En ActiveRecord.php La Función Guardar Tiene Otra Función Llamda Sanitizar, La Cual Retorna Un
            //String, En Este Caso Nos Causaríá Un Problema Ya Que Las Redes Que Tenemos En EL Form Son Un
            //Arreglo El Cual No Se Puede Sanitizar, Por Lo Cual Debemos Pasarlo A Json Para Que Lo Convierta
            //En String Y Así Insertar El Registro Sin Ningún Problema
            $_POST['redes'] = json_encode($_POST['redes'], JSON_UNESCAPED_SLASHES);
            $ponente->sincronizar($_POST);
            //Validar
            $alertas = $ponente->validar();
            //Guardar El Registro
            if(empty($alertas)){
                //GUARDAR LAS IMAGENES
                $imagen_png->save($carpeta_imagenes . '/' . $nombre_imagen . 'png');
                $imagen_webp->save($carpeta_imagenes . '/' . $nombre_imagen . 'webp');
                //Guardar El Registro En La BD
                $resultado = $ponente->guardar();
                if($resultado){
                    header('Location: /admin/ponentes');
                }
            }
        }
        //Rellenar El Espacio De Redes Del Formulario
        $redes = json_decode($ponente->redes);
        $router->render('admin/ponentes/crear',[
            'titulo' => 'Registar Ponente',
            'alertas' => $alertas,
            'ponente' => $ponente,
            'redes' => $redes
        ]);
    }

    public static function editar(Router $router){
        //Proteger Ruta
        if(!isAdmin()){
            header('Location: /login');
        }
        $alertas = [];
        //Validar ID
        $id = $_GET['id'];
        $id = filter_var($id, FILTER_VALIDATE_INT);

        if(!$id){
            header('Location: /admin/ponentes');
        }

        //Obtener El Ponenten A Editar
        $ponente = Ponente::find($id);
      
        if(!$ponente){
            header('Location: /admin/ponentes');
        }

        //Variable Auxiliar (Existirá En La Función Editar Pero No En Crear) Nos Servirá Para Mostrar La Img Actual
        $ponente->imagen_actual = $ponente->imagen;

        //Rellenar El Espacio De Redes Del Formulario
        $redes = json_decode($ponente->redes);

        if($_SERVER['REQUEST_METHOD'] === 'POST'){
        //Proteger Ruta
        if(!isAdmin()){
            header('Location: /login');
        }
            //Verificar Si Hay Una Nueva Imagen
            if(!empty($_FILES['imagen']['tmp_name'])){
                $carpeta_imagenes = '../public/img/speakers';
                // Eliminar la imagen previa
                unlink($carpeta_imagenes . '/' . $ponente->imagen_actual . ".png" );
                unlink($carpeta_imagenes . '/' . $ponente->imagen_actual . ".webp" );

                if(!is_dir($carpeta_imagenes)){
                    mkdir($carpeta_imagenes, 0755, true);
                }

                $imagen_png = Image::make($_FILES['imagen']['tmp_name'])->fit(800,800)->encode('png', 80);
                $imagen_webp = Image::make($_FILES['imagen']['tmp_name'])->fit(800,800)->encode('webp', 80);

                $nombre_imagen = md5( uniqid( rand(), true));

                $_POST['imagen'] = $nombre_imagen;

            }else{
                //Si No Colocamos Una Imagen Nueva Dejamos La Que Tiene Actualmente
                $_POST['imagen'] = $ponente->imagen_actual;
            }
            //Evitar Conflicto Con ActiveRecord Al Intentar Sanitizar Un Arreglo
            $_POST['redes'] = json_encode($_POST['redes'], JSON_UNESCAPED_SLASHES);
            //Sincronizar El Modelo Con El Post Actual
            $ponente->sincronizar($_POST);
            //Validar (Campos Del Formulario)
            $alertas = $ponente->validar();

            if(empty($alertas)){
                //Si Hay Una Imagen Nueva Entonces:
                if(isset($nombre_imagen)){
                //GUARDAR LAS IMAGENES
                $imagen_png->save($carpeta_imagenes . '/' . $nombre_imagen . '.png');
                $imagen_webp->save($carpeta_imagenes . '/' . $nombre_imagen . '.webp');
                }
                //Actualizar El Registro
                $resultado = $ponente->guardar();
                if($resultado){
                    header('Location: /admin/ponentes');
                }
            }
        }

        $router->render('admin/ponentes/editar',[
            'titulo' => 'Editar Ponente',
            'alertas' => $alertas,
            'ponente' => $ponente,
            'redes' => $redes
        ]);
    }

    public static function eliminar(){
        //Proteger Ruta
        if(!isAdmin()){
            header('Location: /login');
        }

        if($_SERVER['REQUEST_METHOD'] === 'POST'){
        //Proteger Ruta
        if(!isAdmin()){
            header('Location: /login');
        }
            //Recuperar El Id
            $id = $_POST['id'];
            //Traemos La Información Del Ponente A Eliminar
            $ponente = Ponente::find($id);
            //Verificar Si Existe
            if(isset($ponente)){
                header('Location: /admin/ponentes');
            }
            //Eliminar Imagen Del Ponente
            if ($ponente->imagen) {
                $carpeta_imagenes = '../public/img/speakers';
                unlink($carpeta_imagenes . '/' . $ponente->imagen . ".png");
                unlink($carpeta_imagenes . '/' . $ponente->imagen . ".webp");
            }
            //Eliminar El Ponente
            $resultado = $ponente->eliminar();
            if($resultado){
                header('Location: /admin/ponentes');
            }
        }
    }
    
}