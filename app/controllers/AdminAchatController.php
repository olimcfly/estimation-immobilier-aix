<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\Database;
use App\Core\Validator;
use App\Core\View;
use App\Models\Achat;
use App\Models\Partenaire;

final class AdminAchatController
{
    private const STATUTS = [
        'prospect', 'recherche', 'visite', 'offre', 'negociation',
        'compromis', 'financement', 'acte_signe', 'annule',
    ];

    private const STATUT_LABELS = [
        'prospect' => 'Prospect',
        'recherche' => 'En recherche',
        'visite' => 'Visite',
        'offre' => 'Offre',
        'negociation' => 'Negociation',
        'compromis' => 'Compromis',
        'financement' => 'Financement',
        'acte_signe' => 'Acte signe',
        'annule' => 'Annule',
    ];

    public function index(): void
    {
        AuthController::requireAuth();

        $model = new Achat();

        $score = isset($_GET['score']) && in_array($_GET['score'], ['chaud', 'tiede', 'froid'], true) ? $_GET['score'] : null;
        $statut = isset($_GET['statut']) && in_array($_GET['statut'], self::STATUTS, true) ? $_GET['statut'] : null;

        $achats = $model->findAllFiltered($score, $statut);
        $stats = $model->getStats();
        $statutCounts = $model->countByStatut();

        // Check if table exists
        $tableExists = Database::tableExists('achats');

        View::renderAdmin('admin/achats', [
            'page_title' => 'Achats - Admin CRM',
            'admin_page_title' => 'Achats',
            'admin_page' => 'achats',
            'breadcrumb' => 'Achats',
            'achats' => $achats,
            'stats' => $stats,
            'statutCounts' => $statutCounts,
            'statutLabels' => self::STATUT_LABELS,
            'filterScore' => $score,
            'filterStatut' => $statut,
            'tableExists' => $tableExists,
        ]);
    }

    public function edit(): void
    {
        AuthController::requireAuth();

        $id = isset($_GET['id']) ? (int) $_GET['id'] : 0;
        $achat = null;

        if ($id > 0) {
            $model = new Achat();
            $achat = $model->findById($id);
            if ($achat === null) {
                header('Location: /admin/achats');
                exit;
            }
        }

        $partenaires = (new Partenaire())->findActifs();

        View::renderAdmin('admin/achat-edit', [
            'page_title' => $achat ? 'Modifier Achat' : 'Nouvel Achat',
            'admin_page' => 'achats',
            'breadcrumb' => $achat ? 'Modifier Achat' : 'Nouvel Achat',
            'achat' => $achat,
            'partenaires' => $partenaires,
            'statutLabels' => self::STATUT_LABELS,
            'errors' => [],
        ]);
    }

    public function save(): void
    {
        AuthController::requireAuth();
        AuthController::verifyCsrfToken();

        try {
            $id = isset($_POST['id']) ? (int) $_POST['id'] : 0;
            $nom = Validator::string($_POST, 'nom_acheteur', 2, 180);

            $data = [
                'nom_acheteur' => $nom,
                'email_acheteur' => trim((string) ($_POST['email_acheteur'] ?? '')),
                'telephone_acheteur' => trim((string) ($_POST['telephone_acheteur'] ?? '')),
                'lead_id' => !empty($_POST['lead_id']) ? (int) $_POST['lead_id'] : null,
                'adresse_bien' => trim((string) ($_POST['adresse_bien'] ?? '')),
                'ville' => trim((string) ($_POST['ville'] ?? '')) ?: 'Aix-en-Provence',
                'quartier' => trim((string) ($_POST['quartier'] ?? '')),
                'type_bien' => trim((string) ($_POST['type_bien'] ?? '')),
                'surface_m2' => !empty($_POST['surface_m2']) ? (float) $_POST['surface_m2'] : null,
                'pieces' => !empty($_POST['pieces']) ? (int) $_POST['pieces'] : null,
                'prix_achat' => !empty($_POST['prix_achat']) ? (float) $_POST['prix_achat'] : null,
                'prix_estime' => !empty($_POST['prix_estime']) ? (float) $_POST['prix_estime'] : null,
                'type_financement' => in_array($_POST['type_financement'] ?? '', ['comptant', 'credit', 'mixte'], true)
                    ? $_POST['type_financement'] : 'credit',
                'montant_pret' => !empty($_POST['montant_pret']) ? (float) $_POST['montant_pret'] : null,
                'apport_personnel' => !empty($_POST['apport_personnel']) ? (float) $_POST['apport_personnel'] : null,
                'statut' => in_array($_POST['statut'] ?? '', self::STATUTS, true)
                    ? $_POST['statut'] : 'prospect',
                'score' => in_array($_POST['score'] ?? '', ['chaud', 'tiede', 'froid'], true)
                    ? $_POST['score'] : 'froid',
                'partenaire_id' => !empty($_POST['partenaire_id']) ? (int) $_POST['partenaire_id'] : null,
                'commission_taux' => !empty($_POST['commission_taux']) ? (float) $_POST['commission_taux'] : null,
                'commission_montant' => !empty($_POST['commission_montant']) ? (float) $_POST['commission_montant'] : null,
                'date_premiere_visite' => !empty($_POST['date_premiere_visite']) ? $_POST['date_premiere_visite'] : null,
                'date_offre' => !empty($_POST['date_offre']) ? $_POST['date_offre'] : null,
                'date_compromis' => !empty($_POST['date_compromis']) ? $_POST['date_compromis'] : null,
                'date_acte' => !empty($_POST['date_acte']) ? $_POST['date_acte'] : null,
                'notes' => trim((string) ($_POST['notes'] ?? '')),
            ];

            $model = new Achat();

            if ($id > 0) {
                $model->update($id, $data);
            } else {
                $id = $model->create($data);
            }

            header('Location: /admin/achats');
            exit;
        } catch (\Throwable $e) {
            $partenaires = (new Partenaire())->findActifs();

            View::renderAdmin('admin/achat-edit', [
                'page_title' => 'Achat',
                'admin_page' => 'achats',
                'breadcrumb' => 'Achat',
                'achat' => $_POST,
                'partenaires' => $partenaires,
                'statutLabels' => self::STATUT_LABELS,
                'errors' => [$e->getMessage()],
            ]);
        }
    }

