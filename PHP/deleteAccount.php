<?php
    include('conection.php');

    if(!isset($_SESSION)) {
        session_start();
    }

    $user_id = $_SESSION['id'];
    $username = $_SESSION['username'];
    $email = $_SESSION['email'];
    $password = $_SESSION['password'];

    $delete_livros_sql = "DELETE FROM livros WHERE user_id = '$user_id'";
    $delete_livros_query = $mysqli->query($delete_livros_sql) or die ("Falha na conexão do código SQL: " - $mysql->error);

    $delete_user_sql = "DELETE FROM users WHERE username = '$username' AND email = '$email' AND password = '$password'";
    $delete_user_query = $mysqli->query($delete_user_sql) or die ("Falha na conexão do código SQL: " - $mysql->error);

    session_destroy();

    header("Location: index.php");
?>