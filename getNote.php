<?php
include 'connect.php';

class Note {
    public $id;
    public $tieuDe;
    public $ngayTao;
    public $ngayCapNhat;
    public $noiDung;

    function __construct($id, $tieuDe, $ngayTao, $ngayCapNhat, $noiDung) {
        $this->id = $id;
        $this->tieuDe = $tieuDe;
        $this->ngayTao = $ngayTao;
        $this->ngayCapNhat = $ngayCapNhat;
        $this->noiDung = $noiDung;
    }
}

$noteArr = array();

$jsonData = file_get_contents('php://input');
$data = json_decode($jsonData, true);

if ($data) {
    $idSinhVien = $data['id'];
    $json = new stdClass();

    $sql = 'SELECT * FROM note WHERE idsinhvien = ' . $idSinhVien;

    $result = $conn->query($sql);

    if ($result) {
        if ($result->num_rows > 0) {
            $json->status = true;
            while ($row = $result->fetch_assoc()) {
                $note = new Note(
                    $row['id'],
                    $row['tieude'],
                    $row['ngayTao'],
                    $row['ngayCapNhat'],
                    $row['noidung']
                );
                array_push($noteArr, $note);
            }
            $json->notes = $noteArr;
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
