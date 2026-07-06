<?php

/**
 * Exclusão de Usuários
 */

require_once __DIR__ . "/../../includes/core/bootstrap.php";

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($id > 0) {
    $stmt = $conn->prepare("DELETE FROM tb_users WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->close();
}

header('Location: index.php?msg=deleted&id=' . $id);
exit();
