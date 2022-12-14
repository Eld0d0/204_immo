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
<!-- On ajoute le header -->
<?php include 'header.php'; ?>

<body>

<?php
  $bdd = new PDO ('mysql:host=localhost:3306;dbname=agence_immobiliere;charset=utf8','agence_immobiliere','groupe01');
  function isConnecte(){
		if($_SESSION && count($_SESSION) && array_key_exists('login', $_SESSION) && !empty($_SESSION['login'])){
			return true;
		}else{
			return false;
		}
	}
?>

<?php if(!isConnecte()) { ?>
  
<form method="POST">
  <div class="row">
    <div class="col">
      <div class="form-group">
        <p class="text"> Choisissez votre identifiant </p>
        <input type="text" class="form-control" placeholder="Identifiant..." name="identifiant" required>
      </div>
    </div>
    <div class="col">
      <div class="form-group">
        <p class="text"> Choisissez un mot de passe </p>
        <input type="password" class="form-control" placeholder="Mot de passe..." name="motdepasse" required>
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

<?php } ?>

<?php
if(isset($_POST) && count($_POST)){
  $login = $_POST['identifiant'];
  $mdp = $_POST['motdepasse'];

  $requete = $bdd->prepare('INSERT INTO clients (identifiant, motdepasse) VALUES (:identifiant, :motdepasse)');
  $requete->execute(array(
    'identifiant' => $login,
    'motdepasse' => $mdp
  ));
  $requete->closeCursor();
}
?>

</body>
<!-- On ajoute le footer -->
<?php include 'footer.php'; ?>
<script src="js/index.js"></script>

</html>