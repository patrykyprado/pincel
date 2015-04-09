<?php
/**
 * Created by PhpStorm.
 * User: Patryky
 * Date: 12/01/15
 * Time: 16:23
 */

//dados de conexão ao pincel atomico
$servidor_mysql_pincel = '177.70.22.184';
$nome_banco_pincel = 'underweb_pincel';
$usuario_pincel = 'underweb_pincel';
$senha_pincel = 'CEDTEC2014Pincel';
global $conn_pincel;
//conectar o bd
$conn_pincel = new PDO("mysql:host=$servidor_mysql_pincel;dbname=$nome_banco_pincel","$usuario_pincel","$senha_pincel");

?>