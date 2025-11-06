<?php

namespace controllers ;

class Controller {

    public function view ($path, $data = []){
        extract($data);
        ob_start();
        require_once __DIR__ . "/../views/{$path}.php";
        $content = ob_get_clean();
        require_once __DIR__ . "/../views/layout/defaultLayout.php";


    }

    // Authentication helpers
    protected function isAuthenticated(): bool {
        return isset($_SESSION['user']) && !empty($_SESSION['user']['id']);
    }

    protected function getUser(): ?array {
        return $_SESSION['user'] ?? null;
    }

    protected function requireAuth() {
        if (!$this->isAuthenticated()) {
            header('Location: /login');
            exit();
        }
    }

    protected function isAdmin(): bool {
        $user = $this->getUser();
        return $user && isset($user['role']) && $user['role'] === 'admin';
    }

    protected function requireAdmin() {
        $this->requireAuth();
        if (!$this->isAdmin()) {
            http_response_code(403);
            echo "403 - Accès refusé";
            exit();
        }
    }
}