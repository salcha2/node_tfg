<?php
require_once 'assets/php/head.php';
require_once 'assets/php/session.php';

// Iniciar la sesión si no está ya iniciada
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Obtener el nombre de usuario desde la sesión
$username = isset($_SESSION['usuario']) ? $_SESSION['usuario'] : 'Nombre de usuario no disponible';

// Depuración por consola
echo '<script>';
echo 'console.log("Nombre de usuario desde la sesión:", ' . json_encode($username) . ');';
echo '</script>';
?>
<style>
/* Estilos personalizados */
</style>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card rounded-0 mt-3 border-primary">
                <div class="card-header border-primary">
                    <ul class="nav nav-tabs card-header-tabs">
                        <li class="nav-item">
                            <a href="#profile" class="nav-link active font-weight-bold" data-toggle="tab">Profile</a>
                        </li>
                        <li class="nav-item">
                            <a href="#editProfile" class="nav-link font-weight-bold" data-toggle="tab">Edit Profile</a>
                        </li>
                        <li class="nav-item">
                            <a href="#changePass" class="nav-link font-weight-bold" data-toggle="tab">Change Password</a>
                        </li>
                    </ul>
                </div>
                <div class="card-body">
                    <div class="tab-content">
                        <!-- Profile Tab Content Start -->
                        <div class="tab-pane fade show active" id="profile">
                            <!-- Profile content goes here -->
                            <div class="card-deck">
                                <div class="card border-primary">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="card-header bg-primary text-light text-center lead">
                                                    User Id: <?= $cid; ?>
                                                </div>
                                                <p class="card-text p-2 m-1 rounded" style="border:1px solid #0275d8;"><b>Name : </b><?= $cname ?></p>
                                                <p class="card-text p-2 m-1 rounded" style="border:1px solid #0275d8;"><b>Email : </b><?= $cemail ?></p>
                                                <p class="card-text p-2 m-1 rounded" style="border:1px solid #0275d8;"><b>Gender : </b><?= $cgender ?></p>
                                                <p class="card-text p-2 m-1 rounded" style="border:1px solid #0275d8;"><b>Date of Birthday : </b><?= $cdob ?></p>
                                                <p class="card-text p-2 m-1 rounded" style="border:1px solid #0275d8;"><b>Phone : </b><?= $cphone ?></p>
                                                <p class="card-text p-2 m-1 rounded" style="border:1px solid #0275d8;"><b>Registered On : </b><?= $reg_on ?></p>
                                                <p class="card-text p-2 m-1 rounded" style="border:1px solid #0275d8;"><b>E-mail Verified : </b><?= $verified ?>
                                                    <?php if($verified == 'Not Verified!'): ?>
                                                        <a href="" id="verify-email" class="float-right">Verify Now</a>
                                                    <?php endif; ?>
                                                </p>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="card border-primary align-self-center">
                                                    <?php if(!$cphoto): ?>
                                                        <img src="assets/img/profile.png" class="img-thumbnail img-fluid" width="408px">
                                                    <?php else: ?>
                                                        <img src="<?= 'assets/php/'.$cphoto; ?>" class="img-thumbnail img-fluid" width="408px">
                                                    <?php endif; ?>
                                                </div>     
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Profile Tab Content End -->

                        <!-- Edit Profile Tab Content Start -->
                        <div class="tab-pane fade" id="editProfile">
                            <!-- Edit Profile content goes here -->
                            <div class="card-deck">
                                <div class="card border-danger align-self-center">
                                    <?php if(!$cphoto): ?>
                                        <img src="assets/img/profile.png" class="img-thumbnail img-fluid" width="408px">
                                    <?php else: ?>
                                        <img src="<?= 'assets/php/'.$cphoto; ?>" class="img-thumbnail img-fluid" width="408px">
                                    <?php endif; ?>
                                </div>
                                <div class="card-body">
                                    <!-- Aquí puedes agregar el formulario o contenido para editar el perfil -->
                                    <form action="" method="post" enctype="multipart/form-data" id="profile-update-form">
                                        <input type="hidden" name="oldimage" value="<?= $cphoto; ?>">
                                        <div class="form-group m-0">
                                            <label for="profilePhoto" class="m-1">Upload Profile Image</label>
                                            <input type="file" name="image" id="profilePhoto">
                                        </div>
                                        <div class="form-group">
                                            <label for="name">Name:</label>
                                            <input type="text" name="name" id="name" class="form-control" value="<?= $cname; ?>" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="email">Email:</label>
                                            <input type="email" name="email" id="email" class="form-control" value="<?= $cemail; ?>" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="gender">Gender:</label>
                                            <select name="gender" id="gender" class="form-control" required>
                                                <option value="Male" <?= $cgender == 'Male' ? 'selected' : ''; ?>>Male</option>
                                                <option value="Female" <?= $cgender == 'Female' ? 'selected' : ''; ?>>Female</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="dob">Date of Birth:</label>
                                            <input type="date" name="dob" id="dob" class="form-control" value="<?= $cdob; ?>" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="phone">Phone:</label>
                                            <input type="text" name="phone" id="phone" class="form-control" value="<?= $cphone; ?>" required>
                                        </div>
                                        <button type="submit" value="Update Profile" class="btn btn-danger btn-block" id="profileUpdateBtn" name="profile_update">Update Profile</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <!-- Edit Profile Tab Content End -->

                        <div class="tab-pane fade" id="changePass">
    <div class="card-deck">
        <div class="card border-success">
            <div class="card-header bg-success text-white text-center lead">
                Change Password
            </div>
            <div class="card-body">
                <form action="#" method="post" class="px-3 mt-2" id="change-pass-form">
                    <div class="form-group">
                        <label for="curpass">Enter Your Current Password</label>
                        <input type="password" name="curpass" placeholder="Current Password" class="form-control form-control-lg" id="curpass" required minlength="5">
                    </div>

                    <div class="form-group">
                        <label for="newpass">Enter New Password</label>
                        <input type="password" name="newpass" placeholder="New Password" class="form-control form-control-lg" id="newpass" required minlength="5">
                    </div>

                    <div class="form-group">
                        <label for="cnewpass">Confirm New Password</label>
                        <input type="password" name="cnewpass" placeholder="Confirm New Password" class="form-control form-control-lg" id="cnewpass" required minlength="5">
                    </div>

                    <div class="form-group">
                        <p id="changepassError" class="text-danger"></p>
                    </div>

                    <div class="form-group text-center">
                        <input type="submit" name="changepass" value="Change Password" class="btn btn-success btn-lg rounded-pill" id="changePassBtn">
                    </div>
                </form>
            </div>
        </div>
        <div class="card border-success align-self-center">
            <img src="assets/img/change.jpg" class="img-thumbnail img-fluid" width="408px">
        </div>
    </div>
