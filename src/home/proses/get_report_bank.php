<?php
include_once "./../../../core/file/function_proses.php";
include_once "./../../../core/file/services/closeBookService.php";
session_start();
$grandTotal = 0;
$id_bank = $_POST['bank'];
$endDate = $_POST['date'];
$explode_date = explode("-", $endDate);
$startDate = $explode_date[0] . "-" . $explode_date[1] . "-" . "01";
$period_date = new DateTime($endDate);
$period = $period_date->format("Y-m");
$db = new db();
// Get Starting Balance From Each Bank
$query_get_bank = "SELECT  * from tb_priod where id_bank_cash='" . $id_bank . "' and priod='" . $period . "'";
$results_get_bank = $db->selectAll($query_get_bank);
$final_get_bank = mysqli_fetch_assoc($results_get_bank);
if (mysqli_num_rows($results_get_bank) > 0) {
    $saldo_awal = $final_get_bank['saldo_awal'];
} else {
    $saldo_awal = 0;
}
$grandTotal = $saldo_awal;
$querySelect = "SELECT * from tb_cash_receipt_payment where id_bank='" . $id_bank . "' AND tanggal_bank BETWEEN '" . $startDate . "' AND'" . $endDate . "' AND status='1'";
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
// var_dump($grandTotal);
// var_dump("Start Date :" . $startDate . " End Date : " . $endDate);
