<?php

    session_start();
    if(isset($_SESSION['username'])){
        header('location:admin-dashboard.php');
        exit();

    }
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | Admin</title>
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.4.1/css/bootstrap.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" />

    <style>
        .vertical-center {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .card {
            width: 100%;
        }
    </style>
</head>
<body class="bg-dark">
    <div class="container vertical-center">
        <div class="row w-100 justify-content-center">
            <div class="col-lg-5">
                <div class="card border-danger shadow-lg">
                    <div class="card-header bg-danger">
                        <h3 class="m-0 text-white">
                            <i class="fas fa-user-cog"></i>&nbsp;Admin Panel Login
                        </h3>
                    </div>
                    <div class="card-body bg-light">
                        <form id="admin-login-form">
                            <div id="adminLoginAlert"></div>
                            <div class="form-group">
                                <label for="username">Username</label>
                                <input type="text" class="form-control form-control-lg rounded-0" id="username" name="username" placeholder="Enter username" required>
                            </div>
                            <div class="form-group">
                                <label for="password">Password</label>
                                <input type="password" class="form-control form-control-lg rounded-0" id="password" name="password" placeholder="Password" required>
                            </div>
                            <div class="form-group">
                                <input type="button" class="btn btn-danger btn-block btn-lg rounded-0" value="Login" id="adminLoginBtn">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>

    <script type="text/javascript">
    $(document).ready(function(){
        $("#adminLoginBtn").click(function(e){
            e.preventDefault();

            if($("#admin-login-form")[0].checkValidity()){
                $(this).val('Please Wait...');
                $.ajax({
                    url: 'assets/php/admin-action.php',
                    method: 'post',
                    data: $("#admin-login-form").serialize() + '&action=adminLogin',
                    success: function(response){
                        if(response === 'admin_login'){
                            window.location = 'admin-dashboard.php'
                        }
                        else{
                            $("#adminLoginAlert").html(response);


                        }

                        $("#adminLoginBtn").val('Login');
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        console.error("AJAX error: " + textStatus + ' : ' + errorThrown);
                    }
                });
            }
        });
    });
    </script>

</body>
</html>
