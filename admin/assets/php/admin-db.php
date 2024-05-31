<?php 
require_once 'config.php';

class Admin extends Database {
    // Admin Login
    public function admin_login($username, $password) {
        $sql = "SELECT username, password FROM admin WHERE username = :username AND password = :password";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['username' => $username, 'password' => $password]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row;
    }


   //Fetch All Registered Users
public function fetchAllUsers($val){
    $sql = "SELECT * FROM users WHERE deleted != :val";
    $stmt = $this->conn->prepare($sql); 
    $stmt->execute(['val' => $val]);
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $result;
}



//Fetch Users Details by ID

 public function fetchUserDetailByID($id){
     $sql = "SELECT * FROM users WHERE id = :id AND deleted != 0";
     $stmt = $this -> conn -> prepare($sql);
     $stmt -> execute(['id' => $id]);

     $result = $stmt -> fetch(PDO::FETCH_ASSOC);

     return $result;
 }


 // Delete An User

 public function userAction($id, $val){
    $sql = "UPDATE users SET deleted = $val WHERE id= :id";

    $stmt = $this -> conn -> prepare($sql);

    $stmt -> execute(['id'=> $id]);

    return true;
 }


}
?>
