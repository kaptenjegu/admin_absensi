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
                <form role="form" method="POST" action="<?= $action ?>" enctype="multipart/form-data">
                    <input type="hidden" name="id_akun" value="<?php if (isset($user)) {
                                                                    echo $user->id_akun;
                                                                } ?>">
                    <div class="form-group">
                        <label>Nama</label>
                        <input type="text" class="form-control" name="nama_user" maxlength="20" <?php if (isset($user)) {
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
                        <label>Lokasi Kerja</label>
                        <select class="form-control" name="id_lokasi">
                            <?php
                            foreach ($lokasi as $v) {
                                $s = '';
                                if (isset($user)) {
                                    if ($v->id_lokasi == $user->id_lokasi) {
                                        $s = 'selected="selected"';
                                    } else {
                                        $s = '';
                                    }
                                }
                                echo '<option value="' . $v->id_lokasi . '" ' . $s  . '>' . $v->nama_lokasi . '</option>';
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
                    <div class="form-group">
                        <label>Shift</label>
                        <select class="form-control" name="role_shift">
                            <option value="1" <?php if (isset($user)) {
                                                    if ($user->role_shift == 1) {
                                                        echo 'selected="selected"';
                                                    }
                                                } ?>>Shift Tetap / Jam Kerja Tetap</option>
                            <option value="2" <?php if (isset($user)) {
                                                    if ($user->role_shift == 2) {
                                                        echo 'selected="selected"';
                                                    }
                                                } ?>>Shift Berubah-ubah / Jam Kerja Berubah</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Menu</label>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox"  name="menu_kas" id="menu_kas" <?php if (isset($user)) {if(cek_permit($user->id_akun,'kas')){echo 'checked';}} ?>>
                            <label class="form-check-label" for="menu_kas">
                                Kas
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox"  name="menu_kas_tipe" id="menu_kas_tipe" <?php if (isset($user)) {if(cek_permit($user->id_akun,'kas_tipe')){echo 'checked';}} ?>>
                            <label class="form-check-label" for="menu_kas_tipe">
                                Kas Tipe
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox"  name="menu_aset" id="menu_aset" <?php if (isset($user)) {if(cek_permit($user->id_akun,'aset')){echo 'checked';}} ?>>
                            <label class="form-check-label" for="menu_aset">
                                Aset
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox"  name="menu_aset_pinjam" id="menu_aset_pinjam" <?php if (isset($user)) {if(cek_permit($user->id_akun,'aset_pinjam')){echo 'checked';}} ?>>
                            <label class="form-check-label" for="menu_aset_pinjam">
                                Aset Pinjam
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox"  name="menu_aset_kembali" id="menu_aset_kembali"<?php if (isset($user)) {if(cek_permit($user->id_akun,'aset_kembali')){echo 'checked';}} ?>>
                            <label class="form-check-label" for="menu_aset_kembali">
                                Aset Kembali
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox"  name="menu_monitoring_bayar" id="menu_monitoring_bayar" <?php if (isset($user)) {if(cek_permit($user->id_akun,'monitoring_bayar')){echo 'checked';}} ?>>
                            <label class="form-check-label" for="menu_monitoring_bayar">
                                Monitoring Bayar
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox"  name="menu_monitoring_riwayat_bayar" id="menu_monitoring_riwayat_bayar" <?php if (isset($user)) {if(cek_permit($user->id_akun,'monitoring_riwayat_bayar')){echo 'checked';}} ?>>
                            <label class="form-check-label" for="menu_monitoring_riwayat_bayar">
                                Riwayat Bayar
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox"  name="menu_tender" id="menu_monitoring_riwayat_bayar" <?php if (isset($user)) {if(cek_permit($user->id_akun,'tender')){echo 'checked';}} ?>>
                            <label class="form-check-label" for="menu_tender">
                                Tender
                            </label>
                        </div>
                    </div>
                    
                    <br>
                    <br>
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