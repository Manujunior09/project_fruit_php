<h1>Inscription</h1>

<?php if (!empty($errors)): ?>
    <ul class="errors">
        <?php foreach ($errors as $err): ?>
            <li><?= htmlspecialchars($err) ?></li>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>

<form method="post" action="/register">
    <div>
        <label>Nom d'utilisateur</label>
        <input type="text" name="username" value="<?= htmlspecialchars($data['username'] ?? '') ?>">
    </div>
    <div>
        <label>Email</label>
        <input type="email" name="email" value="<?= htmlspecialchars($data['email'] ?? '') ?>">
    </div>
    <div>
        <label>Mot de passe</label>
        <input type="password" name="password">
    </div>
    <div>
        <label>Confirmer le mot de passe</label>
        <input type="password" name="password_confirm">
    </div>
    <div>
        <button type="submit">S'inscrire</button>
    </div>
</form>
