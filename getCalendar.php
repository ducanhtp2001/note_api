<?php
include 'connect.php';

class Schedule {
    public $maMon;
    public $tenMon;
    public $soTinChi;
    public $lopTinChi;
    public $ngayHoc;
    public $caHoc;
    public $phongHoc;

    function __construct($maMon, $tenMon, $soTinChi, $lopTinChi, $ngayHoc, $caHoc, $phongHoc) {
        $this->maMon = $maMon;
        $this->tenMon = $tenMon;
        $this->soTinChi = $soTinChi;
        $this->lopTinChi = $lopTinChi;
        $this->ngayHoc = $ngayHoc;
        $this->caHoc = $caHoc;
        $this->phongHoc = $phongHoc;
    }
}

$scheduleArr = array();

$jsonData = file_get_contents('php://input');
$data = json_decode($jsonData, true);

if ($data) {
    $idSinhVien = $data['id'];
    $json = new stdClass();

    $sql = "SELECT danhsachmonhoc.tenmon, danhsachmonhoc.sotin, lichhoc.mamon, lichhoc.loptinchi, dangkimonhoc.idsinhvien, lichhoc.ngayhoc, lichhoc.cahoc, lichhoc.phonghoc
        FROM (((danhsachmonhoc
        JOIN danhsachloptinchi ON danhsachmonhoc.id = danhsachloptinchi.mamon)
        JOIN dangkimonhoc ON (dangkimonhoc.mamon = danhsachloptinchi.mamon AND dangkimonhoc.loptinchi = danhsachloptinchi.loptinchi))
        JOIN lichhoc ON (dangkimonhoc.mamon = lichhoc.mamon AND dangkimonhoc.loptinchi = lichhoc.loptinchi))
        WHERE dangkimonhoc.idsinhvien = '$idSinhVien' ORDER BY lichhoc.ngayhoc";

    $result = $conn->query($sql);
    // $json->idsinhvien = $idSinhVien;
    if ($result) {
        if ($result->num_rows > 0) {
            
            $json->status = true;
            while ($row = $result->fetch_assoc()) {
                $schedule = new Schedule(
                    $row['mamon'],
                    $row['tenmon'],
                    $row['sotin'],
                    $row['loptinchi'],
                    $row['ngayhoc'],
                    $row['cahoc'],
                    $row['phonghoc']
                );
                array_push($scheduleArr, $schedule);
            }
            $json->schedules = $scheduleArr;
        } else {
            $json->status = false;
        }
    }

    
    $myJson = json_encode($json);
    echo $myJson;
} else {
    $json->status = false;
    $json->message = "khong co data";
    $myJson = json_encode($json);
    echo $myJson;
}
?>
