<?php
    // include './connect/conn.php';

    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        $username = $_POST['username'];
        $password = $_POST['password'];
    
      //database connection
    include_once "./connect/db.php";
      //validate login
      $query = "SELECT * FROM users WHERE username = '$username' AND password_hash = '$password'";
    $result = $conn -> query($query);

    if($result -> num_rows > 0){
        header("Location: ../admin/index.php");
        exit();
    }
    else{
        echo '2';
        exit();
    }
}

$conn -> close();