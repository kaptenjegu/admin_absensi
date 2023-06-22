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
                Metode Auto
            </div>
            <div class="panel-body">
                <form role="form" action="<?= base_url('Tools/simpan/') ?>" method="POST">
                    <div class="form-group">
                        <label>Metode</label>
                        <select class="form-control" name="id_metode" required>
                            <option value="1">Auto Absen</option>                            
                            <option value="2">Auto Cuti</option>                            
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Nama</label>
                        <select class="form-control" name="id_akun">
                            <?php
                            foreach ($akun as $v) {
                                echo '<option value="' . $v->id_akun . '">' . $v->nama_user . '</option>';
                            }
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Tanggal</label>
                        <input type="text" class="form-control" name="tgl_range" required>
                    </div>

                    <button type="submit" class="btn btn-success"><i class="fa fa-save"></i> Simpan</button>
                </form>                
            </div>
        </div>
    </div>
</div>