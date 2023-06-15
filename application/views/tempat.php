<div class="row">
    <div class="col-md-12">
        <h1 class="page-header">
            Tempat Kerja
        </h1>
    </div>
</div>
<!-- /. ROW  -->
<div class="row">
    <div class="col-md-12">
        <!-- Advanced Tables -->
        <?= $this->session->flashdata('msg') ?>
        <div class="panel panel-default">
            <div class="panel-heading">
                Data Tempat Kerja
            </div>
            <div class="panel-body">
                <a href="#" class="btn btn-success" data-toggle="modal" data-target="#addTempat"> <i class="fa fa-plus-circle"></i> Tambah Tempat Kerja</a>
                <br>
                <br>
                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover" id="dataTables-master">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Tempat Kerja</th>
                                <th>Opsi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $no = 1;
                            foreach ($lokasi as $v) {
                                echo '<tr><td>' . $no . '</td><td>' . $v->nama_lokasi . '</td><td><button class="btn btn-warning" onclick="get_lokasi(\'' . $v->id_lokasi . '\')">Detail</button></td></tr>';
                                $no += 1;
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!--  ADD-->
<div class="modal fade" id="addTempat" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Tambah Tempat Kerja</h4>
            </div>
            <form method="POST" action="<?= base_url('Tempat/tambah/') ?>">
                <div class="modal-body">
                    <div class="form-group">
                        <label>Nama Tempat Kerja</label>
                        <input type="text" class="form-control" name="nama_lokasi" required>
                    </div>
                    <div class="form-group">
                        <label>Titik Longitude</label>
                        <input type="text" class="form-control" name="long_lokasi" required>
                    </div>
                    <div class="form-group">
                        <label>Titik Latitude</label>
                        <input type="text" class="form-control" name="lat_lokasi" required>
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
<!-- ADD -->

<!--  EDIT-->
<div class="modal fade" id="editTempat" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Edit Jabatan</h4>
            </div>
            <form method="POST" action="<?= base_url('Tempat/edit/') ?>">
                <div class="modal-body">
                    <input type="hidden" name="id_lokasi" id="id_lokasi">
                    <div class="form-group">
                        <label>Nama Tempat Kerja</label>
                        <input type="text" class="form-control" name="nama_lokasi" id="nama_lokasi" required>
                    </div>
                    <div class="form-group">
                        <label>Titik Longitude</label>
                        <input type="text" class="form-control" name="long_lokasi" id="long_lokasi" required>
                    </div>
                    <div class="form-group">
                        <label>Titik Latitude</label>
                        <input type="text" class="form-control" name="lat_lokasi" id="lat_lokasi" required>
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
<!-- EDIT -->