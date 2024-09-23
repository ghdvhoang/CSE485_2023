<?php
    include './connect/conn.php';

    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        $username = $_POST['username'];
        $password = $_POST['password'];


        $query = "SELECT * FROM users WHERE username = '$username' AND password = '$password' ";
        $result = $conn -> query($query);

        if($result -> num_rows > 0){
            header("Location: ./admin/index.php");
            exit();
        }
    }

$conn -> close();