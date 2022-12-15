<?php session_start(); ?>
<!doctype html>
<html lang="fr">

<head>
  <meta charset="utf-8">
  <title>Connexion</title>
  <link rel="stylesheet" href="css/connexion.css">
  <link rel="stylesheet" href="css/normalize.css">
</head>
<?php include 'functions.php'; ?>
<!-- On ajoute le header -->
<?php include 'header.php'; ?>

<body>

  <?php

  /* Fonctions qui permettent de vérifier qu'un utilisateur est connecté / se connecter / mauvais identifiants & mdp */

  if (
    array_key_exists('identifiant', $_POST) && array_key_exists('motdepasse', $_POST)
    && !empty($_POST['identifiant']) && !empty($_POST['motdepasse'])
  ) {
    /* On lance notre requête afin de récupérer nos données de la BDD */
    $bdd = new PDO('mysql:host=localhost:3306;dbname=agence_immobiliere;charset=utf8', 'agence_immobiliere', 'groupe01');
    // On prépare une requête avec des arguments en ?
    $requete = $bdd->prepare('SELECT * FROM `clients` WHERE `identifiant` = ? AND `motdepasse` = ?');
    // On fournit une liste d'argument pour les ? 
    if ($requete->execute([$_POST['identifiant'], $_POST['motdepasse']])) {
      // On récupère le resultat (variable $res) de la requête. FETCH_ASSOC met le résultat sous forme de tableau associatif
      $res = $requete->fetch(PDO::FETCH_ASSOC);
      // Si le resultat est vide, alors on considère que aucun utilisateur n'existe dans la base de données
      if (empty($res)) {
  ?>
        <p class="erreur"> L'identifiant ou le mot de passe est incorrect. </p>
  <?php
      } else { /* Sinon, on se connecte, car un utilisateur a été trouvé dans la base de données */
        connexion($_POST['identifiant']);
      }
    }
  }

  ?>

  <?php if (!connecte()) : /* Si l'utilisateur n'est pas connecté, on affiche le formulaire */ ?>
    <form method="POST">
      <div class="row">
        <div class="col">
          <div class="form-group">
            <p class="text"> Identifiant </p>
            <input type="id" class="form-control" placeholder="Votre identifiant..." name="identifiant" required>
          </div>
        </div>
        <div class="col">
          <div class="form-group">
            <p class="text"> Mot de passe </p>
            <input type="password" class="form-control" placeholder="Votre mot de passe..." name="motdepasse" required>
          </div>
        </div>
        <div class="col">
          <div class="bouton_container">
            <button type="submit" class="bouton_form">Se connecter</button>
          </div>
          <div class="bouton_container">
            <button onclick="location.href='creation_compte.php'" class="bouton_form"> Page d'inscription </button>
          </div>
        </div>
      </div>
    </form>


  <?php else : /* Sinon, s'il est déjà connecté ou vient de se connecter, on affiche ce message (L'affichage est un placeholder) */ ?>
    <p>Bienvenue <?php echo $_SESSION['identifiant']; ?>.</p>
  <?php endif;
  ?>

</body>
<!-- On ajoute le footer -->
<?php include 'footer.php'; ?>

</html>