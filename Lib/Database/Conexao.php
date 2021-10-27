<?php

namespace Lib\Database;

use PDO;

abstract class conexao
{
    private static $conn;

    public static function getCon()
    {
        if (is_null(self::$conn)) :
            self::$conn = new PDO('mysql:host=localhost;dbname=test', 'root', '');
        endif;

        return self::$conn;
    }
}
