<div class="auth-form">
    <h1 class="rainbow-text text-center mb-4">Inscription Magique</h1>

    <?php if (!empty($errors)): ?>
        <div class="flash flash-error mb-3">
            <ul>
                <?php foreach ($errors as $err): ?>
                    <li><?= htmlspecialchars($err) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <form method="post" action="/register">
        <div class="form-group">
            <label class="form-label" for="username">Nom d'utilisateur</label>
            <input type="text" class="form-control" id="username" name="username" value="<?= htmlspecialchars($data['username'] ?? '') ?>" autocomplete="username">
        </div>
        <div class="form-group">
            <label class="form-label" for="email">Email</label>
            <input type="email" class="form-control" id="email" name="email" value="<?= htmlspecialchars($data['email'] ?? '') ?>" autocomplete="email">
        </div>
        <div class="form-group">
            <label class="form-label" for="password">Mot de passe</label>
            <input type="password" class="form-control" id="password" name="password" autocomplete="new-password">
        </div>
        <div class="form-group">
            <label class="form-label" for="password_confirm">Confirmer le mot de passe</label>
            <input type="password" class="form-control" id="password_confirm" name="password_confirm" autocomplete="new-password">
        </div>
        <div class="form-group text-center mt-3">
            <button type="submit" class="btn btn-primary sparkle">✨ S'inscrire</button>
        </div>
    </form>
    <div class="text-center mt-3">
        <a href="/login" class="btn btn-secondary">Déjà membre ? Connexion</a>
    </div>
</div>