
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Inscription</title>
</head>
<body>
 
<h1>Créer un compte</h1>
 
<?php
// Démarre la session si besoin (pour lire les messages)
if (session_status() === PHP_SESSION_NONE) session_start();
 
// Affiche les erreurs s'il y en a
if (!empty($_SESSION['erreurs'])): ?>
    <div style="color:red; border:1px solid red; padding:10px;">
        <ul>
            <?php foreach ($_SESSION['erreurs'] as $e): ?>
                <li><?= htmlspecialchars($e) ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php unset($_SESSION['erreurs']); endif; ?>
 
<!--
    action="/inscription-traitement" → route POST dans routes.yml
    Le formulaire envoie les données au controller auth → méthode inscription()
-->
<form method="POST" action="/inscription-traitement">
 
    <label>Nom d'utilisateur</label><br>
    <input type="text" name="username"
           value="<?= htmlspecialchars($_SESSION['ancien']['username'] ?? '') ?>">
    <br><br>
 
    <label>Email</label><br>
    <input type="email" name="email"
           value="<?= htmlspecialchars($_SESSION['ancien']['email'] ?? '') ?>">
    <br><br>
 
    <label>Mot de passe (min. 6 caractères)</label><br>
    <input type="password" name="password">
    <br><br>
 
    <label>Confirmer le mot de passe</label><br>
    <input type="password" name="password_confirm">
    <br><br>
 
    <button type="submit">S'inscrire</button>
 
</form>
 
<?php unset($_SESSION['ancien']); ?>
 
<p>Déjà un compte ? <a href="/connexion">Se connecter</a></p>
 
</body>
</html>