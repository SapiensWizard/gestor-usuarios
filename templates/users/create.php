<?php

/**
 * Cadastro de Usuários
 */

session_start();
require_once __DIR__ . "/../../includes/core/bootstrap.php";

// Configurar página
$page_title = "Novo Usuário";
$page_description = "Cadastre um novo usuário no sistema.";
$current_page = "users-create";

$error = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $first_name = trim($_POST['first_name'] ?? '');
    $last_name = trim($_POST['last_name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    // Validar nome de usuário
    if (empty($username)) {
        $error[] = "Nome de usuário é obrigatório.";
    } elseif (strlen($username) < 3) {
        $error[] = "Nome de usuário deve ter pelo menos 3 caracteres.";
    } elseif (strlen($username) > 50) {
        $error[] = "Nome de usuário deve ter no máximo 50 caracteres.";
    } elseif (!preg_match('/^[a-zA-Z0-9_]+$/', $username)) {
        $error[] = "Nome de usuário deve conter apenas letras, números e underscore (_).";
    } else {
        // Verificar duplicidade de nome de usuário
        $checkStmt = $conn->prepare("SELECT id FROM tb_users WHERE username = ?");
        $checkStmt->bind_param("s", $username);
        $checkStmt->execute();
        $checkStmt->store_result();
        if ($checkStmt->num_rows > 0) {
            $error[] = "Este nome de usuário já está em uso! Escolha outro.";
        }
        $checkStmt->close();
    }

    // Validar primeiro nome
    if (empty($first_name)) {
        $error[] = "Primeiro nome é obrigatório.";
    } elseif (strlen($first_name) < 3) {
        $error[] = "Primeiro nome deve ter pelo menos 3 caracteres.";
    } elseif (!preg_match('/^[a-zA-ZÀ-ÖØ-öø-ÿ\s]+$/', $first_name)) {
        $error[] = "Primeiro nome deve conter apenas letras.";
    }

    // Validar último nome
    if (empty($last_name)) {
        $error[] = "Último nome é obrigatório.";
    } elseif (strlen($last_name) < 3) {
        $error[] = "Último nome deve ter pelo menos 3 caracteres.";
    } elseif (!preg_match('/^[a-zA-ZÀ-ÖØ-öø-ÿ\s]+$/', $last_name)) {
        $error[] = "Último nome deve conter apenas letras.";
    }

    // Validar e-mail
    if (empty($email)) {
        $error[] = "E-mail é obrigatório.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error[] = "Digite um e-mail válido (ex: nome@dominio.com).";
    } else {
        // Verificar duplicidade de email
        $checkStmt = $conn->prepare("SELECT id FROM tb_users WHERE email = ?");
        $checkStmt->bind_param("s", $email);
        $checkStmt->execute();
        $checkStmt->store_result();
        if ($checkStmt->num_rows > 0) {
            $error[] = "Este e-mail já está cadastrado! Use outro e-mail.";
        }
        $checkStmt->close();
    }

    // Validar senha
    if (empty($password)) {
        $error[] = "Senha é obrigatória.";
    } elseif (strlen($password) < 6) {
        $error[] = "Senha deve ter pelo menos 6 caracteres.";
    }

    // Se não houver erros → Salvar
    if (empty($error)) {
        // Gerar hash da senha
        // $password_hash = password_hash($password, PASSWORD_DEFAULT);

        $stmt = $conn->prepare("INSERT INTO tb_users (username, first_name, last_name, email, password) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssss", $username, $first_name, $last_name, $email, $password);

        if ($stmt->execute()) {
            $new_id = $conn->insert_id;
            header('Location: index.php?msg=created&id=' . $new_id);
            exit();
        } else {
            $error[] = "Ocorreu um erro ao cadastrar o usuário.";
            error_log("Falha na inserção: " . $stmt->error);
        }

        $stmt->close();
    }
}

require_once __DIR__ . "/../../includes/layouts/header.php";
?>

<!-- CSS ESPECÍFICO PARA ESTA PÁGINA -->
<style>
    body[data-page="users-create"] {
        padding-top: 80px !important;
    }

    @media (max-width: 768px) {
        body[data-page="users-create"] {
            padding-top: 120px !important;
        }
    }
</style>

<!-- CREATE USER SECTION -->
<section class="create-user-section py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <!-- Card de Usuário -->
                <div class="card border-0 shadow-lg">
                    <!-- Card Header -->
                    <div class="card-header bg-primary text-white py-3 d-flex flex-column flex-md-row justify-content-between align-items-center gap-3">
                        <div class="d-flex align-items-center">
                            <i class="bi bi-plus-square fs-4 me-2"></i>
                            <h5 class="fw-bold mb-0">
                                Novo Usuário
                            </h5>
                        </div>

                        <a href="index.php" class="btn btn-light btn-sm fw-bold">
                            <i class="bi bi-arrow-left me-1"></i>
                            Voltar
                        </a>
                    </div>

                    <!-- Card Body -->
                    <div class="card-body p-4">
                        <!-- Mensagem de feedback-->
                        <?php if (!empty($error)): ?>
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <i class="bi bi-exclamation-triangle me-2"></i>
                                <strong>Por favor, corrija os seguintes erros:</strong>
                                <ul class="mt-2 list-unstyled mb-0">
                                    <?php foreach ($error as $e): ?>
                                        <li>
                                            <i class="bi bi-x-circle-fill text-danger me-2"></i>
                                            <?= htmlspecialchars($e, ENT_QUOTES, 'UTF-8'); ?>
                                        </li>
                                    <?php endforeach; ?>
                                </ul>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Fechar"></button>
                            </div>
                        <?php endif; ?>

                        <!-- Formulário -->
                        <form action="<?= htmlspecialchars($_SERVER['PHP_SELF'], ENT_QUOTES, 'UTF-8'); ?>" method="POST" novalidate>
                            <!-- Nome de Usuário -->
                            <div class="mb-3">
                                <label for="username" class="form-label fw-semibold" data-required="true">Nome de Usuário</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light"><i class="bi bi-at"></i></span>
                                    <input type="text" name="username" id="username" class="form-control form-control-lg" placeholder="Ex: joao_silva" autocomplete="username" aria-required="true" value="<?= htmlspecialchars($_POST['username'] ?? '', ENT_QUOTES, 'UTF-8'); ?>">
                                </div>
                                <small class="text-muted">
                                    <i class="bi bi-info-circle"></i> Use apenas letras, números e underscore (_). Mínimo 3 caracteres.
                                </small>
                            </div>

                            <div class="row">
                                <!-- Nome -->
                                <div class="col-12 col-md-6 mb-3">
                                    <label for="first_name" class="form-label fw-semibold" data-required="true">Nome</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light"><i class="bi bi-person"></i></span>
                                        <input type="text" name="first_name" id="first_name" class="form-control form-control-lg" placeholder="Primeiro nome" autocomplete="given-name" aria-required="true" value="<?= htmlspecialchars($_POST['first_name'] ?? '', ENT_QUOTES, 'UTF-8'); ?>">
                                    </div>
                                </div>

                                <!-- Sobrenome -->
                                <div class="col-12 col-md-6 mb-3">
                                    <label for="last_name" class="form-label fw-semibold" data-required="true">Sobrenome</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light"><i class="bi bi-person"></i></span>
                                        <input type="text" name="last_name" id="last_name" class="form-control form-control-lg" placeholder="Último nome" autocomplete="family-name" aria-required="true" value="<?= htmlspecialchars($_POST['last_name'] ?? '', ENT_QUOTES, 'UTF-8'); ?>">
                                    </div>
                                </div>
                            </div>

                            <!-- E-mail -->
                            <div class="mb-3">
                                <label for="email" class="form-label fw-semibold" data-required="true">E-mail</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light"><i class="bi bi-envelope"></i></span>
                                    <input type="email" name="email" id="email" class="form-control form-control-lg" placeholder="seu@email.com" autocomplete="email" aria-required="true" value="<?= htmlspecialchars($_POST['email'] ?? '', ENT_QUOTES, 'UTF-8'); ?>">
                                </div>
                            </div>

                            <!-- Senha -->
                            <div class="mb-3">
                                <label for="password" class="form-label fw-semibold" data-required="true">Senha</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light"><i class="bi bi-lock-fill"></i></span>
                                    <input type="password" name="password" id="password" class="form-control form-control-lg" placeholder="Crie uma senha" autocomplete="new-password" aria-required="true" value="<?= htmlspecialchars($_POST['password'] ?? '', ENT_QUOTES, 'UTF-8'); ?>">
                                </div>
                                <small class="text-muted">
                                    <i class="bi bi-info-circle"></i> Mínimo 6 caracteres.
                                </small>
                            </div>

                            <!-- Botão -->
                            <div class="d-grid d-md-flex justify-content-md-end">
                                <button type="submit" class="btn btn-success fw-bold">
                                    <i class="bi bi-save me-1"></i>
                                    Salvar Usuário
                                </button>
                            </div>
                        </form>
                    </div>

                    <!-- Card Footer -->
                    <div class="card-footer bg-light py-3 d-flex flex-column flex-md-row justify-content-between align-items-center gap-2">
                        <small class="text-muted">
                            <i class="bi bi-info-circle me-1"></i>
                            Os campos com <span class="text-danger fw-bold">*</span> são obrigatórios.
                        </small>

                        <small class="text-muted">
                            <i class="bi bi-check2-circle me-1"></i>
                            Revise os dados antes de enviar o formulário.
                        </small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php require_once __DIR__ . "/../../includes/layouts/footer.php"; ?>