    public function delete(): void
    {
        AuthController::requireAuth();
        AuthController::verifyCsrfToken();

        $id = isset($_POST['id']) ? (int) $_POST['id'] : 0;
        if ($id > 0) {
            $model = new Achat();
            $model->delete($id);
        }

        header('Location: /admin/achats');
        exit;
    }

    public function createTable(): void
    {
        AuthController::requireAuth();
        AuthController::verifyCsrfToken();

        try {
            $pdo = Database::connection();
            $pdo->exec("
                CREATE TABLE IF NOT EXISTS achats (
                    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                    website_id INT UNSIGNED NOT NULL,
                    lead_id INT UNSIGNED NULL,
                    nom_acheteur VARCHAR(180) NOT NULL,
                    email_acheteur VARCHAR(180) NULL,
                    telephone_acheteur VARCHAR(40) NULL,
                    adresse_bien VARCHAR(255) NULL,
                    ville VARCHAR(120) NOT NULL DEFAULT 'Aix-en-Provence',
                    quartier VARCHAR(120) NULL,
                    type_bien VARCHAR(80) NULL,
                    surface_m2 DECIMAL(8,2) NULL,
                    pieces INT UNSIGNED NULL,
                    prix_achat DECIMAL(12,2) NULL,
                    prix_estime DECIMAL(12,2) NULL,
                    type_financement ENUM('comptant', 'credit', 'mixte') NOT NULL DEFAULT 'credit',
                    montant_pret DECIMAL(12,2) NULL,
                    apport_personnel DECIMAL(12,2) NULL,
                    statut ENUM('prospect', 'recherche', 'visite', 'offre', 'negociation', 'compromis', 'financement', 'acte_signe', 'annule') NOT NULL DEFAULT 'prospect',
                    score ENUM('chaud', 'tiede', 'froid') NOT NULL DEFAULT 'froid',
                    partenaire_id INT UNSIGNED NULL,
                    commission_taux DECIMAL(5,2) NULL DEFAULT NULL,
                    commission_montant DECIMAL(12,2) NULL DEFAULT NULL,
                    date_premiere_visite DATE NULL DEFAULT NULL,
                    date_offre DATE NULL DEFAULT NULL,
                    date_compromis DATE NULL DEFAULT NULL,
                    date_acte DATE NULL DEFAULT NULL,
                    notes TEXT NULL,
                    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
                    updated_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                    INDEX idx_website_id (website_id),
                    INDEX idx_lead_id (lead_id),
                    INDEX idx_statut (statut),
                    INDEX idx_score (score),
                    INDEX idx_ville (ville),
                    INDEX idx_created_at (created_at),
                    INDEX idx_partenaire_id (partenaire_id)
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
            ");

            $_SESSION['achat_flash'] = ['type' => 'success', 'message' => 'Table "achats" creee avec succes ! La page est maintenant fonctionnelle.'];
        } catch (\Throwable $e) {
            $_SESSION['achat_flash'] = ['type' => 'error', 'message' => 'Erreur: ' . $e->getMessage()];
        }

        header('Location: /admin/achats');
        exit;
    }
}
