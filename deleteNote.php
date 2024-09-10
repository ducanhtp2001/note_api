<?php
include 'connect.php';

$jsonData = file_get_contents('php://input');
$data = json_decode($jsonData, true);

$json = new stdClass();

if ($data) {
    $idSinhVien = $data['idSinhVien'];
    $id = $data['id'];

    if ($idSinhVien != null && $id != null) {
        $sql = "DELETE FROM note WHERE id = '$id' AND idsinhvien = '$idSinhVien'";
        $result = $conn->query($sql);

        if ($result) {
            $json->status = true;
            $json->message = "Success";
        } else {
            $json->status = false;
            $json->message = "False";
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
?>
