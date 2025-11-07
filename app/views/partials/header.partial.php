<header class="header-main">
    <h1 class="rainbow-text">La Boutique des Fruits Magiques de MJ</h1>
    <nav>
        <?php if (isset($_SESSION['user'])): ?>
            <span>Bonjour, <?= htmlspecialchars($_SESSION['user']['username']) ?> (<?= htmlspecialchars($_SESSION['user']['role']) ?>)</span>
            <?php if ($_SESSION['user']['role'] === 'admin'): ?>
                | <a href="/fruits/create">Ajouter un fruit</a>
            <?php endif; ?>
            | <a href="/logout">Se déconnecter</a>
        <?php else: ?>
            <a href="/login">Connexion</a> | <a href="/register">Inscription</a>
        <?php endif; ?>
    </nav>
</header>