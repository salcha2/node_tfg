<?php 
require_once 'admin-db.php';

$admin = new Admin();

session_start();

if (isset($_POST['action']) && $_POST['action'] == 'adminLogin') {
    $username = $admin->test_input($_POST['username']);
    $password = $admin->test_input($_POST['password']);

    $hpassword = sha1($password);

    $loggedInAdmin = $admin->admin_login($username, $hpassword);

    if($loggedInAdmin != null){
        echo 'admin_login';

        $_SESSION['username'] = $username;
    }
    else{
        echo $admin->showMessage('danger', 'Username or Password is Incorrect!');
    }
}

//Handle Fetch All Users Ajax Request
if(isset($_POST['action']) && $_POST['action'] == 'fetchAllUsers'){
    $output = '';
    $data = $admin->fetchAllUsers(0);
    $path = '../assets/php/';

    if($data){
        $output .= '<table class="table table-striped table-bordered text-center">
                <thead>
                <tr>
                    <th>#</th>
                    <th>Image</th>
                    <th>Name</th>
                    <th>E-Mail</th>
                    <th>Phone</th>
                    <th>Gender</th>
                    <th>Verified</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>';

        foreach($data as $row) {
            if($row['photo'] != ''){
                $uphoto = $path.$row['photo'];
            }else{
                $uphoto = '../assets/img/profile.png';
            }

            $output .= '<tr>
                        <td>'.$row['id'].'</td>
                        <td><img src="'.$uphoto.'" class="rounded-circle" width="40px"></td>
                        <td>'.$row['name'].'</td>
                        <td>'.$row['email'].'</td>
                        <td>'.$row['telefono'].'</td>
                        <td>'.$row['gender'].'</td>
                        <td>'.$row['verified'].'</td>
                        <td>
                        <a href="#" id="'.$row['id'].'" title="View Details" class="text-primary userDetailsIcon" data-toggle="modal" data-target="#showUserDetailsModal"><i class="fas fa-info-circle fa-lg"></i></a>&nbsp;&nbsp;

                            <a href="#" id="'.$row['id'].'" title="Delete user" class="text-danger deleteUserIcon"><i class="fas fa-trash-alt fa-lg"></i></a>&nbsp;&nbsp;
                        </td>
                    </tr>';
        }

        $output .= '</tbody></table>';
        echo $output; // Corrección: Imprimir la salida generada
    } else {
        echo '<h3 class="text-center text-secondary">No users registered yet!</h3>'; // Corrección: Mensaje cuando no hay usuarios
    }
}

?>
