<?php
include('conection.php');
include('protect.php');

$livros = array();
$user_id = $_SESSION['id'];

$query = "SELECT livros.id AS livro_id, livros.titulo, livros.autor, livros.ano, livros.genero FROM livros ORDER BY livro_id DESC";
$check_query = $mysqli->query($query);

if ($check_query) {
    $livros = $check_query->fetch_all(MYSQLI_ASSOC);
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

        header {
            width: calc(100% - 24rem);
            height: 4rem;
            padding: 0rem 12rem;
            border-bottom: 2px solid black;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        header a {
            width: 2.5rem;
            height: 2.5rem;
            color: black;
            text-decoration: none;
        }

        #previous-page {
            background: url(../ASSETS/arrow-back.png) center/contain no-repeat;
        }

        #user {
            background: url(../ASSETS/userDefault.png) center/contain no-repeat;
        }

        section {
            width: calc(100% - 24rem);
            padding: 2rem 12rem;
            background-color: white;
            display: grid;
            gap: 2rem;
            grid-template-columns: repeat(auto-fill, minmax(20rem, 1fr));
        }

        section a {
            height: 10rem;
            padding: 1rem;
            color: black;
            text-decoration: none;
            border: 2px solid black;
            transition: .3s ease;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        section a:hover {
            box-shadow: 5px 5px 0px black;
        }

        .last-info {
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            display: flex;
            gap: 5rem;
            align-items: center;
            justify-content: space-between;
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

        <a href="home.php" id="previous-page"></a>
        <a href="user.php" id="user"></a>
    </header>

    <section>
        <?php
        foreach ($livros as $livro) {
            echo "<a href='livro.php?id={$livro['livro_id']}' class='livro'>
                    <h2>{$livro['titulo']}</h2>
                    <p class='autor'>
                        <em>{$livro['autor']}</em>
                    </p>
                    <div class='last-info'>
                        <p class='ano'>{$livro['ano']}</p>
                        <p class='genero'>{$livro['genero']}</p>
                    </div>
                </a>";
        }
        ?>
    </section>

    <footer>
        <h1>EL</h1>
        <p>© 2024 Diogo Santos.</p>
    </footer>
</body>
</html>