<?php
include_once '../connect/conn.php';

//Danh sach tác giả
$query_tgia = "SELECT * FROM tacgia";
$result_tgia = $conn -> query($query_tgia);

//Danh sách thể loại
$query_tloai = "SELECT * FROM theloai";
$result_tloai = $conn -> query($query_tloai);

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Music for Life - Thêm Bài Viết</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css" integrity="sha512-SzlrxWUlpfuzQ+pcUCosxcglQRNAq/DZjVsC0lE40xsADsfeQoEypE+enwcOiGjk/bSuGGKHEyjSoQ1zVisanQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="css/style_login.css">
</head>
<body>
    <header>
        <nav class="navbar navbar-expand-lg bg-body-tertiary shadow p-3 bg-white rounded">
            <div class="container-fluid">
                <div class="h3">
                    <a class="navbar-brand" href="#">Administration</a>
                </div>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link" aria-current="page" href="./">Trang chủ</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../index.php">Trang ngoài</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="./category/category.php">Thể loại</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="author.php">Tác giả</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active fw-bold" href="article.php">Bài viết</a>
                    </li>
                </ul>
                </div>
            </div>
        </nav>
    </header>
    <main class="container mt-5 mb-5">
        <div class="row">
            <div class="col-sm">
                <h3 class="text-center text-uppercase fw-bold">Thêm mới bài viết</h3>
                <form action="process_add_article.php" method="post" enctype="multipart/form-data">
                    <div class="input-group mt-3 mb-3">
                        <span class="input-group-text" id="lblTitle">Tiêu đề bài viết</span>
                        <input type="text" class="form-control" name="txtTitle" required>
                    </div>

                    <div class="input-group mt-3 mb-3">
                        <span class="input-group-text" id="lblMusic">Tên bài hát</span>
                        <input type="text" class="form-control" name="txtMusic" required>
                    </div>

                    <div class="input-group mt-3 mb-3">
                        <span class="input-group-text" id="lblCategory">Thể loại</span>
                        <select class="form-select" name="txtCategory" required>
                            <?php
                                if($result_tloai -> num_rows > 0){
                                    while($category = $result_tloai -> fetch_assoc()){
                                        ?>
                                            <option value="<?php echo $category['ten_tloai']; ?>"><?php echo $category['ten_tloai']; ?></option>
                                        <?php
                                    }
                                }
                            ?>
                        </select>
                    </div>

                    <div class="input-group mt-3 mb-3">
                        <span class="input-group-text" id="lblAuthor">Tác giả</span>
                        <select class="form-select" name="txtAuthor" required>
                        <?php
                                if($result_tgia -> num_rows > 0){
                                    while($author = $result_tgia -> fetch_assoc()){
                                        ?>
                                            <option value="<?php echo $author['ten_tgia']; ?>"><?php echo $author['ten_tgia']; ?></option>
                                        <?php
                                    }
                                }
                            ?>
                        </select>
                    </div>

                    <div class="input-group mt-3 mb-3">
                        <label for="dateWritten" class="me-3">Ngày viết bài: </label>
                        <input type="datetime-local" name="date" id="dateWritten">
                    </div>

                    <div class="input-group mt-3 mb-3">
                        <label for="fileUpload" class="me-3">Chọn hình ảnh bài viết: </label>
                        <input type="file" name="image" id="fileUpload" accept="image/*" onchange="previewImg(event)">
                        <img id="preview" class="img-thumbnail" style="width: 150px; height: auto;" >
                    </div>

                    <div class="input-group mt-3 mb-3">
                        <span class="input-group-text" id="lblContent">Nội dung bài viết</span>
                        <textarea class="form-control" name="txtContent" rows="3" required></textarea>
                    </div>

                    <div class="input-group mt-3 mb-3">
                        <span class="input-group-text" id="lblContent">Tóm tắt bài viết</span>
                        <textarea class="form-control" name="txtSummary" rows="3" required></textarea>
                    </div>

                    <div class="form-group float-end">
                        <input type="submit" value="Thêm" class="btn btn-success">
                        <a href="article.php" class="btn btn-warning">Quay lại</a>
                    </div>
                </form>
            </div>
        </div>
    </main>
    <footer class="bg-white d-flex justify-content-center align-items-center border-top border-secondary border-2" style="height:80px">
        <h4 class="text-center text-uppercase fw-bold">TLU's music garden</h4>
    </footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
    <script>
         function previewImg(event){
            let file = event.target.files[0]; // Lấy file đã chọn
            if (file) {
                let reader = new FileReader(); // Tạo một đối tượng FileReader
                reader.onload = function(e) {
                    let output = document.getElementById("preview");
                    output.src = e.target.result; // Gán URL của hình ảnh vào thẻ <img>
                };
                reader.readAsDataURL(file); // Đọc file dưới dạng URL Data
            }
        }
    </script>
</body>
</html>
