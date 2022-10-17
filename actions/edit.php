<?php

if (!empty($_POST)) {
    include_once '../config/connection.php';

    $newDescription = $_POST['description'];
    $id = $_POST['id'];

    $sql = "UPDATE `tarefa` SET `description` = '$newDescription' WHERE `idTarefa` = $id";
    $result = $connection->query($sql);

    if (!$result) return print(json_encode(['error' => "Falha ao atualizar descrição"]));

    print(json_encode(['success' => "Descrição atualizada com sucesso"]));
}