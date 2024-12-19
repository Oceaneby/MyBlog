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
                <li><a href="accueil.php">Accueil</a></li>
                <li><a href="login.php">login</a></li>
            </ul>
        </nav>
    </header>
    <main class="py-12 px-4 md:px-12">
        <!-- J'affiche le titre de l'article après l'avoir sécurisé des caractères spéciaux  -->
        <h1 class=" mb-12 text-center text-3xl md:text-4xl font-bold leading-tight text-gray-700"><?= htmlspecialchars($article['title']) ?></h1>
        <!-- J'affiche la date de publication de l'article (quelque doute que se soit la bonne méthode ?)  -->
        <p class="text-sm text-gray-500 mb-4">Publié le <?= date('d/m/Y H:i', strtotime($article['created_at'])) ?></p>
        <p class="text-lg leading-relaxed mb-4"><?= htmlspecialchars($article['content']) ?></p>

        <h2>Ajouter un commentaire</h2>
        <?php if ($errorMessage): ?>
            <p style="color: red"><?= $errorMessage ?>
            <?php endif ?>
            <form method="POST">
                <textarea name="commentaire"></textarea><br>
                <input type="text" name="author" placeholder="Votre nom ">
                <button type="submit">Ajouter le commentaire</button>
            </form>

            <h2>Commentaires</h2>
            <!-- Je boucle sur les commentaires  -->
            <?php foreach ($commentaires as $commentaire): ?>
                <p>Le <?= date('d/m/Y H:i', strtotime($commentaire['created_at'])) ?> :</p>
                <p><?= htmlspecialchars($commentaire['content']) ?></p>
                <p><?= htmlspecialchars($commentaire['author']) ?></p>
                <!-- (Voir htmlspecialchars_decode ?)  -->

            <?php endforeach; ?>
    </main>
</body>

</html>