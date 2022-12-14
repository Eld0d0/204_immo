<?php session_start(); ?>
<!doctype html>
<html lang="fr">

<head>
  <meta charset="utf-8">
  <title>Connexion</title>
  <link rel="stylesheet" href="css/connexion.css">
  <link rel="stylesheet" href="css/normalize.css">
</head>
<!-- On ajoute le header -->
<?php include 'header.php'; ?> 

<body>

  <?php

  /* Fonctions qui permettent de vérifier qu'un utilisateur est connecté / se connecter / mauvais identifiants & mdp */

  /*
    Fonction connecte"
        Elle vérifie qu'un utilisateur
        est connecté
    */

  function connecte()
  {
    if (
      $_SESSION
      && count($_SESSION)
      && array_key_exists('identifiant', $_SESSION)
      && !empty($_SESSION['identifiant'])
    ) {
      return true;
    } else {
      return false;
    }
  }

  /*
      Fonction "connexion"
      Elle connecte un utilisateur selon les paramètres transmis
      et les stock dans la SESSION
    */

  function connexion($identifiant, $motdepasse)
  {
    $_SESSION['identifiant'] = $identifiant;
    $_SESSION['motdepasse'] = $motdepasse;
  }

  if (array_key_exists('identifiant', $_POST) && array_key_exists('motdepasse', $_POST)
    && !empty($_POST['identifiant']) && !empty($_POST['motdepasse'])
  ) { ?>


   <?php
    /* On lance notre requête afin de récupérer nos données de la BDD */
    $bdd = new PDO('mysql:host=localhost:3306;dbname=agence_immobiliere;charset=utf8', 'agence_immobiliere', 'groupe01');
    // On prépare une requête avec des arguments en ?
    $requete = $bdd->prepare('SELECT * FROM `clients` WHERE `identifiant` = ? AND `motdepasse` = ?');
    // On fournit une liste d'argument pour les ? 
    if($requete->execute([$_POST['identifiant'], $_POST['motdepasse']])) 
    {
        // On récupère le resultat (variable $res) de la requête. FETCH_ASSOC met le résultat sous forme de tableau associatif
        $res = $requete->fetch(PDO::FETCH_ASSOC);
        // Si le resultat est vide, alors on considère que aucun utilisateur n'existe dans la base de données
        if(empty($res))
        {
            ?><p class="erreur"> Le login ou le mot de passe est incorrect. </p><?php
        } else { /* Sinon, on se connecte, car un utilisateur a été trouvé dans la base de données */
            connexion($_POST['identifiant'], $_POST['motdepasse']);
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
          <br>
          <div class="bouton_container">
            <button type="submit" class="bouton_form">Se connecter</button>
          </div>
        </div>
      </div>
    </form>
    

  <?php else : /* Sinon, s'il est déjà connecté ou vient de se connecter, on affiche ce message (L'affichage est un placeholder) */ ?>
    <p>Bienvenue <?php echo $_SESSION['identifiant']; ?>, votre mot de passe est <?php echo $_SESSION['motdepasse']; ?>.</p>
    <a href="deconnexion.php">Deconnexion</a>
  <?php endif;
  ?>

</body>
<!-- On ajoute le footer -->
<?php include 'footer.php'; ?>

</html>