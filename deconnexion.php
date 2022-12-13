<?php session_start(); ?>
<?php 
    /* On commence par écraser les valeurs du tableaux $_SESSION */
    $_SESSION = array();
    /* On détruit l'ensemble des vairables de la session actuelle */
    session_unset();
    /* Et enfin on détruit la session actuelle */
    session_destroy();
    /* Il ne reste que la redirection à effectuer */
    header('Location: index.php'); // redirige l'utilisateur
?>