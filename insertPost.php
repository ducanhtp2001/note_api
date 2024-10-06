<?php
include 'connect.php';
include 'model.php';

// Lấy dữ liệu từ yêu cầu POST dưới dạng JSON
$data = json_decode(file_get_contents('php://input'), true);

$idSinhVien = isset($data['idSinhVien']) ? $data['idSinhVien'] : null;
$id = isset($data['id']) ? $data['id'] : null;
$thoiGian = isset($data['thoiGian']) ? $data['thoiGian'] : null;
$maMon = isset($data['maMon']) ? $data['maMon'] : null;
$lopTinChi = isset($data['lopTinChi']) ? $data['lopTinChi'] : null;
$noiDung = isset($data['noiDung']) ? $data['noiDung'] : null;
$coImg = isset($data['coImg']) ? $data['coImg'] : null;
$img = isset($data['img']) ? $data['img'] : null;

$fields = [];
$values = [];

if ($id !== null) {
    $fields[] = 'id';
    $values[] = "'$id'";
}

$fields[] = 'idsinhvien';
$values[] = "'$idSinhVien'";
$fields[] = 'thoigian';
$values[] = "'$thoiGian'";
$fields[] = 'mamon';
$values[] = "'$maMon'";
$fields[] = 'loptinchi';
$values[] = "'$lopTinChi'";
$fields[] = 'noidung';
$values[] = "'$noiDung'";
$fields[] = 'coimg';
$values[] = "'$coImg'";
$fields[] = 'img';
$values[] = "'$img'";

// Tạo câu lệnh SQL
$sql = "INSERT INTO post (" . implode(", ", $fields) . ")
        VALUES (" . implode(", ", $values) . ")
        ON DUPLICATE KEY UPDATE 
            idsinhvien = '$idSinhVien', 
            thoigian = '$thoiGian', 
            mamon = '$maMon', 
            loptinchi = '$lopTinChi', 
            noidung = '$noiDung', 
            coimg = '$coImg', 
            img = '$img'";

// echo $sql;

if ($conn->query($sql) === TRUE) {
    if ($conn->affected_rows > 0) {
        if ($conn->affected_rows == 1) {
            $response = array(
                'status' => true,
                'message' => 'Thêm mới thành công'
            );
        } else {
            $response = array(
                'status' => true,
                'message' => 'Đã cập nhật'
            );
        }
    } else {
        echo "Lỗi: " . $conn->error;
        $response = array(
            'status' => false,
            'message' => 'Lỗi cập nhật'
        );
    }
} else {
    echo "Lỗi: " . $conn->error;
    $response = array(
        'status' => false,
        'message' => 'Thêm mới thất bại'
    );
}

echo json_encode($response);

$conn->close();
?>
