<?php
// require_once "../../../core/file/function_proses.php";
include_once "./../../../core/file/services/closeBookService.php";
include_once "./../../../core/file/library.php";

class closeBook
{
    public function closeBook()
    {

        $library_class = new library_class();
        $tanggal     = $library_class->tanggal();
        $bulan         = $library_class->bulan();
        $tahun         = $library_class->tahun();
        $date        = $tahun . '-' . $bulan;
        // $date = "2023-01";
        $db = new db();
        $queryListBank = "SELECT * from tb_bank_cash";
        $getListBank = $db->selectAll($queryListBank);
        foreach ($getListBank as $result) {
            $bank = $result['id_bank_cash'];
            $next_date_periode = new DateTime();
            $previous_date_periode = new DateTime();
            $next_date_periode->modify("+1 month");
            $previous_date_periode->modify("-1 month");
            $next_period = $next_date_periode->format("Y-m");
            $next_periode_fix = date("Y-m", strtotime("+1 month"));

            // ! Get Saldo awal!

            $query_get_saldo_awal = "SELECT * from tb_priod where priod='" . $date . "' and id_bank_cash = '" . $bank . "'";
            // $query_get_saldo_awal = "SELECT * from tb_priod where priod='" . $periode3 . "'";
            $result_get_saldo_awal = mysqli_fetch_assoc($db->selectAll($query_get_saldo_awal));
            $saldo_awal = $result_get_saldo_awal['saldo_awal'];
            $saldo_akhir = $saldo_awal;

            // ! Get seluruh tranksasi pada periode saat ini untuk di ambil total pengeluaran dan pemasukan!
            // $query_get_data_transaksi = "SELECT * from tb_cash_receipt_payment where tanggal_bank like '%" . $periode3 . "%'";
            $query_get_data_transaksi = "SELECT * from tb_cash_receipt_payment where tanggal like '%" . $date . "%' and id_bank='" . $bank . "'";
            $result_get_transaksi = $db->selectAll($query_get_data_transaksi);
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
            $note = "Tutup Buku Bulan" . $date;

            // INSERT FINAL BALANCE
            // $query_update_saldo = "UPDATE tb_priod SET saldo_akhir='" . $saldo_akhir . "'where id_bank_cash='" . $bank . "'";
            $query_update_saldo = "UPDATE tb_priod SET saldo_akhir='" . $saldo_akhir . "', note='" . $note . "'where id_bank_cash='" . $bank . "' and priod='" . $date . "'";
            $db->selectAll($query_update_saldo);
            $db->insert("tb_priod", "id_bank_cash='" . $bank . "',saldo_awal='" . $saldo_akhir . "',priod='" . $next_periode_fix . "'");
        }
    }
    public function isLastDayOfMonth()
    {
        // Ambil tanggal hari ini
        $today = date('Y-m-d');

        // Ambil tanggal akhir bulan berikutnya dengan mktime() dan kurangi 1 hari
        $endOfMonthNextMonth = date('Y-m-d', strtotime('+1 month', strtotime(date('Y-m-d', strtotime('first day of this month')))) - 86400);

        // Bandingkan tanggal hari ini dengan tanggal akhir bulan berikutnya
        return $today === $endOfMonthNextMonth;
    }
}
