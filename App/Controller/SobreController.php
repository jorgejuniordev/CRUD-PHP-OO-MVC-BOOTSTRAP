<?php

namespace App\Controller;

class SobreController
{
    public function index()
    {
        // Twig
        $loader = new \Twig\Loader\FilesystemLoader('App/View');
        $twig = new \Twig\Environment($loader);
        $template = $twig->load('sobre.html');

        // Parametros
        $parametros = array();

        // Renderiza os elementos e armazena na variável
        $conteudo = $template->render($parametros);

        // Exibe o conteúdo final
        echo $conteudo;
    }
}
