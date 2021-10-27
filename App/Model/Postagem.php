<?php

namespace App\Model;

use \Lib\Database\Conexao;
use PDO;
use Exception;

class Postagem
{
    public static function selecionaTodos($opt = null)
    {
        // Conexão
        $con = Conexao::getCon();

        // Query
        $stmt = "SELECT P.id, P.titulo, P.conteudo, P.criacao as data_postado, COUNT(C.postagem) as comentarios FROM postagem AS P " . (is_null($opt) ? 'LEFT' : 'INNER') . " JOIN comentario AS C ON (C.postagem = P.id) GROUP BY P.id ORDER BY P.id DESC;";
        $stmt = $con->prepare($stmt);
        $stmt->execute();

        // Array auxiliar vazio
        $resultado = array();

        // Atribui valores ao array
        while ($row = $stmt->fetchObject("\App\Model\Postagem")) :
            $resultado[] = $row;
        endwhile;

        // Exception caso eseja vazio
        if (empty($resultado)) :
            throw new Exception("Não foram encontrados registros de postagens.");
        endif;

        return $resultado;
    }

    public static function selecionaPostagem($id, $param = NULL)
    {
        // Conexão
        $con = Conexao::getCon();

        // Query
        $stmt = "SELECT postagem.id, postagem.titulo, postagem.conteudo, postagem.criacao as data_postado FROM postagem " . (!is_null($param) ? 'INNER JOIN comentario ON comentario.postagem = postagem.id' : '') . " WHERE postagem.id = :id;";
        $stmt = $con->prepare($stmt);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        // Recebe o resultado
        $resultado = $stmt->fetchObject("\App\Model\Postagem");

        // Verifica a existência do registro, retornando erro se não existir.
        if (empty($resultado)) :
            throw new Exception("O registro selecionado não foi encontrado no banco de dados.");
        else :
            $resultado->comentarios = Comentario::selecionarComentarios($resultado->id);
        endif;

        return $resultado;
    }

    public static function insert($dadosPost)
    {
        if (empty($dadosPost['titulo']) || empty($dadosPost['conteudo'])) :
            throw new Exception("Preencha todos os campos corretamente.");
        endif;

        // Conexão
        $con = Conexao::getCon();

        // Query
        $stmt = "INSERT INTO postagem (titulo, conteudo) VALUES (:tit, :con);";
        $stmt = $con->prepare($stmt);
        $stmt->bindValue(":tit", $dadosPost['titulo']);
        $stmt->bindValue(":con", $dadosPost['conteudo']);
        $res = $stmt->execute();

        if (!$res) :
            throw new Exception("Falha ao inserir publicação.");
            return true;
        endif;
    }

    public static function update($dadosPost)
    {
        if (empty($dadosPost['id']) || empty($dadosPost['titulo']) || empty($dadosPost['conteudo'])) :
            throw new Exception("Preencha todos os campos corretamente.");
        endif;

        // Conexão
        $con = Conexao::getCon();

        // Query
        $stmt = "UPDATE postagem SET titulo = :tit, conteudo = :con WHERE id = :id;";
        $stmt = $con->prepare($stmt);
        $stmt->bindValue(":tit", $dadosPost['titulo']);
        $stmt->bindValue(":con", $dadosPost['conteudo']);
        $stmt->bindValue(":id", $dadosPost['id']);
        $res = $stmt->execute();

        if (!$res) :
            throw new Exception("Falha ao atualizar publicação.");
            return true;
        endif;
    }

    public static function delete($dadosPost)
    {
        if (empty($dadosPost['id'])) :
            throw new Exception("Houve um erro inesperado ao realizar a exclusão da notícia.");
        endif;

        // Conexão
        $con = Conexao::getCon();

        // Query
        $stmt = "DELETE FROM postagem WHERE id = :id;";
        $stmt = $con->prepare($stmt);
        $stmt->bindValue(":id", $dadosPost['id']);
        $res = $stmt->execute();

        if (!$res) :
            throw new Exception("Falha ao remover publicação.");
            return true;
        endif;
    }
}
