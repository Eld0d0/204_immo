<?php session_start(); ?>
<!doctype html>
<html lang="fr">

<head>
  <meta charset="utf-8">
  <title>Création d'une page produit</title>
  <link rel="stylesheet" href="css/creation.css">
  <link rel="stylesheet" href="css/normalize.css">
</head>
<?php include 'functions.php'; ?>
<!-- On ajoute le header -->
<?php include 'header.php'; ?>

<body>

  <?php if (connecte()) { ?>

    <?php
    $bdd = new PDO('mysql:host=localhost:3306;dbname=agence_immobiliere;charset=utf8', 'agence_immobiliere', 'groupe01'); ?>

    <form method="POST">
      <div class="row">
        <div class="col">
          <div class="form-group">
            <label for="name">Adresse du logement :</label>
            <input type="text" class="form-control" name="adresse" required>
          </div>
        </div>
        <div class="col">
          <div class="form-group">
            <label for="name">Type de logement :</label>

            <input type="radio" class="form-control" name="type" value="appartement" required>
            <label for="name">Appartement</label>
            
            <input type="radio" class="form-control" name="type" value="maison" required>
            <label for="name">Maison</label>
          </div>
        </div>
        <div class="col">
          <div class="form-group">
            <label for="name">Surface (en m²) :</label>
            <input type="number" class="form-control" name="surface" required>
          </div>
        </div>
        <div class="col">
          <div class="bouton_container">
            <button type="submit" class="bouton_form">Ajouter</button>
          </div>
        </div>
      </div>
    </form>

  <?php } else {
    header('Location: connexion.php');
  } ?>

  <?php
  if (
    array_key_exists('adresse', $_POST) && !empty($_POST['adresse'])
    && array_key_exists('type', $_POST) && !empty($_POST['type'])
    && array_key_exists('surface', $_POST) && !empty($_POST['surface'])
  ) {

    /* Si le formulaire a bien été envoyé on vérifie que les données sont conformes */
    if (
      preg_match('/[A-Za-z0-9]+/i', $_POST['adresse'])
      && ($_POST['type'] == "appartement" || $_POST['type'] == "maison")
      && preg_match('/[0-9]+/i', $_POST['surface'])
    ) {
      /* Les données entré ici pouvant être affiché sur une page,
    il faut également sécuriser les données face à une potentiel faille XSS */
      $adresse = xss_validator($_POST['adresse']);
      $type = xss_validator($_POST['type']);
      $surface = xss_validator($_POST['surface']);

      /* Et on rajoute à la base de donnée noes informations */
      $requete = $bdd->prepare('INSERT INTO logements (adresse, type, surface) VALUES (:adresse, :type, :surface)');
      $requete->execute(array(
        'adresse' => $adresse,
        'type' => $type,
        'surface' => $surface
      ));
      $requete->closeCursor();

      /* On termine avec l'affichage d'un message pour l'utilisateur */
      echo "<p style='text-align: center;'>Votre logement a bien été ajouté à notre site.</p>";
    } else {
      echo "<p style='text-align: center;'>Une erreur est survenue, veuillez vérifier les valeurs saisies.<p>";
    }
  }
  ?>

</body>
<!-- On ajoute le footer -->
<?php include 'footer.php'; ?>

</html>