<?php
include 'connect.php';

$jsonData = file_get_contents('php://input');
$data = json_decode($jsonData, true);

if ($data) {
    $id = $data['id'];
    $oldp = $data['oldPass'];
    $newp = $data['newPass'];
    $json = new stdClass();

    $sql = "SELECT * FROM taikhoan WHERE idsinhvien = '$id' AND matkhau = '$oldp'";

    $result = $conn->query($sql);

    if ($result) {
        if ($result->num_rows > 0) {
                $sql = "UPDATE taikhoan set matkhau = '$newp' WHERE idsinhvien = '$id'";
                $result = $conn->query($sql);
                if($result) {
                    $json->status = true;
                    $json->message = "Success";
                } else {
                    $json->status = true;
                    $json->message = "Update false";
                }
            } else {
                $json->status = false;
                $json->message = "Wrong password";
            }
        } else {
            $json->status = false;
            $json->message = "Query false";
        }
    


    $myJson = json_encode($json);
    echo $myJson;
} else {
    $json = new stdClass();
    $json->status = false;
    $json->message = "Không có dữ liệu";
    $myJson = json_encode($json);
    echo $myJson;
}
?>
