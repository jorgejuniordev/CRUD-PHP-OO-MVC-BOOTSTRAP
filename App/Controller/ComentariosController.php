<?php

namespace App\Controller;

use App\Model\Postagem;
use App\Model\Comentario;
use Exception;

class ComentariosController
{
    public function index()
    {
        try {
            $postagens = Postagem::selecionaTodos(true);

            $loader = new \Twig\Loader\FilesystemLoader('App/View');
            $twig = new \Twig\Environment($loader);
            $template = $twig->load('comentarios.html');

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

    public function gerenciar($params)
    {
        try {
            // Pega o objeto
            $postagem = Postagem::selecionaPostagem($params, true);

            // Twig
            $loader = new \Twig\Loader\FilesystemLoader('App/View');
            $twig = new \Twig\Environment($loader);
            $template = $twig->load('comentario.html');

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

    public function deletar()
    {
        try {
            Comentario::delete($_GET);
            echo '<script>alert("Comentário deletado com sucesso!");</script>';
        } catch (Exception $e) {
            echo '<script>alert("' . $e->getMessage() . '");</script>';
        }
        echo '<script>location.href="index.php?pagina=comentarios"</script>';
    }

    // public function update(){}

    // public function delete(){}
}
