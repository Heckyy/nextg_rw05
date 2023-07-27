<?php
session_start();
if (!empty($_POST['proses']) && !empty($_SESSION['id_employee'])) {
	include_once "./../../../core/file/function_proses.php";
	include_once "./../../../core/file/library.php";
	$db = new db();
	$library_class = new library_class();
	$tanggal 	= $library_class->tanggal();
	$bulan 		= $library_class->bulan();
	$tahun 		= $library_class->tahun();
	$date		= $tahun . '-' . $bulan;
	$proses = $_POST['proses'];
	if ($proses == "close_book") {
		$periode = $_POST['periode'];
		$periode2 = new DateTime($periode);
		$periode3 = $periode2->format("Y-m");
		$next_date_periode = new DateTime($periode);
		$previous_date_periode = new DateTime($periode);
		$note = $_POST['note'];
		$bank = $_POST['bank'];
		$next_date_periode->modify("+1 month");
		$previous_date_periode->modify("-1 month");
		$next_period = $next_date_periode->format("Y-m");
		$endDate = $_POST['periode'];
		$explode_date = explode("-", $endDate);
		$startDate = $explode_date[0] . "-" . $explode_date[1] . "-" . "01";
		$period_date = new DateTime($endDate);
		$period = $period_date->format("Y-m");
		// $next_periode_fix = date("Y-m", strtotime("+1 month"));


		$date =  new dateTime($periode);
		$format = $date->format("Y-m");
		$next_month = Date("Y-m", strtotime($format . "-01" . "+1 month"));
		// ! Get Saldo awal!

		$query_get_saldo_awal = "SELECT * from tb_priod where priod='" . $periode3 . "' and id_bank_cash = '" . $bank . "'";
		// $query_get_saldo_awal = "SELECT * from tb_priod where priod='" . $periode3 . "'";
		$result_get_saldo_awal = mysqli_fetch_assoc($db->selectAll($query_get_saldo_awal));
		$saldo_awal = $result_get_saldo_awal['saldo_awal'];
		$saldo_akhir = $saldo_awal;
		// ! Get seluruh tranksasi pada periode saat ini untuk di ambil total pengeluaran dan pemasukan!
		// $query_get_data_transaksi = "SELECT * from tb_cash_receipt_payment where tanggal like '%" . $periode3 . "%'";
		$querySelect = "SELECT * from tb_cash_receipt_payment where id_bank='" . $bank . "' AND tanggal_bank BETWEEN '" . $startDate . "' AND'" . $endDate . "'";
		// $query_get_data_transaksi = "SELECT * from tb_cash_receipt_payment where tanggal like '%" . $date . "%' and id_bank='" . $bank . "'";

		$result_get_transaksi = $db->selectAll($querySelect);
		if (mysqli_num_rows($result_get_transaksi) > 0) {
			foreach ($result_get_transaksi as $data) {
				$tipe_dana = $data['type'];
				if ($tipe_dana == "i") {
					$saldo_akhir += intval($data['amount']);
				} else {
					$saldo_akhir -= intval($data['amount']);
				}
			}
		}
		// echo $saldo_akhir;
		// die();



		// INSERT FINAL BALANCE
		$query_update_saldo = "UPDATE tb_priod SET saldo_akhir='" . $saldo_akhir . "', note='" . $note . "'where id_bank_cash='" . $bank . "' and priod='" . $periode3 . "'";
		$db->selectAll($query_update_saldo);
		$db->insert("tb_priod", "id_bank_cash='" . $bank . "',saldo_awal='" . $saldo_akhir . "',priod='" . $next_month . "'");
	}
}
