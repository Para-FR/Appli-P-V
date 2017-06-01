<?php require_once ('../../includes/config.php')?>
<?php
// Génération d'une chaine aléatoire
function chaine_aleatoire($nb_car, $chaine = '@azertyuiopqsdfghjklmwxcvbn123456789AZERTYUIOPQSDFGHJKLMWXCVBN')
{
    $nb_lettres = strlen($chaine) - 1;
    $generation = '';
    for($i=0; $i < $nb_car; $i++)
    {
        $pos = mt_rand(0, $nb_lettres);
        $car = $chaine[$pos];
        $generation .= $car;
    }
    return $generation;
}


?>
<?php echo 'Votre nouveau Mot de Passe : ' . chaine_aleatoire(8);
?>