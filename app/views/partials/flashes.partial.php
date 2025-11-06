<?php
// Affiche puis efface les messages flash stockés en session.
if (session_status() !== PHP_SESSION_ACTIVE) {
    @session_start();
}

if (!empty($_SESSION['flash'])):
    foreach ($_SESSION['flash'] as $type => $messages):
        foreach ($messages as $msg):
            $class = $type === 'success' ? 'flash-success' : ($type === 'error' ? 'flash-error' : 'flash-info');
?>
            <div class="flash <?= htmlspecialchars($class) ?>"><?php echo htmlspecialchars($msg); ?></div>
<?php
        endforeach;
    endforeach;
    // Clear flashes after display
    unset($_SESSION['flash']);
endif;
