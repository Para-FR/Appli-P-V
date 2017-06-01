<?php require_once('../../includes/config.php') ?>
<?php
function do_action_demande($action)
{
    if ($action == 'ajouter') {

        if (empty($element)) {
            executeRequete("SELECT * FROM demandes");
            $caca = executeRequete("SELECT * FROM demandes");
            $defaut = $caca->fetch_assoc();
            //var_dump($test);
            $resultat_modifier = '';
            return $defaut;
        }
    }

    if ($action == 'supprimer') {
        $element = $_GET['element'];

        if (!empty($element)) {
            $verif_exist = executeRequete("SELECT * FROM details_demande WHERE id_demande=$element");
            if ($verif_exist->num_rows > 0){
                $erreur_suppression = '<strong>Erreur !</strong><br> Suppression impossible, un employé est sur cette tâche';
                return $erreur_suppression;
            }else{
                executeRequete("DELETE FROM demandes WHERE id_demande=$element");
                $suppression = '<strong>Supprimé !</strong><br> Produit Supprimé';
                return $suppression;
            }
        }
    }
    if ($action == 'modifier') {
        $element = $_GET['element'];

        if (!empty($element)) {
            $caca = executeRequete("SELECT * FROM demandes WHERE id_demande = $element");
            $test = $caca->fetch_assoc();
            //var_dump($test);
            $resultat_modifier = '';
            return $test;
        }
    }
    if ($action == 'attente') {
        $element = $_GET['element'];
        $attente = 'En Attente';
        if (!empty($element)) {
            executeRequete("UPDATE demandes SET etat='" . $attente . "' WHERE id_demande='" . $_GET['element'] . "'");
        }
    }
    if ($action == 'traitement') {
        $element = $_GET['element'];
        $traitement = 'En cours de traitement';
        if (!empty($element)) {
            executeRequete("UPDATE demandes SET etat='" . $traitement . "' WHERE id_demande='" . $_GET['element'] . "'");
        }
    }
    if ($action == 'traite') {
        $element = $_GET['element'];
        $traite = 'Traité';
        if (!empty($element)) {
            executeRequete("UPDATE demandes SET etat='" . $traite . "' WHERE id_demande='" . $_GET['element'] . "'");
        }
    }
}
// Formulaire d'ajout de Produit
if (isset($_POST['sub_add_demande'])) {
    $echec_ajout_produit = '';
    if (isset($taille_produit) && is_numeric($taille_produit)) {
        $echec_ajout_produit .= '<strong>Erreur !</strong><br> Le champ Taille est incorrect (Numérique)';
    }

    $photo_bdd = "";
    $taille_maxi = 100000000;
    $taille = filesize($_FILES['photo_demande']['tmp_name']);
    $extensions = array('.png', '.gif', '.jpg', '.jpeg');
    $extension = strrchr($_FILES['photo_demande']['name'], '.');
    $echec_ajout_produit = '';

    if(!in_array($extension, $extensions)) //Si l'extension n'est pas dans le tableau
    {
        $erreur = 'Vous devez uploader un fichier de type png, gif, jpg, jpeg';
    }
    if($taille>$taille_maxi)
    {
        $erreur = 'Le fichier est trop gros...';
    }
    if(!empty($_FILES['photo_demande']['name']) && !isset($erreur)) {
        $nom_photo = $_POST['sujet_demande'].'_'.$_FILES['photo_demande']['name'];
        $photo_bdd = "./uploads/$nom_photo";
        $photo_dossier = "./../../uploads/$nom_photo";
        !copy($_FILES['photo_demande']['tmp_name'], "./../../uploads/$nom_photo$nom_photo");
    } else {
        echo $echec_ajout_produit .= '<strong>Erreur !</strong><br> Image non uploadée car trop volumineuse ou n\'est pas une image';
    }
    foreach($_POST as $indice => $valeur) {
        $_POST[$indice] = htmlEntities(addslashes($valeur));
    }
    if (isset($echec_ajout_produit) && empty($echec_ajout_produit)) {
        $id_membre_demande = $_SESSION['membre']['id_membre'];
        executeRequete("INSERT INTO demandes (type_demande, id_membre, date_enregistrement, sujet_demande, message_demande, salle, importance, photo)
      VALUES ('$_POST[type_demande]', '$id_membre_demande' , NOW(), '$_POST[sujet_demande]', '$_POST[description_demande]', '$_POST[salle]', '$_POST[importance]', '$photo_bdd')");
        $produitajouté = '<strong>Validé !</strong><br> Le produit ' . $_POST['sujet_demande'] . '&nbsp;' . 'a bien été ajouté';
    } else {
        $echec_ajout_produit .= '';
    }

}
// Formulaire de modification de Produit
if (isset($_POST['sub_modifier_demande'])) {
    $echec_modification_produit = '';
    if (isset($echec_modification_produit) && empty($echec_modification_produit)) {
        executeRequete("UPDATE demandes SET sujet_demande='" . $_POST['sujet_demande'] . "', message_demande='" . $_POST['description_demande'] . "', salle='" . $_POST['salle'] . "', importance= '" . $_POST['importance'] . "', photo='" . '$photo_bdd' .  "' WHERE id_demande='" . $_GET['element'] . "'");
        $produitmodifie = '<strong>Validé !</strong><br> Le produit ' . $_POST['sujet_demande'] . '&nbsp;' . 'a bien été modifié';
        $test = array(
            "categorie" => $_POST['type_demande'],
            "titre" => $_POST['sujet_demande'],
            "description" => $_POST['description_demande'],
            "couleur" => $_POST['importance'],
            "public" => $_POST['importance']
        );
    }
}
// SI l'action est définie et qu'elle n'est pas vide
if (isset($_GET['action']) && !empty($_GET['action']) && $_GET['action'] == 'supprimer') {
    $suppression = do_action_demande($_GET['action']);
} ?>
<?php if (isset($_GET['action']) && !empty($_GET['action']) && $_GET['action'] == 'traitement') {
    $traitement = do_action_demande($_GET['action']);
} ?>
<?php if (isset($_GET['action']) && !empty($_GET['action']) && $_GET['action'] == 'traite') {
    $traite = do_action_demande($_GET['action']);
} ?>
<?php if (isset($_GET['action']) && !empty($_GET['action']) && $_GET['action'] == 'attente') {
    $attente = do_action_demande($_GET['action']);
} ?>
<?php if (isset($_GET['action']) && !empty($_GET['action']) && $_GET['action'] == 'consulter') {
    $consulter = do_action_demande($_GET['action']);
}else{
    $defaut = do_action_demande('ajouter');
}

?>

<?php require_once('../../includes/navbar.php'); ?>
    <!-- =============================================== -->

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Gestion des Produits
            </h1>
            <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                <li><a href="#">Examples</a></li>
                <li class="active">Blank page</li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content">
            <!-- Default box -->
            <div class="box boxgreen collapsed collapsed-box">
                <div class="box-header with-border">
                    <h3 class="box-title">Ajouter</h3>
                    <?php if (isset($produitajouté) && !empty($produitajouté)) { ?>
                        <div class="alert alert-success center" role="alert">
                            <?php echo $produitajouté ?>
                        </div>
                    <?php } ?>

                    <?php if (isset($echec_ajout_produit) && !empty($echec_ajout_produit)) { ?>
                        <div class="alert alert-danger center" role="alert">
                            <?php echo $echec_ajout_produit ?>
                        </div>
                    <?php } ?>

                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip"
                                title="Collapse">
                            <i class="fa fa-plus"></i></button>
                        <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip"
                                title="Remove">
                            <i class="fa fa-times"></i></button>
                    </div>
                </div>
                <div class="box-body">
                    <div class="box-body">
                        <div class="row">
                            <div class="col-md-12">
                                <!-- Custom Tabs -->
                                <div class="nav-tabs-custom">
                                    <ul class="nav nav-tabs">
                                        <li class="active">
                                            <a href="#tab_insert_1" data-toggle="tab" aria-expanded="true"><i
                                                    class="fa fa-plus"></i> Demande</a>
                                        </li>
                                    </ul>
                                    <div class="tab-content">
                                        <!-- /.tab-pane ADMINUISTRATEUR -->
                                        <div class="tab-pane active" id="tab_insert_1">

                                            <br>
                                            <form action="#"
                                                  class="myform" method="post" enctype="multipart/form-data">
                                                <input type="hidden" name="csrf_sitecom_token"
                                                       value="e9475f8e53f59d2f3b2bbeab3cb56c4e">

                                                <br>
                                                <div class="col-md-8 col-md-offset-2">
                                                    <label for="sel1">Informations générales :</label>
                                                </div>

                                                <div class="row">
                                                    <div class="col-md-4 col-md-offset-2">
                                                        <div class="input-group">
                                                            <span class="input-group-addon" id="basic-addon1"><i
                                                                    class="fa fa-font"></i></span>
                                                            <input type="text" class="form-control"
                                                                   id="inputsujet_demande" name="sujet_demande"
                                                                   placeholder="Sujet" value=""
                                                                   required>
                                                        </div>
                                                        <div class="input-error under-grouped">
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-md-8 col-md-offset-2">
                                                        <div class="input-group">
                                                            <span class="input-group-addon" id="basic-addon1"><i
                                                                    class="fa fa-align-justify"></i></span>
                                                            <textarea type="text" class="form-control"
                                                                      id="inputdescription_demande"
                                                                      name="description_demande"
                                                                      placeholder="Votre Message ..."
                                                                      value="" required></textarea>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-md-8 col-md-offset-2">
                                                    <label for="sel1">Informations secondaires :</label>
                                                </div>

                                                <div class="row">
                                                    <div class="col-md-4 col-md-offset-2">
                                                        <select name="importance" class="form-control" required>
                                                            <option value="Peu Important">Peu important</option>
                                                            <option value="f">Important</option>
                                                            <option value="mixte">Très important</option>
                                                            <option value="mixte">Urgent</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <select name="type_demande" class="form-control" required>
                                                            <?php
                                                            $tableau = $bdd->query("SELECT demande_type FROM type_demande");
                                                            foreach ($tableau as $m => $value) {
                                                                ?>
                                                                <option
                                                                    value="<?php echo $value['demande_type'] ?>">
                                                                    <?php echo $value['demande_type'];?>
                                                                </option>
                                                                <?php
                                                            }
                                                            ?>
                                                        </select>

                                                    </div>

                                                </div>
                                                <br/>


                                                <div class="row">
                                                    <div class="col-md-4 col-md-offset-2">
                                                        <div class="form-group">
                                                            <label for="photo_demande">Image du Produit</label>
                                                            <input type="hidden" name="MAX_FILE_SIZE" value="100000000">
                                                            <input name="photo_demande" type="file" id="photo_demande">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <select name="salle" class="form-control">
                                                            <?php
                                                            $tableau = $bdd->query("SELECT nom_salle FROM salles");
                                                            foreach ($tableau as $m => $value) {
                                                                ?>
                                                                <option
                                                                    value="<?php echo $value['nom_salle'] ?>"><?php echo $value['nom_salle'] ?></option>
                                                                <?php
                                                            }
                                                            ?>
                                                        </select>

                                                    </div>

                                                </div>

                                                <hr>
                                                <div class="row">
                                                    <div class="col-md-11">

                                                        <button name="sub_add_demande" type="submit"
                                                                class="btn btn-success  pull-right">
                                                            <i class="fa fa-check"></i> Ajouter
                                                        </button>
                                                    </div>
                                                </div>


                                            </form>
                                        </div>
                                    </div>
                                    <!-- /.tab-content -->
                                </div>
                                <!-- nav-tabs-custom -->
                            </div>
                            <!-- /.col -->
                        </div>
                        <!-- /.row -->


                    </div>
                </div>
                <!-- /.box-body -->
                <div class="box-footer">
                    Footer
                </div>
                <!-- /.box-footer-->
            </div>
            <!-- /.box -->
            <!-- Box de Modification -->
            <?php if (!empty($test)) { ?>
                <div class="box boxorange">
                    <div class="box-header with-border">
                        <h3 class="box-title">Modifier</h3>


                        <?php if (isset($produitmodifie) && !empty($produitmodifie)) { ?>
                            <div class="alert alert-success center" role="alert">
                                <?php echo $produitmodifie ?>
                            </div>
                        <?php } ?>

                        <?php if (isset($echec_modification_produit) && !empty($echec_modification_produit)) { ?>
                            <div class="alert alert-danger center" role="alert">
                                <?php echo $echec_modification_produit ?>
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
                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <!-- Custom Tabs -->
                                    <div class="nav-tabs-custom">
                                        <ul class="nav nav-tabs">
                                            <li class="active">
                                                <a href="#tab_insert_1" data-toggle="tab" aria-expanded="true"><i
                                                        class="fa fa-plus"></i> Demande</a>
                                            </li>
                                        </ul>
                                        <div class="tab-content">
                                            <!-- /.tab-pane Modifier -->
                                            <div class="tab-pane active" id="tab_insert_1">
                                                <br>
                                                <form action="#"
                                                      class="myform" method="post" enctype="multipart/form-data">
                                                <div class="col-md-8 col-md-offset-2">
                                                    <label for="sel1">Informations générales :</label>
                                                </div>

                                                <div class="row">
                                                    <div class="col-md-4 col-md-offset-2">
                                                        <div class="input-group">
                                                            <span class="input-group-addon" id="basic-addon1"><i
                                                                    class="fa fa-font"></i></span>
                                                            <input type="text" class="form-control"
                                                                   id="inputsujet_demande" name="sujet_demande"
                                                                   placeholder="Sujet"
                                                                   value="<?php echo $test['sujet_demande'] ?>" required>
                                                        </div>
                                                        <div class="input-error under-grouped">
                                                        </div>
                                                    </div>
                                                </div>
                                                <br>
                                                <div class="row">
                                                    <div class="col-md-8 col-md-offset-2">
                                                        <div class="input-group">
                                                            <span class="input-group-addon" id="basic-addon1"><i
                                                                    class="fa fa-align-justify"></i></span>
                                                            <textarea type="text" class="form-control"
                                                                      id="inputdescription_demande"
                                                                      name="description_demande"
                                                                      ><?php echo $test['message_demande'] ?>
                                                            </textarea>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-md-8 col-md-offset-2">
                                                    <label for="sel1">Informations secondaires :</label>
                                                </div>

                                                <div class="row">
                                                    <div class="col-md-4 col-md-offset-2">
                                                        <select name="importance" class="form-control" required>
                                                            <option value="Peu Important">Peu important</option>
                                                            <option value="f">Important</option>
                                                            <option value="mixte">Très important</option>
                                                            <option value="mixte">Urgent</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <select name="type_demande" class="form-control">
                                                            <?php
                                                            $tableau = $bdd->query("SELECT demande_type FROM type_demande");
                                                            foreach ($tableau as $m => $value) {
                                                                ?>
                                                                <option
                                                                    value="<?php echo $value['demande_type'] ?>"><?php echo $value['demande_type'] ?></option>
                                                                <?php
                                                            }
                                                            ?>
                                                        </select>

                                                    </div>

                                                </div>
                                                <br/>
                                                <div class="row">
                                                    <div class="col-md-4 col-md-offset-2">
                                                        <div class="form-group">
                                                            <label for="photo_demande">Image du Produit</label>
                                                            <input type="hidden" name="MAX_FILE_SIZE" value="100000000">
                                                            <input name="photo_demande" type="file" id="photo_demande">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <select name="salle" class="form-control">
                                                            <?php
                                                            $tableau = $bdd->query("SELECT nom_salle FROM salles");
                                                            foreach ($tableau as $m => $value) {
                                                                ?>
                                                                <option
                                                                    value="<?php echo $value['nom_salle'] ?>"><?php echo $value['nom_salle'] ?></option>
                                                                <?php
                                                            }
                                                            ?>
                                                        </select>

                                                    </div>

                                                </div>

                                                <hr>
                                                <div class="row">
                                                    <div class="col-md-11">

                                                        <button name="sub_modifier_demande" type="submit"
                                                                class="btn btn-warning  pull-right">
                                                            <i class="fa fa-cogs"></i> Modifier
                                                        </button>
                                                    </div>
                                                </div>


                                                </form>
                                            </div>
                                        </div>
                                        <!-- /.tab-content -->
                                    </div>
                                    <!-- nav-tabs-custom -->
                                </div>
                                <!-- /.col -->
                            </div>
                            <!-- /.row -->


                        </div>
                    </div>
                    <!-- /.box-body -->
                    <div class="box-footer">
                        Footer
                    </div>
                    <!-- /.box-footer-->
                </div>
                <!-- ./Box de Modification -->
            <?php } ?>
            <!-- Default box 2 -->
            <div class="box boxblue">
                <div class="box-header with-border">
                    <h3 class="box-title">Ensemble des produits</h3>
                    <?php if (isset($suppression) && !empty($suppression)) { ?>
                        <div class="alert alert-danger center" role="alert">
                            <?php echo $suppression ?>
                        </div>
                    <?php } ?>

                    <?php if (isset($erreur_suppression) && !empty($erreur_suppression)) { ?>
                        <div class="alert alert-danger center" role="alert">
                            <?php echo $erreur_suppression ?>
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
                    $tableau = executeRequete("SELECT * FROM demandes");
                    echo '<table id="produits" cellspacing="0" class="table table-bordered display"> <thead> <tr class="center">';
                    while ($colonne = $tableau->fetch_field()) {
                        echo '<th class="center text-center">' . ucfirst($colonne->name) . '</th>';
                    }
                    echo '<th class="center">Action</th>';
                    echo '</thead>';
                    echo "</tr>";
                    while ($ligne = $tableau->fetch_assoc()) {
                        echo '<tr>';
                        foreach ($ligne as $indice => $information) {
                            echo '<td class="center">' . $information . '</td>';
                        }
                        echo "<td class='center text-center'>
    <div style=\"width:100px;\">
        <div class=\"dropdown\">
            <button class=\"btn btn-warning dropdown-toggle btn-xs\" type=\"button\" data-toggle=\"dropdown\"><i class='fa fa-cog'></i></button>
            <ul class=\"dropdown-menu\">
                <li><a name='attente' href='gestion_demandes.php?action=attente&element=" . $ligne['id_demande'] . "'>En Attente</a></li>
                <li><a name='livraison' href='gestion_demandes.php?action=traitement&element=" . $ligne['id_demande'] . "'>En cours de traitement</a></li>
                <li><a name='livree' href='gestion_demandes.php?action=traite&element=" . $ligne['id_demande'] . "'>Traité</a></li>
            </ul>

            <a name=\'action\' href=gestion_demandes.php?action=consulter&element=" . $ligne['id_demande'] . " class=\"btn btn-azur btn-xs\">
            <i class=\"fa fa-eye\"></i>
            </a>
            <a name=\'action\' href=gestion_demandes.php?action=modifier&element=" . $ligne['id_demande'] . " class=\"btn btn-azur btn-xs\">
            <i class=\"fa fa-info-circle\"></i>
            </a>
            <a name=\'action\' href=gestion_demandes.php?action=supprimer&element=" . $ligne['id_demande'] . " class=\"btn btn-danger btn-xs\">
            <i class=\"fa fa-trash\"></i>
            </a>
        </div>
    </div>
</td>"; echo '</tr>';
                    }
                    echo '</table>';
                    ?>
                </div>
                <!-- /.box-body 2 -->
                <div class="box-footer">
                    <?php echo "<b>Total de produits : </b> " . $tableau->num_rows; ?>
                </div>
                <!-- /.box-footer 2-->
            </div>
            <!-- /.box 2 -->

        </section>
    </div>
    <!-- /.content-wrapper -->
    <script src="http://code.jquery.com/jquery-1.12.4.js"></script>
    <script src="https://cdn.datatables.net/1.10.15/js/jquery.dataTables.min.js"></script>
    <script>
        $(document).ready(function () {
            $('#produits').DataTable({
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