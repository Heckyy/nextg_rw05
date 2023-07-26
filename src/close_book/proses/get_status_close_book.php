<?php

include_once "./../../../core/file/function_proses.php";
include_once "./../../../core/file/library.php";

$db = new db();
$date = $_POST["date"];
$datePriod = new DateTime($date);
$priod = $datePriod->format("Y-m");
$idBank = $_POST['idBank'];



// CHECK TO DATABASE

$query_get_status = "SELECT * from tb_priod where id_bank_cash = '" . $idBank . "' and priod='" . $priod . "'";
$getStatus = $db->selectAll($query_get_status);
$resultStatus = mysqli_fetch_assoc($getStatus);
// var_dump($resultStatus['saldo_akhir']);
if (mysqli_num_rows($getStatus) < 0) {
    $status = [
        "status" => "unknown"
    ];
} else {
    if ($resultStatus['saldo_akhir'] == "") {
        $status = [
            "status" => "still open"
        ];
        // 1 For Closed
    } else {
        $status = [
            "status" => "closed"
        ];
        // 0 For unclosed
    }
}
echo json_encode($status, 128);
