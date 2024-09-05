<?php
include('conection.php');

$error_message = '';

if (isset($_POST['Username']) || isset($_POST['Password'])) {
    if ((!empty($_POST['Username'])) && (!empty($_POST['Password']))) {
        $username = $mysqli->real_escape_string($_POST['Username']);
        $password = $mysqli->real_escape_string($_POST['Password']);

        $sql_code = "SELECT * FROM users WHERE username = '$username' AND password = '$password'";
        $sql_query = $mysqli->query($sql_code) or die("Falha na conexão do código SQL: " . $mysqli->error);

        $quantidade = $sql_query->num_rows;

        if ($quantidade == 1) {
            $user = $sql_query->fetch_assoc();

            if (!isset($_SESSION)) {
                session_start();
            }

            $_SESSION['id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['email'] = $user['email'];
            $_SESSION['password'] = $user['password'];

            header("Location: home.php");
        } else {
            $error_message = "Error! Invalid username or password.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EL - Login</title>
    <link rel="icon" href="../ASSETS/book.png">

    <!-- Style -->
    <style>
        *{
            margin: 0;
            padding: 0;
        }

        body{
            font-size: 16px;
            font-family: Arial, Helvetica, sans-serif;
        }

        section{
            width: calc(100% - 4rem);
            min-height: calc(100lvh - 4rem);
            padding: 2rem;
            background: url(../ASSETS/background.png) center/cover no-repeat;
            display: flex;
            flex-direction: column;
            gap: 1rem;
            align-items: center;
            justify-content: center;
        }

        section h1{
            width: 20rem;
            max-width: 100%;
            padding: 1rem;
            color: white;
            background-color: #0000004f;
            backdrop-filter: blur(5px);
        }

        form{
            width: 20rem;
            max-width: 100%;
            padding: 1rem;
            background-color: #0000004f;
            backdrop-filter: blur(5px);
            display: grid;
            gap: 1rem;
            grid-template-columns: repeat(2, 1fr);
        }

        form input:nth-child(1), input:nth-child(2), input:nth-child(3){
            grid-column: span 2;
        }

        form input{
            padding: 1rem;
            outline: none;
            border: none;
            font-size: .8em;
        }

        button, a{
            padding: 1rem 0rem;
            color: black;
            font-size: .8em;
            font-weight: 400;
            background-color: white;
            border: none;
            cursor: pointer;
            transition: .3s ease;
        }

        a{
            color: black;
            text-decoration: none;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        button:hover, a:hover{
            box-shadow: 5px 5px 0px black;
        }

        #error{
            position: absolute;
            top: 0;
            left: 0;
            padding: 1rem;
            color: white;
            font-weight: bold;
            background-color: #0000004f;
            backdrop-filter: blur(5px);
        }
    </style>
</head>
<body>
    <section>
        <h1>ELibrary - Login</h1>
        <form action="" method="POST">
            <input type="text" name="Username" placeholder="Username">
            <input type="password" name="Password" placeholder="Password">
            <button type="submit">Login</button>
            <a href="signin.php">Signin</a>
        </form>

        <?php
        if (!empty($error_message)) {
            echo "<h1 id='error'>$error_message</h1>";
        }
        ?>
    </section>
</body>
</html>