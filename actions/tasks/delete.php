<?php

if (!empty($_POST)) {
    include_once '../../config/connection.php';
    $idTarefa = $_POST['id'];
    $idUsuario = $_POST['user_id'];
 
    $stmt = $connection->prepare("DELETE FROM tarefa WHERE idTarefa = ? and idUsuario = ?");
    $stmt->bind_param('ii', $idTarefa, $idUsuario);
    $stmt->execute();

    $result = $stmt->get_result();

    if ($resul->error) {
        echo json_encode(['error' => $result->error]);
        return;
    }

    echo json_encode(['success' => "Tarefa deletada com sucesso!"]);
}
