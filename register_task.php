<?php
include 'db.php';
include 'session_check.php';

$message = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $description = trim($_POST['description']);
    $sector = trim($_POST['sector']);
    $priority = $_POST['priority'];
    $user_id = $_SESSION['user_id'];
    $status = $_POST['status'];
    $kanban_id = NULL;
    $cep = !empty($_POST['cep']) ? trim($_POST['cep']) : NULL;

    if (empty($description) || empty($sector) || empty($priority) || empty($status)) {
        $message = "Descrição, setor, prioridade e status são obrigatórios.";
    } else {
        $stmt = $conn->prepare("INSERT INTO tasks (kanban_id, description, sector, priority, user_id, status, cep) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("isssiss", $kanban_id, $description, $sector, $priority, $user_id, $status, $cep);

        if ($stmt->execute()) {
            $message = "Tarefa cadastrada com sucesso.";
        } else {
            $message = "Erro ao cadastrar tarefa: " . $stmt->error;
        }

        $stmt->close();
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Tarefa</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('consultar-cep').addEventListener('click', function() {
                var cep = document.getElementById('cep').value;
                if (cep) {
                    var xhr = new XMLHttpRequest();
                    xhr.open('GET', 'sugestao.php?cep=' + cep, true);
                    xhr.onreadystatechange = function() {
                        if (xhr.readyState == 4) {
                            if (xhr.status == 200) {
                                var data = JSON.parse(xhr.responseText);
                                if (data.error) {
                                    alert(data.error);
                                } else {
                                    var endereco = data.logradouro + ', ' + data.bairro + ', ' + data.localidade + ' - ' + data.uf;
                                    document.getElementById('description').value = endereco;
                                }
                            } else {
                                alert('Erro ao consultar CEP. Tente novamente.');
                            }
                        }
                    };
                    xhr.send();
                } else {
                    alert('Digite um CEP válido.');
                }
            });
        });
    </script>
</head>
<body class="bg-light">
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <h1 class="text-center mb-4">Cadastro de Tarefa</h1>
                <form method="POST" action="" class="bg-white p-4 rounded shadow">
                    <div class="mb-3">
                        <label for="description" class="form-label">Descrição:</label>
                        <textarea id="description" name="description" class="form-control" rows="4" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="sector" class="form-label">Setor:</label>
                        <input type="text" id="sector" name="sector" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="priority" class="form-label">Prioridade:</label>
                        <select id="priority" name="priority" class="form-select" required>
                            <option value="">Selecione</option>
                            <option value="low">Baixa</option>
                            <option value="medium">Média</option>
                            <option value="high">Alta</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="cep" class="form-label">CEP (opcional):</label>
                        <input type="text" id="cep" name="cep" class="form-control" placeholder="Digite o CEP">
                        <button type="button" id="consultar-cep" class="btn btn-info mt-2">Consultar CEP</button>
                    </div>
                    <div class="mb-3">
                        <label for="status" class="form-label">Status:</label>
                        <select id="status" name="status" class="form-select" required>
                            <option value="">Selecione</option>
                            <option value="to_do">A fazer</option>
                            <option value="doing">Fazendo</option>
                            <option value="done">Pronto</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-success w-100">Cadastrar Tarefa</button>
                </form>
                <?php if ($message): ?>
                    <div class="mt-3 alert <?php echo strpos($message, 'sucesso') !== false ? 'alert-success' : 'alert-danger'; ?>">
                        <?php echo $message; ?>
                    </div>
                <?php endif; ?>
                <div class="text-center mt-3">
                    <a href="index.php" class="btn btn-secondary">Voltar ao Menu</a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
