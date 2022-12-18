<?php session_start(); ?>
<!doctype html>
<html lang="fr">

<head>
  <meta charset="utf-8">
  <title>Création de compte</title>
  <link rel="stylesheet" href="css/creation_compte.css">
  <link rel="stylesheet" href="css/normalize.css">

  <!-- Google fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

  <link href="https://fonts.googleapis.com/css2?family=Ubuntu:wght@300&display=swap" rel="stylesheet">

  <link href="https://fonts.googleapis.com/css2?family=Merriweather+Sans:wght@300&display=swap" rel="stylesheet">
</head>
<?php include 'functions.php'; ?>
<!-- On ajoute le header -->
<?php include 'header.php'; ?>

<body>

  <?php
  $bdd = new PDO('mysql:host=localhost:3306;dbname=agence_immobiliere;charset=utf8', 'agence_immobiliere', 'groupe01');
  ?>

  <?php if (!connecte()) { ?>

    <form method="POST">
      <div class="row">
        <div class="col">
          <div class="form-group">
            <p class="text">Choisissez votre identifiant</p>
            <input type="text" class="form-control" placeholder="Identifiant" name="identifiant" required>
          </div>
        </div>
        <div class="col">
          <div class="form-group">
            <p class="text">Choisissez un mot de passe</p>
            <em class="text">Doit contenir une majuscule, une minuscule, un chiffre et doit faire au minimum 8 caractères.</em>
            <input type="password" class="form-control" placeholder="Mot de passe" name="motdepasse" required>
          </div>
        </div>
        <div class="col">
          <div class="bouton_container">
            <button type="submit" class="bouton_form">Créer mon compte</button>
          </div>
          <div class="bouton_container">
            <button onclick="location.href='connexion.php'" class="bouton_form"> Page de connexion </button>
          </div>
        </div>
      </div>
    </form>

  <?php } else {
    header('Location: connexion.php');
  } ?>

  <?php
  if (
    array_key_exists('identifiant', $_POST) && array_key_exists('motdepasse', $_POST)
    && !empty($_POST['identifiant']) && !empty($_POST['motdepasse'])
  ) {

    /* Les données entré ici pouvant être affiché sur une page,
    il faut également sécuriser les données face à une potentiel faille XSS */
    $login = xss_validator($_POST['identifiant']);
    $mdp = xss_validator($_POST['motdepasse']);

    if (
      preg_match('/^\S*(?=\S{8,})(?=\S*[a-z])(?=\S*[A-Z])(?=\S*[\d])\S*$/i', $_POST["motdepasse"])
    ) {
      /* On lance notre requête afin de récupérer nos données de la BDD */
      $bdd_id = new PDO('mysql:host=localhost:3306;dbname=agence_immobiliere;charset=utf8', 'agence_immobiliere', 'groupe01');
      // On prépare une requête avec des arguments en ?
      $requete_id = $bdd_id->prepare('SELECT * FROM `clients` WHERE `identifiant` = ?');
      // On fournit une liste d'argument pour les ? 
      if ($requete_id->execute([$login])) {
        // On récupère le resultat (variable $res) de la requête. FETCH_ASSOC met le résultat sous forme de tableau associatif
        $res = $requete_id->fetch(PDO::FETCH_ASSOC);
        /* Si le resultat est vide, alors on considère que aucun utilisateur n'existe dans
      la base de données avec ce pseudo on peut donc créer notre compte */
        $requete_id->closeCursor();
        if (empty($res)) {
          $requete = $bdd->prepare('INSERT INTO clients (identifiant, motdepasse) VALUES (:identifiant, :motdepasse)');
          $requete->execute(array('identifiant' => $login, 'motdepasse' => $mdp));
          $requete->closeCursor();

          /* Une fois le compte créé on connecte automatiquement l'utilisateur */
          connexion($login);
          /* Et on le redirige vers la page de connexion qui lui affichera un message de bienvenu */
          header('Location: connexion.php');
        } else {
          echo "<p style='text-align: center; color: red;'>Identifiant déjà utilisé essayez : " . $login . "01</p>";
        }
      }
    } else {
      echo "<p style='text-align: center; color: red;'>Mot de passe non valide</p>";
    }
  }
  ?>

</body>
<!-- On ajoute le footer -->
<?php include 'footer.php'; ?>

</html>