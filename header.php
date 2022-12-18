<link rel="stylesheet" href="css/header.css">
<link rel="stylesheet" href="css/general.css">
<!-- Google fonts -->
<link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

  <link href="https://fonts.googleapis.com/css2?family=Ubuntu:wght@300&display=swap" rel="stylesheet">

  <link href="https://fonts.googleapis.com/css2?family=Merriweather+Sans:wght@300&display=swap" rel="stylesheet">
<header>
    <nav>
        <a href="index.php">
            <img src="assets/logo.png">
        </a>
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