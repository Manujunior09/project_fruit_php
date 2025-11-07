<?php
$title = "Modifier le Fruit";
?>
<div class="form-container">
    <div class="card">
        <div class="card__body">
            <h1>Modifier le fruit: <?= htmlspecialchars($fruit['nom']) ?></h1>
            
            <form method="POST" action="/fruits/<?= $fruit['id'] ?>" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="nom" class="form-label">Nom:</label>
                    <input type="text" id="nom" name="nom" class="form-control" value="<?= htmlspecialchars($fruit['nom']) ?>" required>
                </div>
                <div class="form-group">
                    <label for="prix" class="form-label">Prix:</label>
                    <input type="number" id="prix" name="prix" step="0.01" class="form-control" value="<?= htmlspecialchars($fruit['prix']) ?>" required>
                    <?php if (isset($errors['prix'])): ?>
                        <p class="form-error"><?= $errors['prix'] ?></p>
                    <?php endif; ?>
                </div>
                <div class="form-group">
                    <label for="description" class="form-label">Description:</label>
                    <textarea id="description" name="description" class="form-control" required><?= htmlspecialchars($fruit['description']) ?></textarea>
                </div>
                <div class="form-group">
                    <label for="pouvoir" class="form-label">Pouvoir magique:</label>
                    <input type="text" id="pouvoir" name="pouvoir" class="form-control" value="<?= htmlspecialchars($fruit['pouvoir'] ?? '') ?>">
                </div>
                <div class="form-group">
                    <label for="origine" class="form-label">Origine:</label>
                    <input type="text" id="origine" name="origine" class="form-control" value="<?= htmlspecialchars($fruit['origine'] ?? '') ?>">
                </div>
                <div class="form-group">
                    <label for="image" class="form-label">Image (PNG, JPG):</label>
                    <?php if (!empty($fruit['image'])): ?>
                        <div style="margin-bottom: 10px;">
                            <img src="/uploads/<?= htmlspecialchars($fruit['image']) ?>" alt="Image actuelle" style="max-width: 100px; max-height: 100px; border-radius: 4px;">
                        </div>
                    <?php endif; ?>
                    <input type="file" id="image" name="image" class="form-control" accept=".png, .jpg, .jpeg">
                    <?php if (isset($errors['image'])): ?>
                        <p class="form-error"><?= $errors['image'] ?></p>
                    <?php endif; ?>
                </div>
                <button type="submit" class="btn btn--primary btn--full-width">Mettre à jour</button>
            </form>
        </div>
    </div>
</div>