<div class="row">
    <div class="col-md-12">
        <h1 class="page-header">
            <?= $judul ?>
        </h1>
    </div>
</div>
<!-- /. ROW  -->

<!-- /. ROW  -->
<div class="row">

    <div class="col-md-6 col-sm-12 col-xs-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                Absen Hari ini <?php //echo strtotime('d-m-Y', date(now)); 
                                ?>
            </div>
            <div class="panel-body">
                <div id="hari_ini"></div>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-sm-12 col-xs-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                Detail Tidak Masuk
            </div>
            <div class="panel-body">
                <div id="tidak_masuk"></div>
            </div>
        </div>
    </div>

</div>
<div class="row">
    <div class="col-md-12">
        <!-- Advanced Tables -->
        <div class="panel panel-default">
            <div class="panel-heading">
                Absen Pending
            </div>
            <div class="panel-body">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover" id="dataTables-master">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama</th>
                                <th>Tanggal</th>
                                <th>Absen Masuk</th>
                                <th>Absen Pulang</th>
                                <th>Status</th>
                                <th>Opsi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $no = 1;
                            foreach ($dashboard as $v) {
                                echo '<tr>
                                        <th>' . $no . '</th>
                                        <th>' . $v->nama_user . '</th>
                                        <th>' . date('d-m-Y',strtotime($v->tgl_absen)) . '</th>
                                        <th>' . $v->absen_masuk . '</th>
                                        <th>' . $v->absen_pulang . '</th>
                                        <th>' . $v->nama_pending . '</th>
                                        <th><button class="btn btn-warning" data-toggle="modal" onclick="get_data(\'' . $v->id_absen . '\')">Detail</button></th>
                                    </tr>';
                                $no +=1 ;
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!--  MODAL DETAIL -->
<div class="modal fade" id="detailForm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Detail Pengajuan Absensi</h4>
            </div>
            <form method="POST" action="<?= base_url('Dashboard/simpan_pengajuan/') ?>">
            <div class="modal-body">
                <input type="hidden" name="id_absen" id="id_absen">
                <input type="hidden" name="pending" id="pending">
                <div class="form-group">
                    <label>Nama</label>
                    <input type="text" class="form-control" id="nama_user" readonly>
                </div>
                <div class="form-group">
                    <label>Jabatan</label>
                    <input type="text" class="form-control" id="nama_jabatan" readonly>
                </div>
                <div class="form-group">
                    <label>Tanggal Absen</label>
                    <input type="text" class="form-control" id="tgl_absen" readonly>
                </div>
                <div class="form-group">
                    <label>Absen Masuk</label>
                    <input type="text" class="form-control" id="absen_masuk" readonly>
                </div>
                <div class="form-group">
                    <label>Absen Pulang</label>
                    <input type="text" class="form-control" id="absen_pulang" readonly>
                </div>
                <div class="form-group">
                    <label>Status</label>
                    <input type="text" class="form-control" id="status" readonly>
                </div>
                <div class="form-group">
                    <label>Keterangan</label>
                    <input type="text" class="form-control" id="keterangan" readonly>
                </div>
                <div class="form-group">
                    <label>Opsi</label>
                    <select class="form-control" name="opsi">
                        <option value="1">disetujui</option>
                        <option value="2">ditolak</option>
                    </select>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary">Simpan</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
            </div>
            </form>
        </div>
    </div>
</div>
<!-- MODAL DETAIL -->