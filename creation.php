<!doctype html>
<html lang="fr">
<head>
  <meta charset="utf-8">
  <title>Création d'une page produit</title>
  <link rel="stylesheet" href="css/creation.css">
</head>
<!-- On ajoute le header -->
<?php include 'header.php';?>
<body>


<?php
  $bdd = new PDO ('mysql:host=localhost:3306;dbname=agence_immobiliere;charset=utf8','root','');
  
?>


<form method="POST">
  <div class="row">
    <div class="col">
      <div class="form-group">
        <label for="name">Adresse du logement : </label>
        <input type="text" class="form-control" name="adresse" required>
      </div>
    </div>
    <div class="col">
      <div class="form-group">
        <label for="name">Type de logement : </label>
        <input type="text" class="form-control" name="type" required>
      </div>
    </div>
    <div class="col">
      <div class="form-group">
        <label for="name">Surface (en m²) : </label>
        <input type="number" class="form-control" name="surface" required>
      </div>
    </div>
    <div class="col">
      <button type="submit" class="btn btn-primary mb-2">Ajouter</button>
    </div>
  </div>
</form>

<?php
  $requete = $bdd->prepare('INSERT INTO logements (adresse, type, surface) VALUES (:adresse, :type, :surface)');
  $requete->execute(array(
    'adresse' => $_POST['adresse'],
    'type' => $_POST['type'],
    'surface' => $_POST['surface']
  ));
?>
  
</body>
<!-- On ajoute le footer -->
<?php include 'footer.php';?>
</html>