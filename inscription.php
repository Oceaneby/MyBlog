<?php

session_start(); 

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require_once 'config.php';
    $password = $_POST['password'];


    if ($user) {
     echo "L'utilisateur existe déjà. Veuillez choisir un autre nom d'utilisateur";
    } else {
        // Hachage du mots de passe pour sécurité
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);;

        // Puis on insert l'utilisateur dans la base de données
        $sql = "INSERT INTO users (username, password) VALUES (:username, :password)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':username' => $username,
            ':password' => $hashed_password,
        ]);
        echo "Inscription réussie ! ";

        // Redirection vers la page de connexion après inscription réussie
        header("Location: login.php");
        exit(); 
        // Important : arrêter l'exécution du script après la redirection
    }
}


?>




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription Blog</title>
    <link rel="stylesheet" href="styles.css">
</head>
<header>
        <nav>
            <ul>
                <li><a href="accueil.php">Accueil</a></li>
                <li><a href="login.php">login</a></li>
            </ul>
        </nav>
    </header>
<body class="container">
    <h1>Rejoignez-nous dès aujourd'hui !</h1>
    <form class="signup__form" method="POST">
    
    <input type="text" name="username" placeholder="Nom d'utilisateur" required><br>
    <input type="password" name="password" placeholder="Mot de passe" required><br>
    <input class="btn"  type="submit" value="S'inscrire">

    <p class="separator__text">Ou</p>
    <p>Se connecter <a href="login.php">Ici !</a></p>
</form>
<footer>
        <p>&copy; Papillon Digital. Tous droits réservés.</p>
    </footer>
</body>
</html>


