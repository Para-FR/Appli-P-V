<?php
$bdd = new mysqli("localhost", "root", "", "ecommerce");

if ($bdd->connect_error) die('Un Problème est survenu lors de la connexion à la BDD :' .$bdd->connect_error);

$bdd->set_charset('utf8');

session_start();

//define("RACINE_SITE", "/site/");

$contenu = '';
$succes = '';
$error = '';
if (isset($_GET['action']) && $_GET['action']=="deconnexion"){
    session_destroy();
    header('Location:index.php');
}

require_once('./functions.php');
?>