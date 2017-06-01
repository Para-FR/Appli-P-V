<?php require_once('../../includes/config.php') ?>
<?php
function do_action_produit($action)
{
    if ($action == 'ajouter') {

        if (empty($element)) {
            executeRequete("SELECT * FROM produit");
            $caca = executeRequete("SELECT * FROM produit");
            $defaut = $caca->fetch_assoc();
            //var_dump($test);
            $resultat_modifier = '';
            return $defaut;
        }
    }

    if ($action == 'supprimer') {
        $element = $_GET['element'];

        if (!empty($element)) {
            executeRequete("DELETE FROM produit WHERE id_produit=$element");
            $suppression = '<strong>Supprimé !</strong><br> Produit Supprimé';
            return $suppression;
        }
    }
    if ($action == 'modifier') {
        $element = $_GET['element'];

        if (!empty($element)) {
            executeRequete("SELECT * FROM produit WHERE id_produit= $element");
            $caca = executeRequete("SELECT * FROM produit WHERE id_produit = $element");
            $test = $caca->fetch_assoc();
            //var_dump($test);
            $resultat_modifier = '';
            return $test;
        }
    } else {
        $resultat_modifier = '';
        return $resultat_modifier;
    }
}

// Formulaire d'ajout de Produit
if (isset($_POST['sub_add_produit'])) {
    $echec_ajout_produit = '';
    $stock_produit = $_POST['stock_produit'];
    $taille_produit = $_POST['size_produit'];
    $prix_produit = $_POST['prix_produit'];
    if (isset($stock_produit) && !is_numeric($stock_produit)) {
        $echec_ajout_produit .= '<strong>Erreur !</strong><br> Le champ Stock est incorrect (Numérique)';
    }
    if (isset($taille_produit) && is_numeric($taille_produit)) {
        $echec_ajout_produit .= '<strong>Erreur !</strong><br> Le champ Taille est incorrect (Numérique)';
    }
    if (isset($prix_produit) && !is_numeric($prix_produit)) {
        $echec_ajout_produit .= '<strong>Erreur !</strong><br> Le champ Prix est incorrect (Numérique)';
    }

    $photo_bdd = "";
    $taille_maxi = 100000000;
    $taille = filesize($_FILES['photo_produit']['tmp_name']);
    $extensions = array('.png', '.gif', '.jpg', '.jpeg');
    $extension = strrchr($_FILES['photo_produit']['name'], '.');
    $echec_ajout_produit = '';

    if(!in_array($extension, $extensions)) //Si l'extension n'est pas dans le tableau
    {
        $erreur = 'Vous devez uploader un fichier de type png, gif, jpg, jpeg';
    }
    if($taille>$taille_maxi)
    {
        $erreur = 'Le fichier est trop gros...';
    }
    if(!empty($_FILES['photo_produit']['name']) && !isset($erreur)) {
        $nom_photo = $_POST['reference_produit'].'_'.$_FILES['photo_produit']['name'];
        $photo_bdd = "./uploads/$nom_photo";
        $photo_dossier = "../../../uploads/$nom_photo";
        !copy($_FILES['photo_produit']['tmp_name'], "../../../uploads/$nom_photo$nom_photo");
    } else {
        echo $echec_ajout_produit .= '<strong>Erreur !</strong><br> Image non uploadée car trop volumineuse ou n\'est pas une image';
    }
    foreach($_POST as $indice => $valeur) {
        $_POST[$indice] = htmlEntities(addslashes($valeur));
    }
    if (isset($echec_ajout_produit) && empty($echec_ajout_produit)) {
        executeRequete("INSERT INTO produit (reference, categorie, titre, taille, description, couleur, prix, stock, public, photo )
      VALUES ('$_POST[reference_produit]', '$_POST[categorie_produit]', '$_POST[titre_produit]', '$_POST[size_produit]', '$_POST[description_produit]', '$_POST[couleur_produit]', '$_POST[prix_produit]', '$_POST[stock_produit]', '$_POST[genre_produit]', '$photo_bdd')");
        $produitajouté = '<strong>Validé !</strong><br> Le produit ' . $_POST['titre_produit'] . '&nbsp;' . 'a bien été ajouté';
    } else {
        $echec_ajout_produit .= '';
    }

}
// SI l'action est définie et qu'elle n'est pas vide
if (isset($_GET['action']) && !empty($_GET['action'])) {
    $test = do_action_produit($_GET['action']);
}
else{
    $defaut = do_action_produit('ajouter');
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
            <div class="box boxgreen collapsed">
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
                                                    class="fa fa-plus"></i> Produit</a>
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
                                                                    class="fa fa-shopping-bag"></i></span>
                                                            <input type="text" class="form-control"
                                                                   id="inputtitre_produit" name="titre_produit"
                                                                   placeholder="Entrez le nom du produit" value=""
                                                                   required>
                                                        </div>
                                                        <div class="input-error under-grouped">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="input-group">
                                                            <input type="text" class="form-control"
                                                                   id="inputprix_produit" name="prix_produit"
                                                                   placeholder="Prix" value="" required>
                                                            <span class="input-group-addon" id="basic-addon1"><i
                                                                    class="fa fa-euro"></i></span>
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
                                                                      id="inputdescription_produit"
                                                                      name="description_produit"
                                                                      placeholder="Entrez une Description ..."
                                                                      value="" required></textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-4 col-md-offset-2">
                                                        <div class="input-group">
                                                            <span class="input-group-addon" id="basic-addon1"><i
                                                                    class="fa fa-barcode"></i></span>
                                                            <input type="text" class="form-control"
                                                                   id="inputreference_produit"
                                                                   name="reference_produit"
                                                                   placeholder="Référence Produit" value="" required>
                                                        </div>
                                                        <div class="input-error under-grouped">
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-md-8 col-md-offset-2">
                                                    <label for="sel1">Informations secondaires :</label>
                                                </div>

                                                <div class="row">
                                                    <div class="col-md-4 col-md-offset-2">
                                                        <select name="genre_produit" class="form-control" required>
                                                            <option value="h">Homme</option>
                                                            <option value="f">Femme</option>
                                                            <option value="mixte">Mixte</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <select name="categorie_produit" class="form-control" required>
                                                            <?php
                                                            $tableau = $bdd->query("SELECT name_type FROM type_produit");
                                                            foreach ($tableau as $m => $value) {
                                                                ?>
                                                                <option
                                                                    value="<?php echo $value['name_type'] ?><?php if ($defaut['categorie'] == $value['name_type']) {
                                                                        echo 'selected';
                                                                    } ?>"><?php echo $value['name_type'] ?></option>
                                                                <?php
                                                            }
                                                            ?>
                                                        </select>

                                                    </div>

                                                </div>
                                                <br/>

                                                <div class="row">
                                                    <div class="col-md-4 col-md-offset-2">
                                                        <div class="input-group">
                                                            <span class="input-group-addon" id="basic-addon1"><i
                                                                    class="fa fa-tags"></i></span>
                                                            <input type="text" class="form-control"
                                                                   id="input_size_produit"
                                                                   name="size_produit"
                                                                   placeholder="Taille Disponibles ex : S, M ..."
                                                                   value="" required>
                                                        </div>
                                                        <div class="input-error under-grouped">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="input-group">
                                                            <span class="input-group-addon" id="basic-addon1"><i
                                                                    class="fa fa-cubes"></i></span>
                                                            <input type="number" class="form-control"
                                                                   id="input_stock_produit" name="stock_produit"
                                                                   placeholder="Stock" value="" required>
                                                        </div>
                                                        <div class="input-error under-grouped">
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-md-4 col-md-offset-2">
                                                        <div class="form-group">
                                                            <label for="photo_produit">Image du Produit</label>
                                                            <input type="hidden" name="MAX_FILE_SIZE" value="1000000000">
                                                            <input name="photo_produit" type="file" id="photo_produit">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <select name="couleur_produit" class="form-control">
                                                            <?php
                                                            $tableau = $bdd->query("SELECT produit_couleur FROM couleur_produit");
                                                            foreach ($tableau as $m => $value) {
                                                                ?>
                                                                <option
                                                                    value="<?php echo $value['produit_couleur'] ?><?php if ($defaut['couleur'] == $value['produit_couleur']) {
                                                                        echo 'selected';
                                                                    } ?>"><?php echo $value['produit_couleur'] ?></option>
                                                                <?php
                                                            }
                                                            ?>
                                                        </select>

                                                    </div>

                                                </div>

                                                <hr>
                                                <div class="row">
                                                    <div class="col-md-11">

                                                        <button name="sub_add_produit" type="submit"
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


        </section>
    </div>
    <!-- /.content-wrapper -->

<?php require_once('../../includes/footer.php'); ?>