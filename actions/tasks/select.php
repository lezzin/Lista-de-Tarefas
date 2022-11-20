<?php

if (!empty($_POST)) {
    include_once '../../config/connection.php';

    $filter = $_POST['filter'];
    $idUsuario = intval($_POST['user_id']);

    switch ($filter) {
        case 'all':
            $result = $connection->query("SELECT * FROM tarefa WHERE idUsuario = $idUsuario")->fetch_all(MYSQLI_ASSOC);
            break;
        case 'completed':
            $result = $connection->query("SELECT * FROM tarefa WHERE status = 2 AND idUsuario = $idUsuario")->fetch_all(MYSQLI_ASSOC);
            break;
        case 'uncompleted':
            $result = $connection->query("SELECT * FROM tarefa WHERE status = 1 AND idUsuario = $idUsuario")->fetch_all(MYSQLI_ASSOC);
            break;
    }

    if (count($result) == 0) {
        print json_encode(array('error' => 'Nenhuma tarefa encontrada'));
        return;
    }

    echo json_encode($result);
}
