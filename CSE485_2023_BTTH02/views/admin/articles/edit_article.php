<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Music for Life - Sửa Bài Viết</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
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
                            <a class="nav-link active fw-bold" aria-current="page" href="index.php?controller=admin&action=index">Trang chủ</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="index.php?controller=user&action=index">Trang ngoài</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="index.php?controller=category&action=index">Thể loại</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="index.php?controller=author&action=index">Tác giả</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="index.php?controller=article&action=index">Bài viết</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>
    <main class="container mt-5 mb-5">
        <div class="row">
            <div class="col-sm">
                <h3 class="text-center text-uppercase fw-bold">Sửa bài viết</h3>
                <form action="index.php?controller=article&action=update&id=<?php echo $article['ma_bviet']; ?>" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="old_image" value="<?php echo $article['hinhanh']; ?>">
                    <input type="hidden" name="id" value="<?php echo $article['ma_bviet']; ?>">

                    <div class="input-group mt-3 mb-3">
                        <span class="input-group-text">Tiêu đề bài viết</span>
                        <input type="text" class="form-control" name="txtTitle" value="<?php echo $article['tieude']; ?>" required>
                    </div>

                    <div class="input-group mt-3 mb-3">
                        <span class="input-group-text">Tên bài hát</span>
                        <input type="text" class="form-control" name="txtMusic" value="<?php echo $article['ten_bhat']; ?>" required>
                    </div>

                    <div class="input-group mt-3 mb-3">
                        <span class="input-group-text">Thể loại</span>
                        <select class="form-select" name="txtCategory">
                            <?php foreach ($result_tloai as $row) { ?>
                                <option value="<?php echo $row['ma_tloai']; ?>" <?php if ($article['ma_tloai'] == $row['ma_tloai']) echo 'selected'; ?>>
                                    <?php echo $row['ten_tloai']; ?>
                                </option>
                            <?php } ?>
                        </select>
                    </div>

                    <div class="input-group mt-3 mb-3">
                        <span class="input-group-text">Tóm tắt</span>
                        <textarea class="form-control" name="txtSummary" required><?php echo $article['tomtat']; ?></textarea>
                    </div>

                    <div class="input-group mt-3 mb-3">
                        <span class="input-group-text">Nội dung</span>
                        <textarea class="form-control" name="txtContent" required><?php echo $article['noidung']; ?></textarea>
                    </div>

                    <div class="input-group mt-3 mb-3">
                        <span class="input-group-text">Tác giả</span>
                        <select class="form-select" name="txtAuthor">
                            <?php foreach ($result_tgia as $row) { ?>
                                <option value="<?php echo $row['ma_tgia']; ?>" <?php if ($article['ma_tgia'] == $row['ma_tgia']) echo 'selected'; ?>>
                                    <?php echo $row['ten_tgia']; ?>
                                </option>
                            <?php } ?>
                        </select>
                    </div>

                    <div class="input-group mt-3 mb-3">
                        <label for="fileUpload" class="me-3">Chọn hình ảnh bài viết: </label>
                        <input type="file" name="image" id="fileUpload" accept="image/*" onchange="previewImg(event)">
                        <img id="preview" class="img-thumbnail" style="width: 150px; height: auto;" src="<?php echo $article['hinhanh']; ?>">
                    </div>

                    <div class="input-group mt-3 mb-3">
                        <span class="input-group-text">Ngày viết</span>
                        <input type="date" class="form-control" name="date" value="<?php echo $article['ngayviet']; ?>" required>
                    </div>

                    <div class="form-group float-end">
                        <input type="submit" value="Cập nhật" class="btn btn-success">
                        <a href="index.php?controller=article&action=index" class="btn btn-warning">Quay lại</a>
                    </div>
                </form>
            </div>
        </div>
    </main>

    <script>
        function previewImg(event) {
            var output = document.getElementById('preview');
            output.src = URL.createObjectURL(event.target.files[0]);
        }
    </script>

<footer class="bg-white d-flex justify-content-center align-items-center border-top border-secondary border-2" style="height:80px">
        <h4 class="text-center text-uppercase fw-bold">TLU's music garden</h4>
    </footer>
</body>
</html>
