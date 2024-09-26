<?php
    require_once "./config.php";
class Article{
    private $ma_bviet;
    private $ma_tgia;
    private $ma_tloai;
    private $tieude;
    private $noidung;
    private $tomtat;
    private $ten_bhat;
    private $ngayviet;
    private $hinhanh;
    private $db;
    public function __construct()
    {
        $this->db = new PDO('mysql:host=' . DB_HOST . ';dbname=' . DB_NAME, DB_USER, DB_PASS);
        $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    public function getAllArticles(){
        $sql = $this->db->prepare('SELECT *   FROM baiviet
                JOIN tacgia ON baiviet.ma_tgia = tacgia.ma_tgia
                JOIN theloai ON baiviet.ma_tloai = theloai.ma_tloai');
        $sql->execute();

        $articles = $sql->fetchALL(PDO::FETCH_ASSOC);
        return $articles;
    }
    public function insertArticle(){
        $sql = $this->db->prepare('INSERT INTO baiviet (ma_bviet, tieude, ten_bhat, ma_tloai, tomtat, noidung, ma_tgia, ngayviet, hinhanh) 
                                 VALUES (:ma_bviet, :tieude, :ten_bhat, :ma_tloai, :tomtat, :noidung, :ma_tgia, :ngayviet, :hinhanh)');
        $sql->bindParam(':ma_bviet', $this->ma_bviet, PDO::PARAM_INT);
        $sql->bindParam(':ma_tloai', $this->ma_tloai, PDO::PARAM_INT);
        $sql->bindParam(':ma_tgia', $this->ma_tgia, PDO::PARAM_INT);
        $sql->bindParam(':tieude', $this->tieude, PDO::PARAM_STR);
        $sql->bindParam(':ten_bhat', $this->ten_bhat, PDO::PARAM_STR);
        $sql->bindParam(':tomtat', $this->tomtat, PDO::PARAM_STR);
        $sql->bindParam(':noidung', $this->noidung, PDO::PARAM_STR);
        $sql->bindParam(':ngayviet', $this->ngayviet, PDO::PARAM_STR); 
        $sql->bindParam(':hinhanh', $this->hinhanh, PDO::PARAM_STR);
    
        $sql->execute();
    }

    public function deleteArticle(){
        $sql = $this->db->prepare('DELETE FROM baiviet WHERE ma_bviet = :ma_bviet');
        $sql->bindParam(':ma_bviet', $this->ma_bviet, PDO::PARAM_INT);

        $sql->execute();
    }

    public function deleteArticleByCate(){
        $sql = $this->db->prepare('DELETE FROM baiviet WHERE ma_tloai = :ma_tloai');
        $sql->bindParam(':ma_tloai', $this->ma_tloai, PDO::PARAM_INT);

        $sql->execute();

    }
    public function deleteArticleByAuth(){
        $sql = $this->db->prepare('DELETE FROM baiviet WHERE ma_tgia = :ma_tgia');
        $sql->bindParam(':ma_tgia', $this->ma_tgia, PDO::PARAM_INT);

        $sql->execute();

    }
    public function updateArticle() {
        $sql = $this->db->prepare('UPDATE baiviet SET tieude = :tieude, ten_bhat = :ten_bhat, ma_tloai = :ma_tloai, tomtat = :tomtat, 
            noidung = :noidung, ma_tgia = :ma_tgia, ngayviet = :ngayviet, hinhanh = :hinhanh WHERE ma_bviet = :ma_bviet');

        $sql->bindParam(':ma_bviet', $this->ma_bviet);
        $sql->bindParam(':tieude', $this->tieude);
        $sql->bindParam(':ten_bhat', $this->ten_bhat);
        $sql->bindParam(':ma_tloai', $this->ma_tloai);
        $sql->bindParam(':tomtat', $this->tomtat);
        $sql->bindParam(':noidung', $this->noidung);
        $sql->bindParam(':ma_tgia', $this->ma_tgia);
        $sql->bindParam(':ngayviet', $this->ngayviet);
        $sql->bindParam(':hinhanh', $this->hinhanh);

        $sql->execute();
    }

    public function getArticleById($ma_bviet) {
        $sql = $this->db->prepare('SELECT * FROM baiviet WHERE ma_bviet = :ma_bviet');
        $sql->bindParam(':ma_bviet', $ma_bviet, PDO::PARAM_INT);
        $sql->execute();
        return $sql->fetch(PDO::FETCH_ASSOC);
    }
    public function update() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $articleModel = new Article();

            // Lấy dữ liệu từ form
            $articleModel->setMaBviet($_POST['id']);
            $articleModel->setTieuDe($_POST['txtTitle']);
            $articleModel->setTenBhat($_POST['txtMusic']);
            $articleModel->setMaTloai($_POST['txtCategory']);
            $articleModel->setTomtat($_POST['txtSummary']);
            $articleModel->setNoidung($_POST['txtContent']);
            $articleModel->setMaTgia($_POST['txtAuthor']);
            $articleModel->setNgayviet($_POST['date']);

            // Xử lý ảnh
            $image_path = $_FILES['image']['name'];

            if (!empty($image_path)) {
                // Trường hợp có ảnh mới, lưu đường dẫn ảnh mới
                $target_dir = 'images/author/';
                $target_img = $target_dir . basename($image_path);

                if (move_uploaded_file($_FILES['image']['tmp_name'], $target_img)) {
                    $articleModel->setHinhanh($target_img);  // Cập nhật ảnh mới
                }
            } else {
                // Trường hợp không có ảnh mới, giữ lại ảnh cũ
                $articleModel->setHinhanh($_POST['old_image']);
            }

            // Cập nhật thông tin bài viết vào cơ sở dữ liệu
            $articleModel->updateArticle();

            // Điều hướng về trang danh sách bài viết
            header("Location: index.php?controller=article&action=index");
            exit();
        }
    }

    public function getAllCategories() {
        $sql = $this->db->prepare('SELECT * FROM theloai');
        $sql->execute();
        return $sql;
    }

    public function getAllAuthors() {
        $sql = $this->db->prepare('SELECT * FROM tacgia');
        $sql->execute();
        return $sql;
    }
    public function getTotalArticles(){
        $sql = $this->db->prepare('SELECT COUNT(ma_bviet) AS count FROM baiviet');
        $sql->execute();

        $article = $sql->fetch(PDO::FETCH_ASSOC);
        return $article;
    }
    public function setMaBviet($ma_bviet){
        $this->ma_bviet = $ma_bviet;
    }
    public function getArticleID($id){
        $sql = $this->db->prepare('SELECT ma_bviet FROM baiviet WHERE ma_bviet = :id');
        $sql->bindParam(':id', $id, PDO::PARAM_INT);

        $sql->execute();
    }

    public function setMaTgia($ma_tgia){
        $this->ma_tgia = $ma_tgia;
    }

    public function setMaTloai($ma_tloai){
        $this->ma_tloai = $ma_tloai;
    }

    public function setNoidung($noidung){
        $this->noidung = $noidung;
    }
    public function setTomtat($tomtat){
        $this->tomtat = $tomtat;
    }

    public function setTenBhat($ten_bhat){
        $this->ten_bhat = $ten_bhat;    
    }

    public function setNgayviet($ngayviet){
        $this->ngayviet = $ngayviet;    
    }

    public function setHinhanh($hinhanh){
        $this->hinhanh = $hinhanh;
    }

    public function setTieuDe($tieude){
        $this->tieude = $tieude;
    }
}