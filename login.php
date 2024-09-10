<?php
include 'connect.php';
$jsonData = file_get_contents('php://input');
$data = json_decode($jsonData, true);

if ($data) {
    $idSinhVien = $data['idSinhVien'];
    $password = $data['password'];
    $json = new stdClass();

    $sql = "SELECT * FROM taikhoan WHERE taikhoan = '" . $idSinhVien . "' AND matkhau = '" . $password . "'";


    $json->idSinhVien = $idSinhVien;
    $result = $conn->query($sql);

    if ($result) {
        if ($result->num_rows > 0) {
             $json->status = true;
             $json->message = "Đăng nhập thành công";
        } else {
            $json->status = false;
            $json->message = "Tài khoản hoặc mật khẩu sai";
        }
    } else {
        $json->status = false;
        $json->message = "Tài khoản hoặc mật khẩu sai";
    }

    $myJson = json_encode($json);
    echo $myJson;
} else {
    echo "khong co data";
}
?>
