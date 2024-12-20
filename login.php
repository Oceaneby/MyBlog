<?php
session_start();
require_once('fonction.php');


// if(!isset($_SESSION['username'])){
//     header('Location:inscription.php');
//     exit();
// }

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    require_once('config.php');

    $username = $_POST['username'];
    $password = $_POST['password'];


    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    $user = loginUser($pdo, $username);

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['username'] = $username;
        header('Location:admin.php');
    } else {
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
    <link rel="stylesheet" href="public/css/styles.css">
</head>

<body class="min-h-screen bg-gradient-to-br from-white-500 flex flex-col items-center justify-center p-4">
    <header class="rounded-md shadow-md px-4 py-2 w-full max-w-md text-center mb-8 bg-pink-900">
        <nav>
            <ul class="flex flex-row text-white justify-center items-center space-x-4">
                <li><a href="accueil.php" aria-label="Accédez à la page d'accueil">Accueil</a></li>
                <li><a href="article.php"  aria-label="Accédez à la page Administrateur">login</a></li>
            </ul>
        </nav>
    </header>
    <div class="w-full max-w-sm bg-white rounded-lg shadow-lg p-8 ">
        <h1 class="text-2xl font-semibold text-gray-800 text-center mb-6">Connexion</h1>

        <form class="space-y-5" method="POST">
            <div>
                <label for="username" class="block mb-2 text-sm font-medium text-gray-700">Nom d'utilisation</label>
                <input
                    type="text"
                    id="username"
                    name="username"
                    placeholder="votre nom d'utilisation"
                    class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-orange-400 focus:border-transparent"
                    required />
            </div>

            <div>
                <label for="password" class="block mb-2 text-sm font-medium text-gray-700">Mot de passe</label>
                <input
                    type="password"
                    id="password"
                    name="password"
                    placeholder="••••••••"
                    class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent"
                    required />
            </div>

            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <input
                        id="remember"
                        type="checkbox"
                        class="h-4 w-4 text-orange-400 focus:ring-orange-400 border-gray-300 rounded peer" />
                    <label for="remember" class="ml-2 text-sm text-gray-700">Se souvenir de moi</label>
                </div>
                <a href="#" class="text-sm text-orange-400 hover:underline" aria-label="Accéder a une page pour Mot de passe oublié">Mot de passe oublié?</a>
            </div>

            <button
                type="submit"
                class="w-full bg-pink-900 text-white font-semibold py-2 rounded-md hover:bg-pink-700 focus:outline-none focus:ring-2 focus:ring-orange-400 focus:ring-offset-2" aria-label="Se connecter">
                Se connecter
            </button>
        </form>


        <p class="mt-6 text-center text-sm text-gray-600">
            Vous n'avez pas de compte ?
            <a href="#" class="text-orange-400 hover:underline" aria-label="Accéder à la page inscription">Créer un compte</a>
        </p>
    </div>
    <section class=" bg-gradient-to-br from-white-500 flex flex-col items-center justify-center p-4">
        <footer class="rounded-md shadow-md px-4 py-2 w-full max-w-md text-center mb-8 bg-pink-900">
            <p class="flex flex-row text-white justify-center items-center space-x-4">&copy; Papillon Digital. Tous droits réservés.</p>
        </footer>
    </section>
</body>

</html>