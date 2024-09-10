<?php
include 'connect.php';

class Course {
    public $maMon;
    public $tenGiaoVien;
    public $tenMon;
    public $soTinChi;
    public $lopTinChi;


    function __construct($maMon, $tenGiaoVien, $tenMon, $soTinChi, $lopTinChi) {
        $this->maMon = $maMon;
        $this->tenGiaoVien = $tenGiaoVien;
        $this->tenMon = $tenMon;
        $this->soTinChi = $soTinChi;
        $this->lopTinChi = $lopTinChi;
    }
}

$classArr = array();

$jsonData = file_get_contents('php://input');
$data = json_decode($jsonData, true);

if ($data) {
    $idSinhVien = $data['id'];
    $json = new stdClass();

    $sql = "SELECT danhsachmonhoc.tenmon, danhsachloptinchi.tenGiaoVien, danhsachmonhoc.soTin, dangkimonhoc.mamon, dangkimonhoc.loptinchi
            FROM (((danhsachmonhoc
            JOIN danhsachloptinchi ON danhsachmonhoc.id = danhsachloptinchi.mamon)
            JOIN dangkimonhoc ON (dangkimonhoc.mamon = danhsachloptinchi.mamon AND dangkimonhoc.loptinchi = danhsachloptinchi.loptinchi)))
            WHERE dangkimonhoc.idsinhvien = '$idSinhVien';";

    $result = $conn->query($sql);
    // $json->idsinhvien = $idSinhVien;
    // $json->sql = $sql;
    if ($result) {
        if ($result->num_rows > 0) {
            $json->status = true;
            while ($row = $result->fetch_assoc()) {
                $class = new Course(
                    $row['mamon'],
                    $row['tenGiaoVien'],
                    $row['tenmon'],
                    $row['soTin'],
                    $row['loptinchi'] // Loại bỏ dấu phẩy không cần thiết ở đây
                );
                array_push($classArr, $class);
            }
            $json->courses = $classArr;
        } else {
            $json->status = false;
        }
    } else {
        $json->status = false;
    }
    
    $myJson = json_encode($json);
    echo $myJson;
} else {
    $json = new stdClass();
    $json->status = false;
    $json->message = "khong co data";
    $myJson = json_encode($json);
    echo $myJson;
}
?>
