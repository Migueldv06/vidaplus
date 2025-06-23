<?php
$servername = "localhost";
$username = "vidaplus";
$password = "#Migueldv1";
$dbname = "vidaplus";

// Criar conexão
$DB = new mysqli($servername, $username, $password, $dbname);

// Verificar conexão
if ($DB->connect_error) {
    die("Conexão falhou: " . $DB->connect_error);
}
?>