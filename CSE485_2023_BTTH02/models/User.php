<?php
    require_once "./config.php";
class User{
    private $id;
    private $username;
    private $password;
    private $db;

    public function __construct()
    {
        $this->db = new PDO('mysql:host=' . DB_HOST . ';dbname=' . DB_NAME, DB_USER, DB_PASS);
        $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }
    public function getTotalUsers(){
        $sql = $this->db->prepare('SELECT COUNT(id) AS count FROM users');
        $sql->execute();

        $user = $sql->fetch(PDO::FETCH_ASSOC);
        return $user;
    }

    public function getListArticle(){
        $sql =$this->db->prepare('SELECT tieude, hinhanh, ma_bviet FROM baiviet ');
        $sql->execute();

        $enroledArticle = $sql->fetchAll(PDO::FETCH_ASSOC);
        return $enroledArticle;
    }

    public function getArticle($id){
        $sql =$this->db->prepare("SELECT baiviet.tieude, baiviet.ten_bhat,theloai.ten_tloai, baiviet.tomtat, baiviet.noidung, tacgia.ten_tgia, baiviet.hinhanh  FROM baiviet 
        JOIN tacgia ON baiviet.ma_tgia = tacgia.ma_tgia
        JOIN theloai ON theloai.ma_tloai = baiviet.ma_tloai
        WHERE ma_bviet = :id");
        $sql->bindParam(':id', $id, PDO::PARAM_INT);
        $sql->execute();

        $article = $sql->fetchAll(PDO::FETCH_ASSOC);
        return $article;
    }

    public function loginAdmin($username) {
        $sql = $this->db->prepare('SELECT * FROM users WHERE username = :username');
        $sql->bindParam(':username', $username, PDO::PARAM_STR);
        $sql->execute();
    
        $admin = $sql->fetch(PDO::FETCH_ASSOC); 
        return $admin;  
    }
    public function setId($id){
        $this->id=$id;
    }

    public function setUserName($username){
        $this->username=$username;
    }

    public function setPassword($password){
        $this->password=$password;
    }
} 