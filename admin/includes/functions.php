<?php

function executeRequete($req){
    global $bdd;
    $result = $bdd->query($req);

    if (!$result) {
        die("Erreur sur la requête sql. <br/>Message :" .$bdd->error. "<br/> Code : " . $req);
    }
    return $result;

}

function debug($var, $mode = 1){
    echo '<strong>Debug</strong><br /> Vous venez d\'être inscrit dans le fichier, le téléchargment commencera dans 5 secondes...<br />
                Sinon<a href="./liste.txt"> Cliquez ici</a>';

    $trace = array_shift($trace);
    echo "Debug demandé dans le fichier :" .$trace['file']. "à la ligne" . $trace['line']."<hr>";
    if ($mode === 1){
        echo "<pre>";
        print_r($var);
        echo "</pre>";
    }else{
        echo "<pre>";
        var_dump($var);
        echo "</pre>";
    }
}
function internauteEstConnecte(){
    if (!isset($_SESSION['membre'])){
        return FALSE;
    }
    return TRUE;
}

function internauteEstConnecteEtEstAdmin(){
    if (internauteEstConnecte() && $_SESSION['membre']['statut']== 1){
        return TRUE;
    }
    return FALSE;
}