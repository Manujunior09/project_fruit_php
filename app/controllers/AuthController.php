<?php

namespace controllers ;

require_once __DIR__ . '/Controller.php';
require_once __DIR__ . '/../models/UserModel.php';

class AuthController extends Controller {

    private $userModel;

    public function __construct() {
        $this->userModel = new \models\UserModel();
    }

    // Affiche le formulaire d'inscription
    public function register() {
        $this->view('auth/register', ['title' => 'Inscription']);
    }
    

    public function registerPost() {
        $data = $_POST;
        $errors = [];

        $username = trim($data['username'] ?? '');
        $email = trim($data['email'] ?? '');
        $password = $data['password'] ?? '';
        $passwordConfirm = $data['password_confirm'] ?? '';

        if (empty($username)) {
            $errors['username'] = 'Nom d\'utilisateur requis';
        }
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = 'Email invalide';
        }
        if (strlen($password) < 6) {
            $errors['password'] = 'Le mot de passe doit faire au moins 6 caractères';
        }
        if ($password !== $passwordConfirm) {
            $errors['password_confirm'] = 'Les mots de passe ne correspondent pas';
        }

        // Vérifier unicité
        if ($this->userModel->findByUsername($username)) {
            $errors['username'] = 'Ce nom d\'utilisateur est déjà pris';
        }
        if ($this->userModel->findByEmail($email)) {
            $errors['email'] = 'Cet email est déjà utilisé';
        }

        if (!empty($errors)) {
            $this->view('auth/register', ['errors' => $errors, 'data' => $data, 'title' => 'Inscription']);
            return;
        }

        $passwordHash = password_hash($password, PASSWORD_DEFAULT);
        $userId = $this->userModel->createUser($username, $email, $passwordHash);

        // $user = $this->userModel->findById($userId);
        // $_SESSION['user'] = ['id' => $user['id'], 'username' => $user['username'], 'role' => $user['role']];

        $this->setFlash('success', 'Inscription réussie. Veuillez vous connecter  ');
        header('Location: /login');
        exit();
    }

    // Affiche le formulaire de connexion
    public function login() {
        $this->view('auth/login', ['title' => 'Connexion']);
    }

    // Traite la connexion
    public function loginPost() {
        $data = $_POST;
        $usernameOrEmail = trim($data['username'] ?? '');
        $password = $data['password'] ?? '';

        $user = $this->userModel->findByUsername($usernameOrEmail);
        if (!$user) {
            $user = $this->userModel->findByEmail($usernameOrEmail);
        }

        if (!$user || !password_verify($password, $user['password'])) {
            $this->view('auth/login', ['errors' => ['credentials' => 'Identifiants invalides'], 'data' => $data, 'title' => 'Connexion']);
            return;
        }

        // Connecter l'utilisateur
        $_SESSION['user'] = ['id' => $user['id'], 'username' => $user['username'], 'role' => $user['role']];
        $this->setFlash('success', 'Connexion réussie. Bonjour ' . $user['username'] . '!');
        header('Location: /');
        exit();
    }

    public function logout() {
        unset($_SESSION['user']);
        session_regenerate_id(true);
        $this->setFlash('success', 'Vous avez été déconnecté.');
        header('Location: /login');
        exit();
    }

}
