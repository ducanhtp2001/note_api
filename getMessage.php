<?php
include 'connect.php'; 
include 'ultil.php';

$data = json_decode(file_get_contents('php://input'), true);
$idPost = isset($data['idPost']) ? $data['idPost'] : null; 

$messages = getMessagesByIdPost($idPost);

$response = [];

if (empty($messages)) {
    $response = [
        'status' => false,
        'message' => 'Không có tin nhắn nào được tìm thấy.'
    ]; 
} else {
    $result = [];
    foreach($messages as $message) {
        $info = getInfoAccount($message['idSinhVien']);
        $result[] = [
            "message" => $message,
            "info" => $info
        ];
    }
    $response = [
        'status' => true,
        'result' => $result
    ];
}

echo json_encode($response); 

$conn->close();
?>
