<?php

namespace App\Controller;

use App\Model\Postagem;
use App\Model\Comentario;
use Exception;

class PostagemController
{
    public function index($params)
    {
        try {
            // Pega o objeto
            $postagem = Postagem::selecionaPostagem($params);

            // Twig
            $loader = new \Twig\Loader\FilesystemLoader('App/View');
            $twig = new \Twig\Environment($loader);
            $template = $twig->load('postagem.html');

            // Parametros
            $parametros = array(
                "id" => $postagem->id,
                "titulo" => $postagem->titulo,
                "conteudo" => $postagem->conteudo,
                "data" => $postagem->data_postado,
                "comentarios" => $postagem->comentarios
            );

            // Renderiza os elementos e armazena na variável
            $conteudo = $template->render($parametros);

            // Exibe o conteúdo final
            echo $conteudo;
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    public function insert($params)
    {
        try {
            Comentario::insert($_POST);
            echo '<script>alert("Comentário inserido com sucesso!");</script>';
        } catch (Exception $e) {
            echo '<script>alert("' . $e->getMessage() . '");</script>';
        }

        echo '<script>location.href="index.php?pagina=' . (!empty($_POST['id']) ? 'postagem&id=' . $_POST['id'] : 'home') . '"</script>';
    }
}
