<?php
include 'connect.php'; 
include 'ultil.php';

$data = json_decode(file_get_contents('php://input'), true);
$maMon = isset($data['maMon']) ? $data['maMon'] : null;
$lopTinChi = isset($data['lopTinChi']) ? $data['lopTinChi'] : null;

$posts = getPostsByMaMonAndLopTinChi($maMon, $lopTinChi);

$result = [];

// Kiểm tra kết quả
if (empty($posts)) {
    $response = [
        'status' => false,
        'message' => 'Không có bài viết nào được tìm thấy.'
    ]; 
} else {
    foreach($posts as $post) {
        $info = getInfoAccount($post['idSinhVien']);
        $result[] = [
            "post" => $post,
            "info" => $info
        ];
    };
    $response = [
        'status' => true,
        'result' => $result
    ];
}

echo json_encode($response); 

$conn->close();
?>
