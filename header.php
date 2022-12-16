<link rel="stylesheet" href="css/header.css">
<header>
    <nav>
        <a href="index.php">Accueil</a>
        <?php
        if (!connecte()) {
           echo '<a href="connexion.php">Connexion</a>';
           echo '<a href="creation_compte.php">Création de compte</a>';
        } else {
            echo '<a href="deconnexion.php">Déconnexion</a>';
            echo '<a href="creation.php">Création</a>';
            echo '<p>|</p>';
            echo '<p>Bonjour ' . $_SESSION["identifiant"] . '</p>';
        }
        ?>
    </nav>
</header>