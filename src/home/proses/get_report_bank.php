<?php
include_once "./../../../core/file/function_proses.php";
include_once "./../../../core/file/services/closeBookService.php";
session_start();

$grandTotal = 0;
$id_bank = $_POST['bank'];
$endDate = $_POST['date'];
$explode_date = explode("-", $endDate);
$startDate = $explode_date[0] . "-" . $explode_date[1] . "-" . "01";
$db = new db();
$querySelect = "SELECT * from tb_cash_receipt_payment where id_bank='" . $id_bank . "' AND tanggal_bank BETWEEN '" . $startDate . "' AND'" . $endDate . "'";
// $querySelect = "SELECT * from tb_cash_receipt";
$results = $db->selectAll($querySelect);
foreach ($results as $result) {
    if ($result['type'] == "i") {
        $grandTotal += $result['amount'];
    } else {
        $grandTotal -= $result['amount'];
    }
}


echo $grandTotal;
