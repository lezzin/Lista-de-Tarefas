<?php

error_reporting(E_ALL);
ini_set('display_errors', '1');

if (!empty($_POST)) {
    require_once '../config/connection.php';

    $sql = "SELECT * FROM usuario WHERE email = ? AND senha = ?";
    $stmt = $connection->prepare($sql);
    $stmt->bind_param('ss', $_POST['email'], $_POST['password']);
    $stmt->execute();

    $result = $stmt->get_result();

    if ($result->num_rows > 0){
        $userID = $result->fetch_assoc()['idUsuario'];
        
        echo "<script>
                localStorage.setItem('email', '" . $_POST['email']."');
                localStorage.setItem('senha', '" . $_POST['password']."');
                localStorage.setItem('idUsuario', '" . $userID."');
                window.location.href = '../index.php';
            </script>";
    } else {
        header('Location: ./login.php?error=1');
    }
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
    <title>Lista de tarefas - Login</title>
</head>

<body>

    <main>
        <div class="container">

            <form action="#" class="form" method="post">
                <h3>Efetuar login</h3>
                
                <?php
                    if (!empty($_GET)) {
                        if (!empty($_GET['error']))
                            echo "<p class='alert error'>Usuário ou senha incorretos</p>";

                        if (!empty($_GET['success']))
                            echo "<p class='alert success'>Usuário cadastrado com sucesso</p>";
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
                    <button class="btn register" type="submit">Login</button>
                    <a href="register.php" class="link">Não possui uma conta? Registre-se</a>
                </div>

            </form>

        </div>
    </main>

</body>

</html>