<?php

/**
 * Visualização de Usuários
 */

session_start();
require_once __DIR__ . "/../../includes/core/bootstrap.php";

// Configurar página
$page_title = "Visualizar Usuário";
$page_description = "Consulte os detalhes de um usuário cadastrado.";
$current_page = "users-view";

$error = [];

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($id <= 0) {
    $error[] = "ID de usuário inválido.";
    header('Location: index.php?error=' . urldecode(implode(', ', $error)));
    exit();
}

$stmt = $conn->prepare("SELECT * FROM tb_users WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
$stmt->close();

if (!$user) {
    $error[] = "Usuário não encontrado.";
    header('Location: index.php?error=' . urlencode(implode(', ', $error)));
    exit();
}

require_once __DIR__ . "/../../includes/layouts/header.php";
?>

<!-- CSS ESPECÍFICO PARA ESTA PÁGINA -->
<style>
    body[data-page="users-view"] {
        padding-top: 80px !important;
    }

    @media (max-width: 768px) {
        body[data-page="users-view"] {
            padding-top: 120px !important;
        }
    }
</style>

<!-- VIEW USER SECTION -->
<section class="view-user-section py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <!-- Card de Usuário -->
                <div class="card border-0 shadow-lg">
                    <!-- Card Header -->
                    <div class="card-header bg-primary text-white py-3 d-flex flex-column flex-md-row justify-content-between align-items-center gap-3">
                        <div class="d-flex align-items-center">
                            <i class="bi bi-eye fs-4 me-2"></i>
                            <h5 class="fw-bold mb-0">Detalhes do Usuário #<?= $id; ?></h5>
                        </div>

                        <a href="index.php" class="btn btn-light btn-sm fw-bold">
                            <i class="bi bi-arrow-left me-1"></i>
                            Voltar
                        </a>
                    </div>

                    <!-- Card Body -->
                    <div class="card-body p-4">
                        <!-- Tabela de dados -->
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover mb-0">
                                <tbody>
                                    <tr>
                                        <th>#ID</th>
                                        <td class="fw-bold">#<?= $user['id']; ?></td>
                                    </tr>
                                    <tr>
                                        <th>Nome de Usuário</th>
                                        <td><?= htmlspecialchars($user['username']); ?></td>
                                    </tr>
                                    <tr>
                                        <th>Primeiro Nome</th>
                                        <td><?= htmlspecialchars($user['first_name']); ?></td>
                                    </tr>
                                    <tr>
                                        <th>Último Nome</th>
                                        <td><?= htmlspecialchars($user['last_name']); ?></td>
                                    </tr>
                                    <tr>
                                        <th>Nome Completo</th>
                                        <td><?= htmlspecialchars($user['first_name'] . ' ' . $user['last_name']); ?></td>
                                    </tr>
                                    <tr>
                                        <th>E-mail</th>
                                        <td>
                                            <a href="mailto:<?= htmlspecialchars($user['email']); ?>" class="text-decoration-none">
                                                <i class="bi bi-envelope-fill me-1"></i>
                                                <?= htmlspecialchars($user['email']); ?>
                                            </a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Senha</th>
                                        <td><?= htmlspecialchars($user['password']); ?></td>
                                    </tr>
                                    <tr>
                                        <th>Data Cadastro</th>
                                        <td>
                                            <i class="bi bi-calendar3 me-1"></i>
                                            <?= date('d/m/Y', strtotime($user['created_at'])); ?>
                                            <span class="text-muted mx-2">|</span>
                                            <i class="bi bi-clock me-1"></i>
                                            <?= date('H:i:s', strtotime($user['created_at'])); ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Última Atualização</th>
                                        <td>
                                            <i class="bi bi-calendar3 me-1"></i>
                                            <?= date('d/m/Y', strtotime($user['updated_at'])); ?>
                                            <span class="text-muted mx-2">|</span>
                                            <i class="bi bi-clock me-1"></i>
                                            <?= date('H:i:s', strtotime($user['updated_at'])); ?>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Card Footer -->
                    <div class="card-footer bg-light py-3 d-flex flex-column flex-md-row justify-content-between align-items-center gap-2">
                        <small class="text-muted">
                            <i class="bi bi-info-circle me-1"></i>
                            Visualizando usuário #<?= $id; ?>
                        </small>

                        <small class="text-muted">
                            <i class="bi bi-journal-text me-1"></i>
                            As informações exibidas refletem o estado atual do cadastro.
                        </small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php require_once __DIR__ . "/../../includes/layouts/footer.php"; ?>