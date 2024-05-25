<?php

    session_start();
    require_once 'auth.php';
    $cuser = new Auth();

    if(!isset($_SESSION['user'])){
        header('location:autent.php');
        die;
    }

    $cemail = $_SESSION['user'];



    $data = $cuser-> currentUser($cemail);


    $cid = $data['id'];
    $cname = $data['name'];
    $cpass = $data['password'];
    $cphone = $data['phone'];
    $cgender = $data['gender'];
    $cdob = $data['dob'];
    $cphoto = $data['photo'];
    $created = $data['created_at'];

    $reg_on = date('d M Y', strtotime($created));

    $verified = $data['verified'];
    $users = $data['username'];


    $_SESSION['usuario'] = $users;


    $fname = strtok($cname, " ");

    if($verified == 0){
        $verified = 'Not Verified!';
    }
    else{
        $verified = 'Verified';
    }


    ?>