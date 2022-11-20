<?php


if (!empty($_POST)) {
    include_once '../../config/connection.php';

    $status = $_POST['status'];
    $idTarefa = $_POST['id'];
    $idUsuario = $_POST['user_id'];

    $stmt = $connection->prepare("UPDATE tarefa SET status = ? WHERE idTarefa = ? and idUsuario = ?");
    $stmt->bind_param('iii', $status, $idTarefa, $idUsuario);
    $stmt->execute();

    $result = $stmt->get_result();

    if ($result->error) {
        echo json_encode(['error' => 'Erro ao atualizar status.']);
        return;
    }

    print(json_encode(['success' => "Status atualizado com sucesso"]));
}
