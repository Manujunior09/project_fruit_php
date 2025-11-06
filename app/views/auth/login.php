<div class="auth-form">
    <h1 class="rainbow-text text-center mb-4">Connexion Magique</h1>

    <?php if (!empty($errors)): ?>
        <div class="flash flash-error mb-3">
            <ul>
                <?php foreach ($errors as $err): ?>
                    <li><?= htmlspecialchars($err) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <form method="post" action="/login">
        <div class="form-group">
            <label class="form-label" for="username">Nom d'utilisateur ou Email</label>
            <input type="text" class="form-control" id="username" name="username" value="<?= htmlspecialchars($data['username'] ?? '') ?>" autocomplete="username">
        </div>
        <div class="form-group">
            <label class="form-label" for="password">Mot de passe</label>
            <input type="password" class="form-control" id="password" name="password" autocomplete="current-password">
        </div>
        <div class="form-group text-center mt-3">
            <button type="submit" class="btn btn-primary sparkle">✨ Se connecter</button>
        </div>
    </form>
    <div class="text-center mt-3">
        <a href="/register" class="btn btn-secondary">Créer un compte magique</a>
    </div>
</div>