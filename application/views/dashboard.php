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
<?= $this->session->flashdata('msg') ?>
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
                                <th>Lokasi</th>
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
                                        <th>' . $v->nama_lokasi . '</th>
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

<div class="row">
    <div class="col-md-12">
        <!-- Advanced Tables -->
        <div class="panel panel-default">
            <div class="panel-heading">
                Pengajuan Lembur
            </div>
            <div class="panel-body">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover" id="dataTables-master2">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama</th>
                                <th>Lokasi</th>
                                <th>Tanggal</th>
                                <th>Absen Masuk</th>
                                <th>Absen Pulang</th>
                                <th>Keterangan</th>
                                <th>Opsi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $no = 1;
                            foreach ($lembur as $v) {
                                echo '<tr>
                                        <th>' . $no . '</th>
                                        <th>' . $v->nama_user . '</th>
                                        <th>' . $v->nama_lokasi . '</th>
                                        <th>' . date('d-m-Y',strtotime($v->tgl_lembur)) . '</th>
                                        <th>' . $v->mulai_lembur . '</th>
                                        <th>' . $v->selesai_lembur . '</th>
                                        <th>' . $v->keterangan . '</th>
                                        <th><a href="#" data-toggle="modal" onclick="get_data_lembur(\'' . $v->id_lembur . '\')" class="btn btn-success">disetujui</a>&emsp;
                                        <a href="' . base_url('Dashboard/hapus_lembur/' . $v->id_lembur ) . '" class="btn btn-danger">ditolak</a></th>
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
                <input type="hidden" name="id_user" id="id_user">
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
                    <input type="text" class="form-control" name="tgl_absen" id="tgl_absen" readonly>
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
                <div class="form-group">
                    <label>Alasan ditolak</label>
                    <input type="text" class="form-control" name="alasan">
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

<!--  MODAL LEMBUR -->
<div class="modal fade" id="detailLembur" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Detail Pengajuan Lembur</h4>
            </div>
            <form method="POST" action="<?= base_url('Dashboard/simpan_lembur/') ?>">
            <div class="modal-body">
                <input type="hidden" name="id_lembur" id="id_lembur">
                <input type="hidden" name="id_user" id="id_user2">
                <div class="form-group">
                    <label>Nama</label>
                    <input type="text" class="form-control" id="nama_user2" readonly>
                </div>
                <div class="form-group">
                    <label>Jabatan</label>
                    <input type="text" class="form-control" id="nama_jabatan2" readonly>
                </div>
                <div class="form-group">
                    <label>Tanggal Lembur</label>
                    <input type="text" class="form-control" name="tgl_lembur" id="tgl_lembur" readonly>
                </div>
                <div class="form-group">
                    <label>Mulai Lembur</label>
                    <input type="text" class="form-control" id="mulai_lembur" readonly>
                </div>
                <div class="form-group">
                    <label>Selesai Lembur</label>
                    <input type="text" class="form-control" id="selesai_lembur" readonly>
                </div>
                <div class="form-group">
                    <label>Keterangan</label>
                    <input type="text" class="form-control" id="keterangan2" readonly>
                </div>
                <div class="form-group">
                    <label>Point Lembur</label>
                    <input type="number" class="form-control" name="point_lembur" step="0.01" required>
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
<!-- MODAL LEMBUR -->
