-- a

SELECT baiviet.tieude
FROM baiviet
JOIN theloai
on baiviet.ma_tloai = theloai.ma_tloai
WHERE theloai.ten_tloai = 'Nhac tru tinh';

-- b
SELECT baiviet.tieude
from baiviet
join tacgia
on baiviet.ma_tgia = tacgia.ma_tgia
where tacgia.ten_tgia = 'Nhacvietplus';

-- c
select theloai.ten_tloai
from theloai
left join baiviet
on theloai.ma_tloai = baiviet.ma_tloai
where baiviet.ma_tloai is null;

-- d
select baiviet.ma_bviet, baiviet.ten_bhat, baiviet.tieude, tacgia.ten_tgia, theloai.ten_tloai, baiviet.ngayviet
from baiviet
join tacgia on baiviet.ma_tgia = tacgia.ma_tgia
join theloai on baiviet.ma_tloai = theloai.ma_tloai;

-- e
SELECT theloai.ten_tloai, COUNT(baiviet.ma_bviet) as so_bai_viet
FROM baiviet
JOIN theloai ON baiviet.ma_tloai = theloai.ma_tloai
GROUP BY theloai.ten_tloai
HAVING count(baiviet.ma_bviet) = (
	SELECT COUNT(baiviet.ma_bviet)
    FROM baiviet
    JOIN theloai ON baiviet.ma_tloai = theloai.ma_tloai
    GROUP BY theloai.ten_tloai
    ORDER BY COUNT(baiviet.ma_bviet) DESC
    LIMIT 1
);

-- f
SELECT tacgia.ten_tgia, COUNT(baiviet.ma_bviet) as so_luong_bai_viet
FROM baiviet
JOIN tacgia ON baiviet.ma_tgia = tacgia.ma_tgia
GROUP BY tacgia.ten_tgia
ORDER BY COUNT(baiviet.ma_bviet) DESC
LIMIT 2;

-- g
SELECT baiviet.tieude
FROM baiviet
WHERE baiviet.tomtat REGEXP 'yeu|thuong|anh|em';

-- h
SELECT baiviet.tieude
FROM baiviet
WHERE baiviet.tomtat REGEXP 'yeu|thuong|anh|em' 
OR baiviet.tieude REGEXP 'yeu|thuong|anh|em';

-- i
CREATE VIEW vw_Music AS
SELECT baiviet.*, tacgia.ten_tgia, theloai.ten_tloai
FROM baiviet
JOIN tacgia ON baiviet.ma_tgia = tacgia.ma_tgia
JOIN theloai ON baiviet.ma_tloai = theloai.ma_tloai;

-- j
DELIMITER $$
	CREATE PROCEDURE sp_DSBaiViet(IN ten_the_loai VARCHAR(50))
    BEGIN
    	IF EXISTS(SELECT 1 FROM theloai WHERE theloai.ten_tloai = ten_the_loai) THEN
        	SELECT baiviet.tieude
            FROM baiviet
            JOIN theloai ON theloai.ma_tloai = baiviet.ma_tloai
            WHERE theloai.ten_tloai = ten_the_loai;
         ELSE
         	SELECT 'Khong tim thay' AS ThongBao;
         END IF;
    END $$;
DELIMITER ;
-- k
ALTER TABLE theloai
ADD SLBaiViet INT;

-- l
CREATE TABLE users (
    id INT NOT NULL PRIMARY KEY,
    username VARCHAR(50) NOT NULL,
    password VARCHAR(255) NOT NULL,
);


INSERT INTO users (id, username, password) 
VALUES
(1,'admin', 'admin123'),
(2,'username1', 'hashed_password1'),
(3,'username2', 'hashed_password2');
