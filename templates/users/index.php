<?php

/**
 * Listagem de Usuários
 */

session_start();
require_once __DIR__ . "/../../includes/core/bootstrap.php";

$page_title = "Lista de Usuários";
$page_description = "Visualize e gerencie os usuários cadastrados no sistema.";
$current_page = "users";

$search = isset($_GET['search']) ? trim($_GET['search']) : '';
$search_term = '%' . $search . '%';

// Buscar usuários com ou sem pesquisa (usando prepared statement)
if (!empty($search)) {
    $sql = "SELECT * FROM tb_users WHERE username LIKE ? OR first_name LIKE ? OR last_name LIKE ? OR email LIKE ? ORDER BY id DESC";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssss", $search_term, $search_term, $search_term, $search_term);
    $stmt->execute();
    $result = $stmt->get_result();
    $users = $result->fetch_all(MYSQLI_ASSOC) ?? [];
    $stmt->close();
} else {
    $sql = "SELECT * FROM tb_users ORDER BY id DESC";
    $result = $conn->query($sql);
    $users = $result->fetch_all(MYSQLI_ASSOC) ?? [];
}

require_once __DIR__ . "/../../includes/layouts/header.php";
?>

<!-- CSS ESPECÍFICO PARA ESTA PÁGINA -->
<style>
    body[data-page="users"] {
        padding-top: 80px !important;
    }

    @media (max-width: 768px) {
        body[data-page="users"] {
            padding-top: 120px !important;
        }
    }
</style>

