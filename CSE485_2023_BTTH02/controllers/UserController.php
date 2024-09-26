<?php
    require_once "./models/User.php";
class UserController{
    public function index(){

        $articles = $this->getListArticle();
        require "views/users/index.php";
    }

    public function detail(){
        $articles = $this->getArticle();
        require "views/users/detail.php";
        
    }

    public function login(){
        $admin = $this->loginAdmin();
        require "views/users/login.php";
        
    }

    public function getListArticle(){
        $object = new User();
        return $object->getListArticle();
    }

    public function getArticle(){
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            $object = new User();
            $article = $object->getArticle($id);
            if ($article) {
                return $article;  // Trả về bài viết nếu tìm thấy
            }
        }
        return null;  // Trả về null nếu không có bài viết
    }

    public function loginAdmin() {
        if ($_SERVER['REQUEST_METHOD'] === "POST") {
            $username = $_POST["username"];
            $password = $_POST["password"];
    
            $object = new User();
            $admin = $object->loginAdmin($username);
    
            if ($admin) { 
                header('Location: ./index.php?controller=admin&action=index');
                exit;
            } else {
                echo "Tên đăng nhập hoặc mật khẩu không đúng.";
            }
        }
        return null;
    }
    
    
} 