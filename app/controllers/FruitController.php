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

        $dateDebut = isset($_GET['date_debut']) ? $_GET['date_debut'] : null;
        $dateFin = isset($_GET['date_fin']) ? $_GET['date_fin'] : null;

        // Validation des dates
        if ($dateDebut && $dateFin) {
            $dateDebutObj = \DateTime::createFromFormat('Y-m-d', $dateDebut);
            $dateFinObj = \DateTime::createFromFormat('Y-m-d', $dateFin);
            
            if ($dateDebutObj && $dateFinObj && $dateDebutObj > $dateFinObj) {
                // Si la date de début est après la date de fin, on les inverse
                $temp = $dateDebut;
                $dateDebut = $dateFin;
                $dateFin = $temp;
            }
        }

        $fruits = $this->fruitModel->getAllFruits($dateDebut, $dateFin);
        $this->view('fruits/index', [
            'fruits' => $fruits,
            'title' => 'Accueil des Fruits',
            'dateDebut' => $dateDebut,
            'dateFin' => $dateFin
        ]);
    }

    public function show($id) {
        // Accessible uniquement aux utilisateurs connectés
        $this->requireAuth();
        $fruit = $this->fruitModel->getFruitById($id);
        if (!$fruit) {
            http_response_code(404);
            $this->view('errors/404', ['title' => 'Fruit non trouvé']);
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
        $this->requireAdmin();

        $errors = [];
        $data = $_POST;

        if (!isset($data['prix']) || !is_numeric($data['prix']) || (float)$data['prix'] <= 0) {
            $errors['prix'] = 'Le prix doit être un nombre positif.';
        }
        if (empty(trim($data['nom']))) {
            $errors['nom'] = 'Le nom du fruit ne peut pas être vide.';
        }

        if (!empty($errors)) {
            // Si des erreurs sont trouvées, on recharge la vue du formulaire avec les erreurs et les données saisies
            $this->view('fruits/create', ['data' => $data, 'errors' => $errors, 'title' => 'Ajouter un Fruit']);
            return;
        }

        // Limite de taille pour les fichiers uploadés (1 Mo)
        $taille_max = 1000000; // octets

        // Préparer la clé image pour éviter les notices dans le modèle
        $data['image'] = null;

        // Gérer l'upload d'image si fourni
        if (isset($_FILES['image']) && $_FILES['image']['error'] !== UPLOAD_ERR_NO_FILE) {
            if ($_FILES['image']['error'] !== UPLOAD_ERR_OK) {
                $errors['image'] = 'Erreur lors du téléversement de l\'image.';
            } elseif ($_FILES['image']['size'] > $taille_max) {
                $errors['image'] = 'Le fichier est trop volumineux (max 1 Mo).';
            } else {
                $uploadDir = __DIR__ . '/../public/uploads/';
                if (!is_dir($uploadDir)) {
                    mkdir($uploadDir, 0777, true);
                }
                $extension = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
                $imageName = uniqid('fruit_', true) . '.' . $extension;
                $uploadFile = $uploadDir . $imageName;
                if (move_uploaded_file($_FILES['image']['tmp_name'], $uploadFile)) {
                    $data['image'] = $imageName;
                } else {
                    $errors['image'] = 'Impossible de déplacer le fichier uploadé.';
                }
            }
        }

        if (!empty($errors)) {
            $this->view('fruits/create', ['data' => $data, 'errors' => $errors, 'title' => 'Ajouter un Fruit']);
            return;
        }

        $newFruitId = $this->fruitModel->addFruit($data);
        header('Location: /fruits/' . $newFruitId);
        exit();
    }

    public function edit($id) {
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
        if (isset($_FILES['image']) && $_FILES['image']['error'] !== UPLOAD_ERR_NO_FILE) {
            // Limite de taille pour les fichiers uploadés (1 Mo)
            $taille_max = 1000000; // octets

            if ($_FILES['image']['error'] !== UPLOAD_ERR_OK) {
                $errors['image'] = 'Erreur lors du téléversement de l\'image.';
            } elseif ($_FILES['image']['size'] > $taille_max) {
                $errors['image'] = 'Le fichier est trop volumineux (max 1 Mo).';
            } else {
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
                    $data['image'] = $imageName; // 
                } else {
                    $errors['image'] = 'Impossible de déplacer le fichier uploadé.';
                }
            }
        }

        if (!empty($errors)) {
            // Recharger la vue d'édition avec les erreurs et les données saisies
            $fruit = $this->fruitModel->getFruitById($id);
            $this->view('fruits/edit', ['fruit' => array_merge($fruit, $data), 'errors' => $errors, 'title' => 'Modifier le Fruit']);
            return;
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
        $this->requireAdmin();

        $this->fruitModel->deleteFruit($id);
        header('Location: /');
        exit();
    }


}
