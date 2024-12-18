<?php

function getArticles($connexion){
    $sql =  'SELECT *, SUBSTRING(content, 1, 20) AS preview FROM articles';
    $stmt = $connexion->query($sql);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function getArticle($connexion, $idArticle){
    $stmt = $connexion->prepare('SELECT * FROM articles WHERE id = :id'); 
    $stmt->execute(['id' => $idArticle]);
// Je récupère l'article en tableau associatif
    return $stmt->fetch();
}

function addComment($connexion, $idArticle, $author, $commentaire ){
     //"now()" permet d'insérer la date et heure actuelle a created_at
    $stmt = $connexion->prepare('INSERT INTO comments (article_id, author, content, created_at) VALUES
    (:article_id,:author, :content, NOW())');
       
    $stmt->execute([
        'article_id' => $idArticle,
        'author' => $author,
        'content' => $commentaire,
        
    ]);
}

function getComments($connexion, $idArticle){
    $stmt = $connexion->prepare('SELECT * FROM comments WHERE article_id = :article_id');
    $stmt->execute(['article_id' => $idArticle]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function addArticle($connexion, $title, $content){
    $stmt = $connexion->prepare('INSERT INTO articles(title, content) VALUES (:title, :content)');
    // On execute la requête en donnant les valeurs du titre et du contenu 
    $stmt->execute([
        'title' => $title,
        'content' => $content,
        
    ]);
}

function deleteComment($connexion, $delete_id){
   // Ici j'execute la requête pour supprimer d'abord le commentaires pour pouvoir supprimer l'article dans la prochaine requête 
   $stmt = $connexion->prepare('DELETE FROM comments WHERE article_id = :id');
   $stmt->execute(['id' => $delete_id]);
}
function deleteArticle($connexion, $delete_id){
    $stmt = $connexion->prepare('DELETE FROM articles WHERE id = :id');
    $stmt->execute(['id' => $delete_id]);
}

function
