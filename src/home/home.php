<?php
// include_once "./../../../../core/file/function_proses.php";


class home
{


    function view_home($db, $e, $library_class, $view, $page)
    {

        $date = new DateTime();
        $currenDate = $date->format("Y-m-d");
        $library_class = new library_class();
        $bulan      = $library_class->bulan();
        $tahun      = $library_class->tahun();
        $priod = $tahun . '-' . $bulan;
        $in = 0;
        $out = 0;
        $input = $db->select('tb_cash_receipt_payment', 'tanggal LIKE "%' . $priod . '%" && status="1"', 'id_cash_receipt_payment', 'ASC');
        foreach ($input as $key => $i) {
            if ($i['type'] == 'i') {
                $in = $in + $i['amount'];
            } else {
                $out = $out + $i['amount'];
            }
        }
        $thisDate = date("Y-m-d");
        $perPage = 10;

        $totalPages = "";
        $cek_error = "";
        $dbConn = new db();
        $queryBanks = "SELECT * from tb_bank_cash";
        $banks = $dbConn->selectAll($queryBanks);


?>
        <script src="<?php echo $e; ?>/src/home/js/jsproses.js"></script>
        <script src="<?php echo $e; ?>/src/home/js/closebook.js"></script>
        <div class="app-card-header p-3 main-content container-fluid">
            <div class="row justify-content-between align-items-center line">
                <div class="col-auto">
                    <h6 class="app-card-title">
                        Dashboard
                    </h6>
                </div>
            </div>
        </div>

        <div class="app-card-body pb-3 main-content container-fluid">
            <section class="section">
                <div class="row mb-4">
                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-header">
                                <h3 class='card-heading' align="center">
                                    This Month's Income
                                </h3>
                            </div>
                            <div class="card-body" align="center">
                                <h2>
                                    Rp.<?php echo number_format($in, 2, ',', '.'); ?>
                                </h2>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-header" align="center">
                                <h3 class='card-heading'>
                                    This month's release
                                </h3>
                            </div>
                            <div class="card-body" align="center">
                                <h2>
                                    Rp.<?php echo number_format($out, 2, ',', '.'); ?>
                                </h2>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-header" align="center">
                                <h3 class='card-heading'>
                                    Report Bank
                                </h3>
                            </div>
                            <div class="card-body" align="center">
                                <input type="date" id="date" value="<?= $thisDate ?>" onchange="reportBank()">
                                <select name="bank" id="bank" onchange="reportBank()">
                                    <?php foreach ($banks as $bank) : ?>
                                        <option value="<?= $bank['id_bank_cash'] ?>"><?= $bank['bank_cash'] ?></option>
                                    <?php endforeach; ?>
                                </select>
                                <h2 class="mt-3" id="nominal">
                                    Rp.<?php echo number_format($out, 2, ',', '.'); ?>
                                </h2>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <section class="section" style="display: none;">
                <div class="app-card-body pb-3 main-content container-fluid">
                    <div class="scroll">
                        <table class="table mb-0">
                            <thead>
                                <tr>
                                    <td width="50px" align="center">No</td>
                                    <td width="200px">No Tiket</td>
                                    <td width="250px">Date</td>
                                    <td width="200px">Kategori</td>
                                    <td width="250px">Name</td>
                                    <td>Deskripsi</td>
                                    <td>Lokasi</td>
                                    <td width="80px">Status</td>
                                </tr>
                            </thead>
                            <tbody id="data_view"><?php echo $cek_error; ?></tbody>
                        </table>
                    </div>
                </div>
                <input type="hidden" id="totalPages" value="<?php echo $totalPages; ?>">
                <div class="row">
                    <div id="pagination"></div>
                </div>
            </section>
        </div>
        <div class="app-card-header p-3 main-content container-fluid d-none">
            <div class="row justify-content-between align-items-center line d-none">
                <div class="col-auto">
                    <h6 class="app-card-title">
                        Report Bank
                    </h6>
                </div>
            </div>
        </div>
        <div class="d-none">
            <h4>Select Date : </h4>
            <input type="date" value="<?= $currenDate ?>" name="" id="">
        </div>
        <section class="section d-none">
            <div class="row mb-4">
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-header">
                            <h3 class='card-heading' align="center">
                                Kas Kecil
                            </h3>
                        </div>
                        <div class="card-body" align="center">
                            <h2>
                                Rp.<?php echo number_format($in, 2, ',', '.'); ?>
                            </h2>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-header" align="center">
                            <h3 class='card-heading'>
                                Kas Besar
                            </h3>
                        </div>
                        <div class="card-body" align="center">
                            <h2>
                                Rp.<?php echo number_format($out, 2, ',', '.'); ?>
                            </h2>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-header" align="center">
                            <h3 class='card-heading'>
                                BCA-IPL
                            </h3>
                        </div>
                        <div class="card-body" align="center">
                            <h2>
                                Rp.<?php echo number_format($out, 2, ',', '.'); ?>
                            </h2>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section class="section d-none">
            <div class="row mb-4">
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-header">
                            <h3 class='card-heading' align="center">
                                BCA-OPERASIONAL
                            </h3>
                        </div>
                        <div class="card-body" align="center">
                            <h2>
                                Rp.<?php echo number_format($in, 2, ',', '.'); ?>
                            </h2>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-header" align="center">
                            <h3 class='card-heading'>
                                BNI
                            </h3>
                        </div>
                        <div class="card-body" align="center">
                            <h2>
                                Rp.<?php echo number_format($out, 2, ',', '.'); ?>
                            </h2>
                        </div>
                    </div>
                </div>

            </div>
        </section>
<?php
    }
}
?>