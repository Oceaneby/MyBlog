<?php

require_once('config.php');
require_once('fonction.php');

$articles = getArticles($pdo);

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bienvenue sur le Blog !</title>
    <link rel="stylesheet" href="styles.css">
</head>
<header>
        <nav>
            <ul>
                <li><a href="accueil.php">Accueil</a></li>
                <li><a href="admin.php">Admin</a></li>
                <li><a href="inscription.php"> Inscription</a></li>
                <li><a href="login.php">login</a></li>
            </ul>
        </nav>
    </header>
<body>
    <h1>Bienvenue dans l'univers <span>Papillon Digital</span>, votre espace dédié à l'innovation et à l'inspiration numérique !</h1>
    <section class="section__bienvenue">
        <p>Que vous soyez passionné par les dernières tendances technologiques, les astuces digitales ou l'univers du design, ce blog est fait pour vous.<br><br> Découvrez une sélection d'articles passionnants et approfondissez vos connaissances à travers des aperçus captivants.<br><br> Chaque titre est une porte ouverte vers un univers d'idées et d'exploration, avec un aperçu concis pour éveiller votre curiosité. Pour aller plus loin, cliquez sur les liens et plongez dans nos articles détaillés.</p>
        <p><span class="text__span">Explorez, apprenez et laissez-vous inspirer par le monde numérique !</span></p>
    </section>
    <section class="section__bienvenue__articles">
    <ul>
    <?php foreach ($articles as $article): ?>
        <li>
            <h2> <?= htmlspecialchars($article['title']) ?></h2>
            <p class="article__date"><?= htmlspecialchars($article['created_at']) ?></p>
            <p><?=  htmlspecialchars($article['preview']) ?></p>

            <!-- ce lien contient l'id de mon article dans l'URL  -->
            <a class="main__link" href="article.php?id=<?= $article['id'] ?>">Lire la suite </a>
        </li>
        <?php endforeach; ?>
    </ul>
    </section>
    <footer>
        <p>&copy; Papillon Digital. Tous droits réservés.</p>
    </footer>
</body>
</html>