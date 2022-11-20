<?php

if (!empty($_POST)) {
    include_once '../../config/connection.php';

    $description = $_POST['task'];
    $idUsuario = intval($_POST['user_id']);
    $status = 1;

    $stmt = $connection->prepare("INSERT INTO tarefa (description, status, idUsuario) VALUES (?, ?, ?)");
    $stmt->bind_param('sii', $description, $status, $idUsuario);

    if (!$stmt->execute()) 
        echo json_encode(['error' => 'Erro ao inserir tarefa: '. $stmt->error]);
    else 
        echo json_encode(['success' => "Tarefa inserida com sucesso!"]);
}
