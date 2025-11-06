<?php

namespace controllers ;

require_once __DIR__ . '/Controller.php';
require_once __DIR__ . '/../models/FruitModel.php';

class FruitController extends Controller {

    private $fruitModel;

    public function __construct() {
    $this->fruitModel = new \models\FruitModel();

    }

    public function index() {
        // Accessible uniquement aux utilisateurs connectés
        $this->requireAuth();
        $fruits = $this->fruitModel->getAllFruits();
        $this->view('fruits/index', ['fruits' => $fruits, 'title' => 'Accueil des Fruits']);

    }

    public function show($id) {
        // Accessible uniquement aux utilisateurs connectés
        $this->requireAuth();
        $fruit = $this->fruitModel->getFruitById($id);
        if (!$fruit) {
            http_response_code(404);
            $this->view('fruits/404', ['title' => 'Fruit non trouvé']);
            return;
        }
       $this->view('fruits/show', ['fruit' => $fruit, 'title' => 'Détail du Fruit']);
    }

    public function create() {
        // Seuls les admins peuvent créer
        $this->requireAdmin();
        $this->view('fruits/create', ['title' => 'Ajouter un Fruit']);
    }

    public function realCreate() {
        // Seuls les admins peuvent créer
        $this->requireAdmin();

        $errors = [];
        $data = $_POST;

        // --- Début de la validation ---
        if (!isset($data['prix']) || !is_numeric($data['prix']) || (float)$data['prix'] <= 0) {
            $errors['prix'] = 'Le prix doit être un nombre positif.';
        }
        if (empty(trim($data['nom']))) {
            $errors['nom'] = 'Le nom du fruit ne peut pas être vide.';
        }
        // --- Fin de la validation ---

        if (!empty($errors)) {
            // Si des erreurs sont trouvées, on recharge la vue du formulaire avec les erreurs et les données saisies
            $this->view('fruits/create', ['data' => $data, 'errors' => $errors, 'title' => 'Ajouter un Fruit']);
            return;
        }

        // TODO: Gérer l'upload de l'image pour la création
        $newFruitId = $this->fruitModel->addFruit($data);
        header('Location: /fruits/' . $newFruitId);
        exit();
    }

    public function edit($id) {
        // Seuls les admins peuvent modifier
        $this->requireAdmin();

        $fruit = $this->fruitModel->getFruitById($id);
        if (!$fruit) {
            http_response_code(404);
            $this->view('errors/404', ['title' => 'Fruit non trouvé']);
            return;
        }
        $this->view('fruits/edit', ['fruit' => $fruit, 'title' => 'Modifier le Fruit']);
    }

    public function update($id) {
        // Seuls les admins peuvent modifier
        $this->requireAdmin();

        $errors = [];
        $data = $_POST;

        // --- Début de la validation ---
        if (!isset($data['prix']) || !is_numeric($data['prix']) || (float)$data['prix'] <= 0) {
            $errors['prix'] = 'Le prix doit être un nombre positif.';
        }
        // Vous pouvez ajouter d'autres validations ici (ex: nom non vide)

        if (!empty($errors)) {
            // Si des erreurs sont trouvées, on recharge la vue du formulaire avec les erreurs
            $fruit = $this->fruitModel->getFruitById($id);
            // On fusionne les données du fruit avec les données postées pour ne pas perdre la saisie
            $this->view('fruits/edit', ['fruit' => array_merge($fruit, $data), 'errors' => $errors, 'title' => 'Modifier le Fruit']);
            return;
        }
        // --- Fin de la validation ---

        $data = $_POST;
        $imageName = null;
        $oldImageName = null;

        // 1. Vérifier si une nouvelle image est téléversée et valide
        if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
            // On récupère d'abord les infos du fruit actuel pour connaître l'ancienne image
            $currentFruit = $this->fruitModel->getFruitById($id);
            $oldImageName = $currentFruit['image'] ?? null;

            $uploadDir = __DIR__ . '/../public/uploads/';
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }
            
            // 2. Générer un nom de fichier unique
            $extension = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
            $imageName = uniqid('fruit_', true) . '.' . $extension;
            $uploadFile = $uploadDir . $imageName;

            // 3. Déplacer le fichier
            if (move_uploaded_file($_FILES['image']['tmp_name'], $uploadFile)) {
                $data['image'] = $imageName; // Ajouter le nouveau nom d'image aux données à mettre à jour
            }
        }

        $this->fruitModel->updateFruit($id, $data);

        // 4. Si une nouvelle image a été uploadée avec succès, supprimer l'ancienne
        if ($oldImageName && file_exists(__DIR__ . '/../public/uploads/' . $oldImageName)) {
            unlink(__DIR__ . '/../public/uploads/' . $oldImageName);
        }

        header('Location: /fruits/' . $id);
        exit();
    }

    public function delete($id) {
        // Seuls les admins peuvent supprimer
        $this->requireAdmin();

        $this->fruitModel->deleteFruit($id);
        header('Location: /');
        exit();
    }


}
