<?php require_once('../../includes/config.php') ?>
<?php
function do_action_commandes($action)
{
    if ($action == 'consulter') {
        $element = $_GET['element'];
        if (!empty($element)) {
            $consult = executeRequete("select id_commande,montant,date_enregistrement,etat,nom,prenom,email,ville,code_postal,adresse
from commande INNER JOIN membre on commande.id_membre = membre.id_membre WHERE id_commande='" . $_GET['element'] . "'");
            $consulter = $consult->fetch_assoc();
            return $consulter;

        }
    }
    if ($action == 'ajouter') {

        if (empty($element)) {
            executeRequete("SELECT * FROM produit");
            $caca = executeRequete("SELECT * FROM produit");
            $defaut = $caca->fetch_assoc();
            //var_dump($test);
            return $defaut;
        }
    }

    if ($action == 'supprimer') {
        $element = $_GET['element'];

        if (!empty($element)) {
            executeRequete("DELETE FROM commande WHERE id_commande=$element");
            $suppression = '<strong>Supprimé !</strong><br> Commande Supprimé';
            return $suppression;
        }
    }
    if ($action == 'livraison') {
        $element = $_GET['element'];
        $livraison = 'commande en cours de livraison';

        if (!empty($element)) {
            executeRequete("UPDATE commande SET etat='" . $livraison . "' WHERE id_commande='" . $_GET['element'] . "'");
            $req_info_commande_client = executeRequete("SELECT id_commande, etat, nom, prenom, email FROM commande 
            INNER JOIN membre ON commande.id_membre = membre.id_membre WHERE id_commande='$element'");
            $info_commande_client = $req_info_commande_client->fetch_assoc();
            $headers  = 'MIME-Version: 1.0' . "\r\n";
            $headers .= 'Content-type: text/html; charset=utf-8';
            $msg  =  'Bonjour '.$info_commande_client['nom']." ".$info_commande_client['prenom'].',<br />';
            $msg .=  'Le statut de votre commande est désormais :' . $info_commande_client['etat'];
            $msg .=  "Connectez vous pour suivre l'avancement de votre commande : <a href=\"http://ecommercemai2017:8082/login\"> ICI </a>";
            $objet = 'Votre Commande n°' . $info_commande_client['id_commande'] .'est en cours de livraison';
            $livraison_mail ='';
            $mail_livraison_send = mail($info_commande_client['email'], $objet, $msg, $headers);
            if ($mail_livraison_send){
                $livraison_mail .= '<strong>Succès !</strong><br> Le mail a bien été envoyé au client';
            }else{
                $livraison_mail .= '<strong>Erreur !</strong><br> Le mail n\'a pas été envoyé';
            }
        }
    }
    if ($action == 'livree') {
        $element = $_GET['element'];
        $livree = 'commande livrée';
        if (!empty($element)) {
            executeRequete("UPDATE commande SET etat='" . $livree . "' WHERE id_commande='" . $_GET['element'] . "'");
            $req_info_commande_client = executeRequete("SELECT id_commande, etat, nom, prenom, email FROM commande 
            INNER JOIN membre ON commande.id_membre = membre.id_membre WHERE id_commande='$element'");
            $info_commande_client = $req_info_commande_client->fetch_assoc();
            $headers  = 'MIME-Version: 1.0' . "\r\n";
            $headers .= 'Content-type: text/html; charset=utf-8';
            $msg  =  'Bonjour '.$info_commande_client['nom']." ".$info_commande_client['prenom'].',<br />';
            $msg .=  'Le statut de votre commande est désormais :' . $info_commande_client['etat'];
            $msg .=  "Connectez vous pour suivre l'avancement de votre commande : <a href=\"http://ecommercemai2017:8082/login\"> ICI </a>";
            $objet = 'Votre Commande n°' . $info_commande_client['id_commande'] .'vient d\'être livrée';
            $livraison_mail ='';
            $mail_livraison_send = mail($info_commande_client['email'], $objet, $msg, $headers);
            if ($mail_livraison_send){
                $livraison_mail .= '<strong>Succès !</strong><br> Le mail a bien été envoyé au client';
            }else{
                $livraison_mail .= '<strong>Erreur !</strong><br> Le mail n\'a pas été envoyé';
            }
        }
    }
    if ($action == 'traitement') {
        $element = $_GET['element'];
        $traitement = 'commande en cours de traitement';
        if (!empty($element)) {
            executeRequete("UPDATE commande SET etat='" . $traitement . "' WHERE id_commande='" . $_GET['element'] . "'");
            $req_info_commande_client = executeRequete("SELECT id_commande, etat, nom, prenom, email FROM commande 
            INNER JOIN membre ON commande.id_membre = membre.id_membre WHERE id_commande='$element'");
            $info_commande_client = $req_info_commande_client->fetch_assoc();
            $headers  = 'MIME-Version: 1.0' . "\r\n";
            $headers .= 'Content-type: text/html; charset=utf-8';
            $msg  =  'Bonjour '.$info_commande_client['nom']." ".$info_commande_client['prenom'].',<br />';
            $msg .=  'Le statut de votre commande est désormais :' . $info_commande_client['etat'];
            $msg .=  "Connectez vous pour suivre l'avancement de votre commande : <a href=\"http://ecommercemai2017:8082/login\"> ICI </a>";
            $objet = 'Votre Commande n°' . $info_commande_client['id_commande'] .'est en cours de traitement';
            $livraison_mail ='';
            $mail_livraison_send = mail($info_commande_client['email'], $objet, $msg, $headers);
            if ($mail_livraison_send){
                $livraison_mail .= '<strong>Succès !</strong><br> Le mail a bien été envoyé au client';
            }else{
                $livraison_mail .= '<strong>Erreur !</strong><br> Le mail n\'a pas été envoyé';
            }
        }
    }
}

?>
<?php
if (isset($_POST['sub_admin'])) {
    $verif_caracters = preg_match('#^[a-zA-Z0-9._-]+$#', $_POST['pseudo_admin']);
    if (!$verif_caracters && (strlen($_POST['pseudo_admin'] < 1) || strlen($_POST['pseudo_admin'] > 20))) {
        $contenu .= '<strong>Erreur !</strong><br> Le champ Pseudo doit contenir entre 1 et 20 caractères alphanumériques.';
    } else {
        $membre = executeRequete("SELECT * FROM membre WHERE pseudo='$_POST[pseudo_admin]'");
        if ($membre->num_rows > 0) {
            $contenu .= '<strong>Erreur !</strong><br> Le Pseudo existe déjà';
        } else {
            $statut = 1;
            $mdp_crypt = sha1($_POST['password_admin']);
            foreach ($_POST as $indice => $valeur) {
                $_POST[$indice] = htmlentities(addslashes($valeur));
            }
            executeRequete("INSERT INTO membre (pseudo, mdp, nom, prenom, email, civilite, ville, code_postal, adresse, statut) 
            VALUES('$_POST[pseudo_admin]', '$mdp_crypt', '$_POST[first_name_admin]', '$_POST[last_name_admin]', '$_POST[email_admin]', '$_POST[civilite]', '$_POST[ville_admin]', '$_POST[cp_admin]', '$_POST[adresse_admin]', '$statut')");
            $succes .= '<strong>Validé !</strong><br> L\'administrateur ' . $_POST['first_name_admin'] . '&nbsp;' . $_POST['last_name_admin'] . ' a bien été ajouté';
        }
    }
}
if (isset($_POST['sub_user'])) {
    $verif_caracters = preg_match('#^[a-zA-Z0-9._-]+$#', $_POST['pseudo_user']);
    if (!$verif_caracters && (strlen($_POST['pseudo_user'] < 1) || strlen($_POST['pseudo_user'] > 20))) {
        $contenu .= '<strong>Erreur !</strong><br> Le champ Pseudo doit contenir entre 1 et 20 caractères alphanumériques.';
    } else {
        $membre = executeRequete("SELECT * FROM membre WHERE pseudo='$_POST[pseudo_user]'");
        if ($membre->num_rows > 0) {
            $contenu .= '<strong>Erreur !</strong><br> Le Pseudo existe déjà';
        } else {
            $statut = 0;
            $mdp_crypt = sha1($_POST['password_user']);
            foreach ($_POST as $indice => $valeur) {
                $_POST[$indice] = htmlentities(addslashes($valeur));
            }
            executeRequete("INSERT INTO membre (pseudo, mdp, nom, prenom, email, civilite, ville, code_postal, adresse, statut) 
            VALUES('$_POST[pseudo_user]', '$mdp_crypt', '$_POST[first_name_user]', '$_POST[last_name_user]', '$_POST[email_user]', '$_POST[civilite]', '$_POST[ville_user]', '$_POST[cp_user]', '$_POST[adresse_user]', '$statut')");
            $succes .= '<strong>Validé !</strong><br> L\'utilisateur ' . $_POST['first_name_user'] . '&nbsp;' . $_POST['last_name_user'] . ' a bien été ajouté';
        }
    }
}
?>
<?php if (isset($_GET['action']) && !empty($_GET['action']) && $_GET['action'] == 'supprimer') {
    $suppression = do_action_commandes($_GET['action']);
} ?>
<?php if (isset($_GET['action']) && !empty($_GET['action']) && $_GET['action'] == 'livraison') {
    $livraison = do_action_commandes($_GET['action']);
} ?>
<?php if (isset($_GET['action']) && !empty($_GET['action']) && $_GET['action'] == 'livree') {
    $livree = do_action_commandes($_GET['action']);
} ?>
<?php if (isset($_GET['action']) && !empty($_GET['action']) && $_GET['action'] == 'traitement') {
    $traitement = do_action_commandes($_GET['action']);
} ?>
<?php if (isset($_GET['action']) && !empty($_GET['action']) && $_GET['action'] == 'consulter') {
    $consulter = do_action_commandes($_GET['action']);
} ?>
<?php require_once('../../includes/navbar.php'); ?>
<!-- =============================================== -->

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Gestion des Commandes
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">Examples</a></li>
            <li class="active">Blank page</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <!-- Default box 2 -->
        <div class="box boxblue">
            <div class="box-header with-border">
                <h3 class="box-title">Vue d'ensemble des Commandes</h3>
                <?php if (isset($suppression) && !empty($suppression)) { ?>
                    <div class="alert alert-danger center" role="alert">
                        <?php echo $suppression ?>
                    </div>
                <?php } ?>

                <?php if (isset($livraison_mail) && !empty($livraison_mail)) { ?>
                    <div class="alert alert-warning center" role="alert">
                        <?php echo $livraison_mail ?>
                    </div>
                <?php } ?>
                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip"
                            title="Collapse">
                        <i class="fa fa-minus"></i></button>
                    <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip"
                            title="Remove">
                        <i class="fa fa-times"></i></button>
                </div>
            </div>
            <div class="box-body">
                <?php
                $return = '';
                $tableau = executeRequete("SELECT id_commande, id_membre, montant, date_enregistrement, etat FROM commande");
                echo '<table id="commandes" cellspacing="0" class="table table-bordered display"> <thead><tr class="center">';
                while ($colonne = $tableau->fetch_field()) {
                    echo '<th class="center text-center">' . ucfirst($colonne->name) . '</th>';
                }
                echo '<th class="center">Action</th>';
                echo '</thead>';
                echo "</tr>";
                while ($ligne = $tableau->fetch_assoc()) {

                    echo '<tr>';
                    foreach ($ligne as $indice => $information) {
                        echo '<td class="centered">' . $information . '</td>';
                    }
                    echo "<td class='center text-center'>
    <div style=\"width:100px;\">
        <div class=\"dropdown\">
            <button class=\"btn btn-warning dropdown-toggle btn-xs\" type=\"button\" data-toggle=\"dropdown\"><i class='fa fa-cog'></i></button>
            <ul class=\"dropdown-menu\">
                <li><a name='traitement' href='gestion_commandes.php?action=traitement&element=" . $ligne['id_commande'] . "'>En cours de traitement</a></li>
                <li><a name='livraison' href='gestion_commandes.php?action=livraison&element=" . $ligne['id_commande'] . "'>En cours de livraison</a></li>
                <li><a name='livree' href='gestion_commandes.php?action=livree&element=" . $ligne['id_commande'] . "'>Commande livrée</a></li>
            </ul>

            <a name=\'action\' href=gestion_commandes.php?action=consulter&element=" . $ligne['id_commande'] . " class=\"btn btn-azur btn-xs\">
            <i class=\"fa fa-eye\"></i>
            </a>
            <a name=\'action\' href=gestion_commandes.php?action=supprimer&element=" . $ligne['id_commande'] . " class=\"btn btn-danger btn-xs\">
            <i class=\"fa fa-trash\"></i>
            </a>
        </div>
    </div>
</td>";
                    echo '</tr>';
                }
                echo '</table>';
                ?>
            </div>
            <!-- /.box-body 2 -->
            <div class="box-footer">

                <?php echo "<b>Total de commande(s) : </b> " . $tableau->num_rows; ?>
            </div>
            <!-- /.box-footer 2-->
        </div>
        <!-- /.box 2 -->

        <!-- Box Consulter -->
        <?php if (!empty($consulter)) { ?>
            <div class="box boxazur">
                <div class="box-header with-border">
                    <h3 class="box-title">Commande n° <?php echo $consulter['id_commande'] ?> &nbsp; Enregistrée le
                        : <?php echo $consulter['date_enregistrement'] ?></h3>
                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip"
                                title="Collapse">
                            <i class="fa fa-minus"></i></button>
                        <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip"
                                title="Remove">
                            <i class="fa fa-times"></i></button>
                    </div>
                </div>
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-8 col-md-offset-2">
                            <label><i class="fa fa-info-circle"></i> Informations:</label><br>
                            <div class="col-md-4 bg-bleu_azur2 pad5 borderRadius5 text-center">
                                <p><?php echo ucfirst($consulter['nom']) ?> <?php echo ucfirst($consulter['prenom']) ?></p>
                                <p><?php echo $consulter['email'] ?></p>
                                <p><?php echo ucfirst($consulter['adresse']) ?></p>
                                <p><?php echo ucfirst($consulter['code_postal']) ?>
                                    &nbsp; <?php echo ucfirst($consulter['ville']) ?></p>

                            </div>
                            <div class="col-md-4 bg-bleu_azur2 pull-right pad5 borderRadius5 text-center">
                                <p>Etat : <br><?php echo ucfirst($consulter['etat']) ?></p>
                            </div>
                            <div class="input-error under-grouped">
                            </div>
                        </div>
                    </div>
                    <hr>
                    <?php
                    $return = '';
                    $detail_commande_tableau = executeRequete("select p.id_produit, p.photo, p.titre, p.description, d.quantite, d.prix  from details_commande d INNER JOIN produit p on d.id_produit = p.id_produit WHERE id_commande='" . $_GET['element'] . "'");
                    echo '<table class="table table-bordered"> <tr class="center">';
                    if ($detail_commande_tableau->num_rows > 0){
                        while ($colonne = $detail_commande_tableau->fetch_field()) {
                            echo '<th class="center text-center">' . ucfirst($colonne->name) . '</th>';
                        }
                    }else{
                        echo "<div class='center'>Il n'y a aucun produit sur cette commande</div>";
                    }

                    echo "</tr>";
                    while ($ligne = $detail_commande_tableau->fetch_assoc()) {
                        echo '<tr>';
                        foreach ($ligne as $item => $value) {
                            echo '<td class="center">' . $value . '</td>';
                        }
                        echo '</tr>';

                    }
                    echo '</table>'
                    ?>

                    <br>
                    <hr>
                </div>
                <!-- /.box-body 2 -->
                <div class="box-footer">
                    <?php echo "<b>Total de produit(s) : </b> " . $detail_commande_tableau->num_rows; ?>
                </div>
                <!-- /.box-footer 2-->
            </div>
        <?php } ?>
        <!-- ./ Box Consulter -->

        <!-- /.content-wrapper -->
    </section>
</div>
<script src="http://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://cdn.datatables.net/1.10.15/js/jquery.dataTables.min.js"></script>
<script>
    $(document).ready(function () {
        $('#commandes').DataTable({
            "language": {
                "sProcessing": "Traitement en cours...",
                "sSearch": "Rechercher&nbsp;:",
                "sLengthMenu": "Afficher _MENU_ &eacute;l&eacute;ments",
                "sInfo": "Affichage de l'&eacute;l&eacute;ment _START_ &agrave; _END_ sur _TOTAL_ &eacute;l&eacute;ments",
                "sInfoEmpty": "Affichage de l'&eacute;l&eacute;ment 0 &agrave; 0 sur 0 &eacute;l&eacute;ment",
                "sInfoFiltered": "(filtr&eacute; de _MAX_ &eacute;l&eacute;ments au total)",
                "sInfoPostFix": "",
                "sLoadingRecords": "Chargement en cours...",
                "sZeroRecords": "Aucun &eacute;l&eacute;ment &agrave; afficher",
                "sEmptyTable": "Aucune donn&eacute;e disponible dans le tableau",
                "oPaginate": {
                    "sFirst": "Premier",
                    "sPrevious": "Pr&eacute;c&eacute;dent",
                    "sNext": "Suivant",
                    "sLast": "Dernier"
                },
                "oAria": {
                    "sSortAscending": ": activer pour trier la colonne par ordre croissant",
                    "sSortDescending": ": activer pour trier la colonne par ordre d&eacute;croissant"
                },

            },

        })
    })
</script>

<?php require_once('../../includes/footer.php'); ?>
