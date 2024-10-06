<?php
include 'connect.php';
include 'ultil.php';

$data = json_decode(file_get_contents('php://input'), true);

$idSinhVien = isset($data['idSinhVien']) ? $data['idSinhVien'] : null;
$id = isset($data['id']) ? $data['id'] : null;
$tieuDe = isset($data['tieuDe']) ? $data['tieuDe'] : null;
$ngayTao = isset($data['ngayTao']) ? $data['ngayTao'] : null;
$ngayCapNhat = isset($data['ngayCapNhat']) ? $data['ngayCapNhat'] : null;
$noiDung = isset($data['noiDung']) ? $data['noiDung'] : null;
$noiDungCua = isset($data['noiDungCua']) ? $data['noiDungCua'] : "Của tôi"; // Nếu không có, gán mặc định

$fields = [];
$values = [];

if ($id !== null) {
    $fields[] = 'id';
    $values[] = "'$id'";
}

$fields[] = 'idsinhvien';
$values[] = "'$idSinhVien'";
$fields[] = 'tieude';
$values[] = "'$tieuDe'";
$fields[] = 'ngayTao';
$values[] = "'$ngayTao'";
$fields[] = 'ngayCapNhat';
$values[] = "'$ngayCapNhat'";
$fields[] = 'noidung';
$values[] = "'$noiDung'";
$fields[] = 'noiDungCua';
$values[] = "'$noiDungCua'";

$sql = "INSERT INTO note (" . implode(", ", $fields) . ")
        VALUES (" . implode(", ", $values) . ")
        ON DUPLICATE KEY UPDATE 
            idsinhvien = '$idSinhVien', 
            tieude = '$tieuDe', 
            ngayTao = '$ngayTao', 
            ngayCapNhat = '$ngayCapNhat', 
            noidung = '$noiDung', 
            noiDungCua = '$noiDungCua'";

// Echo câu lệnh SQL để kiểm tra
// echo $sql;

if ($conn->query($sql) === TRUE) {
    if ($conn->affected_rows > 0) {
        $response = array(
            'status' => true,
            'message' => $conn->affected_rows == 1 ? 'Thêm mới thành công' : 'Đã cập nhật'
        );
    } else {
        $response = array(
            'status' => false,
            'message' => 'Không có thay đổi nào'
        );
    }
} else {
    echo "Lỗi: " . mysqli_error($conn); // Thông báo lỗi cụ thể
    $response = array(
        'status' => false,
        'message' => 'Thêm mới thất bại'
    );
}

echo json_encode($response);
$conn->close();
?>
