<?php

require "./models/Author.php";
require "./models/Article.php";

class AuthorController{
    public function index(){
        $authors = $this->getAllAuthor();
        require "views/admin/authors/index.php";
    }
    public function getAllAuthor(){
        $object = new Author();
        return $object->getAllAuthors();
    }
    public function insert(){
        require 'views/admin/authors/add_author.php';     
    }

    public function save(){
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
                $ten_tgia = $_POST['txtCatName'];

                //Lấy đường dẫn của file
                $image_path = $_FILES['image']['name'];

                $ex = ['jpg', 'png', 'jpeg'];
                $file_type = strtolower(pathinfo($image_path,PATHINFO_EXTENSION));
                if(in_array($file_type, $ex)){
                    $target_dir = 'images/author/';
                    $target_img = $target_dir . basename($image_path);

                    move_uploaded_file($_FILES['image']['tmp_name'], $target_img);

                            
                    do{
                        $ma_tgia = rand(1,1000);
                        $echeck_ma_tgia = $this->getAuthorId($ma_tgia);
                    }while($echeck_ma_tgia>0);

                    $object = new Author();
                    $object->setMaTgia($ma_tgia);
                    $object->setTenTgia($ten_tgia);
                    $object->setHInhanh($target_img);

                    $object->insertAuthor();
                    header("Location: index.php?controller=author&action=index");
                    exit();

                }
        }
    }
    public function update() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $ten_tgia = $_POST['txtAuthorName']; // Đổi tên biến cho hợp lý
            $ma_tgia = $_POST['txtAuthorId']; // Đổi thành 'txtAuthorId' cho đúng
    
            // Kiểm tra xem người dùng có tải lên hình ảnh mới hay không
            if (!empty($_FILES['image']['name'])) {
                $image_path = $_FILES['image']['name'];
    
                $allowed_types = ['jpg', 'png', 'jpeg'];
                $file_type = strtolower(pathinfo($image_path, PATHINFO_EXTENSION));
    
                if (in_array($file_type, $allowed_types)) {
                    $target_dir = 'images/author/';
                    $target_img = $target_dir . basename($image_path);
    
                    // Di chuyển file upload vào thư mục đích
                    if (move_uploaded_file($_FILES['image']['tmp_name'], $target_img)) {
                        // Cập nhật thông tin tác giả với hình ảnh mới
                        $object = new Author();
                        $object->setMaTgia($ma_tgia);
                        $object->setTenTgia($ten_tgia);
                        $object->setHInhanh($image_path); // Lưu tên file thay vì đường dẫn đầy đủ
                        $object->updateAuthor();
                    } else {
                        echo "Failed to upload image. Please try again.";
                        return;
                    }
                } else {
                    echo "Invalid file type. Please upload a JPG, JPEG, or PNG image.";
                    return;
                }
            } else {
                // Nếu không có hình ảnh mới, chỉ cập nhật tên tác giả
                $object = new Author();
                $object->setMaTgia($ma_tgia);
                $object->setTenTgia($ten_tgia);
                $object->updateAuthorWithoutImage(); // Phương thức này chỉ cập nhật tên tác giả mà không thay đổi hình ảnh
            }
    
            // Sau khi cập nhật thành công, chuyển hướng
            header("Location: index.php?controller=author&action=index");
            exit();
        }
    }
    
    public function edit(){
            require 'views/admin/authors/edit_author.php'; 
    }
    public function getAuthorId($id){
        $object = new Author();
        return $object->getAuthorId($id);
    }

    public function delete(){
        $ma_tloai = $_GET['id'];
        $objectArt = new Article();
        $objectArt->setMaTloai($ma_tloai);
        $objectArt->deleteArticleByCate();

        $objectAuth = new Author();
        $objectAuth->setMaTgia($ma_tloai);
        $objectAuth->deleteAuthor();
        header("Location: index.php?controller=category&action=index");
    }
}