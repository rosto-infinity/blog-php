<?php
/**
 * CE FICHIER DOIT ENREGISTRER UN NOUVEAU COMMENTAIRE EST REDIRIGER SUR L'ARTICLE !
 * 
 * On doit d'abord vérifier que toutes les informations ont été entrées dans le formulaire
 * Si ce n'est pas le cas : un message d'erreur
 * Sinon, on va sauver les informations
 * 
 * Pour sauvegarder les informations, ce serait bien qu'on soit sûr que l'article qu'on essaye de commenter existe
 * Il faudra donc faire une première requête pour s'assurer que l'article existe
 * Ensuite on pourra intégrer le commentaire
 * 
 * Et enfin on pourra rediriger l'utilisateur vers l'article en question
 */

/**
 * 1. On vérifie que les données ont bien été envoyées en POST
 * D'abord, on récupère les informations à partir du POST
 * Ensuite, on vérifie qu'elles ne sont pas nulles
 */



$author = $_POST['author'] ?? null;
$content = $_POST['content'] ?? null;
$article_id = $_POST['article_id'] ?? null;

// Vérification finale des infos envoyées dans le formulaire (donc dans le POST)
// Si il n'y a pas d'auteur OU qu'il n'y a pas de contenu OU qu'il n'y a pas d'identifiant d'article
if (!$author || !$article_id || !$content) {
    die("Votre formulaire a été mal rempli !");
}

// On fait quand même gaffe à ce que le gars n'essaye pas des balises cheloues dans son commentaire
$content = htmlspecialchars($content);

/**
 * 2. Vérification que l'id de l'article pointe bien vers un article qui existe
 * ça nécessite une connexion à la base de données puis une requête qui va aller chercher l'article en question
 * Si rien ne revient, la personne se fout de nous.
 * 
 * Attention, on précise ici deux options :
 * - Le mode d'erreur : le mode exception permet à PDO de nous prévenir violament quand on fait une connerie ;-)
 * - Le mode d'exploitation : FETCH_ASSOC veut dire qu'on exploitera les données sous la forme de tableaux associatifs
 * 
 * PS : Ca fait pas genre 3 fois qu'on écrit ces lignes pour se connecter ?! 
 */
$pdo = new PDO('mysql:host=localhost;dbname=blogpoo;charset=utf8', 'root', '', [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
]);


// Vérification de l'existence de l'article
$query = $pdo->prepare('SELECT COUNT(*) FROM articles WHERE id = :article_id');
$query->execute(['article_id' => $article_id]);
$articleExists = $query->fetchColumn();

if (!$articleExists) {
    die("Ho ! L'article $article_id n'existe pas boloss !");
}

// Insertion du commentaire
$query = $pdo->prepare('INSERT INTO comments SET author = :author, content = :content, article_id = :article_id, created_at = NOW()');
$query->execute(compact('author', 'content', 'article_id'));

// Redirection vers l'article en question
header('Location: article.php?id=' . $article_id);
exit();