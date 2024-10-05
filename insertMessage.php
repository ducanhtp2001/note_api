<?php
include 'connect.php';
include 'model.php';



// Lấy dữ liệu từ yêu cầu POST dưới dạng JSON
$data = json_decode(file_get_contents('php://input'), true);

$id = isset($data['id']) ? $data['id'] : null;
$idPost = isset($data['idPost']) ? $data['idPost'] : null;
$idSinhVien = isset($data['idSinhVien']) ? $data['idSinhVien'] : null;
$thoiGian = isset($data['thoiGian']) ? $data['thoiGian'] : null;
$noiDung = isset($data['noiDung']) ? $data['noiDung'] : null;
$coImg = isset($data['coImg']) ? $data['coImg'] : 0;
$img = isset($data['img']) ? $data['img'] : null;

$fields = [];
$values = [];

if ($idPost !== null) {
    $fields[] = 'id';
    $values[] = "'$id'";
}

$fields[] = 'idPost';
$values[] = "'$idPost'";
$fields[] = 'idsinhvien';
$values[] = "'$idSinhVien'";
$fields[] = 'thoigian';
$values[] = "'$thoiGian'";
$fields[] = 'noiDung';
$values[] = "'$noiDung'";
$fields[] = 'coimg';
$values[] = "'$coImg'";
$fields[] = 'img';
$values[] = "'$img'";

$sql = "INSERT INTO message (" . implode(", ", $fields) . ")
        VALUES (" . implode(", ", $values) . ")
        ON DUPLICATE KEY UPDATE 
            idpost = VALUES(idpost), 
            idsinhvien = VALUES(idsinhvien), 
            thoigian = VALUES(thoigian), 
            noiDung = VALUES(noiDung), 
            coimg = VALUES(coimg), 
            img = VALUES(img)";

// echo $sql;

if ($conn->query($sql) === TRUE) {
    $response = array(
        'status' => true,
        'message' => ($conn->affected_rows == 1) ? 'Thêm tin nhắn thành công' : 'Đã cập nhật tin nhắn'
    );
} else {
    echo "Lỗi: " . $conn->error;
    $response = array(
        'status' => false,
        'message' => 'Thêm hoặc cập nhật tin nhắn thất bại'
    );
}

echo json_encode($response);

$conn->close();
?>
