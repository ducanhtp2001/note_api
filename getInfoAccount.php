<?php
include 'connect.php';

class SinhVien {
    public $id;
    public $hoTen;
    public $ngaySinh;
    public $gioiTinh;
    public $queQuan;
    public $gmail;
    public $sdt;
    public $khoa;
    public $nienKhoa;
    public $lop;

    function __construct($id, $hoTen, $ngaySinh, $gioiTinh, $queQuan, $gmail, $sdt, $khoa, $nienKhoa, $lop) {
        $this->id = $id;
        $this->hoTen = $hoTen;
        $this->ngaySinh = $ngaySinh;
        $this->gioiTinh = $gioiTinh;
        $this->queQuan = $queQuan;
        $this->gmail = $gmail;
        $this->sdt = $sdt;
        $this->khoa = $khoa;
        $this->nienKhoa = $nienKhoa;
        $this->lop = $lop;
    }
}

$jsonData = file_get_contents('php://input');
$data = json_decode($jsonData, true);

if ($data) {
    $idSinhVien = $data['id'];
    $json = new stdClass();

    $sql = "SELECT * FROM `thongtinsinhvien` WHERE id = $idSinhVien";

    $result = $conn->query($sql);

    if ($result) {
        if ($result->num_rows > 0) {
            $json->status = true;
            $row = $result->fetch_assoc();
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
            $json->sinhVien = $sinhVien;
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
