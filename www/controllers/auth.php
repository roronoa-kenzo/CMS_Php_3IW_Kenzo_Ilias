<?php
// www/controllers/auth.php
// La session est déjà démarrée dans index.php, pas besoin de session_start() ici

require_once __DIR__ . '/Controller.php';
require_once __DIR__ . '/../model/UserModel.php';
require_once __DIR__ . '/../lib/MailService.php';

class Auth extends Controller
{
    private UserModel $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    // INSCRIPTION — affiche le formulaire
    public function inscriptionForm(): void
    {
        if (isset($_SESSION['user'])) {
            header('Location: /');
            exit;
        }
        $this->render('auth/inscription');
    }

    // INSCRIPTION — traite le formulaire
    public function inscription(): void
    {
        $username  = trim($_POST['username']       ?? '');
        $email     = trim($_POST['email']          ?? '');
        $password  = $_POST['password']            ?? '';
        $password2 = $_POST['password_confirm']    ?? '';

        $erreurs = [];

        if (empty($username)) {
            $erreurs[] = "Le nom d'utilisateur est obligatoire.";
        }
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $erreurs[] = "L'adresse email n'est pas valide.";
        }
        if (strlen($password) < 6) {
            $erreurs[] = "Le mot de passe doit faire au moins 6 caractères.";
        }
        if ($password !== $password2) {
            $erreurs[] = "Les mots de passe ne correspondent pas.";
        }
        if ($this->userModel->emailExiste($email)) {
            $erreurs[] = "Cet email est déjà utilisé.";
        }
        if ($this->userModel->usernameExiste($username)) {
            $erreurs[] = "Ce nom d'utilisateur est déjà pris.";
        }

        if (!empty($erreurs)) {
            $_SESSION['erreurs'] = $erreurs;
            $_SESSION['ancien']  = ['username' => $username, 'email' => $email];
            header('Location: /inscription');
            exit;
        }

        $token = bin2hex(random_bytes(16));
        $this->userModel->creer($username, $email, $password, $token);

        $mailEnvoye = MailService::envoyerActivation($email, $username, $token);

        if ($mailEnvoye) {
            $_SESSION['succes'] = "Compte créé ! Vérifiez vos mails. (Mailpit : http://localhost:8025)";
        } else {
            $_SESSION['erreur'] = "Compte créé mais l'envoi du mail a échoué. Token : $token";
        }

        header('Location: /connexion');
        exit;
    }

    // ACTIVATION — quand l'utilisateur clique sur le lien dans le mail
    public function activation(): void
    {
        $token = $_GET['token'] ?? '';

        if ($this->userModel->activer($token)) {
            $_SESSION['succes'] = "Compte activé ! Vous pouvez vous connecter.";
        } else {
            $_SESSION['erreur'] = "Lien d'activation invalide ou déjà utilisé.";
        }

        header('Location: /connexion');
        exit;
    }

    // CONNEXION — affiche le formulaire
    public function connexionForm(): void
    {
        if (isset($_SESSION['user'])) {
            header('Location: /');
            exit;
        }
        $this->render('auth/connexion');
    }

    // CONNEXION — traite le formulaire
    public function connexion(): void
    {
        $email    = trim($_POST['email']    ?? '');
        $password = $_POST['password']      ?? '';

        $user = $this->userModel->trouverParEmail($email);

        if (!$user || !password_verify($password, $user['password'])) {
            $_SESSION['erreur'] = "Email ou mot de passe incorrect.";
            header('Location: /connexion');
            exit;
        }

        if (!$user['is_active']) {
            $_SESSION['erreur'] = "Votre compte n'est pas encore activé. Vérifiez vos mails.";
            header('Location: /connexion');
            exit;
        }

        session_regenerate_id(true);

        $_SESSION['user'] = [
            'id'       => $user['id'],
            'username' => $user['username'],
            'email'    => $user['email'],
            'role'     => $user['role'],
        ];

        $_SESSION['succes'] = "Bienvenue " . htmlspecialchars($user['username']) . " !";
        header('Location: /');
        exit;
    }

    // DÉCONNEXION
    public function deconnexion(): void
    {
        session_unset();
        session_destroy();
        header('Location: /connexion');
        exit;
    }
}