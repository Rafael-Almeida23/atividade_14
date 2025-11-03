<?php
include 'db.php';
include 'session_check.php';

$message = '';
$task = null;

if (isset($_GET['id'])) {
    $task_id = $_GET['id'];
    $stmt = $conn->prepare("SELECT * FROM tasks WHERE id = ? AND user_id = ?");
    $stmt->bind_param("ii", $task_id, $_SESSION['user_id']);
    $stmt->execute();
    $result = $stmt->get_result();
    $task = $result->fetch_assoc();
    $stmt->close();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $task_id = $_POST['task_id'];
    $description = trim($_POST['description']);
    $sector = trim($_POST['sector']);
    $priority = $_POST['priority'];
    $user_id = $_SESSION['user_id'];
    $cep = !empty($_POST['cep']) ? trim($_POST['cep']) : NULL;

    if (empty($description) || empty($sector) || empty($priority)) {
        $message = "Descrição, setor e prioridade são obrigatórios.";
    } else {
        $stmt = $conn->prepare("UPDATE tasks SET description = ?, sector = ?, priority = ?, cep = ? WHERE id = ? AND user_id = ?");
        $stmt->bind_param("ssssii", $description, $sector, $priority, $cep, $task_id, $user_id);

        if ($stmt->execute()) {
            $message = "Tarefa atualizada com sucesso.";
            header("Location: gerenciar_tasks.php");
            exit();
        } else {
            $message = "Erro ao atualizar tarefa: " . $stmt->error;
        }

        $stmt->close();
    }
}

// Buscar usuários para o select
$users = $conn->query("SELECT id, name FROM users");

$conn->close();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Tarefa</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body class="bg-light">
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <h1 class="text-center mb-4">Editar Tarefa</h1>
                <?php if ($task): ?>
                    <form method="POST" action="" class="bg-white p-4 rounded shadow">
                        <input type="hidden" name="task_id" value="<?php echo $task['id']; ?>">
                        <div class="mb-3">
                            <label for="description" class="form-label">Descrição:</label>
                            <textarea id="description" name="description" class="form-control" rows="4" required><?php echo htmlspecialchars($task['description']); ?></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="sector" class="form-label">Setor:</label>
                            <input type="text" id="sector" name="sector" value="<?php echo htmlspecialchars($task['sector']); ?>" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="priority" class="form-label">Prioridade:</label>
                            <select id="priority" name="priority" class="form-select" required>
                                <option value="low" <?php echo $task['priority'] == 'low' ? 'selected' : ''; ?>>Baixa</option>
                                <option value="medium" <?php echo $task['priority'] == 'medium' ? 'selected' : ''; ?>>Média</option>
                                <option value="high" <?php echo $task['priority'] == 'high' ? 'selected' : ''; ?>>Alta</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="cep" class="form-label">CEP (opcional):</label>
                            <input type="text" id="cep" name="cep" value="<?php echo htmlspecialchars($task['cep'] ?? ''); ?>" class="form-control" placeholder="Digite o CEP">
                        </div>
                        <button type="submit" class="btn btn-success w-100">Atualizar Tarefa</button>
                    </form>
                <?php else: ?>
                    <div class="alert alert-warning">Tarefa não encontrada.</div>
                <?php endif; ?>
                <?php if ($message): ?>
                    <div class="mt-3 alert <?php echo strpos($message, 'sucesso') !== false ? 'alert-success' : 'alert-danger'; ?>">
                        <?php echo $message; ?>
                    </div>
                <?php endif; ?>
                <div class="text-center mt-3">
                    <a href="gerenciar_tasks.php" class="btn btn-secondary">Voltar ao Gerenciamento</a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
