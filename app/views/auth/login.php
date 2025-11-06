<h1>Connexion</h1>

<?php if (!empty($errors)): ?>
    <ul class="errors">
        <?php foreach ($errors as $err): ?>
            <li><?= htmlspecialchars($err) ?></li>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>

<form method="post" action="/login">
    <div>
        <label>Nom d'utilisateur ou Email</label>
        <input type="text" name="username" value="<?= htmlspecialchars($data['username'] ?? '') ?>">
    </div>
    <div>
        <label>Mot de passe</label>
        <input type="password" name="password">
    </div>
    <div>
        <button type="submit">Se connecter</button>
    </div>
</form>
