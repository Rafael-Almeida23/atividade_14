<?php
header('Content-Type: application/json');

if (isset($_GET['cep'])) {
    $cep = preg_replace('/[^0-9]/', '', $_GET['cep']); // Remove caracteres não numéricos

    if (strlen($cep) == 8) {
        $url = "https://viacep.com.br/ws/{$cep}/json/";

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.124 Safari/537.36');
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);

        $response = curl_exec($ch);
        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($http_code == 200 && $response) {
            $data = json_decode($response, true);
            if (!isset($data['erro'])) {
                echo json_encode($data);
            } else {
                echo json_encode(['error' => 'CEP não encontrado']);
            }
        } else {
            echo json_encode(['error' => 'Erro ao acessar a API']);
        }
    } else {
        echo json_encode(['error' => 'CEP inválido']);
    }
} else {
    echo json_encode(['error' => 'CEP não informado']);
}
?>
