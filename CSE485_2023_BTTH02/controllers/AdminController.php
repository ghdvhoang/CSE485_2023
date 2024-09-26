<?php
require "./models/Article.php";
require "./models/Author.php";
require "./models/Category.php";
require "./models/User.php";


class AdminController {
    public function index() {
        $totalArticle = $this->getTotalArticle();
        $totalAuthor = $this->getTotalAuthor();
        $totalCategory = $this->getTotalCategory();
        $totalUser = $this->getTotalUser();

        
        // Gửi dữ liệu đến view
        require "views/admin/index.php";
    }

    public function getTotalArticle() {
        $object = new Article();
        return $object->getTotalArticles(); 
    }
    public function getTotalAuthor() {
        $object = new Author();
        return $object->getTotalAuthors(); 
    }
    public function getTotalCategory() {
        $object = new Category();
        return $object->getTotalCategory(); 
    }

    public function getTotalUser() {
        $object = new User();
        return $object->getTotalUsers(); 
    }
}
?>
