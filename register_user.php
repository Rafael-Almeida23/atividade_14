<?php
include 'db.php';

$message = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);

    if (empty($name) || empty($email)) {
        $message = "Nome e e-mail são obrigatórios.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $message = "E-mail inválido.";
    } else {
        $stmt = $conn->prepare("INSERT INTO users (name, email) VALUES (?, ?)");
        $stmt->bind_param("ss", $name, $email);

        if ($stmt->execute()) {
            $message = "Cadastro concluído com sucesso.";
        } else {
            $message = "Erro ao cadastrar: " . $stmt->error;
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
    <title>Cadastro de Usuário</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body class="bg-light">
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <h1 class="text-center mb-4">Cadastro de Usuário</h1>
                <form method="POST" action="" class="bg-white p-4 rounded shadow">
                    <div class="mb-3">
                        <label for="name" class="form-label">Nome:</label>
                        <input type="text" id="name" name="name" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">E-mail:</label>
                        <input type="email" id="email" name="email" class="form-control" required>
                    </div>
                    <button type="submit" class="btn btn-success w-100">Cadastrar</button>
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
