<?php

require_once('config.php');

$accueil =  'SELECT *, SUBSTRING(content, 1, 20) AS preview FROM articles';

$stmt = $pdo -> query($accueil);

$articles = $stmt->fetchAll(PDO::FETCH_ASSOC);


?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bienvenue sur le Blog !</title>
</head>
<body>
    <h1>Bienvenue sur le Blog!</h1>
    <ul>
    <?php foreach ($articles as $article): ?>
        <li>
            <h2> <?php echo htmlspecialchars($article['title']) ?></h2>
            <p><?php echo htmlspecialchars($article['created_at']) ?></p>
            <p><?php echo htmlspecialchars($article['preview']) ?></p>

            <!-- ce lien contient l'id de mon article dans l'URL  -->
            <a href="article.php?id=<?= $article['id'] ?>">Lire la suite </a>
        </li>
        <?php endforeach; ?>
    </ul>
</body>
</html>