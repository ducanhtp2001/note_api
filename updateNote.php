<?php
include 'connect.php';

class Note {
    public $id;
    public $tieuDe;
    public $ngayCapNhat;
    public $noiDung;

    function __construct($id, $tieuDe, $ngayCapNhat, $noiDung) {
        $this->id = $id;
        $this->tieuDe = $tieuDe;
        $this->ngayCapNhat = $ngayCapNhat;
        $this->noiDung = $noiDung;
    }
}

// Lấy dữ liệu từ yêu cầu POST dưới dạng JSON
$data = json_decode(file_get_contents('php://input'), true);

$id = $data['id'];
$tieuDe = $data['tieuDe'];
$ngayCapNhat = $data['ngayCapNhat'];
$noiDung = $data['noiDung'];

// Tạo một đối tượng Note mới
$note = new Note($id, $tieuDe, $ngayCapNhat, $noiDung);

// Tiến hành lưu đối tượng Note vào cơ sở dữ liệu
$sql = "UPDATE note SET tieude = '$note->tieuDe', ngayCapNhat = '$note->ngayCapNhat',
        noidung = '$note->noiDung' WHERE id = '$note->id'";


if ($conn->query($sql) === TRUE) {
    $response = array(
        'status' => true,
        'message' => 'Note update successfully'
    );
} else {
    $response = array(
        'status' => false,
        'message' => 'Failed to update note'
    );
}

echo json_encode($response);

$conn->close();
?>
