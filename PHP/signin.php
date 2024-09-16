<?php
include('conection.php');

$error_message = '';
$success_message = '';
$warning_message = '';

if (isset($_POST['User']) && isset($_POST['Email']) && isset($_POST['Password']) && isset($_POST['confirmPass'])) {
    $username = $mysqli->real_escape_string($_POST['User']);
    $email = $mysqli->real_escape_string($_POST['Email']);
    $password = $mysqli->real_escape_string($_POST['Password']);
    $confirmPass = $mysqli->real_escape_string($_POST['confirmPass']);

    if (empty($username) || empty($email) || empty($password) || empty($confirmPass)) {
        $warning_message = "Fill in all fields.";
    } else if ($password != $confirmPass) {
        $warning_message = "Passwords do not match.";
    } else {
        // Verifica se o usuário já existe
        $check_user_sql = "SELECT * FROM users WHERE username = '$username'";
        $check_user_query = $mysqli->query($check_user_sql) or die("Falha na conexão do código SQL: " . $mysqli->error);
        $user_exists = $check_user_query->num_rows > 0;

        $check_email_sql = "SELECT * FROM users WHERE email = '$email'";
        $check_email_query = $mysqli->query($check_email_sql) or die("Falha na conexão do código SQL: " . $mysqli->error);
        $email_exists = $check_email_query->num_rows > 0;

        if ($user_exists) {
            $error_message = "This username is already in use. Please choose another one.";
        } else if ($email_exists) {
            $error_message = "This email is already in use. Please choose another one.";
        } else {
            // Insere o novo usuário no banco de dados
            $insert_user_sql = "INSERT INTO users (username, email, password) VALUES ('$username', '$email','$password')";
            $insert_user_query = $mysqli->query($insert_user_sql) or die("Falha na conexão do código SQL: " . $mysqli->error);

            $success_message = "Registration successful! Log in <a href='index.php'>Here</a>";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EL - Signin</title>
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

        header nav ul{
            list-style: none;
            display: flex;
            gap: 1rem;
            align-items: center;
            justify-content: center;
        }

        header h1{
            cursor: default;
        }

        header a{
            color: black;
            text-decoration: none;
        }

        section {
            width: calc(100% - 4rem);
            min-height: calc(100lvh - 8rem - 2px);
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

        form {
            width: 20rem;
            max-width: 100%;
            padding: 1rem;
            background-color: #0000004f;
            backdrop-filter: blur(5px);
            display: grid;
            gap: 1rem;
            grid-template-columns: repeat(2, 1fr);
        }
        
        form div{
            grid-column: span 2;
            position: relative;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        form div input{
            width: calc(100% - 2rem);
        }

        form input {
            grid-column: span 2;
            padding: 1rem;
            outline: none;
            border: none;
            font-size: .8em;
        }

        button {
            grid-column: span 2;
            padding: 1rem 0rem;
            border: none;
            background-color: white;
            cursor: pointer;
            transition: .3s ease;
            font-size: .8em;
        }

        button:hover {
            box-shadow: 5px 5px 0px black;
        }

        #eye{
            appearance: none;
            position: absolute;
            right: .5rem;
            padding: 0rem;
            width: 2rem;
            height: 2rem;
            background: url(../ASSETS/eye.png) center/contain no-repeat;
            cursor: pointer;
        }

        #eye:checked{
            background: url(../ASSETS/eyeClose.png) center/contain no-repeat;
        }

        #error, #success, #warning{
            position: absolute;
            top: 0;
            left: 0;
            padding: 1rem;
            color: white;
            font-weight: bold;
            background-color: #0000004f;
            backdrop-filter: blur(5px);
        }

        @media screen and (max-width: 1025px) {
            header{
                width: calc(100% - 4rem);
                padding: 0rem 2rem;
            }
        }
    </style>
</head>
<body>
    <header>
        <h1>EL</h1>

        <nav>
            <ul>
                <li><a href="index.php">Login</a></li>
                <li>|</li>
                <li><a href="signin.php">Signin</a></li>
            </ul>
        </nav>
    </header>

    <section>
        <h1>ELibrary - Signin</h1>
        <form action="" method="POST">
            <input type="text" name="User" maxlength="25" placeholder="Username*" required>
            <input type="email" name="Email" maxlength="50" placeholder="Email*" required>
            <div>
                <input type="password" name="Password" id="password" minlength="8" maxlength19="off" placeholder="Password*" autocomplete="off" required>
                <input type="checkbox" id="eye" onchange="viewPassword(this)">
            </div>
            <input type="password" name="confirmPass" id="confirmPass" minlength="8" maxlength="19" id="confirmPass" placeholder="Confirm password*" autocomplete="off" required>

            <button type="submit">Register</button>
        </form>

        <?php
        if (!empty($error_message)) {
            echo "<h1 id='error'>$error_message</h1>";
        }
        if (!empty($success_message)) {
            echo "<h1 id='success'>$success_message</h1>";
        }
        if (!empty($warning_message)) {
            echo "<h1 id='warning'>$warning_message</h1>";
        }
        ?>
    </section>

    <!-- Script -->
    <script>
        function viewPassword(checkbox) {
            if(checkbox.checked) {
                document.getElementById('password').type = 'text'
            } else {
                document.getElementById('password').type = 'password'
            }
        }
    </script>
</body>
</html>