<?php
    require_once "./config.php";

class Author{
    private $ma_tgia;
    private $ten_tgia;

    private $hinhanh;
    private $db;
    public function __construct()
    {
        $this->db = new PDO('mysql:host=' . DB_HOST . ';dbname=' . DB_NAME, DB_USER, DB_PASS);
        $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }
    public function getAllAuthors(){
        $sql = $this->db->prepare('SELECT * FROM tacgia');
        $sql->execute();

        $authors = $sql->fetchAll(PDO::FETCH_ASSOC);
        return $authors;
    }
    public function getTotalAuthors(){
        $sql = $this->db->prepare('SELECT COUNT(ma_tgia) AS count FROM tacgia');
        $sql->execute();

        $author = $sql->fetch(PDO::FETCH_ASSOC);
        return $author;
    }

    public function insertAuthor(){
        $sql = $this->db->prepare('INSERT INTO tacgia(ma_tgia, ten_tgia, hinh_anh) VALUES (:ma_tgia, :ten_tgia ,:hinhanh)');
        $sql->bindParam(':ma_tgia', $this->ma_tgia, PDO::PARAM_INT);
        $sql->bindParam(':ten_tgia', $this->ten_tgia, PDO::PARAM_STR);
        $sql->bindParam(':hinhanh', $this->hinhanh, PDO::PARAM_STR);

       $sql->execute();
    }
    public function updateAuthorWithoutImage() {
        $sql = $this->db->prepare('UPDATE tacgia SET ten_tgia = :ten_tgia WHERE ma_tgia = :ma_tgia');
        $sql->bindParam(':ten_tgia', $this->ten_tgia, PDO::PARAM_STR);
        $sql->bindParam(':ma_tgia', $this->ma_tgia, PDO::PARAM_INT);
        $sql->execute();
    }
    
    public function updateauthor(){
        $sql = $this->db->prepare('UPDATE tacgia SET ten_tgia = :ten_tgia, hinh_anh = :hinhanh WHERE ma_tgia = :ma_tgia');
        $sql->bindParam(':ma_tgia', $this->ma_tgia, PDO::PARAM_INT);
        $sql->bindParam(':ten_tgia', $this->ten_tgia, PDO::PARAM_STR);
        $sql->bindParam(':hinhanh', $this->hinhanh, PDO::PARAM_STR);


        $sql->execute();
    }
    public function deleteAuthor(){
        $sql = $this->db->prepare('DELETE FROM tacgia WHERE ma_tgia = :ma_tgia');
        $sql->bindParam(':ma_tgia', $this->ma_tgia, PDO::PARAM_INT);

        $sql->execute();
    }

    public function getAuthorId($matgia){
        $sql = $this->db->prepare('SELECT ma_tgia FROM tacgia WHERE ma_tgia = :ma_tgia ');
        $sql->bindParam(':ma_tgia', $ma_tgia, PDO::PARAM_INT);
        $sql->execute();

        return $sql->fetch(PDO::FETCH_ASSOC);
    }
    public function getAuthor($author){
        $sql = $this->db->prepare('SELECT ma_tgia FROM tacgia WHERE ten_tgia = :ten_tgia');
        $sql->bindParam(':ten_tgia', $author, PDO::PARAM_STR);
        $sql->execute();

        return $sql->fetchAll(PDO::FETCH_ASSOC);
    }


    public function setMaTgia($ma_tgia){
        $this->ma_tgia = $ma_tgia;
    }

    public function setTenTgia($ten_tgia){  
        $this->ten_tgia = $ten_tgia;
    }

    public function setHInhanh($hinhanh){
        $this->hinhanh = $hinhanh;
    }
}   