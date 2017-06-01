<?php require_once ('./admin/includes/config.php')?>
<?php
if (isset($_POST['connect'])) {
    $resultat = executeRequete("SELECT * FROM membres WHERE email='$_POST[email]'");
    if ($resultat->num_rows != 0) {
        $membre = $resultat->fetch_assoc();
        if ($membre['mdp'] == sha1($_POST['mdp'])) {
            foreach ($membre as $indice => $element) {
                if ($indice != 'mdp') {
                    $_SESSION['membre'][$indice] = $element;
                }
            }
            header("location:./admin/modules/index/index.php");
        } else {
            $contenu = '<strong>Erreur !</strong><br> Combinaison Pseudo et Mot de Passe incorrect.';
        }
    } else {
        $contenu = '<strong>Erreur !</strong><br> Combinaison Pseudo et Mot de Passe incorrect.';
    }
} ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>P & V - Connexion</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.7 -->
    <link rel="stylesheet" href="./admin/bootstrap/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="./admin/dist/css/AdminLTE.min.css">
    <!-- iCheck -->
    <link rel="stylesheet" href="./admin/plugins/iCheck/square/blue.css">

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
<body class="hold-transition login-page">
<div class="login-box">
    <div class="login-logo">
        <a href="../../index2.html"><b>P&V</b> Logistique</a>
    </div>
    <!-- /.login-logo -->
    <div class="login-box-body">
        <p class="login-box-msg">Connectez-vous</p>

        <form action="#" method="post">
            <div class="form-group has-feedback">
                <input name="email" type="email" class="form-control" placeholder="Adresse Mail">
                <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
            </div>
            <div class="form-group has-feedback">
                <input name="mdp" type="password" class="form-control" placeholder="Mot de Passe">
                <span class="glyphicon glyphicon-lock form-control-feedback"></span>
            </div>
            <div class="row">
                <!-- /.col -->
                <div class="col-xs-offset-4 col-xs-4">
                    <button name="connect" type="submit" class="btn btn-primary btn-flat ">Se Connecter</button>
                </div>
                <!-- /.col -->
            </div>
        </form>
        <hr>
        <div class="text-center">
            <a href="#">Mot de Passe Oublié ?</a><br>
            <a href="register" class="text-center">S'inscrire</a>
        </div>


    </div>
    <!-- /.login-box-body -->
</div>
<!-- /.login-box -->

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
