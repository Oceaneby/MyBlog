<?php
session_start();
require_once('config.php');

// Je récupère l'id de l'article qui se trouve dans l'URL, si il n'est pas trouver '??' donne la valeur de 0 à id_article(l'id de url devient 0 qui n'est pas dans la base de donner)
$id_article = $_GET['id'] ?? 0;

// Si l'ID de l'article n'est pas valide, rediriger vers la page d'accueil
if ($id_article == 0) {
    header('Location: accueil.php');
    exit();
}

// Ici je prépare la requête SQL qui va récupérer toutes les donnés de mon article qui correspond a l'id dans l'URL
$stmt = $pdo->prepare('SELECT * FROM articles WHERE id = :id'); 
$stmt->execute(['id' => $id_article]);
// Je récupère l'article en tableau associatif
$article = $stmt->fetch(PDO::FETCH_ASSOC);



if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['commentaire'])) {
    //Je vérifie d'abord que mon champ 'commentaire' existe dans mon formulaire
    // Puis je sécurise le contenue du commentaire 
    $commentaire = htmlspecialchars($_POST['commentaire']);

    // Je fais une requete pour ajouter un nouveau commentaire a ma table 'comments'
    $stmt = $pdo->prepare('INSERT INTO comments (article_id, content, created_at) VALUES
    (:article_id, :content, NOW())');
        //"now()" permet d'insérer la date et heure actuelle a created_at
    $stmt->execute([
        'article_id' => $id_article,
        'content' => $commentaire,
    ]);
}

// Je récupère tous les commentaires associés à l'article qui a le même id que dans l'URL 
$stmt = $pdo->prepare('SELECT * FROM comments WHERE article_id = :article_id');
$stmt->execute(['article_id' => $id_article]);
$commentaires = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Les Articles</title>
</head>

<body>
    <!-- J'affiche le titre de l'article après l'avoir sécurisé des caractères spéciaux  -->
    <h1><?php echo htmlspecialchars($article['title']) ?></h1>
    <!-- J'affiche la date de publication de l'article (quelque doute que se soit la bonne méthode ?)  -->
    <p>Publié le <?= date('d/m/Y', strtotime($article['created_at'])) ?></p>
    <p><?php echo htmlspecialchars($article['content']) ?></p>

    <h2>Ajouter un commentaire</h2>
    <form method="POST">
        <textarea name="commentaire" required></textarea><br>
        <button type="submit">Ajouter le commentaire</button>
    </form>

    <h2>Commentaires</h2>
    <!-- Je boucle sur les commentaires  -->
    <?php foreach ($commentaires as $commentaire): ?>
        <p>Le <?= date('d/m/Y H:i', strtotime($commentaire['created_at'])) ?> :</p>
        <p><?php echo htmlspecialchars($commentaire['content']) ?></p>
        <!-- (Voir htmlspecialchars_decode ?)  -->
    <?php endforeach; ?>

</body>

</html>