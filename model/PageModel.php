<?php
// www/model/PageModel.php
require_once __DIR__ . '/../lib/database.php';
use Application\Lib\Database\DatabaseConnection;

class PageModel
{
    private \PDO $pdo;

    public function __construct()
    {
        $this->pdo = DatabaseConnection::getInstance()->getConnection();
    }
    
    // Retourne TOUTES les pages (pour la liste backoffice)
    public function toutesLesPages(): array
    {
        $req = $this->pdo->query('
            SELECT pages.*, users.username AS auteur
            FROM pages
            JOIN users ON users.id = pages.auteur_id
            ORDER BY pages.created_at DESC
        ');
        return $req->fetchAll();
    }
    // Retourne uniquement les pages PUBLIÉES (pour le frontoffice)
    public function pagesPubliees(): array
    {
        $req = $this->pdo->query('
            SELECT pages.*, users.username AS auteur
            FROM pages
            JOIN users ON users.id = pages.auteur_id
            WHERE pages.statut = "publiee"
            ORDER BY pages.created_at DESC
        ');
        return $req->fetchAll();
    }

    // Trouve une page par son ID (pour modifier/supprimer)
    public function trouverParId(int $id): array|false
    {
        $req = $this->pdo->prepare('
            SELECT pages.*, users.username AS auteur
            FROM pages
            JOIN users ON users.id = pages.auteur_id
            WHERE pages.id = ?
        ');
        $req->execute([$id]);
        return $req->fetch();
    }
    // Trouve une page par son slug (pour le frontoffice)
    // ex: /page/mon-article → slug = "mon-article"
    public function trouverParSlug(string $slug): array|false
    {
        $req = $this->pdo->prepare('
            SELECT pages.*, users.username AS auteur
            FROM pages
            JOIN users ON users.id = pages.auteur_id
            WHERE pages.slug = ? AND pages.statut = "publiee"
        ');
        $req->execute([$slug]);
        return $req->fetch();
    }

    // On crée une nouvelle page
    public function creer(string $titre, string $contenu, string $slug, int $auteurId): void
    {
        $req = $this->pdo->prepare('
            INSERT INTO pages (titre, contenu, slug, statut, auteur_id)
            VALUES (?, ?, ?, "brouillon", ?)
        ');
        // statut = brouillon par défaut, l'admin publie manuellement
        $req->execute([$titre, $contenu, $slug, $auteurId]);
    }

    // Modifie une page existante
    public function modifier(int $id, string $titre, string $contenu, string $slug): void
    {
        $req = $this->pdo->prepare('
            UPDATE pages SET titre = ?, contenu = ?, slug = ? WHERE id = ?
        ');
        $req->execute([$titre, $contenu, $slug, $id]);
    }

    // Supprime une page
    public function supprimer(int $id): void
    {
        $req = $this->pdo->prepare('DELETE FROM pages WHERE id = ?');
        $req->execute([$id]);
    }

    // On change le statut d'une page (publiée ↔ brouillon)
    public function changerStatut(int $id): void
    {
        // Si c'est "publiee" → passe à "brouillon" et inversement
        $req = $this->pdo->prepare('
            UPDATE pages
            SET statut = IF(statut = "publiee", "brouillon", "publiee")
            WHERE id = ?
        ');
        $req->execute([$id]);
    }

    // On verifie si un slug existe déjà (pour éviter les doublons)
    public function slugExiste(string $slug, ?int $exclureId = null): bool
    {
        if ($exclureId) {
            $req = $this->pdo->prepare('SELECT id FROM pages WHERE slug = ? AND id != ?');
            $req->execute([$slug, $exclureId]);
        } else {
            $req = $this->pdo->prepare('SELECT id FROM pages WHERE slug = ?');
            $req->execute([$slug]);
        }
        return $req->fetch() !== false;
    }
}