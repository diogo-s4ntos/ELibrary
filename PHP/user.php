<?php
include('conection.php');
include('protect.php');

$livros = array();
$user_id = $_SESSION['id'];

$query = "SELECT livros.id AS livro_id, livros.titulo, livros.autor, livros.ano, livros.genero, users.id AS user_id FROM livros JOIN users ON livros.user_id = users.id WHERE livros.user_id = $user_id ORDER BY livro_id DESC";
$check_query = $mysqli->query($query);

$user_query = "SELECT * FROM users WHERE id = $user_id";
$check_user_query = $mysqli->query($user_query);

if ($check_query) {
    $livros = $check_query->fetch_all(MYSQLI_ASSOC);
}

if($check_user_query) {
    $user_data = $check_user_query->fetch_assoc();
    $user_name = $user_data['username'];
    $user_email = $user_data['email'];
    $user_password = $user_data['password'];
} else {
    $user_name = 'Utilizador';
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

        #previous-page{
            background: url(../ASSETS/arrow-back.png) center/contain no-repeat;
        }

        #user-link{
            background: url(../ASSETS/userDefault.png) center/contain no-repeat;
        }

        main{
            min-height: calc(100lvh - 4rem - 2px);
        }

        #user{
            width: calc(100% - 24rem);
            padding: 2rem 12rem;
            display: flex;
            gap: 2rem;
            align-items: center;
            justify-content: space-between;
        }

        #user-info, #options{
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }

        #user-info h1, #user-info p{
            white-space: nowrap;
            text-overflow: ellipsis;
            overflow: hidden;
        }

        #user-info h1{
            font-size: 3em;
        }

        #user-info p{
            font-size: 1.5em;
        }

        #options a{
            color: black;
            font-size: 2em;
        }

        #books{
            width: calc(100% - 24rem);
            padding: 2rem 12rem;
            background-color: white;
            display: grid;
            gap: 2rem;
            grid-template-columns: repeat(auto-fill, minmax(20rem, 1fr));
        }

        #books a{
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

        #books a:hover {
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

            #user{
                display: flex;
                flex-direction: column;
                align-items: start;
            }

            #user, #books {
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
        <a href="user.php" id="user-link"></a>
    </header>

    <main>
        <section id="user">
            <div id="user-info">
                <?php 
                echo "<h1>{$user_name}</h1>
                        <p>{$user_email}</p>"
                ?>
            </div>
            <div id="options">
                <a href="deleteAccount.php">Delete account</a>
                <a href="logout.php">Logout</a>
            </div>
        </section>

        <section id="books">
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
    </main>
    
    <footer>
        <h1>EL</h1>
        <p>© 2024 Diogo Santos.</p>
    </footer>
</body>
</html>