<?php session_start(); ?>
<link rel="stylesheet" href="css/header.css">
<?php include 'functions.php'; ?>
<header>
    <nav>
        <a href="index.php">Accueil</a>
        <?php
        if (!connecte()) {
        ?>
            <a href="connexion.php">Connexion</a>
            <a href="creation_compte.php">Création de compte</a>
        <?php } else {
            echo '<a href="deconnexion.php">Déconnexion</a>';
            echo '<a href="creation.php">Création</a>';
            echo '<p>Bonjour ' . $_SESSION["identifiant"] . '</p>';
        }
        ?>
    </nav>
</header>