<h1>Mot de passe oublié</h1>

<?php if (!empty($_SESSION['erreur'])): ?>
    <p style="color:red;"><?= htmlspecialchars($_SESSION['erreur']) ?></p>
    <?php unset($_SESSION['erreur']); ?>
<?php endif; ?>

<form action="/mot-de-passe-oublie-traitement" method="post">
    <label for="email">Votre email :</label>
    <input type="email" name="email" id="email" required>

    <button type="submit">Envoyer le lien</button>
</form>