<?php 
/*
    Fonction connecte"
        Elle vérifie qu'un utilisateur
        est connecté
    */

    function connecte()
    {
      if (
        isset($_SESSION)
        && count($_SESSION)
        && array_key_exists('identifiant', $_SESSION)
        && !empty($_SESSION['identifiant'])
      ) {
        return true;
      } else {
        return false;
      }
    }


    /* Cette fonction à pour objectif de vérifier et
    de corriger les données pour éviter l'abus d'une faille XSS */
    function xss_validator($element)
    {
        $element = trim($element);
        $element = strip_tags($element);
        $element = stripslashes($element);
        $element = htmlspecialchars($element);
        return $element;
    }

    /*
      Fonction "connexion"
      Elle connecte un utilisateur selon les paramètres transmis
      et les stock dans la SESSION
    */

  function connexion($identifiant)
  {
    $_SESSION['identifiant'] = $identifiant;
  }
?>