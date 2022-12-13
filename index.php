<!doctype html>
<html lang="fr">

<head>
  <meta charset="utf-8">
  <title>Accueil</title>
  <link rel="stylesheet" href="css/index.css">
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
  <section id="corps_page">
    <div id="formulaire_filtre">
      <h2>Filtre</h2>
      <form class="filtre_form" action="index.php" method="POST">


        <div>
          <label for="sfc_min">Surface min en m2 :</label>
          <input type="text" id="sfc_min" name="text_sfc_min">
        </div>

        <div>
          <label for="sfc_max">Surface max en m2 :</label>
          <input type="text" id="sfc_max" name="text_sfc_max">
        </div>

        <div>
          <div>
            <input type="radio" id="appartement" name="radio_type" value="appartement">
            <label for="apaprtement">Appartement</label>
          </div>

          <div>
            <input type="radio" id="maison" name="radio_type" value="maison">
            <label for="maison">Maison</label>
          </div>
        </div>

        <div class="bouton_container">
          <button class="bouton_form" name="submit_post" type="submit">Filtrer</button>
        </div>

      </form>
      <div class="bouton_container">
        <button id="form_reset" class="bouton_form"><a href="index.php">Reset</a></button>
      </div>
    </div>

    <div id="liste_logements">
      <?php

      /* Pour commencer on définit une fonction qui va nous
    permettre de vérifier l'ensemble des données
    recu afin de palier aux failles XSS */
      function verification($element_post)
      {
        $element_post = trim($element_post);
        $element_post = strip_tags($element_post);
        $element_post = stripslashes($element_post);
        $element_post = htmlspecialchars($element_post);
        return $element_post;
      }

      /* On lance notre requête afin de récupérer nos données de la BDD */
      $bdd = new PDO('mysql:host=localhost:3306;dbname=agence_immobiliere;charset=utf8', 'gence_immobiliere', 'groupe01');
      $requete = $bdd->query('SELECT * FROM `logements`');
      $logements = $requete->fetchAll();

      if (($_SERVER["REQUEST_METHOD"] == "POST") && isset($_POST) && count($_POST)) {
        if (array_key_exists('radio_type', $_POST) && !empty($_POST['radio_type'])) {

          /* Ensuite on stock toutes les données
    récupérés dans des variables en appliquant notre fonction de sécurité*/
          $type = verification($_POST["radio_type"]);

          /* On trie nos données récupéré dans la BDD suivant
          le filtre appliqué de type de logement */
          if ($type == 'maison' || $type == 'appartement') {
            foreach ($logements as $element) {
              if ($element['type'] !== $type) {
                unset($logements[array_search($element, $logements)]);
              }
            }
          }
        }
        /* Système de trie de la surface minimum */
        if (array_key_exists('text_sfc_min', $_POST) && !empty($_POST['text_sfc_min'])) {
          $sfc_min = verification($_POST['text_sfc_min']);

          if (preg_match('/[0-9]+/i', $sfc_min)) {
            foreach ($logements as $element) {
              if ($element['surface'] < $sfc_min) {
                unset($logements[array_search($element, $logements)]);
              }
            }
          }
        }
        /* Système de trie de la surface maximum */
        if (array_key_exists('text_sfc_max', $_POST) && !empty($_POST['text_sfc_max'])) {
          $sfc_max = verification($_POST['text_sfc_max']);

          if (preg_match('/[0-9]+/i', $sfc_max)) {
            foreach ($logements as $element) {
              if ($element['surface'] > $sfc_max) {
                unset($logements[array_search($element, $logements)]);
              }
            }
          }
        }
      }

      /* On trie $logements si un filtre à été appliqué */


      /* on affiche les éléments de notre Array */
      $image = "";
      foreach ($logements as $element) {
        /* On affiche une image suivant le type de bien */
        if ($element['type'] == 'maison') {
          $image = 'assets/maison.jpg';
        } else {
          $image = 'assets/appartement.jpg';
        }

        echo '<div class="logement">
        <img class="logement_img" src="' . $image . '">
        <div class="logement_information">
          <div>
            <p>Adresse : ' . $element['adresse'] . '</p>
          </div>
          <div>
            <p>Type de logement : ' . $element['type'] . '</p>
          </div>
          <div>
            <p>Surface : ' . $element['surface'] . 'm2</p>
          </div>
          <div>
            <p>Référence : ' . $element['id'] . '</p>
          </div>
        </div>
      </div>';
      }

      $requete->closeCursor();
      ?>

    </div>

  </section>
</body>
<!-- On ajoute le footer -->
<?php include 'footer.php'; ?>
<script src="js/index.js"></script>

</html>