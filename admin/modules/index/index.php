<?php require_once('../../includes/config.php') ?>
<?php if (internauteEstConnecte() && $_SESSION['membre']['statut'] == 0){
    header('Location:../404.html');
} ?>
<?php

$membres = executeRequete("SELECT * FROM membres");
$demandes = executeRequete("SELECT * FROM demandes");
$stock = '0';
$events = '1';
?>
<?php require_once ('../../includes/navbar.php') ?>
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Tableau de Bord
                <small><strong>P&V</strong> Logistique</small>
            </h1>
            <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-dashboard"></i> Tableau de Bord</a></li>
                <li class="active">Accueil</li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content">
            <!-- Small boxes (Stat box) -->
            <div class="row">
                <div class="col-lg-3 col-xs-6">
                    <!-- small box -->
                    <div class="small-box bg-bleu_azur">
                        <div class="inner">
                            <h3><?php echo $membres->num_rows ?></h3>
                            <p>Membres</p>
                        </div>
                        <div class="icon">
                            <i class="fa fa-users"></i>
                        </div>
                        <a href="../membres/gestion_membre.php" class="small-box-footer">Afficher la liste <i class="fa fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <!-- ./col -->
                <div class="col-lg-3 col-xs-6">
                    <!-- small box -->
                    <div class="small-box bg-bleu_azur2">
                        <div class="inner">
                            <h3><?php echo $demandes->num_rows ?></h3>

                            <p>Demandes</p>
                        </div>
                        <div class="icon">
                            <i class="fa fa-envelope"></i>
                        </div>
                        <a href="../produits/gestion_produits.php" class="small-box-footer">Afficher la liste <i class="fa fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <!-- ./col -->
                <div class="col-lg-3 col-xs-6">
                    <!-- small box -->
                    <div class="small-box bg-creme">
                        <div class="inner">
                            <h3><?php echo $stock ?></h3>

                            <p>Stocks</p>
                        </div>
                        <div class="icon">
                            <i class="fa fa-cubes"></i>
                        </div>
                        <a href="../commandes/gestion_commandes.php" class="small-box-footer">Détails <i class="fa fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <!-- ./col -->
                <div class="col-lg-3 col-xs-6">
                    <!-- small box -->
                    <div class="small-box bg-orange2">
                        <div class="inner">
                            <h3><?php echo $events ?></h3>

                            <p>Evenements en cours</p>
                        </div>
                        <div class="icon">
                            <i class="fa fa-calendar"></i>
                        </div>
                        <a href="#" class="small-box-footer">Gérer <i class="fa fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <!-- ./col -->
            </div>
            <!-- /.row -->
            <!-- Main row -->

        </section>
        <!-- /.content -->
    </div>

    <!-- /.content-wrapper -->
<?php require_once ('../../includes/footer.php') ?>
