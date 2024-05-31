<?php
session_start();
if(!isset($_SESSION['username'])){
    header('location:index.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php
        // Obtener el nombre del archivo actual sin la extensión .php
        $title = basename($_SERVER['PHP_SELF'], '.php');
        // Separar el nombre del archivo en partes divididas por un guion
        $titleParts = explode('-', $title);
        // Capitalizar la primera letra de la segunda parte
        $title = isset($titleParts[1]) ? ucfirst($titleParts[1]) : 'Admin Panel';
    ?>
    <title><?php echo $title; ?> | Admin Panel</title>
    <link rel="stylesheet" type="text/css" href="https://cdnjs.datatables.net/v/bs4/dt-1.10.20/datatables.min.css" />

    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.4.1/css/bootstrap.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" />
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function(){
            $("#open-nav").click(function(){
                $(".admin-nav").toggleClass('animate');
            });
        });
    </script>
    <style type="text/css">
        .admin-nav {
            width: 220px;
            min-height: 100vh;
            overflow: hidden;
            background-color: #343a40;
            transition: 0.3s all ease-in-out;
        }

        .admin-link {
            background-color: #343a40;
        }

        .admin-link:hover, .nav-active {
            background-color: #212529;
            text-decoration: none;
        }

        .animate {
            width: 0;
            transition: 0.3s all ease-in-out;
        }
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <div class="admin-nav p-0">
                <h4 class="text-light text-center p-2">Admin Panel</h4>
                <div class="list-group list-group-flush">
                    <a href="admin-dashboard.php" class="list-group-item text-light admin-link <?= (basename($_SERVER['PHP_SELF']) == 'admin-dashboard.php') ? 'nav-active' : ''; ?>">
                        <i class="fas fa-chart-pie"></i>&nbsp;&nbsp;Dashboard
                    </a>
                    <a href="admin-users.php" class="list-group-item text-light admin-link
                    <?= (basename($_SERVER['PHP_SELF']) == 'admin-users.php') ? 'nav-active' : ''; ?>">
                        <i class="fas fa-user-friends"></i>&nbsp;&nbsp;Users
                    </a>

                    <a href="admin-notes.php" class="list-group-item text-light admin-link">
                        <i class="fas fa-building"></i>&nbsp;&nbsp;Buildings
                    </a>
                    <a href="admin-deleteduser.php" class="list-group-item text-light admin-link <?= (basename($_SERVER['PHP_SELF']) == 'admin-deleteduser.php') ? 'nav-active' : ''; ?>">
                            <i class="fas fa-user-slash"></i>&nbsp;&nbsp;Deleted Users
                        </a>

                        <a href="admin-exportuser.php" class="list-group-item text-light admin-link <?= (basename($_SERVER['PHP_SELF']) == 'admin-exportuser.php') ? 'nav-active' : ''; ?>">
                            <i class="fas fa-table"></i>&nbsp;&nbsp;Export Users
                        </a>

                        <a href="admin-profile.php" class="list-group-item text-light admin-link <?= (basename($_SERVER['PHP_SELF']) == 'admin-profile.php') ? 'nav-active' : ''; ?>">
                            <i class="fas fa-id-card"></i>&nbsp;&nbsp;Profile
                        </a>

                    <a href="admin-setting.php" class="list-group-item text-light admin-link <?= (basename($_SERVER['PHP_SELF']) == 'admin-setting.php') ? 'nav-active' : ''; ?>">
                        <i class="fas fa-cog"></i>&nbsp;&nbsp;Settings
                    </a>
                </div>
            </div>
            <div class="col">
                <div class="row">
                    <div class="col-lg-12 bg-primary pt-2 justify-content-between d-flex">
                        <a href="#" class="text-white" id="open-nav"><h3><i class="fas fa-bars"></i></h3></a>
                        <h4 class="text-light"><?= $title; ?></h4>
                        <a href="assets/php/logout.php" class="text-light mt-1">
                            <i class="fas fa-sign-out-alt"></i>&nbsp;Logout
                        </a>
                    </div>
                </div>