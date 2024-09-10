<?php
include 'connect.php';

// Lấy dữ liệu từ yêu cầu POST
$jsonData = file_get_contents('php://input');
$data = json_decode($jsonData, true);

$json = new stdClass();

if ($data) {
    $idSinhVien = $data['idSinhVien'];
    $taiKhoan = $data['taiKhoan'];
    $matKhau = $data['matKhau'];
    $iv = "";

    // Sử dụng câu lệnh chuẩn bị (prepared statement)
    $stmt = $conn->prepare('SELECT * FROM taikhoan WHERE idsinhvien = ?');
    $stmt->bind_param('i', $idSinhVien); // 'i' chỉ định kiểu dữ liệu là integer
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Sinh viên đã đăng ký tài khoản
        $json->status = false;
        $json->message = "Sinh viên đã đăng ký tài khoản!";
    } else {
        // Thực hiện thêm mới tài khoản
        $stmt = $conn->prepare('INSERT INTO taikhoan (idsinhvien, taikhoan, matkhau, iv) VALUES (?, ?, ?, ?)');
        $stmt->bind_param('isss', $idSinhVien, $taiKhoan, $matKhau, $iv); // 'i' cho integer, 's' cho string

        if ($stmt->execute()) {
            $json->status = true;
            $json->message = "Đăng ký thành công!";
        } else {
            $json->status = false;
            $json->message = "Đăng ký thất bại: " . $stmt->error;
        }
    }

    // Đóng kết nối chuẩn bị
    $stmt->close();
} else {
    $json->status = false;
    $json->message = "Không có dữ liệu";
}

// Gửi phản hồi JSON
header('Content-Type: application/json');
echo json_encode($json);

// Đóng kết nối cơ sở dữ liệu
$conn->close();
?>
