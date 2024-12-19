<?php

session_start();
require_once('config.php');
require_once('fonction.php');
ini_set('display_error', 1);
error_reporting(E_ALL);


if(!isset($_SESSION['username'])){
    header('Location:login.php');
    exit();
}

if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] == 'add_article'){
    if(isset($_POST['title'], $_POST['content'])){
        $title = $_POST['title'];
        $content = $_POST['content'];
    }
    addArticle($pdo, $title, $content);
    header('Location: admin.php');
    exit();
};


// SUPPRESSION D'UN ARTICLE 

if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_action']) && $_POST['delete_action'] =='delete_article'){
    if(isset($_POST['delete_id'])){
        $delete_id = $_POST['delete_id'];

        var_dump($delete_id);
    
        deleteComment($pdo, $delete_id);
        deleteArticle($pdo, $delete_id);
        header('Location: admin.php');
        exit();
    } else {
        echo " ID pas valide problème !";
    }

};

// MODIFICATION D'UN ARTICLE 

if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_action']) && $_POST['update_action'] == 'update_article'){
    if(isset($_POST['article_id'],$_POST['title'], $_POST['content'])){
        $article_id = $_POST['article_id'];
        $title = $_POST['title'];
        $content = $_POST['content'];
    }
    updateArticle($pdo, $title, $content, $article_id);
    header('Location: admin.php');
    exit();
};

$articles = getAllArticles($pdo);
  
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>administration</title>
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
<div class=" w-full  max-w-xl bg-white rounded-lg shadow-lg p-8 mx-auto mt-12">    
    <h1 class="text-2xl font-semibold text-pink-900 text-center mb-6 uppercase">administration</h1>
    <h2 class="text-2xl font-semibold mb-6  text-gray-700">Ajout d'un nouvel article</h2>
    <form class="space-y-6 p-8 rounded-lg shadow-lg" method="POST">
        <input type="hidden" name="action" value="add_article">
        <label for="title" class="block text-sm font-medium text-pink-900 ">Titre :</label>
        <input type="text" id="title" name="title" class="mt-2 p-3 w-full border border-orange-400 rounded-md focus:outline-none focus:ring-2 focus:ring-orange-400" required><br>

        <label for="content" class="block text-sm font-medium text-pink-900">Le contenue :</label>
        <textarea name="content" id="content" class="mt-2 p-3 w-full border border-orange-400 rounded-md focus:outline-none focus:ring-2 focus:ring-orange-400" required></textarea>
        <button type="submit" class="w-full py-3 mt-4 bg-pink-900 text-white font-semibold rounded-md hover:bg-pink-700 focus:outline-none focus:ring-2  focus:ring-orange-400  ">Ajouter l'article</button>
    </form>

    <h2 class="text-2xl font-semibold mt-12 mb-6  text-gray-700">Affichage de la liste de mes articles</h2>
    <ul class="space-y-6">
    <?php foreach ($articles as $article): ?>
    
            <li class="bg-white p-6 rounded-lg shadow-md hover:shadow-lg transition duration-200">
                <h3 class="text-xl font-semibold text-gray-700"><?= htmlspecialchars($article['title']) ?></h3>
                <p class="mt-2 text-gray-700"><?= htmlspecialchars($article['content']) ?></p>
                <form method="POST" class="mt-4 flex space-x-4">
                    <input type="hidden" name="delete_action" value="delete_article">
                    <input type="hidden" name="delete_id" value="<?=htmlspecialchars($article['id']) ?>">
                    <button type="submit" class="px-4 py-2 bg-red-600 text-white font-semibold rounded-md hover:bg-red-700 focus:outline-none focus:ring-2">Supprimer l'article</button>
                </form>

                <form method="POST" class="mt-4 flex space-x-4">
                    <input type="hidden" name="update_action" value="update_article">
                    <input type="hidden" name="article_id" value="<?=htmlspecialchars($article['id']) ?>">
                    <input type="text" name="title" value="<?=htmlspecialchars($article['title']) ?>" class="p-2 w-full border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-orange-400">
                    <textarea name="content" class="p-2 w-full border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-orange-400" value="<?=htmlspecialchars($article['content']) ?>"></textarea>
                    <button type="submit" class="px-4 py-2 bg-orange-300 text-white font-semibold rounded-md hover:bg-orange-500 focus:outline-none focus:ring-2 focus:ring-orange-700">Modifier l'article </button>
                </form>
            </li>
        
        <?php endforeach; ?>
        </ul>
        <h3 class="mt-8 text-center text-sm text-gray-600">Pensez a vous déconnecter <a href="logout.php" class="text-orange-400 hover:underline">Déconnexion</a></h3>
</div>        
</body>
</html>