<?php
// includes/layouts/header.php

// Se não houver variáveis definidas, usar padrões
$page_title = $page_title ?? APP_NAME;
$page_description = $page_description ?? "CRUD para gerenciamento de usuários.";
$current_page = $current_page ?? 'home';
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="<?= htmlspecialchars($page_description) ?>">
    <meta name="keywords" content="<?= $page_keywords ?? 'CRUD, gestão, usuários' ?>">
    <meta name="author" content="Onésimo Supe">

    <!-- Favicon -->
    <link rel="icon" href="<?= URL_BASE ?>assets/img/logo/favicon.ico">

    <!-- Bootstrap 5 CSS -->
    <link rel="stylesheet" href="<?= URL_BASE ?>assets/vendor/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?= URL_BASE ?>assets/vendor/bootstrap-icons/bootstrap-icons.css">

    <!-- Cutom CSS -->
    <link rel="stylesheet" href="<?= URL_BASE ?>assets/css/styles.css">

    <title><?= htmlspecialchars($page_title) ?> | <?= APP_NAME ?></title>
</head>

<body data-page="<?= $current_page ?>">

    <!-- HEADER / NAVBAR -->
    <?php require_once __DIR__ . '/navbar.php'; ?>
    
    <main>