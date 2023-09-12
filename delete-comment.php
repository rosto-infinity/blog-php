<?php
/**
 * DANS CE FICHIER ON CHERCHE A SUPPRIMER LE COMMENTAIRE DONT L'ID EST PASSE EN PARAMETRE GET !
 * 
 * On va donc vérifier que le paramètre "id" est bien présent en GET, qu'il correspond bien à un commentaire existant
 * Puis on le supprimera !
 */

/**
 * 1. Récupération du paramètre "id" en GET
 */
$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
if ($id === null || $id === false) {
    die("Ho ! Fallait préciser le paramètre id en GET !");
}

/**
 * 2. Connexion à la base de données avec PDO
 */
$pdo = new PDO('mysql:host=localhost;dbname=blogpoo;charset=utf8', 'root', '', [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
]);

/**
 * 3. Récupération de l'identifiant de l'article avant la suppression du commentaire
 */
$query = $pdo->prepare('SELECT article_id FROM comments WHERE id = :id');
$query->execute(['id' => $id]);
$article_id = $query->fetchColumn();

/**
 * 4. Suppression réelle du commentaire
 */
$query = $pdo->prepare('DELETE FROM comments WHERE id = :id');
$query->execute(['id' => $id]);

/**
 * 5. Affichage de l'identifiant de l'article
 */
// var_dump($article_id);
// die();
if (!$article_id) {
    die("Aucun commentaire n'a l'identifiant $id !");
}

/**
 * 4. Redirection vers l'article en question
 */
header("Location: article.php?id=$article_id");
exit();