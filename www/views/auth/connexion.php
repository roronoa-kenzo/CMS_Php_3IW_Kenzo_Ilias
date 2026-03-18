
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Connexion</title>
</head>
<body>
 
<h1>Connexion</h1>
 
<?php
if (session_status() === PHP_SESSION_NONE) session_start();
 
// Affiche l'erreur s'il y en a une
if (!empty($_SESSION['erreur'])): ?>
    <div style="color:red; border:1px solid red; padding:10px;">
        <?= htmlspecialchars($_SESSION['erreur']) ?>
    </div>
<?php unset($_SESSION['erreur']); endif; ?>
 
<!-- Affiche le message de succès (ex: après inscription) -->
<?php if (!empty($_SESSION['succes'])): ?>
    <div style="color:green; border:1px solid green; padding:10px;">
        <?= $_SESSION['succes'] /* contient du HTML (lien activation) */ ?>
    </div>
<?php unset($_SESSION['succes']); endif; ?>
 
<!--
    action="/connexion-traitement" → route POST dans routes.yml
    Le formulaire envoie les données au controller auth → méthode connexion()
-->
<form method="POST" action="/connexion-traitement">
 
    <label>Email</label><br>
    <input type="email" name="email" autofocus>
    <br><br>
 
    <label>Mot de passe</label><br>
    <input type="password" name="password">
    <br><br>
 
    <button type="submit">Se connecter</button>
 
</form>
 
<p>Pas encore de compte ? <a href="/inscription">S'inscrire</a></p>
 
</body>
</html>