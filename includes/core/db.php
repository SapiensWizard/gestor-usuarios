<?php
require_once __DIR__ . '/config.php';

$username = getenv('DB_USERNAME') ?: DB_USER;
$password = getenv('DB_PASSWORD') ?: DB_PASS;

$conn = new mysqli(DB_HOST, $username, $password, DB_NAME);

if ($conn->connect_error) {
    error_log('Conexão falhou: ' . $conn->connect_error);
    die('Erro interno de conexão');
}

$conn->set_charset('utf8mb4');
