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
                Data User
            </div>
            <div class="panel-body">
                <a href="<?= base_url('User/tambah/') ?>" class="btn btn-success"> <i class="fa fa-plus-circle"></i> Tambah User</a>
                <br>
                <br>
                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover" id="dataTables-master">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama</th>
                                <th>Jabatan</th>
                                <th>Email</th>
                                <th>No Telp</th>
                                <th>Opsi</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                        $no = 1;
                        foreach($user as $v){
                            echo '<tr><td>' . $no . '</td><td>' . $v->nama_user . '</td><td>' . $v->nama_jabatan . '</td><td>' . $v->email . '</td><td>' . $v->no_telp . '</td><td><a href="' . base_url('User/edit/' . $v->id_akun) . '" class="btn btn-warning">Edit</td></tr>';
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