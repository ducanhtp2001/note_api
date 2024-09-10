<?php
include 'connect.php'; // Đảm bảo file này thiết lập kết nối $conn

$jsonData = file_get_contents('php://input');
$data = json_decode($jsonData, true);

if ($data) {
    $idSinhVien = $data['idSinhVien'];
    $lop = $data['lop'];
    $khoa = $data['khoa'];
    $nienKhoa = $data['nienKhoa'];
    $json = new stdClass();

    $sql = 'SELECT * FROM thongtinsinhvien WHERE id = ' . $idSinhVien . ' AND lop = ' . $lop . ' AND khoa = ' . $khoa . ' AND nienkhoa = ' . $nienKhoa;

    $result = $conn->query($sql);

    if ($result) {
        if ($result->num_rows > 0) {
            $json->status = true;
            $row = $result->fetch_assoc();
            $json->tenSinhVien = $row['hoten'];
        } else {
            $json->status = false;
        }
    } else {
        $json->status = false;
        $json->message = "Lỗi thực thi câu lệnh SQL.";
    }

    echo json_encode($json);
} else {
    echo json_encode(['status' => false, 'message' => 'Không có dữ liệu']);
}
?>
