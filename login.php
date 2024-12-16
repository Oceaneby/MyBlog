<?php
// Démarre la session pour pouvoir stocker les infos
session_start();


// if(!isset($_SESSION['username'])){
//     header('Location:inscription.php');
//     exit();
// }
// On vérifie si le formulaire a été envoyer
if($_SERVER['REQUEST_METHOD'] === 'POST'){
    
    require_once('config.php');

    // On récupère les valeurs du formulaire via la méthode POST 
    $username = $_POST['username'];
    $password = $_POST['password'];

    // On hache le mot de passe pour garantir la sécurité
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

// On prépare la requête SQL pour séléctionner un utilisateur avec le nom d'utilisateur fourni
    $stmt = $pdo ->prepare('SELECT * FROM users WHERE username = :username');

    // On exucte la requête en remplaçant username par la valeur du nom d'utilisateur
    $stmt->execute(['username' => $username]);

    // On récupèren l'utilisateur correspondant a ce nom d'utilisateur dans la base de données
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

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
</head>
<body>
    <h1>Connexion à l'administration</h1>
    <form method="POST">
        <input type="text" name="username" placeholder="Nom d'utilisateur" required><br>
        <input type="password" name="password" placeholder="Mot de passe" required><br>
        <input class="btn" type="submit" value="Connexion">
    </form>
</body>
</html>