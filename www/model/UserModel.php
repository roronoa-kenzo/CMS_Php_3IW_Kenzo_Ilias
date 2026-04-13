<?php
// www/model/UserModel.php

// On charge la classe DatabaseConnection
require_once __DIR__ . '/../lib/database.php';

use Application\Lib\Database\DatabaseConnection;

class UserModel
{
    // Une seule propriété pour la BDD
    private \PDO $pdo;

    public function __construct()
        {
            // j'utilise la methode singleton pour la connexion à la BDD
            $this->pdo = DatabaseConnection::getInstance()->getConnection();
        }
    // On Cherche un utilisateur par son email (pour la connexion / reset)
    public function trouverParEmail(string $email): ?array
    {
        $sql = "SELECT * FROM users WHERE email = :email LIMIT 1";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['email' => $email]);
        $user = $stmt->fetch(\PDO::FETCH_ASSOC);
        return $user ?: null;
    }

    //je stocke un code secret pour reset le mot de passe
    public function definirResetToken(int $userId, string $token, string $expiresAt): void
    {
        $sql = "UPDATE users 
                SET reset_token = :token,
                    reset_token_expires_at = :expires_at
                WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            'token'      => $token,
            'expires_at' => $expiresAt,
            'id'         => $userId,
        ]);
    }

    // Je trouve un utilisateur avec un token de reset
    public function trouverParResetToken(string $token): ?array
    {
        $sql = "SELECT * FROM users WHERE reset_token = :token LIMIT 1";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['token' => $token]);
        $user = $stmt->fetch(\PDO::FETCH_ASSOC);
        return $user ?: null;
    }

    // On met à jour le mot de passe et supprime le token
    public function mettreAJourMotDePasseEtViderToken(int $userId, string $passwordHash): void
    {
        $sql = "UPDATE users
                SET password = :password,
                    reset_token = NULL,
                    reset_token_expires_at = NULL
                WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            'password' => $passwordHash,
            'id'       => $userId,
        ]);
    }

    // On verifie si un email existe déjà (pour l'inscription)
    public function emailExiste(string $email): bool
    {
        $req = $this->pdo->prepare('SELECT id FROM users WHERE email = ?');
        $req->execute([$email]);
        return $req->fetch() !== false;
    }

    // On verifie si un username existe déjà (pour l'inscription)
    public function usernameExiste(string $username): bool
    {
        $req = $this->pdo->prepare('SELECT id FROM users WHERE username = ?');
        $req->execute([$username]);
        return $req->fetch() !== false;
    }
    // On crée un nouvel utilisateur dans la BDD
    public function creer(string $username, string $email, string $motDePasse, string $token): void
    {
        // on ne stocke JAMAIS le mot de passe en clair dans la BDD, on le hash avec password_hash()
        $hash = password_hash($motDePasse, PASSWORD_DEFAULT);

        $req = $this->pdo->prepare('
           INSERT INTO users (username, email, password, role_id, is_active, activation_token)
           VALUES (?, ?, ?, 3, 0, ?)
        ');
        // role_id = 3 (visiteur), is_active = 0 (pas encore activé)
        $req->execute([$username, $email, $hash, $token]);
    }

    // Active un compte avec le token reçu par mail
    public function activer(string $token): bool
    {
        $req = $this->pdo->prepare('
            UPDATE users
            SET is_active = 1, activation_token = NULL
            WHERE activation_token = ?
        ');
        $req->execute([$token]);
        return $req->rowCount() > 0; // true = la notre compte a été activé, false = token invalide
    }
}