<!-- USER SECTION -->
<section class="user-section py-5">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <!-- User Card -->
                <div class="card border-0 shadow-lg">
                    <!-- Card Header -->
                    <div class="card-header bg-primary text-white py-3 d-flex flex-column flex-md-row justify-content-between align-items-center gap-3">
                        <div class="d-flex align-items-center">
                            <i class="bi bi-people-fill fs-4 me-2"></i>
                            <h5 class="fw-bold mb-0">Lista de Usuários</h5>
                        </div>

                        <div class="d-flex flex-wrap gap-2">
                            <a href="create.php" class="btn btn-success btn-sm fw-bold">
                                <i class="bi bi-plus-circle me-1"></i>
                                Novo Usuário
                            </a>
                        </div>
                    </div>

                    <!-- Card Body -->
                    <div class="card-body">
                        <!-- Barra de pesquisa -->
                        <form action="<?= htmlspecialchars($_SERVER['PHP_SELF'], ENT_QUOTES, 'UTF-8'); ?>" method="GET" class="row g-2 align-items-center mb-4" role="search">
                            <div class="col">
                                <div class="input-group">
                                    <span class="input-group-text bg-white">
                                        <i class="bi bi-search text-muted"></i>
                                    </span>

                                    <input
                                        type="search"
                                        name="search"
                                        id="search"
                                        class="form-control"
                                        placeholder="Pesquisar por nome, usuário ou e-mail..."
                                        autocomplete="off"
                                        value="<?= htmlspecialchars($_GET['search'] ?? '', ENT_QUOTES, 'UTF-8'); ?>">
                                </div>
                            </div>

                            <div class="col-auto">
                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-search me-1"></i>
                                    Pesquisar
                                </button>
                            </div>

                            <?php if (!empty($search)): ?>
                                <div class="col-auto">
                                    <a href="index.php" class="btn btn-outline-secondary">
                                        <i class="bi bi-arrow-clockwise me-1"></i>
                                        Limpar
                                    </a>
                                </div>
                            <?php endif; ?>
                        </form>

                        <!-- Mensagem de feedback -->
                        <?php if (isset($_GET['msg'])): ?>
                            <div class="alert alert-success alert-dismissible fade show m-3" role="alert">
                                <i class="bi bi-check-circle me-2"></i>
                                <?php
                                $msg = $_GET['msg'];
                                $id = isset($_GET['id']) ? ' #' . $_GET['id'] : '';

                                if ($msg == 'created') echo 'Usuário' . $id . ' criado com sucesso!';
                                elseif ($msg == 'updated') echo 'Usuário' . $id . ' atualizado com sucesso!';
                                elseif ($msg == 'deleted') echo 'Usuário' . $id . ' excluído com sucesso!';
                                ?>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Fechar"></button>
                            </div>
                        <?php endif; ?>

                        <!-- Tabela de dados -->
                        <div class="table-responsive">
                            <table class="table table-striped table-hover table-bordered align-middle mb-0">
                                <thead class="table-dark">
                                    <tr>
                                        <th class="text-center">#ID</th>
                                        <th>Nome de Usuário</th>
                                        <th>Nome Completo</th>
                                        <th>E-mail</th>
                                        <th>Senha</th>
                                        <th class="text-center">Data Cadastro</th>
                                        <th class="text-center">Ações</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    <?php if (count($users) > 0): ?>
                                        <?php foreach ($users as $user): ?>
                                            <tr>
                                                <td class="text-center fw-bold">#<?= $user['id']; ?></td>
                                                <td><?= htmlspecialchars($user['username']); ?></td>
                                                <td><?= htmlspecialchars($user['first_name'] . ' ' . $user['last_name']); ?></td>
                                                <td>
                                                    <a href="mailto:<?= htmlspecialchars($user['email']); ?>" class="text-decoration-none">
                                                        <i class="bi bi-envelope-fill me-1"></i>
                                                        <?= htmlspecialchars($user['email']); ?>
                                                    </a>
                                                </td>
                                                <td><?= htmlspecialchars($user['password']); ?></td>
                                                <td class="text-center text-nowrap">
                                                    <i class="bi bi-calendar3 me-1"></i>
                                                    <?= date('d/m/Y H:i', strtotime($user['created_at'])); ?>
                                                </td>
                                                <td class="text-center text-nowrap">
                                                    <a href="view.php?id=<?= $user['id']; ?>" class="btn btn-info btn-sm" title="Visualizar">
                                                        <i class="bi bi-eye"></i>
                                                    </a>
                                                    <a href="edit.php?id=<?= $user['id']; ?>" class="btn btn-primary btn-sm" title="Editar">
                                                        <i class="bi bi-pencil-square"></i>
                                                    </a>
                                                    <a href="delete.php?id=<?= $user['id']; ?>" class="btn btn-danger btn-sm" title="Excluir" onclick="return confirm('Tem certeza que deseja excluir?')">
                                                        <i class="bi bi-trash"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <tr>
                                            <?php if (!empty($search)): ?>
                                                <td colspan="7" class="text-center py-5">
                                                    <div class="py-4">
                                                        <i class="bi bi-search fs-1 d-block text-muted mb-3"></i>
                                                        <h5 class="text-muted">Nenhum resultado encontrado</h5>
                                                        <p class="text-muted small">
                                                            Não foi encontrado nenhum usuário com <strong>"<?= htmlspecialchars($search, ENT_QUOTES, 'UTF-8'); ?>"</strong>
                                                        </p>
                                                        <a href="index.php" class="btn btn-outline-primary btn-sm">
                                                            <i class="bi bi-arrow-clockwise me-1"></i>
                                                            Limpar pesquisa
                                                        </a>
                                                    </div>
                                                </td>
                                            <?php else: ?>
                                                <td colspan="7" class="text-center py-5">
                                                    <div class="py-4">
                                                        <i class="bi bi-inbox fs-1 d-block text-muted mb-3"></i>
                                                        <h5 class="text-muted">Nenhum usuário cadastrado</h5>
                                                        <p class="text-muted small">Clique no botão abaixo para adicionar o primeiro</p>
                                                        <a href="create.php" class="btn btn-primary btn-sm">
                                                            <i class="bi bi-plus-circle me-1"></i>
                                                            Novo Usuário
                                                        </a>
                                                    </div>
                                                </td>
                                            <?php endif; ?>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Card Footer com contagem -->
                    <div class="card-footer bg-light py-3 d-flex flex-column flex-md-row justify-content-between align-items-center gap-2">
                        <small class="text-muted">
                            <i class="bi bi-info-circle me-1"></i>
                            <?php if (!empty($search)): ?>
                                Mostrando <strong><?= count($users); ?></strong> resultado(s) para <strong>"<?= htmlspecialchars($search, ENT_QUOTES, 'UTF-8'); ?>"</strong>
                            <?php else: ?>
                                Total de usuários cadastrados: <strong><?= count($users); ?></strong>
                            <?php endif; ?>
                        </small>

                        <small class="text-muted">
                            <i class="bi bi-arrow-down me-1"></i>
                            Ordenados por ID decrescente
                        </small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php require_once __DIR__ . "/../../includes/layouts/footer.php"; ?>