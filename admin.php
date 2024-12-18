<?php

session_start();
require_once('config.php');
require_once('fonction.php');
ini_set('display_error', 1);
error_reporting(E_ALL);


if(!isset($_SESSION['username'])){
    header('Location:inscription.php');
    exit();
}




// AJOUT D'UN ARTICLE 
// Je vérifie que l'action envoyer par le formulaire est bien add_article pour l'ajout d'un nouvel article 
if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] == 'add_article'){
    // On ajoute un nouvel article 
       
    if(isset($_POST['title'], $_POST['content'])){
        // On sécurise le titre en échappent les caractètres spéciaux (sécurité)
        $title = $_POST['title'];
        $content = $_POST['content'];
        // $title = htmlspecialchars($_POST['title']);
        // $content = htmlspecialchars($_POST['content']);
    
    }
    addArticle($pdo, $title, $content);
    // On prépare la requête SQL pour insérer un nouvel article dans la base de données
    // $stmt = $pdo->prepare('INSERT INTO articles(title, content) VALUES (:title, :content)');
    // // On execute la requête en donnant les valeurs du titre et du contenu 
    // $stmt->execute([
    //     'title' => $title,
    //     'content' => $content,
    // ]);
    
    header('Location: admin.php');
    exit();
};
// echo "L'ajout fonctionne !";






// SUPPRESSION D'UN ARTICLE 
// Je vérifie que l'action envoyer par le formulaire est bien delete_article pour supprimer un article 
if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_action']) && $_POST['delete_action'] =='delete_article'){
    // Je vérifie que mon id article a supprimer soit BIEN PRESENT dans ma requête 
    if(isset($_POST['delete_id'])){
        $delete_id = $_POST['delete_id'];
        // Je récupère l'id de mon article a supprimer 
        var_dump($delete_id);
        // Ici j'execute la requête pour supprimer d'abord le commentaires pour pouvoir supprimer l'article dans la prochaine requête 
        // $stmt = $pdo->prepare('DELETE FROM comments WHERE article_id = :id');
        // $stmt->execute(['id' => $delete_id]);
        deleteComment($pdo, $delete_id);
        deleteArticle($pdo, $delete_id);
          // On execute la requête pour supprimer mon article avec son ID 
        //   $stmt = $pdo->prepare('DELETE FROM articles WHERE id = :id');
        //   $stmt->execute(['id' => $delete_id]);
        header('Location: admin.php');
        exit();
    } else {
        echo " ID pas valide problème !";
    }

};

// MODIFICATION D'UN ARTICLE 
// On oublie pas de récupérer les bonne valeurs et nom du formulaire et on vérifie par exemple si 'update_action' existe dans mon formulaire puis on vérifie si elle est exactement égale a ma chaine de caractère 'update_article' qui est présent dans mon formulaire 

// En gros si ma requete est POST, si mon champs update_action existe dans mon formulaire et si ça valeur est bien 'update_article' alors on sait que c'est le formulaire de modification qui est soumis 
if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_action']) && $_POST['update_action'] == 'update_article'){
    // On vérifie que l'utilisateur souhaite modifié un article avec update_acticle 
    if(isset($_POST['article_id'],$_POST['title'], $_POST['content'])){
        // Ici je récupère l'id de mon article à modifié
        $article_id = $_POST['article_id'];

        // On sécurise le titre en échappent les caractètres spéciaux
     
    }

    // On prépare la requête SQL pour modifié un article 
    $stmt = $pdo->prepare('UPDATE articles SET title = :title, content = :content WHERE id = :id');
    // On execute la requête en donnant les nouvelles valeurs du titre, du contenu et de l'id (mise à jours)
    $stmt->execute([
        'title' => $title,
        'content' => $content,
        'id' => $article_id,
    ]);
    header('Location: admin.php');
    exit();
   
};



// On récupère tous les articles de la base de données (table articles)
$recup = $pdo->prepare('SELECT * FROM articles');
$recup->execute();

// On récupère le résultat sous forme de tableaux 
$articles = $recup->fetchAll(PDO::FETCH_ASSOC);
  


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
                <li><a href="inscription.php"> Inscription</a></li>
                <li><a href="login.php">login</a></li>
            </ul>
        </nav>
    </header>
<body>
    <h1>administration</h1>
    <h2>Ajout d'un nouvel article</h2>
    <form method="POST">
        <input type="hidden" name="action" value="add_article">
        <label for="title">Titre :</label>
        <input type="text" id="title" name="title" required><br>

        <label for="content">Le contenue :</label>
        <textarea name="content" id="content" required></textarea>
        <button type="submit">Ajouter l'article</button>
    </form>

    <h2>Affichage de la liste de mes articles</h2>
    <ul>
    <?php foreach ($articles as $article): ?>
    
            <li>
                <?= htmlspecialchars($article['title']) ?>
                <form method="POST">
                    <input type="hidden" name="delete_action" value="delete_article">
                    <input type="hidden" name="delete_id" value="<?= $article['id'] ?>">
                    <button type="submit">Supprimer l'article</button>
                </form>

                <form method="POST">
                    <input type="hidden" name="update_action" value="update_article">
                    <input type="hidden" name="article_id" value="<?= $article['id'] ?>">
                    <input type="text" name="title" value="<?= $article['title'] ?>">
                    <textarea name="content" value="<?=$article['content'] ?>"></textarea>
                    <button type="submit">Modifier l'article </button>
                </form>
            </li>
        
        <?php endforeach; ?>
        </ul>
        <h3>Pensez a vous déconnecter <a href="logout.php">Déconnexion</a></h3>
</body>
</html>