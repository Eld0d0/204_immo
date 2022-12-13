<?php session_start(); ?>
<!doctype html>
<html lang="fr">
<head>
  <meta charset="utf-8">
  <title>Connexion</title>
  <link rel="stylesheet" href="css/connexion.css">
</head>
<!-- On ajoute le header -->
<?php include 'header.php';?>
<body>

  <?php

    /* On lance notre requête afin de récupérer nos données de la BDD */
    $bdd = new PDO('mysql:host=localhost:3306;dbname=agence_immobiliere;charset=utf8', 'root', 'root');
    $requete = $bdd->query('SELECT * FROM `clients`');
    $clients = $requete->fetchAll();

    /* Fonctions qui permettent de vérifier qu'un utilisateur est connecté / se connecter / mauvais identifiants & mdp */
    
    /*
    Fonction connecte
		Permet de vérifier qu'un utilisateur est connecté
		à partir de la SESSION
    */

    function connecte(){
      if($_SESSION
          && count($_SESSION)
              && array_key_exists('identifiant', $_SESSION)
                  && !empty($_SESSION['identifiant'])){
          return true;
        }
        else {
          return false;
        }
    }

    /*
      Fonction "connexion"
      Connecte un utilisateur selon les paramètres transmis
      et les stock dans la SESSION
    */

    function connexion($identifiant, $motdepasse){
      $_SESSION['identifiant'] = $identifiant;
      $_SESSION['motdepasse'] = $motdepasse;
    }

    /*
    Fonction "erreur"
    Annonce que l'identifiant ou le mot
    de passe est incorrecte
    */

    function erreur($msg = ""){
      if(!array_key_exists('msg', $_SESSION)){
        $_SESSION['msg'] = "";
      }
  
      $_SESSION['msg'] .= $msg . " ";
    }

    if($_POST 
        && count($_POST) 
            && array_key_exists('identifiant', $_POST) && array_key_exists('motdepasse', $_POST)
                && !empty($_POST['identifiant']) && !empty($_POST['motdepasse'])) {
            // Mauvais identifiant
            if($_POST['identifiant'] !== "Administrateur"){
                erreur("Le login est incorrect.");
            // Mauvais mot de passe
            }else if($_POST['motdepasse'] !== "83CCutv8"){
                erreur("Le mot de passe est incorrect.");
            }else{
                // Des données issues d'un formulaire de connexion sont transmises
                connexion($_POST['login'], $_POST['mdp']);
            }
    }

  ?>

  <?php if(!connecte()) : /* Si l'utilisateur n'est pas connecté, on affiche le formulaire */ ?>
      <form method="POST">
        <div class="row">
          <div class="col">
            <div class="form-group">
              <p class="text"> Identifiant </p>
              <input type="id" class="form-control" placeholder="Votre identifiant..." name="login" required>
            </div>
          </div>
          <div class="col">
            <div class="form-group">
              <p class="text"> Mot de passe </p>
              <input type="password" class="form-control" placeholder="Votre mot de passe..." name="mdp" required>
            </div>
          </div>
            <div class="col">
              <br>
              <button type="submit" class="btn btn-primary mb-2">Se connecter</button>
            </div>
        </div>
      </form>

  <?php else: /* Sinon, s'il est déjà connecté ou vient de se connecter, on affiche ce message (PLACEHOLDER, CE SERA À REMPLACER) */ ?>
    <p>Bienvenue <?php echo $_SESSION['identifiant']; ?>, votre mot de passe est <?php echo $_SESSION['motdepasse'];?>.</p>
  <?php endif;
  $requete->closeCursor();
  ?>

</body>
<!-- On ajoute le footer -->
<?php include 'footer.php';?>
</html>