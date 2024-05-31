<?php
    require_once 'assets/php/session.php';
?>


<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title><?= ucfirst(basename($_SERVER['PHP_SELF'], '.php')) ?></title>
    <!-- Bootstrap 4 CSS CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.min.css" />
    <!-- Fontawesome CSS CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.14.0/css/all.min.css" />
    <link rel="stylesheet" href="css/style.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.4.1/css/bootstrap.min.css" />

    <link href="https://cdn.datatables.net/v/bs4/dt-2.0.7/datatables.min.css" rel="stylesheet">
    <style type="text/css">
        @import url("https://fonts.googleapis.com/css?family=Maven+Pro:400,500,600,700,800,900&display=swap");    
        *{
            font-family: 'Maven Pro', sans-serif;
        }

        .dropdown-item {
    padding: 10px 20px; /* Puedes ajustar estos valores según tus preferencias */
}
    </style>

<script async src="https://www.googletagmanager.com/gtag/js?id=UA-151025138-1"></script>
<link href="css/bootstrap.css" type="text/css" rel="stylesheet">

    <!-- Add custom CSS here -->
    <link href="css/art-risk.css?v=1" type="text/css" rel="stylesheet">
  </head>
  <body>
  <nav class="navbar navbar-default" role="navigation">
    <!--<a class="navbar-brand" href="index.php"><i class="fas fa-code fa-lg"></i>&nbsp;&nbsp;Code </a>-->
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="index.html">Art-Risk</a>
        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse navbar-ex1-collapse">
    <ul class="nav navbar-nav">
        <li><a href="index.html">Inicio</a></li>
        <li><a href="guia.html">Guia</a></li>
        <li><a href="herramienta.html">Herramienta</a></li>
        <li><a href="contacto.html">Contacto</a></li>
        <li class="nav-item dropdown">
            <a href="#" class="nav-link dropdown-toggle" id="navbardrop" data-toggle="dropdown">
                <i class="fas fa-user-cog"></i> &nbsp;Hi! <?= $users; ?>
            </a>
            <div class="dropdown-menu">
                <a href="#" class="dropdown-item"><i class="fas fa-cog"></i>&nbsp;Setting</a>
                <a href="profile.php" class="dropdown-item"><i class="fas fa-user-circle"></i>&nbsp;Profile</a>

                <a href="assets/php/logout.php" class="dropdown-item"><i class="fas fa-sign-out-alt"></i>&nbsp;Logout</a>


            </div>
        </li>
    </ul>
</div>

        <!-- /.navbar-collapse -->
    </div>
    <!-- /.container -->
</nav>