<?php
require_once 'session.php';
require_once 'auth.php'; // Asumiendo que 'auth.php' contiene la clase `Auth`

$users = new Auth(); // Crear una instancia de la clase Auth

// Handle Add New Note Ajax Request 
if (isset($_POST['action']) && $_POST['action'] == 'add_note') {
    // Obtener los datos del formulario
    $nombre = $users->test_input($_POST['title']);
    $descripcion = $users->test_input($_POST['note']);

    // Obtener el nombre de usuario de la sesión
    session_start();
    $usuario = $_SESSION['usuario'];

    // Llamar a la función para agregar una nueva nota
    $users->add_new_note($usuario, $nombre, $descripcion);
}

// Handle Display Notes Ajax Request
if (isset($_POST['action']) && $_POST['action'] == 'display_notes') {
    // Iniciar la sesión
    session_start();

    // Verificar si el nombre de usuario está en la sesión
    if (isset($_SESSION['usuario'])) {
        $usuario = $_SESSION['usuario']; // Obtener el nombre de usuario de la sesión

        // Llamar a la función para obtener las notas del usuario actual
        $notes = $users->get_notes($usuario);

        // Preparar la respuesta
        $response = [
            'notes' => $notes // Array de notas del usuario
        ];

        // Enviar la respuesta al cliente
        echo json_encode($response);
    } else {
        // Si el nombre de usuario no está en la sesión, enviar una respuesta vacía
        echo json_encode(['notes' => []]);
    }
}

if (isset($_POST['id'])) {
    $id = $_POST['id'];

    $row = $cuser -> edit_note($id);

    echo json_encode($row);
    
}



if (isset($_POST['action']) && $_POST['action'] == 'update_note') {
    // Depurar datos recibidos
    print_r($_POST); 

    // Verificación y sanitización de entradas
    if (!empty($_POST['note_id']) && !empty($_POST['edit_title']) && !empty($_POST['edit_note'])) {
        $id = $cuser->test_input($_POST['note_id']);
        $nombre = $cuser->test_input($_POST['edit_title']);
        $descripcion = $cuser->test_input($_POST['edit_note']);

        // Verificación de la existencia del ID en la base de datos
        if ($cuser->note_exists($id)) {
            // Intentar actualizar la nota
            $update_result = $cuser->update_note($id, $nombre, $descripcion);
            if ($update_result) {
                echo json_encode(["status" => "success", "message" => "Note updated successfully."]);
            } else {
                echo json_encode(["status" => "error", "message" => "Failed to update note."]);
            }
        } else {
            echo json_encode(["status" => "error", "message" => "Note with specified ID does not exist."]);
        }
    } else {
        echo json_encode(["status" => "error", "message" => "All fields are required."]);
    }
}


//HAndle delete a note of an User ajax request


if (isset($_POST['del_id'])) {
    $id = $_POST['del_id'];
    print_r($_POST); // Para depuración, verifica que el ID se está recibiendo correctamente

    $cuser->delete_note($id);
}



//Handle display detail note of an user request
if(isset($_POST['info_id'])){
    $id = $_POST['info_id'];

    // Mensaje de depuración
    echo "Info ID recibido: " . $id;

    // Obtener detalles de la nota utilizando la nueva función
    $row = $cuser->get_note_details($id);

    // Mensaje de depuración
    echo "Fila recuperada de la base de datos: ";
    print_r($row);

    if ($row) {
        echo json_encode($row);
    } else {
        echo json_encode(["error" => "No se encontró la nota con el ID especificado."]);
    }
}


//Handle ajax request for profile update

// Handle ajax request for profile update
if(isset($_FILES['image'])) {
    // Verificar que al menos uno de los campos (excepto la imagen) esté presente
    if (!isset($_POST['name']) && !isset($_POST['gender']) && !isset($_POST['dob']) && !isset($_POST['phone'])) {
        echo "No fields to update.";
        exit;
    }

    $name = isset($_POST['name']) ? $cuser->test_input($_POST['name']) : null;
    $gender = isset($_POST['gender']) ? $cuser->test_input($_POST['gender']) : null;
    $dob = isset($_POST['dob']) ? $cuser->test_input($_POST['dob']) : null;
    $phone = isset($_POST['phone']) ? $cuser->test_input($_POST['phone']) : null;
    $oldImage = $_POST['oldimage'];
    $folder = 'uploads/';

    // Imprimir valores recibidos
    echo "Name: $name<br>";
    echo "Gender: $gender<br>";
    echo "DOB: $dob<br>";
    echo "Phone: $phone<br>";
    echo "Old Image: $oldImage<br>";

    // Verificar si el usuario existe en la base de datos
    $checkSql = "SELECT * FROM users WHERE id = :id";
    $checkStmt = $cuser->conn->prepare($checkSql);
    $checkStmt->execute(['id' => $cid]);
    $userData = $checkStmt->fetch(PDO::FETCH_ASSOC);

    if (!$userData) {
        echo "User not found in the database.";
        exit;
    }

    // Mostrar datos actuales del usuario
    echo "Current Data in DB: <br>";
    echo "Name: " . $userData['name'] . "<br>";
    echo "Gender: " . $userData['gender'] . "<br>";
    echo "DOB: " . $userData['dob'] . "<br>";
    echo "Phone: " . $userData['phone'] . "<br>";
    echo "Photo: " . $userData['photo'] . "<br>";
    echo "Deleted: " . $userData['deleted'] . "<br>";

    if (isset($_FILES['image']['name']) && ($_FILES['image']['name'] != "")) {
        // Si se proporciona una nueva imagen, procesarla
        $newImage = $folder . $_FILES['image']['name'];
        if (move_uploaded_file($_FILES['image']['tmp_name'], $newImage)) {
            echo "New Image Path: $newImage<br>";

            if ($oldImage != null) {
                // Eliminar la imagen anterior si existe
                if (unlink($oldImage)) {
                    echo "Deleted Old Image: $oldImage<br>";
                } else {
                    echo "Failed to delete old image<br>";
                }
            }
        } else {
            echo "Error moving uploaded file<br>";
            exit;
        }
    } else {
        // Si no se proporciona una nueva imagen, mantener la imagen existente
        $newImage = $oldImage;
        echo "No new image uploaded<br>";
    }

    // Crear una instancia de la clase Auth
    $auth = new Auth();

    // Llamada a la función update_profile de la instancia de la clase Auth
    $result = $auth->update_profile($name, $gender, $dob, $phone, $newImage, $cid);

    // Verificar si la actualización del perfil fue exitosa e imprimir el resultado
    if ($result) {
        echo "Profile updated successfully<br>";
    } else {
        // Obtener el mensaje de error específico de la consulta SQL
        $errorInfo = $checkStmt->errorInfo();
        echo "Failed to update profile<br>";
        echo "SQL Error: " . $errorInfo[2] . "<br>";
    }
} else {
    echo "Image file not received.<br>";
}



//Handle Change Password Ajax Request
if(isset($_POST['action']) && $_POST['action'] == 'change_pass'){
    $currentPass = $_POST['curpass'];
    $newPass = $_POST['newpass'];
    $cnewPass = $_POST['cnewpass'];

    $hnewPass = password_hash($newPass, PASSWORD_DEFAULT);

    if($newPass != $cnewPass){
        echo $cuser->showMessage('danger', 'Passwords did not match!');
    }
    else{
        if(password_verify($currentPass, $cpass)){
            $cuser->change_password($hnewPass, $cid);
            echo $cuser->showMessage('success', 'Password Changed Successfully!');
        }
        else{
            echo $cuser->showMessage('danger', 'Current Password is Wrong!');
        }
    }
}






?>
