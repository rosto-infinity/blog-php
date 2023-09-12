

<h1 class="article-title"><?= $article['title'] ?></h1>
<small class="article-date">Ecrit le <?= $article['created_at'] ?></small>
<p class="article-introduction"><?= $article['introduction'] ?></p>
<hr class="article-divider">
<?= $article['content'] ?>

<?php if (count($commentaires) === 0) : ?>
  <h2 class="comment-heading">Il n'y a pas encore de commentaires pour cet article... SOYEZ LE PREMIER ! :D</h2>
<?php else : ?>
  <h2 class="comment-heading">Il y a déjà <?= count($commentaires) ?> réactions :</h2>
  <?php foreach ($commentaires as $commentaire) : ?>
    <h3 class="comment-author">Commentaire de <?= $commentaire['author'] ?></h3>
    <small class="comment-date">Le <?= $commentaire['created_at'] ?></small>
    <blockquote class="comment-content">
      <em><?= $commentaire['content'] ?></em>
    </blockquote>
    <a href="delete-comment?id=<?= $commentaire['id'] ?>" onclick="return window.confirm(`Êtes-vous sûr de vouloir supprimer ce commentaire ?!`)" class="comment-delete">Supprimer</a>
  <?php endforeach ?>
<?php endif ?>

<form action="save-comment" method="POST" class="comment-form">
  <h3 class="comment-form-heading">Vous voulez réagir ? N'hésitez pas les bros !</h3>
  <input type="text" name="author" placeholder="Votre pseudo !" class="comment-form-author">
  <textarea name="content" cols="30" rows="10" placeholder="Votre commentaire ..." class="comment-form-content"></textarea>
  <input type="hidden" name="article_id" value="<?= $article_id ?>">
  <button class="comment-form-submit">Commenter !</button>
</form>