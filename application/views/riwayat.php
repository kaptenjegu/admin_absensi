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
    <?= $this->session->flashdata('msg') ?>
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
                                if (isset($_GET['id_akun'])) {
                                    if ($_GET['id_akun'] == $v->id_akun) {
                                        $r = 'selected="true"';
                                    } else {
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
            </div>
        </div>

        <div class="panel panel-default">
            <div class="panel-heading">
                <b>Data Absen</b>
            </div>
            <div class="panel-body">
                <?php if(isset($_GET['bulan'])){ ?>
                <form role="form" action="<?= base_url('Riwayat/tambah_libur_lembur/') ?>" method="POST">
                    <div class="form-group">
                        <label>Tambah Absen Libur Shift / Lembur</label>
                    </div>
                    <input type="hidden" name="id_akun" value="<?= $_GET['id_akun'] ?>">
                    <input type="hidden" name="bulan" value="<?= $_GET['bulan'] ?>">
                    <div class="form-group">
                        <label>Tipe Absen</label>
                        <select class="form-control" name="tipe_absen">
                            <option value="11">Libur Shift</option>
                            <option value="99999">Lembur</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Tanggal</label>
                        <input type="text" class="form-control" name="tgl_absen" id="tgl_absen" required>
                    </div>
                    <div class="form-group">
                        <label><b>Mulai Lembur (Jika libur shift, silakan diabaikan)</b></label>
                        <input type="text" class="form-control" name="mulai_absen" id="mulai_absen" required>
                    </div>
                    <div class="form-group">
                        <label><b>Selesai Lembur (Jika libur shift, silakan diabaikan)</b></label>
                        <input type="text" class="form-control" name="selesai_absen" id="selesai_absen" required>
                    </div>
                    <div class="form-group">
                        <label>Point Lembur (Jika libur shift, silakan diisi 0)</label>
                        <input type="number" class="form-control" name="point_lembur" step="0.01" required>
                    </div>
                    <button type="submit" class="btn btn-info"><i class="fa fa-plus"></i> Tambahkan</button>
                </form>
                <br><br><br>
                <?php } ?>

                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover" id="dataTables-master">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Tanggal</th>
                                <th>Absen Masuk</th>
                                <th>Absen Pulang</th>
                                <th>Catatan</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $no = 1;
                            foreach ($riwayat as $v) {
                                echo '<tr>
                                    <td>' . $no . '</td>
                                    <td>' . date('d-m-Y', strtotime($v->tgl_absen)) . '</td>
                                    <td>' . $v->absen_masuk . '</td>
                                    <td>' . $v->absen_pulang . '</td>
                                    <td>' . $v->catatan_pending . '</td>
                                </tr>';
                                $no += 1;
                            }
                            ?>
                        </tbody>
                    </table>
                </div>

                <br>
                <br>
                <br>
                <b>Data Lembur</b>


                <br>
                <br>
                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover" id="dataTables-master2">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Tanggal</th>
                                <th>Mulai Lembur</th>
                                <th>Selesai Lembur</th>
                                <th>Point</th>
                                <th>Keterangan</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $no = 1;
                            foreach ($lembur as $v) {
                                echo '<tr>
                                    <td>' . $no . '</td>
                                    <td>' . date('d-m-Y', strtotime($v->tgl_lembur)) . '</td>
                                    <td>' . $v->mulai_lembur . '</td>
                                    <td>' . $v->selesai_lembur . '</td>
                                    <td>' . $v->point_lembur . '</td>
                                    <td>' . $v->keterangan . '</td>
                                </tr>';
                                $no += 1;
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <br>
        <br>



    </div>
</div>