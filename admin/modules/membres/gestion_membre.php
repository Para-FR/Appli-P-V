<?php require_once('../../includes/config.php') ?>
<?php
function do_action_membre($action)
{

    if ($action == 'supprimer') {
        $element = $_GET['element'];

        if (!empty($element)) {
            executeRequete("DELETE FROM membres WHERE id_membre=$element");
            $suppression = '<strong>Supprimé !</strong><br> Utilisateur Supprimé';
            return $suppression;
        }
    }
    if ($action == 'modifier') {
        $element = $_GET['element'];

        if (!empty($element)) {
            executeRequete("SELECT * FROM membres WHERE id_membre=$element");
            $caca = executeRequete("SELECT * FROM membres WHERE id_membre=$element");
            $test = $caca->fetch_assoc();
            //var_dump($test);
            return $test;
        }
    } else {
        $resultat_modifier = '';
        return $resultat_modifier;
    }
}

?>
<?php

if (isset($_POST['sub_admin'])) {
if (isset($_POST['email_admin'])){
        $membre = executeRequete("SELECT * FROM membres WHERE email='$_POST[email_admin]'");
        if ($membre->num_rows > 0) {
            $contenu .= '<strong>Erreur !</strong><br> Le Pseudo existe déjà';
        } else {
            $statut = 1;
            $mdp_crypt = sha1($_POST['password_admin']);
            foreach ($_POST as $indice => $valeur) {
                $_POST[$indice] = htmlentities(addslashes($valeur));
            }
            executeRequete("INSERT INTO membres (nom, prenom, email, mdp, mdp_confirm, statut, deleted) 
            VALUES('$_POST[first_name_admin]', '$_POST[last_name_admin]', '$_POST[email_admin]', '$mdp_crypt', '$mdp_crypt', '$statut', '0')");
            $succes .= '<strong>Validé !</strong><br> L\'administrateur ' . $_POST['first_name_admin'] . '&nbsp;' . $_POST['last_name_admin'] . ' a bien été ajouté';
        }
    }
}
if (isset($_POST['sub_user'])) {
if (isset($_POST['email_user'])){
        $membre = executeRequete("SELECT * FROM membres WHERE email='$_POST[email_user]'");
        if ($membre->num_rows > 0) {
            $contenu .= '<strong>Erreur !</strong><br> L\'email existe déjà';
        } else {
            $statut = 0;
            $mdp_crypt = sha1($_POST['password_user']);
            foreach ($_POST as $indice => $valeur) {
                $_POST[$indice] = htmlentities(addslashes($valeur));
            }
            executeRequete("INSERT INTO membres (nom, prenom, email, mdp, mdp_confirm, statut, deleted) 
            VALUES('$_POST[first_name_user]', '$_POST[last_name_user]', '$_POST[email_user]', '$mdp_crypt', '$mdp_crypt', '$statut', '0')");
            $succes .= '<strong>Validé !</strong><br> L\'utilisateur ' . $_POST['first_name_user'] . '&nbsp;' . $_POST['last_name_user'] . ' a bien été ajouté';


        }

    }
}
if (isset($_POST['sub_modifier_membre'])) {
    $echec_modification_membre = '';
    } if(isset($_POST['email_admin'])) {
        $membre = executeRequete("SELECT * FROM membres WHERE email='$_POST[email_admin]'");
        $motdp = $membre->fetch_assoc();
        if ($membre->num_rows > 1) {
            $echec_modification_membre .= '<strong>Erreur !</strong><br> L\'email existe déjà';
        } else {
            if (empty($_POST['password_admin'])) {
                $mdp_crypt = $motdp['mdp'];
            } else {
                if ($_POST['password_admin'] == $_POST['confirmation_admin']) {
                    $mdp_crypt = sha1($_POST['password_admin']);
                } else {
                    $echec_modification_membre .= '<strong>Erreur !</strong><br> Les mots de passe ne correspondent pas';
                }
            }
            if (isset($echec_modification_membre) && empty($echec_modification_membre)) {
                executeRequete("UPDATE membres SET nom='" . $_POST['first_name_admin'] . "', prenom='" . $_POST['last_name_admin'] . "', email='" . $_POST['email_admin'] . "', mdp= '" . $mdp_crypt . "', mdp_confirm='" . $mdp_crypt . "', statut='" . $_POST['statut_membre'] . "' WHERE id_membre='" . $_GET['element'] . "'");
                $membremodifie = '<strong>Validé !</strong><br> Le membre ' . ucfirst($_POST['first_name_admin']) . '&nbsp;' . ucfirst($_POST['last_name_admin']) . ' a bien été modifié';
                $test = array(
                    "nom" => $_POST['first_name_admin'],
                    "prenom" => $_POST['last_name_admin'],
                    "email" => $_POST['email_admin'],
                    "statut" => $_POST['statut_membre']
                );
            }
        }
}

?>
<?php if (isset($_GET['action']) && !empty($_GET['action'] && $_GET['action'] != 'modifier')) {
    $suppression = do_action_membre($_GET['action']);
}
if (isset($_GET['action']) && !empty($_GET['action'] && $_GET['action'] != 'supprimer')) {
    $test = do_action_membre($_GET['action']);
}
?>
<?php require_once('../../includes/navbar.php'); ?>
    <!-- =============================================== -->

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Gestion des Membres
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
            <div class="box boxgreen collapsed-box">
                <div class="box-header with-border">
                    <h3 class="box-title">Ajouter</h3>
                    <?php if (isset($contenu) && !empty($contenu)) { ?>
                        <div class="alert alert-danger center" role="alert">
                            <?php echo $contenu ?>
                        </div>
                    <?php } ?>
                    <?php if (isset($succes) && !empty($succes)) { ?>
                        <div class="alert alert-success center" role="alert">
                            <?php echo $succes ?>
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
                                            <a href="#tab_insert_1" data-toggle="tab" aria-expanded="true">Administrateur</a>
                                        </li>
                                        <li class="">
                                            <a href="#tab_insert_2" data-toggle="tab"
                                               aria-expanded="false">Utilisateur</a>
                                        </li>
                                    </ul>
                                    <div class="tab-content">
                                        <!-- /.tab-pane ADMINUISTRATEUR -->
                                        <div class="tab-pane active" id="tab_insert_1">

                                            <br>
                                            <form action="#"
                                                  class="myform" method="post" accept-charset="utf-8">
                                                <input type="hidden" name="csrf_sitecom_token"
                                                       value="e9475f8e53f59d2f3b2bbeab3cb56c4e">


                                                <div class="row">
                                                    <div
                                                        class="col-md-10 col-md-offset-1 bg-info paddingTop20 borderRadius5">

                                                        <div class="row">
                                                            <div class="col-md-8 col-md-offset-2">
                                                                <label><i class="fa fa-key"></i> Identifiants :</label>

                                                                <div class="input-group">
                                                                    <span class="input-group-addon" id="basic-addon1"><i
                                                                            class="fa fa-user-circle-o"></i></span>
                                                                    <input type="email" class="form-control"
                                                                           id="inputpseudo_admin" name="pseudo_admin"
                                                                           placeholder="Identifiant" value="">
                                                                </div>
                                                                <div class="input-error under-grouped">
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="row">
                                                            <div class="col-md-4 col-md-offset-2">
                                                                <div class="input-group">
                                                                    <span class="input-group-addon" id="basic-addon1"><i
                                                                            class="fa fa-lock"></i></span>
                                                                    <input type="password" class="form-control"
                                                                           id="inputpassword_admin"
                                                                           name="password_admin"
                                                                           placeholder="Mot de passe" value="">
                                                                </div>
                                                                <div class="input-error under-grouped">
                                                                </div>

                                                            </div>
                                                            <div class="col-md-4">
                                                                <div class="input-group">
                                                                    <span class="input-group-addon" id="basic-addon1"><i
                                                                            class="ion ion-lock-combination"></i></span>
                                                                    <input type="password" class="form-control"
                                                                           id="inputconfirmation_admin"
                                                                           name="confirmation_admin"
                                                                           placeholder="Confirmation du mot de passe"
                                                                           value="">
                                                                </div>
                                                                <div class="input-error under-grouped">
                                                                </div>

                                                            </div>
                                                        </div>


                                                    </div>
                                                </div>

                                                <br>
                                                <div class="col-md-8 col-md-offset-2">
                                                    <label for="sel1">Informations générales :</label>
                                                </div>

                                                <div class="row">
                                                    <div class="col-md-4 col-md-offset-2">
                                                        <div class="input-group">
                                                            <span class="input-group-addon" id="basic-addon1"><i
                                                                    class="fa fa-id-card-o"></i></span>
                                                            <input type="text" class="form-control"
                                                                   id="inputfirst_name_admin" name="first_name_admin"
                                                                   placeholder="Nom" value="">
                                                        </div>
                                                        <div class="input-error under-grouped">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="input-group">
                                                            <span class="input-group-addon" id="basic-addon1"><i
                                                                    class="fa fa-user-circle-o"></i></span>
                                                            <input type="text" class="form-control"
                                                                   id="inputlast_name_admin" name="last_name_admin"
                                                                   placeholder="Prénom" value="">
                                                        </div>
                                                        <div class="input-error under-grouped">
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-md-8 col-md-offset-2">
                                                        <div class="input-group">
                                                            <span class="input-group-addon" id="basic-addon1"><i
                                                                    class="fa fa-envelope"></i></span>
                                                            <input type="text" class="form-control"
                                                                   id="inputemail_admin" name="email_admin"
                                                                   placeholder="Adresse mail" value="">
                                                        </div>
                                                    </div>
                                                </div>

                                                <hr>
                                                <div class="row">
                                                    <div class="col-md-11">

                                                        <button name="sub_admin" type="submit"
                                                                class="btn btn-success  pull-right">
                                                            <i class="fa fa-check"></i> Valider
                                                        </button>
                                                    </div>
                                                </div>


                                            </form>
                                        </div>
                                        <!-- /.tab-pane AEROPORT -->
                                        <div class="tab-pane" id="tab_insert_2">

                                            <br>
                                            <form action="#"
                                                  class="myform" method="post" accept-charset="utf-8">
                                                <input type="hidden" name="csrf_sitecom_token"
                                                       value="e9475f8e53f59d2f3b2bbeab3cb56c4e">


                                                <div class="row">
                                                    <div
                                                        class="col-md-10 col-md-offset-1 bg-info paddingTop20 borderRadius5">

                                                        <div class="row">
                                                            <div class="col-md-8 col-md-offset-2">
                                                                <label><i class="fa fa-key"></i> Identifiants :</label>

                                                                <div class="input-group">
                                                                    <span class="input-group-addon" id="basic-addon1"><i
                                                                            class="fa fa-user-circle-o"></i></span>
                                                                    <input type="email" class="form-control"
                                                                           id="inputpseudo_user" name="pseudo_user"
                                                                           placeholder="Identifiant" value="">
                                                                </div>
                                                                <div class="input-error under-grouped">
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="row">
                                                            <div class="col-md-4 col-md-offset-2">
                                                                <div class="input-group">
                                                                    <span class="input-group-addon" id="basic-addon1"><i
                                                                            class="fa fa-lock"></i></span>
                                                                    <input type="password" class="form-control"
                                                                           id="inputpassword_user"
                                                                           name="password_user"
                                                                           placeholder="Mot de passe" value="">
                                                                </div>
                                                                <div class="input-error under-grouped">
                                                                </div>

                                                            </div>
                                                            <div class="col-md-4">
                                                                <div class="input-group">
                                                                    <span class="input-group-addon" id="basic-addon1"><i
                                                                            class="ion ion-lock-combination"></i></span>
                                                                    <input type="password" class="form-control"
                                                                           id="inputconfirmation_user"
                                                                           name="confirmation_user"
                                                                           placeholder="Confirmation du mot de passe"
                                                                           value="">
                                                                </div>
                                                                <div class="input-error under-grouped">
                                                                </div>

                                                            </div>
                                                        </div>


                                                    </div>
                                                </div>

                                                <br>
                                                <div class="col-md-8 col-md-offset-2">
                                                    <label for="sel1">Informations générales :</label>
                                                </div>

                                                <div class="row">
                                                    <div class="col-md-4 col-md-offset-2">
                                                        <div class="input-group">
                                                            <span class="input-group-addon" id="basic-addon1"><i
                                                                    class="fa fa-id-card-o"></i></span>
                                                            <input type="text" class="form-control"
                                                                   id="inputfirst_name_user" name="first_name_user"
                                                                   placeholder="Nom" value="">
                                                        </div>
                                                        <div class="input-error under-grouped">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="input-group">
                                                            <span class="input-group-addon" id="basic-addon1"><i
                                                                    class="fa fa-user-circle-o"></i></span>
                                                            <input type="text" class="form-control"
                                                                   id="inputlast_name_user" name="last_name_user"
                                                                   placeholder="Prénom" value="">
                                                        </div>
                                                        <div class="input-error under-grouped">
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-md-8 col-md-offset-2">
                                                        <div class="input-group">
                                                            <span class="input-group-addon" id="basic-addon1"><i
                                                                    class="fa fa-envelope"></i></span>
                                                            <input type="text" class="form-control"
                                                                   id="inputemail_user" name="email_user"
                                                                   placeholder="Adresse mail" value="">
                                                        </div>
                                                    </div>
                                                </div>

                                                <hr>
                                                <div class="row">
                                                    <div class="col-md-11">

                                                        <button name="sub_user" type="submit"
                                                                class="btn btn-success  pull-right">
                                                            <i class="fa fa-check"></i> Valider
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
            <!-- ./Box Modif -->
            <!-- Box Modification -->
            <?php if (!empty($test)) { ?>
                <div class="box boxorange">
                    <div class="box-header with-border">
                        <h3 class="box-title">Modifier</h3>


                        <?php if (isset($membremodifie) && !empty($membremodifie)) { ?>
                            <div class="alert alert-success center" role="alert">
                                <?php echo $membremodifie ?>
                            </div>
                        <?php } ?>

                        <?php if (isset($echec_modification_membre) && !empty($echec_modification_membre)) { ?>
                            <div class="alert alert-danger center" role="alert">
                                <?php echo $echec_modification_membre ?>
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
                                                        class="fa fa-plus"></i> Membre : <?php echo $test['nom'] ?>  &nbsp;  <?php echo $test['prenom'] ?>
                                                </a>
                                            </li>
                                        </ul>
                                        <div class="tab-content">
                                            <!-- /.tab-pane Modifier -->
                                            <div class="tab-pane active" id="tab_insert_1">

                                                <br>
                                                <form action="#"
                                                      class="myform" method="post" accept-charset="utf-8">
                                                    <input type="hidden" name="csrf_sitecom_token"
                                                           value="e9475f8e53f59d2f3b2bbeab3cb56c4e">


                                                    <div class="row">
                                                        <div
                                                            class="col-md-10 col-md-offset-1 bg-info paddingTop20 borderRadius5">

                                                            <div class="row">
                                                                <div class="col-md-8 col-md-offset-2">
                                                                    <label><i class="fa fa-key"></i> Identifiants
                                                                        :</label>

                                                                    <div class="input-group">
                                                                    <span class="input-group-addon" id="basic-addon1"><i
                                                                            class="fa fa-user-circle-o"></i></span>
                                                                        <input type="email" class="form-control"
                                                                               id="inputidentifiant_admin"
                                                                               name="identifiant_admin"
                                                                               placeholder="Identifiant"
                                                                               value="<?php echo $test['email'] ?>">
                                                                    </div>
                                                                    <div class="input-error under-grouped">
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="row">
                                                                <div class="col-md-4 col-md-offset-2">
                                                                    <div class="input-group">
                                                                    <span class="input-group-addon" id="basic-addon1"><i
                                                                            class="fa fa-lock"></i></span>
                                                                        <input type="password" class="form-control"
                                                                               id="inputpassword_admin"
                                                                               name="password_admin"
                                                                               placeholder="Mot de passe" value="">
                                                                    </div>
                                                                    <div class="input-error under-grouped">
                                                                    </div>

                                                                </div>
                                                                <div class="col-md-4">
                                                                    <div class="input-group">
                                                                    <span class="input-group-addon" id="basic-addon1"><i
                                                                            class="ion ion-lock-combination"></i></span>
                                                                        <input type="password" class="form-control"
                                                                               id="inputconfirmation_admin"
                                                                               name="confirmation_admin"
                                                                               placeholder="Confirmation du mot de passe"
                                                                               value="">
                                                                    </div>
                                                                    <div class="input-error under-grouped">
                                                                    </div>

                                                                </div>
                                                            </div>


                                                        </div>
                                                    </div>

                                                    <br>
                                                    <div class="col-md-8 col-md-offset-2">
                                                        <label for="sel1">Informations générales :</label>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-md-4 col-md-offset-2">
                                                            <div class="input-group">
                                                            <span class="input-group-addon" id="basic-addon1"><i
                                                                    class="fa fa-id-card-o"></i></span>
                                                                <input type="text" class="form-control"
                                                                       id="inputfirst_name_admin"
                                                                       name="first_name_admin"
                                                                       placeholder="Nom"
                                                                       value="<?php echo $test['nom'] ?>">
                                                            </div>
                                                            <div class="input-error under-grouped">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="input-group">
                                                            <span class="input-group-addon" id="basic-addon1"><i
                                                                    class="fa fa-user-circle-o"></i></span>
                                                                <input type="text" class="form-control"
                                                                       id="inputlast_name_admin" name="last_name_admin"
                                                                       placeholder="Prénom"
                                                                       value="<?php echo $test['prenom'] ?>">
                                                            </div>
                                                            <div class="input-error under-grouped">
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-md-8 col-md-offset-2">
                                                            <div class="input-group">
                                                            <span class="input-group-addon" id="basic-addon1"><i
                                                                    class="fa fa-envelope"></i></span>
                                                                <input type="text" class="form-control"
                                                                       id="inputemail_admin" name="email_admin"
                                                                       placeholder="Adresse mail"
                                                                       value="<?php echo $test['email'] ?>">
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-md-8 col-md-offset-2">
                                                            <label for="sel1">Statut :</label>

                                                            <div class="input-group">
                                                            <span class="input-group-addon" id="basic-addon1"><i
                                                                    class="fa fa-users"></i></span>

                                                                <select name="statut_membre" class="form-control"
                                                                        required>
                                                                    <option value="1">Administrateur</option>
                                                                    <option value="0" <?php if ($test['statut'] == 0) {
                                                                        echo 'selected';
                                                                    } ?>>Utilisateur
                                                                    </option>
                                                                </select>
                                                            </div>
                                                            <div class="input-error under-grouped">
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <hr>
                                                    <div class="row">
                                                        <div class="col-md-11">

                                                            <button name="sub_modifier_membre" type="submit"
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

            <?php } ?>
            <!-- ./Box Modification -->
            <!-- Default box 2 -->
            <div class="box boxblue">
                <div class="box-header with-border">
                    <h3 class="box-title">Ensemble des utilisateurs</h3>
                    <?php if (isset($suppression) && !empty($suppression)) { ?>
                        <div class="alert alert-danger center" role="alert">
                            <?php echo $suppression ?>
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
                    $tableau = executeRequete("SELECT id_membre, nom, prenom, email, statut, deleted FROM membres");
                    echo '<table id="membres" cellspacing="0" class="table table-bordered display"> <thead> <tr class="center">';
                    while ($colonne = $tableau->fetch_field()) {
                        echo '<th class="center text-center">' . ucfirst($colonne->name) . '</th>';
                    }
                    echo '<th class="center">Modification</th>';
                    echo '<th class="center">Suppression</th>';
                    echo '</thead>';
                    echo "</tr>";
                    while ($ligne = $tableau->fetch_assoc()) {
                        echo '<tr>';
                        foreach ($ligne as $indice => $information) {
                            echo '<td class="center">' . $information . '</td>';
                        }
                        echo "<td class='center'><i class='fa fa-pencil' aria-hidden='true'><a name=\'action\' href=gestion_membre.php?action=modifier&element=" . $ligne['id_membre'] . "></i> Modification</td>";
                        echo "<td class='center'><i class='fa fa-trash' aria-hidden='true'><a name=\'action\' href=gestion_membre.php?action=supprimer&element=" . $ligne['id_membre'] . "></i> Suppression</td>";
                        echo '</tr>';
                    }
                    echo '</table>';
                    ?>
                </div>
                <!-- /.box-body 2 -->
                <div class="box-footer">
                    <?php echo "<b>Total d'utilisateurs : </b> " . $tableau->num_rows; ?>
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
            $('#membres').DataTable({
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