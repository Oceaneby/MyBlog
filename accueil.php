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
    <link rel="stylesheet" href="public/css/styles.css">
</head>

<body>
    <header class=" bg-gradient-to-br from-white-500 flex flex-col items-center justify-center p-4">
        <nav class="rounded-md shadow-md px-4 py-2 w-full max-w-md text-center mb-8 bg-pink-900">
            <ul class="flex flex-row text-white justify-center items-center space-x-4">
                <li><a href="accueil.php" aria-label="Accédez à la page d'accueil">Accueil</a></li>
                <li><a href="admin.php" aria-label="Accédez à la page Administrateur">Admin</a></li>
                <li><a href="login.php" aria-label="Accédez à la page login">login</a></li>
            </ul>
        </nav>
    </header>
    <main class="py-12 px-4 md:px-12">
        <h1 class=" mb-12 text-center text-3xl md:text-4xl font-bold leading-tight text-gray-700">Bienvenue dans l'univers <span class="text-orange-400">Papillon Digital</span>, votre espace dédié à l'innovation et à l'inspiration numérique !</h1>
        <section class="max-w-4xl mx-auto mb-16 px-4">
            <p class="text-lg leading-relaxed mb-4 text-gray-700">Que vous soyez passionné par les dernières tendances technologiques, les astuces digitales ou l'univers du design, ce blog est fait pour vous.<br><br> Découvrez une sélection d'articles passionnants et approfondissez vos connaissances à travers des aperçus captivants.<br><br> Chaque titre est une porte ouverte vers un univers d'idées et d'exploration, avec un aperçu concis pour éveiller votre curiosité. Pour aller plus loin, cliquez sur les liens et plongez dans nos articles détaillés.</p>
            <p><span class="text-xl font-semibold text-orange-400">Explorez, apprenez et laissez-vous inspirer par le monde numérique !</span></p>
        </section>
        <section class="max-w-4xl mx-auto px-4">
            <h2 class="text-2xl font-semibold text-gray-700 mb-6 text-center">Nos derniers articles</h2>
            <ul class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-8">
                <?php foreach ($articles as $article): ?>
                    <li class="bg-white p-6 rounded-lg shadow-lg hover:shadow-xl transition-shadow duration-300 flex flex-col">
                        <h2 class="text-xl font-bold text-pink-900"> <?= htmlspecialchars($article['title']) ?></h2>
                        <p class="text-sm text-gray-500 mb-4"><?= htmlspecialchars($article['created_at']) ?></p>
                        <p class="text-gray-700 mb-4 flex-grow"><?= htmlspecialchars($article['preview']) ?></p>

                        <!-- ce lien contient l'id de mon article dans l'URL  -->
                        <a href="article.php?id=<?= $article['id'] ?>" aria-label="Lire la suite de l'article" class=" mt-auto text-orange-400 hover:underline">Lire la suite </a>
                    </li>
                <?php endforeach; ?>
            </ul>


        </section>
    </main>
    <section class=" bg-gradient-to-br from-white-500 flex flex-col items-center justify-center p-4">
        <footer class="rounded-md shadow-md px-4 py-2 w-full max-w-md text-center mb-8 bg-pink-900">
            <p class="flex flex-row text-white justify-center items-center space-x-4">&copy; Papillon Digital. Tous droits réservés.</p>
        </footer>
    </section>
</body>

</html>