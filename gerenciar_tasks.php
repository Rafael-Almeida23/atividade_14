<?php
include 'db.php';
include 'session_check.php';

// Atualizar status da tarefa
if (isset($_POST['update_status'])) {
    $task_id = $_POST['task_id'];
    $status = $_POST['update_status'];
    $stmt = $conn->prepare("UPDATE tasks SET status = ? WHERE id = ? AND user_id = ?");
    $stmt->bind_param("sii", $status, $task_id, $_SESSION['user_id']);
    $stmt->execute();
    $stmt->close();
    header("Location: gerenciar_tasks.php");
    exit();
}

// Excluir tarefa
if (isset($_POST['delete_task'])) {
    $task_id = $_POST['task_id'];
    $stmt = $conn->prepare("DELETE FROM tasks WHERE id = ? AND user_id = ?");
    $stmt->bind_param("ii", $task_id, $_SESSION['user_id']);
    $stmt->execute();
    $stmt->close();
    header("Location: gerenciar_tasks.php");
    exit();
}

// Buscar tarefas do usuário logado
$tasks = $conn->prepare("SELECT t.id, t.description, t.sector, t.priority, t.status, t.cep, u.name as user_name FROM tasks t JOIN users u ON t.user_id = u.id WHERE t.user_id = ? ORDER BY t.id");
$tasks->bind_param("i", $_SESSION['user_id']);
$tasks->execute();
$result = $tasks->get_result();

$conn->close();

// Organizar tarefas por status
$columns = ['to_do' => [], 'doing' => [], 'done' => []];
while ($task = $result->fetch_assoc()) {
    $columns[$task['status']][] = $task;
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerenciamento de Tarefas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body class="bg-light">
    <div class="container mt-5">
        <h1 class="text-center mb-4">Gerenciamento de Tarefas</h1>
        <div class="row">
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h5 class="card-title mb-0">A Fazer</h5>
                    </div>
                    <div class="card-body">
                        <?php foreach ($columns['to_do'] as $task): ?>
                            <div class="card mb-3">
                                <div class="card-body">
                                    <h5 class="card-title"><?php echo htmlspecialchars($task['description']); ?></h5>
                                    <p class="card-text">Setor: <?php echo htmlspecialchars($task['sector']); ?></p>
                                    <p class="card-text">Prioridade: <?php echo htmlspecialchars($task['priority']); ?></p>
                                    <p class="card-text">Usuário: <?php echo htmlspecialchars($task['user_name']); ?></p>
                                    <div class="d-flex flex-wrap justify-content-center gap-1">
                                        <form method="POST" class="d-inline">
                                            <input type="hidden" name="task_id" value="<?php echo $task['id']; ?>">
                                            <button type="submit" name="update_status" value="doing" class="btn btn-success btn-sm">Mover para Fazendo</button>
                                        </form>
                                        <a href="edit_task.php?id=<?php echo $task['id']; ?>" class="btn btn-primary btn-sm">Editar</a>
                                        <form method="POST" class="d-inline" onsubmit="return confirm('Tem certeza que deseja excluir?')">
                                            <input type="hidden" name="task_id" value="<?php echo $task['id']; ?>">
                                            <button type="submit" name="delete_task" class="btn btn-danger btn-sm">Excluir</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header bg-warning text-dark">
                        <h5 class="card-title mb-0">Fazendo</h5>
                    </div>
                    <div class="card-body">
                        <?php foreach ($columns['doing'] as $task): ?>
                            <div class="card mb-3">
                                <div class="card-body">
                                    <h5 class="card-title"><?php echo htmlspecialchars($task['description']); ?></h5>
                                    <p class="card-text">Setor: <?php echo htmlspecialchars($task['sector']); ?></p>
                                    <p class="card-text">Prioridade: <?php echo htmlspecialchars($task['priority']); ?></p>
                                    <p class="card-text">Usuário: <?php echo htmlspecialchars($task['user_name']); ?></p>
                                    <div class="d-flex flex-wrap justify-content-center gap-1">
                                        <form method="POST" class="d-inline">
                                            <input type="hidden" name="task_id" value="<?php echo $task['id']; ?>">
                                            <button type="submit" name="update_status" value="to_do" class="btn btn-secondary btn-sm">Mover para A Fazer</button>
                                            <button type="submit" name="update_status" value="done" class="btn btn-success btn-sm">Mover para Pronto</button>
                                        </form>
                                        <a href="edit_task.php?id=<?php echo $task['id']; ?>" class="btn btn-primary btn-sm">Editar</a>
                                        <form method="POST" class="d-inline" onsubmit="return confirm('Tem certeza que deseja excluir?')">
                                            <input type="hidden" name="task_id" value="<?php echo $task['id']; ?>">
                                            <button type="submit" name="delete_task" class="btn btn-danger btn-sm">Excluir</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header bg-success text-white">
                        <h5 class="card-title mb-0">Pronto</h5>
                    </div>
                    <div class="card-body">
                        <?php foreach ($columns['done'] as $task): ?>
                            <div class="card mb-3">
                                <div class="card-body">
                                    <h5 class="card-title"><?php echo htmlspecialchars($task['description']); ?></h5>
                                    <p class="card-text">Setor: <?php echo htmlspecialchars($task['sector']); ?></p>
                                    <p class="card-text">Prioridade: <?php echo htmlspecialchars($task['priority']); ?></p>
                                    <p class="card-text">Usuário: <?php echo htmlspecialchars($task['user_name']); ?></p>
                                    <div class="d-flex flex-wrap justify-content-center gap-1">
                                        <form method="POST" class="d-inline">
                                            <input type="hidden" name="task_id" value="<?php echo $task['id']; ?>">
                                            <button type="submit" name="update_status" value="doing" class="btn btn-warning btn-sm">Mover para Fazendo</button>
                                        </form>
                                        <a href="edit_task.php?id=<?php echo $task['id']; ?>" class="btn btn-primary btn-sm">Editar</a>
                                        <form method="POST" class="d-inline" onsubmit="return confirm('Tem certeza que deseja excluir?')">
                                            <input type="hidden" name="task_id" value="<?php echo $task['id']; ?>">
                                            <button type="submit" name="delete_task" class="btn btn-danger btn-sm">Excluir</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="text-center mt-4">
            <a href="register_task.php" class="btn btn-success me-2">Cadastrar Nova Tarefa</a>
            <a href="logout.php" class="btn btn-danger me-2">Logout</a>
            <a href="index.php" class="btn btn-secondary">Voltar ao Menu</a>
        </div>
    </div>
</body>
</html>
