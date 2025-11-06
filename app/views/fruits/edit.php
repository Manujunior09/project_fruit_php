<?php
$title = "Modifier le Fruit";
?>
<div class="form-container">
    <div class="card">
        <div class="card__body">
            <h1>Modifier le fruit: <?= htmlspecialchars($fruit['nom']) ?></h1>
            
            <form method="POST" action="/fruits/<?= $fruit['id'] ?>">
                <input type="hidden" name="_method" value="PUT"> <!-- Pour simuler une requête PUT -->
                <div class="form-group">
                    <label for="nom" class="form-label">Nom:</label>
                    <input type="text" id="nom" name="nom" class="form-control" value="<?= htmlspecialchars($fruit['nom']) ?>" required>
                </div>
                <div class="form-group">
                    <label for="prix" class="form-label">Prix:</label>
                    <input type="number" id="prix" name="prix" step="0.01" class="form-control" value="<?= htmlspecialchars($fruit['prix']) ?>" required>
                </div>
                <div class="form-group">
                    <label for="description" class="form-label">Description:</label>
                    <textarea id="description" name="description" class="form-control" required><?= htmlspecialchars($fruit['description']) ?></textarea>
                </div>
                <button type="submit" class="btn btn--primary btn--full-width">Mettre à jour</button>
            </form>
        </div>
    </div>
</div>