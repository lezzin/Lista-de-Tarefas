<?php

if (!empty($_POST)) {
    include_once '../config/connection.php';

    $status = $_POST['status'];
    $id = $_POST['id'];

    $sql = "UPDATE `tarefa` SET `status` = '$status' WHERE `idTarefa` = $id";
    $result = $connection->query($sql);

    if (!$result) return print(json_encode(['error' => "Falha ao atualizar status"]));

    print(json_encode(['success' => "Status atualizado com sucesso"]));
}
