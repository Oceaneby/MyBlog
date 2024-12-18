<?php

function getArticles($connexion){
    $sql =  'SELECT *, SUBSTRING(content, 1, 20) AS preview FROM articles';
    $stmt = $connexion->query($sql);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function getArticle($connexion, $idArticle){
    $stmt = $connexion->prepare('SELECT * FROM articles WHERE id = :id'); 
    $stmt->execute(['id' => $idArticle]);
    return $stmt->fetch();
}

function addComment($connexion, $idArticle, $author, $commentaire ){
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
    $stmt->execute([
        'title' => $title,
        'content' => $content,
        
    ]);
}

function deleteComment($connexion, $delete_id){
   $stmt = $connexion->prepare('DELETE FROM comments WHERE article_id = :id');
   $stmt->execute(['id' => $delete_id]);
}
function deleteArticle($connexion, $delete_id){
    $stmt = $connexion->prepare('DELETE FROM articles WHERE id = :id');
    $stmt->execute(['id' => $delete_id]);
}
function updateArticle($connexion, $title, $content, $article_id){ 
        $stmt = $connexion->prepare('UPDATE articles SET title = :title, content = :content WHERE id = :id');
        $stmt->execute([
            'title' => $title,
            'content' => $content,
            'id' => $article_id,
        ]);
}

function getAllArticles($connexion){
    $stmt = $connexion->prepare('SELECT * FROM articles');
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
