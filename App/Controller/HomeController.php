<?php

namespace App\Controller;

use App\Model\Postagem;
use Exception;

class HomeController
{
    public function index()
    {
        try {
            $postagens = Postagem::selecionaTodos();

            $loader = new \Twig\Loader\FilesystemLoader('App/View');
            $twig = new \Twig\Environment($loader);
            $template = $twig->load('home.html');

            // Elementos / Parametros
            $parametros = array();
            $parametros['postagens'] = $postagens;

            // Renderiza os elementos e armazena na variável
            $conteudo = $template->render($parametros);

            // Exibe o conteúdo final
            echo $conteudo;
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }
}
