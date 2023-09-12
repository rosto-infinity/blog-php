
<?php
// Configuration
$articlesPerPage = 6; // Nombre d'articles par page

// Récupération du numéro de page à afficher
$page = isset($_GET['page']) ? $_GET['page'] : 1;

// Récupération des articles depuis votre source de données (par exemple, une base de données)
// Remplacez cette partie avec votre propre méthode de récupération des articles
$allArticles = getAllArticles(); // Fonction fictive pour récupérer tous les articles
$totalArticles = count($allArticles); // Nombre total d'articles

// Calcul du nombre total de pages
$totalPages = ceil($totalArticles / $articlesPerPage);

// Vérification de la validité de la page demandée
if ($page < 1 || $page > $totalPages) {
    $page = 1; // Page par défaut si la page demandée est invalide
}

// Calcul des indices de début et de fin des articles à afficher
$startIndex = ($page - 1) * $articlesPerPage;
$endIndex = $startIndex + $articlesPerPage - 1;
if ($endIndex >= $totalArticles) {
    $endIndex = $totalArticles - 1;
}

// Récupération des articles à afficher pour la page actuelle
$articles = array_slice($allArticles, $startIndex, $articlesPerPage);

// Affichage des articles

// Affichage des articles
echo "<h1>Nos articles</h1>";

echo '<div class="article-grid">';
foreach ($articles as $article) {
  echo '<div class="article">';
  echo '<h2>' . $article['title'] . '</h2>';
  echo '<small>Ecrit le ' . $article['created_at'] . '</small>';
  echo '<p>' . $article['introduction'] . '</p>';
  echo '<a href="article?id=' . $article['id'] . '">Lire la suite</a>';
  echo '<a href="delete-article?id=' . $article['id'] . '" onclick="return window.confirm(`Êtes-vous sûr de vouloir supprimer cet article ?!`)">Supprimer</a>';
  echo '</div>';
}
echo '</div>';

// Affichage des liens de pagination
echo "<br>";
echo "<br>";

echo "<div class='pagination'>";
if ($totalPages > 1) {
    // Lien vers la première page
    if ($page > 1) {
        echo " <a href='index?page=1'>Première page</a> ";
    }

    // Lien vers la page précédente
    if ($page > 1) {
        echo " <a href='index?page=" . ($page - 1) . "'>Page précédente</a> ";
    }

    // Lien vers les pages individuelles
    for ($i = 1; $i <= $totalPages; $i++) {
        if ($i == $page) {
            echo " <span class='current-page'>$i</span> ";
        } else {
            echo "<a href='index?page=$i'>$i</a>";
        }
    }

    // Lien vers la page suivante
    if ($page < $totalPages) {
        echo " <a href='index?page=" . ($page + 1) . "'>Page suivante</a> ";
    }

    // Lien vers la dernière page
    if ($page < $totalPages) {
        echo " <a href='index?page=$totalPages'>Dernière page</a> ";
    }
}
echo "</div>";

// Fonction  pour récupérer tous les articles
function getAllArticles()
{
    $pdo = new PDO('mysql:host=localhost;dbname=blogpoo;charset=utf8', 'root', '', [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
    ]);

    $query = "SELECT * FROM articles";
    $stmt = $pdo->prepare($query);
    $stmt->execute();
    $articles = $stmt->fetchAll();

    return $articles;
}
?>