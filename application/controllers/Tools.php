<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Tools extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        date_default_timezone_set('Asia/Jakarta');
        cek_login();
    }

    public function index()
    {
        $data['judul'] = 'Menu Khusus';
        $data['page'] = 'Tools';
        $data['url'] = base_url('Tools');

        $this->db->where('tgl_delete', null);
        $data['akun'] = $this->db->get('fai_akun')->result();

        $this->load->view('header', $data);
        $this->load->view('tools', $data);
        $this->load->view('footer');
    }

    public function simpan()
    {
        try {
            $this->db->trans_start();

            $id_metode = $this->input->post('id_metode');   //1 - auto absen , 2 - auto cuti
            $id_akun = $this->input->post('id_akun');
            $tgl_range = $this->input->post('tgl_range');

            switch ($id_metode) {
                case 1:
                    $query = $this->auto_absen($tgl_range, $id_akun);
                    $this->db->query($query);
                    break;
                case 2:
                    $query = $this->auto_cuti($tgl_range, $id_akun);
                    $this->db->query($query);
                    break;
                case 3:
                    $query = $this->auto_absen2($tgl_range, $id_akun);
                    $this->db->query($query);
                    break;
                case 4:
                    $query = $this->absen_sakit($tgl_range, $id_akun);
                    $this->db->query($query);
                    break;
                case 5:
                    $query = $this->absen_unpaid($tgl_range, $id_akun);
                    $this->db->query($query);
                    break;
            }

            $this->session->set_flashdata('msg', '<div class="alert alert-success alert-dismissable">
					<center><b>Fungsi Auto telah dieksekusi</b></center></div>');

            $this->db->trans_complete();
        } catch (\Throwable $e) {
            $this->session->set_flashdata('msg', '<div class="alert alert-danger alert-dismissable">
					<center><b>Caught exception: ' .  $e->getMessage() . '</b></center></div>');
        }
        redirect('Tools');
    }

    //generate query, !!! per bulan, jika ganti bulan, maka jalankan fungsi lagi secara manual !!!
    private function auto_absen($tgl, $id_akun)
    {
        $tgl = explode(' - ', $tgl);
        $t1 = explode('-', $tgl[0]);
        $t2 = explode('-', $tgl[1]);
        $q = "INSERT INTO fai_absen(id_absen,id_user,tgl_absen,absen_masuk,absen_pulang,pending,catatan_pending)
                            VALUES ";
        for ($n = $t1[2]; $n <= $t2[2]; $n++) {
            if (strlen($n) == 1) {
                $n1 = '0' . $n;
            } else {
                $n1 = $n;
            }

            if ((date('D', strtotime($t1[0] . '-' . $t1[1] . '-' . $n1)) !== 'Sun') and ($this->cek_tgl($t1[0] . "-" . $t1[1] . "-" . $n1, $id_akun) == 0) and ($this->cek_libur($t1[0] . "-" . $t1[1] . "-" . $n1) == 0)) {
                if ($n == $t2[2]) { //generate query
                    $q .= "('" . randid() . "','$id_akun', '" . $t1[0] . "-" . $t1[1] . "-" . $n1 . "', '07:30', '18:00', 0, 'auto absen - " . $_SESSION['nama_user'] . "')";
                } else {
                    $q .= "('" . randid() . "','$id_akun', '" . $t1[0] . "-" . $t1[1] . "-" . $n1 . "', '07:30', '18:00', 0, 'auto absen - " . $_SESSION['nama_user'] . "'),";
                }
            }
        }

        return $q;
    }

    //generate query auto absen tanpa libur, !!! per bulan, jika ganti bulan, maka jalankan fungsi lagi secara manual !!!
    private function auto_absen2($tgl, $id_akun)
    {
        $tgl = explode(' - ', $tgl);
        $t1 = explode('-', $tgl[0]);
        $t2 = explode('-', $tgl[1]);
        $q = "INSERT INTO fai_absen(id_absen,id_user,tgl_absen,absen_masuk,absen_pulang,pending,catatan_pending)
                            VALUES ";
        for ($n = $t1[2]; $n <= $t2[2]; $n++) {
            if (strlen($n) == 1) {
                $n1 = '0' . $n;
            } else {
                $n1 = $n;
            }

            if ($this->cek_tgl($t1[0] . "-" . $t1[1] . "-" . $n1, $id_akun) == 0) {
                if ($n == $t2[2]) { //generate query
                    $q .= "('" . randid() . "','$id_akun', '" . $t1[0] . "-" . $t1[1] . "-" . $n1 . "', '07:30', '18:00', 0, 'auto absen - " . $_SESSION['nama_user'] . "')";
                } else {
                    $q .= "('" . randid() . "','$id_akun', '" . $t1[0] . "-" . $t1[1] . "-" . $n1 . "', '07:30', '18:00', 0, 'auto absen - " . $_SESSION['nama_user'] . "'),";
                }
            }
        }

        return $q;
    }

    private function auto_cuti($tgl, $id_akun)
    {
        $tgl = explode(' - ', $tgl);
        $t1 = explode('-', $tgl[0]);
        $t2 = explode('-', $tgl[1]);
        $q = "INSERT INTO fai_absen(id_absen,id_user,tgl_absen,absen_masuk,absen_pulang,pending,catatan_pending)
                            VALUES ";
        for ($n = $t1[2]; $n <= $t2[2]; $n++) {
            if (strlen($n) == 1) {
                $n1 = '0' . $n;
            } else {
                $n1 = $n;
            }

            if ((date('D', strtotime($t1[0] . '-' . $t1[1] . '-' . $n1)) !== 'Sun') and ($this->cek_tgl($t1[0] . "-" . $t1[1] . "-" . $n1, $id_akun) == 0) and ($this->cek_libur($t1[0] . "-" . $t1[1] . "-" . $n1) == 0)) {

                if ($n == $t2[2]) {
                    $q .= "('" . randid() . "','$id_akun', '" . $t1[0] . "-" . $t1[1] . "-" . $n1 . "', '07:30', '18:00', 4, 'auto cuti - " . $_SESSION['nama_user'] . "')";
                } else {
                    $q .= "('" . randid() . "','$id_akun', '" . $t1[0] . "-" . $t1[1] . "-" . $n1 . "', '07:30', '18:00', 4, 'auto cuti - " . $_SESSION['nama_user'] . "'),";
                }
            }
        }

        return $q;
    }

    private function absen_sakit($tgl, $id_akun)
    {
        $tgl = explode(' - ', $tgl);
        $t1 = explode('-', $tgl[0]);
        $t2 = explode('-', $tgl[1]);
        $q = "INSERT INTO fai_absen(id_absen,id_user,tgl_absen,absen_masuk,absen_pulang,pending,catatan_pending)
                            VALUES ";
        for ($n = $t1[2]; $n <= $t2[2]; $n++) {
            if (strlen($n) == 1) {
                $n1 = '0' . $n;
            } else {
                $n1 = $n;
            }

            if ($this->cek_tgl($t1[0] . "-" . $t1[1] . "-" . $n1, $id_akun) == 0) {
                //generate query
                if ($n == $t2[2]) { 
                    $q .= "('" . randid() . "','$id_akun', '" . $t1[0] . "-" . $t1[1] . "-" . $n1 . "', '07:30', '18:00', 6, 'absen sakit - " . $_SESSION['nama_user'] . "')";
                } else {
                    $q .= "('" . randid() . "','$id_akun', '" . $t1[0] . "-" . $t1[1] . "-" . $n1 . "', '07:30', '18:00', 6, 'absen sakit - " . $_SESSION['nama_user'] . "'),";
                }
            }
        }

        return $q;
    }

    private function absen_unpaid($tgl, $id_akun)
    {
        $tgl = explode(' - ', $tgl);
        $t1 = explode('-', $tgl[0]);
        $t2 = explode('-', $tgl[1]);
        $q = "INSERT INTO fai_absen(id_absen,id_user,tgl_absen,absen_masuk,absen_pulang,pending,catatan_pending)
                            VALUES ";
        for ($n = $t1[2]; $n <= $t2[2]; $n++) {
            if (strlen($n) == 1) {
                $n1 = '0' . $n;
            } else {
                $n1 = $n;
            }

            if ($this->cek_tgl($t1[0] . "-" . $t1[1] . "-" . $n1, $id_akun) == 0) {
                //generate query
                if ($n == $t2[2]) { 
                    $q .= "('" . randid() . "','$id_akun', '" . $t1[0] . "-" . $t1[1] . "-" . $n1 . "', '07:30', '18:00', 5, 'absen unpaid leave - " . $_SESSION['nama_user'] . "')";
                } else {
                    $q .= "('" . randid() . "','$id_akun', '" . $t1[0] . "-" . $t1[1] . "-" . $n1 . "', '07:30', '18:00', 5, 'absen unpaid leave - " . $_SESSION['nama_user'] . "'),";
                }
            }
        }

        return $q;
    }

    private function cek_tgl($tgl, $id_akun)
    {
        $this->db->where('tgl_absen', $tgl);
        $this->db->where('id_user', $id_akun);
        $n = $this->db->get('fai_absen')->num_rows();
        return $n;
    }

    private function cek_libur($tgl)
    {
        $this->db->where('tgl_libur', $tgl);
        //$this->db->where('id_user', $id_akun);
        $n = $this->db->get('fai_libur')->num_rows();
        return $n;
    }
}
