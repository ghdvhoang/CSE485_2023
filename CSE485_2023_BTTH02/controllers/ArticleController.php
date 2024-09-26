<?php
require_once "./models/Article.php";
require_once "./models/Author.php";
require_once "./models/Category.php";

class ArticleController {
    public function index() {
        $articles = $this->getAllArticles();
        require 'views/admin/articles/index.php';
    }

    public function insert(){
        $categories = $this->getAllCategories();
        $authors = $this->getAllAuthor();
        require 'views/admin/articles/add_article.php';
        
    }

    public function save(){
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
                $tieude = $_POST['txtTitle'];
                $ten_bhat = $_POST['txtMusic'];
                $ten_tloai = $_POST['txtCategory'];

                $ten_tgia = $_POST['txtAuthor'];
                $ngayviet = $_POST['date'];
                $noidung = $_POST['txtContent'];
                $tomtat = $_POST['txtSummary'];
                $ma_tloai = $this->getCategory($ten_tloai);
                $ma_tgia = $this->getAuthor($ten_tgia);
                //Lấy đường dẫn của file
                $image_path = $_FILES['image']['name'];

                $ex = ['jpg', 'png', 'jpeg'];
                $file_type = strtolower(pathinfo($image_path,PATHINFO_EXTENSION));
                if(in_array($file_type, $ex)){
                    $target_dir = 'images/author/';
                    $target_img = $target_dir . basename($image_path);

                    move_uploaded_file($_FILES['image']['tmp_name'], $target_img);

                            
                    do{
                        $ma_bviet = rand(1,1000);
                        $echeck_ma_bviet = $this->getArtId($ma_bviet);
                    }while($echeck_ma_bviet>0);

                   
                    $object = new Article();
                    $object->setMaTgia($ma_tgia);
                    $object->setMaTloai($ma_tloai);
                    $object->setMaBviet($ma_bviet);
                    $object->setTieuDe($tieude);
                    $object->setNoidung($noidung);
                    $object->setTomtat($tomtat);
                    $object->setNgayviet($ngayviet);
                    $object->setHInhanh($target_img);
                    $object->setTenBhat($ten_bhat);

                    $object->insertArticle();
                    header("Location: index.php?controller=article&action=index");
                    exit();

                }
        }
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

    public function edit() {
        // Lấy id của bài viết
        $id = $_GET['id'];
        
        // Lấy dữ liệu bài viết từ model
        $articleModel = new Article();
        $article = $articleModel->getArticleById($id);

        // Lấy danh sách tác giả và thể loại
        $result_tloai = $articleModel->getAllCategories();
        $result_tgia = $articleModel->getAllAuthors();

        // Gọi view edit
        require "views/admin/articles/edit_article.php";
    }

    public function delete() {
        if(isset($_GET['id'])){
        
            $articleModel = new Article();
            $articleModel->setMaBviet($_GET['id']);
            $articleModel->deleteArticle();
        
            header("Location: index.php?controller=article&action=index");         
            exit();
        }
    }
    public function getAllArticles(){
        $object = new Article();
        return $object->getAllArticles();
    }

    public function getArtId($id){
        $object = new Article();
        return $object->getArticleId($id);
    }
    public function getAllCategories(){
        $object = new Category();
        return $object->getAllCategories();
    }
    
    public function getAllAuthor(){
        $object = new Author();
        return $object->getAllAuthors();
    }

    public function getCategory($ten_tloai){
        $object = new Category();
        return $object->getCateGory($ten_tloai);
    }
    public function getAuthor($ten_tloai){
        $object = new Author();
        return $object->getAuthor($ten_tloai);
    }
}