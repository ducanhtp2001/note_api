<?php
include 'connect.php';

// Lấy dữ liệu từ yêu cầu DELETE (id của tin nhắn)
$data = json_decode(file_get_contents('php://input'), true);
$id = isset($data['id']) ? $data['id'] : null;

if ($id !== null) {
    // Tạo câu lệnh SQL để xóa tin nhắn
    $sql = "DELETE FROM message WHERE id = '$id'";

    if ($conn->query($sql) === TRUE) {
        if ($conn->affected_rows > 0) {
            $response = array(
                'status' => true,
                'message' => 'Xóa tin nhắn thành công'
            );
        } else {
            $response = array(
                'status' => false,
                'message' => 'Không tìm thấy tin nhắn để xóa'
            );
        }
    } else {
        $response = array(
            'status' => false,
            'message' => 'Lỗi khi xóa: ' . $conn->error
        );
    }
} else {
    $response = array(
        'status' => false,
        'message' => 'Thiếu id của tin nhắn'
    );
}

echo json_encode($response);

$conn->close();
?>
