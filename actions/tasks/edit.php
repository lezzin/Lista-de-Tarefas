<?php

if (!empty($_POST)) {
    include_once '../../config/connection.php';

    $newDescription = $_POST['description'];
    $idTarefa = $_POST['idTarefa'];

    $stmt = $connection->prepare("UPDATE tarefa SET description = ? WHERE idTarefa = ?");
    $stmt->bind_param('si', $newDescription, $idTarefa);
    $stmt->execute();

    if (!$stmt->execute()) 
        echo json_encode(['error' => 'Erro ao atualizar tarefa.']);
    else 
        echo json_encode(['success' => "Descrição atualizada com sucesso"]);
}