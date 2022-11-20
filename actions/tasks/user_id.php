<?php

if (!empty($_POST)) {
    include_once '../../config/connection.php';
    
    $email = $_POST['email'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM usuario WHERE email = '$email' AND senha = '$password'";
    $result = $connection->query($sql);

    if ($result->num_rows > 0) {
        $user_id = $result->fetch_assoc()['idUsuario'];

        echo json_encode(array('user_id' => $user_id));
        return;
    } 

    echo json_encode(array('error' => 'Usuário não encontrado'));
}