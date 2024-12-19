<?php
session_start();
require_once('fonction.php');


// if(!isset($_SESSION['username'])){
//     header('Location:inscription.php');
//     exit();
// }

if($_SERVER['REQUEST_METHOD'] === 'POST'){
    
    require_once('config.php');

    $username = $_POST['username'];
    $password = $_POST['password'];

   
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    $user = loginUser($pdo, $username);

    if($user && password_verify($password, $user['password'])){
        $_SESSION['username'] = $username;
        header('Location:admin.php');
    } else{
        echo "Identifiants ou mot de passe incorrects";
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion</title>
    <link rel="stylesheet" href="styles.css">
</head>
<header>
        <nav>
            <ul>
                <li><a href="accueil.php">Accueil</a></li>
                <li><a href="article.php">login</a></li>
            </ul>
        </nav>
    </header>
<body>
    <h1 class="container">Connexion à l'administration</h1>
    <form class="signup__form" method="POST">
        <input type="text" name="username" placeholder="Nom d'utilisateur" required><br>
        <input type="password" name="password" placeholder="Mot de passe" required><br>
        <input class="btn" type="submit" value="Connexion">
    </form>
    <footer>
        <p>&copy; Papillon Digital. Tous droits réservés.</p>
    </footer>
</body>
</html>