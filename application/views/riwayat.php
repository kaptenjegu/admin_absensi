<div class="row">
    <div class="col-md-12">
        <h1 class="page-header">
            <?= $judul ?>
        </h1>
    </div>
</div>
<!-- /. ROW  -->



<div class="row">
    <div class="col-md-12">
        <!-- Advanced Tables -->
        <div class="panel panel-default">
            <div class="panel-heading">
                Riwayat Absen
            </div>
            <div class="panel-body">
                <form role="form" action="<?= base_url('Riwayat/data_rilis/') ?>" method="GET">
                    <div class="form-group">
                        <label>Nama</label>
                        <select class="form-control" name="id_akun">
                            <?php
                            foreach ($user as $v) {
                                if (isset($_GET['id_akun'])){
                                    if($_GET['id_akun'] == $v->id_akun){
                                        $r = 'selected="true"';
                                    }else{
                                        $r = '';
                                    }
                                }
                                echo '<option value="' . $v->id_akun . '" ' . $r . '>' . $v->nama_user . '</option>';
                            }
                            ?>

                        </select>
                    </div>
                    <div class="form-group">
                        <label>Bulan</label>
                        <select class="form-control" name="bulan">
                            <option value="1" <?php
                                                if (isset($_GET['bulan'])) {
                                                    if ($_GET['bulan'] == 1) {
                                                        echo 'selected="true"';
                                                    }
                                                } ?>>Januari
                                <?= date('Y') ?>
                            </option>
                            <option value="2" <?php
                                                if (isset($_GET['bulan'])) {
                                                    if ($_GET['bulan'] == 2) {
                                                        echo 'selected="true"';
                                                    }
                                                } ?>>Februari
                                <?= date('Y') ?>
                            </option>
                            <option value="3" <?php
                                                if (isset($_GET['bulan'])) {
                                                    if ($_GET['bulan'] == 3) {
                                                        echo 'selected="true"';
                                                    }
                                                } ?>>Maret
                                <?= date('Y') ?>
                            </option>
                            <option value="4" <?php
                                                if (isset($_GET['bulan'])) {
                                                    if ($_GET['bulan'] == 4) {
                                                        echo 'selected="true"';
                                                    }
                                                } ?>>April
                                <?= date('Y') ?>
                            </option>
                            <option value="5" <?php
                                                if (isset($_GET['bulan'])) {
                                                    if ($_GET['bulan'] == 5) {
                                                        echo 'selected="true"';
                                                    }
                                                } ?>>Mei
                                <?= date('Y') ?>
                            </option>
                            <option value="6" <?php
                                                if (isset($_GET['bulan'])) {
                                                    if ($_GET['bulan'] == 6) {
                                                        echo 'selected="true"';
                                                    }
                                                } ?>>Juni
                                <?= date('Y') ?>
                            </option>
                            <option value="7" <?php
                                                if (isset($_GET['bulan'])) {
                                                    if ($_GET['bulan'] == 7) {
                                                        echo 'selected="true"';
                                                    }
                                                } ?>>Juli
                                <?= date('Y') ?>
                            </option>
                            <option value="8" <?php
                                                if (isset($_GET['bulan'])) {
                                                    if ($_GET['bulan'] == 8) {
                                                        echo 'selected="true"';
                                                    }
                                                } ?>>Agustus
                                <?= date('Y') ?>
                            </option>
                            <option value="9" <?php
                                                if (isset($_GET['bulan'])) {
                                                    if ($_GET['bulan'] == 9) {
                                                        echo 'selected="true"';
                                                    }
                                                } ?>>September
                                <?= date('Y') ?>
                            </option>
                            <option value="10" <?php
                                                if (isset($_GET['bulan'])) {
                                                    if ($_GET['bulan'] == 10) {
                                                        echo 'selected="true"';
                                                    }
                                                } ?>>Oktober
                                <?= date('Y') ?>
                            </option>
                            <option value="11" <?php
                                                if (isset($_GET['bulan'])) {
                                                    if ($_GET['bulan'] == 11) {
                                                        echo 'selected="true"';
                                                    }
                                                } ?>>November
                                <?= date('Y') ?>
                            </option>
                            <option value="12" <?php
                                                if (isset($_GET['bulan'])) {
                                                    if ($_GET['bulan'] == 12) {
                                                        echo 'selected="true"';
                                                    }
                                                } ?>>Desember
                                <?= date('Y') ?>
                            </option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-success"><i class="fa fa-search"></i> Tampilkan</button>
                </form>
                <br>
                <br>
                <br>
                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover" id="dataTables-master">
                        <thead>
                            <tr>
                                <th>Tanggal</th>
                                <th>Absen Masuk</th>
                                <th>Absen Pulang</th>
                                <th>Catatan</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach ($riwayat as $v) {
                                echo '<tr>
                                    <td>' . date('d-m-Y', strtotime($v->tgl_absen)) . '</td>
                                    <td>' . $v->absen_masuk . '</td>
                                    <td>' . $v->absen_pulang . '</td>
                                    <td>' . $v->catatan_pending . '</td>
                                </tr>';
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>