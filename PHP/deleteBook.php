<?php
ob_start();
session_start();

include('conection.php');
include('protect.php');

$error_message = '';

if (isset($_GET['id'])) {
    $book_id = $_GET['id'];
    $user_id = $_SESSION['id'];

    $sql = "DELETE FROM livros 
            WHERE id = $book_id 
            AND user_id = $user_id";

    $sql2 = "DELETE FROM reviews
            WHERE livro_id = $book_id"; 
            
    $query2 = $mysqli->query($sql2) or die("Falha na conexão do código SQL: " . $mysqli->error);
    
    $query = $mysqli->query($sql) or die("Falha na conexão do código SQL: " . $mysqli->error);

    if ($mysqli->affected_rows > 0) {
        header('Location: livros.php');
        exit();
    } else {
        $error_message = "Livro não encontrado ou não tens permissão para apagá-lo.";
    }
} else {
    $error_message = "ID do livro não foi fornecido.";
}

ob_end_flush();
?>