<?php
require_once "../../../core/file/function_proses.php";

class reportBank
{
    public function report($id_bank)
    {
        $db = new db();
        $this_date = date("Y-m-d");
        $nominal = 15000;
        $db->insert("tb_report_bank", "id_bank='" . $id_bank . "',date='" . $this_date . "',nominal='" . $nominal . "'");
    }
}
