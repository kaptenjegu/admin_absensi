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
                Data Hari Libur
            </div>
            <div class="panel-body">
                <a href="#" class="btn btn-success" data-toggle="modal" data-target="#addForm"> <i class="fa fa-plus-circle"></i> Tambah Hari Libur</a>
                <br>
                <br>
                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover" id="dataTables-master">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Tanggal</th>
                                <th>Keterangan</th>
                                <th>Opsi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $no = 1;
                            foreach ($libur as $v) {
                                echo '<tr><td>' . $no . '</td><td>' . date('d-m-Y', strtotime($v->tgl_libur)) . '</td><td>' . $v->keterangan . '</td>
                                    <td><button class="btn btn-warning" data-toggle="modal" onclick="get_data(\'' . $v->id_libur . '\')">Detail</button></td></tr>';
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
<div class="modal fade" id="addForm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Tambah <?= $judul ?></h4>
            </div>
            <form method="POST" action="<?= base_url('Libur/simpan_tambah/') ?>">
                <div class="modal-body">
                    <div class="form-group">
                        <label>Tanggal Libur</label>
                        <input type="text" class="form-control" name="tgl_libur" required>
                    </div>
                    <div class="form-group">
                        <label>Keterangan</label>
                        <input type="text" class="form-control" name="keterangan" required>
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
<div class="modal fade" id="editForm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Edit <?= $judul ?></h4>
            </div>
            <form method="POST" action="<?= base_url('Libur/simpan_edit/') ?>">
                <div class="modal-body">
                    <input type="hidden" name="id_libur" id="id_libur">
                    <div class="form-group">
                        <label>Tanggal Libur</label>
                        <input type="text" class="form-control" name="tgl_libur" id="tgl_libur" required>
                    </div>
                    <div class="form-group">
                        <label>Keterangan</label>
                        <input type="text" class="form-control" name="keterangan" id="keterangan" required>
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