<?php
include 'connect.php';
include 'model.php';

$jsonData = file_get_contents('php://input');
$data = json_decode($jsonData, true);

header('Content-Type: application/json; charset=utf-8');

if ($data) {
    $maMon = $data['maMon'];
    $lopTinChi = $data['lopTinChi'];
    $json = new stdClass();

    $sql = "SELECT * FROM dangkimonhoc JOIN thongtinsinhvien ON dangkimonhoc.idsinhvien = thongtinsinhvien.id
            WHERE dangkimonhoc.mamon = '$maMon' AND dangkimonhoc.loptinchi = '$lopTinChi'";

    $result = $conn->query($sql);

    if ($result) {
        if ($result->num_rows > 0) {
            $json->status = true;
            $students = [];
            while ($row = $result->fetch_assoc()) {
                $sinhVien = new SinhVien(
                    $row['id'],
                    $row['hoten'],
                    $row['ngaysinh'],
                    $row['gioitinh'],
                    $row['quequan'],
                    $row['gmail'],
                    $row['sdt'],
                    $row['khoa'],
                    $row['nienkhoa'],
                    $row['lop']
                );
                $students[] = $sinhVien;
            }
            $json->sinhVien = $students;
        } else {
            $json->status = false;
        }
    }


    $myJson = json_encode($json);
    echo $myJson;
} else {
    $json = new stdClass();
    $json->status = false;
    $json->message = "Không có dữ liệu";
    $myJson = json_encode($json);
    echo $myJson;
}
?>
