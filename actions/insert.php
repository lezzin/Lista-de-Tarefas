<?php

if (!empty($_POST)) {
    include_once '../config/connection.php';

    $description = $_POST['task'];
    $status = 1;

    $connection->query("INSERT INTO tarefa (description, status) VALUES ('$description', '$status')");

    if ($connection->error)
        return print(json_encode(['error' => $connection->error]));

    echo json_encode(['success' => 'Tarefa adicionada com sucesso!']);
}
