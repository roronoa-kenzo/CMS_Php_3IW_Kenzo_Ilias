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
            'role_id'  => $user['role_id'],
            'role'     => $this->getRoleName((int)$user['role_id']),
        ];
        $_SESSION['succes'] = "Bienvenue " . htmlspecialchars($user['username']) . " !";
        header('Location: /');
        exit;
    }

    // 1) Affiche le formulaire "Mot de passe oublié"
    public function motDePasseOublieForm(): void
    {
        // Si déjà connecté, on n'a pas besoin de ça
        if (isset($_SESSION['user'])) {
            header('Location: /');
            exit;
        }

        $this->render('auth/mot_de_passe_oublie');
    }

    // 2) Traite le formulaire "Mot de passe oublié"
    public function motDePasseOublie(): void
    {
        $email = trim($_POST['email'] ?? '');

        if ($email === '') {
            $_SESSION['erreur'] = "Veuillez entrer votre adresse email.";
            header('Location: /mot-de-passe-oublie');
            exit;
        }

        // On cherche l'utilisateur
        $user = $this->userModel->trouverParEmail($email);

        // Pour rester simple (et un peu sécurisé) :
        // on affiche toujours le même message, même si l'email n'existe pas.
        if ($user) {
            // On crée un token aléatoire
            $token = bin2hex(random_bytes(32));
            // Expiration dans 1 heure
            $expiresAt = date('Y-m-d H:i:s', time() + 3600);

            // On enregistre ça en base
            $this->userModel->definirResetToken($user['id'], $token, $expiresAt);

            // Lien de réinitialisation (adapter le domaine si besoin)
            $resetLink = APP_URL . '/reinitialiser-mot-de-passe?token=' . urlencode($token);
            // Envoi du mail grâce à ton MailService
            MailService::envoyerResetMotDePasse($user['email'], $user['username'], $resetLink);}

        $_SESSION['succes'] = "Si un compte existe avec cet email, un lien a été envoyé.";
        // ➜ on te renvoie vers la page de connexion comme demandé
        header('Location: /connexion');
        exit;
    }

    // 3) Affiche le formulaire pour choisir un nouveau mot de passe
    public function resetMotDePasseForm(): void
    {
        $token = $_GET['token'] ?? '';

        if ($token === '') {
            $_SESSION['erreur'] = "Lien invalide.";
            header('Location: /connexion');
            exit;
        }

        $user = $this->userModel->trouverParResetToken($token);

        // On vérifie que le token existe et n'est pas expiré
        if (!$user || $user['reset_token_expires_at'] < date('Y-m-d H:i:s')) {
            $_SESSION['erreur'] = "Lien expiré ou invalide.";
            header('Location: /connexion');
            exit;
        }

        // On passe le token à la vue
        $this->render('auth/reset_mot_de_passe', ['token' => $token]);
    }

    // 4) Traite le formulaire "nouveau mot de passe"
    public function resetMotDePasse(): void
    {
        $token           = $_POST['token'] ?? '';
        $password        = $_POST['password'] ?? '';
        $passwordConfirm = $_POST['password_confirm'] ?? '';

        if ($token === '') {
            $_SESSION['erreur'] = "Token manquant.";
            header('Location: /connexion');
            exit;
        }

        if ($password === '' || $password !== $passwordConfirm) {
            $_SESSION['erreur'] = "Les mots de passe ne correspondent pas.";
            header('Location: /reinitialiser-mot-de-passe?token=' . urlencode($token));
            exit;
        }

        $user = $this->userModel->trouverParResetToken($token);

        if (!$user || $user['reset_token_expires_at'] < date('Y-m-d H:i:s')) {
            $_SESSION['erreur'] = "Lien expiré ou invalide.";
            header('Location: /connexion');
            exit;
        }

        // On chiffre le nouveau mot de passe
        $hash = password_hash($password, PASSWORD_DEFAULT);

        // On met à jour et on enlève le token
        $this->userModel->mettreAJourMotDePasseEtViderToken($user['id'], $hash);

        $_SESSION['succes'] = "Mot de passe changé, vous pouvez vous connecter.";
        header('Location: /connexion');
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