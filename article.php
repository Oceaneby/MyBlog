<?php
session_start();
require_once('config.php');
require_once('fonction.php');


$errorMessage = "";

if (!isset($_GET["id"])) {
    header('Location: accueil.php');
    exit();
}

$id_article = $_GET['id'];

$article = getArticle($pdo, $id_article);


if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $author = empty($_POST['author']) ? "Anonyme" : $_POST['author'];
    $commentaire = $_POST['commentaire'];

    if ($commentaire) {
        addComment($pdo, $id_article, $author, $commentaire);
    } else {
        $errorMessage = "Vous devez écrire un commentaire";
    }
}
$commentaires = getComments($pdo, $id_article);
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Les Articles</title>
    <link rel="stylesheet" href="public/css/styles.css">
</head>

<body>
    <header class=" bg-gradient-to-br from-white-500 flex flex-col items-center justify-center p-4">
        <nav class="rounded-md shadow-md px-4 py-2 w-full max-w-md text-center mb-8 bg-pink-900">
            <ul class="flex flex-row text-white justify-center items-center space-x-4">
                <li><a href="accueil.php" aria-label="Accédez à la page d'accueil">Accueil</a></li>
                <li><a href="login.php" aria-label="Accédez à la page Administrateur">login</a></li>
            </ul>
        </nav>
    </header>
    <main class="py-12 px-4 md:px-12">
        <!-- J'affiche le titre de l'article après l'avoir sécurisé des caractères spéciaux  -->
        <h1 class=" mb-12 text-center text-3xl md:text-4xl font-bold leading-tight text-gray-700"><?= htmlspecialchars($article['title']) ?></h1>
        <!-- J'affiche la date de publication de l'article (quelque doute que se soit la bonne méthode ?)  -->
        <p class="text-sm text-gray-500 mb-4">Publié le <?= date('d/m/Y H:i', strtotime($article['created_at'])) ?></p>
        <p class="text-lg leading-relaxed text-gray-700 mb-8"><?= nl2br(htmlspecialchars($article['content'])) ?></p>
        <section class="bg-white p-6 rounded-lg shadow-md mb-12">
            <h2 class="text-2xl font-semibold text-gray-800 mb-4">Ajouter un commentaire</h2>
            <?php if ($errorMessage): ?>
                <p class="text-red-600 mb-4"><?= $errorMessage ?>
                <?php endif ?>
                <form method="POST" class="space-y-4">
                    <textarea name="commentaire" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent" aria-label="Écrivez votre commentaire" placeholder="Écrivez votre commentaire ici ..."></textarea><br>
                    <input type="text" name="author" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent" aria-label="Votre nom" placeholder="Votre nom ">
                    <button type="submit" class="w-full py-3 mt-2 bg-pink-900 text-white font-semibold rounded-lg hover:bg-pink-700 transition duration-300" aria-label="Ajouter le commentaire">Ajouter le commentaire</button>
                </form>



        </section>
        <h2 class="text-2xl font-semibold text-gray-800 mb-6">Commentaires</h2>
        <!-- Je boucle sur les commentaires  -->
        <?php if (empty($commentaires)): ?>
            <p class=" text-xl text-gray-500 text-center font-semibold">Pas encore de commentaires</p>
            <p class=" text-sm text-gray-500 text-center font-semibold">Soyez le premier à commenter !</p>
        <?php else: ?>

            <?php foreach ($commentaires as $commentaire): ?>
                <p class="text-sm text-gray-500 mb-2">Le <?= date('d/m/Y H:i', strtotime($commentaire['created_at'])) ?> par <?= htmlspecialchars($commentaire['author']) ?> </p>
                <p class="text-gray-700"><?= htmlspecialchars($commentaire['content']) ?></p>
                <!-- (Voir htmlspecialchars_decode ?)  -->

            <?php endforeach; ?>
        <?php endif; ?>
    </main>
    <section class=" bg-gradient-to-br from-white-500 flex flex-col items-center justify-center p-4">
        <footer class="rounded-md shadow-md px-4 py-2 w-full max-w-md text-center mb-8 bg-pink-900">
            <p class="flex flex-row text-white justify-center items-center space-x-4">&copy; Papillon Digital. Tous droits réservés.</p>
        </footer>
    </section>
</body>


</html>