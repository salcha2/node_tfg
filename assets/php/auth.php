<?php

require_once 'config.php';



class Auth extends Database{

    public function register($name, $username, $email, $password){
        $sql = "INSERT INTO users (name, username, email, password, created_at) VALUES (:name, :username, :email, :pass, CURRENT_TIMESTAMP)";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['name' => $name, 'username' => $username, 'email' => $email, 'pass' => $password]);
        return true;
    }
    

    //Check if user already registered
    public function user_exist($email){
        $sql = "SELECT email FROM users WHERE email = :email";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['email'=> $email]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        return $result;
    }

    //Login Existing User
    public function login($email){
        $sql= "SELECT email, password FROM users WHERE email = :email AND deleted != 0";
        $stmt = $this->conn->prepare($sql);
        $stmt -> execute(['email'=>$email]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        return $row;
    }


    //Current User In Session
    public function currentUser($email){
        $sql = "SELECT * FROM users WHERE email = :email AND deleted != 0";
        $stmt = $this -> conn -> prepare($sql);
        $stmt -> execute(['email'=> $email]);
        $row = $stmt -> fetch(PDO::FETCH_ASSOC);

        return $row;
    }

    //Forgot Password

    public function forgot_password($token, $email){
        $sql = "UPDATE users SET token = :token, token_expire = CURRENT_TIMESTAMP + INTERVAL '10 MINUTE' WHERE email = :email";
        
        $stmt = $this->conn->prepare($sql);
        if ($stmt->execute(['token' => $token, 'email' => $email])) {
            return true; // Si la consulta se ejecuta con éxito, devuelve verdadero
        } else {
            return false; // Si hay algún error en la ejecución de la consulta, devuelve falso
        }
    }


     // Método para obtener las credenciales de correo electrónico de un usuario
     public function getUserEmailCredentials($email) {
        $sql = "SELECT email_smtp_username, email_smtp_password FROM users WHERE email = :email";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['email' => $email]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }



    // Add new note

    public function add_new_note($usuario, $nombre, $descripcion){
        $sql = "INSERT INTO datos4 (usuario, nombre, descripcion) VALUES (:usuario, :nombre, :descripcion)";
    
        $stmt = $this->conn->prepare($sql);
    
        // Imprimir los valores que se pasarán a la consulta SQL
        echo "Usuario: $usuario<br>";
        echo "Nombre: $nombre<br>";
        echo "Descripción: $descripcion<br>";
    
        $stmt->execute(['usuario' => $usuario, 'nombre'=> $nombre , 'descripcion' => $descripcion]);
    
        // Verificar si hay errores durante la ejecución de la consulta
        $errorInfo = $stmt->errorInfo();
        if ($errorInfo[0] !== '00000') {
            // Si hay errores, imprimir el mensaje de error
            echo "Error al ejecutar la consulta: " . $errorInfo[2];
            return false;
        }
    
        return true;
    }


    // Fetch All Note Of An user
// Definición de la función get_notes
public function get_notes($usuario) {
    // Verificar la conexión a la base de datos
    if ($this->conn) {
        error_log("Conexión a la base de datos establecida.");
    } else {
        error_log("Error de conexión a la base de datos.");
        return [];
    }

    // Preparar la consulta SQL
    $sql = "SELECT * FROM datos4 WHERE usuario = :usuario";
    $stmt = $this->conn->prepare($sql);
    
    // Imprimir el valor del usuario
    error_log("Usuario: $usuario");

    // Verificar si el valor del usuario no está vacío
    if (empty($usuario)) {
        error_log("El valor del usuario está vacío.");
        return [];
    }

    // Ejecutar la consulta SQL
    if ($stmt->execute(['usuario' => $usuario])) {
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        // Agregar mensaje de depuración
        error_log("Consulta SQL ejecutada. Resultado: " . print_r($result, true));

        // Verificar si la consulta devolvió resultados
        if (empty($result)) {
            error_log("No se encontraron notas para el usuario: $usuario");
        }

        return $result;
    } else {
        // Agregar mensaje de depuración en caso de error en la ejecución de la consulta
        $errorInfo = $stmt->errorInfo();
        error_log("Error en la ejecución de la consulta SQL: " . $errorInfo[2]);
        return [];
    }
}


// edit Note of an user
public function edit_note($id){
    $sql = "SELECT * FROM datos4 WHERE id = :id";
    $stmt = $this -> conn -> prepare($sql);
    $stmt -> execute(['id' => $id]);

    $result = $stmt -> fetch(PDO::FETCH_ASSOC);

    return $result;


}


//UPDATE nOTE OF AN USER
public function note_exists($id) {
    $sql = "SELECT COUNT(*) FROM datos4 WHERE id = :id";
    $stmt = $this->conn->prepare($sql);
    $stmt->execute(['id' => $id]);
    return $stmt->fetchColumn() > 0;
}

public function update_note($id, $nombre, $descripcion) {
    try {
        $sql = "UPDATE datos4 SET nombre = :nombre, descripcion = :descripcion, updated_at = NOW() WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['nombre' => $nombre, 'descripcion' => $descripcion, 'id' => $id]);
        return true;
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
        return false;
    }
}


//DELETE A NOTE of an user

public function delete_note($id){
    $sql = "DELETE FROM datos4 WHERE id = :id";
    $stmt = $this->conn->prepare($sql);
    $stmt->execute(['id' => $id]);

    return true;
}


    // Obtener detalles de una nota
public function get_note_details($id){
    $sql = "SELECT * FROM datos4 WHERE id = :id";
    $stmt = $this->conn->prepare($sql);
    $stmt->execute(['id' => $id]);

    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    return $result;
}


//Update profile of an user

public function update_profile($name, $gender, $dob, $phone, $photo, $id) {
    // Asegurarse de que la condición de deleted sea coherente con la lógica de la aplicación
    $sql = "UPDATE users SET name = :name, gender = :gender, dob = :dob , telefono = :phone, photo = :photo WHERE id = :id";
    $stmt = $this->conn->prepare($sql);
    $stmt->execute(['name' => $name, 'gender' => $gender, 'dob' => $dob, 'phone' => $phone, 'photo' => $photo, 'id' => $id]);
    return $stmt->rowCount() > 0;
}



//Change Password of An User

public function change_password($pass, $id){
    $sql = "UPDATE users SET password = :pass WHERE id= :id AND deleted != 0";
    $stmt = $this -> conn -> prepare($sql);
    $stmt -> execute(['pass' => $pass, 'id'=> $id]);
    return true;
}
  

    
    
    


}



?>