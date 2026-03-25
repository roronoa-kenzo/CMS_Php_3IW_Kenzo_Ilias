<h1>Nouveau mot de passe</h1>

<?php if (!empty($_SESSION['erreur'])): ?>
    <p style="color:red;"><?= htmlspecialchars($_SESSION['erreur']) ?></p>
    <?php unset($_SESSION['erreur']); ?>
<?php endif; ?>

<form action="/reinitialiser-mot-de-passe-traitement" method="post">
    <input type="hidden" name="token" value="<?= htmlspecialchars($token) ?>">

    <label for="password">Nouveau mot de passe :</label>
    <input type="password" name="password" id="password" required>

    <label for="password_confirm">Confirmer le mot de passe :</label>
    <input type="password" name="password_confirm" id="password_confirm" required>

    <button type="submit">Changer le mot de passe</button>
</form>