<?php
include 'connect.php';

class Note {
    public $id;
    public $idSinhVien;
    public $tieuDe;
    public $ngayTao;
    public $ngayCapNhat;
    public $noiDung;
    public $noiDungCua;

    function __construct($id, $idSinhVien, $tieuDe, $ngayTao, $ngayCapNhat, $noiDung, $noiDungCua) {
        $this->id = $id;
        $this->idSinhVien = $idSinhVien;
        $this->tieuDe = $tieuDe;
        $this->ngayTao = $ngayTao;
        $this->ngayCapNhat = $ngayCapNhat;
        $this->noiDung = $noiDung;
        $this->noiDungCua = $noiDungCua;
    }
}

// Lấy dữ liệu từ yêu cầu POST dưới dạng JSON
$data = json_decode(file_get_contents('php://input'), true);

$idSinhVien = isset($data['idSinhVien']) ? $data['idSinhVien'] : null;
$id = isset($data['id']) ? $data['id'] : null;
$tieuDe = isset($data['tieuDe']) ? $data['tieuDe'] : null;
$ngayTao = isset($data['ngayTao']) ? $data['ngayTao'] : null;
$ngayCapNhat = isset($data['ngayCapNhat']) ? $data['ngayCapNhat'] : null;
$noiDung = isset($data['noiDung']) ? $data['noiDung'] : null;
$noiDungCua = isset($data['noiDungCua']) ? $data['noiDungCua'] : null;

if($noiDungCua == null) $noiDungCua = "Của tôi";


$fields = [];
$values = [];

if ($id !== null) {
    $fields[] = 'id';
    $values[] = "'$id'";
}

$fields[] = 'idsinhvien';
$values[] = "'$idSinhVien'";
$fields[] = 'tieude';
$values[] = "'$tieuDe'";
$fields[] = 'ngayTao';
$values[] = "'$ngayTao'";
$fields[] = 'ngayCapNhat';
$values[] = "'$ngayCapNhat'";
$fields[] = 'noidung';
$values[] = "'$noiDung'";
$fields[] = 'noiDungCua';
$values[] = "'$noiDungCua'";

// Tạo câu lệnh SQL
$sql = "INSERT INTO note (" . implode(", ", $fields) . ")
        VALUES (" . implode(", ", $values) . ")
        ON DUPLICATE KEY UPDATE 
            idsinhvien = '$idSinhVien', 
            tieude = '$tieuDe', 
            ngayTao = '$ngayTao', 
            ngayCapNhat = '$ngayCapNhat', 
            noidung = '$noiDung', 
            noiDungCua = '$noiDungCua'";

// echo $sql;

if ($conn->query($sql) === TRUE) {
    if ($conn->affected_rows > 0) {
        if ($conn->affected_rows == 1) {

            $response = array(
                'status' => true,
                'message' => 'Thêm mới thành công'
            );
        } else {
            $response = array(
                'status' => true,
                'message' => 'Đã cập nhật'
            );
        }
    } else {
        echo "Lỗi: " . $conn->error;
        $response = array(
            'status' => false,
            'message' => 'Lỗi cập nhật'
        );
    }
} else {
    echo "Lỗi: " . $conn->error;
    $response = array(
        'status' => false,
        'message' => 'Thêm mới thất bại'
    );
}

echo json_encode($response);

$conn->close();
?>
