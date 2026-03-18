<?php
// www/model/UserModel.php
 
// On charge la classe DatabaseConnection
require_once __DIR__ . '/../lib/database.php';
 
use Application\Lib\Database\DatabaseConnection;
 
class UserModel
{
    private \PDO $pdo;
 
    public function __construct()
    {
        // On crée une connexion via la classe qui existe déjà dans lib/database.php
        $db = new DatabaseConnection();
        $this->pdo = $db->getConnection();
    }
 
    // ------------------------------------------------------
    // Cherche un utilisateur par son email (pour la connexion)
    // ------------------------------------------------------
    public function trouverParEmail(string $email): array|false
    {
        $req = $this->pdo->prepare('
            SELECT users.*, roles.nom AS role
            FROM users
            JOIN roles ON roles.id = users.role_id
            WHERE users.email = ?
        ');
        $req->execute([$email]);
        return $req->fetch(); // retourne un tableau ou false
    }
 
    // ------------------------------------------------------
    // Vérifie si un email existe déjà (pour l'inscription)
    // ------------------------------------------------------
    public function emailExiste(string $email): bool
    {
        $req = $this->pdo->prepare('SELECT id FROM users WHERE email = ?');
        $req->execute([$email]);
        return $req->fetch() !== false;
    }
 
    // ------------------------------------------------------
    // Vérifie si un username existe déjà (pour l'inscription)
    // ------------------------------------------------------
    public function usernameExiste(string $username): bool
    {
        $req = $this->pdo->prepare('SELECT id FROM users WHERE username = ?');
        $req->execute([$username]);
        return $req->fetch() !== false;
    }
 
    // ------------------------------------------------------
    // Crée un nouvel utilisateur dans la BDD
    // ------------------------------------------------------
    public function creer(string $username, string $email, string $motDePasse, string $token): void
    {
        // IMPORTANT : on ne stocke JAMAIS le mot de passe en clair !
        $hash = password_hash($motDePasse, PASSWORD_DEFAULT); 
        $req = $this->pdo->prepare('
           INSERT INTO users (username, email, password, role_id, is_active, activation_token)
           VALUES (?, ?, ?, 3, 0, ?)
        ');
        // role_id = 3 (visiteur), is_active  = 0 (pas encore activé)
        $req->execute([$username, $email, $hash, $token]);
    }
 
    // ------------------------------------------------------
    // Active un compte avec le token reçu par mail
    // ------------------------------------------------------
    public function activer(string $token): bool
    {
        $req = $this->pdo->prepare('
            UPDATE users SET is_active = 1, activation_token = NULL WHERE activation_token = ?
        ');
        $req->execute([$token]);
        return $req->rowCount() > 0; // true = un compte a bien été activé
    }
}