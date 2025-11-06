<?php
$title = "Liste des Fruits";
?>
<div class="fruits-container">
    <h1>Nos Fruits Magiques</h1>
    
    <a href="/fruits/create" class="btn btn--primary">
        Ajouter un fruit
    </a>
    
    <div class="fruits-grid">
        <?php foreach ($fruits as $fruit): ?>
            <div class="card">
                <div class="card__body">
                    <h3><?= htmlspecialchars($fruit['nom']) ?></h3>
                    <p><?= htmlspecialchars($fruit['description']) ?></p>
                    <a href="/fruits/<?= $fruit['id'] ?>" class="btn btn--secondary btn--sm">Voir détail</a>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>