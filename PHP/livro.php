<?php
include('conection.php');
include('protect.php');

if(isset($_GET['id'])) {
    $book_id = $_GET['id'];
    $user_id = $_SESSION['id'];

    $query = "SELECT livros.id AS livro_id, livros.titulo, livros.autor, livros.ano, livros.genero, livros.descricao, livros.user_id As user_id
            FROM livros 
            WHERE livros.id = $book_id";
    $check_query = $mysqli->query($query);

    if ($check_query) {
        $info = $check_query->fetch_assoc();
    }
}

$reviews_query = "SELECT reviews.*, users.username 
                FROM reviews 
                JOIN livros ON reviews.livro_id = livros.id
                JOIN users ON reviews.user_id = users.id 
                WHERE reviews.livro_id = $book_id";
$check_reviews_query = $mysqli->query($reviews_query);

if($check_reviews_query) {
    $reviews = $check_reviews_query->fetch_all(MYSQLI_ASSOC);
}

if (isset($_POST['review'])) {
    $review = $mysqli->real_escape_string($_POST['review']);

    if(!empty($_POST['review'])) {
        $insert_database = "INSERT INTO reviews (review, livro_id, user_id) VALUES ('$review', '$book_id', '$user_id')";
        $check_insert = $mysqli->query($insert_database) or die("Falha na conexão: " . $mysqli->error);
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
            height: auto;
            padding: 2rem 12rem;
            background-color: white;
            display: flex;
            flex-direction: column;
            gap: 3rem;
        }

        #reviews{
            gap: 1rem;
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

        form{
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }

        form textarea{
            width: calc(100% - 2rem);
            min-height: 8rem;
            padding: 1rem;
            border: 1px solid black;
            outline: none;
            color: black;
            font-size: .9em;
            font-family: Arial, Helvetica, sans-serif;
            resize: vertical;
        }

        form button{
            width: fit-content;
            padding: .5rem 1rem;
            font-size: 1em;
            background-color: white;
            border: 2px solid black;
            transition: .3s ease;
            cursor: pointer;
            align-self: end;
        }

        form button:hover{
            box-shadow: 2px 2px 0px black;
        }

        #reviews ul{
            display: flex;
            flex-direction: column;
            gap: .8rem;
            list-style: none;
        }

        #reviews ul li{
            width: fit-content;
            padding: 1rem;
            border: 1px solid black;
            display: flex;
            flex-direction: column;
            gap: .8rem;
        }
        
        #reviews ul li h3{
            display: flex;
            gap: 5rem;
            align-items: center;
            justify-content: center;
        }

        #deleteReview{
            width: 1.5rem;
            height: 1.5rem;
            background: url(../ASSETS/trash.png) center/contain no-repeat;
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
    <section id="reviews">
        <h2>Reviews</h2>
        <form action="" method="POST">
            <textarea name="review" placeholder="Your review..."></textarea>
            <button type="submit">Submit</button>
        </form>
        <ul>
            <?php
            foreach ($reviews as $review) {
                echo "<li>";
                if ($info['user_id'] == $review['user_id']) {
                    echo "<h3>{$review['username']} (review owner)
                            <a href='deleteReview.php?review_id={$review['id']}&book_id={$info['livro_id']}' id='deleteReview'></a>
                        </h3>";
                } else {
                    echo "<h3>{$review['username']}</h3>";
                }
                echo "<p>{$review['review']}</p>
                    </li>";
            }
            ?>
        </ul>
    </section>

    <footer>
        <h1>EL</h1>
        <p>© 2024 Diogo Santos.</p>
    </footer>

    <!-- Script -->
    <script>
        document.querySelector('form').addEventListener('submit', function(event) {
            event.preventDefault();
            const form = this;

            fetch('', {
                method: 'POST',
                body: new FormData(form)
            }).then(() => {
                window.location.reload();
            }).catch(err => console.error('Erro:', err));
        });
    </script>
</body>
</html>