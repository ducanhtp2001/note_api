<?php
include 'connect.php';

$data = json_decode(file_get_contents('php://input'), true);

$id = isset($data['id']) ? $data['id'] : null;

if ($id !== null) {
    // Tạo câu lệnh SQL để lấy thông tin bài đăng
    $sql = "SELECT * FROM post WHERE id = '$id'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Lấy dữ liệu và trả về dưới dạng JSON
        $post = $result->fetch_assoc();
        $response = array(
            'status' => true,
            'data' => $post
        );
    } else {
        $response = array(
            'status' => false,
            'message' => 'Không tìm thấy bài đăng'
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
