<?php

namespace App\Model;

use \Lib\Database\Conexao;
use PDO;
use Exception;

class Comentario
{
    public static function selecionarComentarios($id)
    {
        // Armazena o objeto de Conexão retornado na variável $con
        $con = Conexao::getCon();

        // Query
        $stmt = "SELECT id, nome, mensagem, data_comentario FROM comentario WHERE postagem = :id ORDER BY data_comentario ASC;";
        $stmt = $con->prepare($stmt);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        // Array
        $resultado = array();

        // Armazena dados no array
        while ($row = $stmt->fetchObject("\App\Model\Comentario")) :
            $resultado[] = $row;
        endwhile;

        // Retorna o resultado final
        return $resultado;
    }

    public static function insert($dadosPost)
    {
        if (empty($dadosPost['id']) || empty($dadosPost['nome']) || empty($dadosPost['mensagem'])) :
            throw new Exception("Preencha todos os campos corretamente.");
        endif;

        // Conexão
        $con = Conexao::getCon();

        // Query
        $stmt = "INSERT INTO comentario (postagem, nome, mensagem) VALUES (:id, :nom, :men);";
        $stmt = $con->prepare($stmt);
        $stmt->bindValue(":id", $dadosPost['id']);
        $stmt->bindValue(":nom", $dadosPost['nome']);
        $stmt->bindValue(":men", $dadosPost['mensagem']);
        $res = $stmt->execute();

        if (!$res) :
            throw new Exception("Falha ao inserir comentário.");
            return true;
        endif;
    }

    /** 
     * Como não há autenticação (login / user):
     * o sistema pode possibilitar a exclusão de comentários
     * livremente.
     */

    public static function delete($dadosGet)
    {
        if (empty($dadosGet['id'])) :
            throw new Exception("Houve um erro inesperado ao deletar o comentário.");
        endif;

        // Conexão
        $con = Conexao::getCon();

        // Query
        $stmt = "DELETE FROM comentario WHERE id = :id;";
        $stmt = $con->prepare($stmt);
        $stmt->bindValue(":id", $dadosGet['id']);
        $res = $stmt->execute();

        if (!$res) :
            throw new Exception("Falha ao deletar comentário.");
            return true;
        endif;
    }
}
