<?php

if (!empty($_POST)) {
    $idTarefa = $_POST['id'];
    include_once '../config/connection.php';

    $connection->query("DELETE FROM tarefa WHERE idTarefa = $idTarefa");

    if ($connection->error) {
        echo json_encode(['error' => $connection->error]);
        return;
    }

    echo json_encode(['success' => "Tarefa deletada com sucesso!"]);
}
