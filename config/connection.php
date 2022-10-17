<?php

$dbhost = "localhost";
$dbuser = "root";
$dbpass = "";
$dbname = "lista_de_tarefas";

$connection = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);

if (mysqli_connect_errno())
    die("Erro na conexão: " . mysqli_connect_error() . " (" . mysqli_connect_errno() . ")");
