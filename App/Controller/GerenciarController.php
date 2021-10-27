<?php

namespace App\Controller;

use App\Model\Postagem;
use Exception;

class GerenciarController
{
    public function index()
    {
        try {
            $postagens = Postagem::selecionaTodos();

            $loader = new \Twig\Loader\FilesystemLoader('App/View');
            $twig = new \Twig\Environment($loader);
            $template = $twig->load('gerenciar.html');

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

    public function criar()
    {
        $loader = new \Twig\Loader\FilesystemLoader('App/View');
        $twig = new \Twig\Environment($loader);
        $template = $twig->load('criarNoticia.html');

        // Elementos / Parametros
        $parametros = array();

        // Renderiza os elementos e armazena na variável
        $conteudo = $template->render($parametros);

        // Exibe o conteúdo final
        echo $conteudo;
    }

    public function editar($params)
    {
        try {
            // Pega o objeto
            $postagem = Postagem::selecionaPostagem($params);

            // Twig
            $loader = new \Twig\Loader\FilesystemLoader('App/View');
            $twig = new \Twig\Environment($loader);
            $template = $twig->load('atualizarNoticia.html');

            // Parametros
            $parametros = array(
                "id" => $postagem->id,
                "titulo" => $postagem->titulo,
                "conteudo" => $postagem->conteudo
            );

            // Renderiza os elementos e armazena na variável
            $conteudo = $template->render($parametros);

            // Exibe o conteúdo final
            echo $conteudo;
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    public function deletar($params)
    {
        try {
            // Pega o objeto
            $postagem = Postagem::selecionaPostagem($params);

            // Twig
            $loader = new \Twig\Loader\FilesystemLoader('App/View');
            $twig = new \Twig\Environment($loader);
            $template = $twig->load('deletarrNoticia.html');

            // Parametros
            $parametros = array(
                "id" => $postagem->id,
                "titulo" => $postagem->titulo
            );

            // Renderiza os elementos e armazena na variável
            $conteudo = $template->render($parametros);

            // Exibe o conteúdo final
            echo $conteudo;
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    public function insert()
    {
        try {
            Postagem::insert($_POST);
            echo '<script>alert("Publicação inserida com sucesso!");</script>';
            echo '<script>location.href="index.php?pagina=gerenciar"</script>';
        } catch (Exception $e) {
            echo '<script>alert("' . $e->getMessage() . '");</script>';
            echo '<script>location.href="index.php?pagina=gerenciar&metodo=criar"</script>';
        }
    }

    public function update()
    {
        try {
            Postagem::update($_POST);
            echo '<script>alert("Publicação atualizada com sucesso!");</script>';
            echo '<script>location.href="index.php?pagina=gerenciar"</script>';
        } catch (Exception $e) {
            echo '<script>alert("' . $e->getMessage() . '");</script>';
            echo '<script>location.href="index.php?pagina=gerenciar&metodo=criar"</script>';
        }
    }

    public function delete()
    {
        try {
            Postagem::delete($_POST);
            echo '<script>alert("Publicação deletada com sucesso!");</script>';
            echo '<script>location.href="index.php?pagina=gerenciar"</script>';
        } catch (Exception $e) {
            echo '<script>alert("' . $e->getMessage() . '");</script>';
            echo '<script>location.href="index.php?pagina=gerenciar&metodo=criar"</script>';
        }
    }

    // public function update(){}

    // public function delete(){}
}
