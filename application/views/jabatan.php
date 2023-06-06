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
        <?= $this->session->flashdata('msg') ?>
        <div class="panel panel-default">
            <div class="panel-heading">
                Data Jabatan
            </div>
            <div class="panel-body">
                <a href="#" class="btn btn-success" data-toggle="modal" data-target="#addForm"> <i class="fa fa-plus-circle"></i> Tambah Jabatan</a>
                <br>
                <br>
                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover" id="dataTables-master">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Jabatan</th>
                                <th>Opsi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $no = 1;
                            foreach ($jabatan as $v) {
                                echo '<tr><td>' . $no . '</td><td>' . $v->nama_jabatan . '</td><td><a href"#" class="btn btn-warning" onclick="get_data(\'' . $v->id_jabatan . '\')">Edit</a></td></tr>';
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
                <h4 class="modal-title" id="myModalLabel">Tambah Jabatan</h4>
            </div>
            <form method="POST" action="<?= base_url('Jabatan/tambah/') ?>">
            <div class="modal-body">
                <div class="form-group">
                    <label>Nama Jabatan</label>
                    <input type="text" class="form-control" name="nama_jabatan" required>
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
                <h4 class="modal-title" id="myModalLabel">Edit Jabatan</h4>
            </div>
            <form method="POST" action="<?= base_url('Jabatan/edit/') ?>">
            <div class="modal-body">
                <input type="hidden" name="id_jabatan" id="id_jabatan">
                <div class="form-group">
                    <label>Nama Jabatan</label>
                    <input type="text" class="form-control" name="nama_jabatan" id="nama_jabatan" required>
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