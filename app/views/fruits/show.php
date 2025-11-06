<?php
$title = "Détail du Fruit";
?>
<?php if ($fruit): ?>
    <div class="fruit-detail">
        <div class="card">
            <div class="card__body">
                <h1><?= htmlspecialchars($fruit['nom']) ?></h1>
                
                <?php if (!empty($fruit['image'])): ?>
                    <div class="fruit-image-container">
                        <img src="/uploads/<?= htmlspecialchars($fruit['image']) ?>" alt="Image de <?= htmlspecialchars($fruit['nom']) ?>" class="fruit-image-detail">
                    </div>
                <?php endif; ?>

                <div class="detail-content">
                    <p class="price"><?= htmlspecialchars($fruit['prix']) ?> €</p>
                    <p class="description"><?= htmlspecialchars($fruit['description']) ?></p>
                    <p><strong>Pouvoir magique :</strong> <?= htmlspecialchars($fruit['pouvoir'] ?? 'Non spécifié') ?></p>
                    <p><strong>Origine :</strong> <?= htmlspecialchars($fruit['origine'] ?? 'Inconnue') ?></p>
                </div>
                
                <div class="action-buttons">
                    <a href="/fruits/<?= $fruit['id'] ?>/edit" class="btn btn--primary">Modifier</a>
                    <form method="POST" action="/fruits/<?= $fruit['id'] ?>/delete" style="display: inline;" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce fruit ?');">
                        <button type="submit" class="btn btn--outline">Supprimer</button>
                    </form>
                    <a href="/" class="btn btn--secondary">Retour</a>
                </div>
            </div>
        </div>
    </div>
<?php else: ?>
    <div class="container" style="text-align: center; padding: 40px;">
        <h1>Fruit non trouvé</h1>
        <p>Désolé, ce fruit n'est pas disponible dans notre boutique magique.</p>
        <a href="/" class="btn btn--primary" style="margin-top: 20px;">Retour à la liste des fruits</a>
    </div>
<?php endif; ?>