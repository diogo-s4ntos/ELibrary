<?php
include('conection.php');
include('protect.php');

if(isset($_GET['id'])) {
    $book_id = $_GET['id'];
    $user_id = $_SESSION['id'];

    $query = "SELECT livros.id AS livro_id, livros.titulo, livros.autor, livros.ano, livros.genero, livros.descricao FROM livros WHERE livros.id = $book_id";
    $check_query = $mysqli->query($query);

    if ($check_query) {
        $info = $check_query->fetch_assoc();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $info['titulo'], '-', $info['autor']?></title>
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

        #previous-page{
            background: url(../ASSETS/arrow-back.png) center/contain no-repeat;
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
            gap: 3rem;
        }

        section h1{
            font-size: 2.5em;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        section h1 a{
            width: 3rem;
            height: 3rem;
            background: url(../ASSETS/trash.png) center/contain no-repeat;
            transition: .3s ease;
        }

        section h1 a:hover{
            transform: scale(1.1);
        }

        .info-livro{
            display: flex;
            justify-content: space-between;
        }

        .info-livro, .desc{
            font-size: 1.1em;
        }

        .desc{
            text-align: justify;
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

        <a href="livros.php" id="previous-page"></a>
        <a href="user.php" id="user"></a>
    </header>
    
    <section>
        <?php
        echo "<h1>
                {$info['titulo']}
                <a href='deleteBook.php?id={$info['livro_id']}'></a>
            </h1>
            <div class='info-livro'>
                <p>
                    <em>{$info['autor']}</em>
                </p>
                <p>{$info['ano']}</p>
                <p>{$info['genero']}</p>
            </div>
            <div class='desc'>
                <p>{$info['descricao']}</p>
            </div>";
        ?>
    </section>

    <footer>
        <h1>EL</h1>
        <p>© 2024 Diogo Santos.</p>
    </footer>
</body>
</html>