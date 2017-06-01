<?php require_once('../../includes/config.php') ?>
<?php require_once('../../includes/navbar.php'); ?>
    <!-- =============================================== -->

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Newsletter
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
                    <h3 class="box-title">Ensemble des Abonnés</h3>
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
                        <div class="row">
                            <div class="col-md-12">
                                <!-- Custom Tabs -->
                                <?php
                                $tableau = executeRequete("SELECT * FROM newsletter");
                                echo '<table class="table table-bordered"> <tr class="center">';
                                        while ($colonne = $tableau->fetch_field()) {
                                        echo '<th class="center text-center">' . ucfirst($colonne->name) . '</th>';
                                        }
                                        echo "</tr>";
                                    while ($ligne = $tableau->fetch_assoc()) {

                                        echo '<tr>';
                                        foreach ($ligne as $indice => $information) {
                                            echo '<td class="text-center">' . $information . '</td>';
                                        }
                                        echo '</tr>';
                                    }
                                    echo '</table>'
                                        ?>
                                    <!-- /.tab-content -->
                                </div>
                                <!-- nav-tabs-custom -->
                            </div>
                            <!-- /.col -->
                        </div>
                        <!-- /.row -->


                <!-- /.box-body -->
            </div>
            <!-- /.box -->

        </section>
    </div>
    <!-- /.content-wrapper -->

<?php require_once('../../includes/footer.php'); ?>