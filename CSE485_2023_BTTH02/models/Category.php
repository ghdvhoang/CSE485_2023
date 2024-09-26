<?php
    require_once "./config.php";

class Category{
    private $ma_tloai;
    private $ten_tloai;
    private $db;
    public function __construct()
    {
        $this->db = new PDO('mysql:host=' . DB_HOST . ';dbname=' . DB_NAME, DB_USER, DB_PASS);
        $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }
    public function getTotalCategory(){
        $sql = $this->db->prepare('SELECT COUNT(ma_tloai) AS count FROM theloai');
        $sql->execute();

        $category = $sql->fetch(PDO::FETCH_ASSOC);
        return $category;
    }

    public function insertCategory(){
        $sql = $this->db->prepare('INSERT INTO theloai(ma_tloai, ten_tloai) VALUES(:ma_tloai, :ten_tloai)');
        $sql->bindParam(':ma_tloai', $this->ma_tloai, PDO::PARAM_INT);
        $sql->bindParam(':ten_tloai', $this->ten_tloai, PDO::PARAM_STR);

       $sql->execute();
    }

    public function getAllCategories(){
        $sql = $this->db->prepare('SELECT * FROM theloai');
        $sql->execute();

        $categories = $sql->fetchAll(PDO::FETCH_ASSOC);
        return $categories;
    }

    public function getCategoryId($ma_tloai){
        $sql = $this->db->prepare('SELECT ma_tloai FROM theloai WHERE ma_tloai = :ma_tloai ');
        $sql->bindParam(':ma_tloai', $ma_tloai, PDO::PARAM_INT);
        $sql->execute();

        return $sql->fetch(PDO::FETCH_ASSOC);
    }

    public function updateCategory(){
        $sql = $this->db->prepare('UPDATE theloai SET ten_tloai = :ten_tloai WHERE ma_tloai = :ma_tloai');
        $sql->bindParam(':ma_tloai', $this->ma_tloai, PDO::PARAM_INT);
        $sql->bindParam(':ten_tloai', $this->ten_tloai, PDO::PARAM_STR);

        $sql->execute();
    }

    public function deleteCategory(){
        $sql = $this->db->prepare('DELETE FROM theloai WHERE ma_tloai = :ma_tloai');
        $sql->bindParam(':ma_tloai', $this->ma_tloai, PDO::PARAM_INT);

        $sql->execute();
    }

    public function getCat($id){
        $sql = $this->db->prepare('SELECT * FROM theloai WHERE ma_tloai = :id');
        $sql->bindParam(':id', $id, PDO::PARAM_INT);
        $sql->execute();

        return $sql->fetchAll(PDO::FETCH_ASSOC);
    }
    public function getCategory($category){
        $sql = $this->db->prepare('SELECT ma_tloai FROM theloai WHERE ten_tloai = :ten_tloai');
        $sql->bindParam(':ten_tloai', $category, PDO::PARAM_STR);
        $sql->execute();

        return $sql->fetchAll(PDO::FETCH_ASSOC);
    }

    public function setMaTloai($ma_tloai) {
        $this->ma_tloai = $ma_tloai;
    }

    public function setTloai($ten_tloai) {
        $this->ten_tloai = $ten_tloai;
    }

}