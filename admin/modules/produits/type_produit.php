<?php require_once('../../includes/config.php') ?>
<?php
$dataview = 1;
// Formulaire d'ajout de type de vêtements
if (isset($_POST['sub_type'])) {
    $ajout_type_echec = '';
    $ajout_type_succes = '';
    $ajout_type = $_POST['new_type_produit'];
    //var_dump($ajout_type);
    $verif_caracters = preg_match('#^[a-zA-Z0-9._-]+$#', $ajout_type);
    if (!$verif_caracters && (strlen($ajout_type < 1) || strlen($ajout_type > 20))) {
        $ajout_type_echec .= '<strong>Erreur !</strong><br> Le champ Type doit contenir entre 1 et 20 caractères alphanumériques.';
        $dataview = 1;
    } else {
        $types = executeRequete("SELECT * FROM type_produit WHERE name_type='$ajout_type'");
        if ($types->num_rows > 0) {
            $ajout_type_echec .= '<strong>Erreur !</strong><br> Le Type existe déjà';
            $dataview = 1;
        } else {
            executeRequete("INSERT INTO type_produit (name_type) 
            VALUES('$ajout_type')");
            $ajout_type_succes .= '<strong>Validé !</strong><br> Le Type' . $ajout_type . '&nbsp;' .' a bien été ajouté';
            $dataview = 1;
        }
    }
}
// Formulaire d'ajout de couleur de vêtements
if (isset($_POST['sub_couleur'])) {
    $ajout_couleur_echec = '';
    $ajout_couleur_succes = '';
    $ajout_couleur = $_POST['new_couleur_produit'];
    $verif_caracters = preg_match('#^[a-zA-Z0-9._-]+$#', $ajout_couleur);
    if (!$verif_caracters && (strlen($ajout_couleur < 1) || strlen($ajout_couleur > 20))) {
        $ajout_couleur_echec .= '<strong>Erreur !</strong><br> Le champ Couleur doit contenir entre 1 et 20 caractères alphanumériques.';
        $dataview = 2;
    } else {
        $couleur = executeRequete("SELECT * FROM couleur_produit WHERE produit_couleur='$ajout_couleur'");
        if ($couleur->num_rows > 0) {
            $ajout_couleur_echec .= '<strong>Erreur !</strong><br> La Couleur existe déjà';
            $dataview = 2;
        } else {
            executeRequete("INSERT INTO couleur_produit (produit_couleur) 
            VALUES('$ajout_couleur')");
            $ajout_couleur_succes .= '<strong>Validé !</strong><br> Le Type' . $ajout_couleur . '&nbsp;' .' a bien été ajouté';
            $dataview = 2;
        }
    }
}
?>

    <?php
// Fonction do_action pour supprimer soit un type soit une couleur.
function do_action($action)
{

    if ($action == 'supprimertype') {
        $element = $_GET['element'];

        if (!empty($element)) {
            executeRequete("DELETE FROM type_produit WHERE id_type=$element");
            $suppression_type = '<strong>Supprimé !</strong><br> Type Supprimé';
            return $suppression_type;
            $dataview = 1;
            return $dataview;
        }
    }
    if ($action == 'supprimercouleur') {
        $element = $_GET['element'];

        if (!empty($element)) {
            executeRequete("DELETE FROM couleur_produit WHERE id_couleur=$element");
            $suppression_couleur = '<strong>Supprimé !</strong><br> Couleur Supprimée';
            return $suppression_couleur;
            $dataview = 2;
            return $dataview;
        }
    }

}?>
<?php if (isset($_GET['action']) && !empty($_GET['action'] && $_GET['action'] != 'supprimercouleur')) {
    $suppression_type = do_action($_GET['action']);
}
?><?php if (isset($_GET['action']) && !empty($_GET['action'] && $_GET['action'] != 'supprimertype')) {
    $suppression_couleur = do_action($_GET['action']);
}
?>
<?php require_once('../../includes/navbar.php'); ?>
    <!-- =============================================== -->

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Gestion Type Produit
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
            <div class="box boxgreen">
                <div class="box-header with-border">
                    <h3 class="box-title">Ajouter</h3>

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
                                            <a href="#tab_insert_1" data-toggle="tab" aria-expanded="true">Type</a>
                                        </li>
                                        <li class="">
                                            <a href="#tab_insert_2" data-toggle="tab">Couleur</a>
                                        </li>
                                    </ul>
                                    <div class="tab-content">
                                        <!-- /.tab-pane Ajout Type / Couleur -->
                                        <div class="tab-pane <?php if ($dataview == 1) {

                                            echo 'active'; }  ?>" id="tab_insert_1">

                                            <br>
                                            <form action="#"
                                                  class="myform" method="post" accept-charset="utf-8">
                                                <input type="hidden" name="csrf_sitecom_token"
                                                       value="e9475f8e53f59d2f3b2bbeab3cb56c4e">


                                                <div class="row">
                                                        <div class="row">
                                                            <div class="col-md-6 col-md-offset-2">
                                                                <?php if (isset($ajout_type_echec) && !empty($ajout_type_echec)) { ?>
                                                                    <div class="alert alert-danger center" role="alert">
                                                                        <?php echo $ajout_type_echec ?>
                                                                    </div>
                                                                <?php } ?>
                                                                <?php if (isset($ajout_type_succes) && !empty($ajout_type_succes)) { ?>
                                                                    <div class="alert alert-success center" role="alert">
                                                                        <?php echo $ajout_type_succes ?>
                                                                    </div>
                                                                <?php } ?>
                                                                <?php if (isset($suppression_type) && !empty($suppression_type)) { ?>
                                                                    <div class="alert alert-danger center" role="alert">
                                                                        <?php echo $suppression_type ?>
                                                                    </div>
                                                                <?php } ?>
                                                                <label><i class="fa fa-shopping-bag"></i> Type Produit :</label>
                                                                <div class="input-group">
                                                                    <span class="input-group-addon" id="basic-addon1"><i
                                                                            class="fa fa-bars"></i></span>
                                                                    <input type="text" class="form-control"
                                                                           id="inputnew_type_produit"
                                                                           name="new_type_produit"
                                                                           placeholder="Nouveau Type" value="">
                                                                </div><button name="sub_type" type="submit"
                                                                              class="btn btn-info  pull-right">
                                                                    <i class="fa fa-check"></i> Ajouter
                                                                </button>
                                                                <div class="input-error under-grouped"></div>
                                                            </div>
                                                        </div>
                                                    <hr>
                                                            <div class="col-md-4 col-md-offset-3">
                                                                <label><i class="fa fa-list"></i> Liste Type Produit :</label>
                                                                <div class="border-left bg-gray borderRadius5">

                                                                    <?php
                                                                    $return = '';
                                                                    $tableau = executeRequete("SELECT * FROM type_produit");
                                                                    echo '<table class="table table-bordered"> <tr class="center">';
                                                                    while ($colonne = $tableau->fetch_field()) {
                                                                        echo '<th class="center text-center">' . ucfirst($colonne->name) . '</th>';
                                                                    }
                                                                    echo '<th class="center">Suppression</th>';
                                                                    echo "</tr>";
                                                                    while ($ligne = $tableau->fetch_assoc()) {
                                                                        echo '<tr>';
                                                                        foreach ($ligne as $indice => $information) {
                                                                            echo '<td class="center">' . $information . '</td>';
                                                                        }
                                                                        echo "<td class='center'><i class='fa fa-trash' aria-hidden='true'><a name=\'action\' href=type_produit.php?action=supprimertype&element=" . $ligne['id_type'] . "></i> Suppression</td>";
                                                                        echo '</tr>';
                                                                    }
                                                                    echo '</table>';
                                                                    ?>
                                                                </div>
                                                            </div>






                                                        </div>
                                                <div class="box-footer">
                                                    <?php echo "<b>Total de type(s) : </b> " . $tableau->num_rows; ?>
                                                </div>

                                                        </div>
                                        <div class="tab-pane <?php if ($dataview != 1) {

                                        } echo 'active' ?>" id="tab_insert_2">

                                            <br>
                                            <form action="#"
                                                  class="myform" method="post" accept-charset="utf-8">
                                                <input type="hidden" name="csrf_sitecom_token"
                                                       value="e9475f8e53f59d2f3b2bbeab3cb56c4e">


                                                <div class="row">
                                                    <div class="row">
                                                        <div class="col-md-6 col-md-offset-2">
                                                            <?php if (isset($ajout_couleur_echec) && !empty($ajout_couleur_echec)) { ?>
                                                                <div class="alert alert-danger center" role="alert">
                                                                    <?php echo $ajout_couleur_echec ?>
                                                                </div>
                                                            <?php } ?>
                                                            <?php if (isset($ajout_couleur_succes) && !empty($ajout_couleur_succes)) { ?>
                                                                <div class="alert alert-success center" role="alert">
                                                                    <?php echo $ajout_couleur_succes ?>
                                                                </div>
                                                            <?php } ?>
                                                            <?php if (isset($suppression_couleur) && !empty($suppression_couleur)) { ?>
                                                                <div class="alert alert-danger center" role="alert">
                                                                    <?php echo $suppression_couleur ?>
                                                                </div>
                                                            <?php } ?>
                                                            <label><i class="fa  fa-paint-brush"></i> Couleur Produit :</label>
                                                            <div class="input-group">
                                                                    <span class="input-group-addon" id="basic-addon1"><i
                                                                            class="fa fa-bars"></i></span>
                                                                <input type="text" class="form-control"
                                                                       id="inputnew_couleur_produit"
                                                                       name="new_couleur_produit"
                                                                       placeholder="Nouvelle Couleur" value="">
                                                            </div><button name="sub_couleur" type="submit"
                                                                          class="btn btn-info  pull-right">
                                                                <i class="fa fa-check"></i> Ajouter
                                                            </button>
                                                            <div class="input-error under-grouped"></div>
                                                        </div>
                                                    </div>
                                                    <hr>
                                                    <div class="col-md-4 col-md-offset-2">
                                                        <label><i class="fa fa-list"></i> Liste Couleur Produit :</label>
                                                        <div class="border-left bg-gray borderRadius5">

                                                            <?php
                                                            $return = '';
                                                            $tableau = executeRequete("SELECT * FROM couleur_produit");
                                                            echo '<table class="table table-bordered"> <tr class="center">';
                                                            while ($colonne = $tableau->fetch_field()) {
                                                                echo '<th class="center text-center">' . ucfirst($colonne->name) . '</th>';
                                                            }
                                                            echo '<th class="center">Suppression</th>';
                                                            echo "</tr>";
                                                            while ($ligne = $tableau->fetch_assoc()) {
                                                                echo '<tr>';
                                                                foreach ($ligne as $indice => $information) {
                                                                    echo '<td class="center">' . $information . '</td>';
                                                                }
                                                                echo "<td class='center'><i class='fa fa-trash' aria-hidden='true'><a name=\'action\' href=type_produit.php?action=supprimercouleur&element=" . $ligne['id_couleur'] . "></i> Suppression</td>";
                                                                echo '</tr>';
                                                            }
                                                            echo '</table>';
                                                            ?>
                                                        </div>
                                                    </div>






                                                </div>
                                                <div class="box-footer">
                                                    <?php echo "<b>Total de couleur(s) : </b> " . $tableau->num_rows; ?>
                                                </div>

                                        </div>


                                                    </div>

                                                <br>
                                                </div>


                                            </form>
                                        </div>
                                    </div>
                                    <!-- /.tab-content -->
                                </div>

                    </div>
                    <!-- /.box-body 2 -->
<!-- nav-tabs-custom -->
                            <!-- /.col -->
                        </div>
                        <!-- /.row -->
    </div>
                </div>
                <!-- /.box-body -->
            </div>
            <!-- /.box -->

        </section>
    </div>
    <!-- /.content-wrapper -->

<?php require_once('../../includes/footer.php'); ?>