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

// Lấy dữ liệu từ yêu cầu POST dưới dạng JSON
$data = json_decode(file_get_contents('php://input'), true);

$idSinhVien = $data['id'];
$tieuDe = $data['tieuDe'];
$ngayTao = $data['ngayTao'];
$ngayCapNhat = $data['ngayCapNhat'];
$noiDung = $data['noiDung'];

// Tạo một đối tượng Note mới
$note = new Note($idSinhVien, $tieuDe, $ngayTao, $ngayCapNhat, $noiDung);

// Tiến hành lưu đối tượng Note vào cơ sở dữ liệu
$sql = "INSERT INTO note (idsinhvien, tieude, ngayTao, ngayCapNhat, noidung)
        VALUES ('$note->id', '$note->tieuDe', '$note->ngayTao', '$note->ngayCapNhat', '$note->noiDung')";

if ($conn->query($sql) === TRUE) {
    $response = array(
        'status' => true,
        'message' => 'Note added successfully'
    );
} else {
    $response = array(
        'status' => false,
        'message' => 'Failed to add note'
    );
}

echo json_encode($response);

$conn->close();
?>
