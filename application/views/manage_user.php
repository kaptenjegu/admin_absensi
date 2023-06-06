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
        <div class="panel panel-default">
            <div class="panel-heading">
                <?= $judul ?>
            </div>
            <div class="panel-body">
                <form role="form" method="POST" action="<?= $action ?>">
                    <input type="hidden" name="id_akun" value="<?php if (isset($user)) {
                                                                    echo $user->id_akun;
                                                                } ?>">
                    <div class="form-group">
                        <label>Nama</label>
                        <input type="text" class="form-control" name="nama_user" <?php if (isset($user)) {
                                                                                        echo 'value="' . $user->nama_user . '"';
                                                                                    } ?> required>
                    </div>
                    <div class="form-group">
                        <label>Email</label>
                        <input type="text" class="form-control" name="email" <?php if (isset($user)) {
                                                                                    echo 'value="' . $user->email . '"';
                                                                                } ?> required>
                    </div>
                    <div class="form-group">
                        <label>Jabatan</label>
                        <select class="form-control" name="id_jabatan">
                            <?php
                            foreach ($jabatan as $v) {
                                if (isset($user)) {
                                    if ($v->id_jabatan == $user->id_jabatan) {
                                        $s = 'selected="selected"';
                                    } else {
                                        $s = '';
                                    }
                                }
                                echo '<option value="' . $v->id_jabatan . '" ' . $s . '>' . $v->nama_jabatan . '</option>';
                            }
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Sisa Cuti</label>
                        <input type="text" class="form-control" <?php if (isset($user)) {
                                                                    echo 'value="' . $user->sisa_cuti . '"';
                                                                } ?> readonly>
                    </div>
                    <div class="form-group">
                        <label>Nomor Telepon</label>
                        <input type="text" class="form-control" name="no_telp" <?php if (isset($user)) {
                                                                                    echo 'value="' . $user->no_telp . '"';
                                                                                } ?> required>
                    </div>
                    <div class="form-group">
                        <label>Role Karyawan</label>
                        <select class="form-control" name="role_pegawai">
                            <option value="1" <?php if (isset($user)) {
                                                    if ($user->role_pegawai == 1) {
                                                        echo 'selected="selected"';
                                                    }
                                                } ?>>Staff</option>
                            <option value="2" <?php if (isset($user)) {
                                                    if ($user->role_pegawai == 2) {
                                                        echo 'selected="selected"';
                                                    }
                                                } ?>>Atasan</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-info">Simpan</button>&emsp;
                    <a href="<?= base_url('User') ?>" class="btn btn-default">Kembali</a>&emsp;&emsp;&emsp;
                    <?php if (isset($user)) { ?>
                        <a href="<?= base_url('User/hapus_user/' . $user->id_akun) ?>" onclick="return(confirm('Apakah Anda yakin untuk menghapus user \'<?php echo $user->nama_user; ?>\' ?'))" class="btn btn-danger">Hapus</a>
                    <?php } ?>
                </form>
            </div>
        </div>

    </div>
</div>