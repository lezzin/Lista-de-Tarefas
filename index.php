<?php

error_reporting(E_ALL);
ini_set('display_errors', '1');

?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Lista de tarefas utilizando HTML, SASS, PHP e MySQL.">
    <meta name="keywords" content="HTML, SASS, PHP, MySQL, Lista de tarefas">
    <meta name="author" content="Leandro Adrian da Silva">
    <link rel="stylesheet" href="./src/css/styles.css">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js" defer></script>
    <script src="https://kit.fontawesome.com/1614cc0d63.js" crossorigin="anonymous" defer></script>
    <script src="./src/js/script.js" defer></script>
    <title>Lista de tarefas - Index</title>
</head>

<body>

    <button class="getOutBtn">
        <i class="fas fa-sign-out-alt"></i>
    </button>

    <main class="container">

        <div class="message danger">
            <p class="message__text"></p>
        </div>

        <div class="content">
            <h1>Lista de tarefas</h1>

            <div class="loader">
                <span class="spinner"></span>
            </div>

            <form id="form">
                <input type="text" name="task" placeholder="Digite uma tarefa" required>
                <button type="submit" name="submit">Adicionar</button>

                <select name="filter" id="filter">
                    <option value="all">Todas</option>
                    <option value="completed">Concluídas</option>
                    <option value="uncompleted">Não concluídas</option>
                </select>
            </form>

            <div class="tasks_container">
                <ul class="tasks" id="tasks"></ul>
            </div>
        </div>
    </main>

</body>

</html>