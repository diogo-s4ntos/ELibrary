<?php
// Ativar o buffer de saída
ob_start();
session_start();

include('conection.php');
include('protect.php');

$userid = $_SESSION['id'];

if (isset($_POST['autor']) && isset($_POST['titulo']) && isset($_POST['descricao']) && isset($_POST['ano']) && isset($_POST['genero'])) {
    $autor = $mysqli->real_escape_string($_POST['autor']);
    $titulo = $mysqli->real_escape_string($_POST['titulo']);
    $ano = $mysqli->real_escape_string($_POST['ano']);
    $genero = $mysqli->real_escape_string($_POST['genero']);
    $descricao = $mysqli->real_escape_string($_POST['descricao']);

    if (!empty($_POST['autor']) && !empty($_POST['titulo']) && !empty($_POST['descricao']) && !empty($_POST['ano']) && !empty($_POST['genero'])) {
        $insert_database = "INSERT INTO livros (autor, titulo, descricao, ano, genero, user_id) VALUES ('$autor', '$titulo', '$descricao', '$ano', '$genero', '$userid')";
        $check_insert = $mysqli->query($insert_database) or die("Falha na conexão: " . $mysqli->error);

        header("Location: home.php");
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EL - Online Library</title>
    <link rel="icon" href="../ASSETS/book.png">

    <!-- Style -->
    <style>
        * {
            margin: 0;
            padding: 0;
        }

        body {
            font-size: 16px;
            font-family: Arial, Helvetica, sans-serif;
        }

        header{
            width: calc(100% - 24rem);
            height: 4rem;
            padding: 0rem 12rem;
            border-bottom: 2px solid black;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        header a{
            width: 2.5rem;
            height: 2.5rem;
            color: black;
            text-decoration: none;
        }

        #next-page{
            background: url(../ASSETS/arrow-next.png) center/contain no-repeat;
        }

        #user{
            background: url(../ASSETS/userDefault.png) center/contain no-repeat;
        }

        section {
            width: calc(100% - 24rem);
            min-height: calc(100lvh - 8rem - 2px);
            padding: 2rem 12rem;
            background-color: white;
            display: flex;
            flex-direction: column;
            gap: 1rem;
            align-items: center;
        }

        section h2 {
            width: 42rem;
            max-width: calc(100% - 2rem);
            padding: .5rem 1rem;
            color: white;
            font-size: 2em;
            letter-spacing: .2rem;
            background-color: black;
            display: flex;
            gap: 2rem;
            align-items: center;
            justify-content: space-between;
        }

        section h2 img{
            width: 4rem;
        }

        form {
            width: 44rem;
            max-width: 100%;
            display: grid;
            gap: 1rem;
            grid-template-columns: repeat(4, 1fr);
        }

        form input{
            grid-column: span 2;
            padding: 1rem;
            outline: none;
            border: 1px solid black;
        }

        textarea{
            grid-column: span 4;
            padding: 1rem;
            min-height: 8rem;
            resize: vertical;
            font-size: .85em;
            font-family: Arial, Helvetica, sans-serif;
            border: 1px solid black;
            outline: none;
        }

        button{
            padding: 1rem;
            color: black;
            font-weight: bold;
            background-color: white;
            border: 2px solid black;
            transition: .3s ease;
            cursor: pointer;
        }

        button:hover{
            box-shadow: 2px 2px 0px black;
        }

        footer{
            width: calc(100% - 24rem);
            height: 4rem;
            padding: 0rem 12rem;
            box-shadow: 0px 0px 2px black;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        @media screen and (max-width: 1025px) {
            header, footer{
                width: calc(100% - 4rem);
                padding: 0rem 2rem;
            }

            section {
                width: calc(100% - 4rem);
                padding: 2rem;
            }
        }
    </style>
</head>
<body>
    <header>
        <h1><a href="home.php">EL</a></h1>

        <a href="livros.php" id="next-page"></a>
        <a href="user.php" id="user"></a>
    </header>

    <section>
        <h2>Add Book <img src="../ASSETS/book.png" alt="Book" draggable="false"></h2>
        <form action="" method="POST" enctype="multipart/form-data">
            <input type="text" name="autor" placeholder="Author" id="autor-input" autocomplete="off" required>
            <input type="text" name="titulo" placeholder="Title" id="titulo-input" autocomplete="off" required>
            <textarea type="text" name="descricao" placeholder="Description" id="descricao" autocomplete="off" required></textarea>
            <input type="text" name="ano" placeholder="Year of publication" id="ano-input" minlength="4" maxlength="4" oninput="onlyNumbers(this)" autocomplete="off" required>
            <input type="text" name="genero" placeholder="Genre" id="genero-input" oninput="onlyLetters(this)" autocomplete="off" required>
            <button type="submit" id='submit'>Add</button>
        </form>
    </section>

    <!-- Script -->
    <script>
        function onlyNumbers(input) {
            input.value = input.value.replace(/[^0-9]/g, '');
        }

        function onlyLetters(input) {
            input.value = input.value.replace(/[^a-zA-ZÀ-ÖØ-öø-ÿ ,_-]/g, '');
        }
    </script>
    
    <footer>
        <h1>EL</h1>
        <p>© 2024 Diogo Santos.</p>
    </footer>
</body>
</html>

<?php
// Descarregar o buffer de saída
ob_end_flush();
?>