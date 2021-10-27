<?php

namespace App\Core;

use \App\Controller\ComentariosController;
use \App\Controller\ErroController;
use \App\Controller\GerenciarController;
use \App\Controller\HomeController;
use \App\Controller\PostagemController;
use \App\Controller\SobreController;

class Core
{
    public function start($url)
    {
        // Variáveis
        $controller = (isset($url['pagina']) && !empty($url['pagina']) ? ucfirst($url['pagina']) : 'Home') . 'Controller';
        $controller = '\App\Controller\\' . $controller;
        $acao = isset($url['metodo']) && !empty($url['metodo']) ? $url['metodo'] : 'index';

        // Verifica se a classe não existe, atribuindo um valor a variável controller.
        if (!class_exists($controller)) :
            $controller = 'ErroController';
        endif;

        // Definição de id
        $id = isset($url['id']) && !is_null($url['id']) ? $url['id'] : NULL;

        call_user_func_array(array(new $controller, $acao), array('id' => $id));
    }
}
