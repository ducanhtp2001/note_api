<?php
include 'connect.php';

$jsonData = file_get_contents('php://input');
$data = json_decode($jsonData, true);

$json = new stdClass();

if ($data) {
    $idSinhVien = $data['idSinhVien'];
    $id = $data['id'];

    if ($idSinhVien != null && $id != null) {
        // Kiểm tra xem bản ghi có tồn tại không
        $checkSql = "SELECT * FROM note WHERE id = '$id' AND idsinhvien = '$idSinhVien'";
        $checkResult = $conn->query($checkSql);

        if ($checkResult && $checkResult->num_rows > 0) {
            // Nếu bản ghi tồn tại, thực hiện xóa
            $sql = "DELETE FROM note WHERE id = '$id' AND idsinhvien = '$idSinhVien'";
            $result = $conn->query($sql);

            if ($result) {
                if ($conn->affected_rows > 0) {
                    $json->status = true;
                    $json->message = "Success";
                } else {
                    $json->status = false;
                    $json->message = "No record found to delete";
                }
            } else {
                $json->status = false;
                $json->message = "SQL Error: " . $conn->error;
            }
        } else {
            $json->status = false;
            $json->message = "No record found to delete";
        }
    } else {
        $json->status = false;
        $json->message = "Missing idSinhVien or id";
    }
} else {
    $json->status = false;
    $json->message = "No data";
}

$myJson = json_encode($json);
echo $myJson;

$conn->close();
?>
