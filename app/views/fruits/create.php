<?php
$title = "Ajouter un Fruit";
?>
<div class="form-container">
    <div class="card">
        <div class="card__body">
            <h1>Ajouter un nouveau fruit</h1>
            
            <form method="POST" action="/fruits" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="nom" class="form-label">Nom:</label>
                    <input type="text" id="nom" name="nom" class="form-control" value="<?= htmlspecialchars($data['nom'] ?? '') ?>" required>
                    <?php if (isset($errors['nom'])): ?>
                        <p class="form-error"><?= $errors['nom'] ?></p>
                    <?php endif; ?>
                </div>
                
                <div class="form-group">
                    <label for="prix" class="form-label">Prix:</label>
                    <input type="number" id="prix" name="prix" step="0.01" class="form-control" value="<?= htmlspecialchars($data['prix'] ?? '') ?>" required>
                    <?php if (isset($errors['prix'])): ?>
                        <p class="form-error"><?= $errors['prix'] ?></p>
                    <?php endif; ?>
                </div>
                
                <div class="form-group">
                    <label for="description" class="form-label">Description:</label>
                    <textarea id="description" name="description" class="form-control" required><?= htmlspecialchars($data['description'] ?? '') ?></textarea>
                </div>
                <div class="form-group">
                    <label for="image" class="form-label">Image (PNG, JPG):</label>
                    <input type="file" id="image" name="image" class="form-control" accept=".png, .jpg, .jpeg" value="1000000">
                    <?php if (isset($errors['image'])): ?>
                        <p class="form-error"><?= $errors['image'] ?></p>
                    <?php endif; ?>
                </div>
                <button type="submit" class="btn btn--primary btn--full-width">Ajouter</button>

                <a href="/" class="btn btn-secondary">Annuler</a>
            </form>
        </div>
    </div>
</div>