</div>

<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.4.1/js/bootstrap.bundle.min.js"></script>
<script src="js/script.js"></script>
<script type="text/javascript">
$(document).ready(function(){
    // Change Password Ajax Request
    $("#changePassBtn").click(function(e){
        if($("#change-pass-form")[0].checkValidity()){ // Verificar la validez del formulario
            e.preventDefault(); // Prevenir el envío del formulario por defecto
            $("#changePassBtn").val('Please Wait...'); // Cambiar el texto del botón a "Please Wait..."

            // Verificar si las contraseñas coinciden
            if($("#newpass").val() != $("#cnewpass").val()){
                $("#changepassError").text('* Passwords do not match!'); // Mostrar un mensaje de error
                $("#changePassBtn").val('Change Password'); // Restaurar el texto del botón
            } else {
                $.ajax({
                    url: 'assets/php/process.php',
                    method: 'post',
                    data: $("#change-pass-form").serialize()+'&action=change_pass', // Serializar los datos del formulario
                    success: function(response){
                        $("#changepassAlert").html(response);
                        $("#changePassBtn").val('Change Password');
                        $("#changepassError").text(''); // Limpiar el mensaje de error
                        $("#change-pass-form")[0].reset();
                    },
                    error: function(xhr, status, error){
                        console.error("Error: " + xhr.responseText);
                        $("#changepassError").text('Error changing password.');
                        $("#changePassBtn").val('Change Password');
                    }
                });
            }
        }
    });
});
</script>





</body>
</html>
