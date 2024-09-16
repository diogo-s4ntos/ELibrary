<?php 
ob_start();
session_start();

include 'conection.php';
include 'protect.php';

$error_message = '';

if(isset($_GET['review_id']) && isset($_GET['book_id'])) {
    $review_id = $_GET['review_id'];
    $book_id = $_GET['book_id'];
    $user_id = $_SESSION['id'];

    $sql = "DELETE FROM reviews 
            WHERE reviews.id = $review_id
            AND reviews.user_id = $user_id;";
    $query = $mysqli->query($sql) or die("Falha na conexão do código SQL: " . $mysqli->error);

    if ($mysqli->affected_rows > 0) {
        header("Location: livro.php?id=$book_id");
        exit();
    } else {
        header("Location: livro.php?id=$book_id");
        exit();
    }
} else {
    $error_message = "ID do livro não foi fornecido.";
}

ob_end_flush();
?>