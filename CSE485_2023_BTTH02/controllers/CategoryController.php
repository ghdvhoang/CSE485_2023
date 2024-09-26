<?php
require "./models/Category.php";
require "./models/Article.php";


class CategoryController{
    public function index(){
        $categories = $this->getAllCategories();
        require 'views/admin/categories/index.php';
    }
    public function insert(){
        require 'views/admin/categories/add_category.php';
        
    }

    public function save(){
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            $ten_tloai = $_POST['txtCatName'];

            do{
                $ma_tloai = rand(1,1000);
                $echeck_ma_tloai = $this->getaCatId($ma_tloai);
            }while($echeck_ma_tloai>0);

            $object = new Category();
            $object->setMaTloai($ma_tloai);
            $object->setTloai($ten_tloai);

            $object->insertCategory();
            header("Location: index.php?controller=category&action=index");
            exit();
        }
    }

    public function edit(){

        if(isset($_GET['id'])){
            $category = $this->getCategory($_GET['id']);
            require 'views/admin/categories/edit_category.php';
        }
        
    }

    public function update(){
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            $ten_tloai = $_POST['txtCatName'];
            $ma_tloai = $_POST['txtCatId'];
           
            $object = new Category();
            $object->setMaTloai($ma_tloai);
            $object->setTloai($ten_tloai);

            $object->updateCategory();
            header("Location: index.php?controller=category&action=index");
        }
    }

    public function delete(){
        $ma_tloai = $_GET['id'];
        $objectArt = new Article();
        $objectArt->setMaTloai($ma_tloai);
        $objectArt->deleteArticleByCate();

        $objectCate = new Category();
        $objectCate->setMaTloai($ma_tloai);
        $objectCate->deleteCategory();
        header("Location: index.php?controller=category&action=index");
    }

    public function getAllCategories(){
        $object = new Category();
        return $object->getAllCategories();
    }

    public function getaCatId($id){
        $object = new Category();
        return $object->getCategoryId($id);
    }

    public function getCategory($id){
        $oblject = new Category();
        return $oblject->getCat($id);
    }
}