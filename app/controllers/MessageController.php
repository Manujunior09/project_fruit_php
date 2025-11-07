<?php 
namespace controllers;

require_once __DIR__.'/../models/MessageModel.php';

class MessageController {

    private $messageModel;

    public function __construct() {
        $this->messageModel = new \models\MessageModel();
    }

    public function create(){
        $this->requireAuth();
        $this->view('messages/create', ['title' => 'Envoyer un message']);
    }

    public function realCreate(){
        $this->requireAuth();
        $data = $_POST;
        $errors = [];

        // Validation du sujet
        if (empty($data['subject'])) {
            $errors['subject'] = 'Le sujet est requis.';
        } elseif (strlen($data['subject']) < 3) {
            $errors['subject'] = 'Le sujet doit contenir au moins 3 caractères.';
        } elseif (strlen($data['subject']) > 255) {
            $errors['subject'] = 'Le sujet ne peut pas dépasser 255 caractères.';
        }

        // Validation du contenu
        if (empty($data['content'])) {
            $errors['content'] = 'Le contenu est requis.';
        } elseif (strlen($data['content']) < 10) {
            $errors['content'] = 'Le contenu doit contenir au moins 10 caractères.';
        }

        // Si des erreurs sont trouvées
        if (!empty($errors)) {
            $this->view('messages/create', [
                'data' => $data,
                'errors' => $errors,
                'title' => 'Envoyer un message'
            ]);
            return;
        }

        $data['subject'] = htmlspecialchars($data['subject']);
        $data['content'] = htmlspecialchars($data['content']);

        // Récupérer l'ID de l'utilisateur depuis la session
        $userId = $_SESSION['user']['id'];

        $this->messageModel->create($userId, $data['subject'], $data['content']);

        // Message flash de succès
        $_SESSION['flash'] = [
            'type' => 'success',
            'message' => 'Votre message a été envoyé avec succès!'
        ];

        // Redirection vers la liste des messages
        header('Location: /my_messages');
        exit();


    }

    public function myMessages(){
        $this->requireAuth();
        
        // Récupérer l'ID de l'utilisateur connecté
        $userId = $_SESSION['user']['id'];
        
        // Récupérer les messages de l'utilisateur
        $messages = $this->messageModel->findByUserId($userId);
        
        $this->view('messages/my_messages', [
            'messages' => $messages, 
            'title' => 'Mes messages'
        ]);
    }

    public function index(){
        // Seuls les administrateurs peuvent voir tous les messages
        $this->requireAdmin();
        $messages = $this->messageModel->getAllMessages();

        $this->view('messages/index', [
            'messages' => $messages,
            'title' => 'Tous les messages'
        ]);
    }
}

    
