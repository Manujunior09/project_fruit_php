<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'Fruits Magiques' ?></title>
    <link rel="stylesheet" href="/style.css">
</head>
<body> 
    <?php include __DIR__ . '/../partials/header.partial.php'; ?>
    <main class="main-content">
        <?= $content ?>
    </main>
    <?php include __DIR__ . '/../partials/footer.partial.php'; ?>
</body>
</html>