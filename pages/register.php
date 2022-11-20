<?php

error_reporting(E_ALL);
ini_set('display_errors', '1');

if (!empty($_POST)) {
    require_once '../config/connection.php';

    $sql = "SELECT * FROM usuario WHERE email = ?";
    $stmt = $connection->prepare($sql);
    $stmt->bind_param('s', $_POST['email']);
    $stmt->execute();

    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        header('Location: ./register.php?error=user_exists');
        return;
    }
    
    $sql = "INSERT INTO usuario (email, senha) VALUES (?, ?)";
    $stmt = $connection->prepare($sql);
    $stmt->bind_param('ss', $_POST['email'], $_POST['password']);
    $stmt->execute();

    if ($stmt->error) {
        header('Location: ../register.php?error=insert_error');
        return;
    }

    header('Location: ./login.php?success=register_success');
}

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Lista de tarefas utilizando HTML, SASS, PHP e MySQL.">
    <meta name="keywords" content="HTML, SASS, PHP, MySQL, Lista de tarefas">
    <meta name="author" content="Leandro Adrian da Silva">

    <link rel="stylesheet" href="../src/css/form.css">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js" defer></script>
    <script src="https://kit.fontawesome.com/1614cc0d63.js" crossorigin="anonymous" defer></script>
    <script src="./src/js/script.js" defer></script>
    <title>Lista de tarefas - Registro</title>
</head>

<body>

    <main>
        <div class="container">

            <form action="#" class="form" method="post">
                <h3>Registre-se aqui</h3>

                <?php 
                if (!empty($_GET) and !empty($_GET['error'])) {
                    switch ($_GET['error']) {
                        case 'insert_error':
                            echo '<p class="alert error">Erro ao inserir usuário no banco de dados.</p>';
                            break;
                        case 'user_exists':
                            echo '<p class="alert error">Usuário já cadastrado.</p>';
                            break;
                    }
                }
                ?>

                <div class="form_group">
                    <label for="name">Email</label>
                    <input type="email" name="email" id="email" placeholder="usuario@gmail.com">
                </div>

                <div class="form_group">
                    <label for="year">Senha</label>
                    <input type="password" name="password" id="password" placeholder="********">
                </div>

                <div class="bottom">
                    <button class="btn register" type="submit">Registrar-se</button>
                    <a href="login.php" class="link">já possui uma conta?</a>
                </div>

            </form>

        </div>
    </main>

</body>

</html>