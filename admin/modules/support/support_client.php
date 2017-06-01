<?php require_once('../../includes/config.php') ?>
<?php
function do_action_support($action)
{
    if ($action == 'consulter') {
        $element = $_GET['element'];
        if (!empty($element)) {
            $consult = executeRequete("
            SELECT * FROM contact WHERE id_contact='" . $_GET['element'] . "'");
            $consulter = $consult->fetch_assoc();
            return $consulter;

        }
    }

    if ($action == 'supprimer') {
        $element = $_GET['element'];

        if (!empty($element)) {
            executeRequete("DELETE FROM contact WHERE id_contact=$element");
            $suppression = '<strong>Supprimé !</strong><br> Message Supprimé';
            return $suppression;
        }
    }
    if ($action == 'attente') {
        $element = $_GET['element'];
        $attente = 'En Attente';
        if (!empty($element)) {
            executeRequete("UPDATE contact SET statut='" . $attente . "' WHERE id_contact='" . $_GET['element'] . "'");
        }
    }
    if ($action == 'traitement') {
        $element = $_GET['element'];
        $traitement = 'En cours de traitement';
        if (!empty($element)) {
            executeRequete("UPDATE contact SET statut='" . $traitement . "' WHERE id_contact='" . $_GET['element'] . "'");
        }
    }
    if ($action == 'traite') {
        $element = $_GET['element'];
        $traite = 'Traité';
        if (!empty($element)) {
            executeRequete("UPDATE contact SET statut='" . $traite . "' WHERE id_contact='" . $_GET['element'] . "'");
        }
    }
}

?>
<?php if (isset($_GET['action']) && !empty($_GET['action']) && $_GET['action'] == 'supprimer') {
    $suppression = do_action_support($_GET['action']);
} ?>
<?php if (isset($_GET['action']) && !empty($_GET['action']) && $_GET['action'] == 'traitement') {
    $traitement = do_action_support($_GET['action']);
} ?>
<?php if (isset($_GET['action']) && !empty($_GET['action']) && $_GET['action'] == 'traite') {
    $traite = do_action_support($_GET['action']);
} ?>
<?php if (isset($_GET['action']) && !empty($_GET['action']) && $_GET['action'] == 'attente') {
    $attente = do_action_support($_GET['action']);
} ?>
<?php if (isset($_GET['action']) && !empty($_GET['action']) && $_GET['action'] == 'consulter') {
    $consulter = do_action_support($_GET['action']);
} ?>
<?php require_once('../../includes/navbar.php'); ?>
<!-- =============================================== -->

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Gestion des Tickets
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
                <h3 class="box-title">Boîte de Reception</h3>
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
                $tableau = executeRequete("SELECT * FROM contact");
                echo '<table class="table table-bordered"> <tr class="center">';
                while ($colonne = $tableau->fetch_field()) {
                    echo '<th class="center text-center">' . ucfirst($colonne->name) . '</th>';
                }
                echo '<th class="center">Action</th>';
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
                <li><a name='attente' href='support_client.php?action=attente&element=" . $ligne['id_contact'] . "'>En Attente</a></li>
                <li><a name='livraison' href='support_client.php?action=traitement&element=" . $ligne['id_contact'] . "'>En cours de traitement</a></li>
                <li><a name='livree' href='support_client.php?action=traite&element=" . $ligne['id_contact'] . "'>Traité</a></li>
            </ul>

            <a name=\'action\' href=support_client.php?action=consulter&element=" . $ligne['id_contact'] . " class=\"btn btn-azur btn-xs\">
            <i class=\"fa fa-eye\"></i>
            </a>
            <a name=\'action\' href=support_client.php?action=supprimer&element=" . $ligne['id_contact'] . " class=\"btn btn-danger btn-xs\">
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

                <?php echo "<b>Total de message(s) : </b> " . $tableau->num_rows; ?>
            </div>
            <!-- /.box-footer 2-->
        </div>
        <!-- /.box 2 -->

        <!-- Box Consulter -->
        <?php if (!empty($consulter)) { ?>
            <div class="box boxazur">
                <div class="box-header with-border">
                    <h3 class="box-title">Demande n° <?php echo $consulter['id_contact'] ?> &nbsp; Enregistrée le
                        : <?php echo $consulter['date_contact'] ?></h3>
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
                                <p><i class="fa fa-user"></i> <?php echo ucfirst($consulter['name_contact']) ?></p>
                                    <p><i class="fa fa-envelope"></i> <?php echo $consulter['email_contact'] ?></p>


                            </div>
                            <div class="col-md-4 bg-bleu_azur2 pull-right pad5 borderRadius5 text-center">
                                <p>Statut : <br><?php echo ucfirst($consulter['statut']) ?></p>
                            </div>
                            <div class="input-error under-grouped">
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-md-12 text-center">
                            <h4><p><i class="fa fa-commenting-o"> </i> Sujet : <?php echo ucfirst($consulter['sujet_contact']) ?></p></h4>
                        </div>

                        <div class=" col-md-offset-2 col-md-8 bg-bleu_azur pad5 borderRadius5">
                            <p><i class="fa fa-user"></i> <?php echo ucfirst($consulter['name_contact']) ?> : <?php echo ucfirst($consulter['message_contact']) ?></p>
                        </div>
                    </div>
                </div>
                <!-- /.box-body 2 -->
                <div class="box-footer">

                </div>
                <!-- /.box-footer 2-->
            </div>
        <?php } ?>
        <!-- ./ Box Consulter -->

        <!-- /.content-wrapper -->
    </section>
</div>

<?php require_once('../../includes/footer.php'); ?>
