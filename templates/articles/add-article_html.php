
<h1>Ajouter un nouvel article</h1>

<form method="POST" action="add-article">
<label for="title">Title:</label>
        <input type="text" name="title" id="title">

        <br>

        <div hidden>
        <label for="slug">Slug:</label>
        <input type="text" name="slug" id="slug" >
        </div>

        <br>

        <label for="introduction">Introduction:</label>
        <textarea name="introduction" id="introduction"></textarea>

        <br>

        <label for="content">Content:</label>
        <textarea name="content" id="content"></textarea>

        <br>

        <input type="submit" value="Ajouter">
</form>