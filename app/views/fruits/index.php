<?php
$title = "Liste des Fruits Magiques";
?>
<div class="fruits-container container">
    <h1 class="rainbow-text">✨ Collection de Fruits Magiques ✨</h1>
    
    <?php if (isset($_SESSION['user']) && $_SESSION['user']['role'] === 'admin'): ?>
        <div class="text-center mb-4">
            <a href="/fruits/create" class="btn btn-primary sparkle">
                <span>✨</span> Créer un Nouveau Fruit Magique
            </a>
        </div>
    <?php endif; ?>
    
    <div class="fruits-grid">
        <?php foreach ($fruits as $fruit): ?>
            <div class="fruit-card magic-hover">
                <?php if (!empty($fruit['image'])): ?>
                    <img src="/uploads/<?= htmlspecialchars($fruit['image']) ?>" 
                         alt="<?= htmlspecialchars($fruit['nom']) ?>" 
                         class="fruit-card__image">
                <?php else: ?>
                    <img src="/uploads/default-fruit.jpg" 
                         alt="Image par défaut" 
                         class="fruit-card__image">
                <?php endif; ?>
                
                <div class="fruit-card__content">
                    <h3 class="fruit-card__title sparkle"><?= htmlspecialchars($fruit['nom']) ?></h3>
                    <?php if (isset($fruit['prix'])): ?>
                        <div class="fruit-card__price"><?= number_format($fruit['prix'], 2) ?> €</div>
                    <?php endif; ?>
                    <p class="fruit-card__description"><?= htmlspecialchars($fruit['description']) ?></p>
                </div>
                
                <div class="fruit-card__footer">
                    <a href="/fruits/<?= $fruit['id'] ?>" class="btn btn-secondary">
                        Découvrir ses pouvoirs
                    </a>
                    <?php if (isset($_SESSION['user']) && $_SESSION['user']['role'] === 'admin'): ?>
                        <a href="/fruits/edit/<?= $fruit['id'] ?>" class="btn btn-primary">
                            Modifier
                        </a>
                    <?php endif; ?>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
    
    <?php if (empty($fruits)): ?>
        <div class="text-center mt-4">
            <p class="mb-3">Aucun fruit magique n'a encore été découvert...</p>
            <?php if (isset($_SESSION['user']) && $_SESSION['user']['role'] === 'admin'): ?>
                <a href="/fruits/create" class="btn btn-primary">Ajouter le premier fruit</a>
            <?php endif; ?>
        </div>
    <?php endif; ?>
</div>