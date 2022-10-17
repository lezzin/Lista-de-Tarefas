<?php

if (!empty($_POST)) {
    $filter = $_POST['filter'];
    global $var;

    include_once '../config/connection.php';

    switch ($filter) {
        case 'all':
            $result = $connection->query("SELECT * FROM tarefa")->fetch_all(MYSQLI_ASSOC);
            break;
        case 'completed':
            $result = $connection->query("SELECT * FROM tarefa WHERE status = 2")->fetch_all(MYSQLI_ASSOC);
            break;
        case 'uncompleted':
            $result = $connection->query("SELECT * FROM tarefa WHERE status = 1")->fetch_all(MYSQLI_ASSOC);
            break;
        default:
            $result = "Erro ao filtrar";
            break;
    }

    if (sizeof($result) == 0) return print(json_encode(['error' => 'Nenhuma tarefa encontrada!']));

    echo json_encode($result);
}
