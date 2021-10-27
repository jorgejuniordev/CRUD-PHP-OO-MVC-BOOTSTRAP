<?php

require_once "vendor/autoload.php";

$template = file_get_contents("app/template/estrutura.html");

ob_start();
$core = new \App\Core\Core();
$core->start($_GET);
$saida = ob_get_contents();
ob_end_clean();

$templatePronto = str_replace('{{content}}', $saida, $template);

echo $templatePronto;
