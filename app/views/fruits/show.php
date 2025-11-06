<?php
$title = "Détail du Fruit";
?>
<div class="fruit-detail">
    <div class="card">
        <div class="card__body">
            <h1><?= htmlspecialchars($fruit['nom']) ?></h1>
            
            <div class="detail-content">
                <p class="price"><?= htmlspecialchars($fruit['prix']) ?> €</p>
                <p class="description"><?= htmlspecialchars($fruit['description']) ?></p>
            </div>
            
            <div class="action-buttons">
                <a href="/fruits/<?= $fruit['id'] ?>/edit" class="btn btn--primary">Modifier</a>
                <a href="/fruits/<?= $fruit['id'] ?>/delete" class="btn btn--outline">Supprimer</a>
                <a href="/" class="btn btn--secondary">Retour</a>
            </div>
        </div>
    </div>
</div>