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
<body>
    <h1 class="main__title">administration</h1>
    <h2 class="sub__title">Ajout d'un nouvel article</h2>
    <form class="form__article" method="POST">
        <input type="hidden" name="action" value="add_article">
        <label for="title" class="form__label">Titre :</label>
        <input type="text" id="title" name="title" class="form__input" required><br>

        <label for="content" class="form__label">Le contenue :</label>
        <textarea name="content" id="content" class="form__textarea" required></textarea>
        <button type="submit" class="submit__btn">Ajouter l'article</button>
    </form>

    <h2 class="sub__title">Affichage de la liste de mes articles</h2>
    <ul class="article__list">
    <?php foreach ($articles as $article): ?>
    
            <li class="article__item">
                <h3 class="article__title"><?= htmlspecialchars($article['title']) ?></h3>
                <form method="POST">
                    <input type="hidden" name="delete_action" value="delete_article">
                    <input type="hidden" name="delete_id" value="<?=htmlspecialchars($article['id']) ?>">
                    <button type="submit" class="submit__delete">Supprimer l'article</button>
                </form>

                <form method="POST">
                    <input type="hidden" name="update_action" value="update_article">
                    <input type="hidden" name="article_id" value="<?=htmlspecialchars($article['id']) ?>">
                    <input type="text" name="title" value="<?=htmlspecialchars($article['title']) ?>">
                    <textarea name="content" class="form__textarea" value="<?=htmlspecialchars($article['content']) ?>"></textarea>
                    <button type="submit" class="submit__upload">Modifier l'article </button>
                </form>
            </li>
        
        <?php endforeach; ?>
        </ul>
        <h3>Pensez a vous déconnecter <a href="logout.php">Déconnexion</a></h3>
</body>
</html>