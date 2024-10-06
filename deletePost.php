<?php
include 'connect.php';

$data = json_decode(file_get_contents('php://input'), true);

$id = isset($data['id']) ? $data['id'] : null;

if ($id !== null) {
    $sql = "DELETE FROM post WHERE id = '$id'";
    $result = $conn->query($sql);
    if ($conn->affected_rows > 0) {
        $response = array(
            'status' => true,
            'message' => 'Xóa bài đăng thành công'
        );
    } else {
        $response = array(
            'status' => false,
            'message' => 'Không tìm thấy bài đăng hoặc xóa thất bại'
        );
    }
} else {
    $response = array(
        'status' => false,
        'message' => 'Thiếu id của bài đăng'
    );
}

echo json_encode($response);
$conn->close();
?>
