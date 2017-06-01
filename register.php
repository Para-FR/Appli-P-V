<?php require_once('./admin/includes/config.php') ?>
<?php
if (internauteEstConnecte()) {
    header('Location:admin/modules/index/index.php');
}
if (isset($_POST['sub_register'])) {

    $membre = executeRequete("SELECT * FROM membres WHERE email='$_POST[email]'");
    if ($membre->num_rows > 0) {
        $contenu .= '<strong>Erreur !</strong><br> Le Pseudo existe déjà';
    } else {
        $mdp_crypt = sha1($_POST['mdp']);
        $mdp_crypt_confirm = sha1($_POST['mdp_confirm']);
        foreach ($_POST as $indice => $valeur) {
            $_POST[$indice] = htmlentities(addslashes($valeur));
        }
        executeRequete("INSERT INTO membres (nom, prenom, email, mdp, mdp_confirm, statut, deleted) 
            VALUES('$_POST[nom]', '$_POST[prenom]', '$_POST[email]', '$mdp_crypt', '$mdp_crypt_confirm', '0', '0')");
        $succes .= '<strong>Validé !</strong><br> Vous êtes désormais inscrit <br> <a href="login.php">Connectez vous</a>';
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Pierre & Vacances - Logistique</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.7 -->
    <link rel="stylesheet" href="admin/bootstrap/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="admin/dist/css/AdminLTE.min.css">
    <!-- iCheck -->
    <link rel="stylesheet" href="admin/plugins/iCheck/square/blue.css">
    <!-- Refonte CSS -->
    <link rel="stylesheet" href="./admin/dist/css/master.css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    <!-- Google Font -->
    <link rel="stylesheet"
          href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>
<body class="hold-transition register-page">
<div class="register-box">
    <div class="register-logo">
        <a href="../../index2.html"><b>P&V</b> Logistique</a>
    </div>

    <div class="register-box-body">
        <p class="login-box-msg">S'enregistrer</p>
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

        <form action="#" method="post">
            <div class="form-group has-feedback">
                <input name="nom" type="text" class="form-control" placeholder="Nom" required>
                <span class="fa fa-id-card-o form-control-feedback"></span>
            </div>
            <div class="form-group has-feedback">
                <input name="prenom" type="text" class="form-control" placeholder="Prénom" required>
                <span class="glyphicon glyphicon-user form-control-feedback"></span>
            </div>
            <div class="form-group has-feedback">
                <input name="email" type="email" class="form-control" placeholder="Adresse Mail" required>
                <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
            </div>
            <div class="form-group has-feedback">
                <input name="mdp" type="password" class="form-control" placeholder="Mot de Passe" required>
                <span class="glyphicon glyphicon-lock form-control-feedback"></span>
            </div>
            <div class="form-group has-feedback">
                <input name="mdp_confirm" type="password" class="form-control"
                       placeholder="Confirmation Mot de Passe" required>
                <span class="glyphicon glyphicon-log-in form-control-feedback"></span>
            </div>
            <div class="row">

                <!-- /.col -->
                <div class="col-xs-offset-4 col-xs-4">
                    <button name="sub_register" type="submit"
                            class="btn btn-primary btn-block btn-flat text-center col">S'inscrire
                    </button>
                </div>
                <!-- /.col -->
            </div>
        </form>

        <p class="paddingTop20 text-center">Déjà un compte ? <a href="login.php" class="text-center paddingTop20"> Se
                Connecter</a></p>
    </div>
    <!-- /.form-box -->
</div>
<!-- /.register-box -->

<!-- jQuery 3.1.1 -->
<script src="./admin/plugins/jQuery/jquery-3.1.1.min.js"></script>
<!-- Bootstrap 3.3.7 -->
<script src="./admin/bootstrap/js/bootstrap.min.js"></script>
<!-- iCheck -->
<script src="./admin/plugins/iCheck/icheck.min.js"></script>
<script>
    $(function () {
        $('input').iCheck({
            checkboxClass: 'icheckbox_square-blue',
            radioClass: 'iradio_square-blue',
            increaseArea: '20%' // optional
        });
    });
</script>
</body>
</html>
